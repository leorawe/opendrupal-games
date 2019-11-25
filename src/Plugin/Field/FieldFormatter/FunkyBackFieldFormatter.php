<?php

namespace Drupal\opendrupal_pegi\Plugin\Field\FieldFormatter;

//use Drupal\Component\Utility\Html;
//use Drupal\Core\Field\FieldItemInterface;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FormatterBase;
//use Drupal\Core\Form\FormStateInterface;

/**
 * Plugin implementation of the 'test_field_formatter' formatter.
 *
 * @FieldFormatter(
 *   id = "test_field_formatter",
 *   label = @Translation("Funky Back Color"),
 *   field_types = {
 *     "string"
 *   }
 * )
 */
class FunkyBackFieldFormatter extends FormatterBase {

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $elements = [];

    foreach ($items as $delta => $item) {
      //$elements[$delta] = ['#markup' => $this->viewValue($item)];
      $elements[$delta] = [
        '#type' => 'html_tag',
        '#tag' => 'p',
        '#value' => $this->t('The content area color has been changed to @code', ['@code' => $item->value]),
        '#attributes' => [
          'style' => 'background-color: ' . $item->value,
        ],
      ];
    }

    return $elements;
  }

}
