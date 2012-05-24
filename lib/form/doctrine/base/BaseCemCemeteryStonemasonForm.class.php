<?php

/**
 * CemCemeteryStonemason form base class.
 *
 * @method CemCemeteryStonemason getObject() Returns the current form's model object
 *
 * @package    cemetery
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseCemCemeteryStonemasonForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                => new sfWidgetFormInputHidden(),
      'cem_cemetery_id'   => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('CemCemetery'), 'add_empty' => false)),
      'cms_stonemason_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('CemStonemason'), 'add_empty' => false)),
    ));

    $this->setValidators(array(
      'id'                => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'id', 'required' => false)),
      'cem_cemetery_id'   => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('CemCemetery'))),
      'cms_stonemason_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('CemStonemason'))),
    ));

    $this->widgetSchema->setNameFormat('cem_cemetery_stonemason[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'CemCemeteryStonemason';
  }

}
