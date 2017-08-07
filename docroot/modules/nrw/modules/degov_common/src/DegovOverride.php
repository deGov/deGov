<?php

namespace Drupal\degov_common;

/**
 * Class DegovOverride
 *
 * @package Drupal\degov_common
 */
class DegovOverride {

  /**
   * Overrides the class implementation specified in a plugin definition.
   *
   * The replacement class is only used if its immediate parent is the class
   * specified by the plugin definition.
   *
   * @param array $plugin_definition
   *   The plugin definition.
   * @param string $replacement_class
   *   The class to use.
   */
  public static function pluginClass(array &$plugin_definition, $replacement_class) {
    if (get_parent_class($replacement_class) == $plugin_definition['class']) {
      $plugin_definition['class'] = $replacement_class;
    }
  }

}
