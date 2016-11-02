<?php

namespace Drupal\itnrw_map\Tests\Controller;

use Drupal\simpletest\WebTestBase;

/**
 * Provides automated tests for the degov_welcome module.
 */
class ItnrwMapControllerTest extends WebTestBase {


  /**
   * {@inheritdoc}
   */
  public static function getInfo() {
    return array(
      'name' => "itnrw_map DefaultController's controller functionality",
      'description' => 'Test Unit for module itnrw_map and controller DefaultController.',
      'group' => 'Other',
    );
  }

  /**
   * {@inheritdoc}
   */
  public function setUp() {
    parent::setUp();
  }

  /**
   * Tests degov_welcome functionality.
   */
  public function testDefaultController() {
    // Check that the basic functions of module degov_welcome.
    $this->assertEquals(TRUE, TRUE, 'Test Unit Generated via Drupal Console.');
  }

}
