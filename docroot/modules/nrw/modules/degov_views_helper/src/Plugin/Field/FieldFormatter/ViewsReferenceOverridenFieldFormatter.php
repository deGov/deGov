<?php

namespace Drupal\degov_views_helper\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\views\Views;
use Drupal\viewsreference\Plugin\Field\FieldFormatter\ViewsReferenceFieldFormatter;

/**
 * Field formatter for Viewsreference Field.
 *
 * @FieldFormatter(
 *   id = "degov_viewsreference_formatter",
 *   label = @Translation("Views Reference with extra options"),
 *   field_types = {"viewsreference"}
 * )
 */
class ViewsReferenceOverridenFieldFormatter extends ViewsReferenceFieldFormatter {

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $elements = [];

    foreach ($items as $delta => $item) {
      $view_name = $item->getValue()['target_id'];
      $display_id = $item->getValue()['display_id'];
      $argument = $item->getValue()['argument'];
      $title = $item->getValue()['title'];

      $extra_data = unserialize($item->getValue()['data']);

      $view = Views::getView($view_name);
      // Someone may have deleted the View.
      if (!is_object($view)) {
        continue;
      }
      $arguments = [$argument];
      if (preg_match('/\//', $argument)) {
        $arguments = explode('/', $argument);
      }

      $node = \Drupal::routeMatch()->getParameter('node');
      $token_service = \Drupal::token();
      if (is_array($arguments)) {
        foreach ($arguments as $index => $argument) {
          if (!empty($token_service->scan($argument))) {
            $arguments[$index] = $token_service->replace($argument, ['node' => $node]);
          }
        }
      }

      $view->setDisplay($display_id);
      $view->setArguments($arguments);
      if (!empty($extra_data['page_limit']) && is_numeric($extra_data['page_limit'])) {
        $limit = (int) $extra_data['page_limit'];
        $view->setItemsPerPage($limit);
      }

      $view->build($display_id);
      $view->preExecute();
      $view->execute($display_id);
      if (!empty($extra_data['view_mode'])) {
        if (!$view->rowPlugin->usesFields() && !empty($view->rowPlugin->options['view_mode'])) {
          $view->rowPlugin->options['view_mode'] = $extra_data['view_mode'];
        }
      }
      if (!empty($view->result) || !empty($view->empty)) {
        if ($title) {
          $title = $view->getTitle();
          $title_render_array = [
            '#theme' => 'viewsreference__view_title',
            '#title' => $this->t('@title', ['@title' => $title]),
          ];
        }

        if ($this->getSetting('plugin_types')) {
          if ($title) {
            $elements[$delta]['title'] = $title_render_array;
          }
        }

        $elements[$delta]['contents'] = $view->buildRenderable($display_id);
      }
    }

    return $elements;
  }

}
