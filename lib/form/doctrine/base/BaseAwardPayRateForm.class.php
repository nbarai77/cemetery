<?php

/**
 * AwardPayRate form base class.
 *
 * @method AwardPayRate getObject() Returns the current form's model object
 *
 * @package    cemetery
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseAwardPayRateForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                => new sfWidgetFormInputHidden(),
      'id_award'          => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Award'), 'add_empty' => false)),
      'overtime_hrs'      => new sfWidgetFormTime(),
      'overtime_pay_rate' => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'                => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'id', 'required' => false)),
      'id_award'          => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Award'))),
      'overtime_hrs'      => new sfValidatorTime(),
      'overtime_pay_rate' => new sfValidatorInteger(),
    ));

    $this->widgetSchema->setNameFormat('award_pay_rate[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'AwardPayRate';
  }

}
