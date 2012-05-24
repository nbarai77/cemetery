<?php

/**
 * LetterConfirmation form.
 *
 * @package    cemetery
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: LetterConfirmationForm.class.php,v 1.1.1.1 2012/03/24 11:56:37 nitin Exp $
 */
class LetterConfirmationForm extends BaseLetterConfirmationForm
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
		$this->asConfirm = array('0'=>'No','1'=>'Yes');
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
        BaseLetterConfirmationForm::setWidgets(
            array(
				'confirmed' => new sfWidgetFormChoice(array('expanded' => true, 'multiple' => false,'choices' => $this->asConfirm),array('tabindex'=>1)),
           	));
		
        $this->widgetSchema->setNameFormat('letterconfirmation[%s]');
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
        BaseLetterConfirmationForm::setValidators(
	    	array(
                'confirmed'	=> new sfValidatorString( 
                       								array('required' => false, 'trim' => true))
			)
        );
    }
}
