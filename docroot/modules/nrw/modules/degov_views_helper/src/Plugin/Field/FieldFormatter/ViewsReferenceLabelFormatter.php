<?php

namespace Drupal\degov_views_helper\Plugin\Field\FieldFormatter;

use Drupal\views\Views;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FormatterBase;

/**
 * Field formatter for Viewsreference Field.
 *
 * @FieldFormatter(
 *   id = "degov_viewsreference_label",
 *   label = @Translation("Views Label"),
 *   field_types = {"viewsreference"}
 * )
 */
class ViewsReferenceLabelFormatter extends FormatterBase {

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
    foreach ($items as $delta => $item) {
      $view_name = $item->getValue()['target_id'];
      $view = Views::getView($view_name);
      // Someone may have deleted the View.
      if (!is_object($view)) {
        continue;
      }
      $title = $view->getTitle();
      $title_render_array = array(
        '#theme' => 'viewsreference__view_title',
        '#title' => $this->t($title),
      );
      $elements[$delta]['title'] = $title_render_array;
    }
    return $elements;
  }
}