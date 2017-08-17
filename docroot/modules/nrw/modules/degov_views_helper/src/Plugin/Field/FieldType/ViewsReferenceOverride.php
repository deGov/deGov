<?php

namespace Drupal\degov_views_helper\Plugin\Field\FieldType;

use Drupal\viewsreference\Plugin\Field\FieldType\ViewsReferenceItem;

/**
 * Class ViewsReferenceOverride.
 *
 * @package Drupal\degov_views_helper\Plugin\Field\FieldType
 */
class ViewsReferenceOverride extends ViewsReferenceItem {

  /**
   * {@inheritdoc}
   */
  public function setValue($values, $notify = TRUE) {
    // Select widget has extra layer of items.
    $additional_settings = [];
    if (isset($values['page_limit'])) {
      $additional_settings['page_limit'] = $values['page_limit'];
    }
    if (isset($values['view_mode'])) {
      $additional_settings['view_mode'] = $values['view_mode'];
    }
    if (!empty($additional_settings)) {
      $values['data'] = serialize($additional_settings);
    }
    if (is_array($values['argument'])) {
      $values['argument'] = implode('/', $values['argument']);
    }
    parent::setValue($values, FALSE);
  }

}
