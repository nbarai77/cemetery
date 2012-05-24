<?php

/**
 * IntermentBookingThree form base class.
 *
 * @method IntermentBookingThree getObject() Returns the current form's model object
 *
 * @package    cemetery
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseIntermentBookingThreeForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                             => new sfWidgetFormInputHidden(),
      'interment_booking_id'           => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('IntermentBooking'), 'add_empty' => false)),
      'file_location'                  => new sfWidgetFormInputText(),
      'cemetery_application'           => new sfWidgetFormChoice(array('choices' => array('Completed' => 'Completed', 'Pending' => 'Pending', 'NA' => 'NA'))),
      'burial_booking_form'            => new sfWidgetFormChoice(array('choices' => array('Completed' => 'Completed', 'Pending' => 'Pending', 'NA' => 'NA'))),
      'ashes_booking_form'             => new sfWidgetFormChoice(array('choices' => array('Completed' => 'Completed', 'Pending' => 'Pending', 'NA' => 'NA'))),
      'exhumation_booking_from'        => new sfWidgetFormChoice(array('choices' => array('Completed' => 'Completed', 'Pending' => 'Pending', 'NA' => 'NA'))),
      'remains_booking_from'           => new sfWidgetFormChoice(array('choices' => array('Completed' => 'Completed', 'Pending' => 'Pending', 'NA' => 'NA'))),
      'health_order'                   => new sfWidgetFormChoice(array('choices' => array('Completed' => 'Completed', 'Pending' => 'Pending', 'NA' => 'NA'))),
      'court_order'                    => new sfWidgetFormChoice(array('choices' => array('Completed' => 'Completed', 'Pending' => 'Pending', 'NA' => 'NA'))),
      'checked_fnd_details'            => new sfWidgetFormChoice(array('choices' => array('Completed' => 'Completed', 'Pending' => 'Pending', 'NA' => 'NA'))),
      'checked_owner_grave'            => new sfWidgetFormChoice(array('choices' => array('Completed' => 'Completed', 'Pending' => 'Pending', 'NA' => 'NA'))),
      'living_grave_owner'             => new sfWidgetFormChoice(array('choices' => array('Completed' => 'Completed', 'Pending' => 'Pending', 'NA' => 'NA'))),
      'deceased_grave_owner'           => new sfWidgetFormChoice(array('choices' => array('Completed' => 'Completed', 'Pending' => 'Pending', 'NA' => 'NA'))),
      'cecked_chapel_booking'          => new sfWidgetFormChoice(array('choices' => array('Completed' => 'Completed', 'Pending' => 'Pending', 'NA' => 'NA'))),
      'advised_fd_to_check'            => new sfWidgetFormChoice(array('choices' => array('Completed' => 'Completed', 'Pending' => 'Pending', 'NA' => 'NA'))),
      'advised_fd_recommended'         => new sfWidgetFormChoice(array('choices' => array('Completed' => 'Completed', 'Pending' => 'Pending', 'NA' => 'NA'))),
      'advised_fd_coffin_height'       => new sfWidgetFormChoice(array('choices' => array('Completed' => 'Completed', 'Pending' => 'Pending', 'NA' => 'NA'))),
      'medical_death_certificate'      => new sfWidgetFormChoice(array('choices' => array('Completed' => 'Completed', 'Pending' => 'Pending', 'NA' => 'NA'))),
      'medical_certificate_spelling'   => new sfWidgetFormChoice(array('choices' => array('Completed' => 'Completed', 'Pending' => 'Pending', 'NA' => 'NA'))),
      'medical_certificate_infectious' => new sfWidgetFormChoice(array('choices' => array('Completed' => 'Completed', 'Pending' => 'Pending', 'NA' => 'NA'))),
      'request_probe_reopen'           => new sfWidgetFormChoice(array('choices' => array('Completed' => 'Completed', 'Pending' => 'Pending', 'NA' => 'NA'))),
      'request_triple_depth_reopen'    => new sfWidgetFormChoice(array('choices' => array('Completed' => 'Completed', 'Pending' => 'Pending', 'NA' => 'NA'))),
      'checked_monumental'             => new sfWidgetFormChoice(array('choices' => array('Completed' => 'Completed', 'Pending' => 'Pending', 'NA' => 'NA'))),
      'contacted_stonemason'           => new sfWidgetFormChoice(array('choices' => array('Completed' => 'Completed', 'Pending' => 'Pending', 'NA' => 'NA'))),
      'checked_accessories'            => new sfWidgetFormChoice(array('choices' => array('Completed' => 'Completed', 'Pending' => 'Pending', 'NA' => 'NA'))),
      'balloons_na'                    => new sfWidgetFormChoice(array('choices' => array('Completed' => 'Completed', 'Pending' => 'Pending', 'NA' => 'NA'))),
      'burning_drum'                   => new sfWidgetFormChoice(array('choices' => array('Completed' => 'Completed', 'Pending' => 'Pending', 'NA' => 'NA'))),
      'canopy'                         => new sfWidgetFormChoice(array('choices' => array('Completed' => 'Completed', 'Pending' => 'Pending', 'NA' => 'NA'))),
      'ceremonial_sand_bucket'         => new sfWidgetFormChoice(array('choices' => array('Completed' => 'Completed', 'Pending' => 'Pending', 'NA' => 'NA'))),
      'fireworks'                      => new sfWidgetFormChoice(array('choices' => array('Completed' => 'Completed', 'Pending' => 'Pending', 'NA' => 'NA'))),
      'lowering_device'                => new sfWidgetFormChoice(array('choices' => array('Completed' => 'Completed', 'Pending' => 'Pending', 'NA' => 'NA'))),
      'checked_returned_signed'        => new sfWidgetFormChoice(array('choices' => array('Completed' => 'Completed', 'Pending' => 'Pending', 'NA' => 'NA'))),
      'check_coffin_sizes_surcharge'   => new sfWidgetFormChoice(array('choices' => array('Completed' => 'Completed', 'Pending' => 'Pending', 'NA' => 'NA'))),
      'surcharge_applied'              => new sfWidgetFormChoice(array('choices' => array('Completed' => 'Completed', 'Pending' => 'Pending', 'NA' => 'NA'))),
      'compare_burial_booking'         => new sfWidgetFormChoice(array('choices' => array('Completed' => 'Completed', 'Pending' => 'Pending', 'NA' => 'NA'))),
      'for_between_burials'            => new sfWidgetFormChoice(array('choices' => array('Completed' => 'Completed', 'Pending' => 'Pending', 'NA' => 'NA'))),
      'double_check_yellow_date'       => new sfWidgetFormChoice(array('choices' => array('Completed' => 'Completed', 'Pending' => 'Pending', 'NA' => 'NA'))),
      'other'                          => new sfWidgetFormTextarea(),
      'created_at'                     => new sfWidgetFormDateTime(),
      'updated_at'                     => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'                             => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'id', 'required' => false)),
      'interment_booking_id'           => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('IntermentBooking'))),
      'file_location'                  => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'cemetery_application'           => new sfValidatorChoice(array('choices' => array(0 => 'Completed', 1 => 'Pending', 2 => 'NA'), 'required' => false)),
      'burial_booking_form'            => new sfValidatorChoice(array('choices' => array(0 => 'Completed', 1 => 'Pending', 2 => 'NA'), 'required' => false)),
      'ashes_booking_form'             => new sfValidatorChoice(array('choices' => array(0 => 'Completed', 1 => 'Pending', 2 => 'NA'), 'required' => false)),
      'exhumation_booking_from'        => new sfValidatorChoice(array('choices' => array(0 => 'Completed', 1 => 'Pending', 2 => 'NA'), 'required' => false)),
      'remains_booking_from'           => new sfValidatorChoice(array('choices' => array(0 => 'Completed', 1 => 'Pending', 2 => 'NA'), 'required' => false)),
      'health_order'                   => new sfValidatorChoice(array('choices' => array(0 => 'Completed', 1 => 'Pending', 2 => 'NA'), 'required' => false)),
      'court_order'                    => new sfValidatorChoice(array('choices' => array(0 => 'Completed', 1 => 'Pending', 2 => 'NA'), 'required' => false)),
      'checked_fnd_details'            => new sfValidatorChoice(array('choices' => array(0 => 'Completed', 1 => 'Pending', 2 => 'NA'), 'required' => false)),
      'checked_owner_grave'            => new sfValidatorChoice(array('choices' => array(0 => 'Completed', 1 => 'Pending', 2 => 'NA'), 'required' => false)),
      'living_grave_owner'             => new sfValidatorChoice(array('choices' => array(0 => 'Completed', 1 => 'Pending', 2 => 'NA'), 'required' => false)),
      'deceased_grave_owner'           => new sfValidatorChoice(array('choices' => array(0 => 'Completed', 1 => 'Pending', 2 => 'NA'), 'required' => false)),
      'cecked_chapel_booking'          => new sfValidatorChoice(array('choices' => array(0 => 'Completed', 1 => 'Pending', 2 => 'NA'), 'required' => false)),
      'advised_fd_to_check'            => new sfValidatorChoice(array('choices' => array(0 => 'Completed', 1 => 'Pending', 2 => 'NA'), 'required' => false)),
      'advised_fd_recommended'         => new sfValidatorChoice(array('choices' => array(0 => 'Completed', 1 => 'Pending', 2 => 'NA'), 'required' => false)),
      'advised_fd_coffin_height'       => new sfValidatorChoice(array('choices' => array(0 => 'Completed', 1 => 'Pending', 2 => 'NA'), 'required' => false)),
      'medical_death_certificate'      => new sfValidatorChoice(array('choices' => array(0 => 'Completed', 1 => 'Pending', 2 => 'NA'), 'required' => false)),
      'medical_certificate_spelling'   => new sfValidatorChoice(array('choices' => array(0 => 'Completed', 1 => 'Pending', 2 => 'NA'), 'required' => false)),
      'medical_certificate_infectious' => new sfValidatorChoice(array('choices' => array(0 => 'Completed', 1 => 'Pending', 2 => 'NA'), 'required' => false)),
      'request_probe_reopen'           => new sfValidatorChoice(array('choices' => array(0 => 'Completed', 1 => 'Pending', 2 => 'NA'), 'required' => false)),
      'request_triple_depth_reopen'    => new sfValidatorChoice(array('choices' => array(0 => 'Completed', 1 => 'Pending', 2 => 'NA'), 'required' => false)),
      'checked_monumental'             => new sfValidatorChoice(array('choices' => array(0 => 'Completed', 1 => 'Pending', 2 => 'NA'), 'required' => false)),
      'contacted_stonemason'           => new sfValidatorChoice(array('choices' => array(0 => 'Completed', 1 => 'Pending', 2 => 'NA'), 'required' => false)),
      'checked_accessories'            => new sfValidatorChoice(array('choices' => array(0 => 'Completed', 1 => 'Pending', 2 => 'NA'), 'required' => false)),
      'balloons_na'                    => new sfValidatorChoice(array('choices' => array(0 => 'Completed', 1 => 'Pending', 2 => 'NA'), 'required' => false)),
      'burning_drum'                   => new sfValidatorChoice(array('choices' => array(0 => 'Completed', 1 => 'Pending', 2 => 'NA'), 'required' => false)),
      'canopy'                         => new sfValidatorChoice(array('choices' => array(0 => 'Completed', 1 => 'Pending', 2 => 'NA'), 'required' => false)),
      'ceremonial_sand_bucket'         => new sfValidatorChoice(array('choices' => array(0 => 'Completed', 1 => 'Pending', 2 => 'NA'), 'required' => false)),
      'fireworks'                      => new sfValidatorChoice(array('choices' => array(0 => 'Completed', 1 => 'Pending', 2 => 'NA'), 'required' => false)),
      'lowering_device'                => new sfValidatorChoice(array('choices' => array(0 => 'Completed', 1 => 'Pending', 2 => 'NA'), 'required' => false)),
      'checked_returned_signed'        => new sfValidatorChoice(array('choices' => array(0 => 'Completed', 1 => 'Pending', 2 => 'NA'), 'required' => false)),
      'check_coffin_sizes_surcharge'   => new sfValidatorChoice(array('choices' => array(0 => 'Completed', 1 => 'Pending', 2 => 'NA'), 'required' => false)),
      'surcharge_applied'              => new sfValidatorChoice(array('choices' => array(0 => 'Completed', 1 => 'Pending', 2 => 'NA'), 'required' => false)),
      'compare_burial_booking'         => new sfValidatorChoice(array('choices' => array(0 => 'Completed', 1 => 'Pending', 2 => 'NA'), 'required' => false)),
      'for_between_burials'            => new sfValidatorChoice(array('choices' => array(0 => 'Completed', 1 => 'Pending', 2 => 'NA'), 'required' => false)),
      'double_check_yellow_date'       => new sfValidatorChoice(array('choices' => array(0 => 'Completed', 1 => 'Pending', 2 => 'NA'), 'required' => false)),
      'other'                          => new sfValidatorString(array('required' => false)),
      'created_at'                     => new sfValidatorDateTime(),
      'updated_at'                     => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('interment_booking_three[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'IntermentBookingThree';
  }

}
