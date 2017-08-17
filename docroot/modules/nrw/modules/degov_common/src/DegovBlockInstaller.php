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
class DegovBlockInstaller extends DegovConfigManagerBase implements DegovBlockInstallerInterface {

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
    // Rewrite configuration for the default language.
    $this->installBlockConfig($dir_base);
  }

  /**
   * Finds files in a given directory and uses them to rewrite active config.
   *
   * @param string $config_dir
   *   The directory that contains config rewrites.
   */
  public function installBlockConfig($config_dir) {
    $source_storage = new StorageReplaceDataWrapper($this->activeStorage);
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
          }
          else {
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
        $this->activeStorage,
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
      } catch (ConfigImporterException $e) {
        $reasons = implode("\n", $config_importer->getErrors());
        drupal_set_message(t('The configuration cannot be imported because it failed validation for the following reasons: @reasons', ['@reasons' => $reasons]));
      }
      // Import configuration.
      $this->configImport($config_importer);
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
  protected function fileScanDirectory($dir, $mask, $options = []) {
    return file_scan_directory($dir, $mask, $options);
  }
}