<?php

/**
 * CemCemetery form base class.
 *
 * @method CemCemetery getObject() Returns the current form's model object
 *
 * @package    cemetery
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseCemCemeteryForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                => new sfWidgetFormInputHidden(),
      'country_id'        => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Country'), 'add_empty' => false)),
      'name'              => new sfWidgetFormInputText(),
      'description'       => new sfWidgetFormTextarea(),
      'url'               => new sfWidgetFormInputText(),
      'is_enabled'        => new sfWidgetFormInputText(),
      'address'           => new sfWidgetFormInputText(),
      'suburb_town'       => new sfWidgetFormInputText(),
      'state'             => new sfWidgetFormInputText(),
      'postcode'          => new sfWidgetFormInputText(),
      'area_code'         => new sfWidgetFormInputText(),
      'phone'             => new sfWidgetFormInputText(),
      'fax_area_code'     => new sfWidgetFormInputText(),
      'fax'               => new sfWidgetFormInputText(),
      'email'             => new sfWidgetFormInputText(),
      'gmap_code'         => new sfWidgetFormTextarea(),
      'cemetery_map_path' => new sfWidgetFormInputText(),
      'latitude'          => new sfWidgetFormInputText(),
      'longitude'         => new sfWidgetFormInputText(),
      'created_at'        => new sfWidgetFormDateTime(),
      'updated_at'        => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'                => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'id', 'required' => false)),
      'country_id'        => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Country'))),
      'name'              => new sfValidatorString(array('max_length' => 255)),
      'description'       => new sfValidatorString(array('required' => false)),
      'url'               => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'is_enabled'        => new sfValidatorInteger(array('required' => false)),
      'address'           => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'suburb_town'       => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'state'             => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'postcode'          => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'area_code'         => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'phone'             => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'fax_area_code'     => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'fax'               => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'email'             => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'gmap_code'         => new sfValidatorString(array('max_length' => 2000, 'required' => false)),
      'cemetery_map_path' => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'latitude'          => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'longitude'         => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'created_at'        => new sfValidatorDateTime(),
      'updated_at'        => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('cem_cemetery[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'CemCemetery';
  }

}
