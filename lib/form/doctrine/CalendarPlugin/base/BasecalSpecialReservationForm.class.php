<?php

/**
 * calSpecialReservation form base class.
 *
 * @method calSpecialReservation getObject() Returns the current form's model object
 *
 * @package    cemetery
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BasecalSpecialReservationForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'cal_special_reservation_id' => new sfWidgetFormInputHidden(),
      'equ_equipment_id'           => new sfWidgetFormInputText(),
      'user_id'                    => new sfWidgetFormInputText(),
      'name'                       => new sfWidgetFormInputText(),
      'reservation_type'           => new sfWidgetFormChoice(array('choices' => array('special' => 'special', 'maintenance' => 'maintenance'))),
      'user_list'                  => new sfWidgetFormTextarea(),
      'sort_order'                 => new sfWidgetFormInputText(),
      'created_at'                 => new sfWidgetFormDateTime(),
      'updated_at'                 => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'cal_special_reservation_id' => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'cal_special_reservation_id', 'required' => false)),
      'equ_equipment_id'           => new sfValidatorInteger(),
      'user_id'                    => new sfValidatorInteger(),
      'name'                       => new sfValidatorString(array('max_length' => 100)),
      'reservation_type'           => new sfValidatorChoice(array('choices' => array(0 => 'special', 1 => 'maintenance'))),
      'user_list'                  => new sfValidatorString(),
      'sort_order'                 => new sfValidatorInteger(array('required' => false)),
      'created_at'                 => new sfValidatorDateTime(),
      'updated_at'                 => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('cal_special_reservation[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'calSpecialReservation';
  }

}
