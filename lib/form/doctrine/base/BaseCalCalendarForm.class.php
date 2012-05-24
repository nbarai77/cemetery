<?php

/**
 * CalCalendar form base class.
 *
 * @method CalCalendar getObject() Returns the current form's model object
 *
 * @package    cemetery
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseCalCalendarForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'cal_calendar_id'            => new sfWidgetFormInputHidden(),
      'cal_schedular_id'           => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('CalSchedular'), 'add_empty' => false)),
      'periode'                    => new sfWidgetFormInputText(),
      'periode_type'               => new sfWidgetFormInputText(),
      'duration'                   => new sfWidgetFormInputText(),
      'slot'                       => new sfWidgetFormInputText(),
      'cal_special_reservation_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('CalSpecialReservation'), 'add_empty' => false)),
      'lab_list'                   => new sfWidgetFormTextarea(),
      'artical_list'               => new sfWidgetFormTextarea(),
      'rate_bace'                  => new sfWidgetFormInputText(),
      'created_at'                 => new sfWidgetFormDateTime(),
      'updated_at'                 => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'cal_calendar_id'            => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'cal_calendar_id', 'required' => false)),
      'cal_schedular_id'           => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('CalSchedular'))),
      'periode'                    => new sfValidatorInteger(),
      'periode_type'               => new sfValidatorInteger(),
      'duration'                   => new sfValidatorInteger(),
      'slot'                       => new sfValidatorInteger(),
      'cal_special_reservation_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('CalSpecialReservation'))),
      'lab_list'                   => new sfValidatorString(array('required' => false)),
      'artical_list'               => new sfValidatorString(array('required' => false)),
      'rate_bace'                  => new sfValidatorString(array('max_length' => 1, 'required' => false)),
      'created_at'                 => new sfValidatorDateTime(),
      'updated_at'                 => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('cal_calendar[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'CalCalendar';
  }

}
