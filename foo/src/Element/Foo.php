<?php

namespace Drupal\foo\Element;

use Drupal\Component\Utility\Html;
use Drupal\webform\Element\WebformCompositeBase;

/**
 * Provides a 'foo'.
 *
 * Webform composites contain a group of sub-elements.
 *
 *
 * IMPORTANT:
 * Webform composite can not contain multiple value elements (ie checkboxes)
 * or composites (ie webform_address)
 *
 * @FormElement("foo")
 *
 * @see \Drupal\webform\Element\WebformCompositeBase
 * @see \Drupal\foo\Element\WebformExampleComposite
 */
class Foo extends WebformCompositeBase {

  /**
   * {@inheritdoc}
   */
  public function getInfo() {
    return parent::getInfo() + ['#theme' => 'foo'];
  }

  /**
   * {@inheritdoc}
   */
  public static function getCompositeElements() {
    // Generate an unique ID that can be used by #states.
    $html_id = Html::getUniqueId('foo');

    $elements = [];
    $elements['dependent_name'] = [
      '#type' => 'textfield',
      '#title' => t('Depedent name'),
      '#attributes' => ['data-webform-composite-id' => $html_id . '--dependent_name'],
    ];
    $elements['dependent_ssn'] = [
      '#type' => 'textfield',
      '#title' => t('Depedent SSN'),
      '#input_mask' => '999-99-9999',
      '#attributes' => ['data-webform-composite-id' => $html_id . '--dependent_ssn'],
    ];
    $elements['relationship_to_dependent'] = [
      '#type' => 'select',
      '#title' => t('Relationship of dependent to you:'),
      '#options' => [
        'sibling' => 'Sibling',
        'child' => 'Child',
        'fosterchild' => 'Fosterchild',
        'parent' => 'Parent',
        'stepchild' => 'Stepchild',
      ],
      '#attributes' => ['data-webform-composite-id' => $html_id . '--relationship'],
    ];
    $elements['date_of_birth'] = [
      '#type' => 'date',
      '#title' => t('Date of birth'),
      '#states' => [
        'enabled' => [
          '[data-webform-composite-id="' . $html_id . '--dependent_name"]' => ['filled' => TRUE],
        ],
      ],
    ];
    $elements['gender'] = [
      '#type' => 'select',
      '#title' => t('Gender of dependent'),
      '#options' => 'gender',
      '#empty_option' => '',
      '#states' => [
        'enabled' => [
          '[data-webform-composite-id="' . $html_id . '--dependent_name"]' => ['filled' => TRUE],
        ],
      ],
    ];
    $elements['status'] = [
      "#type" => 'checkbox',
      '#title' => t('Do they live with you?'),
      '#attributes' => ['data-webform-composite-id' => $html_id . '--status'],
    ];
    return $elements;
  }

}
