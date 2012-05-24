<?php

/**
 * GranteeDetails form base class.
 *
 * @method GranteeDetails getObject() Returns the current form's model object
 *
 * @package    cemetery
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseGranteeDetailsForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                  => new sfWidgetFormInputHidden(),
      'cem_id'              => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('CemCemetery'), 'add_empty' => false)),
      'title'               => new sfWidgetFormInputText(),
      'grantee_first_name'  => new sfWidgetFormInputText(),
      'grantee_middle_name' => new sfWidgetFormInputText(),
      'grantee_surname'     => new sfWidgetFormInputText(),
      'grantee_address'     => new sfWidgetFormTextarea(),
      'grantee_email'       => new sfWidgetFormInputText(),
      'state'               => new sfWidgetFormInputText(),
      'town'                => new sfWidgetFormInputText(),
      'postal_code'         => new sfWidgetFormInputText(),
      'phone'               => new sfWidgetFormInputText(),
      'contact_mobile'      => new sfWidgetFormInputText(),
      'fax'                 => new sfWidgetFormInputText(),
      'fax_area_code'       => new sfWidgetFormInputText(),
      'area_code'           => new sfWidgetFormInputText(),
      'grantee_dob'         => new sfWidgetFormDate(),
      'grantee_id_number'   => new sfWidgetFormInputText(),
      'grantee_unique_id'   => new sfWidgetFormInputText(),
      'remarks_1'           => new sfWidgetFormInputText(),
      'remarks_2'           => new sfWidgetFormInputText(),
      'created_at'          => new sfWidgetFormDateTime(),
      'updated_at'          => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'                  => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'id', 'required' => false)),
      'cem_id'              => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('CemCemetery'))),
      'title'               => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'grantee_first_name'  => new sfValidatorString(array('max_length' => 255)),
      'grantee_middle_name' => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'grantee_surname'     => new sfValidatorString(array('max_length' => 255)),
      'grantee_address'     => new sfValidatorString(array('required' => false)),
      'grantee_email'       => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'state'               => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'town'                => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'postal_code'         => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'phone'               => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'contact_mobile'      => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'fax'                 => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'fax_area_code'       => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'area_code'           => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'grantee_dob'         => new sfValidatorDate(array('required' => false)),
      'grantee_id_number'   => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'grantee_unique_id'   => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'remarks_1'           => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'remarks_2'           => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'created_at'          => new sfValidatorDateTime(),
      'updated_at'          => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('grantee_details[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'GranteeDetails';
  }

}
