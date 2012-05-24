<?php

/**
 * SfGuardGroupPermission form base class.
 *
 * @method SfGuardGroupPermission getObject() Returns the current form's model object
 *
 * @package    cemetery
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: BaseSfGuardGroupPermissionForm.class.php,v 1.1.1.1 2012/03/24 11:56:50 nitin Exp $
 */
abstract class BaseSfGuardGroupPermissionForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'group_id'      => new sfWidgetFormInputHidden(),
      'permission_id' => new sfWidgetFormInputHidden(),
      'created_at'    => new sfWidgetFormDateTime(),
      'updated_at'    => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'group_id'      => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'group_id', 'required' => false)),
      'permission_id' => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'permission_id', 'required' => false)),
      'created_at'    => new sfValidatorDateTime(),
      'updated_at'    => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('sf_guard_group_permission[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'SfGuardGroupPermission';
  }

}
