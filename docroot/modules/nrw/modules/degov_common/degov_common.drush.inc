<?php

/**
 * @file Contains the drush commands.
 */

/**
 * Implements hook_drush_command().
 */
function degov_common_drush_command() {
  $items = [];
  $items['scheduled-updates'] = [
    'description' => t('Task to run scheduled updates with drush'),
    'drupal dependencies' => ['degov_common', 'scheduled_updates'],
    'aliases' => ['sch-updates']
  ];
  return $items;
}

function drush_degov_common_scheduled_updates() {
  if (\Drupal::moduleHandler()->moduleExists('scheduled_updates')) {
    \Drupal::service('scheduled_updates.update_runner')->runAllUpdates();
  }
}
