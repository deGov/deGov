<?php

namespace Drupal\degov_content_types_shared_fields\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FieldDefinitionInterface;
use Drupal\Core\Field\Plugin\Field\FieldFormatter\EntityReferenceFormatterBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Link;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\Routing\RouteProviderInterface;
use Drupal\Core\Url;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Routing\Exception\RouteNotFoundException;

/**
 * Plugin implementation of the 'Taxonomy_term_search' formatter.
 *
 * This formatter creates taxonomy term links to search pages with
 * the term pre-selected in a facet block if a facet for the term
 * exists and the url alias for the facet is identical to the term's
 * bundle machine name. See the tags facet/bundle for an example.
 *
 * @FieldFormatter(
 *   id = "taxonomy_term_search",
 *   label = @Translation("Link to search page"),
 *   description = @Translation("A facet with the term's bundle machine name as the facet url alias should exist."),
 *   field_types = {
 *     "entity_reference"
 *   }
 * )
 */
class TaxonomyTermSearchFormatter extends EntityReferenceFormatterBase implements ContainerFactoryPluginInterface {

  /**
   * The route provider service.
   *
   * @var \Drupal\Core\Routing\RouteProviderInterface
   */
  protected $routeProvider;

  /**
   * {@inheritdoc}
   */
  public function __construct($plugin_id, $plugin_definition, FieldDefinitionInterface $field_definition, array $settings, $label, $view_mode, array $third_party_settings, RouteProviderInterface $route_provider) {
    parent::__construct($plugin_id, $plugin_definition, $field_definition, $settings, $label, $view_mode, $third_party_settings);
    $this->routeProvider = $route_provider;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $plugin_id,
      $plugin_definition,
      $configuration['field_definition'],
      $configuration['settings'],
      $configuration['label'],
      $configuration['view_mode'],
      $configuration['third_party_settings'],
      $container->get('router.route_provider')
    );
  }

  /**
   * {@inheritdoc}
   */
  public static function defaultSettings() {
    return [
      'route_name' => '',
    ] + parent::defaultSettings();
  }

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $elements = [];

    if ($route_name = $this->getSetting('route_name')) {
      try {
        $this->routeProvider->getRouteByName($route_name);
      }
      catch (RouteNotFoundException $e) {
        $route_name = NULL;
      }
    }

    foreach ($this->getEntitiesToView($items, $langcode) as $delta => $entity) {
      if ($route_name) {
        $options = ['query' => ['f' => [$entity->bundle() . ':' . $entity->id()]]];
        $url = Url::fromRoute($route_name, [], $options);
        $content = Link::fromTextAndUrl($entity->label(), $url)->toRenderable();
      }
      else {
        $content = [
          '#plain_text' => $entity->label(),
        ];
      }

      $elements[$delta] = [
        'content' => $content,
        '#cache' => [
          'tags' => $entity->getCacheTags(),
        ],
      ];
    }

    return $elements;
  }

  /**
   * {@inheritdoc}
   */
  public function settingsForm(array $form, FormStateInterface $form_state) {
    $form = parent::settingsForm($form, $form_state);

    $form['route_name'] = [
      '#title' => $this->t('Search route name'),
      '#description' => $this->t('The route name of the search page the term should link to, e.g. %route_name', ['%route_name' => 'view.search_content.page_1']),
      '#type' => 'machine_name',
      '#default_value' => $this->getSetting('route_name'),
      '#required' => FALSE,
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function settingsSummary() {
    $summary = parent::settingsSummary();

    if ($route_name = $this->getSetting('route_name')) {
      $summary[] = $this->t('Search route name: %route_name', ['%route_name' => $route_name]);
    }

    return $summary;
  }

  /**
   * {@inheritdoc}
   */
  public static function isApplicable(FieldDefinitionInterface $field_definition) {
    return $field_definition->getFieldStorageDefinition()->getSetting('target_type') === 'taxonomy_term';
  }

}
