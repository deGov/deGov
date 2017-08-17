<?php

namespace Drupal\degov_search_media_manager\EventSubscriber;

use Drupal\Core\Session\AccountInterface;
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
class MediaManagerSubscriber implements EventSubscriberInterface {

  /**
   * @var  AccountInterface
   */
  protected $currentUser;

  /**
   * MediaManagerSubscriber constructor.
   *
   * @param \Drupal\Core\Session\AccountInterface $current_user
   */
  public function __construct(AccountInterface $current_user) {
    $this->currentUser = $current_user;
  }

  /**
   * @param GetResponseEvent $event
   * @return void
   */
  public function onRequest(GetResponseEvent $event) {
    $request = $event->getRequest();
    $route = $request->attributes->get('_route');
    $media = $request->attributes->get('media');

    // Check if the user tries to access the media canonical route.
    if ($route === 'entity.media.canonical' && $media instanceof MediaInterface && $media->hasField('field_include_search') && $media->field_include_search->value === '0' && !$this->currentUser->hasPermission('access media manager')) {
      // Redirect the user to the front page with status 403 if the media is not
      // for search and user has no permissions to access.
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
