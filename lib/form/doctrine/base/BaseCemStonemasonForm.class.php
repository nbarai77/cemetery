<?php

/**
 * CemStonemason form base class.
 *
 * @method CemStonemason getObject() Returns the current form's model object
 *
 * @package    cemetery
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseCemStonemasonForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                         => new sfWidgetFormInputHidden(),
      'user_id'                    => new sfWidgetFormInputText(),
      'work_type_stone_mason_id'   => new sfWidgetFormInputText(),
      'bond'                       => new sfWidgetFormInputText(),
      'annual_license_fee'         => new sfWidgetFormInputText(),
      'abn_acn_number'             => new sfWidgetFormInputText(),
      'contractors_license_number' => new sfWidgetFormInputText(),
      'general_induction_cards'    => new sfWidgetFormInputText(),
      'operator_licenses'          => new sfWidgetFormInputText(),
      'list_current_employees'     => new sfWidgetFormInputText(),
      'list_contractors'           => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'                         => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'id', 'required' => false)),
      'user_id'                    => new sfValidatorInteger(),
      'work_type_stone_mason_id'   => new sfValidatorInteger(array('required' => false)),
      'bond'                       => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'annual_license_fee'         => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'abn_acn_number'             => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'contractors_license_number' => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'general_induction_cards'    => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'operator_licenses'          => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'list_current_employees'     => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'list_contractors'           => new sfValidatorString(array('max_length' => 255, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('cem_stonemason[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'CemStonemason';
  }

}
