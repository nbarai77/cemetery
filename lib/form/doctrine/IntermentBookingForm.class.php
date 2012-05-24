<?php

/**
 * IntermentBooking form.
 *
 * @package    cemetery
 * @subpackage form
 * @author     Prakash Panchal
 * @version    SVN: $Id: IntermentBookingForm.class.php,v 1.1.1.1 2012/03/24 11:56:38 nitin Exp $
 */
sfProjectConfiguration::getActive()->loadHelpers(array('jQuery', 'Url'));
class IntermentBookingForm extends BaseIntermentBookingForm
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
		$this->asCommonStatus = array('NO'=>'No','YES'=>'Yes');
		$this->asDeceasedGender = array('Male'=>'Male','Female'=>'Female','Trans-Gender' => 'Trans-Gender');
		$this->asDeceasedMaritalStatus = array('Married'=>'Married','Unmarried'=>'Unmarried');
		$this->amStoneMasonList = Doctrine::getTable('sfGuardUser')->getStoneMasonByUserRole();
		$this->amFndList = Doctrine::getTable('sfGuardUser')->getFunderalDirectorsAsPerUserRole();
		
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
		$this->amCatalog = Doctrine::getTable('Catalog')->getCatalogList()->fetchArray();        
		$this->amCatalogList = array();
		if(count($this->amCatalog) > 0)
		{
			foreach($this->amCatalog as $ssKey => $asResult)
				$this->amCatalogList[$asResult['id']] = $asResult['name'];
		}
        $this->ssPaymentStatus = array(1=>'Credit',2=>'Waiting',3=>'Pending');
        
		$this->amPostData = sfContext::getInstance()->getRequest()->getParameter('service');
		$this->ssInvalidDateMessage = '';
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
				'service_type_id'                => new sfWidgetFormDoctrineChoice(array('model' => 'ServiceType', 'add_empty' => $asWidgets['service_type_id']), array('tabindex'=>1)),
				'date_notified'                  => new sfWidgetFormDateJQueryUI(
														array("change_month"	=> true, 
															  "change_year" 	=> true,
															  "dateFormat"		=> "dd-mm-yy",
															  "showSecond" 		=> false, 
															  'show_button_panel' => false),
														array('tabindex'=>2,'readonly'=>false)),
				
				'fnd_fndirector_id'              => new sfWidgetFormChoice(array('choices' => array('' => $asWidgets['fnd_fndirector_id']) + $this->amFndList),array('tabindex'=>3)),
				'consultant'                     => new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 4)),
				'service_date'      			 => new sfWidgetFormDateJQueryUI(
														array("change_month"	=> true, 
															  "change_year" 	=> true,
															  "dateFormat"		=> "dd-mm-yy",
															  "showSecond" 		=> false, 
															  'show_button_panel' => false),
														array('tabindex'=>5,'readonly'=>false)),
				'date1_day'           			 => new sfWidgetFormInputText(array(), array('size' => 10,'readonly' => true)),
				'service_booking_time_from'      => new sfWidgetFormDateJQueryUI(
														array("showTime" 		=> true,
															  "showSecond" 		=> true,  
															  "timeFormat" 		=> 'hh:mm:ss',
															  'show_button_panel' => true),
														array('style' => 'width:100px;', 'tabindex'=>7,'readonly'=>false)),
				'service_booking_time_to'        => new sfWidgetFormDateJQueryUI(
														array("showTime"		=> true,
															  "showSecond" 		=> true, 
															  "timeFormat" 		=> 'hh:mm:ss',
															  'show_button_panel' => true),
														array('style' => 'width:100px;', 'tabindex'=>8,'readonly'=>false)),
				'service_date2'      			 => new sfWidgetFormDateJQueryUI(
														array("change_month"	=> true, 
															  "change_year" 	=> true,
															  "dateFormat"		=> "dd-mm-yy",
															  "showSecond" 		=> false, 
															  'show_button_panel' => false),
														array('tabindex'=>9,'readonly'=>false)),
				'date2_day'           			 => new sfWidgetFormInputText(array(), array('size' => 10,'readonly' => true)),
				'service_booking2_time_from'      => new sfWidgetFormDateJQueryUI(
														array("showTime" 		=> true,
															  "showSecond" 		=> true,  
															  "timeFormat" 		=> 'hh:mm:ss',
															  'show_button_panel' => true),
														array('style' => 'width:100px;', 'tabindex'=>10,'readonly'=>false)),
				'service_booking2_time_to'        => new sfWidgetFormDateJQueryUI(
														array("showTime"		=> true,
															  "showSecond" 		=> true, 
															  "timeFormat" 		=> 'hh:mm:ss',
															  'show_button_panel' => true),
														array('style' => 'width:100px;', 'tabindex'=>11,'readonly'=>false)),
				'service_date3'      			 => new sfWidgetFormDateJQueryUI(
														array("change_month"	=> true, 
															  "change_year" 	=> true,
															  "dateFormat"		=> "dd-mm-yy",
															  "showSecond" 		=> false, 
															  'show_button_panel' => false),
														array('tabindex'=>12,'readonly'=>false)),
				'date3_day'           			 => new sfWidgetFormInputText(array(), array('size' => 10,'readonly' => true)),
				'service_booking3_time_from'      => new sfWidgetFormDateJQueryUI(
														array("showTime" 		=> true,
															  "showSecond" 		=> true,  
															  "timeFormat" 		=> 'hh:mm:ss',
															  'show_button_panel' => true),
														array('style' => 'width:100px;', 'tabindex'=>13,'readonly'=>false)),
				'service_booking3_time_to'        => new sfWidgetFormDateJQueryUI(
														array("showTime"		=> true,
															  "showSecond" 		=> true, 
															  "timeFormat" 		=> 'hh:mm:ss',
															  'show_button_panel' => true),
														array('style' => 'width:100px;', 'tabindex'=>14,'readonly'=>false)),
				'deceased_title'              	 => new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 15)),
				'deceased_surname'               => new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 17)),
				'deceased_other_surname'         => new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 18)),
				'deceased_first_name'            => new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 19)),
				'deceased_other_first_name'      => new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 20)),
				'deceased_middle_name'           => new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 21)),
				'deceased_other_middle_name'     => new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 22)),
				'deceased_gender'                => new sfWidgetFormChoice(array('expanded' => true, 'multiple' => false,'choices' => $this->asDeceasedGender),array('tabindex'=>23)),
                'catalog_id' => new sfWidgetFormChoice(
														array('choices' => array('' => $asWidgets['catalog_id']) + $this->amCatalogList),
														array('tabindex'=>1)),
                'payment_id' => new sfWidgetFormChoice(
														array('choices' => array('' => $asWidgets['payment_id']) + $this->ssPaymentStatus),
														array('tabindex'=>1)),
           	));

		// Add Confirmed Check box.
		if(sfContext::getInstance()->getUser()->getAttribute('groupid') != sfConfig::get('app_cemrole_funeraldirector'))
			$this->widgetSchema['confirmed'] = new MyWidgetFormInputCheckbox(array(), array('tabindex' => 2, 'value' => 1));
		
		// FOR EMBED FORM
		$oIntermentBookingTwo = ($this->getObject()->isNew()) ? new IntermentBookingTwo() : Doctrine::getTable('IntermentBookingTwo')->findOneByIntermentBookingId($this->getObject()->getId());
		$this->oIntermentBookingTwoForm = new IntermentBookingTwoForm($oIntermentBookingTwo);
		$this->embedForm('other_details', $this->oIntermentBookingTwoForm);
		
		if($this->isNew())
        {
            $date_today = sfConfig::get('app_default_date_formate');
            $this->setDefault('date_notified', $date_today);
            $this->setDefault('service_date', $date_today);            
            $this->setDefault('service_date2', $date_today);            
            $this->setDefault('service_date3', $date_today);            
        }
        else
		{
			$date_notified = $service_date = $service_date2 = $service_date3 = sfConfig::get('app_default_date_formate');
            if($this->getObject()->getDateNotified() != '' && $this->getObject()->getDateNotified() != '0000-00-00')
			{
				list($snYear,$snMonth,$snDay) = explode('-',$this->getObject()->getDateNotified());
				$date_notified = $snDay.'-'.$snMonth.'-'.$snYear;				
			}
			$this->setDefault('date_notified', $date_notified);	
			if($this->getObject()->getServiceDate() != '' && $this->getObject()->getServiceDate() != '0000-00-00')
			{
				list($snYear,$snMonth,$snDay) = explode('-',$this->getObject()->getServiceDate());
				$service_date = $snDay.'-'.$snMonth.'-'.$snYear;				
			}
            $this->setDefault('service_date', $service_date);
			if($this->getObject()->getServiceBookingTimeFrom() != '')
				$this->setDefault('service_booking_time_from', date('H:i:s',strtotime($this->getObject()->getServiceBookingTimeFrom())));
			if($this->getObject()->getServiceBookingTimeTo() != '')
				$this->setDefault('service_booking_time_to', date('H:i:s',strtotime($this->getObject()->getServiceBookingTimeTo())));

			if($this->getObject()->getServiceDate2() != '' && $this->getObject()->getServiceDate2() != '0000-00-00')
			{
				list($snYear,$snMonth,$snDay) = explode('-',$this->getObject()->getServiceDate2());
				$service_date2 = $snDay.'-'.$snMonth.'-'.$snYear;				
			}
            $this->setDefault('service_date2', $service_date2);	
			if($this->getObject()->getServiceBooking2TimeFrom() != '')
				$this->setDefault('service_booking2_time_from', date('H:i:s',strtotime($this->getObject()->getServiceBooking2TimeFrom())));
			if($this->getObject()->getServiceBooking2TimeTo() != '')
				$this->setDefault('service_booking2_time_to', date('H:i:s',strtotime($this->getObject()->getServiceBooking2TimeTo())));

			if($this->getObject()->getServiceDate3() != '' && $this->getObject()->getServiceDate3() != '0000-00-00')
			{
				list($snYear,$snMonth,$snDay) = explode('-',$this->getObject()->getServiceDate3());
				$service_date3 = $snDay.'-'.$snMonth.'-'.$snYear;				
			}
            $this->setDefault('service_date3', $service_date3);
			if($this->getObject()->getServiceBooking3TimeFrom() != '')
				$this->setDefault('service_booking3_time_from', date('H:i:s',strtotime($this->getObject()->getServiceBooking3TimeFrom())));
			if($this->getObject()->getServiceBooking3TimeTo() != '')
				$this->setDefault('service_booking3_time_to', date('H:i:s',strtotime($this->getObject()->getServiceBooking3TimeTo())));			
				
			// SET DEFAULT VALUE FOR EMBED FORM
			$ssChapelFromTime = $this->embeddedForms['other_details']->getObject()->getChapelTimeFrom();
			$ssChapelFromTime = ($ssChapelFromTime != '' && $ssChapelFromTime != '0000-00-00 00:00:00') ? date('d-m-Y H:i:s',strtotime( $ssChapelFromTime )) : '';
			
			$ssChapelToTime = $this->embeddedForms['other_details']->getObject()->getChapelTimeTo();
			$ssChapelToTime = ($ssChapelToTime != '' && $ssChapelToTime != '0000-00-00 00:00:00') ? date('d-m-Y H:i:s',strtotime( $ssChapelToTime )) : '';
			
			$ssRoomFromTime = $this->embeddedForms['other_details']->getObject()->getRoomTimeFrom();
			$ssRoomFromTime = ($ssRoomFromTime != '' && $ssRoomFromTime != '0000-00-00 00:00:00') ? date('d-m-Y H:i:s',strtotime( $ssRoomFromTime )) : '';
			
			$ssRoomToTime = $this->embeddedForms['other_details']->getObject()->getRoomTimeTo();
			$ssRoomToTime = ($ssRoomToTime != '' && $ssRoomToTime != '0000-00-00 00:00:00') ? date('d-m-Y H:i:s',strtotime( $ssRoomToTime )) : '';

			$oEmbedFormDefault = $this->getDefault('other_details');
			$oEmbedFormDefault['chapel_time_from'] = $ssChapelFromTime;
			$oEmbedFormDefault['chapel_time_to'] = $ssChapelToTime;
			$oEmbedFormDefault['room_time_from'] = $ssRoomFromTime;
			$oEmbedFormDefault['room_time_to'] = $ssRoomToTime;
			$this->setDefault('other_details', $oEmbedFormDefault);

		}
        
		
        $this->widgetSchema->setNameFormat('service[%s]');
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
		$this->ssInvalidDateMessage = $amValidators['booking_date_past']['invalid'];

        BaseIntermentBookingForm::setValidators(
	    	array(
				'deceased_title'		=> new sfValidatorString( 
                       								array('required' => false, 'trim' => true)),
                'deceased_surname'		=> new sfValidatorString( 
                       								array('required' => true, 'trim' => true),
                       								array('required' => $amValidators['deceased_surname']['required'])
												),
                'deceased_first_name'	=> new sfValidatorString( 
                       								array('required' => true, 'trim' => true),
                       								array('required' => $amValidators['deceased_first_name']['required'])
												),
                'deceased_middle_name'	=> new sfValidatorString( 
                       								array('required' => false, 'trim' => true),
                       								array('required' => $amValidators['deceased_middle_name']['required'])
												),
                'service_type_id'	=> new sfValidatorString( 
                       								array('required' => false, 'trim' => true)),
                'date_notified'	=> new sfValidatorString(
                       								array('required' => false, 'trim' => true)),
                'fnd_fndirector_id'	=> new sfValidatorString( 
                       								array('required' => false, 'trim' => true)),
                'consultant'	=> new sfValidatorString( 
                       								array('required' => false, 'trim' => true)),
                'service_date'	=> new sfValidatorString( 
                       								array('required' => false, 'trim' => true)),
				'date1_day'		=> new sfValidatorString( 
                       								array('required' => false, 'trim' => true)),
                'service_booking_time_from'	=> new sfValidatorString( 
                       								array('required' => false, 'trim' => true)),
                'service_booking_time_to'	=> new sfValidatorString( 
                       								array('required' => false, 'trim' => true)),
				
				'service_date2'	=> new sfValidatorString( 
                       								array('required' => false, 'trim' => true)),
				'date2_day'		=> new sfValidatorString( 
                       								array('required' => false, 'trim' => true)),
                'service_booking2_time_from'	=> new sfValidatorString( 
                       								array('required' => false, 'trim' => true)),
                'service_booking2_time_to'	=> new sfValidatorString( 
                       								array('required' => false, 'trim' => true)),
													
				'service_date3'	=> new sfValidatorString( 
                       								array('required' => false, 'trim' => true)),
				'date3_day'		=> new sfValidatorString( 
                       								array('required' => false, 'trim' => true)),
                'service_booking3_time_from'	=> new sfValidatorString( 
                       								array('required' => false, 'trim' => true)),
                'service_booking3_time_to'	=> new sfValidatorString( 
                       								array('required' => false, 'trim' => true)),

                'deceased_other_surname'	=> new sfValidatorString( 
                       								array('required' => false, 'trim' => true)),
                'deceased_other_first_name'	=> new sfValidatorString( 
                       								array('required' => false, 'trim' => true)),
                'deceased_other_middle_name'	=> new sfValidatorString(
                       								array('required' => false, 'trim' => true)),
                'deceased_gender'	=> new sfValidatorString( 
                       								array('required' => false, 'trim' => true)),
                'catalog_id'  =>              new sfValidatorString( 
												array('required' => false, 'trim' => true)),
                'payment_id'  =>              new sfValidatorString( 
												array('required' => false, 'trim' => true))
			)
        );
		
		// Validated Confirmed field while 
		if(sfContext::getInstance()->getUser()->getAttribute('groupid') != sfConfig::get('app_cemrole_funeraldirector'))
		{
			$this->validatorSchema['confirmed'] =	new sfValidatorString(
															array('required' => false, 'trim' => true));
		}
		if($this->isNew())
		{
			$this->validatorSchema['service_booking_time_from'] = new sfValidatorAnd(array(new sfValidatorDate(), new sfValidatorCallback(
																		array('callback'=> array($this,'checkValidDate'),
																			  'arguments' => array('ssCurrentDate' => $this->amPostData['service_booking_time_from'])),
																		array('invalid'=> $amValidators['booking_invalid_date']['invalid']))
																		),															
																		array('required' => false, 'trim' => true)
																);
			
			$this->validatorSchema['service_booking_time_to'] = new sfValidatorAnd(array(new sfValidatorDate(), new sfValidatorCallback(
																		array('callback'=> array($this,'checkValidDate'),
																			  'arguments' => array('ssCurrentDate' => $this->amPostData['service_booking_time_to'])),
																		array('invalid'=> $amValidators['booking_invalid_date']['invalid']))
																		),															
																		array('required' => false, 'trim' => true)
																);
		}
		$this->validatorSchema['other_details'] = $this->oIntermentBookingTwoForm->getValidatorSchema();
		
    }
	// over ride parent object named updateObject for set manual values 
	public function updateObject($values = null)
	{
		if($this->isNew())
			$this->values['taken_by'] 		= sfContext::getInstance()->getUser()->getAttribute('userid',0);

		$this->values['user_id'] 			= sfContext::getInstance()->getUser()->getAttribute('userid');
		
		if(!sfContext::getInstance()->getUser()->isSuperAdmin())
		{
			$snCemeteryId	= sfContext::getInstance()->getUser()->getAttribute('cemeteryid');
			$oCemetery = Doctrine::getTable('CemCemetery')->find($snCemeteryId);
			$this->values['cem_cemetery_id'] = $snCemeteryId;
			$this->values['country_id'] = $oCemetery->getCountryId();
		}

		if($this->amPostData['service_type_id'] == '')
			$this->values['service_type_id'] = NULL;
        if($this->amPostData['catalog_id'] == '')
			$this->values['catalog_id'] = NULL;
        if($this->amPostData['payment_id'] == '')
			$this->values['payment_id'] = NULL;

		parent::updateObject($this->values);
	}
	// save embed form
	public function saveEmbeddedForms($con = null, $forms = null)
	{
		$this->embeddedForms['other_details']->getObject()->setIntermentBookingId($this->getObject()->getId());
		
		if(sfContext::getInstance()->getUser()->isSuperAdmin())
		{
			$amPostChapelTypes 	= sfContext::getInstance()->getRequest()->getParameter('chapel_grouplist');
			$amPostRoomTypes 	= sfContext::getInstance()->getRequest()->getParameter('room_grouplist');
			
			// SET CHAPEL TYPE IDS.
			if($this->amPostData['other_details']['chapel'] == 'YES' && count($amPostChapelTypes) > 0)
				$this->embeddedForms['other_details']->getObject()->setCemChapelIds(implode(',',$amPostChapelTypes));

			// SET ROOM TYPE IDS.
			if($this->amPostData['other_details']['room'] == 'YES' && count($amPostRoomTypes) > 0 )
				$this->embeddedForms['other_details']->getObject()->setCemRoomIds(implode(',',$amPostRoomTypes));
		}
		else
		{
			if($this->amPostData['other_details']['chapel'] == 'YES' && isset($this->amPostData['other_details']['chapel_grouplist']) )
				$this->embeddedForms['other_details']->getObject()->setCemChapelIds(implode(',', $this->amPostData['other_details']['chapel_grouplist']));

			if($this->amPostData['other_details']['room'] == 'YES' && isset($this->amPostData['other_details']['room_grouplist']) )
				$this->embeddedForms['other_details']->getObject()->setCemRoomIds(implode(',',$this->amPostData['other_details']['room_grouplist']));
		}

		$ssChapelFromTime = $this->amPostData['other_details']['chapel_time_from'];
		$ssChapelFromTime = ($ssChapelFromTime != '' && $ssChapelFromTime != '00-00-0000 00:00:00') ? date('Y-m-d H:i:s',strtotime( $ssChapelFromTime )) : '';
		$this->embeddedForms['other_details']->getObject()->setChapelTimeFrom($ssChapelFromTime);

		$ssChapelToTime = $this->amPostData['other_details']['chapel_time_to'];
		$ssChapelToTime = ($ssChapelToTime != '' && $ssChapelToTime != '00-00-0000 00:00:00') ? date('Y-m-d H:i:s',strtotime( $ssChapelToTime )) : '';
		$this->embeddedForms['other_details']->getObject()->setChapelTimeTo($ssChapelToTime);
		
		$ssRoomFromTime = $this->amPostData['other_details']['room_time_from'];
		$ssRoomFromTime = ($ssRoomFromTime != '' && $ssRoomFromTime != '00-00-0000 00:00:00') ? date('Y-m-d H:i:s',strtotime( $ssRoomFromTime )) : '';
		$this->embeddedForms['other_details']->getObject()->setRoomTimeFrom($ssRoomFromTime);
		
		$ssRoomToTime = $this->amPostData['other_details']['room_time_to'];
		$ssRoomToTime = ($ssRoomToTime != '' && $ssRoomToTime != '00-00-0000 00:00:00') ? date('Y-m-d H:i:s',strtotime( $ssRoomToTime )) : '';
		$this->embeddedForms['other_details']->getObject()->setRoomTimeTo($ssRoomToTime);

		parent::saveEmbeddedForms($con, $forms);
	}
	/**
     * Fuction checkValidDate to check date is greater than or equal to current date
     * @param $validator 	= Call Validator
     * @param $snCurrentDate 	= date
	 
	 * return  $snCurrentDate valid date
     */
	public function checkValidDate($validator, $snCurrentDate, $asArguments) 
	{
		if(date("Y-m-d",strtotime($snCurrentDate)) < date('Y-m-d'))
			throw new sfValidatorError($validator, $this->ssInvalidDateMessage);
		else
			return date("Y-m-d H:i:s",strtotime($asArguments['ssCurrentDate']));
	}
}