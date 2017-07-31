<?php

namespace Drupal\degov_users_roles\Routing;

use Drupal\Core\Routing\RouteSubscriberBase;
use Drupal\Core\Routing\RoutingEvents;
use Symfony\Component\Routing\RouteCollection;

/**
 * Class RouteSubscriber
 *
 * @package Drupal\degov_users_roles\Routing
 */
class RouteSubscriber extends RouteSubscriberBase {

  /**
   * Alters existing routes for a specific collection.
   * Adds requirement so the Access Check could be applied.
   *
   * @param \Symfony\Component\Routing\RouteCollection $collection
   *   The route collection for adding routes.
   */
  protected function alterRoutes(RouteCollection $collection) {
    // Find the route we want to alter
    $route = $collection->get('entity.user.edit_form');
    $requirements = $route->getRequirements();
    $requirements['_degov_role_access'] = 'TRUE';
    $route->addRequirements($requirements);
    // Re-add the collection to override the existing route.
    $collection->add('entity.user.edit_form', $route);

    $route = $collection->get('role_delegation.edit_form');
    $requirements = $route->getRequirements();
    $requirements['_degov_role_access'] = 'TRUE';
    $route->addRequirements($requirements);
    // Re-add the collection to override the existing route.
    $collection->add('role_delegation.edit_form', $route);
  }

  /**
   * @return mixed
   */
  public static function getSubscribedEvents() {
    $events[RoutingEvents::ALTER] = 'onAlterRoutes';
    return $events;
  }
}
