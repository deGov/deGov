<?php

namespace Drupal\degov_welcome\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Class DefaultController.
 *
 * @package Drupal\degov_welcome\Controller
 */
class DefaultController extends ControllerBase {

  /**
   * Hello.
   *
   * @return string
   *   Return Hello string.
   */
  public function welcome() {
    return [
      '#type' => 'markup',
      '#markup' => $this->t('Welcome to deGOV - you successfully installed deGov'),
    ];
  }

}
