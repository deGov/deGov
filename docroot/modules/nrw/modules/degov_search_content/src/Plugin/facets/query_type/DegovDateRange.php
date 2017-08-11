<?php

namespace Drupal\degov_search_content\Plugin\facets\query_type;

use Drupal\Core\Datetime\DrupalDateTime;
use Drupal\facets\Plugin\facets\query_type\SearchApiDate;

/**
 *
 * @FacetsQueryType(
 *   id = "search_api_degov_date_range",
 *   label = @Translation("Date Range"),
 * )
 */
class DegovDateRange extends SearchApiDate {

  /**
   * {@inheritdoc}
   */
  public function execute() {
    $query = $this->query;

    // Alter the query here.
    if (!empty($query)) {
      $options = &$query->getOptions();

      $operator = $this->facet->getQueryOperator();
      $field_identifier = $this->facet->getFieldIdentifier();
      $exclude = $this->facet->getExclude();
      $options['search_api_facets'][$field_identifier] = [
        'field' => $field_identifier,
        'limit' => $this->facet->getHardLimit(),
        'operator' => $this->facet->getQueryOperator(),
        'min_count' => $this->facet->getMinCount(),
        'missing' => FALSE,
      ];

      // Add the filter to the query if there are active values.
      $active_items = $this->facet->getActiveItems();
      $filter = $query->createConditionGroup($operator, ['facet:' . $field_identifier]);
      if (count($active_items)) {
        foreach ($active_items as $value) {
          $range = $this->calculateRange($value);

          $item_filter = $query->createConditionGroup('AND', ['facet:' . $field_identifier]);
          if ($range['start']) {
            $item_filter->addCondition($this->facet->getFieldIdentifier(), $range['start'], $exclude ? '<' : '>=');
          }
          if ($range['stop']) {
            $item_filter->addCondition($this->facet->getFieldIdentifier(), $range['stop'], $exclude ? '>' : '<=');
          }

          $filter->addConditionGroup($item_filter);
        }
        $query->addConditionGroup($filter);
      }
    }
  }

  /**
   * Returns a start and end date based on a unix timestamp.
   *
   * This method returns a start and end date with an absolute interval, based
   * on the granularity set in the widget.
   *
   * @param int $value
   *   Unix timestamp.
   *
   * @return array
   *   An array with a start and end date as unix timestamps.
   *
   * @throws \Exception
   *   Thrown when creating a date fails.
   */
  protected function calculateRangeAbsolute($value) {
    $dateTime = new DrupalDateTime();

    $value = trim($value, '[]');
    $value = explode(' TO ', $value);
    if (empty($value) || count($value) != 2) {
      return;
    }
    // Check if the date in query string is valid.
    $isValidStartDate = strtotime($value[0]);
    $isValidEndDate = strtotime($value[1]);

    switch ($this->getGranularity()) {
      case static::FACETAPI_DATE_YEAR:
        if ($isValidStartDate) {
          $startDate = $dateTime::createFromFormat('Y-m-d\TH:i:s', $value[0] . '-01-01T00:00:00');
        }
        if ($isValidEndDate) {
          $stopDate = $dateTime::createFromFormat('Y-m-d\TH:i:s', $value[1] . '-12-31T23:59:59');
        }
        break;

      case static::FACETAPI_DATE_MONTH:
        if ($isValidStartDate) {
          $startDate = $dateTime::createFromFormat('Y-m-d\TH:i:s', $value[0] . '-01T00:00:00');
        }
        if ($isValidEndDate) {
          $stopDate = $dateTime::createFromFormat('Y-m-d\TH:i:s', $value[1] . '-' . $startDate->format('t') . 'T23:59:59');
        }
        break;

      case static::FACETAPI_DATE_DAY:
        if ($isValidStartDate) {
          $startDate = $dateTime::createFromFormat('Y-m-d\TH:i:s', $value[0] . 'T00:00:00');
        }
        if ($isValidEndDate) {
          $stopDate = $dateTime::createFromFormat('Y-m-d\TH:i:s', $value[1] . 'T23:59:59');
        }
        break;

      case static::FACETAPI_DATE_HOUR:
        if ($isValidStartDate) {
          $startDate = $dateTime::createFromFormat('Y-m-d\TH:i:s', $value[0] . '00:00');
        }
        if ($isValidEndDate) {
          $stopDate = $dateTime::createFromFormat('Y-m-d\TH:i:s', $value[1] . '59:59');
        }
        break;

      case static::FACETAPI_DATE_MINUTE:
        if ($isValidStartDate) {
          $startDate = $dateTime::createFromFormat('Y-m-d\TH:i:s', $value[0] . ':00');
        }
        if ($isValidEndDate) {
          $stopDate = $dateTime::createFromFormat('Y-m-d\TH:i:s', $value[1] . ':59');
        }
        break;

      case static::FACETAPI_DATE_SECOND:
        if ($isValidStartDate) {
          $startDate = $dateTime::createFromFormat('Y-m-d\TH:i:s', $value[0]);
        }
        if ($isValidEndDate) {
          $stopDate = $dateTime::createFromFormat('Y-m-d\TH:i:s', $value[1]);
        }
        break;

    }

    return [
      'start' => $startDate ? $startDate->format('U') : FALSE,
      'stop' => $stopDate ? $stopDate->format('U') : FALSE,
    ];
  }

}