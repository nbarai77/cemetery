<?php

/**
 * IntermentBookingDocs form base class.
 *
 * @method IntermentBookingDocs getObject() Returns the current form's model object
 *
 * @package    cemetery
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseIntermentBookingDocsForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                   => new sfWidgetFormInputHidden(),
      'interment_booking_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('IntermentBooking'), 'add_empty' => false)),
      'file_name'            => new sfWidgetFormInputText(),
      'file_path'            => new sfWidgetFormInputText(),
      'file_description'     => new sfWidgetFormTextarea(),
      'expiry_date'          => new sfWidgetFormDate(),
      'created_at'           => new sfWidgetFormDateTime(),
      'updated_at'           => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'                   => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'id', 'required' => false)),
      'interment_booking_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('IntermentBooking'))),
      'file_name'            => new sfValidatorString(array('max_length' => 255)),
      'file_path'            => new sfValidatorString(array('max_length' => 255)),
      'file_description'     => new sfValidatorString(array('required' => false)),
      'expiry_date'          => new sfValidatorDate(array('required' => false)),
      'created_at'           => new sfValidatorDateTime(),
      'updated_at'           => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('interment_booking_docs[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'IntermentBookingDocs';
  }

}
