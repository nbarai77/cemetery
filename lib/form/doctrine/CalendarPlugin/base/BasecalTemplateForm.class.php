<?php

/**
 * calTemplate form base class.
 *
 * @method calTemplate getObject() Returns the current form's model object
 *
 * @package    cemetery
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BasecalTemplateForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'cal_template_id'  => new sfWidgetFormInputHidden(),
      'equ_equipment_id' => new sfWidgetFormInputText(),
      'name'             => new sfWidgetFormInputText(),
      'description'      => new sfWidgetFormTextarea(),
      'created_at'       => new sfWidgetFormDateTime(),
      'updated_at'       => new sfWidgetFormDateTime(),
      'param_set'        => new sfWidgetFormTextarea(),
    ));

    $this->setValidators(array(
      'cal_template_id'  => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'cal_template_id', 'required' => false)),
      'equ_equipment_id' => new sfValidatorInteger(),
      'name'             => new sfValidatorString(array('max_length' => 100)),
      'description'      => new sfValidatorString(array('required' => false)),
      'created_at'       => new sfValidatorDateTime(),
      'updated_at'       => new sfValidatorDateTime(),
      'param_set'        => new sfValidatorString(),
    ));

    $this->widgetSchema->setNameFormat('cal_template[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'calTemplate';
  }

}
