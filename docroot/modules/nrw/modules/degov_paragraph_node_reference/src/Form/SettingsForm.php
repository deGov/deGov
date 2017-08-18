<?php

namespace Drupal\degov_paragraph_node_reference\Form;

use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Entity\EntityDisplayRepositoryInterface;
use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class SettingsForm.
 *
 * @package Drupal\degov_paragraph_node_reference
 */
class SettingsForm extends ConfigFormBase {

  /**
   * The entity display repository.
   *
   * @var \Drupal\Core\Entity\EntityDisplayRepositoryInterface
   */
  protected $entityDisplayRepository;

  /**
   * Constructs a \Drupal\degov_paragraph_node_reference\Form\SettingsForm object.
   *
   * @param \Drupal\Core\Config\ConfigFactoryInterface $config_factory
   *   The factory for configuration objects.
   * @param \Drupal\Core\Entity\EntityDisplayRepositoryInterface $entity_display_repository
   *   The entity display repository service.
   */
  public function __construct(ConfigFactoryInterface $config_factory, EntityDisplayRepositoryInterface $entity_display_repository) {
    parent::__construct($config_factory);
    $this->entityDisplayRepository = $entity_display_repository;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('config.factory'),
      $container->get('entity_display.repository')
    );
  }

  /**
   * Gets the configuration names that will be editable.
   *
   * @return array
   *   An array of configuration object names that are editable if called in
   *   conjunction with the trait's config() method.
   */
  protected function getEditableConfigNames() {
    return [
      'degov_paragraph_node_reference.settings',
    ];
  }

  /**
   * Returns a unique string identifying the form.
   *
   * @return string
   *   The unique string identifying the form.
   */
  public function getFormId() {
    return 'degov_paragraph_node_reference_settings';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    // Get the current settings.
    $config = $this->config('degov_paragraph_node_reference.settings');

    // Get all view modes for nodes.
    $view_modes = $this->entityDisplayRepository->getViewModes('node');

    // Create the options array for the form element
    $options = [];
    foreach ($view_modes as $key => $value) {
      if ($value['status'] === TRUE) {
        $options[$key] = $value['label'];
      }
    }

    $form['enabled_view_modes'] = [
      '#type' => 'checkboxes',
      '#title' => t('Enabled view modes'),
      '#options' => $options,
      '#default_value' => $config->get('enabled_view_modes'),
    ];

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $enabled_view_modes = $form_state->getValue('enabled_view_modes');
    $this->configFactory()->getEditable('degov_paragraph_node_reference.settings')
      ->set('enabled_view_modes', $enabled_view_modes)
      ->save();
    parent::submitForm($form, $form_state);
  }
}
