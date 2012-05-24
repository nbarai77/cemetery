<?php

/**
 * ArRow form base class.
 *
 * @method ArRow getObject() Returns the current form's model object
 *
 * @package    cemetery
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseArRowForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'              => new sfWidgetFormInputHidden(),
      'country_id'      => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Country'), 'add_empty' => false)),
      'cem_cemetery_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('CemCemetery'), 'add_empty' => false)),
      'ar_area_id'      => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('ArArea'), 'add_empty' => true)),
      'ar_section_id'   => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('ArSection'), 'add_empty' => true)),
      'row_name'        => new sfWidgetFormInputText(),
      'is_enabled'      => new sfWidgetFormInputText(),
      'row_user'        => new sfWidgetFormInputText(),
      'row_map_path'    => new sfWidgetFormInputText(),
      'created_at'      => new sfWidgetFormDateTime(),
      'updated_at'      => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'              => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'id', 'required' => false)),
      'country_id'      => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Country'))),
      'cem_cemetery_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('CemCemetery'))),
      'ar_area_id'      => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('ArArea'), 'required' => false)),
      'ar_section_id'   => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('ArSection'), 'required' => false)),
      'row_name'        => new sfValidatorString(array('max_length' => 255)),
      'is_enabled'      => new sfValidatorInteger(array('required' => false)),
      'row_user'        => new sfValidatorString(array('max_length' => 25, 'required' => false)),
      'row_map_path'    => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'created_at'      => new sfValidatorDateTime(),
      'updated_at'      => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('ar_row[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'ArRow';
  }

}
