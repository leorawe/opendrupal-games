<?php
/**
 * @file
 * Contains \Drupal\opendrupal_pegi\Form\OpendrupalPegiSettingsForm.
 */
namespace Drupal\opendrupal_pegi\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
/**
 * Displays theme configuration for entire site and individual themes.
 */
class OpendrupalPegiSettingsForm extends ConfigFormBase {
  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'opendrupal_pegi_settings';
  }
  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return ['opendrupal_pegi.settings'];
  }
  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('opendrupal_pegi.settings');


    //up to how many links are allowed?
    $options = [2, 3, 4, 5, 6, 7, 8, 9, 10];
    $form['block_links']=[
      '#type' => 'select',
      '#title' => $this->t('Links in Game Review Block'),
      '#default_value' => $config->get('opendrupal_pegi.block_link_limit'),
      '#options' => array_combine($options, $options),
      '#description' => $this->t('Default number of game review links displayed in block.'),
    ];
    $form['page_links']=[
      '#type' => 'select',
      '#title' => $this->t('Links on Game Review Page'),
      '#default_value' => $config->get('opendrupal_pegi.page_link_limit'),
      '#options' => array_combine($options, $options),
      '#description' => $this->t('Default number of game review links displayed on page.'),
    ];

    $form['page_title'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Page Title'),
      '#default_value' => $config->get('opendrupal_pegi.page_title_setting'),
    ];  

    return parent::buildForm($form, $form_state);
  }
  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->config('opendrupal_pegi.settings')
      ->set('opendrupal_pegi.block_link_limit', $form_state->getValue('block_links'))
      ->set('opendrupal_pegi.page_link_limit', $form_state->getValue('page_links'))
      ->set('opendrupal_pegi.page_title_setting', $form_state->getValue('page_title'))
      ->save();

    parent::submitForm($form, $form_state);
    $this->messenger()->addStatus($this->t('Game configuration options have been saved.'));
  }
}