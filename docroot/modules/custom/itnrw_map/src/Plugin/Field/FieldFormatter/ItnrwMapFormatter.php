<?php

namespace Drupal\itnrw_map\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Component\Utility\Html;
use Drupal\itnrw_map\Controller\ItnrwMapController;

/**
 * Plugin implementation of the 'itnrw_map' formatter.
 *
 * @FieldFormatter(
 *   id = "itnrw_map",
 *   label = @Translation("IT.NRW Map from one-line address"),
 *   field_types = {
 *     "string"
 *   }
 * )
 */
class ItnrwMapFormatter extends FormatterBase {

  /**
   * {@inheritdoc}
   */
  public static function defaultSettings() {
    return array(
     "service_token" => "dcc283ec-e666-069b-42f0-160b2cfa13d6",
     "zoom_level" => "12",
    ) + parent::defaultSettings();
  }

  /**
   * {@inheritdoc}
   */
  public function settingsForm(array $form, FormStateInterface $form_state) {
    $elements = parent::settingsForm($form, $form_state);

    $elements['service_token'] = array(
      '#type'          => 'textfield',
      '#title'         => $this->t('Token'),
      '#default_value' => "dcc283ec-e666-069b-42f0-160b2cfa13d6",
      '#description'   => $this->t("Enter the given token you have obtained from your service provider"),
    );

    $elements['generic_label'] = array(
      '#type' => 'markup',
      '#markup' => '<h3>' . $this->t('General settings') . '</h3>',
    );
    $elements['zoom_level'] = array(
      '#type' => 'select',
      '#options' => array(
        1 => $this->t('1 - Minimum'),
        2 => 2,
        3 => 3,
        4 => 4,
        5 => 5,
        6 => 6,
        7 => 7,
        8 => 8,
        9 => 9,
        10 => 10,
        11 => 11,
        12 => $this->t('12 - Default'),
        13 => 13,
        14 => 14,
        15 => 15,
        16 => 16,
        17 => 17,
        18 => 18,
        19 => 19,
        20 => $this->t('20 - Maximum'),
      ),
      '#title' => $this->t('Zoom level'),
      '#default_value' => $this->getSetting('zoom_level'),
    );

    return $elements;
  }

  /**
   * {@inheritdoc}
   */
  public function settingsSummary() {
    $summary = array();

    $service_token = $this->getSetting('service_token') ? : "";
    $summary[] = $this->t('Provided token: %token', array('%token'  => $service_token));

    $zoom_level = $this->getSetting('zoom_level') ?: "12";
    $summary[] = $this->t('Zoom level: %zoom_level', array('%zoom_level' => $zoom_level));

    return $summary;
  }

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {

    $element = array();
    $settings = $this->getSettings();

    $service_token = $settings['service_token'];
    $zoom_level = (int) $settings['zoom_level'];

    $itnrw = new ItnrwMapController($service_token);
    foreach ($items as $delta => $item) {
      $address_value = Html::escape($item->value);
      $coordinates = $itnrw->geocodeAddress($address_value);

      $element[$delta] = array(
        '#theme' => 'itnrw_map_output',
        '#zoom' => $zoom_level,
        '#coordinates' => $coordinates,
      );
    }
    return $element;
  }
}
