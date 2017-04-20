<?php

/**
 * @file
 * Enables modules and site configuration for the {{ profile }} profile.
 */

/**
 * Implements hook_install_tasks().
 */
function degov_profile_install_tasks($install_state){
  $tasks = array(
    'degov_module_setup' => array(
      'display_name' => t('Install deGov modules'),
      'type' => 'batch'
    ),
    'degov_theme_setup' => array(
      'display_name' => t('Install deGov theme'),
      'display' => TRUE,
    ),
    'degov_finalize_setup' => array(
      'display_name' => t('Finalize installation'),
      'type' => 'batch',
      'display' => TRUE,
    ),
  );

  return $tasks;
}

/**
 * Install deGov modules task.
 */
function degov_module_setup(&$install_state) {
  drupal_get_messages('status', TRUE);

  $files = system_rebuild_module_data();

  $modules = array(
    'degov_eu_cookie_compliance' => 'degov_eu_cookie_compliance',
    'degov_address_element' => 'degov_address_element',
    'degov_image_element' => 'degov_image_element',
    'degov_image_text_element' => 'degov_image_text_element',
    'degov_text_element' => 'degov_text_element',
    'degov_citation_element' => 'degov_citation_element',
    'degov_links_element' => 'degov_links_element',
    'degov_contact_element' => 'degov_contact_element',
    'degov_gallery_element' => 'degov_gallery_element',
    'degov_downloads_element' => 'degov_downloads_element',
    'degov_faq_element' => 'degov_faq_element',
    'degov_google_maps_element' => 'degov_google_maps_element',
    'degov_video_element' => 'degov_video_element'
  );

  $operations = array();
  foreach ($modules as $module) {
    $operations[] = array('_install_degov_module_batch', array(array($module), $module));
  }

  $batch = array(
    'operations' => $operations,
    'title' => t('Install deGov modules'),
    'error_message' => t('An error occured during deGov module installation.')
  );

  return $batch;
}

/**
 * Performs batch installation of deGov modules.
 */
function _install_degov_module_batch($module, $module_name, &$context) {
  set_time_limit(0);
  \Drupal::service('module_installer')->install($module, $dependencies = TRUE);
  $context['results'][] = $module;
  $context['message'] = t('Install %module_name module.', array('%module_name' => $module_name));
}

/**
 * Install deGov theme task.
 */
function degov_theme_setup(&$install_state) {
  drupal_get_messages('status', TRUE);

  $theme = 'degov_theme';

  \Drupal::service('theme_handler')->install(array($theme));

  \Drupal::configFactory()
    ->getEditable('system.theme')
    ->set('default', $theme)
    ->save();

  \Drupal::service('theme.manager')->resetActiveTheme();

}

/**
 * Finalize deGov profile installation task.
 */
function degov_finalize_setup() {
  drupal_get_messages('status', TRUE);
}
