<?php

namespace Drupal\degov_content_types_shared_fields\Twig\Extension;

/**
 * Provides field value filters for Twig templates.
 */
class FieldQuickEditAttributesExtension extends \Twig_Extension {

  /**
   * {@inheritdoc}
   */
  public function getFilters() {
    return array(
      new \Twig_SimpleFilter('quickedit_attr', [$this, 'getQuickEdit']),
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getName() {
    return 'twig_field_quickedit_attributes';
  }


  /**
   * Twig filter callback: Only return a field's attributes for quick edit.
   *
   * @param $build
   *   Render array of a field.
   *
   * @return array
   *   Array of render array(s) of field value(s). If $build is not the render
   *   array of a field, NULL is returned.
   */
  public function getQuickEdit($build) {

    if (!$this->isFieldRenderArray($build)) {
      return NULL;
    }

    if (!\Drupal::moduleHandler()->moduleExists('quickedit')) {
      return NULL;
    }

    if (!\Drupal::currentUser()->hasPermission('access in-place editing')) {
      return;
    }

    $element = $build['element'];
    /** @var $entity \Drupal\Core\Entity\EntityInterface */
    $entity = $build['#object'];

    // Quick Edit module only supports view modes, not dynamically defined
    // "display options" (which \Drupal\Core\Field\FieldItemListInterface::view()
    // always names the "_custom" view mode).
    // @see \Drupal\Core\Field\FieldItemListInterface::view()
    // @see https://www.drupal.org/node/2120335
    if ($build['#view_mode'] === '_custom') {
      return;
    }

    $attributes = [];

    // Fields that are computed fields are not editable.
    $definition = $entity->getFieldDefinition($element['#field_name']);
    if (!$definition->isComputed()) {
      $attributes['data-quickedit-field-id'] = $entity->getEntityTypeId() . '/' . $entity->id() . '/' . $element['#field_name'] . '/' . $element['#language'] . '/' . $element['#view_mode'];
    }

    if (!empty($attributes)) {
      return $attributes;
    }

    return NULL;
  }

  /**
   * Checks whether the render array is a field's render array.
   *
   * @param $build
   *   The renderable array.
   *
   * @return bool
   *   True if $build is a field render array.
   */
  protected function isFieldRenderArray($build) {

    return isset($build['#theme']) && $build['#theme'] == 'field';
  }
}
