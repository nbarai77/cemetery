<?php

/**
 * LetterConfirmation form base class.
 *
 * @method LetterConfirmation getObject() Returns the current form's model object
 *
 * @package    cemetery
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseLetterConfirmationForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                        => new sfWidgetFormInputHidden(),
      'interment_booking_five_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('IntermentBookingFive'), 'add_empty' => false)),
      'mail_content_type'         => new sfWidgetFormInputText(),
      'confirmed'                 => new sfWidgetFormInputText(),
      'token'                     => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'                        => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'id', 'required' => false)),
      'interment_booking_five_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('IntermentBookingFive'))),
      'mail_content_type'         => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'confirmed'                 => new sfValidatorInteger(array('required' => false)),
      'token'                     => new sfValidatorString(array('max_length' => 255, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('letter_confirmation[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'LetterConfirmation';
  }

}
