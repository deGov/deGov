<?php

namespace Drupal\degov_users_roles\Access;

use Drupal\Core\Access\AccessResult;
use Drupal\Core\Routing\Access\AccessInterface;
use Drupal\Core\Routing\RouteMatch;
use Drupal\Core\Session\AccountProxy;
use Drupal\user\UserInterface;

/**
 * Class UserEditAccessCheck
 *
 * @package Drupal\degov_users_roles\Access
 */
class UserEditAccessCheck implements AccessInterface {

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
    /** @var \Drupal\user\UserInterface $userToEdit */
    // Only allow users with the administrator role to edit users with the administrator role.
    $userToEdit = $route_match->getParameter('user');
    if ($userToEdit && $userToEdit instanceof UserInterface && $userToEdit->hasRole('administrator')) {
      $current_user_roles = $account->getAccount()->getRoles();
      return AccessResult::allowedIf(in_array('administrator', $current_user_roles));
    }

    return AccessResult::allowed();
  }
}
