<?php

/**
 * @file
 * Contains \Drupal\degov_search_media_permissions\EventSubscriber\MediaPermissionSubscriber
 */

namespace Drupal\degov_search_media_permissions\EventSubscriber;

use Drupal\Core\Url;
use Drupal\media_entity\MediaInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;

/**
 * Redirect to front page if user should not be allowed to access
 * canonical route of media entity.
 */
class MediaPermissionSubscriber implements EventSubscriberInterface {

  /**
   * @param GetResponseEvent $event
   * @return void
   */
  public function onRequest(GetResponseEvent $event) {
    $request = $event->getRequest();
    $route = $request->attributes->get('_route');
    $media = $request->attributes->get('media');

    if ($route === 'entity.media.canonical' && $media instanceof MediaInterface && $media->hasField('field_include_search') && $media->field_include_search->value === '0' && !\Drupal::currentUser()->getAccount()->hasPermission('access media manager')) {
      $url = Url::fromRoute('<front>');
      $response = new RedirectResponse($url->toString(), 301);
      $event->setResponse($response);
    }
  }

  /**
   * {@inheritdoc}
   */
  public static function getSubscribedEvents() {
    $events[KernelEvents::REQUEST][] = ['onRequest'];
    return $events;
  }
}
