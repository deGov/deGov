<?php

namespace Drupal\degov_common;


use Drupal\config_rewrite\ConfigRewriter;

/**
 * Class DegovModuleUpdater
 *
 * @package Drupal\degov_common
 */
class DegovModuleUpdater extends ConfigRewriter {

  /**
   * @param $version
   */
  public function applyUpdates($module, $version) {
    $source_dir = drupal_get_path('module', $module) . '/config/update_' . $version;
    if (file_exists($source_dir)) {
      // Are there any new installs?
      $install_dir = $source_dir . '/install';
      if (file_exists($install_dir)) {
        \Drupal::service('degov_config.updater')->checkConfigurationChanges($install_dir);
      }
      // Are there any optional?
      $optional_dir = $source_dir . '/optional';
      if (file_exists($optional_dir)) {
        \Drupal::service('degov_config.updater')->checkOptional($optional_dir);
      }
      // Are there any blocks?
      $blocks_dir = $source_dir .'/block';
      if (file_exists($blocks_dir)) {
        \Drupal::service('degov_config.block_installer')->installBlockConfig($blocks_dir);
      }
      // Are there any rewrites?
      $updates_dir = $source_dir .'/rewrite';
      if (file_exists($updates_dir)) {
        $extension = $this->moduleHandler->getModule($module);
        $this->rewriteDirectoryConfig($extension, $updates_dir);
      }
    }
  }

}