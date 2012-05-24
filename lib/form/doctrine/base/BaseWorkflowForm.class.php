<?php

/**
 * Workflow form base class.
 *
 * @method Workflow getObject() Returns the current form's model object
 *
 * @package    cemetery
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseWorkflowForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                    => new sfWidgetFormInputHidden(),
      'country_id'            => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Country'), 'add_empty' => false)),
      'cem_cemetery_id'       => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('CemCemetery'), 'add_empty' => false)),
      'ar_area_id'            => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('ArArea'), 'add_empty' => true)),
      'ar_section_id'         => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('ArSection'), 'add_empty' => true)),
      'ar_row_id'             => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('ArRow'), 'add_empty' => true)),
      'ar_plot_id'            => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('ArPlot'), 'add_empty' => true)),
      'ar_grave_id'           => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('ArGrave'), 'add_empty' => true)),
      'work_date'             => new sfWidgetFormDate(),
      'title'                 => new sfWidgetFormInputText(),
      'name'                  => new sfWidgetFormInputText(),
      'surname'               => new sfWidgetFormInputText(),
      'email'                 => new sfWidgetFormInputText(),
      'area_code'             => new sfWidgetFormInputText(),
      'telephone'             => new sfWidgetFormInputText(),
      'department_delegation' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('DepartmentDelegation'), 'add_empty' => true)),
      'work_description'      => new sfWidgetFormTextarea(),
      'completed_by'          => new sfWidgetFormInputText(),
      'completion_date'       => new sfWidgetFormDate(),
      'action_taken'          => new sfWidgetFormTextarea(),
      'feed_charges'          => new sfWidgetFormInputText(),
      'receipt_number'        => new sfWidgetFormInputText(),
      'created_at'            => new sfWidgetFormDateTime(),
      'updated_at'            => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'                    => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'id', 'required' => false)),
      'country_id'            => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Country'))),
      'cem_cemetery_id'       => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('CemCemetery'))),
      'ar_area_id'            => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('ArArea'), 'required' => false)),
      'ar_section_id'         => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('ArSection'), 'required' => false)),
      'ar_row_id'             => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('ArRow'), 'required' => false)),
      'ar_plot_id'            => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('ArPlot'), 'required' => false)),
      'ar_grave_id'           => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('ArGrave'), 'required' => false)),
      'work_date'             => new sfValidatorDate(array('required' => false)),
      'title'                 => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'name'                  => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'surname'               => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'email'                 => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'area_code'             => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'telephone'             => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'department_delegation' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('DepartmentDelegation'), 'required' => false)),
      'work_description'      => new sfValidatorString(array('required' => false)),
      'completed_by'          => new sfValidatorInteger(array('required' => false)),
      'completion_date'       => new sfValidatorDate(array('required' => false)),
      'action_taken'          => new sfValidatorString(array('required' => false)),
      'feed_charges'          => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'receipt_number'        => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'created_at'            => new sfValidatorDateTime(),
      'updated_at'            => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('workflow[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Workflow';
  }

}
