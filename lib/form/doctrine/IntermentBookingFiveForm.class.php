<?php

/**
 * IntermentBookingThree form.
 *
 * @package    cemetery
 * @subpackage form
 * @author     Prakash Panchal
 * @version    SVN: $Id: IntermentBookingFiveForm.class.php,v 1.1.1.1 2012/03/24 11:56:41 nitin Exp $
 */

class IntermentBookingFiveForm extends BaseIntermentBookingFiveForm
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
		unset($this['id'],$this['cost']);		
		$this->asCommonStatus = array('1' => 'Print', '2' => 'Email', '0' => 'None');
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
        BaseIntermentBookingFiveForm::setWidgets(
            array(
	      	'new_grave_inscription'							=> new sfWidgetFormChoice(array('expanded' => true, 'multiple' => false,'choices' => $this->asCommonStatus),
																					  array('tabindex'=> 1)),
			'new_grave_monumental_and_monumental_lawn'		=> new sfWidgetFormChoice(array('expanded' => true, 'multiple' => false,'choices' => $this->asCommonStatus),
																								  array('tabindex'=> 2)),
			'ov_ro_inscription_only'						=> new sfWidgetFormChoice(array('expanded' => true, 'multiple' => false,'choices' => $this->asCommonStatus),
																								  array('tabindex'=> 3)),
			'ov_ro_inscription_only_and_transfer_fee'		=> new sfWidgetFormChoice(array('expanded' => true, 'multiple' => false,'choices' => $this->asCommonStatus),
																								  array('tabindex'=> 4)),
			'ov_ro_inscription_only_transfer_nofee'			=> new sfWidgetFormChoice(array('expanded' => true, 'multiple' => false,'choices' => $this->asCommonStatus),
																								  array('tabindex'=> 5)),
			'ov_ro_monumental_letter_only'					=> new sfWidgetFormChoice(array('expanded' => true, 'multiple' => false,'choices' => $this->asCommonStatus),
																								  array('tabindex'=> 6)),
			'ov_ro_monumental_letter_only_fee'				=> new sfWidgetFormChoice(array('expanded' => true, 'multiple' => false,'choices' => $this->asCommonStatus),
																								  array('tabindex'=> 7)),
			'ov_ro_monumental_letter_only_nofee'			=> new sfWidgetFormChoice(array('expanded' => true, 'multiple' => false,'choices' => $this->asCommonStatus),
																								  array('tabindex'=> 8)),
			'baby_burial_letter'							=> new sfWidgetFormChoice(array('expanded' => true, 'multiple' => false,'choices' => $this->asCommonStatus),
																								  array('tabindex'=> 9)),
			'lawn_package'									=> new sfWidgetFormChoice(array('expanded' => true, 'multiple' => false,'choices' => $this->asCommonStatus),
																								  array('tabindex'=> 10)),
			'lawn_package_transfer_fee'						=> new sfWidgetFormChoice(array('expanded' => true, 'multiple' => false,'choices' => $this->asCommonStatus),
																								  array('tabindex'=> 11)),
			'lawn_package_transfer_nofee'					=> new sfWidgetFormChoice(array('expanded' => true, 'multiple' => false,'choices' => $this->asCommonStatus),
																								  array('tabindex'=> 12)),
			'monumental_package'							=> new sfWidgetFormChoice(array('expanded' => true, 'multiple' => false,'choices' => $this->asCommonStatus),
																								  array('tabindex'=> 13)),
			'monumental_package_asian_sections'				=> new sfWidgetFormChoice(array('expanded' => true, 'multiple' => false,'choices' => $this->asCommonStatus),
																								  array('tabindex'=> 14)),
			'monumental_package_asian_sections_trans_fee'	=> new sfWidgetFormChoice(array('expanded' => true, 'multiple' => false,'choices' => $this->asCommonStatus),
																								  array('tabindex'=> 15)),
			'monumental_package_asian_sections_trans_nofee'	=> new sfWidgetFormChoice(array('expanded' => true, 'multiple' => false,'choices' => $this->asCommonStatus),
																								  array('tabindex'=> 16)),
			'monumental_package_fee'						=> new sfWidgetFormChoice(array('expanded' => true, 'multiple' => false,'choices' => $this->asCommonStatus),
																								  array('tabindex'=> 17)),
			'monumental_packageno_fee'						=> new sfWidgetFormChoice(array('expanded' => true, 'multiple' => false,'choices' => $this->asCommonStatus),
																								  array('tabindex'=> 18)),
			'c5_envelope'									=> new sfWidgetFormChoice(array('expanded' => true, 'multiple' => false,'choices' => $this->asCommonStatus),
																								  array('tabindex'=> 19)),
																							  
			 
			'dl_envelope'									=> new sfWidgetFormChoice(array('expanded' => true, 'multiple' => false,'choices' => $this->asCommonStatus),
																								  array('tabindex'=> 20)),
			
			'letter_21'									=> new sfWidgetFormChoice(array('expanded' => true, 'multiple' => false,'choices' => $this->asCommonStatus),
																								  array('tabindex'=> 21)),
			'letter_22'									=> new sfWidgetFormChoice(array('expanded' => true, 'multiple' => false,'choices' => $this->asCommonStatus),array('tabindex'=> 22)),
			
			'letter_23'									=> new sfWidgetFormChoice(array('expanded' => true, 'multiple' => false,'choices' => $this->asCommonStatus),array('tabindex'=> 23)),
			
			'letter_24'									=> new sfWidgetFormChoice(array('expanded' => true, 'multiple' => false,'choices' => $this->asCommonStatus),array('tabindex'=> 24)),
			'letter_25'									=> new sfWidgetFormChoice(array('expanded' => true, 'multiple' => false,'choices' => $this->asCommonStatus),array('tabindex'=> 25)),
			'letter_26'									=> new sfWidgetFormChoice(array('expanded' => true, 'multiple' => false,'choices' => $this->asCommonStatus),array('tabindex'=> 26)),
			'letter_27'									=> new sfWidgetFormChoice(array('expanded' => true, 'multiple' => false,'choices' => $this->asCommonStatus),array('tabindex'=> 27)),
			'letter_28'									=> new sfWidgetFormChoice(array('expanded' => true, 'multiple' => false,'choices' => $this->asCommonStatus),array('tabindex'=> 28)),
			'letter_29'									=> new sfWidgetFormChoice(array('expanded' => true, 'multiple' => false,'choices' => $this->asCommonStatus),array('tabindex'=> 29)),
			'letter_30'									=> new sfWidgetFormChoice(array('expanded' => true, 'multiple' => false,'choices' => $this->asCommonStatus),array('tabindex'=> 30)),
			'letter_31'									=> new sfWidgetFormChoice(array('expanded' => true, 'multiple' => false,'choices' => $this->asCommonStatus),array('tabindex'=> 31)),
			'letter_32'									=> new sfWidgetFormChoice(array('expanded' => true, 'multiple' => false,'choices' => $this->asCommonStatus),array('tabindex'=> 32)),
			'letter_33'									=> new sfWidgetFormChoice(array('expanded' => true, 'multiple' => false,'choices' => $this->asCommonStatus),array('tabindex'=> 33)),
			'letter_34'									=> new sfWidgetFormChoice(array('expanded' => true, 'multiple' => false,'choices' => $this->asCommonStatus),array('tabindex'=> 34)),
			'letter_35'									=> new sfWidgetFormChoice(array('expanded' => true, 'multiple' => false,'choices' => $this->asCommonStatus),array('tabindex'=> 35)),
			'letter_36'									=> new sfWidgetFormChoice(array('expanded' => true, 'multiple' => false,'choices' => $this->asCommonStatus),array('tabindex'=> 36)),
			'letter_37'									=> new sfWidgetFormChoice(array('expanded' => true, 'multiple' => false,'choices' => $this->asCommonStatus),array('tabindex'=> 37)),
			'letter_38'									=> new sfWidgetFormChoice(array('expanded' => true, 'multiple' => false,'choices' => $this->asCommonStatus),array('tabindex'=> 38)),
			'letter_39'									=> new sfWidgetFormChoice(array('expanded' => true, 'multiple' => false,'choices' => $this->asCommonStatus),array('tabindex'=> 39)),
			'letter_40'									=> new sfWidgetFormChoice(array('expanded' => true, 'multiple' => false,'choices' => $this->asCommonStatus),array('tabindex'=> 40)),																								  																								  
																								  
																								  
																								  			
           	));

        $this->widgetSchema->setNameFormat('servicefive[%s]');
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
        BaseIntermentBookingFiveForm::setValidators(
	    	array(                
					'new_grave_inscription'							=> new sfValidatorChoice(array('choices' => $this->asCommonStatus, 'required' => false)),
					'new_grave_monumental_and_monumental_lawn'		=> new sfValidatorChoice(array('choices' => $this->asCommonStatus, 'required' => false)),
					'ov_ro_inscription_only'						=> new sfValidatorChoice(array('choices' => $this->asCommonStatus, 'required' => false)),
					'ov_ro_inscription_only_and_transfer_fee'		=> new sfValidatorChoice(array('choices' => $this->asCommonStatus, 'required' => false)),
					'ov_ro_inscription_only_transfer_nofee'			=> new sfValidatorChoice(array('choices' => $this->asCommonStatus, 'required' => false)),
					'ov_ro_monumental_letter_only'					=> new sfValidatorChoice(array('choices' => $this->asCommonStatus, 'required' => false)),
					'ov_ro_monumental_letter_only_fee'				=> new sfValidatorChoice(array('choices' => $this->asCommonStatus, 'required' => false)),
					'ov_ro_monumental_letter_only_nofee'			=> new sfValidatorChoice(array('choices' => $this->asCommonStatus, 'required' => false)),
					'baby_burial_letter'							=> new sfValidatorChoice(array('choices' => $this->asCommonStatus, 'required' => false)),
					'lawn_package'									=> new sfValidatorChoice(array('choices' => $this->asCommonStatus, 'required' => false)),
					'lawn_package_transfer_fee'						=> new sfValidatorChoice(array('choices' => $this->asCommonStatus, 'required' => false)),
					'lawn_package_transfer_nofee'					=> new sfValidatorChoice(array('choices' => $this->asCommonStatus, 'required' => false)),
					'monumental_package'							=> new sfValidatorChoice(array('choices' => $this->asCommonStatus, 'required' => false)),
					'monumental_package_asian_sections'				=> new sfValidatorChoice(array('choices' => $this->asCommonStatus, 'required' => false)),
					'monumental_package_asian_sections_trans_fee'	=> new sfValidatorChoice(array('choices' => $this->asCommonStatus, 'required' => false)),
					'monumental_package_asian_sections_trans_nofee'	=> new sfValidatorChoice(array('choices' => $this->asCommonStatus, 'required' => false)),
					'monumental_package_fee'						=> new sfValidatorChoice(array('choices' => $this->asCommonStatus, 'required' => false)),
					'monumental_packageno_fee'						=> new sfValidatorChoice(array('choices' => $this->asCommonStatus, 'required' => false)),
					'c5_envelope'									=> new sfValidatorChoice(array('choices' => $this->asCommonStatus, 'required' => false)),
					'dl_envelope'									=> new sfValidatorChoice(array('choices' => $this->asCommonStatus, 'required' => false)),
					'letter_21'									=> new sfValidatorChoice(array('choices' => $this->asCommonStatus, 'required' => false)),
					'letter_22'									=> new sfValidatorChoice(array('choices' => $this->asCommonStatus, 'required' => false)),
					'letter_23'									=> new sfValidatorChoice(array('choices' => $this->asCommonStatus, 'required' => false)),
					'letter_24'									=> new sfValidatorChoice(array('choices' => $this->asCommonStatus, 'required' => false)),
					'letter_25'									=> new sfValidatorChoice(array('choices' => $this->asCommonStatus, 'required' => false)),
					'letter_26'									=> new sfValidatorChoice(array('choices' => $this->asCommonStatus, 'required' => false)),
					'letter_27'									=> new sfValidatorChoice(array('choices' => $this->asCommonStatus, 'required' => false)),
					'letter_28'									=> new sfValidatorChoice(array('choices' => $this->asCommonStatus, 'required' => false)),
					'letter_29'									=> new sfValidatorChoice(array('choices' => $this->asCommonStatus, 'required' => false)),
					'letter_30'									=> new sfValidatorChoice(array('choices' => $this->asCommonStatus, 'required' => false)),
					'letter_31'									=> new sfValidatorChoice(array('choices' => $this->asCommonStatus, 'required' => false)),
					'letter_32'									=> new sfValidatorChoice(array('choices' => $this->asCommonStatus, 'required' => false)),
					'letter_33'									=> new sfValidatorChoice(array('choices' => $this->asCommonStatus, 'required' => false)),
					'letter_34'									=> new sfValidatorChoice(array('choices' => $this->asCommonStatus, 'required' => false)),
					'letter_35'									=> new sfValidatorChoice(array('choices' => $this->asCommonStatus, 'required' => false)),
					'letter_36'									=> new sfValidatorChoice(array('choices' => $this->asCommonStatus, 'required' => false)),
					'letter_37'									=> new sfValidatorChoice(array('choices' => $this->asCommonStatus, 'required' => false)),
					'letter_38'									=> new sfValidatorChoice(array('choices' => $this->asCommonStatus, 'required' => false)),
					'letter_39'									=> new sfValidatorChoice(array('choices' => $this->asCommonStatus, 'required' => false)),
					'letter_40'									=> new sfValidatorChoice(array('choices' => $this->asCommonStatus, 'required' => false))
				)
        );
    }
	// over ride parent object named updateObject for set manual values 
	public function updateObject($values = null)
	{
		$this->values['interment_booking_id']  		= sfContext::getInstance()->getRequest()->getParameter('id');

		parent::updateObject($this->values);
	}
}
