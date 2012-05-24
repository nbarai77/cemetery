<?php

/**
 * ArGrave form.
 *
 * @package    cemetery
 * @subpackage form
 * @author     Prakash Panchal
 * @version    SVN: $Id: SummaryForm.class.php,v 1.1.1.1 2012/03/24 11:56:30 nitin Exp $
 */
sfProjectConfiguration::getActive()->loadHelpers(array('jQuery', 'Url'));
class SummaryForm extends BaseIntermentBookingForm
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
	/**
     * Function for ovrwrite parent class method.
     *
     * This function is access by admin user.
     * 
     * @access  public
     */
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
        BaseIntermentBookingForm::setWidgets(
            array(
                    'service_date'	=> new sfWidgetFormDateJQueryUI(
										array("change_month"	=> true, 
											  "change_year" 	=> true,
											  "dateFormat"		=> "dd-mm-yy",
											  "showSecond" 		=> false, 
											  'show_button_panel' => false),
										array('tabindex'=>2,'readonly'=>false))
            	));

		$this->setDefault('service_date', date('d-m-Y'));		
        $this->widgetSchema->setNameFormat('summary[%s]'); 
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
        BaseIntermentBookingForm::setValidators(
	    	array(
                  'service_date'		=> new sfValidatorString(array('required' => false, 'trim' => true))				
				 )
        );
    }
}
