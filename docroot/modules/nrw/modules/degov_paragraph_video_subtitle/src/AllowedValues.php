<?php

namespace Drupal\degov_paragraph_video_subtitle;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\field\Entity\FieldStorageConfig;

/**
 * Class AllowedValues
 *
 * @package Drupal\degov_paragraph_subtitle
 */
class AllowedValues {

  /**
   * Gets the allowed values for the field_subtitle_lang field.
   *
   * @param \Drupal\field\Entity\FieldStorageConfig $definition
   *   The field definition.
   *
   * @param \Drupal\Core\Entity\ContentEntityInterface|NULL $entity
   *   The entity being created or updated.
   *
   * @param $cacheable
   *   Whether or not the results are cacheable.
   *
   * @return array
   *   An array of allowed values.
   */
  public static function lang(FieldStorageConfig $definition, ContentEntityInterface $entity = NULL, $cacheable) {
    $options = [];
    $languages = \Drupal::languageManager()->getLanguages();

    foreach ($languages as $language) {
      $options[$language->getId()] = $language->getName();
    }

    return $options;
  }

}
