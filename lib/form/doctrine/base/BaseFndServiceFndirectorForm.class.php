<?php

/**
 * FndServiceFndirector form base class.
 *
 * @method FndServiceFndirector getObject() Returns the current form's model object
 *
 * @package    cemetery
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseFndServiceFndirectorForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                => new sfWidgetFormInputHidden(),
      'fnd_fndirector_id' => new sfWidgetFormInputText(),
      'fnd_service_id'    => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('FndService'), 'add_empty' => false)),
    ));

    $this->setValidators(array(
      'id'                => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'id', 'required' => false)),
      'fnd_fndirector_id' => new sfValidatorInteger(),
      'fnd_service_id'    => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('FndService'))),
    ));

    $this->widgetSchema->setNameFormat('fnd_service_fndirector[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'FndServiceFndirector';
  }

}
