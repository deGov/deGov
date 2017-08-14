<?php

namespace Drupal\degov_search_media_manager\Access;

use Drupal\Core\Access\AccessResult;
use Drupal\Core\Routing\Access\AccessInterface;
use Drupal\Core\Routing\RouteMatch;
use Drupal\Core\Session\AccountProxy;
use Drupal\media_entity\MediaInterface;

/**
 * Class MediaAccessCheck
 *
 * @package Drupal\degov_search_media_manager\Access
 */
class MediaAccessCheck implements AccessInterface {

  /**
   * A custom access check.
   *
   * @param \Drupal\Core\Session\AccountProxy $account
   *   Run access checks for this account.
   *
   * @param \Drupal\Core\Routing\RouteMatch $route_match
   *
   * @return \Drupal\Core\Access\AccessResult
   */
  public function access(AccountProxy $account, RouteMatch $route_match) {
    /** @var MediaInterface $media */
    $media = $route_match->getParameter('media');
    // Check if the user tries to access the media canonical route.
    if ($media instanceof MediaInterface && $media->hasField('field_include_search')) {
      if (!$media->get('field_include_search')->isEmpty()) {
        $include_in_search = $media->get('field_include_search')->getValue();
        if ($include_in_search[0]['value'] == 0) {
          return AccessResult::allowedIfHasPermission($account, 'access media manager');
        }
      }
    }

    return AccessResult::allowed();
  }
}