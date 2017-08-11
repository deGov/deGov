<?php

namespace Drupal\degov_common;

/**
 * Interface DegovBlockInstallerInterface
 *
 * @package Drupal\degov_common
 */
interface DegovBlockInstallerInterface {

  /**
   * Extension sub-directory containing block configuration for installation.
   */
  const BLOCK_CONFIG_DIRECTORY = 'config/block';

  /**
   * Install blocks.
   *
   * @param $module
   *   The name of a module (without the .module extension).
   */
  public function placeBlockConfig($module);

}