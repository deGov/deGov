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
 *
 * Install all required base deGov modules and features as an additional step to
 * prevent double defined configuration files.
 */
function degov_module_setup(&$install_state) {
  // Prevent Drupal status messages during profile installation.
  drupal_get_messages('status', TRUE);

  // Rebuild, save, and return data about all currently available modules.
  $files = system_rebuild_module_data();

  // Define all required base deGov modules and features.
  $modules = array(
    'degov_common' => 'degov_common',
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
    'degov_eu_cookie_compliance' => t('EU cookie compliance'),
    'degov_password_policy' => t('Secure password policy'),
  ];
  $form['degov']['optional_modules'] = [
    '#type' => 'checkboxes',
    '#title' => t('ENABLE OPTIONAL FEATURES'),
    '#description' => t('Checked features are recommended.'),
    '#options' => $degov_optional_modules,
    '#default_value' => [
      'degov_eu_cookie_compliance',
      'degov_password_policy'
    ],
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
