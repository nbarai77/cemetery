<?php

/**
 * IntermentBookingFour form base class.
 *
 * @method IntermentBookingFour getObject() Returns the current form's model object
 *
 * @package    cemetery
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseIntermentBookingFourForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                             => new sfWidgetFormInputHidden(),
      'interment_booking_id'           => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('IntermentBooking'), 'add_empty' => false)),
      'lodged_by_id'                   => new sfWidgetFormInputText(),
      'lodged_by_name'                 => new sfWidgetFormInputText(),
      'deceased_place_of_death'        => new sfWidgetFormInputText(),
      'deceased_country_id_of_death'   => new sfWidgetFormInputText(),
      'deceased_country_id_of_birth'   => new sfWidgetFormInputText(),
      'deceased_place_of_birth'        => new sfWidgetFormInputText(),
      'deceased_date_of_birth'         => new sfWidgetFormDate(),
      'deceased_date_of_death'         => new sfWidgetFormDate(),
      'deceased_age'                   => new sfWidgetFormInputText(),
      'period'                         => new sfWidgetFormInputText(),
      'finageuom'                      => new sfWidgetFormChoice(array('choices' => array('Year' => 'Year', 'Month' => 'Month', 'Weeks' => 'Weeks', 'Days' => 'Days', 'Hours' => 'Hours', 'Adult' => 'Adult', 'Child' => 'Child', 'Unborn' => 'Unborn'))),
      'deceased_usual_address'         => new sfWidgetFormInputText(),
      'deceased_suburb_town'           => new sfWidgetFormInputText(),
      'deceased_state'                 => new sfWidgetFormInputText(),
      'deceased_postal_code'           => new sfWidgetFormInputText(),
      'deceased_country_id'            => new sfWidgetFormInputText(),
      'deceased_marital_status'        => new sfWidgetFormInputText(),
      'deceased_partner_name'          => new sfWidgetFormInputText(),
      'deceased_partner_surname'       => new sfWidgetFormInputText(),
      'deceased_father_name'           => new sfWidgetFormInputText(),
      'deceased_father_surname'        => new sfWidgetFormInputText(),
      'deceased_mother_name'           => new sfWidgetFormInputText(),
      'deceased_mother_maiden_surname' => new sfWidgetFormInputText(),
      'deceased_children1'             => new sfWidgetFormInputText(),
      'deceased_children2'             => new sfWidgetFormInputText(),
      'deceased_children3'             => new sfWidgetFormInputText(),
      'deceased_children4'             => new sfWidgetFormInputText(),
      'deceased_children5'             => new sfWidgetFormInputText(),
      'deceased_children6'             => new sfWidgetFormInputText(),
      'deceased_children7'             => new sfWidgetFormInputText(),
      'deceased_children8'             => new sfWidgetFormInputText(),
      'deceased_children9'             => new sfWidgetFormInputText(),
      'deceased_children10'            => new sfWidgetFormInputText(),
      'deceased_children11'            => new sfWidgetFormInputText(),
      'deceased_children12'            => new sfWidgetFormInputText(),
      'relationship_to_deceased'       => new sfWidgetFormInputText(),
      'informant_title'                => new sfWidgetFormInputText(),
      'informant_surname'              => new sfWidgetFormInputText(),
      'informant_first_name'           => new sfWidgetFormInputText(),
      'informant_middle_name'          => new sfWidgetFormInputText(),
      'informant_fax_area_code'        => new sfWidgetFormInputText(),
      'informant_fax'                  => new sfWidgetFormInputText(),
      'informant_email'                => new sfWidgetFormInputText(),
      'informant_telephone_area_code'  => new sfWidgetFormInputText(),
      'informant_telephone'            => new sfWidgetFormInputText(),
      'informant_mobile'               => new sfWidgetFormInputText(),
      'informant_address'              => new sfWidgetFormInputText(),
      'informant_suburb_town'          => new sfWidgetFormInputText(),
      'informant_state'                => new sfWidgetFormInputText(),
      'informant_postal_code'          => new sfWidgetFormInputText(),
      'informant_country_id'           => new sfWidgetFormInputText(),
      'control_number'                 => new sfWidgetFormInputText(),
      'cul_calender_type'              => new sfWidgetFormInputText(),
      'cul_date_of_death'              => new sfWidgetFormInputText(),
      'cul_time_of_death'              => new sfWidgetFormInputText(),
      'cul_date_of_birth'              => new sfWidgetFormInputText(),
      'cul_date_of_interment'          => new sfWidgetFormInputText(),
      'cul_status'                     => new sfWidgetFormInputText(),
      'cul_died_after_dust'            => new sfWidgetFormInputText(),
      'cul_remains_position'           => new sfWidgetFormInputText(),
      'created_at'                     => new sfWidgetFormDateTime(),
      'updated_at'                     => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'                             => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'id', 'required' => false)),
      'interment_booking_id'           => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('IntermentBooking'))),
      'lodged_by_id'                   => new sfValidatorInteger(array('required' => false)),
      'lodged_by_name'                 => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'deceased_place_of_death'        => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'deceased_country_id_of_death'   => new sfValidatorInteger(array('required' => false)),
      'deceased_country_id_of_birth'   => new sfValidatorInteger(array('required' => false)),
      'deceased_place_of_birth'        => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'deceased_date_of_birth'         => new sfValidatorDate(array('required' => false)),
      'deceased_date_of_death'         => new sfValidatorDate(array('required' => false)),
      'deceased_age'                   => new sfValidatorInteger(array('required' => false)),
      'period'                         => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'finageuom'                      => new sfValidatorChoice(array('choices' => array(0 => 'Year', 1 => 'Month', 2 => 'Weeks', 3 => 'Days', 4 => 'Hours', 5 => 'Adult', 6 => 'Child', 7 => 'Unborn'), 'required' => false)),
      'deceased_usual_address'         => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'deceased_suburb_town'           => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'deceased_state'                 => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'deceased_postal_code'           => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'deceased_country_id'            => new sfValidatorInteger(array('required' => false)),
      'deceased_marital_status'        => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'deceased_partner_name'          => new sfValidatorString(array('max_length' => 30, 'required' => false)),
      'deceased_partner_surname'       => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'deceased_father_name'           => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'deceased_father_surname'        => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'deceased_mother_name'           => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'deceased_mother_maiden_surname' => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'deceased_children1'             => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'deceased_children2'             => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'deceased_children3'             => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'deceased_children4'             => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'deceased_children5'             => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'deceased_children6'             => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'deceased_children7'             => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'deceased_children8'             => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'deceased_children9'             => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'deceased_children10'            => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'deceased_children11'            => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'deceased_children12'            => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'relationship_to_deceased'       => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'informant_title'                => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'informant_surname'              => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'informant_first_name'           => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'informant_middle_name'          => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'informant_fax_area_code'        => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'informant_fax'                  => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'informant_email'                => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'informant_telephone_area_code'  => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'informant_telephone'            => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'informant_mobile'               => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'informant_address'              => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'informant_suburb_town'          => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'informant_state'                => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'informant_postal_code'          => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'informant_country_id'           => new sfValidatorInteger(array('required' => false)),
      'control_number'                 => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'cul_calender_type'              => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'cul_date_of_death'              => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'cul_time_of_death'              => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'cul_date_of_birth'              => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'cul_date_of_interment'          => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'cul_status'                     => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'cul_died_after_dust'            => new sfValidatorInteger(array('required' => false)),
      'cul_remains_position'           => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'created_at'                     => new sfValidatorDateTime(),
      'updated_at'                     => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('interment_booking_four[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'IntermentBookingFour';
  }

}
