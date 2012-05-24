<?php

/**
 * CemMail form base class.
 *
 * @method CemMail getObject() Returns the current form's model object
 *
 * @package    cemetery
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseCemMailForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                 => new sfWidgetFormInputHidden(),
      'mail_subject'       => new sfWidgetFormInputText(),
      'mail_body'          => new sfWidgetFormTextarea(),
      'attached_file_name' => new sfWidgetFormInputText(),
      'mail_status'        => new sfWidgetFormInputText(),
      'created_at'         => new sfWidgetFormDateTime(),
      'updated_at'         => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'                 => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'id', 'required' => false)),
      'mail_subject'       => new sfValidatorString(array('max_length' => 255)),
      'mail_body'          => new sfValidatorString(array('required' => false)),
      'attached_file_name' => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'mail_status'        => new sfValidatorInteger(array('required' => false)),
      'created_at'         => new sfValidatorDateTime(),
      'updated_at'         => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('cem_mail[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'CemMail';
  }

}
