<?php

namespace Drupal\degov_node_event\Plugin\views\area;


use Drupal\calendar\CalendarHelper;
use Drupal\calendar\Plugin\views\area\CalendarHeader;

/**
 * Views area Calendar Header area.
 *
 * @ingroup views_area_handlers
 *
 * @ViewsArea("degov_calendar_widget_header")
 */
class CalendarWidgetHeader extends CalendarHeader {

  /**
   * Render a text area with \Drupal\Component\Utility\Xss::filterAdmin().
   */
  public function renderTextField($value) {
    if ($value) {
      return $this->sanitizeValue($this->tokenizeValue($value), 'xss_admin');
    }
    /** @var \Drupal\calendar\DateArgumentWrapper $argument */
    $argument = CalendarHelper::getDateArgumentHandler($this->view);
    return $argument->format('M Y');
  }
}