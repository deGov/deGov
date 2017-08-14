<?php

namespace Drupal\degov_search_media_manager\Routing;

use Drupal\Core\Routing\RouteSubscriberBase;
use Drupal\Core\Routing\RoutingEvents;
use Symfony\Component\Routing\RouteCollection;

/**
 * Redirect to front page if user should not be allowed to access
 * canonical route of media entity.
 */
class MediaManagerSubscriber extends RouteSubscriberBase {

  /**
   * Alters existing routes for a specific collection.
   * Adds requirement so the Access Check could be applied.
   *
   * @param \Symfony\Component\Routing\RouteCollection $collection
   *   The route collection for adding routes.
   */
  protected function alterRoutes(RouteCollection $collection) {
    // Find the route we want to alter
    $route = $collection->get('entity.media.canonical');
    $requirements = $route->getRequirements();
    $requirements['_degov_media_access'] = 'TRUE';
    $route->addRequirements($requirements);
    // Re-add the collection to override the existing route.
    $collection->add('entity.media.canonical', $route);
  }

  /**
   * @return mixed
   */
  public static function getSubscribedEvents() {
    $events[RoutingEvents::ALTER] = 'onAlterRoutes';
    return $events;
  }
}
