<?php

/**
 * GranteeGraveHistory form base class.
 *
 * @method GranteeGraveHistory getObject() Returns the current form's model object
 *
 * @package    cemetery
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseGranteeGraveHistoryForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                           => new sfWidgetFormInputHidden(),
      'grantee_details_id'           => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('GranteeDetails'), 'add_empty' => false)),
      'grantee_details_surrender_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('GranteeDetails_3'), 'add_empty' => false)),
      'ar_grave_id'                  => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('ArGrave'), 'add_empty' => false)),
      'catalog_id'                   => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Catalog'), 'add_empty' => true)),
      'payment_id'                   => new sfWidgetFormInputText(),
      'surrender_date'               => new sfWidgetFormDate(),
      'transfer_cost'                => new sfWidgetFormInputText(),
      'receipt_number'               => new sfWidgetFormInputText(),
      'created_at'                   => new sfWidgetFormDateTime(),
      'updated_at'                   => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'                           => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'id', 'required' => false)),
      'grantee_details_id'           => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('GranteeDetails'))),
      'grantee_details_surrender_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('GranteeDetails_3'))),
      'ar_grave_id'                  => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('ArGrave'))),
      'catalog_id'                   => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Catalog'), 'required' => false)),
      'payment_id'                   => new sfValidatorInteger(array('required' => false)),
      'surrender_date'               => new sfValidatorDate(),
      'transfer_cost'                => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'receipt_number'               => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'created_at'                   => new sfValidatorDateTime(),
      'updated_at'                   => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('grantee_grave_history[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'GranteeGraveHistory';
  }

}
