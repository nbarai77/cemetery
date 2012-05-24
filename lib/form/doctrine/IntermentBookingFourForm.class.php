<?php

/**
 * IntermentBookingFour form.
 *
 * @package    cemetery
 * @subpackage form
 * @author     Prakash Panchal
 * @version    SVN: $Id: IntermentBookingFourForm.class.php,v 1.1.1.1 2012/03/24 11:56:31 nitin Exp $
 */
sfProjectConfiguration::getActive()->loadHelpers(array('jQuery', 'Url'));
class IntermentBookingFourForm extends BaseIntermentBookingFourForm
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
		$this->asDeceasedMaritalStatus = array('Never Married'				=>'Never Married',
											   'Married'					=>'Married',
											   'Widow/Widower'				=>'Widow/Widower',
											   'Sparated but not divorced'	=>'Separated but not divorced',
											   'Divorced'					=>'Divorced',
											   'De facto'					=>'De facto',
											   'Unknown' 					=> 'Unknown'
											   );
		$this->asFinageuom = array('Year'=>'Year','Month'=>'Month','Weeks'=>'Weeks','Days'=>'Days','Hours'=>'Hours','Adult'=>'Adult','Child'=>'Child','Unborn'=>'Unborn');
		$this->asCalendarType = array('Aboriginal'=>'Aboriginal',
									  'Bahai'=>'Bahai',
									  'Chinese (Yinyang Li)'=>'Chinese (Yinyang Li)',
									  'Coptic/Ortodox'=>'Coptic/Ortodox',
									  'Discordian'=>'Discordian',
									  'Ethiopic'=>'Ethiopic',
									  'Hebrew  (Jewish)'=>'Hebrew  (Jewish)',
									  'Hindu Solar'=>'Hindu Solar',
									  'Hindu Lunar'=>'Hindu Lunar',
									  'Islamic (Muslim)'=>'Islamic (Muslim)',
									  'Jalaali'=>'Jalaali',
									  'Japanese/Kyureki'=>'Japanese/Kyureki',
									  'Mayan Long Count'=>'Mayan Long Count',
									  'Mayan Haab'=>'Mayan Haab',
									  'Mayan Tzolkin'=>'Mayan Tzolkin',
									  'Persian'=>'Persian',
									  'Other'=>'Other'
									 );
		
		$this->asCountryList = array();
		$omCriteria = Doctrine::getTable('Country')->getCountryList(array(),array());
		$amCountry = $omCriteria->orderBy('sf.name')->fetchArray();
		$this->snDefaultCountryId = 0;
		if(count($amCountry) > 0)
		{
			foreach($amCountry as $asDataSet)
			{
				$this->asCountryList[$asDataSet['id']] = $asDataSet['name'];
				if($asDataSet['name'] == sfConfig::get('app_default_country'))
					$this->snDefaultCountryId = $asDataSet['id'];
			}
		}
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
        BaseIntermentBookingFourForm::setWidgets(
            array(
				'control_number'          		=> new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 1)),
				'interment_date'         		=> new sfWidgetFormDateJQueryUI(
												array("change_month"	=> true, 
													  "change_year" 	=> true,
													  "dateFormat"		=> "dd-mm-yy",
													  "showSecond" 		=> false, 
													  'show_button_panel' => false),
												array('tabindex'=>2,'readonly'=>false)),
				'deceased_date_of_death'         => new sfWidgetFormDateJQueryUI(
														array("change_month"	=> true, 
															  "change_year" 	=> true,
															  "dateFormat"		=> "dd-mm-yy",
															  "showSecond" 		=> false, 
															  'show_button_panel' => false,
															  "disableDOD"	=> true
															  ),
														array('tabindex'=>2,'readonly'=>false)),
				'deceased_date_of_birth'         => new sfWidgetFormDateJQueryUI(
														array("change_month"	=> true, 
															  "change_year" 	=> true,
															  "dateFormat"		=> "dd-mm-yy",
															  "showSecond" 		=> false, 
															  'show_button_panel' => false),
														array('tabindex'=>3,'readonly'=>false)),
				'deceased_place_of_death'        => new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 4)),
				'deceased_place_of_birth'        => new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 5)),
				
                'deceased_country_id_of_death'   => new sfWidgetFormChoice(
													array('choices' => array('' => $asWidgets['deceased_country_id_of_death']) + $this->asCountryList),
													array('tabindex'=> 6)),
				'deceased_country_id_of_birth'   => new sfWidgetFormChoice(
													array('choices' => array('' => $asWidgets['deceased_country_id_of_birth']) + $this->asCountryList),
													array('tabindex'=> 7)),
				'deceased_age'                   => new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 8)),
				'deceased_usual_address'         => new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 10)),
				
				'finageuom'            			 => new sfWidgetFormChoice(
													array('choices' => array('' => $asWidgets['finageuom']) + $this->asFinageuom),
													array('tabindex'=> 9)),
				
				'deceased_suburb_town'           => new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 12)),
				'deceased_state'                 => new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 13)),
				'deceased_postal_code'           => new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 14)),
				'deceased_country_id'            => new sfWidgetFormChoice(
													array('choices' => array('' => $asWidgets['deceased_country_id']) + $this->asCountryList),
													array('tabindex'=> 15)),
				'deceased_marital_status'        => new sfWidgetFormChoice(array('choices' => $this->asDeceasedMaritalStatus),array('tabindex'=>16)),
				'deceased_partner_surname'       => new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 17)),
				'deceased_partner_name'          => new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 18)),
				'deceased_father_surname'        => new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 19)),
				'deceased_father_name'           => new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 20)),
				'deceased_mother_maiden_surname' => new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 21)),
				'deceased_mother_name'           => new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 22)),				
				'deceased_children1'             => new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 23)),
				'deceased_children2'             => new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 24)),
				'deceased_children3'             => new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 25)),
				'deceased_children4'             => new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 26)),
				'deceased_children5'             => new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 27)),
				'deceased_children6'             => new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 28)),
				'deceased_children7'             => new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 29)),
				'deceased_children8'             => new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 30)),
				'deceased_children9'             => new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 31)),
				'deceased_children10'            => new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 32)),
				'deceased_children11'            => new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 33)),
				'deceased_children12'            => new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 34)),				

				'cul_calender_type'       		 => new sfWidgetFormChoice(
													array('choices' => array('' => $asWidgets['cul_calender_type']) + $this->asCalendarType),
													array('tabindex'=> 35)),
				'cul_date_of_death'              => new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 36)),
				'cul_date_of_interment'          => new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 37)),
				'cul_died_after_dust'          	 => new MyWidgetFormInputCheckbox(array(), array('value' => 1,'tabindex' => 38)),
				'cul_time_of_death'           	 => new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 39)),
				'cul_date_of_birth'          	 => new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 40)),
				'cul_status'          			 => new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 41)),
				'cul_remains_position'           => new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 42)),
           	));
		
		if($this->isNew())
        {
            $date_today = sfConfig::get('app_default_date_formate');
            $this->setDefault('deceased_date_of_birth', $date_today);
            $this->setDefault('deceased_date_of_death', $date_today);            
        }
        if(!$this->isNew())
		{
			$ssDceasedDOB = $ssDeceasedDOD = $ssCalDOD = $ssCalDOB = $ssCalDOI = sfConfig::get('app_default_date_formate');
			if($this->getObject()->getDeceasedDateOfBirth() != '' && $this->getObject()->getDeceasedDateOfBirth() != '0000-00-00')
			{
				list($snYear,$snMonth,$snDay) = explode('-',$this->getObject()->getDeceasedDateOfBirth());
				$ssDceasedDOB = $snDay.'-'.$snMonth.'-'.$snYear;				
			}
			$this->setDefault('deceased_date_of_birth', $ssDceasedDOB);	

			if($this->getObject()->getDeceasedDateOfDeath() != '' && $this->getObject()->getDeceasedDateOfDeath() != '0000-00-00')
			{
				list($snYear,$snMonth,$snDay) = explode('-', $this->getObject()->getDeceasedDateOfDeath());
				$ssDeceasedDOD = $snDay.'-'.$snMonth.'-'.$snYear;				
			}
			$this->setDefault('deceased_date_of_death', $ssDeceasedDOD);
			
			if($this->getObject()->getCulDateOfDeath() != '')
			{
				list($snYear,$snMonth,$snDay) = explode('-', $this->getObject()->getCulDateOfDeath());
				$ssCalDOD = $snDay.'-'.$snMonth.'-'.$snYear;
			}
			$this->setDefault('cul_date_of_death', $ssCalDOD);
			
			if($this->getObject()->getCulDateOfBirth() != '')
			{
				list($snYear,$snMonth,$snDay) = explode('-', $this->getObject()->getCulDateOfBirth());
				$ssCalDOB = $snDay.'-'.$snMonth.'-'.$snYear;
			}
			$this->setDefault('cul_date_of_birth', $ssCalDOB);
			
			if($this->getObject()->getCulDateOfInterment() != '')
			{
				list($snYear,$snMonth,$snDay) = explode('-', $this->getObject()->getCulDateOfInterment());
				$ssCalDOI = $snDay.'-'.$snMonth.'-'.$snYear;
			}
			$this->setDefault('cul_date_of_interment', $ssCalDOI);
			
			$this->setDefault('cul_died_after_dust', $this->getObject()->getCulDiedAfterDust());
			
		}
		else
			$this->setDefault('cul_died_after_dust', 0);

        $this->widgetSchema->setNameFormat('servicefour[%s]');
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
        BaseIntermentBookingFourForm::setValidators(
	    	array(                
				'deceased_date_of_death'	=> new sfValidatorString( 
                       								array('required' => false, 'trim' => true)),
				'deceased_date_of_birth'	=> new sfValidatorString( 
                       								array('required' => false, 'trim' => true)),
				'deceased_place_of_death'	=> new sfValidatorString( 
                       								array('required' => false, 'trim' => true)),
				'deceased_place_of_birth'	=> new sfValidatorString( 
                       								array('required' => false, 'trim' => true)),
				'deceased_country_id_of_death'	=> new sfValidatorString( 
                       								array('required' => false, 'trim' => true)),
				'deceased_country_id_of_birth'	=> new sfValidatorString( 
                       								array('required' => false, 'trim' => true)),
				'deceased_age'					=> new sfValidatorString( 
                       								array('required' => false, 'trim' => true)),
				'finageuom'        			 => new sfValidatorString( 
                       								array('required' => false, 'trim' => true)),
				'deceased_usual_address'	=> new sfValidatorString( 
                       								array('required' => false, 'trim' => true)),
				'deceased_suburb_town'	=> new sfValidatorString( 
                       								array('required' => false, 'trim' => true)),
				'deceased_postal_code'	=> new sfValidatorString( 
                       								array('required' => false, 'trim' => true)),
				'deceased_state'	    => new sfValidatorString( 
                       								array('required' => false, 'trim' => true)),                       								
				'deceased_country_id'	=> new sfValidatorString( 
                       								array('required' => false, 'trim' => true)),
				'deceased_marital_status'	=> new sfValidatorString( 
                       								array('required' => false, 'trim' => true)),
				'deceased_partner_surname'	=> new sfValidatorString( 
                       								array('required' => false, 'trim' => true)),
				'deceased_partner_name'	=> new sfValidatorString( 
                       								array('required' => false, 'trim' => true)),
				'deceased_father_surname'	=> new sfValidatorString( 
                       								array('required' => false, 'trim' => true)),
				'deceased_father_name'	=> new sfValidatorString( 
                       								array('required' => false, 'trim' => true)),
				'deceased_mother_maiden_surname'	=> new sfValidatorString( 
                       								array('required' => false, 'trim' => true)),
				'deceased_mother_name'	=> new sfValidatorString( 
                       								array('required' => false, 'trim' => true)),
				'deceased_children1'	=> new sfValidatorString( 
                       								array('required' => false, 'trim' => true)),
				'deceased_children2'	=> new sfValidatorString( 
                       								array('required' => false, 'trim' => true)),
				'deceased_children3'	=> new sfValidatorString( 
                       								array('required' => false, 'trim' => true)),
				'deceased_children4'	=> new sfValidatorString( 
                       								array('required' => false, 'trim' => true)),
				'deceased_children5'	=> new sfValidatorString( 
                       								array('required' => false, 'trim' => true)),
				'deceased_children6'	=> new sfValidatorString( 
                       								array('required' => false, 'trim' => true)),
				'deceased_children7'	=> new sfValidatorString( 
                       								array('required' => false, 'trim' => true)),
				'deceased_children8'	=> new sfValidatorString( 
                       								array('required' => false, 'trim' => true)),
				'deceased_children9'	=> new sfValidatorString( 
                       								array('required' => false, 'trim' => true)),
				'deceased_children10'	=> new sfValidatorString( 
                       								array('required' => false, 'trim' => true)),
				'deceased_children11'	=> new sfValidatorString( 
                       								array('required' => false, 'trim' => true)),
				'deceased_children12'	=> new sfValidatorString( 
                       								array('required' => false, 'trim' => true)),

				'cul_calender_type'	=> new sfValidatorString( 
                       								array('required' => false, 'trim' => true)),
				'cul_date_of_death'	=> new sfValidatorString( 
                       								array('required' => false, 'trim' => true)),
				'cul_time_of_death'	=> new sfValidatorString( 
                       								array('required' => false, 'trim' => true)),
				'cul_date_of_birth'	=> new sfValidatorString( 
                       								array('required' => false, 'trim' => true)),                       								
				'cul_date_of_interment'	=> new sfValidatorString( 
                       								array('required' => false, 'trim' => true)),
				'cul_status'	=> new sfValidatorString( 
                       								array('required' => false, 'trim' => true)),
				'cul_died_after_dust'	=> new sfValidatorString( 
                       								array('required' => false, 'trim' => true)),
				'cul_remains_position'	=> new sfValidatorString( 
                       								array('required' => false, 'trim' => true)),				
				'control_number'		=> new sfValidatorString( 
                       								array('required' => false, 'trim' => true),
                       								array('required' => $amValidators['control_number']['required'])
												),
				'interment_date'	=> new sfValidatorString( 
										array('required' => false, 'trim' => true))
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
