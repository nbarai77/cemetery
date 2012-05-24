<?php

/**
 * CemTaskNotes form base class.
 *
 * @method CemTaskNotes getObject() Returns the current form's model object
 *
 * @package    cemetery
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseCemTaskNotesForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'               => new sfWidgetFormInputHidden(),
      'user_id'          => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('SfGuardUser'), 'add_empty' => false)),
      'task_title'       => new sfWidgetFormInputText(),
      'task_description' => new sfWidgetFormTextarea(),
      'entry_date'       => new sfWidgetFormDate(),
      'due_date'         => new sfWidgetFormDate(),
      'created_at'       => new sfWidgetFormDateTime(),
      'updated_at'       => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'               => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'id', 'required' => false)),
      'user_id'          => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('SfGuardUser'))),
      'task_title'       => new sfValidatorString(array('max_length' => 255)),
      'task_description' => new sfValidatorString(),
      'entry_date'       => new sfValidatorDate(array('required' => false)),
      'due_date'         => new sfValidatorDate(array('required' => false)),
      'created_at'       => new sfValidatorDateTime(),
      'updated_at'       => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('cem_task_notes[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'CemTaskNotes';
  }

}
