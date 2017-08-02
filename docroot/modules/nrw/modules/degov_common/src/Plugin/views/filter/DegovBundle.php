<?php

namespace Drupal\degov_common\Plugin\views\filter;

use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\StringTranslation\TranslatableMarkup;
use Drupal\lightning_core\Plugin\views\filter\Bundle;

/**
 * Class DegovBundle
 *
 * @package Drupal\degov_common\Plugin\views\filter
 */
class DegovBundle extends Bundle {
  /**
   * {@inheritdoc}
   */
  public function buildExposedForm(&$form, FormStateInterface $form_state) {
    parent::buildExposedForm($form, $form_state);

    if (empty($this->options['exposed'])) {
      return;
    }
    if (empty($this->options['expose']['argument'])) {
      return;
    }

    $argument = $this->options['expose']['argument'];
    $argument = $this->view->argument[$argument];
    /** @var \Drupal\views\Plugin\views\argument\ArgumentPluginBase $argument */
    $value = $argument->getValue();

    $key = $this->options['expose']['identifier'];
    $allowed_values = explode('+', $value);
    if (!empty($allowed_values)) {
      foreach ($form[$key]['#options'] as $option => $label) {
        if ($argument->isException($option) || ($label instanceof TranslatableMarkup && $label->getUntranslatedString() == "- Any -")) {
          continue;
        }
        if (!in_array($option, $allowed_values)) {
          unset($form[$key]['#options'][$option]);
        }
      }
      $form[$key]['#access'] = TRUE;
    } else {
      $form[$key]['#access'] = is_null($value) || $argument->isException($value);
    }
  }
}