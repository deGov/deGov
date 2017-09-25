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
    'degov_base_setup' => array(
      'display_name' => t('Install deGov base'),
      'type' => 'batch'
    ),
    'degov_media_setup' => array(
      'display_name' => t('Install deGov media'),
      'type' => 'batch'
    ),
    'degov_paragraphs_setup' => array(
      'display_name' => t('Install deGov paragraphs'),
      'type' => 'batch'
    ),
    'degov_node_setup' => array(
      'display_name' => t('Install deGov node'),
      'type' => 'batch'
    ),
    'degov_search_setup' => array(
      'display_name' => t('Install deGov search'),
      'type' => 'batch'
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
 * Install deGov base task.
 *
 * Install all required base deGov base modules as an additional step.
 */
function degov_base_setup(&$install_state) {
  // Prevent Drupal status messages during profile installation.
  drupal_get_messages('status', TRUE);

  // Rebuild, save, and return data about all currently available modules.
  $files = system_rebuild_module_data();

  // Define all required base deGov modules and features.
  $modules = array(
    'degov_common' => 'degov_common',
    'degov_content_types_shared_fields' => 'degov_content_types_shared_fields',
    'degov_date_formats' => 'degov_date_formats',
    'degov_pathauto' => 'degov_pathauto',
    'degov_rich_text_format_settings' => 'degov_rich_text_format_settings',
    'degov_taxonomy_term_copyright' => 'degov_taxonomy_term_copyright',
    'degov_taxonomy_term_section' => 'degov_taxonomy_term_section',
    'degov_taxonomy_term_tags' => 'degov_taxonomy_term_tags',
  );

  // Add a batch operation to install each module.
  $operations = array();
  foreach ($modules as $module) {
    $operations[] = array('_install_degov_module_batch', array(array($module), $module));
  }

  // Batch operation definition.
  $batch = array(
    'operations' => $operations,
    'title' => t('Install deGov base'),
    'error_message' => t('An error occured during deGov module installation.')
  );

  return $batch;
}

/**
 * Install deGov media task.
 *
 * Install all required base deGov media modules as an additional step.
 */
function degov_media_setup(&$install_state) {
  // Prevent Drupal status messages during profile installation.
  drupal_get_messages('status', TRUE);

  // Rebuild, save, and return data about all currently available modules.
  $files = system_rebuild_module_data();

  // Define all required base deGov modules and features.
  $modules = array(
    'degov_social_media_settings' => 'degov_social_media_settings',
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
    'degov_media_social_media_embed' => 'degov_media_social_media_embed',
    'degov_media_tweet' => 'degov_media_tweet',
    'degov_media_video' => 'degov_media_video',
    'degov_media_video_upload' => 'degov_media_video_upload',
  );

  // Add a batch operation to install each module.
  $operations = array();
  foreach ($modules as $module) {
    $operations[] = array('_install_degov_module_batch', array(array($module), $module));
  }

  // Batch operation definition.
  $batch = array(
    'operations' => $operations,
    'title' => t('Install deGov modules'),
    'error_message' => t('An error occured during deGov module installation.')
  );

  return $batch;
}

/**
 * Install deGov paragraphs task.
 *
 * Install all required base deGov paragraph modules as an additional step.
 */
function degov_paragraphs_setup(&$install_state) {
  // Prevent Drupal status messages during profile installation.
  drupal_get_messages('status', TRUE);

  // Rebuild, save, and return data about all currently available modules.
  $files = system_rebuild_module_data();

  // Define all required base deGov modules and features.
  $modules = array(
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
  );

  // Add a batch operation to install each module.
  $operations = array();
  foreach ($modules as $module) {
    $operations[] = array('_install_degov_module_batch', array(array($module), $module));
  }

  // Batch operation definition.
  $batch = array(
    'operations' => $operations,
    'title' => t('Install deGov modules'),
    'error_message' => t('An error occured during deGov module installation.')
  );

  return $batch;
}

/**
 * Install deGov node modules task.
 *
 * Install all required base deGov node modules.
 */
function degov_node_setup(&$install_state) {
  // Prevent Drupal status messages during profile installation.
  drupal_get_messages('status', TRUE);

  // Rebuild, save, and return data about all currently available modules.
  $files = system_rebuild_module_data();

  // Define all required base deGov modules and features.
  $modules = array(
    'degov_node_blog' => 'degov_node_blog',
    'degov_node_event' => 'degov_node_event',
    'degov_node_faq' => 'degov_node_faq',
    'degov_node_normal_page' => 'degov_node_normal_page',
    'degov_node_press' => 'degov_node_press',
    'degov_simplenews' => 'degov_simplenews',
    'degov_rss_feed' => 'degov_rss_feed',
    'degov_workbench_access' => 'degov_workbench_access',
    //'degov_metatags' => 'degov_metatags',
    //'degov_scheduled_updates' => 'degov_scheduled_updates',
    'degov_users_roles' => 'degov_users_roles',
  );

  // Add a batch operation to install each module.
  $operations = array();
  foreach ($modules as $module) {
    $operations[] = array('_install_degov_module_batch', array(array($module), $module));
  }

  // Batch operation definition.
  $batch = array(
    'operations' => $operations,
    'title' => t('Install deGov modules'),
    'error_message' => t('An error occured during deGov module installation.')
  );

  return $batch;
}

/**
 * Install deGov search modules task.
 *
 * Install all required base deGov search modules.
 */
function degov_search_setup(&$install_state) {
  // Prevent Drupal status messages during profile installation.
  drupal_get_messages('status', TRUE);

  // Rebuild, save, and return data about all currently available modules.
  $files = system_rebuild_module_data();

  // Define all required base deGov modules and features.
  $modules = array(
    'degov_search_base' => 'degov_search_base',
    'degov_search_content' => 'degov_search_content',
    'degov_search_media' => 'degov_search_media'
  );

  // Add a batch operation to install each module.
  $operations = array();
  foreach ($modules as $module) {
    $operations[] = array('_install_degov_module_batch', array(array($module), $module));
  }

  // Batch operation definition.
  $batch = array(
    'operations' => $operations,
    'title' => t('Install deGov modules'),
    'error_message' => t('An error occured during deGov module installation.')
  );

  return $batch;
}

/**
 * Performs batch operation to install a deGov module or feature.
 */
function _install_degov_module_batch($module, $module_name, &$context) {
  set_time_limit(0);
  \Drupal::service('module_installer')->install($module, $dependencies = TRUE);
  $context['results'][] = $module;
  $context['message'] = t('Install %module_name module.', array('%module_name' => $module_name));
}

/**
 * Install deGov theme task.
 *
 * Installs the deGov demo theme as an additional step.
 */
function degov_theme_setup(&$install_state) {
  // Prevent Drupal status messages during profile installation.
  drupal_get_messages('status', TRUE);

  // Set the default theme to be deGov.
  // @todo base theme needs to be set when finished.
  // $theme = 'degov_base_theme';
  // \Drupal::service('theme_installer')->install(array($theme));
  // \Drupal::configFactory()
  //   ->getEditable('system.theme')
  //   ->set('default', $theme)
  //   ->save();
  // \Drupal::service('theme.manager')->resetActiveTheme();
}

/**
 * Implements hook_form_FORM_ID_alter().
 *
 * Alters the profile configuration form to add an additional list of optional
 * deGov modules that can be enabled during profile installation.
 */
function degov_profile_form_install_configure_form_alter(&$form, \Drupal\Core\Form\FormStateInterface $form_state) {
  // Prevent Drupal status messages during profile installation.
  drupal_get_messages('status', TRUE);

  // List all optional deGov modules.
  $degov_optional_modules = [
    'degov_breadcrumb' => 'degov_breadcrumb',
    'degov_html_mail' => 'degov_html_mail',
    'degov_tweets' => 'degov_tweets',
    'degov_eu_cookie_compliance' => 'degov_eu_cookie_compliance',
    'degov_password_policy' => 'degov_password_policy',
    'degov_sitemap_settings' => 'degov_sitemap_settings',
    'degov_search_media_manager' => 'degov_search_media_manager',
    'degov_multilingual' => 'degov_multilingual',
    'degov_restrict_ip' => 'degov_restrict_ip',
    'degov_taxonomy_media_accessibility' => 'degov_taxonomy_media_accessibility',
    'degov_taxonomy_media_language' => 'degov_taxonomy_media_language'
  ];
  $form['degov']['optional_modules'] = [
    '#type' => 'checkboxes',
    '#title' => t('ENABLE OPTIONAL FEATURES'),
    '#description' => t('Checked features are recommended.'),
    '#options' => $degov_optional_modules,
    '#default_value' => [],
  ];

  // Add an additional submit handler for optional modules.
  $form['#submit'][] = 'degov_optional_modules_submit';
}

/**
 * Submit handler for degov_profile_form_install_configure_form_alter().
 */
function degov_optional_modules_submit($form_id, &$form_state) {
  // Sets all optional modules to a Drupal set variable for later installation.
  $degov_optional_modules = array_filter($form_state->getValue('optional_modules'));
  \Drupal::state()->set('degov_optional_modules', $degov_optional_modules);
}

/**
 * Finalize deGov profile installation task.
 *
 * Installs additional recommended deGov modules and features that has been
 * selected during the deGov profile installation.
 */
function degov_finalize_setup() {
  // Prevent Drupal status messages during profile installation.
  drupal_get_messages('status', TRUE);

  $batch = array();

  // Retrieve all checked optional modules.
  $degov_optional_modules = \Drupal::state()->get('degov_optional_modules');

  // Add a batch operation to install each optional module.
  foreach ($degov_optional_modules as $module => $module_name) {
    $batch['operations'][] = ['_install_degov_module_batch', array(array($module), $module_name)];
  }

  return $batch;
}
