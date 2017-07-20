<?php

namespace Drupal\degov_views_helper\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class DegovSettingsForm.
 *
 * @package Drupal\degov_views_helper
 */
class DegovSettingsForm extends ConfigFormBase {

  /**
   * Gets the configuration names that will be editable.
   *
   * @return array
   *   An array of configuration object names that are editable if called in
   *   conjunction with the trait's config() method.
   */
  protected function getEditableConfigNames() {
    return [
      'degov.default_settings',
    ];
  }

  /**
   * Returns a unique string identifying the form.
   *
   * @return string
   *   The unique string identifying the form.
   */
  public function getFormId() {
    return 'degov_default_settings';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['help'] = [
      '#type' => 'markup',
      '#markup' => '<p>' . $this->t('This is configuration section of deGov distribution') . '</p>',
    ];
    return parent::buildForm($form, $form_state);
  }

}
