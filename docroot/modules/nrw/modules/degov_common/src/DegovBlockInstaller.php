<?php

namespace Drupal\degov_common;


use Drupal\config\Form\ConfigSync;
use Drupal\config\StorageReplaceDataWrapper;
use Drupal\Core\Config\ConfigException;
use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Config\ConfigImporter;
use Drupal\Core\Config\ConfigImporterException;
use Drupal\Core\Config\ConfigManagerInterface;
use Drupal\Core\Config\StorageComparer;
use Drupal\Core\Config\StorageInterface;
use Drupal\Core\Config\TypedConfigManagerInterface;
use Drupal\Core\Extension\ModuleHandlerInterface;
use Drupal\Core\Extension\ModuleInstallerInterface;
use Drupal\Core\Extension\ThemeHandlerInterface;
use Drupal\Core\Lock\LockBackendInterface;
use Drupal\Core\Logger\LoggerChannelInterface;
use Drupal\Core\StringTranslation\TranslationInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Yaml\Yaml;

/**
 * Class DegovBlockInstaller
 *
 * @package Drupal\degov_common
 */
class DegovBlockInstaller implements DegovBlockInstallerInterface {

  /**
   * The config storage.
   *
   * @var \Drupal\Core\Config\StorageInterface
   */
  protected $configStorage;

  /**
   * The module handler.
   *
   * @var \Drupal\Core\Extension\ModuleHandlerInterface
   */
  protected $moduleHandler;

  /**
   * The theme handler.
   *
   * @var \Drupal\Core\Extension\ThemeHandlerInterface
   */
  protected $themeHandler;

  /**
   * The event dispatcher.
   *
   * @var \Symfony\Component\EventDispatcher\EventDispatcherInterface
   */
  protected $eventDispatcher;

  /**
   * The configuration manager.
   *
   * @var \Drupal\Core\Config\ConfigManagerInterface;
   */
  protected $configManager;

  /**
   * The database lock object.
   *
   * @var \Drupal\Core\Lock\LockBackendInterface
   */
  protected $lock;

  /**
   * The typed config manager.
   *
   * @var \Drupal\Core\Config\TypedConfigManagerInterface
   */
  protected $typedConfigManager;

  /**
   * The module installer.
   *
   * @var \Drupal\Core\Extension\ModuleInstallerInterface
   */
  protected $moduleInstaller;

  /**
   * The string translation service.
   *
   * @var \Drupal\Core\StringTranslation\TranslationInterface
   */
  protected $stringTranslation;


  /**
   * Constructs a new ConfigRewriter.
   *
   * @param \Drupal\Core\Config\StorageInterface $config_storage
   * @param \Drupal\Core\Config\ConfigManagerInterface $configManager
   * @param \Symfony\Component\EventDispatcher\EventDispatcherInterface $eventDispatcher
   * @param \Drupal\Core\Extension\ModuleHandlerInterface $module_handler
   *   The module handler.
   * @param \Drupal\Core\Extension\ThemeHandlerInterface $theme_handler
   *   The theme handler.
   * @param \Drupal\Core\Lock\LockBackendInterface $lock
   * @param \Drupal\Core\Config\TypedConfigManagerInterface $typed_config
   * @param \Drupal\Core\Extension\ModuleInstallerInterface $moduleInstaller
   * @param \Drupal\Core\StringTranslation\TranslationInterface $string_translation
   */
  public function __construct(StorageInterface $config_storage, EventDispatcherInterface $eventDispatcher, ConfigManagerInterface $configManager, LockBackendInterface $lock, TypedConfigManagerInterface $typed_config, ModuleHandlerInterface $module_handler, ModuleInstallerInterface $moduleInstaller, ThemeHandlerInterface $theme_handler, TranslationInterface $string_translation) {
    $this->configStorage = $config_storage;
    $this->configManager = $configManager;
    $this->eventDispatcher = $eventDispatcher;
    $this->moduleHandler = $module_handler;
    $this->themeHandler = $theme_handler;
    $this->lock = $lock;
    $this->typedConfigManager = $typed_config;
    $this->moduleInstaller = $moduleInstaller;
    $this->stringTranslation = $string_translation;
  }

  /**
   * Install blocks.
   *
   * @param $module
   *   The name of a module (without the .module extension).
   */
  public function placeBlockConfig($module) {
    // Load the module extension.
    $extension = $this->moduleHandler->getModule($module);

    // Block configs are stored in 'modulename/config/block'.
    $dir_base = $extension->getPath() . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'block';
    $languages = \Drupal::languageManager()->getLanguages();

    // Rewrite configuration for the default language.
    $this->installBlockConfig($extension, $dir_base);

    // Rewrite configuration for each enabled language.
    foreach ($languages as $langcode => $language) {
      $language_dir = $dir_base . DIRECTORY_SEPARATOR . 'language' . DIRECTORY_SEPARATOR . $langcode;
      $this->installBlockConfig($extension, $language_dir, $langcode);
    }
  }

  /**
   * Finds files in a given directory and uses them to rewrite active config.
   *
   * @param \Drupal\Core\Extension\Extension $extension
   *   The extension that contains the config rewrites.
   * @param string $config_dir
   *   The directory that contains config rewrites.
   * @param string $langcode
   *   (Optional) The langcode that this configuration is for, if applicable.
   */
  protected function installBlockConfig($extension, $config_dir, $langcode = NULL) {
    if ($langcode) {
      return;
    }
    $source_storage = new StorageReplaceDataWrapper($this->configStorage);
    // Scan the rewrite directory for rewrites.
    if (file_exists($config_dir) && $files = $this->fileScanDirectory($config_dir, '/^.*\.yml$/i', ['recurse' => FALSE])) {
      // Loop through all files in block directory.
      foreach ($files as $file) {
        // Parse the rewrites and retrieve the original config.
        $block = Yaml::parse(file_get_contents($config_dir . DIRECTORY_SEPARATOR . $file->name . '.yml'));
        // Check if the theme from the configuration exists.
        if (!$this->themeHandler->themeExists($block['theme'])) {
          // If not, set the theme to currently active.
          $currentActiveThemeName = $this->themeHandler->getDefault();
          $block['theme'] = $currentActiveThemeName;
          $block['dependencies']['theme'] = [$currentActiveThemeName];
        }
        // Get the list of all the regions provided from the theme.
        $regions = system_region_list($block['theme']);
        if (empty($regions[$block['region']])) {
          if (!empty($regions['content'])) {
            $block['region'] = 'content';
          } else {
            $region_ids = array_keys($regions);
            $block['region'] = $region_ids[0];
          }
        }
        // Try to set new data to active configuration.
        $source_storage->replaceData($file->name, $block);
      }
      // Initialize the comparer.
      $storage_comparer = new StorageComparer(
        $source_storage,
        $this->configStorage,
        $this->configManager
      );
      // Check if there are any changes.
      if (!$storage_comparer->createChangelist()->hasChanges()) {
        return;
      }
      // Initialize Config Importer.
      $config_importer = new ConfigImporter(
        $storage_comparer,
        $this->eventDispatcher,
        $this->configManager,
        $this->lock,
        $this->typedConfigManager,
        $this->moduleHandler,
        $this->moduleInstaller,
        $this->themeHandler,
        $this->stringTranslation
      );
      // Validate the new configuration.
      try {
        $config_importer->validate();
      }
      catch (ConfigImporterException $e) {
        $reasons = implode("\n", $config_importer->getErrors());
        drupal_set_message(t('The configuration cannot be imported because it failed validation for the following reasons: @reasons', ['@reasons' => $reasons]));
      }
      // Import configuration.
      $this->configImport($config_importer);
    }
  }

  /**
   * Imports all the changes for the block configuration with batch.
   *
   * @param \Drupal\Core\Config\ConfigImporter $config_importer
   */
  protected function configImport($config_importer) {
    if ($config_importer->alreadyImporting()) {
      drupal_set_message(t('Another request may be importing configuration already.'), 'error');
    }
    else {
      try {
        // This is the contents of \Drupal\Core\Config\ConfigImporter::import.
        // Copied here so we can log progress.
        if ($config_importer->hasUnprocessedConfigurationChanges()) {
          $sync_steps = $config_importer->initialize();
          foreach ($sync_steps as $step) {
            $context = array();
            do {
              $config_importer->doSyncStep($step, $context);
              if (isset($context['message'])) {
                drupal_set_message(str_replace('Synchronizing', 'Synchronized', (string)$context['message']), 'info');
              }
            } while ($context['finished'] < 1);
          }
        }
        if ($config_importer->getErrors()) {
          throw new ConfigException('Errors occurred during import');
        }
        else {
          drupal_set_message('The configuration was imported successfully.', 'success');
        }
      }
      catch (ConfigException $e) {
        // Return a negative result for UI purposes. We do not differentiate
        // between an actual synchronization error and a failed lock, because
        // concurrent synchronizations are an edge-case happening only when
        // multiple developers or site builders attempt to do it without
        // coordinating.
        $message = 'The import failed due for the following reasons:' . "\n";
        $message .= implode("\n", $config_importer->getErrors());

        watchdog_exception('config_import', $e);
        drupal_set_message($message, 'error');
      }
    }
  }

  /**
   * Wraps file_scan_directory().
   *
   * @param $dir
   *   The base directory or URI to scan, without trailing slash.
   * @param $mask
   *   The preg_match() regular expression for files to be included.
   * @param $options
   *   An associative array of additional options.
   *
   * @return array
   *   An associative array (keyed on the chosen key) of objects with 'uri',
   *   'filename', and 'name' properties corresponding to the matched files.
   */
  protected function fileScanDirectory($dir, $mask, $options = array()) {
    return file_scan_directory($dir, $mask, $options);
  }
}