<?php

namespace Drupal\degov_search_content\Plugin\facets\widget;

use Drupal\Core\Form\FormStateInterface;
use Drupal\facets\FacetInterface;
use Drupal\facets\Plugin\facets\query_type\SearchApiDate;
use Drupal\facets\Result\Result;
use Drupal\facets\Widget\WidgetPluginBase;
use Drupal\Core\Datetime\DrupalDateTime;

/**
 * The date range picker widget.
 *
 * @FacetsWidget(
 *   id = "degov_date_range_picker",
 *   label = @Translation("Date Range Picker"),
 *   description = @Translation("A configurable widget that shows a date range picker."),
 * )
 */
class DateRangePicker extends WidgetPluginBase {

  /**
   * {@inheritdoc}
   */
  public function build(FacetInterface $facet) {
    $this->facet = $facet;
    // Try to load some results.
    $items = array_map(function (Result $result) {
      if (empty($result->getUrl())) {
        return $this->buildResultItem($result);
      }
      else {
        return $this->buildListItems($result);
      }
    }, $facet->getResults());

    $startDate = '';
    $endDate = '';
    // Get the active items if present to get start and end date of the filter.
    $activeItems = $this->facet->getActiveItems();
    if ($activeItems) {
      foreach ($activeItems as $value) {
        $value = trim($value, '[]');
        $value = explode(' TO ', $value);
        if (count($value) != 2) {
          continue;
        }
        $startDate = $value[0];
        $endDate = $value[1];
      }
    }

    // Get the active url of the current search.
    $facetUrl = '';
    if (!empty($items)) {
      foreach ($items as $item) {
        /** @var \Drupal\Core\Url $url */
        $url = $item['#url'];
        $options = $url->getOptions();
        foreach ($options['query']['f'] as $key => $option) {
          if (strpos($option, $this->facet->getUrlAlias()) !== FALSE) {
            unset($options['query']['f'][$key]);
          }
        }
        $options['query']['f'][] = $this->facet->getUrlAlias().':[date_min TO date_max]';
        $url->setOptions($options);
        $facetUrl = $url->toString();
      }
    }

    $timezone = \Drupal::config('system.date')->get('timezone.default');
    // Prepare the render array for date filters.
    $form = [];
    $form['date_filter_wrapper'] = [
      '#type' => 'details',
      '#title' => $this->t('Date filters'),
      '#open' => TRUE,
      '#attributes' => ['class' => ['date-filter-wrapper']],
    ];
    $form['date_filter_wrapper']['date_from'] = [
      '#type' => 'date',
      '#date_date_format' => 'Y-m-d',
      '#date_date_element' => 'date',
      '#date_time_element' => 'none',
      '#date_increment' => 1,
      '#date_time_format' => '',
      '#date_timezone' => $timezone,
      '#date_year_range' => '-10:+3',
      '#default_value' => (!empty($startDate)) ? DrupalDateTime::createFromTimestamp(strtotime($startDate)) : '',
      // Set the attributes to get the datepicker.
      '#attributes' => ['data-drupal-date-format' => 'Y-m-d', 'class' => ['date-from']],
    ];
    $form['date_filter_wrapper']['date_to'] = [
      '#type' => 'date',
      '#date_date_format' => 'Y-m-d',
      '#date_date_element' => 'date',
      '#date_time_element' => 'none',
      '#date_increment' => 1,
      '#date_time_format' => '',
      '#date_timezone' => $timezone,
      '#date_year_range' => '-10:+3',
      '#default_value' => (!empty($endDate)) ? DrupalDateTime::createFromTimestamp(strtotime($endDate)) : '',
      // Set the attributes to get the datepicker.
      '#attributes' => ['data-drupal-date-format' => 'Y-m-d', 'class' => ['date-to']],
    ];
    // Attach the jquery datepicker library.
    $form['#attached']['library'][] = 'core/drupal.date';
    // Add the settings to JS for facet to properly functioning.
    $form['#attached']['drupalSettings']['dateFilter'] = [
      'urlAlias' => $this->facet->getUrlAlias(),
      'facetUrl' => $facetUrl,
      'min' => $startDate,
      'max' => $endDate,
    ];
    $form['#attached']['library'][] = 'degov_search_content/facet.date_range';

    $form['date_filter_wrapper']['actions']['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Filter'),
      '#attributes' => ['class' => ['date-filter']],
    ];

    return $form;
  }

  /**
   * Human readable array of granularity options.
   *
   * @return array
   *   An array of granularity options.
   */
  private function granularityOptions() {
    return [
      SearchApiDate::FACETAPI_DATE_YEAR => $this->t('Year'),
      SearchApiDate::FACETAPI_DATE_MONTH => $this->t('Month'),
      SearchApiDate::FACETAPI_DATE_DAY => $this->t('Day'),
      SearchApiDate::FACETAPI_DATE_HOUR => $this->t('Hour'),
      SearchApiDate::FACETAPI_DATE_MINUTE => $this->t('Minute'),
      SearchApiDate::FACETAPI_DATE_SECOND => $this->t('Second'),
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration() {
    return [
        'display_relative' => FALSE,
        'granularity' => SearchApiDate::FACETAPI_DATE_MONTH,
        'date_display' => '',
        'relative_granularity' => 1,
        'relative_text' => TRUE,
      ] + parent::defaultConfiguration();
  }

  /**
   * {@inheritdoc}
   */
  public function buildConfigurationForm(array $form, FormStateInterface $form_state, FacetInterface $facet) {
    $configuration = $this->getConfiguration();

    $form += parent::buildConfigurationForm($form, $form_state, $facet);

    $form['display_relative'] = [
      '#type' => 'radios',
      '#title' => $this->t('Date display'),
      '#default_value' => $configuration['display_relative'],
      '#options' => [
        FALSE => $this->t('Actual date with granularity'),
        TRUE => $this->t('Relative date'),
      ],
    ];

    $form['granularity'] = [
      '#type' => 'radios',
      '#title' => $this->t('Granularity'),
      '#default_value' => $configuration['granularity'],
      '#options' => $this->granularityOptions(),
    ];
    $form['date_display'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Date format'),
      '#default_value' => $configuration['date_display'],
      '#description' => $this->t('Override default date format used for the displayed filter format. See the <a href="http://php.net/manual/function.date.php">PHP manual</a> for available options.'),
      '#states' => [
        'visible' => [':input[name="widget_config[display_relative]"]' => ['value' => 0]],
      ],
    ];

    return $form;
  }


  /**
   * {@inheritdoc}
   */
  public function getQueryType(array $query_types) {
    return $query_types['degov_date_range'];
  }

}