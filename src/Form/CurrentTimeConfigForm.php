<?php

namespace Drupal\current_time\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Implements a configuration form for current_time_block.
 */
class CurrentTimeConfigForm extends ConfigFormBase {
  /**
     * Config settings.
     *
     * @var string
     */
  const SETTINGS = 'current_time.settings';

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'current_time_admin_settings';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      static::SETTINGS,
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config(static::SETTINGS);

    $form['country'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Country'),
      '#default_value' => $config->get('country'),
    ];

    $form['city'] = [
      '#type' => 'textfield',
      '#title' => $this->t('City'),
      '#default_value' => $config->get('city'),
    ];

    $timezone_options = [
      'America/Chicago' => $this->t('America/Chicago'),
      'America/New_York' => $this->t('America/New York'),
      'Asia/Tokyo' => $this->t('Asia/Tokyo'),
      'Asia/Dubai' => $this->t('Asia/Dubai'),
      'Asia/Kolkata' => $this->t('Asia/Kolkata'),
      'Europe/Amsterdam' => $this->t('Europe/Amsterdam'),
      'Europe/Oslo' => $this->t('Europe/Oslo'),
      'Europe/London' => $this->t('Europe/London'),
    ];
    $form['timezone'] = [
      '#type' => 'select',
      '#title' => $this->t('Timezone'),
      '#options' => $timezone_options,
      '#default_value' => $config->get('timezone'),
      '#required' => TRUE,
    ];

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    // Save form data as configuration.
    $this->configFactory->getEditable(static::SETTINGS)
      ->set('country', $form_state->getValue('country'))
      ->set('city', $form_state->getValue('city'))
      ->set('timezone', $form_state->getValue('timezone'))
      ->save();

    parent::submitForm($form, $form_state);
  }

}
