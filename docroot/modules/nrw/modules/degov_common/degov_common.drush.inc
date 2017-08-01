<?php

/**
 * @file Contains the drush commands.
 */

/**
 * Implements hook_drush_command().
 */
function degov_content_types_shared_fields_drush_command() {
  $items = [];
  $items['scheduled-updates'] = [
    'description' => t('Task to run scheduled updates with drush'),
    'drupal dependencies' => ['degov_content_types_shared_fields', 'scheduled_updates'],
    'aliases' => ['sch-updates']
  ];
  return $items;
}

function drush_degov_content_types_shared_fields_scheduled_updates() {
  if (\Drupal::moduleHandler()->moduleExists('scheduled_updates')) {
    \Drupal::service('scheduled_updates.update_runner')->runAllUpdates();
  }
}
