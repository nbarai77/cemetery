<?php

/**
 * IntermentBookingTwo form base class.
 *
 * @method IntermentBookingTwo getObject() Returns the current form's model object
 *
 * @package    cemetery
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseIntermentBookingTwoForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                   => new sfWidgetFormInputHidden(),
      'interment_booking_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('IntermentBooking'), 'add_empty' => false)),
      'disease_id'           => new sfWidgetFormInputText(),
      'unit_type_id'         => new sfWidgetFormInputText(),
      'coffin_type_id'       => new sfWidgetFormInputText(),
      'death_certificate'    => new sfWidgetFormInputText(),
      'own_clergy'           => new sfWidgetFormInputText(),
      'clergy_name'          => new sfWidgetFormInputText(),
      'coffin_surcharge'     => new sfWidgetFormInputText(),
      'burning_drum'         => new sfWidgetFormInputText(),
      'fireworks'            => new sfWidgetFormInputText(),
      'lowering_device'      => new sfWidgetFormInputText(),
      'balloons'             => new sfWidgetFormInputText(),
      'chapel_multimedia'    => new sfWidgetFormInputText(),
      'facility'             => new sfWidgetFormChoice(array('choices' => array('YES' => 'YES', 'NO' => 'NO'))),
      'facility_from'        => new sfWidgetFormDateTime(),
      'facility_to'          => new sfWidgetFormDateTime(),
      'coffin_length'        => new sfWidgetFormInputText(),
      'coffin_width'         => new sfWidgetFormInputText(),
      'coffin_height'        => new sfWidgetFormInputText(),
      'chapel'               => new sfWidgetFormChoice(array('choices' => array('YES' => 'YES', 'NO' => 'NO'))),
      'cem_chapel_ids'       => new sfWidgetFormInputText(),
      'chapel_time_from'     => new sfWidgetFormDateTime(),
      'chapel_time_to'       => new sfWidgetFormDateTime(),
      'room'                 => new sfWidgetFormChoice(array('choices' => array('YES' => 'YES', 'NO' => 'NO'))),
      'cem_room_ids'         => new sfWidgetFormInputText(),
      'room_time_from'       => new sfWidgetFormDateTime(),
      'room_time_to'         => new sfWidgetFormDateTime(),
      'special_instruction'  => new sfWidgetFormInputText(),
      'ceremonial_sand'      => new sfWidgetFormInputText(),
      'receipt_number'       => new sfWidgetFormInputText(),
      'canopy'               => new sfWidgetFormInputText(),
      'cost'                 => new sfWidgetFormInputText(),
      'notes'                => new sfWidgetFormTextarea(),
      'created_at'           => new sfWidgetFormDateTime(),
      'updated_at'           => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'                   => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'id', 'required' => false)),
      'interment_booking_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('IntermentBooking'))),
      'disease_id'           => new sfValidatorInteger(array('required' => false)),
      'unit_type_id'         => new sfValidatorInteger(array('required' => false)),
      'coffin_type_id'       => new sfValidatorInteger(array('required' => false)),
      'death_certificate'    => new sfValidatorInteger(array('required' => false)),
      'own_clergy'           => new sfValidatorInteger(array('required' => false)),
      'clergy_name'          => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'coffin_surcharge'     => new sfValidatorInteger(array('required' => false)),
      'burning_drum'         => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'fireworks'            => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'lowering_device'      => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'balloons'             => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'chapel_multimedia'    => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'facility'             => new sfValidatorChoice(array('choices' => array(0 => 'YES', 1 => 'NO'), 'required' => false)),
      'facility_from'        => new sfValidatorDateTime(array('required' => false)),
      'facility_to'          => new sfValidatorDateTime(array('required' => false)),
      'coffin_length'        => new sfValidatorInteger(array('required' => false)),
      'coffin_width'         => new sfValidatorInteger(array('required' => false)),
      'coffin_height'        => new sfValidatorInteger(array('required' => false)),
      'chapel'               => new sfValidatorChoice(array('choices' => array(0 => 'YES', 1 => 'NO'), 'required' => false)),
      'cem_chapel_ids'       => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'chapel_time_from'     => new sfValidatorDateTime(array('required' => false)),
      'chapel_time_to'       => new sfValidatorDateTime(array('required' => false)),
      'room'                 => new sfValidatorChoice(array('choices' => array(0 => 'YES', 1 => 'NO'), 'required' => false)),
      'cem_room_ids'         => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'room_time_from'       => new sfValidatorDateTime(array('required' => false)),
      'room_time_to'         => new sfValidatorDateTime(array('required' => false)),
      'special_instruction'  => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'ceremonial_sand'      => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'receipt_number'       => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'canopy'               => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'cost'                 => new sfValidatorInteger(array('required' => false)),
      'notes'                => new sfValidatorString(array('required' => false)),
      'created_at'           => new sfValidatorDateTime(),
      'updated_at'           => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('interment_booking_two[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'IntermentBookingTwo';
  }

}
