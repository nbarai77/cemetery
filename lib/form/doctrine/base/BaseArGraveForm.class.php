<?php

/**
 * ArGrave form base class.
 *
 * @method ArGrave getObject() Returns the current form's model object
 *
 * @package    cemetery
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseArGraveForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                       => new sfWidgetFormInputHidden(),
      'country_id'               => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Country'), 'add_empty' => false)),
      'cem_cemetery_id'          => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('CemCemetery'), 'add_empty' => false)),
      'ar_area_id'               => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('ArArea'), 'add_empty' => true)),
      'ar_section_id'            => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('ArSection'), 'add_empty' => true)),
      'ar_row_id'                => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('ArRow'), 'add_empty' => true)),
      'ar_plot_id'               => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('ArPlot'), 'add_empty' => true)),
      'ar_grave_status_id'       => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('ArGraveStatus'), 'add_empty' => false)),
      'cem_stonemason_id'        => new sfWidgetFormInputText(),
      'grave_number'             => new sfWidgetFormInputText(),
      'grave_image1'             => new sfWidgetFormInputText(),
      'grave_image2'             => new sfWidgetFormInputText(),
      'length'                   => new sfWidgetFormInputText(),
      'width'                    => new sfWidgetFormInputText(),
      'height'                   => new sfWidgetFormInputText(),
      'unit_type_id'             => new sfWidgetFormInputText(),
      'details'                  => new sfWidgetFormTextarea(),
      'monument'                 => new sfWidgetFormInputText(),
      'monuments_grave_position' => new sfWidgetFormInputText(),
      'monuments_unit_type'      => new sfWidgetFormInputText(),
      'monuments_depth'          => new sfWidgetFormInputText(),
      'monuments_width'          => new sfWidgetFormInputText(),
      'monuments_length'         => new sfWidgetFormInputText(),
      'latitude'                 => new sfWidgetFormInputText(),
      'longitude'                => new sfWidgetFormInputText(),
      'is_enabled'               => new sfWidgetFormInputText(),
      'comment1'                 => new sfWidgetFormTextarea(),
      'comment2'                 => new sfWidgetFormTextarea(),
      'user_id'                  => new sfWidgetFormInputText(),
      'created_at'               => new sfWidgetFormDateTime(),
      'updated_at'               => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'                       => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'id', 'required' => false)),
      'country_id'               => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Country'))),
      'cem_cemetery_id'          => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('CemCemetery'))),
      'ar_area_id'               => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('ArArea'), 'required' => false)),
      'ar_section_id'            => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('ArSection'), 'required' => false)),
      'ar_row_id'                => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('ArRow'), 'required' => false)),
      'ar_plot_id'               => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('ArPlot'), 'required' => false)),
      'ar_grave_status_id'       => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('ArGraveStatus'))),
      'cem_stonemason_id'        => new sfValidatorInteger(array('required' => false)),
      'grave_number'             => new sfValidatorString(array('max_length' => 25)),
      'grave_image1'             => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'grave_image2'             => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'length'                   => new sfValidatorString(array('max_length' => 10, 'required' => false)),
      'width'                    => new sfValidatorString(array('max_length' => 10, 'required' => false)),
      'height'                   => new sfValidatorString(array('max_length' => 30, 'required' => false)),
      'unit_type_id'             => new sfValidatorInteger(array('required' => false)),
      'details'                  => new sfValidatorString(array('required' => false)),
      'monument'                 => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'monuments_grave_position' => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'monuments_unit_type'      => new sfValidatorInteger(array('required' => false)),
      'monuments_depth'          => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'monuments_width'          => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'monuments_length'         => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'latitude'                 => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'longitude'                => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'is_enabled'               => new sfValidatorInteger(array('required' => false)),
      'comment1'                 => new sfValidatorString(array('required' => false)),
      'comment2'                 => new sfValidatorString(array('required' => false)),
      'user_id'                  => new sfValidatorInteger(array('required' => false)),
      'created_at'               => new sfValidatorDateTime(),
      'updated_at'               => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('ar_grave[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'ArGrave';
  }

}
