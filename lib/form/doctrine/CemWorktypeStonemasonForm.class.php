<?php

/**
 * CemWorktypeStonemason form.
 *
 * @package    cemetery
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: CemWorktypeStonemasonForm.class.php,v 1.1.1.1 2012/03/24 11:56:43 nitin Exp $
 */
class CemWorktypeStonemasonForm extends BaseCemWorktypeStonemasonForm
{
    /**
     * Function for ovrwrite parent class method.
     *
     * This function is access by admin user.
     * 
     * @access  public
     */
    public function setup()
    {
    }	
	
  public function configure()
  {
	  unset($this['id']);
  }
   /**
     * Function for set widgets for form elements.
     *
     * @access  public
     * @param   array   $asWidgets pass a widgets array.
     *
     */
    public function setWidgets(array $asWidgets)
    {

			
        BaseCemWorktypeStonemasonForm::setWidgets(
            array(
                    'name' => new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 1)),
                    'is_enabled'         => new MyWidgetFormInputCheckbox(array(), array('tabindex' => 1, 'value' => 1)),
            )
        );

        $this->widgetSchema->setNameFormat('cem_worktype_stonemason[%s]'); 
    }  
  
  
    /**
     * Function for set labels for form elements.
     *
     * @access  public
     * @param   array   $asLabels pass a labels array.
     *
     */
    public function setLabels($asLabels)
    {
        $this->widgetSchema->setLabels($asLabels);
    }
    /**
     * Function for set validators for form elements.
     *
     * @access  public
     * @param   array   $amValidators pass a validators array.
     *
     */
    public function setValidators(array $amValidators)
    {
        BaseCemWorktypeStonemasonForm::setValidators(
            array(
                'name'       => new sfValidatorString(array('max_length' => 255, 'required' => true, 'trim' => true),
															array('required' => $amValidators['name']['required'])	
														),
                                        
                'is_enabled'         => new sfValidatorString(
                                            array('required' => false, 'trim' => true)
                                        ),                   

            )
        );
    } 

}
