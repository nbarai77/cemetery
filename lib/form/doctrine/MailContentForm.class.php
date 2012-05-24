<?php

/**
 * MailContent form.
 *
 * @package    cemetery
 * @subpackage form
 * @author     Prakash Panchal
 * @version    SVN: $Id: MailContentForm.class.php,v 1.1.1.1 2012/03/24 11:56:41 nitin Exp $
 */
class MailContentForm extends BaseMailContentForm
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
        BaseMailContentForm::setWidgets(
            array(
					'subject' 			=> new sfWidgetFormInputText(array(), array('style' => 'width:530px','tabindex'=> 1)),
					'content' 			=> new sfWidgetFormCKEditor(array('jsoptions'=>array('param' => 'value')),array('tabindex'=> 2))
	            )
        );
        $this->widgetSchema->setNameFormat('mailcontent[%s]'); 
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
        BaseMailContentForm::setValidators(
            array(                   
				'subject'			=> new sfValidatorString(
											array('required' => true, 'trim' => true),
											array('required' => $amValidators['subject']['required'])
										   ),
				'content'				=> new sfValidatorString(
											array('required' => false, 'trim' => true),
											array('required' => $amValidators['content']['required'])
										   )
            )
        );
    } 
}
