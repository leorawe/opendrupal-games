<?php
/**
 
 * @file
 
 * Contains \Drupal\opendrupal_pegi\Form\GameForm.
 
 */
namespace Drupal\opendrupal_pegi\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Form for Configuration on Block listing Game Reviews
 */
class GameForm extends ConfigFormBase {
  /**
   * {@inheritdoc}
   */
  public function getFormId(){
    return 'opendrupal_pegi_game_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form = parent::buildForm($form, $form_state);
 
    $config = $this->config('opendrupal_pegi.settings');
    
    //up to how many links are allowed?
    $form['max_items']=[
      '#type' => 'number',
      '#default_value' => $config->get('opendrupal_pegi.max_items'),
    ];

    $form['submit']=[
      '#type' => 'submit',
      '#value' => $this->t('Set Max Num'),
    ];
    $form['#cache'] = ['max-age' => 0];
    return $form;
  }

/**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    //message
    $config = $this->config('opendrupal_pegi.settings');
 
    $config->set('opendrupal_pegi.max_items', $form_state->getValue('max_items'));
 
    $config->save();
 
    return parent::submitForm($form, $form_state);
   }


  /**
 
   * {@inheritdoc}
 
   */
 
  protected function getEditableConfigNames() {
 
    return [
 
      'opendrupal_pegi.settings',
 
    ];
 
  }
}