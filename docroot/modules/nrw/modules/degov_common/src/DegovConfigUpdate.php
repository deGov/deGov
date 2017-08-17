<?php

namespace Drupal\degov_common;

use Drupal\config\StorageReplaceDataWrapper;
use Drupal\Core\Config\ConfigImporter;
use Drupal\Core\Config\FileStorage;
use Drupal\Core\Config\StorageComparer;
use Drupal\Core\Config\StorageInterface;

/**
 * Class DegovOverride
 *
 * @package Drupal\degov_common
 */
class DegovConfigUpdate extends DegovConfigManagerBase {

  /**
   * @param $module
   * @param string $config_type
   *
   * @return array|null|void
   */
  public function configPartialImport($module, $config_type = 'install') {
    $source_dir = drupal_get_path('module', $module) . '/config/' . $config_type;
    $this->checkConfigurationChanges($source_dir);
  }

  /**
   * @param $source_dir
   *
   * @return array|null|void
   */
  public function checkConfigurationChanges($source_dir) {
    $source_storage = new FileStorage($source_dir);

    // Determine $source_storage in partial and non-partial cases.
    /** @var \Drupal\Core\Config\StorageInterface $active_storage */
    $active_storage = $this->activeStorage;

    $replacement_storage = new StorageReplaceDataWrapper($active_storage);
    foreach ($source_storage->listAll() as $name) {
      $data = $source_storage->read($name);
      $replacement_storage->replaceData($name, $data);
    }
    $source_storage = $replacement_storage;

    /** @var \Drupal\Core\Config\ConfigManagerInterface $config_manager */
    $config_manager = $this->configManager;
    $storage_comparer = new StorageComparer($source_storage, $active_storage, $config_manager);

    if (!$storage_comparer->createChangelist()->hasChanges()) {
      return drupal_set_message(t('There are no changes to import.'), 'status');
    }

    $change_list = [];
    foreach ($storage_comparer->getAllCollectionNames() as $collection) {
      $change_list[$collection] = $storage_comparer->getChangelist(NULL, $collection);
    }

    foreach ($change_list as $collection) {
      if (empty($collection)) {
        continue;
      }
      foreach ($collection as $operation => $list) {
        if (empty($list)) {
          continue 1;
        }
        $config_list = implode("\n", $list);
        drupal_set_message(t('The following configurations will be @operation: @list', [
          '@operation' => $operation . 'd',
          '@list' => $config_list,
        ]));
      }
    }
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
    $this->configImport($config_importer);
  }

  /**
   * Check optional directory for configuration changes.
   *
   * @param $source_dir
   */
  public function checkOptional($source_dir) {
    $optional_install_path = $source_dir;
    if (is_dir($optional_install_path)) {
      // Install any optional config the module provides.
      $storage = new FileStorage($optional_install_path, StorageInterface::DEFAULT_COLLECTION);
      \Drupal::service('config.installer')->installOptionalConfig($storage, '');
    }
  }

}
