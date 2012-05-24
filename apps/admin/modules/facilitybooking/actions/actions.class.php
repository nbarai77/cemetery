<?php
/**
 * Facility Booking actions.
 *
 * @package    Cemetery
 * @subpackage Facility Booking
 * @author     Prakash Panchal
 *
 */
sfProjectConfiguration::getActive()->loadHelpers(array('I18N'));
class facilitybookingActions extends sfActions
{
    /**
     * preExecutes  action
     *
     * @access public
     * @param sfRequest $request A request object
     */
    public function preExecute()
    {
        sfContext::getInstance()->getResponse()->addCacheControlHttpHeader('no-store, no-cache, must-revalidate, post-check=0, pre-check=0');

        // Declaration of messages.
        $this->amSuccessMsg = array(
                                    1 => __('Status changes successfully'),
                                    2 => __('Record has been updated successfully'),
                                    3 => __('Record has been deleted successfully'),
                                    4 => __('Record has been inserted successfully'),
                                );

        $this->amErrorMsg = array(1 => __('Please select at least one'),);
        $this->ssFormName = 'frm_list_facilitybooking';
        $omRequest        = sfContext::getInstance()->getRequest();

        // Set default values
        $this->amExtraParameters = array();
        $this->amExtraParameters['snPaging']        = $this->snPaging       = $omRequest->getParameter('paging',sfConfig::get('app_default_paging_records'));
        $this->amExtraParameters['snPage']          = $this->snPage         = $omRequest->getParameter('page', sfConfig::get('app_default_page', 1));
        //$this->amExtraParameters['ssSearchSurname']   	= $this->ssSearchName  	= trim($omRequest->getParameter('searchSurname',''));
        $this->amExtraParameters['ssSearchFirstName']   = $this->ssSearchIsEnabled  	= trim($omRequest->getParameter('searchFirstName',''));
        $this->amExtraParameters['ssSearchEmail']   	= $this->ssSearchName  			= trim($omRequest->getParameter('searchEmail',''));
        $this->amExtraParameters['ssSearchChapel']   	= $this->ssSearchChapel  		= trim($omRequest->getParameter('searchChapel',''));
        $this->amExtraParameters['ssSearchRoom']   		= $this->ssSearchRoom  			= trim($omRequest->getParameter('searchRoom',''));
        $this->amExtraParameters['ssSearchIsFinalized']	= $this->ssSearchIsFinalized  	= trim($omRequest->getParameter('searchIsFinalized',''));
        $this->amExtraParameters['ssSortBy']        	= $this->ssSortBy       		= $omRequest->getParameter('sortby','id');
        $this->amExtraParameters['ssSortMode']      	= $this->ssSortMode     		= $omRequest->getParameter('sortmode','desc');

        $this->ssSortQuerystr = $this->ssQuerystr = 'page='.$this->snPage.'&paging='.$this->snPaging;

        /*if($this->getRequestParameter('searchSurname') != '' )        // Search parameters
        {
            $this->ssQuerystr    .= '&searchSurname='.$this->getRequestParameter('searchSurname');
            $this->ssSortQuerystr.= '&searchSurname='.$this->getRequestParameter('searchSurname');
        }*/

        if($this->getRequestParameter('searchFirstName') != '' )        // Search parameters
        {
            $this->ssQuerystr    .= '&searchFirstName='.$this->getRequestParameter('searchFirstName');
            $this->ssSortQuerystr.= '&searchFirstName='.$this->getRequestParameter('searchFirstName');
        }

        if($this->getRequestParameter('searchEmail') != '' )        // Search parameters
        {
            $this->ssQuerystr    .= '&searchEmail='.$this->getRequestParameter('searchEmail');
            $this->ssSortQuerystr.= '&searchEmail='.$this->getRequestParameter('searchEmail');
        }

        if($this->getRequestParameter('searchChapel') != '' )        // Search parameters
        {
            $this->ssQuerystr    .= '&searchChapel='.$this->getRequestParameter('searchChapel');
            $this->ssSortQuerystr.= '&searchChapel='.$this->getRequestParameter('searchChapel');
        }
		
        if($this->getRequestParameter('searchRoom') != '' )        // Search parameters
        {
            $this->ssQuerystr    .= '&searchRoom='.$this->getRequestParameter('searchRoom');
            $this->ssSortQuerystr.= '&searchRoom='.$this->getRequestParameter('searchRoom');
        }
		
		if($this->getRequestParameter('searchIsFinalized') != '' )        // Search parameters
        {
            $this->ssQuerystr    .= '&searchIsFinalized='.$this->getRequestParameter('searchIsFinalized');
            $this->ssSortQuerystr.= '&searchIsFinalized='.$this->getRequestParameter('searchIsFinalized');
        }

        if($this->getRequestParameter('sortby') != '' )        // Sorting parameters
            $this->ssQuerystr .= '&sortby='.$this->getRequestParameter('sortby').'&sortmode='.$this->getRequestParameter('sortmode');

        $this->amExtraParameters['ssQuerystr']     = $this->ssQuerystr;
        $this->amExtraParameters['ssSortQuerystr'] = $this->ssSortQuerystr;
    }

   /**
    * Executes index action
    *
    * @access public
    * @param sfRequest $request A request object
    */
    public function executeIndex(sfWebRequest $request)
    {
        //set search combobox field
        $this->amSearch = array(
								'first_name' => array(
												'caption'	=> __('Informant First Name'),
												'id'		=> 'FirstName',
												'type'		=> 'text',																								
											),
								'email' => array(
												'caption'	=> __('Informant Email'),
												'id'		=> 'Email',
												'type'		=> 'text',																								
											),
								'chapel' => array(
												'caption' 	=> __('Chapel Booking'),
												'id'		=> 'Chapel',														
												'type' 		=> 'select',
												'options'	=> array(
												                    '' => __('All'),
																	'NO' => __('No'),
																	'YES' => __('Yes'),																			
																)															
											),
								'room' => array(
												'caption' 	=> __('Room Booking'),
												'id'		=> 'Room',														
												'type' 		=> 'select',
												'options'	=> array(
												                    '' => __('All'),
																	'NO' => __('No'),
																	'YES' => __('Yes'),																			
																)															
											),
								'is_finalized' => array(
												'caption' 	=> __('Finalized'),
												'id'		=> 'IsFinalized',														
												'type' 		=> 'checkbox',
												'options'	=> array()															
											),
							);

        $omCommon = new common();

        if($request->getParameter('admin_act') == "delete" && $request->getParameter('id'))            
        {
            $omCommon->DeleteRecordsComposite('FacilityBooking', $request->getParameter('id'),'id');
            $this->getUser()->setFlash('snSuccessMsgKey', 3);      
        }
		// Change status
        if($request->getParameter('admin_act') == "status" && $request->getParameter('id'))
        {
            $ssStatus     = ($request->getParameter('request_status') == "Finalized") ? 1 : '0';
            $ssSuccessKey = 1;

            $omCommon->UpdateStatusComposite('FacilityBooking','is_finalized', $request->getParameter('id'), $ssStatus, 'id');
            $this->getUser()->setFlash('snSuccessMsgKey', $ssSuccessKey); // set flag variable to display proper message
            unset($omCommon);
        }

        // Get cms page list for listing.
        $oFacilityBookingPageListQuery = Doctrine::getTable('FacilityBooking')->getFacilityBookingList($this->amExtraParameters, $this->amSearch);

        // Set pager and get results
        $oPager               = new sfMyPager();
        $this->oFacilityBookingList  = $oPager->getResults('FacilityBooking', $this->snPaging,$oFacilityBookingPageListQuery,$this->snPage);
        $this->amFacilityBookingList = $this->oFacilityBookingList->getResults(Doctrine::HYDRATE_ARRAY);

        unset($oPager);

        // Total number of records
        $this->snPageTotalFacilityBookingPages = $this->oFacilityBookingList->getNbResults();

        if($request->getParameter('request_type') == 'ajax_request')
            $this->setTemplate('listFacilityBookingUpdate');
    }
   /**
    * update action
    *
    * Update cms pages   
    * @access public
    * @param  object $oRequest A request object
    *     
    */
    public function executeAddedit(sfWebRequest $oRequest)
    {
        $snIdStoneMason = $oRequest->getParameter('id', '');
        $ssSuccessKey   = 4; // Success message key for add        
        $this->snCementeryId = $oRequest->getParameter('facilitybooking_cem_cemetery_id', '');        
        $this->asCementery = $this->amChapelUnAssociated = $this->amChapelAssociated = $this->amRoomUnAssociated = $this->amRoomAssociated = array();
        
        if($snIdStoneMason)
		{
            $this->forward404Unless($oFacilityBooking = Doctrine::getTable('FacilityBooking')->find($snIdStoneMason));
            $this->oFacilityBookingForm = new FacilityBookingForm($oFacilityBooking);
			
            $ssSuccessKey = 2; // Success message key for edit
            
			// For get Cementry List
			$this->asCementery = Doctrine::getTable('CemCemetery')->getAllCemeteries($oFacilityBooking->getCountryId()); 
			$this->snCementeryId = ($this->snCementeryId != '') ? $this->snCementeryId : $oFacilityBooking->getCemCemeteryId();
			
			if($this->getUser()->isSuperAdmin())
			{
				$this->amChapelUnAssociated = Doctrine::getTable('CemChapel')->getCemChapelTypes(array(),$this->snCementeryId);
				$this->amRoomUnAssociated 	= Doctrine::getTable('CemRoom')->getCemRoomTypes(array(),$this->snCementeryId);
			
				$amCemChapelIds = ($oFacilityBooking->getCemChapelIds() != '') ? explode(',',$oFacilityBooking->getCemChapelIds()) : array();
				$amCemRoomIds = ($oFacilityBooking->getCemRoomIds() != '') ? explode(',',$oFacilityBooking->getCemRoomIds()) : array();
				
				if(count($amCemChapelIds) > 0)
					$this->amChapelAssociated = Doctrine::getTable('CemChapel')->getCemChapelTypes($amCemChapelIds,$this->snCementeryId);
				if(count($amCemRoomIds) > 0)
					$this->amRoomAssociated = Doctrine::getTable('CemRoom')->getCemRoomTypes($amCemRoomIds,$this->snCementeryId);
			}			
        }
        else
            $this->oFacilityBookingForm = new FacilityBookingForm();

        $this->getConfigurationFields($this->oFacilityBookingForm);

		$amFacilityBookingRequestParameter = $oRequest->getParameter($this->oFacilityBookingForm->getName());

		$this->snCementeryId = isset($amFacilityBookingRequestParameter['cem_cemetery_id']) ? $amFacilityBookingRequestParameter['cem_cemetery_id'] : $this->snCementeryId;
		if($amFacilityBookingRequestParameter['country_id'] != '')
			$this->asCementery = Doctrine::getTable('CemCemetery')->getAllCemeteries($amFacilityBookingRequestParameter['country_id']);   
			
		// GET ASSOCIATED CHAPEL TYPES
		if($this->getUser()->isSuperAdmin())
		{
			if($this->snCementeryId > 0)			
			{
				$this->amChapelUnAssociated = Doctrine::getTable('CemChapel')->getCemChapelTypes(array(),$this->snCementeryId);
				if( count($oRequest->getParameter('chapel_grouplist')) > 0)
					$this->amChapelAssociated = Doctrine::getTable('CemChapel')->getCemChapelTypes($oRequest->getParameter('chapel_grouplist'));
			}
			// GET ASSOCIATED ROOM TYPES
			if($this->snCementeryId > 0)
			{
				$this->amRoomUnAssociated 	= Doctrine::getTable('CemRoom')->getCemRoomTypes(array(),$this->snCementeryId);
				if(count($oRequest->getParameter('room_grouplist')) > 0)
					$this->amRoomAssociated = Doctrine::getTable('CemRoom')->getCemRoomTypes($oRequest->getParameter('room_grouplist'));
			}
		}		
		
        if($oRequest->isMethod('post'))
        {
			$amFacilityBookingRequestParameter['chapel_time_from'] = (date("Y-m-d H:i:s",strtotime($amFacilityBookingRequestParameter['chapel_time_from'])));
			$amFacilityBookingRequestParameter['chapel_time_to'] = (date("Y-m-d H:i:s",strtotime($amFacilityBookingRequestParameter['chapel_time_to'])));
			$amFacilityBookingRequestParameter['room_time_from'] = (date("Y-m-d H:i:s",strtotime($amFacilityBookingRequestParameter['room_time_from'])));
			$amFacilityBookingRequestParameter['room_time_to'] = (date("Y-m-d H:i:s",strtotime($amFacilityBookingRequestParameter['room_time_to'])));

            $this->oFacilityBookingForm->bind($amFacilityBookingRequestParameter);
            
			$bSelectCemetery = false;
			if($this->getUser()->isSuperAdmin())
			{
				if($oRequest->getParameter('facilitybooking_cem_cemetery_id') != '')
					$bSelectCemetery = true;
			}
			else
				$bSelectCemetery = true;            
            
			
            if($this->oFacilityBookingForm->isValid() && $bSelectCemetery)
            {
				$snIdFacility = $this->oFacilityBookingForm->save()->getId();
				
				$oFacility = Doctrine::getTable('FacilityBooking')->find($snIdFacility);
				$oFacility->setTotal($amFacilityBookingRequestParameter['chapel_cost'] + $amFacilityBookingRequestParameter['room_cost']);
				$oFacility->save();				

				$this->getUser()->setFlash('snSuccessMsgKey', $ssSuccessKey);   //Set messages for add and update records
				$this->redirect('facilitybooking/index?'.$this->amExtraParameters['ssQuerystr']);
            }else {
				
				if(!$bSelectCemetery)
					$this->getUser()->setFlash('ssErrorCemeter',__('Please select cemetery'));
			}
        }
    }
    
	/**
    * Executes getCementryListAsPerCountry action
    *
    * @access public
    * @param sfRequest $request A request object
    */
    public function executeGetCementryListAsPerCountry(sfWebRequest $request)
    {	
		$snIdCountry = $request->getParameter('id','');	
		$asCementery = Doctrine::getTable('CemCemetery')->getAllCemeteries($snIdCountry);
		
		return $this->renderPartial('getCementeryList', array('asCementryList' => $asCementery));
	}    
	/**
    * Executes getChapelTypeLists action
    *
    * @access public
    * @param sfRequest $request A request object
    */
    public function executeGetChapelTypeLists(sfWebRequest $request)
    {		
		$snCemeteryId = $request->getParameter('cemetery_id','');	
		$amChapelUnAssociated = Doctrine::getTable('CemChapel')->getCemChapelTypes(array(), $snCemeteryId);
		
		return $this->renderPartial('getChapelTypes', array('amChapelUnAssociated' 	=> $amChapelUnAssociated, 
															'amChapelAssociated' 	=> array()
															));
	}
    /**
    * Executes getRoomTypeLists action
    *
    * @access public
    * @param sfRequest $request A request object
    */
    public function executeGetRoomTypeLists(sfWebRequest $request)
    {		
		$snCemeteryId = $request->getParameter('cemetery_id','');	
		$amRoomUnAssociated = Doctrine::getTable('CemRoom')->getCemRoomTypes(array(), $snCemeteryId);
		
		return $this->renderPartial('getRoomTypes', array('amRoomUnAssociated' 	=> $amRoomUnAssociated, 
															'amRoomAssociated' 		=> array()
															));
	}
    
    /**
     * getConfigurationFields
     *
     * Function for prepare configuration fields for form
     * @access private
     * @param  object $oForm form object
     *     
     */
    private function getConfigurationFields($oForm)
    {
        $oForm->setWidgets(
			array(
					'cem_cemetery_id' 	=> __('Select Cemetery'),
					'country_id'		=> __('Select Country'),
					'date_next'			=> __('Next'),
					'date_prev'			=> __('Previous')
				 )
		);

        $oForm->setLabels(
            array(
				'cem_cemetery_id'		=> __('Select Cemetery'),
				'country_id'       		=> __('Select Country'),
                'surname'            	=> __('Surname'),
                'first_name'            => __('First Name'),
                'middle_name'     	 	=> __('Middle Name'),
                'email'            		=> __('Email'),
                'telephone'            	=> __('Telephone'),	
				'mobile'				=> __('Mobile'),
                'address'     	 		=> __('Address'),
                'suburb_town'           => __('Suburb/Town'),
                'postal_code'           => __('Postal Code'),
				'country_id'       		=> __('Country'),				
                'fax'     	 			=> __('Fax'),
				'fax_area_code'  		=> __('Fax Area Code'),
				'area_code'     		=> __('Telephone Area Code'),
                'chapel'             	=> __('Chapel'),
                'room'            		=> __('Room'),
                'special_instruction'	=> __('Special Instruction'),
                'receipt_number'     	=> __('Receipt Number'),
				'chapel_grouplist'		=> __('Select Chapel Type'),
				'room_grouplist'		=> __('Select Room Type')
                
            )
        );

        $oForm->setValidators(
            array(
					'cem_cemetery_id'    => array(
												'required'  => __('Please select cemetery')
											),
    	            'country_id'    => array(
												'required'  => __('Please select country')
											),
    	            'surname'       => array(
												'required'  => __('Please enter surname')
											),
    	            'first_name'	=> array(
												'required'  => __('Please enter first name')
											),
	                'email'			=> array(
												'required'  => __('Please enter email'),
												'invalid'  => __('Please enter valid email')
											),
	                'booking_invalid_date'	=> array(
												'invalid'  => __('Please select valid date')
												),
	                'booking_date_past'		=> array(
												'invalid'  => __('Please select greater than or equal current date')
												)
				)
        );
    }
}
