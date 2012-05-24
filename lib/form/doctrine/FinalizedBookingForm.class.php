<?php

/**
 * Finalized Booking form.
 *
 * @package    cemetery
 * @subpackage form
 * @author     Prakash Panchal
 * @version    SVN: $Id: FinalizedBookingForm.class.php,v 1.1.1.1 2012/03/24 11:56:37 nitin Exp $
 */
class FinalizedBookingForm extends sfForm
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
					'control_number'         => new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 1)),
                    'interment_date'         => new sfWidgetFormDateJQueryUI(
												array("change_month"	=> true, 
													  "change_year" 	=> true,
													  "dateFormat"		=> "dd-mm-yy",
													  "showSecond" 		=> false, 
													  'show_button_panel' => false),
												array('tabindex'=>2,'readonly'=>false)),
	            )
        );
        $this->widgetSchema->setNameFormat('finalizedbooking[%s]'); 
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
				'control_number'	=> new sfValidatorString( 
                       								array('required' => true, 'trim' => true),
                       								array('required' => $amValidators['control_number']['required'])
												),                 
				'interment_date'	=> new sfValidatorString( 
										array('required' => false, 'trim' => true))
            )
        );
    } 
}
