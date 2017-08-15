<?php

namespace Drupal\degov_paragraph_block_reference\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FormatterBase;


/**
 * Field formatter for Block Selecct Field.
 *
 * @FieldFormatter(
 *   id = "degov_block_render",
 *   label = @Translation("deGov Block Display"),
 *   field_types = {"list_string"}
 * )
 */
class BlockRender extends FormatterBase {

  /**
   * Builds a renderable array for a field value.
   *
   * @param \Drupal\Core\Field\FieldItemListInterface $items
   *   The field values to be rendered.
   * @param string $langcode
   *   The language that should be used to render the field.
   *
   * @return array
   *   A renderable array for $items, as an array of child elements keyed by
   *   consecutive numeric indexes starting from 0.
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $elements = [];
    $block_manager = \Drupal::service('plugin.manager.block');
    foreach ($items as $delta => $item) {
      $block_name = $item->getValue()['value'];
      $plugin_block = $block_manager->createInstance($block_name, []);
      $builtBlock = $plugin_block->build();
      $elements[$delta] = $builtBlock;
    }
    return $elements;
  }
}