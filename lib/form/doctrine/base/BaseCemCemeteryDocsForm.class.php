<?php

/**
 * CemCemeteryDocs form base class.
 *
 * @method CemCemeteryDocs getObject() Returns the current form's model object
 *
 * @package    cemetery
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseCemCemeteryDocsForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'              => new sfWidgetFormInputHidden(),
      'cem_cemetery_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('CemCemetery'), 'add_empty' => false)),
      'doc_name'        => new sfWidgetFormInputText(),
      'doc_description' => new sfWidgetFormTextarea(),
      'doc_path'        => new sfWidgetFormInputText(),
      'created_at'      => new sfWidgetFormDateTime(),
      'updated_at'      => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'              => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'id', 'required' => false)),
      'cem_cemetery_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('CemCemetery'))),
      'doc_name'        => new sfValidatorString(array('max_length' => 255)),
      'doc_description' => new sfValidatorString(array('required' => false)),
      'doc_path'        => new sfValidatorString(array('max_length' => 255)),
      'created_at'      => new sfValidatorDateTime(),
      'updated_at'      => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('cem_cemetery_docs[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'CemCemeteryDocs';
  }

}
