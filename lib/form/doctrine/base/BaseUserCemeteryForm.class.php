<?php

/**
 * UserCemetery form base class.
 *
 * @method UserCemetery getObject() Returns the current form's model object
 *
 * @package    cemetery
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseUserCemeteryForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'              => new sfWidgetFormInputHidden(),
      'user_id'         => new sfWidgetFormInputText(),
      'group_id'        => new sfWidgetFormInputText(),
      'cem_cemetery_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('CemCemetery'), 'add_empty' => true)),
      'award_id'        => new sfWidgetFormInputText(),
      'title'           => new sfWidgetFormInputText(),
      'middle_name'     => new sfWidgetFormInputText(),
      'organisation'    => new sfWidgetFormInputText(),
      'code'            => new sfWidgetFormInputText(),
      'address'         => new sfWidgetFormTextarea(),
      'state'           => new sfWidgetFormInputText(),
      'phone'           => new sfWidgetFormInputText(),
      'suburb'          => new sfWidgetFormInputText(),
      'postal_code'     => new sfWidgetFormInputText(),
      'fax'             => new sfWidgetFormInputText(),
      'fax_area_code'   => new sfWidgetFormInputText(),
      'area_code'       => new sfWidgetFormInputText(),
      'user_code'       => new sfWidgetFormInputText(),
      'created_at'      => new sfWidgetFormDateTime(),
      'updated_at'      => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'              => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'id', 'required' => false)),
      'user_id'         => new sfValidatorInteger(),
      'group_id'        => new sfValidatorInteger(),
      'cem_cemetery_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('CemCemetery'), 'required' => false)),
      'award_id'        => new sfValidatorInteger(array('required' => false)),
      'title'           => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'middle_name'     => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'organisation'    => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'code'            => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'address'         => new sfValidatorString(array('required' => false)),
      'state'           => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'phone'           => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'suburb'          => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'postal_code'     => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'fax'             => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'fax_area_code'   => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'area_code'       => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'user_code'       => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'created_at'      => new sfValidatorDateTime(),
      'updated_at'      => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('user_cemetery[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'UserCemetery';
  }

}
