<?php

/**
 * IntermentBookingLogs form base class.
 *
 * @method IntermentBookingLogs getObject() Returns the current form's model object
 *
 * @package    cemetery
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseIntermentBookingLogsForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'               => new sfWidgetFormInputHidden(),
      'user_id'          => new sfWidgetFormInputText(),
      'cem_id'           => new sfWidgetFormInputText(),
      'country'          => new sfWidgetFormInputText(),
      'cem_name'         => new sfWidgetFormInputText(),
      'area'             => new sfWidgetFormInputText(),
      'section'          => new sfWidgetFormInputText(),
      'row'              => new sfWidgetFormInputText(),
      'plot'             => new sfWidgetFormInputText(),
      'grave'            => new sfWidgetFormInputText(),
      'grantee'          => new sfWidgetFormInputText(),
      'operation'        => new sfWidgetFormInputText(),
      'operation_date'   => new sfWidgetFormDateTime(),
      'deceased_surname' => new sfWidgetFormInputText(),
      'deceased_name'    => new sfWidgetFormInputText(),
      'status'           => new sfWidgetFormInputText(),
      'service_type'     => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'               => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'id', 'required' => false)),
      'user_id'          => new sfValidatorInteger(array('required' => false)),
      'cem_id'           => new sfValidatorInteger(array('required' => false)),
      'country'          => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'cem_name'         => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'area'             => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'section'          => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'row'              => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'plot'             => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'grave'            => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'grantee'          => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'operation'        => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'operation_date'   => new sfValidatorDateTime(array('required' => false)),
      'deceased_surname' => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'deceased_name'    => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'status'           => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'service_type'     => new sfValidatorString(array('max_length' => 255, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('interment_booking_logs[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'IntermentBookingLogs';
  }

}
