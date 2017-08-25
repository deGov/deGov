<?php
/**
 * @file
 * Enables modules and site configuration for the nrwGov profile.
 */

/**
 * Implements hook_install_tasks().
 *
 * Defines additional tasks to be performed by the nrwGov installation profile.
 */
function nrwgov_profile_install_tasks($install_state) {
  $tasks = array(
    'nrwgov_module_setup' => array(
      'display_name' => t('Install nrwGov modules'),
      'type' => 'batch'
    ),
    'nrwgov_theme_setup' => array(
      'display_name' => t('Install nrwGov theme'),
      'display' => TRUE,
    ),
    'nrwgov_finalize_setup' => array(
      'display_name' => t('Finalize installation'),
      'type' => 'batch',
      'display' => TRUE,
    ),
  );

  return $tasks;
}

/**
 * Install nrwGov modules task.
 *
 * Install all required base nrwGov modules and features as an additional step to
 * prevent double defined configuration files.
 */
function nrwgov_module_setup(&$install_state) {
  // Prevent Drupal status messages during profile installation.
  drupal_get_messages('status', TRUE);

  // Rebuild, save, and return data about all currently available modules.
  $files = system_rebuild_module_data();

  // Define all required base nrwGov modules and features.
  $modules = array(
    'degov_breadcrumb' => 'degov_breadcrumb',
    'degov_common' => 'degov_common',
    'degov_content_types_shared_fields' => 'degov_content_types_shared_fields',
    'degov_date_formats' => 'degov_date_formats',
    'degov_html_mail' => 'degov_html_mail',
    'degov_media_address' => 'degov_media_address',
    'degov_media_audio' => 'degov_media_audio',
    'degov_media_caption_helper' => 'degov_media_caption_helper',
    'degov_media_citation' => 'degov_media_citation',
    'degov_media_contact' => 'degov_media_contact',
    'degov_media_document' => 'degov_media_document',
    'degov_media_gallery' => 'degov_media_gallery',
    'degov_media_image' => 'degov_media_image',
    'degov_media_instagram' => 'degov_media_instagram',
    'degov_media_person' => 'degov_media_person',
    'degov_media_tweet' => 'degov_media_tweet',
    'degov_media_video' => 'degov_media_video',
    'degov_media_video_upload' => 'degov_media_video_upload',
    'degov_node_blog' => 'degov_node_blog',
    'degov_node_event' => 'degov_node_event',
    'degov_node_faq' => 'degov_node_faq',
    'degov_node_normal_page' => 'degov_node_normal_page',
    'degov_node_press' => 'degov_node_press',
    'degov_paragraph_block_reference' => 'degov_paragraph_block_reference',
    'degov_paragraph_downloads' => 'degov_paragraph_downloads',
    'degov_paragraph_faq' => 'degov_paragraph_faq',
    'degov_paragraph_header' => 'degov_paragraph_header',
    'degov_paragraph_iframe' => 'degov_paragraph_iframe',
    'degov_paragraph_links' => 'degov_paragraph_links',
    'degov_paragraph_map' => 'degov_paragraph_map',
    'degov_paragraph_media_reference' => 'degov_paragraph_media_reference',
    'degov_paragraph_node_reference' => 'degov_paragraph_node_reference',
    'degov_paragraph_slideshow' => 'degov_paragraph_slideshow',
    'degov_paragraph_text' => 'degov_paragraph_text',
    'degov_paragraph_video_subtitle' => 'degov_paragraph_video_subtitle',
    'degov_paragraph_view_reference' => 'degov_paragraph_view_reference',
    'degov_paragraph_webformular' => 'degov_paragraph_webformular',
    'degov_rss_feed' => 'degov_rss_feed',
    'degov_search_base' => 'degov_search_base',
    'degov_search_content' => 'degov_search_content',
    'degov_search_media' => 'degov_search_media',
    'degov_search_media_manager' => 'degov_search_media_manager',
    'degov_taxonomy_term_copyright' => 'degov_taxonomy_term_copyright',
    'degov_taxonomy_term_section' => 'degov_taxonomy_term_section',
    'degov_taxonomy_term_tags' => 'degov_taxonomy_term_tags',
    'degov_simplenews' => 'degov_simplenews',
    'degov_tweets' => 'degov_tweets',
    'degov_users_roles' => 'degov_users_roles',
    'degov_views_helper' => 'degov_views_helper',
    'degov_workbench_access' => 'degov_workbench_access',
    'degov_eu_cookie_compliance' => 'degov_eu_cookie_compliance',
    'degov_metatags' => 'degov_metatags',
    'degov_password_policy' => 'degov_password_policy',
    'degov_pathauto' => 'degov_pathauto',
    'degov_rich_text_format_settings' => 'degov_rich_text_format_settings',
    'degov_sitemap_settings' => 'degov_sitemap_settings',
  );

  // Add a batch operation to install each module.
  $operations = array();
  foreach ($modules as $module) {
    $operations[] = array('_install_nrwgov_module_batch', array(array($module), $module));
  }

  // Batch operation definition.
  $batch = array(
    'operations' => $operations,
    'title' => t('Install nrwGov modules'),
    'error_message' => t('An error occured during nrwGov module installation.')
  );

  return $batch;
}

/**
 * Performs batch operation to install a nrwGov module or feature.
 */
function _install_nrwgov_module_batch($module, $module_name, &$context) {
  set_time_limit(0);
  \Drupal::service('module_installer')->install($module, $dependencies = TRUE);
  $context['results'][] = $module;
  $context['message'] = t('Install %module_name module.', array('%module_name' => $module_name));
}

/**
 * Install nrwGov theme task.
 *
 * Installs the nrwGov demo theme as an additional step.
 */
function nrwgov_theme_setup(&$install_state) {
  // Prevent Drupal status messages during profile installation.
  drupal_get_messages('status', TRUE);

  // Set the default theme to be nrwGov.
  $theme = 'nrw_base_theme';
  \Drupal::service('theme_installer')->install(array($theme));
  \Drupal::configFactory()
    ->getEditable('system.theme')
    ->set('default', $theme)
    ->save();
  \Drupal::service('theme.manager')->resetActiveTheme();
}

/**
 * Implements hook_form_FORM_ID_alter().
 *
 * Alters the profile configuration form to add an additional list of optional
 * nrwGov modules that can be enabled during profile installation.
 */
function nrwgov_profile_form_install_configure_form_alter(&$form, \Drupal\Core\Form\FormStateInterface $form_state) {
  // Prevent Drupal status messages during profile installation.
  drupal_get_messages('status', TRUE);

  // List all optional nrwGov modules.
  $nrwgov_optional_modules = [
    'nrw_view_mode_overrides' => t('nrw_view_mode_overrides'),
    'nrw_view_paragraph_selection_overrides' => t('nrw_view_paragraph_selection_overrides'),
    'nrw_menu' => t('nrw_menu'),
    'nrw_image_and_crop_styles' => t('nrw_image_and_crop_styles'),
  ];
  $form['nrwgov']['optional_modules'] = [
    '#type' => 'checkboxes',
    '#title' => t('ENABLE OPTIONAL FEATURES'),
    '#description' => t('Checked features are recommended.'),
    '#options' => $nrwgov_optional_modules,
    '#default_value' => [
      'nrw_view_mode_overrides',
      'nrw_view_paragraph_selection_overrides',
      'nrw_menu',
      'nrw_image_and_crop_styles'
    ],
  ];

  // Add an additional submit handler for optional modules.
  $form['#submit'][] = 'nrwgov_optional_modules_submit';
}

/**
 * Submit handler for nrwgov_profile_form_install_configure_form_alter().
 */
function nrwgov_optional_modules_submit($form_id, &$form_state) {
  // Sets all optional modules to a Drupal set variable for later installation.
  $nrwgov_optional_modules = array_filter($form_state->getValue('optional_modules'));
  \Drupal::state()->set('nrwgov_optional_modules', $nrwgov_optional_modules);
}

/**
 * Finalize nrwGov profile installation task.
 *
 * Installs additional recommended nrwGov modules and features that has been
 * selected during the nrwGov profile installation.
 */
function nrwgov_finalize_setup() {
  // Prevent Drupal status messages during profile installation.
  drupal_get_messages('status', TRUE);

  $batch = array();

  // Retrieve all checked optional modules.
  $nrwgov_optional_modules = \Drupal::state()->get('nrwgov_optional_modules');

  // Add a batch operation to install each optional module.
  foreach ($nrwgov_optional_modules as $module => $module_name) {
    $batch['operations'][] = ['_install_nrwgov_module_batch', array(array($module), $module_name)];
  }

  return $batch;
}
