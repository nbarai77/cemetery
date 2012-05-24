<?php

/**
 * FndFndirector form base class.
 *
 * @method FndFndirector getObject() Returns the current form's model object
 *
 * @package    cemetery
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseFndFndirectorForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'              => new sfWidgetFormInputHidden(),
      'cem_cemetery_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('CemCemetery'), 'add_empty' => false)),
      'country_id'      => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Country'), 'add_empty' => false)),
      'code'            => new sfWidgetFormInputText(),
      'company_name'    => new sfWidgetFormInputText(),
      'address'         => new sfWidgetFormTextarea(),
      'state'           => new sfWidgetFormInputText(),
      'town'            => new sfWidgetFormInputText(),
      'postal_code'     => new sfWidgetFormInputText(),
      'title'           => new sfWidgetFormInputText(),
      'first_name'      => new sfWidgetFormInputText(),
      'last_name'       => new sfWidgetFormInputText(),
      'middle_name'     => new sfWidgetFormInputText(),
      'phone'           => new sfWidgetFormInputText(),
      'fax_number'      => new sfWidgetFormInputText(),
      'fax_area_code'   => new sfWidgetFormInputText(),
      'area_code'       => new sfWidgetFormInputText(),
      'email'           => new sfWidgetFormInputText(),
      'is_enabled'      => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'              => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'id', 'required' => false)),
      'cem_cemetery_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('CemCemetery'))),
      'country_id'      => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Country'))),
      'code'            => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'company_name'    => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'address'         => new sfValidatorString(array('required' => false)),
      'state'           => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'town'            => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'postal_code'     => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'title'           => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'first_name'      => new sfValidatorString(array('max_length' => 255)),
      'last_name'       => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'middle_name'     => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'phone'           => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'fax_number'      => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'fax_area_code'   => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'area_code'       => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'email'           => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'is_enabled'      => new sfValidatorInteger(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('fnd_fndirector[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'FndFndirector';
  }

}
