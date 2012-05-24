<?php

/**
 * sArArea form base class.
 *
 * @method sArArea getObject() Returns the current form's model object
 *
 * @package    cemetery
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: BasesArAreaForm.class.php,v 1.1.1.1 2012/03/24 11:56:48 nitin Exp $
 */
abstract class BasesArAreaForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                   => new sfWidgetFormInputHidden(),
      'country_id'           => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Country'), 'add_empty' => false)),
      'cem_cemetery_id'      => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('CemCemetery'), 'add_empty' => false)),
      'area_code'            => new sfWidgetFormInputText(),
      'area_description'     => new sfWidgetFormTextarea(),
      'area_control_numberr' => new sfWidgetFormInputText(),
      'area_name'            => new sfWidgetFormInputText(),
      'area_user'            => new sfWidgetFormInputText(),
      'is_enabled'           => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'                   => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'id', 'required' => false)),
      'country_id'           => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Country'))),
      'cem_cemetery_id'      => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('CemCemetery'))),
      'area_code'            => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'area_description'     => new sfValidatorString(array('required' => false)),
      'area_control_numberr' => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'area_name'            => new sfValidatorString(array('max_length' => 50)),
      'area_user'            => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'is_enabled'           => new sfValidatorInteger(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('s_ar_area[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'sArArea';
  }

}
