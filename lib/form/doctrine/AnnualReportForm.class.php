<?php

/**
 * AnnualReport form.
 *
 * @package    cemetery
 * @subpackage AnnualReport Form
 * @author     Prakash Panchal
 * @version    SVN: $Id: AnnualReportForm.class.php,v 1.1.1.1 2012/03/24 11:56:40 nitin Exp $
 */
sfProjectConfiguration::getActive()->loadHelpers(array('jQuery', 'Url'));
class AnnualReportForm extends BaseIntermentBookingForm
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
                    'from_date'	=> new sfWidgetFormDateJQueryUI(
										array("change_month"	=> true, 
											  "change_year" 	=> true,
											  "dateFormat"		=> "dd-mm-yy",
											  "showSecond" 		=> false, 
											  'show_button_panel' => false),
										array('tabindex'=>1,'readonly'=>false)),
                    'to_date'	=> new sfWidgetFormDateJQueryUI(
										array("change_month"	=> true, 
											  "change_year" 	=> true,
											  "dateFormat"		=> "dd-mm-yy",
											  "showSecond" 		=> false, 
											  'show_button_panel' => false),
										array('tabindex'=>2,'readonly'=>false)),
            	));
        $this->widgetSchema->setNameFormat('annualreport[%s]'); 
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
                  'from_date'	=> new sfValidatorString(array('required' => false, 'trim' => true)),
                  'to_date'		=> new sfValidatorString(array('required' => false, 'trim' => true)),
				 )
        );
    }
}
