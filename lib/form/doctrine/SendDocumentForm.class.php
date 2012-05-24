<?php

/**
 * Send Document form.
 *
 * @package    cemetery
 * @subpackage form
 * @author     Prakash Panchal
 * @version    SVN: $Id: SendDocumentForm.class.php,v 1.1.1.1 2012/03/24 11:56:32 nitin Exp $
 */
class SendDocumentForm extends sfForm
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
		$this->snCemeteryId = sfContext::getInstance()->getRequest()->getParameter('cemetery_id','');
		$this->ssFilename = sfContext::getInstance()->getRequest()->getParameter('filename','');
		
		$asPostData = sfContext::getInstance()->getRequest()->getParameter('sendocs');
		$this->snCemeteryId = (sfContext::getInstance()->getUser()->getAttribute('cemeteryid') != '') ? sfContext::getInstance()->getUser()->getAttribute('cemeteryid') : ((isset($asPostData['cemetery_id'])) ? $asPostData['cemetery_id'] : $this->snCemeteryId);
		$this->ssFilename = ($this->ssFilename != '') ? $this->ssFilename : ((isset($asPostData['filename'])) ? $asPostData['filename'] : $this->ssFilename);
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
                    'mail_to' => new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 1)),
					'mail_subject' => new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 2)),
					'mail_body' => new sfWidgetFormCKEditor(array('jsoptions'=>array('param' => 'value')),array('tabindex'=> 3)),
					'cemetery_id' => new sfWidgetFormInputHidden(array(), array('value' => $this->snCemeteryId,'readonly' => 'true')),
					'filename' => new sfWidgetFormInputHidden(array(), array('value' => $this->ssFilename,'readonly' => 'true')),
	            )
        );
		$this->setDefault('cemetery_id',$this->snCemeteryId);
		$this->setDefault('filename',$this->ssFilename);
        $this->widgetSchema->setNameFormat('sendocs[%s]'); 
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
                'mail_to'		=> new sfValidatorEmail(
										array('required' => true, 'trim' => true),
										array('required' => $amValidators['mail_to']['required'],'invalid' => $amValidators['mail_to']['invalid'])
									),
				'mail_subject'	=> new sfValidatorString(
										array('required' => true, 'trim' => true),
										array('required' => $amValidators['mail_subject']['required'])
                                       ),
				'mail_body'		=> new sfValidatorString(
										array('required' => true, 'trim' => true),
										array('required' => $amValidators['mail_body']['required'])
                                       ),
				'cemetery_id'	=> new sfValidatorString( 
										array('required' => false, 'trim' => true)
										),
				'filename'		=> new sfValidatorString( 
										array('required' => false, 'trim' => true)
										)
            )
        );
    } 
}
