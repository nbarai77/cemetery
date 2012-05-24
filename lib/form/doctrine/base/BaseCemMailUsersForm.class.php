<?php

/**
 * CemMailUsers form base class.
 *
 * @method CemMailUsers getObject() Returns the current form's model object
 *
 * @package    cemetery
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseCemMailUsersForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                 => new sfWidgetFormInputHidden(),
      'cem_mail_id'        => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('CemMail'), 'add_empty' => false)),
      'from_user_id'       => new sfWidgetFormInputText(),
      'to_user_id'         => new sfWidgetFormInputText(),
      'to_email'           => new sfWidgetFormInputText(),
      'sent_status'        => new sfWidgetFormInputText(),
      'read_unread_status' => new sfWidgetFormInputText(),
      'delete_status'      => new sfWidgetFormInputText(),
      'mail_send_status'   => new sfWidgetFormInputText(),
      'created_at'         => new sfWidgetFormDateTime(),
      'updated_at'         => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'                 => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'id', 'required' => false)),
      'cem_mail_id'        => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('CemMail'))),
      'from_user_id'       => new sfValidatorInteger(),
      'to_user_id'         => new sfValidatorInteger(array('required' => false)),
      'to_email'           => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'sent_status'        => new sfValidatorInteger(array('required' => false)),
      'read_unread_status' => new sfValidatorInteger(array('required' => false)),
      'delete_status'      => new sfValidatorInteger(array('required' => false)),
      'mail_send_status'   => new sfValidatorInteger(array('required' => false)),
      'created_at'         => new sfValidatorDateTime(),
      'updated_at'         => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('cem_mail_users[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'CemMailUsers';
  }

}
