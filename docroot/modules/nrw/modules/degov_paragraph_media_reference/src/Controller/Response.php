<?php

namespace Drupal\degov_paragraph_media_reference\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Provides route responses for the Media reference module.
 */
class Response extends ControllerBase {

  /**
   * Returns an array of allowed view modes by given entity type and id.
   *
   * @param string $entity_type
   *   Entity type that needs is checked for allowed view modes.
   * @param string $entity_id
   *   Entity id that needs is checked for allowed view modes.
   *
   * @return array
   *   An arroy of allowed view modes.
   */
  public function ajaxEntityLoad($entity_type, $entity_id) {
    // Retrieve the entity.
    $entity_storage = \Drupal::entityTypeManager()->getStorage($entity_type);
    if (!empty($entity_storage)) {
      $entity = $entity_storage->load($entity_id);
      // Check the entity for enabled view modes.
      $view_modes = \Drupal::entityQuery('entity_view_display')
        ->condition('bundle', $entity->bundle())
        ->execute();
      foreach ($view_modes as $view_mode) {
        $view_mode = explode('.', $view_mode);
        if (!empty($view_mode[2])) {
          $allowed_view_modes[] = $view_mode[2];
        }
      }
    }

    return new JsonResponse($allowed_view_modes);
  }
}