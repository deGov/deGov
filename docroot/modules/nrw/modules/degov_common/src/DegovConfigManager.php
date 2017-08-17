<?php
/**
 * Created by PhpStorm.
 * User: onexinternet
 * Date: 15.08.17
 * Time: 16:09
 */

namespace Drupal\degov_common;


interface DegovConfigManager {

  /**
   * Imports all the changes for the block configuration with batch.
   *
   * @param \Drupal\Core\Config\ConfigImporter $config_importer
   */
  public function configImport($config_importer);


}