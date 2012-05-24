<?php

/**
 * ArGraveMaintenance form base class.
 *
 * @method ArGraveMaintenance getObject() Returns the current form's model object
 *
 * @package    cemetery
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseArGraveMaintenanceForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                => new sfWidgetFormInputHidden(),
      'country_id'        => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Country'), 'add_empty' => false)),
      'cem_cemetery_id'   => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('CemCemetery'), 'add_empty' => false)),
      'ar_area_id'        => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('ArArea'), 'add_empty' => true)),
      'ar_section_id'     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('ArSection'), 'add_empty' => true)),
      'ar_row_id'         => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('ArRow'), 'add_empty' => true)),
      'ar_plot_id'        => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('ArPlot'), 'add_empty' => true)),
      'ar_grave_id'       => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('ArGrave'), 'add_empty' => false)),
      'date_paid'         => new sfWidgetFormDate(),
      'onsite_work_date'  => new sfWidgetFormDate(),
      'amount_paid'       => new sfWidgetFormInputText(),
      'receipt'           => new sfWidgetFormInputText(),
      'renewal_term'      => new sfWidgetFormChoice(array('choices' => array('6 Months' => '6 Months', '1 Year' => '1 Year', '5 Years' => '5 Years', '10 Years' => '10 Years', 'Perpetual' => 'Perpetual'))),
      'renewal_date'      => new sfWidgetFormDate(),
      'interred_name'     => new sfWidgetFormInputText(),
      'interred_surname'  => new sfWidgetFormInputText(),
      'title'             => new sfWidgetFormInputText(),
      'organization_name' => new sfWidgetFormInputText(),
      'first_name'        => new sfWidgetFormInputText(),
      'surname'           => new sfWidgetFormInputText(),
      'address'           => new sfWidgetFormTextarea(),
      'subrub'            => new sfWidgetFormInputText(),
      'state'             => new sfWidgetFormInputText(),
      'postal_code'       => new sfWidgetFormInputText(),
      'user_country'      => new sfWidgetFormInputText(),
      'email'             => new sfWidgetFormInputText(),
      'area_code'         => new sfWidgetFormInputText(),
      'number'            => new sfWidgetFormInputText(),
      'notes'             => new sfWidgetFormTextarea(),
      'created_at'        => new sfWidgetFormDateTime(),
      'updated_at'        => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'                => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'id', 'required' => false)),
      'country_id'        => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Country'))),
      'cem_cemetery_id'   => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('CemCemetery'))),
      'ar_area_id'        => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('ArArea'), 'required' => false)),
      'ar_section_id'     => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('ArSection'), 'required' => false)),
      'ar_row_id'         => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('ArRow'), 'required' => false)),
      'ar_plot_id'        => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('ArPlot'), 'required' => false)),
      'ar_grave_id'       => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('ArGrave'))),
      'date_paid'         => new sfValidatorDate(array('required' => false)),
      'onsite_work_date'  => new sfValidatorDate(array('required' => false)),
      'amount_paid'       => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'receipt'           => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'renewal_term'      => new sfValidatorChoice(array('choices' => array(0 => '6 Months', 1 => '1 Year', 2 => '5 Years', 3 => '10 Years', 4 => 'Perpetual'))),
      'renewal_date'      => new sfValidatorDate(array('required' => false)),
      'interred_name'     => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'interred_surname'  => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'title'             => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'organization_name' => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'first_name'        => new sfValidatorString(array('max_length' => 255)),
      'surname'           => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'address'           => new sfValidatorString(array('required' => false)),
      'subrub'            => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'state'             => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'postal_code'       => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'user_country'      => new sfValidatorInteger(array('required' => false)),
      'email'             => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'area_code'         => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'number'            => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'notes'             => new sfValidatorString(array('required' => false)),
      'created_at'        => new sfValidatorDateTime(),
      'updated_at'        => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('ar_grave_maintenance[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'ArGraveMaintenance';
  }

}
