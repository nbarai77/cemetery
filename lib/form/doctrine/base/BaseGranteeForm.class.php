<?php

/**
 * Grantee form base class.
 *
 * @method Grantee getObject() Returns the current form's model object
 *
 * @package    cemetery
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseGranteeForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                      => new sfWidgetFormInputHidden(),
      'grantee_details_id'      => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('GranteeDetails'), 'add_empty' => false)),
      'country_id'              => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Country'), 'add_empty' => false)),
      'cem_cemetery_id'         => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('CemCemetery'), 'add_empty' => false)),
      'ar_area_id'              => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('ArArea'), 'add_empty' => true)),
      'ar_section_id'           => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('ArSection'), 'add_empty' => true)),
      'ar_row_id'               => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('ArRow'), 'add_empty' => true)),
      'ar_plot_id'              => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('ArPlot'), 'add_empty' => true)),
      'ar_grave_id'             => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('ArGrave'), 'add_empty' => false)),
      'ar_grave_status_id'      => new sfWidgetFormInputText(),
      'fnd_fndirector_id'       => new sfWidgetFormInputText(),
      'grantee_identity_id'     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('GranteeIdentity'), 'add_empty' => true)),
      'catalog_id'              => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Catalog'), 'add_empty' => true)),
      'payment_id'              => new sfWidgetFormInputText(),
      'grantee_identity_number' => new sfWidgetFormInputText(),
      'receipt_number'          => new sfWidgetFormInputText(),
      'control_number'          => new sfWidgetFormInputText(),
      'invoice_number'          => new sfWidgetFormInputText(),
      'date_of_purchase'        => new sfWidgetFormDate(),
      'cost'                    => new sfWidgetFormInputText(),
      'tenure_expiry_date'      => new sfWidgetFormDate(),
      'user_id'                 => new sfWidgetFormInputText(),
      'created_at'              => new sfWidgetFormDateTime(),
      'updated_at'              => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'                      => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'id', 'required' => false)),
      'grantee_details_id'      => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('GranteeDetails'))),
      'country_id'              => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Country'))),
      'cem_cemetery_id'         => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('CemCemetery'))),
      'ar_area_id'              => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('ArArea'), 'required' => false)),
      'ar_section_id'           => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('ArSection'), 'required' => false)),
      'ar_row_id'               => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('ArRow'), 'required' => false)),
      'ar_plot_id'              => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('ArPlot'), 'required' => false)),
      'ar_grave_id'             => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('ArGrave'))),
      'ar_grave_status_id'      => new sfValidatorInteger(array('required' => false)),
      'fnd_fndirector_id'       => new sfValidatorInteger(array('required' => false)),
      'grantee_identity_id'     => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('GranteeIdentity'), 'required' => false)),
      'catalog_id'              => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Catalog'), 'required' => false)),
      'payment_id'              => new sfValidatorInteger(array('required' => false)),
      'grantee_identity_number' => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'receipt_number'          => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'control_number'          => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'invoice_number'          => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'date_of_purchase'        => new sfValidatorDate(array('required' => false)),
      'cost'                    => new sfValidatorInteger(array('required' => false)),
      'tenure_expiry_date'      => new sfValidatorDate(array('required' => false)),
      'user_id'                 => new sfValidatorInteger(array('required' => false)),
      'created_at'              => new sfValidatorDateTime(),
      'updated_at'              => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('grantee[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Grantee';
  }

}
