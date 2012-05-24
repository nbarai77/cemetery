<?php

/**
 * FacilityBooking form.
 *
 * @package    cemetery
 * @subpackage form
 * @author     Prakash Panchal
 * @version    SVN: $Id: FacilityBookingForm.class.php,v 1.1.1.1 2012/03/24 11:56:32 nitin Exp $
 */
sfProjectConfiguration::getActive()->loadHelpers(array('jQuery', 'Url')); 
class FacilityBookingForm extends BaseFacilityBookingForm
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
		unset($this['id'],$this['total']);
		$this->amStatus = array('NO'=>'No','YES'=>'Yes');
		$this->asPostData = sfContext::getInstance()->getRequest()->getParameter('facilitybooking');
		
		// Get cemetery List as per user role
		if(sfContext::getInstance()->getUser()->isSuperAdmin())
			$this->amCementeryList = Doctrine::getTable('CemCemetery')->getAllCemeteriesByUserRole();
		
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
		$this->ssInvalidDateMessage = '';

		$this->amAllChapelTypes = $this->amAllRoomTypes = $this->amChapleAssociated = $this->amRoomAssociated = array();		
		if(!sfContext::getInstance()->getUser()->isSuperAdmin())
		{
			// GET ALL CHAPEL TYPES		
			$this->amAllChapelTypes = Doctrine::getTable('CemChapel')->getCemChapelTypes();
			// GET ALL ROOM TYPES
			$this->amAllRoomTypes = Doctrine::getTable('CemRoom')->getCemRoomTypes();
			
			// GET OLD SELECTED CHAPLE AND ROOM TYPE TO EDIT THE RECORDS
			if(!$this->isNew())
			{
				$amCemChapelIds = ($this->getObject()->getCemChapelIds() != '') ? explode(',',$this->getObject()->getCemChapelIds()) : '';
				$amCemRoomIds = ($this->getObject()->getCemRoomIds() != '') ? explode(',',$this->getObject()->getCemRoomIds()) : '';
				
				$this->amChapleAssociated = Doctrine::getTable('CemChapel')->getCemChapelTypes($amCemChapelIds);
				$this->amRoomAssociated = Doctrine::getTable('CemRoom')->getCemRoomTypes($amCemRoomIds);
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
        BaseFacilityBookingForm::setWidgets(
            array(
				'title' 				=> new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 2)),
				'surname' 				=> new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 3)),
				'first_name' 			=> new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 4)),
				'middle_name' 			=> new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 5)),
				'email' 				=> new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 6)),				
				'address' 				=> new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 7)),
				'suburb_town' 			=> new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 8)),
				'country_id'  			=> new sfWidgetFormChoice(
													array('choices' => array('' => $asWidgets['country_id']) + $this->asCountryList),
													array('tabindex'=> 9)),
				'state' 				=> new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 10)),
				'postal_code' 			=> new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 11)),
				'area_code' 			=> new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 12)),
				'telephone' 			=> new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 13)),
				'mobile' 				=> new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 14)),
				'fax_area_code' 		=> new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 15)),
				'fax' 					=> new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 16)),
				'chapel' 				=> new sfWidgetFormChoice(array('expanded' => true, 'multiple' => false,'choices' => $this->amStatus ), 
																  array('tabindex'=> 17)),
				'chapel_time_from' 		=> new sfWidgetFormDateJQueryUI(
														array("change_month"	=> true, 
															  "change_year" 	=> true,
															  "dateFormat"		=> "dd-mm-yy",
															  "showSecond" 		=> true, 
															  "timeFormat" 		=> 'hh:mm:ss',
															  'show_button_panel' => true),
														array('tabindex'=>19,'readonly'=>false)),
				'chapel_time_to' 		=> new sfWidgetFormDateJQueryUI(
														array("change_month"	=> true, 
															  "change_year" 	=> true,
															  "dateFormat"		=> "dd-mm-yy",
															  "showSecond" 		=> true, 
															  "timeFormat" 		=> 'hh:mm:ss',
															  'show_button_panel' => true),
														array('tabindex'=>20,'readonly'=>false)),
				'chapel_cost' 			=> new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 21)),
				
				'room' 					=> new sfWidgetFormChoice(array('expanded' => true, 'multiple' => false,'choices' => $this->amStatus ),
																  array('tabindex'=> 22)),
				'room_time_from' 		=> new sfWidgetFormDateJQueryUI(
														array("change_month"	=> true, 
															  "change_year" 	=> true,
															  "dateFormat"		=> "dd-mm-yy",
															  "showSecond" 		=> true, 
															  "timeFormat" 		=> 'hh:mm:ss',
															  'show_button_panel' => true),
														array('tabindex'=> 24,'readonly'=>false)),
				'room_time_to' 			=> new sfWidgetFormDateJQueryUI(
														array("change_month"	=> true, 
															  "change_year" 	=> true,
															  "dateFormat"		=> "dd-mm-yy",
															  "showSecond" 		=> true, 
															  "timeFormat" 		=> 'hh:mm:ss',
															  'show_button_panel' => true),
														array('tabindex'=> 25,'readonly'=>false)),
				'no_of_rooms' 			=> new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 26)),
				'room_cost' 			=> new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 27)),
				
				'special_instruction'	=> new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 28)),
				'receipt_number' 		=> new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 29)),
           	));
           	
           	
           	
		if(sfContext::getInstance()->getUser()->isSuperAdmin())
		{
			$this->widgetSchema['country_id'] = new sfWidgetFormChoice(
													array('choices' => array('' => $asWidgets['country_id']) + $this->asCountryList),
													array('tabindex'=>1, 'onChange' => "callAjaxRequest(this.value,'".url_for('facilitybooking/getCementryListAsPerCountry')."','facilitybooking_cementery_list');")
												);
			if($this->isNew())
				$this->setDefault('country_id', $this->snDefaultCountryId);
		}
		else
		{
			$snCemeteryId = sfContext::getInstance()->getUser()->getAttribute('cemeteryid');
			$oCemetery = Doctrine::getTable('CemCemetery')->find($snCemeteryId);
			$this->widgetSchema['country_id'] = new sfWidgetFormInputHidden(array(), array('value' => $oCemetery->getCountryId(),'readonly' => 'true'));
			$this->widgetSchema['cem_cemetery_id'] = new sfWidgetFormInputHidden(array(), array('value' => $snCemeteryId,'readonly' => 'true'));
			
			$this->widgetSchema['chapel_grouplist']	= new sfWidgetFormChoice(
															array('multiple' => true,'choices' => $this->amAllChapelTypes, 'default' => array_keys($this->amChapleAssociated) ),
															array('tabindex'=> 17)
													);
			
			$this->widgetSchema['room_grouplist']	= new sfWidgetFormChoice(
															array('multiple' => true, 'choices' => $this->amAllRoomTypes, 'default' => array_keys($this->amRoomAssociated) ),
															array('tabindex'=> 22)
														);

			$this->setDefault('cem_cemetery_id',$snCemeteryId);			
			$this->setDefault('country_id',$oCemetery->getCountryId());
		}              	
           	
		if($this->isNew()){
			$this->setDefault('chapel_time_from', date('d-m-Y H:i:s'));
			$this->setDefault('chapel_time_to', date('d-m-Y H:i:s'));
			$this->setDefault('room_time_from', date('d-m-Y H:i:s'));
			$this->setDefault('room_time_to', date('d-m-Y H:i:s'));
		}else {
			$this->setDefault('chapel_time_from', date('d-m-Y H:i:s',strtotime($this->getObject()->getChapelTimeFrom())));
			$this->setDefault('chapel_time_to', date('d-m-Y H:i:s',strtotime($this->getObject()->getChapelTimeTo())));
			$this->setDefault('room_time_from', date('d-m-Y H:i:s',strtotime($this->getObject()->getRoomTimeFrom())));
			$this->setDefault('room_time_to', date('d-m-Y H:i:s',strtotime($this->getObject()->getRoomTimeTo())));
		}		

        $this->widgetSchema->setNameFormat('facilitybooking[%s]'); 
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
		
        BaseFacilityBookingForm::setValidators(
	    	array(
				'title'       			=> new sfValidatorString(
                                            		array('required' => false, 'trim' => true)
                                        		),
                'surname'				=> new sfValidatorString( 
                       								array('required' => true, 'trim' => true),
                       								array('required' => $amValidators['surname']['required'])
												),
                'first_name'			=> new sfValidatorString( 
                       								array('required' => true, 'trim' => true),
                       								array('required' => $amValidators['first_name']['required'])
												),
				'email'       			=> new sfValidatorEmail(
                                            		array('required' => false, 'trim' => true),
													array('invalid' => $amValidators['email']['invalid'])
                                        		),
				'middle_name'       	=> new sfValidatorString(
                                            		array('required' => false, 'trim' => true)
                                        		),
				'telephone'       		=> new sfValidatorString(
                                            		array('required' => false, 'trim' => true)
                                        		),
				'mobile'       		=> new sfValidatorString(
                                            		array('required' => false, 'trim' => true)
                                        		),
				'address'     			=> new sfValidatorString(
                                            		array('required' => false, 'trim' => true)
                                        		),
				'suburb_town'       	=> new sfValidatorString(
                                            		array('required' => false, 'trim' => true)
                                        		),
				'state'     			=> new sfValidatorString(
                                            		array('required' => false, 'trim' => true)
                                        		),
				'postal_code'       	=> new sfValidatorString(
                                            		array('required' => false, 'trim' => true)
                                        		),
				'fax'       			=> new sfValidatorString(
                                            		array('required' => false, 'trim' => true)
                                        		),
				'area_code'     		=> new sfValidatorString(
                                            		array('required' => false, 'trim' => true)
                                        		),
				'fax_area_code'     	=> new sfValidatorString(
                                            		array('required' => false, 'trim' => true)
                                        		),
				'chapel'       			=> new sfValidatorChoice(
                                            		array('required' => false, 'choices' => array_keys($this->amStatus))
                                        		),
				'chapel_time_from'      => new sfValidatorString(
                                            		array('required' => false, 'trim' => true)
                                        		),
				'chapel_time_to'       	=> new sfValidatorString(
                                            		array('required' => false, 'trim' => true)
                                        		),
				'chapel_cost'       	=> new sfValidatorString(
                                            		array('required' => false, 'trim' => true)
                                        		),
				'room'       			=> new sfValidatorChoice(
                                            		array('required' => false, 'choices' => array_keys($this->amStatus))
                                        		),
				'room_time_from'       	=> new sfValidatorString(
                                            		array('required' => false, 'trim' => true)
                                        		),
				'room_time_to'       	=> new sfValidatorString(
                                            		array('required' => false, 'trim' => true)
                                        		),
				'room_cost'       		=> new sfValidatorString(
                                            		array('required' => false, 'trim' => true)
                                        		),
				'no_of_rooms'       	=> new sfValidatorString(
                                            		array('required' => false, 'trim' => true)
                                        		),
				'special_instruction'	=> new sfValidatorString(
                                            		array('required' => false, 'trim' => true)
                                        		),
				'receipt_number'       	=> new sfValidatorString(
                                            		array('required' => false, 'trim' => true)
                                        		)
			)
        );
		
		if(sfContext::getInstance()->getUser()->isSuperAdmin())
		{
			$this->validatorSchema['country_id'] = new sfValidatorChoice(
                                            		array('required' => true, 'choices' => array_keys($this->asCountryList)),
													array('required'=> $amValidators['country_id']['required'])
                                        			);
		}
		else
		{
			$this->validatorSchema['country_id']	= new sfValidatorDoctrineChoice(
														array('model'=>'Country','multiple'=>false,'required'=>false));

			$this->validatorSchema['cem_cemetery_id'] = new sfValidatorString(
															array('required' => false, 'trim' => true)
														);
			
			$this->validatorSchema['chapel_grouplist'] =  new sfValidatorChoice(
															array('multiple' => true, 'choices' => array_keys($this->amAllChapelTypes), 'required' => false)
														);
														
			$this->validatorSchema['room_grouplist'] = new sfValidatorChoice(
															array('multiple' => true, 'choices' => array_keys($this->amAllRoomTypes), 'required' => false)
														);
		}   		
		
		
		
		if($this->isNew())
		{
			$this->validatorSchema['chapel_time_from'] = new sfValidatorAnd(array(new sfValidatorDate(), new sfValidatorCallback(
																		array('callback'=> array($this,'checkValidDate')),
																		array('invalid'=> $amValidators['booking_invalid_date']['invalid']))
																		),															
																		array('required' => false, 'trim' => true)
																);
			
			$this->validatorSchema['chapel_time_to'] = new sfValidatorAnd(array(new sfValidatorDate(), new sfValidatorCallback(
																		array('callback'=> array($this,'checkValidDate')),
																		array('invalid'=> $amValidators['booking_invalid_date']['invalid']))
																		),															
																		array('required' => false, 'trim' => true)
																);
			
			$this->validatorSchema['room_time_from'] = new sfValidatorAnd(array(new sfValidatorDate(), new sfValidatorCallback(
																		array('callback'=> array($this,'checkValidDate')),
																		array('invalid'=> $amValidators['booking_invalid_date']['invalid']))
																		),															
																		array('required' => false, 'trim' => true)
																);
			
			$this->validatorSchema['room_time_to'] = new sfValidatorAnd(array(new sfValidatorDate(), new sfValidatorCallback(
																		array('callback'=> array($this,'checkValidDate')),
																		array('invalid'=> $amValidators['booking_invalid_date']['invalid']))
																		),															
																		array('required' => false, 'trim' => true)
																);
		}
    }
	/**
     * Fuction checkValidDate to check date is greater than or equal current date
     * @param $validator 	= Call Validator
     * @param $snCurrentDate 	= date
	 
	 * return  $snCurrentDate valid date
     */
	public function checkValidDate($validator, $snCurrentDate) 
	{	
		if(date("Y-m-d",strtotime($snCurrentDate)) < date('Y-m-d'))
			throw new sfValidatorError($validator, $this->ssInvalidDateMessage);
		else 
			return $snCurrentDate;
	}
	
	// over ride parent object named updateObject for set manual values 
	public function updateObject($values = null)
	{
		if(sfContext::getInstance()->getUser()->isSuperAdmin())
		{
			$this->values['cem_cemetery_id'] = sfContext::getInstance()->getRequest()->getParameter('facilitybooking_cem_cemetery_id');
			
			$amPostChapelTypes 	= sfContext::getInstance()->getRequest()->getParameter('chapel_grouplist');
			$amPostRoomTypes 	= sfContext::getInstance()->getRequest()->getParameter('room_grouplist');

			// SET CHAPEL TYPE IDS.		
			if($this->asPostData['chapel'] == 'YES' && count($amPostChapelTypes) > 0)
				$this->values['cem_chapel_ids'] = implode(',',$amPostChapelTypes);

			// SET ROOM TYPE IDS.
			if($this->asPostData['room'] == 'YES' && count($amPostRoomTypes) > 0 )
				$this->values['cem_room_ids'] = implode(',',$amPostRoomTypes);
		}
		else
		{
			if($this->asPostData['chapel'] == 'YES' && isset($this->asPostData['chapel_grouplist']) )
				$this->values['cem_chapel_ids'] = implode(',',$this->asPostData['chapel_grouplist']);

			if($this->asPostData['room'] == 'YES' && isset($this->asPostData['room_grouplist']) )
				$this->values['cem_room_ids'] = implode(',',$this->asPostData['room_grouplist']);
		}

//		echo "<pre>";print_r($this->values);exit;
		parent::updateObject($this->values);
	}
}
