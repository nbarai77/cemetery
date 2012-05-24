<?php

/**
 * sfGuardForgotPassword form base class.
 *
 * @method sfGuardForgotPassword getObject() Returns the current form's model object
 *
 * @package    cemetery
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: BasesfGuardForgotPasswordForm.class.php,v 1.1.1.1 2012/03/24 11:56:46 nitin Exp $
 */
abstract class BasesfGuardForgotPasswordForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'         => new sfWidgetFormInputHidden(),
      'user_id'    => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('SfGuardUser'), 'add_empty' => false)),
      'unique_key' => new sfWidgetFormInputText(),
      'expires_at' => new sfWidgetFormDateTime(),
      'created_at' => new sfWidgetFormDateTime(),
      'updated_at' => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'         => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'id', 'required' => false)),
      'user_id'    => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('SfGuardUser'))),
      'unique_key' => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'expires_at' => new sfValidatorDateTime(),
      'created_at' => new sfValidatorDateTime(),
      'updated_at' => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('sf_guard_forgot_password[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'sfGuardForgotPassword';
  }

}
