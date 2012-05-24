<?php

/**
 * CemCemeteryFndirector form base class.
 *
 * @method CemCemeteryFndirector getObject() Returns the current form's model object
 *
 * @package    cemetery
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseCemCemeteryFndirectorForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                => new sfWidgetFormInputHidden(),
      'fnd_fndirector_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('FndFndirector'), 'add_empty' => false)),
      'cem_cemetery_id'   => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('CemCemetery'), 'add_empty' => false)),
    ));

    $this->setValidators(array(
      'id'                => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'id', 'required' => false)),
      'fnd_fndirector_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('FndFndirector'))),
      'cem_cemetery_id'   => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('CemCemetery'))),
    ));

    $this->widgetSchema->setNameFormat('cem_cemetery_fndirector[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'CemCemeteryFndirector';
  }

}
