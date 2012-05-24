<?php

/**
 * SendLetters form.
 *
 * @package    cemetery
 * @subpackage form
 * @author     Prakash Panchal
 * @version    SVN: $Id: SendLettersForm.class.php,v 1.1.1.1 2012/03/24 11:56:22 nitin Exp $
 */
sfProjectConfiguration::getActive()->loadHelpers(array('jQuery', 'Url'));
class SendLettersForm extends sfForm
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
        sfForm::setWidgets(
            array(
                    'mail_to' 				=> new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 1)),
					'mail_subject' 			=> new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 2)),
					'mail_body' 			=> new sfWidgetFormCKEditor(array('jsoptions'=>array('param' => 'value')),array('tabindex'=> 3)),
					'attachment' 			=> new sfWidgetFormInputFile(array(),array('tabindex'=> 4))
	            )
        );
        $this->widgetSchema->setNameFormat('cemmail[%s]'); 
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
        sfForm::setValidators(
            array(                   
				'mail_to'				=> new sfValidatorEmail(
											array('required' => true, 'trim' => true),
											array('required' => $amValidators['mail_to']['required'],'invalid' => $amValidators['mail_to']['invalid'])
										),
				'mail_subject'			=> new sfValidatorString(
											array('required' => true, 'trim' => true),
											array('required' => $amValidators['mail_subject']['required'])
										   ),
				'mail_body'				=> new sfValidatorString(
											array('required' => true, 'trim' => true),
											array('required' => $amValidators['mail_body']['required'])
										   ),
				'attachment'      		 => new sfValidatorFile(
                                                    array('required' => false, 'trim' => true)
                                                )
            )
        );
    } 
}
