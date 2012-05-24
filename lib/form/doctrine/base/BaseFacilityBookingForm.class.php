<?php

/**
 * FacilityBooking form base class.
 *
 * @method FacilityBooking getObject() Returns the current form's model object
 *
 * @package    cemetery
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseFacilityBookingForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                  => new sfWidgetFormInputHidden(),
      'country_id'          => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Country'), 'add_empty' => false)),
      'cem_cemetery_id'     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('CemCemetery'), 'add_empty' => false)),
      'title'               => new sfWidgetFormInputText(),
      'surname'             => new sfWidgetFormInputText(),
      'first_name'          => new sfWidgetFormInputText(),
      'middle_name'         => new sfWidgetFormInputText(),
      'email'               => new sfWidgetFormInputText(),
      'telephone'           => new sfWidgetFormInputText(),
      'mobile'              => new sfWidgetFormInputText(),
      'address'             => new sfWidgetFormTextarea(),
      'state'               => new sfWidgetFormInputText(),
      'suburb_town'         => new sfWidgetFormInputText(),
      'postal_code'         => new sfWidgetFormInputText(),
      'fax'                 => new sfWidgetFormInputText(),
      'fax_area_code'       => new sfWidgetFormInputText(),
      'area_code'           => new sfWidgetFormInputText(),
      'chapel'              => new sfWidgetFormChoice(array('choices' => array('YES' => 'YES', 'NO' => 'NO'))),
      'cem_chapel_ids'      => new sfWidgetFormInputText(),
      'chapel_time_from'    => new sfWidgetFormDateTime(),
      'chapel_time_to'      => new sfWidgetFormDateTime(),
      'chapel_cost'         => new sfWidgetFormInputText(),
      'room'                => new sfWidgetFormChoice(array('choices' => array('YES' => 'YES', 'NO' => 'NO'))),
      'cem_room_ids'        => new sfWidgetFormInputText(),
      'room_time_from'      => new sfWidgetFormDateTime(),
      'room_time_to'        => new sfWidgetFormDateTime(),
      'no_of_rooms'         => new sfWidgetFormInputText(),
      'room_cost'           => new sfWidgetFormInputText(),
      'special_instruction' => new sfWidgetFormInputText(),
      'receipt_number'      => new sfWidgetFormInputText(),
      'total'               => new sfWidgetFormInputText(),
      'is_finalized'        => new sfWidgetFormInputText(),
      'created_at'          => new sfWidgetFormDateTime(),
      'updated_at'          => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'                  => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'id', 'required' => false)),
      'country_id'          => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Country'))),
      'cem_cemetery_id'     => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('CemCemetery'))),
      'title'               => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'surname'             => new sfValidatorString(array('max_length' => 255)),
      'first_name'          => new sfValidatorString(array('max_length' => 255)),
      'middle_name'         => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'email'               => new sfValidatorString(array('max_length' => 255)),
      'telephone'           => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'mobile'              => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'address'             => new sfValidatorString(array('required' => false)),
      'state'               => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'suburb_town'         => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'postal_code'         => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'fax'                 => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'fax_area_code'       => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'area_code'           => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'chapel'              => new sfValidatorChoice(array('choices' => array(0 => 'YES', 1 => 'NO'), 'required' => false)),
      'cem_chapel_ids'      => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'chapel_time_from'    => new sfValidatorDateTime(array('required' => false)),
      'chapel_time_to'      => new sfValidatorDateTime(array('required' => false)),
      'chapel_cost'         => new sfValidatorInteger(array('required' => false)),
      'room'                => new sfValidatorChoice(array('choices' => array(0 => 'YES', 1 => 'NO'), 'required' => false)),
      'cem_room_ids'        => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'room_time_from'      => new sfValidatorDateTime(array('required' => false)),
      'room_time_to'        => new sfValidatorDateTime(array('required' => false)),
      'no_of_rooms'         => new sfValidatorInteger(array('required' => false)),
      'room_cost'           => new sfValidatorInteger(array('required' => false)),
      'special_instruction' => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'receipt_number'      => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'total'               => new sfValidatorInteger(array('required' => false)),
      'is_finalized'        => new sfValidatorInteger(array('required' => false)),
      'created_at'          => new sfValidatorDateTime(),
      'updated_at'          => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('facility_booking[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'FacilityBooking';
  }

}
