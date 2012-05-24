<?php

/**
 * ArSection form base class.
 *
 * @method ArSection getObject() Returns the current form's model object
 *
 * @package    cemetery
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseArSectionForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'               => new sfWidgetFormInputHidden(),
      'country_id'       => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Country'), 'add_empty' => false)),
      'cem_cemetery_id'  => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('CemCemetery'), 'add_empty' => false)),
      'ar_area_id'       => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('ArArea'), 'add_empty' => true)),
      'section_code'     => new sfWidgetFormInputText(),
      'section_name'     => new sfWidgetFormInputText(),
      'first_grave'      => new sfWidgetFormInputText(),
      'last_grave'       => new sfWidgetFormInputText(),
      'section_user'     => new sfWidgetFormInputText(),
      'section_map_path' => new sfWidgetFormInputText(),
      'is_enabled'       => new sfWidgetFormInputText(),
      'created_at'       => new sfWidgetFormDateTime(),
      'updated_at'       => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'               => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'id', 'required' => false)),
      'country_id'       => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Country'))),
      'cem_cemetery_id'  => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('CemCemetery'))),
      'ar_area_id'       => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('ArArea'), 'required' => false)),
      'section_code'     => new sfValidatorString(array('max_length' => 255)),
      'section_name'     => new sfValidatorString(array('max_length' => 255)),
      'first_grave'      => new sfValidatorInteger(array('required' => false)),
      'last_grave'       => new sfValidatorInteger(array('required' => false)),
      'section_user'     => new sfValidatorString(array('max_length' => 11, 'required' => false)),
      'section_map_path' => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'is_enabled'       => new sfValidatorInteger(array('required' => false)),
      'created_at'       => new sfValidatorDateTime(),
      'updated_at'       => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('ar_section[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'ArSection';
  }

}
