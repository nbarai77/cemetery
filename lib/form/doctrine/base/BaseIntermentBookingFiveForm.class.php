<?php

/**
 * IntermentBookingFive form base class.
 *
 * @method IntermentBookingFive getObject() Returns the current form's model object
 *
 * @package    cemetery
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseIntermentBookingFiveForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                   => new sfWidgetFormInputHidden(),
      'interment_booking_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('IntermentBooking'), 'add_empty' => false)),
      'mail_content_id'      => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('MailContent'), 'add_empty' => false)),
      'status'               => new sfWidgetFormChoice(array('choices' => array('No' => 'No', 'Yes' => 'Yes'))),
      'created_at'           => new sfWidgetFormDateTime(),
      'updated_at'           => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'                   => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'id', 'required' => false)),
      'interment_booking_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('IntermentBooking'))),
      'mail_content_id'      => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('MailContent'))),
      'status'               => new sfValidatorChoice(array('choices' => array(0 => 'No', 1 => 'Yes'))),
      'created_at'           => new sfValidatorDateTime(),
      'updated_at'           => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('interment_booking_five[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'IntermentBookingFive';
  }

}
