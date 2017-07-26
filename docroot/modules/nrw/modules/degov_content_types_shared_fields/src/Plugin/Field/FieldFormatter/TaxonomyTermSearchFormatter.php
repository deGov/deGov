<?php

namespace Drupal\degov_content_types_shared_fields\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FieldDefinitionInterface;
use Drupal\Core\Field\Plugin\Field\FieldFormatter\EntityReferenceFormatterBase;
use Drupal\Core\Link;
use Drupal\Core\Url;

/**
 * Plugin implementation of the 'Taxonomy_term_search' formatter.
 *
 * This formatter create taxonomy term links to the default search page
 * with the term pre-selected in a facet block if a facet for the term
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
class TaxonomyTermSearchFormatter extends EntityReferenceFormatterBase {

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $elements = [];

    foreach ($this->getEntitiesToView($items, $langcode) as $delta => $entity) {
      $options = ['query' => ['f' => [$entity->bundle() . ':' . $entity->id()]]];
      $url = Url::fromRoute('view.search_content.page_1', [], $options);

      $elements[$delta] = [
        'link' => Link::fromTextAndUrl($entity->label(), $url)->toRenderable(),
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
  public static function isApplicable(FieldDefinitionInterface $field_definition) {
    return $field_definition->getFieldStorageDefinition()->getSetting('target_type') === 'taxonomy_term';
  }

}
