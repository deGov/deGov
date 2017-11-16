<?php
/**
 * @file
 * Enables modules and site configuration for the deGov profile.
 */

/**
 * Implements hook_install_tasks().
 *
 * Defines additional tasks to be performed by the deGov installation profile.
 */
function degov_profile_install_tasks($install_state) {
  $tasks = array(
    'degov_theme_setup' => array(
      'display_name' => t('Install deGov theme'),
      'display' => TRUE,
    ),
  );

  return $tasks;
}

/**
 * Install deGov base theme task.
 *
 * Installs the deGov demo theme as an additional step.
 */
function degov_theme_setup(&$install_state) {
  // Prevent Drupal status messages during profile installation.
  drupal_get_messages('status', TRUE);

  // Set the default theme to be deGov.
  $theme = 'degov_base_theme';
  \Drupal::service('theme_installer')->install(array($theme));
  \Drupal::configFactory()
    ->getEditable('system.theme')
    ->set('default', $theme)
    ->save();
  \Drupal::service('theme.manager')->resetActiveTheme();
}
