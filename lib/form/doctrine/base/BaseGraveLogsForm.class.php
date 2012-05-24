<?php

/**
 * GraveLogs form base class.
 *
 * @method GraveLogs getObject() Returns the current form's model object
 *
 * @package    cemetery
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseGraveLogsForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'             => new sfWidgetFormInputHidden(),
      'user_id'        => new sfWidgetFormInputText(),
      'cem_id'         => new sfWidgetFormInputText(),
      'country_name'   => new sfWidgetFormInputText(),
      'cem_name'       => new sfWidgetFormInputText(),
      'area_name'      => new sfWidgetFormInputText(),
      'section_name'   => new sfWidgetFormInputText(),
      'row_name'       => new sfWidgetFormInputText(),
      'plot_name'      => new sfWidgetFormInputText(),
      'grave_number'   => new sfWidgetFormInputText(),
      'operation'      => new sfWidgetFormInputText(),
      'operation_date' => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'             => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'id', 'required' => false)),
      'user_id'        => new sfValidatorInteger(array('required' => false)),
      'cem_id'         => new sfValidatorInteger(array('required' => false)),
      'country_name'   => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'cem_name'       => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'area_name'      => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'section_name'   => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'row_name'       => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'plot_name'      => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'grave_number'   => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'operation'      => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'operation_date' => new sfValidatorDateTime(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('grave_logs[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'GraveLogs';
  }

}
