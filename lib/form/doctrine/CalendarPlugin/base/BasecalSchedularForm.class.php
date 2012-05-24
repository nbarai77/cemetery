<?php

/**
 * calSchedular form base class.
 *
 * @method calSchedular getObject() Returns the current form's model object
 *
 * @package    cemetery
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BasecalSchedularForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'cal_schedular_id' => new sfWidgetFormInputHidden(),
      'cal_template_id'  => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('CalTemplate'), 'add_empty' => false)),
      'start_date'       => new sfWidgetFormDateTime(),
      'created_at'       => new sfWidgetFormDateTime(),
      'updated_at'       => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'cal_schedular_id' => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'cal_schedular_id', 'required' => false)),
      'cal_template_id'  => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('CalTemplate'))),
      'start_date'       => new sfValidatorDateTime(),
      'created_at'       => new sfValidatorDateTime(),
      'updated_at'       => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('cal_schedular[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'calSchedular';
  }

}
