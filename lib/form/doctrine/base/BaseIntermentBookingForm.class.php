<?php

/**
 * IntermentBooking form base class.
 *
 * @method IntermentBooking getObject() Returns the current form's model object
 *
 * @package    cemetery
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseIntermentBookingForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                         => new sfWidgetFormInputHidden(),
      'country_id'                 => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Country'), 'add_empty' => true)),
      'cem_cemetery_id'            => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('CemCemetery'), 'add_empty' => true)),
      'ar_area_id'                 => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('ArArea'), 'add_empty' => true)),
      'ar_section_id'              => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('ArSection'), 'add_empty' => true)),
      'ar_row_id'                  => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('ArRow'), 'add_empty' => true)),
      'ar_plot_id'                 => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('ArPlot'), 'add_empty' => true)),
      'ar_grave_id'                => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('ArGrave'), 'add_empty' => true)),
      'ar_grave_status'            => new sfWidgetFormInputText(),
      'denomination_id'            => new sfWidgetFormInputText(),
      'fnd_fndirector_id'          => new sfWidgetFormInputText(),
      'service_type_id'            => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('ServiceType'), 'add_empty' => true)),
      'cem_stonemason_id'          => new sfWidgetFormInputText(),
      'catalog_id'                 => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Catalog'), 'add_empty' => true)),
      'payment_id'                 => new sfWidgetFormInputText(),
      'deceased_title'             => new sfWidgetFormInputText(),
      'deceased_surname'           => new sfWidgetFormInputText(),
      'deceased_first_name'        => new sfWidgetFormInputText(),
      'deceased_middle_name'       => new sfWidgetFormInputText(),
      'deceased_other_surname'     => new sfWidgetFormInputText(),
      'deceased_other_first_name'  => new sfWidgetFormInputText(),
      'deceased_other_middle_name' => new sfWidgetFormInputText(),
      'deceased_gender'            => new sfWidgetFormChoice(array('choices' => array('Male' => 'Male', 'Female' => 'Female', 'Trans-Gender' => 'Trans-Gender'))),
      'date_notified'              => new sfWidgetFormDate(),
      'consultant'                 => new sfWidgetFormInputText(),
      'service_date'               => new sfWidgetFormDate(),
      'date1_day'                  => new sfWidgetFormInputText(),
      'service_booking_time_from'  => new sfWidgetFormTime(),
      'service_booking_time_to'    => new sfWidgetFormTime(),
      'service_date2'              => new sfWidgetFormDate(),
      'date2_day'                  => new sfWidgetFormInputText(),
      'service_booking2_time_from' => new sfWidgetFormTime(),
      'service_booking2_time_to'   => new sfWidgetFormTime(),
      'service_date3'              => new sfWidgetFormDate(),
      'date3_day'                  => new sfWidgetFormInputText(),
      'service_booking3_time_from' => new sfWidgetFormTime(),
      'service_booking3_time_to'   => new sfWidgetFormTime(),
      'monument'                   => new sfWidgetFormInputText(),
      'monuments_grave_position'   => new sfWidgetFormInputText(),
      'monuments_unit_type'        => new sfWidgetFormInputText(),
      'monuments_depth'            => new sfWidgetFormInputText(),
      'monuments_width'            => new sfWidgetFormInputText(),
      'monuments_length'           => new sfWidgetFormInputText(),
      'grantee_first_name'         => new sfWidgetFormInputText(),
      'grantee_surname'            => new sfWidgetFormInputText(),
      'grantee_id'                 => new sfWidgetFormInputText(),
      'grantee_relationship'       => new sfWidgetFormInputText(),
      'grave_size'                 => new sfWidgetFormInputText(),
      'grave_length'               => new sfWidgetFormInputText(),
      'grave_width'                => new sfWidgetFormInputText(),
      'grave_depth'                => new sfWidgetFormInputText(),
      'grave_unit_type'            => new sfWidgetFormInputText(),
      'is_finalized'               => new sfWidgetFormInputText(),
      'is_private'                 => new sfWidgetFormInputText(),
      'interment_date'             => new sfWidgetFormDate(),
      'taken_by'                   => new sfWidgetFormInputText(),
      'confirmed'                  => new sfWidgetFormInputText(),
      'comment1'                   => new sfWidgetFormTextarea(),
      'comment2'                   => new sfWidgetFormTextarea(),
      'user_id'                    => new sfWidgetFormInputText(),
      'created_at'                 => new sfWidgetFormDateTime(),
      'updated_at'                 => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'                         => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'id', 'required' => false)),
      'country_id'                 => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Country'), 'required' => false)),
      'cem_cemetery_id'            => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('CemCemetery'), 'required' => false)),
      'ar_area_id'                 => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('ArArea'), 'required' => false)),
      'ar_section_id'              => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('ArSection'), 'required' => false)),
      'ar_row_id'                  => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('ArRow'), 'required' => false)),
      'ar_plot_id'                 => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('ArPlot'), 'required' => false)),
      'ar_grave_id'                => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('ArGrave'), 'required' => false)),
      'ar_grave_status'            => new sfValidatorInteger(array('required' => false)),
      'denomination_id'            => new sfValidatorInteger(array('required' => false)),
      'fnd_fndirector_id'          => new sfValidatorInteger(array('required' => false)),
      'service_type_id'            => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('ServiceType'), 'required' => false)),
      'cem_stonemason_id'          => new sfValidatorInteger(array('required' => false)),
      'catalog_id'                 => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Catalog'), 'required' => false)),
      'payment_id'                 => new sfValidatorInteger(array('required' => false)),
      'deceased_title'             => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'deceased_surname'           => new sfValidatorString(array('max_length' => 255)),
      'deceased_first_name'        => new sfValidatorString(array('max_length' => 255)),
      'deceased_middle_name'       => new sfValidatorString(array('max_length' => 255)),
      'deceased_other_surname'     => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'deceased_other_first_name'  => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'deceased_other_middle_name' => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'deceased_gender'            => new sfValidatorChoice(array('choices' => array(0 => 'Male', 1 => 'Female', 2 => 'Trans-Gender'), 'required' => false)),
      'date_notified'              => new sfValidatorDate(array('required' => false)),
      'consultant'                 => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'service_date'               => new sfValidatorDate(array('required' => false)),
      'date1_day'                  => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'service_booking_time_from'  => new sfValidatorTime(array('required' => false)),
      'service_booking_time_to'    => new sfValidatorTime(array('required' => false)),
      'service_date2'              => new sfValidatorDate(array('required' => false)),
      'date2_day'                  => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'service_booking2_time_from' => new sfValidatorTime(array('required' => false)),
      'service_booking2_time_to'   => new sfValidatorTime(array('required' => false)),
      'service_date3'              => new sfValidatorDate(array('required' => false)),
      'date3_day'                  => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'service_booking3_time_from' => new sfValidatorTime(array('required' => false)),
      'service_booking3_time_to'   => new sfValidatorTime(array('required' => false)),
      'monument'                   => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'monuments_grave_position'   => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'monuments_unit_type'        => new sfValidatorInteger(array('required' => false)),
      'monuments_depth'            => new sfValidatorInteger(array('required' => false)),
      'monuments_width'            => new sfValidatorInteger(array('required' => false)),
      'monuments_length'           => new sfValidatorInteger(array('required' => false)),
      'grantee_first_name'         => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'grantee_surname'            => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'grantee_id'                 => new sfValidatorInteger(array('required' => false)),
      'grantee_relationship'       => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'grave_size'                 => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'grave_length'               => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'grave_width'                => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'grave_depth'                => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'grave_unit_type'            => new sfValidatorInteger(array('required' => false)),
      'is_finalized'               => new sfValidatorInteger(array('required' => false)),
      'is_private'                 => new sfValidatorInteger(array('required' => false)),
      'interment_date'             => new sfValidatorDate(array('required' => false)),
      'taken_by'                   => new sfValidatorInteger(array('required' => false)),
      'confirmed'                  => new sfValidatorInteger(array('required' => false)),
      'comment1'                   => new sfValidatorString(array('required' => false)),
      'comment2'                   => new sfValidatorString(array('required' => false)),
      'user_id'                    => new sfValidatorInteger(array('required' => false)),
      'created_at'                 => new sfValidatorDateTime(),
      'updated_at'                 => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('interment_booking[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'IntermentBooking';
  }

}
