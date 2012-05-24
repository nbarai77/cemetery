<?php

/**
 * TimeInOut form base class.
 *
 * @method TimeInOut getObject() Returns the current form's model object
 *
 * @package    cemetery
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseTimeInOutForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'          => new sfWidgetFormInputHidden(),
      'user_id'     => new sfWidgetFormInputText(),
      'day_type_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('DayType'), 'add_empty' => true)),
      'created_at'  => new sfWidgetFormDateTime(),
      'updated_at'  => new sfWidgetFormDateTime(),
      'task_date'   => new sfWidgetFormDate(),
      'time_in'     => new sfWidgetFormTime(),
      'time_out'    => new sfWidgetFormTime(),
      'total_hrs'   => new sfWidgetFormTime(),
      'status'      => new sfWidgetFormChoice(array('choices' => array('IN' => 'IN', 'OUT' => 'OUT'))),
    ));

    $this->setValidators(array(
      'id'          => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'id', 'required' => false)),
      'user_id'     => new sfValidatorInteger(),
      'day_type_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('DayType'), 'required' => false)),
      'created_at'  => new sfValidatorDateTime(),
      'updated_at'  => new sfValidatorDateTime(),
      'task_date'   => new sfValidatorDate(),
      'time_in'     => new sfValidatorTime(),
      'time_out'    => new sfValidatorTime(),
      'total_hrs'   => new sfValidatorTime(),
      'status'      => new sfValidatorChoice(array('choices' => array(0 => 'IN', 1 => 'OUT'))),
    ));

    $this->widgetSchema->setNameFormat('time_in_out[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'TimeInOut';
  }

}
