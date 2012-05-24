<?php
/**
 * Service Booking actions.
 *
 * @package    Cemetery
 * @subpackage Service Booking
 * @author     Prakash Panchal      
 *
 */
sfProjectConfiguration::getActive()->loadHelpers(array('I18N','Url','Partial'));
class servicebookingActions extends sfActions
{
    /**
     * preExecutes  action
     *
     * @access public
     * @param sfRequest $request A request object
     */
    public function preExecute()
    {
		$this->getUser()->setAttribute('from_interments',false);
        sfContext::getInstance()->getResponse()->addCacheControlHttpHeader('no-store, no-cache, must-revalidate, post-check=0, pre-check=0');

        // Declaration of messages.
        $this->amSuccessMsg = array(
                                    1 => __('Status changes successfully'),
                                    2 => __('Record has been updated successfully'),
                                    3 => __('Record has been deleted successfully'),
                                    4 => __('Record has been inserted successfully'),
									5 => __('Record has been finalized successfully'),
									6 => __('Document has been successfully uploaded'),
									7 => __('Document has been successfully download'),
									8 => __('Document has been successfully updated'),
									9 => __('Letters has been sent successfully with attachment'),                                    
                                );

		$this->amErrorMsg   = array(
									1 => __('Select atleast one'), 
									2 => __('Some information was missing'),
									3 => __('This page is in a restricted area'),
									4 => __('Letters sending failed!'),
									5 => __('No letters select to send mail. Please select letters from Booking.'),
                                    6 => __('No record found for this selected date'),
									);
        $this->ssFormName = 'frm_list_servicebooking';
        $omRequest        = sfContext::getInstance()->getRequest();
		$this->ssIntermentDate = sfConfig::get('app_default_date_formate');

        // Set default values
        $this->amExtraParameters = array();
        $this->amExtraParameters['snPaging']        = $this->snPaging       = $omRequest->getParameter('paging',sfConfig::get('app_default_paging_records'));
        $this->amExtraParameters['snPage']          = $this->snPage         = $omRequest->getParameter('page', sfConfig::get('app_default_page', 1));
		
		if($omRequest->getParameter('flag') == 'true' || $omRequest->getParameter('reset') == 'true') 
		{
			$this->getUser()->setAttribute('int_country', '');
			$this->getUser()->setAttribute('int_cemetery', '');
			$this->getUser()->setAttribute('int_area', '');
			$this->getUser()->setAttribute('int_section', '');
			$this->getUser()->setAttribute('int_row', '');
			$this->getUser()->setAttribute('int_plot', '');
			$this->getUser()->setAttribute('int_grave', '');
		}
		if(!$this->getUser()->isSuperAdmin())
		{
			$this->snCemeteryId = $this->getUser()->getAttribute('cemeteryid');
			$oCemetery = Doctrine::getTable('CemCemetery')->find($this->snCemeteryId);
			$this->snCountryId = ($oCemetery) ? $oCemetery->getCountryId() : '';
			
			$this->getUser()->setAttribute('int_country', $this->snCountryId);
			$this->getUser()->setAttribute('int_cemetery', $this->snCemeteryId);
			
		}
		
		$this->amExtraParameters['ssSearchCountryId']   	= $this->ssSearchCountryId  = trim($omRequest->getParameter('searchCountryId',''));
		$this->amExtraParameters['ssSearchCountryId'] 		= ($this->ssSearchCountryId != '') ? $this->ssSearchCountryId : ( $this->getUser()->getAttribute('int_country') != '' ? $this->getUser()->getAttribute('int_country') : '');
		$this->amExtraParameters['ssSearchCemCemeteryId']   = $this->ssSearchCemeteryId = trim($omRequest->getParameter('searchCemCemeteryId',''));
		$this->amExtraParameters['ssSearchCemCemeteryId'] = ($this->ssSearchCemeteryId != '') ? $this->ssSearchCemeteryId : ($this->getUser()->getAttribute('int_cemetery') != '' ? $this->getUser()->getAttribute('int_cemetery') : '' );
		
		$this->ssSearchAreaId 		= trim($omRequest->getParameter('searchArAreaId',''));
		$this->ssSearchSectionId  	= trim($omRequest->getParameter('searchArSectionId',''));
		$this->ssSearchRowId 		= trim($omRequest->getParameter('searchArRowId',''));
		$this->ssSearchPlotId		= trim($omRequest->getParameter('searchArPlotId',''));
		$this->ssSearchArGraveId		= trim($omRequest->getParameter('searchArGraveId',''));		
		
		$this->ssSearchAreaId 		= ($this->ssSearchAreaId != '') ? $this->ssSearchAreaId : ( $this->getUser()->getAttribute('int_area') != '' ? $this->getUser()->getAttribute('int_area') : '' );
		$this->ssSearchSectionId 	= ($this->ssSearchSectionId != '') ? $this->ssSearchSectionId : ( $this->getUser()->getAttribute('int_section') != '' ? $this->getUser()->getAttribute('int_section') : '' );
		$this->ssSearchRowId 		= ($this->ssSearchRowId != '') ? $this->ssSearchRowId : ( $this->getUser()->getAttribute('int_row') != '' ? $this->getUser()->getAttribute('int_row') : '' );
		$this->ssSearchPlotId 		= ($this->ssSearchPlotId != '') ? $this->ssSearchPlotId : ( $this->getUser()->getAttribute('int_plot') != '' ? $this->getUser()->getAttribute('int_plot') : '' );
		$this->ssSearchArGraveId 		= ($this->ssSearchArGraveId != '') ? $this->ssSearchArGraveId : ( $this->getUser()->getAttribute('int_grave') != '' ? $this->getUser()->getAttribute('int_grave') : '' );

		$this->amExtraParameters['ssSearchArAreaId']   		= $this->ssSearchAreaId;
		$this->amExtraParameters['ssSearchArSectionId']   	= $this->ssSearchSectionId;
		$this->amExtraParameters['ssSearchArRowId']   		= $this->ssSearchRowId;
		$this->amExtraParameters['ssSearchArPlotId']   		= $this->ssSearchPlotId;
		$this->amExtraParameters['ssSearchArGraveId'] 		= $this->ssSearchArGraveId;
		
		$this->amExtraParameters['ssSearchDeceasedSurname']   	= $this->ssSearchDeceasedSurname  		= trim($omRequest->getParameter('searchDeceasedSurname',''));
		$this->amExtraParameters['ssSearchDeceasedFirstName']   = $this->ssSearchDeceasedFirstName 		= trim($omRequest->getParameter('searchDeceasedFirstName',''));
        $this->amExtraParameters['ssSearchControlNumber'] = $this->ssSearchControlNumber	= trim($omRequest->getParameter('searchControlNumber',''));
		
        $this->amExtraParameters['ssSortBy']        = $this->ssSortBy       = $omRequest->getParameter('sortby','created_at');
        $this->amExtraParameters['ssSortMode']      = $this->ssSortMode     = $omRequest->getParameter('sortmode','desc');

        $this->ssSortQuerystr = $this->ssQuerystr = 'page='.$this->snPage.'&paging='.$this->snPaging;
		
		if($this->ssSearchCountryId != '' )        // Search parameters
        {
            $this->ssQuerystr    .= '&searchCountryId='.$this->ssSearchCountryId;
            $this->ssSortQuerystr.= '&searchCountryId='.$this->ssSearchCountryId;
        }
		if($this->ssSearchCemeteryId != '' )        // Search parameters
        {
            $this->ssQuerystr    .= '&searchCemCemeteryId='.$this->ssSearchCemeteryId;
            $this->ssSortQuerystr.= '&searchCemCemeteryId='.$this->ssSearchCemeteryId;
        }
		if($this->ssSearchAreaId != '' )        // Search parameters
        {
            $this->ssQuerystr    .= '&searchArAreaId='.$this->ssSearchAreaId;
            $this->ssSortQuerystr.= '&searchArAreaId='.$this->ssSearchAreaId;
        }
		if($this->ssSearchSectionId != '' )        // Search parameters
        {
            $this->ssQuerystr    .= '&searchArSectionId='.$this->ssSearchSectionId;
            $this->ssSortQuerystr.= '&searchArSectionId='.$this->ssSearchSectionId;
        }
		if($this->ssSearchRowId != '' )        // Search parameters
        {
            $this->ssQuerystr    .= '&searchArRowId='.$this->ssSearchRowId;
            $this->ssSortQuerystr.= '&searchArRowId='.$this->ssSearchRowId;
        }
        if($this->ssSearchPlotId != '' )        // Search parameters
        {
            $this->ssQuerystr    .= '&searchArPlotId='.$this->ssSearchPlotId;
            $this->ssSortQuerystr.= '&searchArPlotId='.$this->ssSearchPlotId;
        }
		if($this->ssSearchArGraveId != '' )        // Search parameters
        {
            $this->ssQuerystr    .= '&searchArGraveId='.$this->ssSearchArGraveId;
            $this->ssSortQuerystr.= '&searchArGraveId='.$this->ssSearchArGraveId;
        }
		if($this->ssSearchDeceasedSurname != '' )        // Search parameters
        {
            $this->ssQuerystr    .= '&searchDeceasedSurname='.$this->ssSearchDeceasedSurname;
            $this->ssSortQuerystr.= '&searchDeceasedSurname='.$this->ssSearchDeceasedSurname;
        }
		if($this->ssSearchDeceasedFirstName != '' )        // Search parameters
        {
            $this->ssQuerystr    .= '&searchDeceasedFirstName='.$this->ssSearchDeceasedFirstName;
            $this->ssSortQuerystr.= '&searchDeceasedFirstName='.$this->ssSearchDeceasedFirstName;
        }
		if($this->ssSearchControlNumber != '' )        // Search parameters
        {
            $this->ssQuerystr    .= '&searchControlNumber='.$this->ssSearchControlNumber;
            $this->ssSortQuerystr.= '&searchControlNumber='.$this->ssSearchControlNumber;
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
    public function executeInterment(sfWebRequest $request)
    {
		if($request->isMethod('post') && $request->getParameter('request_type') == 'ajax_request')
		{
			$ssSearchCountryId  = trim($request->getParameter('searchCountryId',''));
			$ssSearchCemeteryId = trim($request->getParameter('searchCemCemeteryId',''));
			
			$this->snCemeteryId = $this->getUser()->getAttribute('cemeteryid');
			if($ssSearchCemeteryId == '') {
				$ssSearchCemeteryId = $this->getUser()->setAttribute('int_cemetery', $this->snCemeteryId);				
			}
			
			if($ssSearchCountryId == '') {
				$oCemetery = Doctrine::getTable('CemCemetery')->find($this->snCemeteryId);
				$this->snCountryId = ($oCemetery) ? $oCemetery->getCountryId() : '';
				$ssSearchCountryId = $this->getUser()->setAttribute('int_country', $this->snCountryId);				
			}
			
			$ssSearchAreaId 	= trim($request->getParameter('searchArAreaId',''));
			$ssSearchSectionId  = trim($request->getParameter('searchArSectionId',''));
			$ssSearchRowId 		= trim($request->getParameter('searchArRowId',''));
			$ssSearchPlotId		= trim($request->getParameter('searchArPlotId',''));
			$ssSearchGraveId	= trim($request->getParameter('searchArGraveId',''));
			
			//$this->getUser()->setAttribute('int_country', $ssSearchCountryId);
			//$this->getUser()->setAttribute('int_cemetery', $ssSearchCemeteryId);
			$this->getUser()->setAttribute('int_area', ($ssSearchAreaId != '') ? $ssSearchAreaId : '');
			$this->getUser()->setAttribute('int_section', ($ssSearchSectionId != '') ? $ssSearchSectionId : '');
			$this->getUser()->setAttribute('int_row', ($ssSearchRowId != '') ? $ssSearchRowId : '');
			$this->getUser()->setAttribute('int_plot', ($ssSearchPlotId != '') ? $ssSearchPlotId : '');
			$this->getUser()->setAttribute('int_grave', ($ssSearchGraveId != '') ? $ssSearchGraveId : '');
		}
		
		// For get Country list to fill Country Combo.
		$this->asCountryList = array();
		$omCriteria = Doctrine::getTable('Country')->getCountryList(array(),array());
		$amCountry = $omCriteria->orderBy('sf.name')->fetchArray();
		if(count($amCountry) > 0)
		{
			foreach($amCountry as $asDataSet)
				$this->asCountryList[$asDataSet['id']] = $asDataSet['name'];
		}
		
        //set search combobox field
        $this->amSearch = array(
								'ar_area_id' => array(
												'caption'	=> __('Area'),
												'id'		=> 'ArAreaId',
												'type'		=> 'selectajax',
												'ssPartial' => 'getCustomAreaList',
												'ssArrayKey' => 'asAreaList',
												'ssArrayValue' 	=> 'snAreaId',
												'options'	=> array()
											),
								'ar_section_id' => array(
												'caption'	=> __('Section'),
												'id'		=> 'ArSectionId',
												'type'		=> 'selectajax',
												'ssPartial' => 'getCustomSectionList',
												'ssArrayKey' => 'asSectionList',
												'ssArrayValue' 	=> 'snSectionId',
												'options'	=> array()
											),
								'ar_row_id' => array(
												'caption'	=> __('Row'),
												'id'		=> 'ArRowId',
												'type'		=> 'selectajax',
												'ssPartial' => 'getCustomRowList',
												'ssArrayKey' => 'asRowList',
												'ssArrayValue' 	=> 'snRowId',
												'options'	=> array()
											),
								'ar_plot_id' => array(
												'caption'	=> __('Plot'),
												'id'		=> 'ArPlotId',
												'type'		=> 'selectajax',
												'ssPartial' => 'getCustomPlotList',
												'ssArrayKey' => 'asPlotList',
												'ssArrayValue' 	=> 'snPlotId',
												'options'	=> array()
											),
								'ar_grave_id' => array(
												'caption'	=> __('Grave'),
												'id'		=> 'ArGraveId',
												'type'		=> 'selectajax',
												'ssPartial' => 'getCustomGraveList',
												'ssArrayKey' => 'asGraveList',
												'ssArrayValue' 	=> 'snGraveId',
												'options'	=> array()
											),
								'deceased_surname' => array(
												'caption'	=> __('Surname'),
												'id'		=> 'DeceasedSurname',
												'type'		=> 'text',
											),
								'deceased_first_name' => array(
												'caption'	=> __('First Name'),
												'id'		=> 'DeceasedFirstName',
												'type'		=> 'text',
											),
								'control_number' => array(
												'caption'	=> __('Control Number'),
												'id'		=> 'ControlNumber',
												'type'		=> 'integer',
												'alias'		=> 'ibf'
											)
							);

		if($this->getUser()->isSuperAdmin())
		{
			$this->amSearch = array(
								'country_id' => array(
												'caption'	=> __('Country'),
												'id'		=> 'CountryId',
												'type'		=> 'selectcountry',
												'options'	=> $this->asCountryList
											),
								'cem_cemetery_id' => array(
												'caption'	=> __('Cemetery'),
												'id'		=> 'CemCemeteryId',
												'type'		=> 'selectajax',
												'ssPartial' => 'getCustomCementeryList',
												'ssArrayKey' => 'asCementryList',
												'ssArrayValue' 	=> 'snCementeryId',
												'options'	=> array()
											)															
							) + $this->amSearch;
		}

		$this->getUser()->setAttribute('interments',1);
		$this->amExtraParameters['ssSortBy'] = $this->ssSortBy  = 'interment_date';
		
        $omCommon = new common();

        if($request->getParameter('admin_act') == "delete" && $request->getParameter('id'))            
        {
			// FOR UPDATE user_id WHO DELETE THE RECORDS.
			$omCommon->UpdateStatusComposite('IntermentBooking','user_id', $request->getParameter('id'), $this->getUser()->getAttribute('userid'), 'id');
			
            $omCommon->DeleteRecordsComposite('IntermentBooking', $request->getParameter('id'),'id');
            $this->getUser()->setFlash('snSuccessMsgKey', 3);
        }
		
		// Change status
        if($request->getParameter('admin_act') == "status" && $request->getParameter('id'))
        {   
            $ssStatus     = ($request->getParameter('request_status') == "Private") ? 1 : '0';
            $ssSuccessKey = 1;

            $omCommon->UpdateStatusComposite('IntermentBooking','is_private', $request->getParameter('id'), $ssStatus, 'id');
            $this->getUser()->setFlash('snSuccessMsgKey', $ssSuccessKey); // set flag variable to display proper message
            unset($omCommon);
        }

        $oIntermentPageListQuery = Doctrine::getTable('IntermentBooking')->getServiceBookingList($this->amExtraParameters, $this->amSearch, '', true);
		
		// Replace Doctrine Pager Count Query By Mannual Count Query.
		$ssCountQuery  = Doctrine::getTable('IntermentBooking')->getServiceBookingListCount($this->amExtraParameters, $this->amSearch, '', true);

        // Set pager and get results
        $oPager               = new sfMyPager();
        $this->oIntermentList  = $oPager->getResults('IntermentBooking', $this->snPaging,$oIntermentPageListQuery,$this->snPage,$ssCountQuery);
        $this->amIntermentList = $this->oIntermentList->getResults(Doctrine::HYDRATE_ARRAY);

        unset($oPager);

        // Total number of records
        $this->snPageTotalIntermentPages = $this->oIntermentList->getNbResults();

        if($request->getParameter('request_type') == 'ajax_request')
            $this->setTemplate('listIntermentUpdate');
	}
   /**
    * Executes index action
    *
    * @access public
    * @param sfRequest $request A request object
    */
    public function executeIndex(sfWebRequest $request)
    {
		$this->getUser()->setAttribute('interments','');
		
        //set search combobox field
        $this->amSearch = array();

        $omCommon = new common();

        if($request->getParameter('admin_act') == "delete" && $request->getParameter('id'))            
        {
			// FOR UPDATE user_id WHO DELETE THE RECORDS.
			$omCommon->UpdateStatusComposite('IntermentBooking','user_id', $request->getParameter('id'), $this->getUser()->getAttribute('userid'), 'id');
			
            $omCommon->DeleteRecordsComposite('IntermentBooking', $request->getParameter('id'),'id');
            $this->getUser()->setFlash('snSuccessMsgKey', 3);      
        }

        $oIntermentBookingPageListQuery = Doctrine::getTable('IntermentBooking')->getServiceBookingList($this->amExtraParameters, $this->amSearch);
	
		// Replace Doctrine Pager Count Query By Mannual Count Query.		
		$ssCountQuery =Doctrine::getTable('IntermentBooking')->getServiceBookingListCount($this->amExtraParameters, $this->amSearch);
		
		// Set pager and get results
		$oPager               = new sfMyPager();
		$this->oIntermentBookingList  = $oPager->getResults('IntermentBooking', $this->snPaging,$oIntermentBookingPageListQuery,$this->snPage,$ssCountQuery);
		$this->amIntermentBookingList = $this->oIntermentBookingList->getResults(Doctrine::HYDRATE_ARRAY);
        
		unset($oPager);

		// Total number of records
		$this->snPageTotalIntermentBookingPages = $this->oIntermentBookingList->getNbResults();

        if($request->getParameter('request_type') == 'ajax_request')
            $this->setTemplate('listIntermentBookingUpdate');
    }
	

   /**
    * Executes booking invoice action
    *
    *
    * @access public
    * @param sfRequest $request A request object
    */
    public function executeBookingInvoice(sfWebRequest $oRequest)
    {
		$this->getUser()->setAttribute('interments','');
		
        //set search combobox field
        $this->amSearch = array();
        $omCommon = new common();
        $oIntermentBookingPageListQuery = Doctrine::getTable('IntermentBooking')->getServiceBookingList($this->amExtraParameters, $this->amSearch,'','',true);
	
		// Replace Doctrine Pager Count Query By Mannual Count Query.		
		$ssCountQuery =Doctrine::getTable('IntermentBooking')->getServiceBookingListCount($this->amExtraParameters, $this->amSearch);
		
		// Set pager and get results
		$oPager               = new sfMyPager();
		$this->oIntermentBookingList  = $oPager->getResults('IntermentBooking', $this->snPaging,$oIntermentBookingPageListQuery,$this->snPage,$ssCountQuery);
		$this->amIntermentBookingList = $this->oIntermentBookingList->getResults(Doctrine::HYDRATE_ARRAY);
        
		unset($oPager);        
        $this->oGravePlotReportForm = new ServiceReportForm();        
        $this->getExportConfigurationFields($this->oGravePlotReportForm);
        
        $amGraveFormRequest = $oRequest->getParameter($this->oGravePlotReportForm->getName());
        
        if($oRequest->isMethod('post') && $oRequest->getParameter('request_type') != 'ajax_request')
       	{			
            $this->ssFromDate 	= ((isset($amGraveFormRequest['from_date']) && $amGraveFormRequest['from_date'] != '') ? $amGraveFormRequest['from_date'] : '');
			$this->ssToDate		= ((isset($amGraveFormRequest['to_date']) && $amGraveFormRequest['to_date'] != '') ? $amGraveFormRequest['to_date'] : '');

			// FOR SERVICE REPORT AS PER BETWEEN FROM AND TO DATE
			if($this->ssToDate != '')
			{
				$ssFormatedFromDate = (($this->ssFromDate != '') ?date('Y-m-d', strtotime($this->ssFromDate)):'');
                $ssFormatedToDate = date('Y-m-d', strtotime($this->ssToDate));
                $asServiceReport = Doctrine::getTable('IntermentBooking')->getServiceBookingList($this->amExtraParameters, $this->amSearch,'',true,true,'',$ssFormatedFromDate, $ssFormatedToDate)->fetchArray();
            }
            
            if(count($asServiceReport) > 0)
            {
                $ssFilename = "Invoices.csv"; 
                $this->getResponse()->setHttpHeader('Content-Disposition', 'attachment; filename=' . basename($ssFilename));
                $this->getResponse()->setContentType('text/csv;charset=ISO-8859-2');
                $ssContents = "";
                $ssContents .= 'Deceased Name,Catalog Name,Cost Price,Special Cost Price, Service Type Name';
                $ssContents .= "\n"; 
                foreach($asServiceReport as $snKey=>$asValues)
                {
                    $ssContents .= $asValues['deceased_surname']." ".$asValues['deceased_first_name'].","; 
                    $ssContents .= $asValues['catalog_name'].",";
                    $ssContents .= $asValues['cost_price'].",";
                    $ssContents .= $asValues['special_cost_price'].",";
                    $ssContents .= $asValues['service_type_name'].",";
                    $ssContents .= ($asValues['payment_id'] == 1 ? 'Credit' : ($asValues['payment_id'] == 2 ? 'Waiting' : ($asValues['payment_id'] == 3 ? 'Pending' : ''))).",";
                    $ssContents .= "\n"; 
                }
                
                $this->getResponse()->setContent($ssContents);        
                $this->getResponse()->sendHttpHeaders();
                
                return sfView::NONE;
            }
            else
                $this->getUser()->setFlash('snErrorMsgKey', 6);
		}
        // Total number of records
		$this->snPageTotalIntermentBookingPages = $this->oIntermentBookingList->getNbResults();

        if($oRequest->getParameter('request_type') == 'ajax_request')
            $this->setTemplate('listIntermentBookingUpdate');
    }

    /**
     * Executes GenerateTransferGraveInvoice action
     *
     * @access public
     * @param sfRequest $request A request object
     */
    public function executeGenerateBookingInvoice(sfWebRequest $oRequest)
    {            
        $snBookingId = $oRequest->getParameter('booking_id','');
        $this->snCementeryId = $this->getUser()->getAttribute('cemeteryid');
        
        $this->oIntermentBookingPageListQuery = Doctrine::getTable('IntermentBooking')->getServiceBookingList($this->amExtraParameters, $this->amSearch,'','',true,$snBookingId)->fetchArray();
        
        $ssContent = '';
        
        if(count($this->oIntermentBookingPageListQuery) > 0)
        {
            $ssContent .= '<table><tr><td>Service Invoices</td><td></td><td></td><td></td><td>'.date('d-m-Y H:m').'</td></tr></table>';
            $ssContent .= '<table cellspacing="0" cellpadding="0" border="1"><tr><td>Deceased Name</td><td>Payment name</td><td>Cost price</td><td>Special price</td><td>Payment status</td></tr>';
            foreach($this->oIntermentBookingPageListQuery as $snKey=>$asValues)
            {
                $ssContent .= '<tr><td valign="top" align="left">'.$asValues['deceased_surname']." ".$asValues['deceased_first_name'].'</td>                
                <td valign="top" align="left">'.$asValues['catalog_name'].'</td>
                <td valign="top" align="left">'.$asValues['cost_price'].'</td>
                <td valign="top" align="left">'.$asValues['special_cost_price'].'</td>
                <td valign="top" align="left">'.($asValues['payment_id'] == 1 ? 'Credit' : ($asValues['payment_id'] == 2 ? 'Waiting' : ($asValues['payment_id'] == 3 ? 'Pending' : ''))).'</td></tr>';                
            }
            $ssContent .= '</table>';
        }
        
        sfGeneral::getPDFContentReport($ssContent);
    }
    
    /**
     * getConfigurationFields
     *
     * Function for prepare configuration fields for form
     * @access private
     * @param  object $oForm form object
     *     
     */
    private function getExportConfigurationFields($oForm)
    {
        $oForm->setWidgets(
			array(
					'country_id'		=> __('Select Country'),
					'cem_cemetery_id'  => __('Select Cemetery'),
					'reports_identity_id' => __('Select Grantee Identity')
				 )
		);
		/*
		$oForm->setDefault('country_id', $this->getUser()->getAttribute('cn'));
		$oForm->setDefault('from_date', $this->getUser()->getAttribute('from_date'));		
		$oForm->setDefault('to_date', $this->getUser()->getAttribute('to_date'));
		*/
		$oForm->setDefault('country_id', $this->amPostRequest['country_id']);
		$oForm->setDefault('from_date', $this->amPostRequest['from_date']);
		$oForm->setDefault('to_date', $this->amPostRequest['to_date']);
		
        $oForm->setLabels(
            array(
                'country_id'       	=> __('Select Country'),
                'cem_cemetery_id'  	=> __('Select Cemetery'),
				'from_date'  		=> __('From Date'),
				'to_date'  			=> __('To Date')
            )
        );
    }
    
	public function executeFinalized(sfWebRequest $oRequest)
    {
		//////////////////////////////////////////////////////////////////
		//						CHECED FOR IS FINALISED					//
		//////////////////////////////////////////////////////////////////

		$snIntermentBookingId = $oRequest->getParameter('id', '');
		$this->ssControlNumber = $oRequest->getParameter('control_number', '');
		$this->ssIntermentDate = $oRequest->getParameter('interment_date', '');
		
		$this->oFinalizedBookingForm = new FinalizedBookingForm();

		$this->getConfigurationFieldsForFinalizedBooking($this->oFinalizedBookingForm);
		if($oRequest->isMethod('post'))
        {
			$amFinalizedBookingFormRequest = $oRequest->getParameter($this->oFinalizedBookingForm->getName());
			$this->oFinalizedBookingForm->bind($amFinalizedBookingFormRequest);
						
			if($this->oFinalizedBookingForm->isValid())
			{
				$oIntermentBooking = Doctrine::getTable('IntermentBooking')->find($snIntermentBookingId);
				
				// Update deases details are finalised.
				if(!empty($oIntermentBooking))
				{
					$ssIntermentDate = date('Y-m-d');
					if($amFinalizedBookingFormRequest['interment_date'] != '') 
					{
						list($snDay,$snMonth,$snYear) = explode('-', trim($amFinalizedBookingFormRequest['interment_date']));
						$ssIntermentDate = $snYear.'-'.$snMonth.'-'.$snDay;
					}
					// Update interment date when it will be finalized.
					IntermentBooking::updateBookingIsFinalised($oIntermentBooking->getId(),$ssIntermentDate, $oIntermentBooking->getArGraveId(),$oIntermentBooking->getGranteeId());
					
					// UPDATE CONTROL NUMBER IF CHANGED
					$omCommon = new common();
					$omCommon->UpdateStatusComposite('IntermentBookingFour','control_number', $oIntermentBooking->getId(), $amFinalizedBookingFormRequest['control_number'], 'interment_booking_id');
					
					$this->getUser()->setFlash('snSuccessMsgKey', 5);   //Set messages for add and update records
						
					echo "<script type='text/javascript'>";
					echo "document.location.href='".url_for('servicebooking/index?'.$this->amExtraParameters['ssQuerystr'])."';";
					echo "</script>";exit;
				}
				else
				{
					$this->getUser()->setFlash('snSuccessMsgKey', 2);   //Set messages for add and update records
					echo "<script type='text/javascript'>";
					echo "document.location.href='".url_for('servicebooking/addedit')."';";
					echo "</script>";exit;
				}
			}
			return $this->renderPartial('finalizedBooking', array('oFinalizedBookingForm' => $this->oFinalizedBookingForm, 
																  'amExtraParameters' => $this->amExtraParameters,
																  'ssControlNumber'	=> $this->ssControlNumber
																  ));
		}
	}
   /**
    * update action
    *
    * Update IntermentBooking pages   
    * @access public
    * @param  object $oRequest A request object
    *     
    */
    public function executeAddedit(sfWebRequest $oRequest)
    {
        $snIntermentBookingId = $oRequest->getParameter('id', '');
		$this->snTabKey = $oRequest->getParameter('tab','step1');
        $ssSuccessKey   = 4; // Success message key for add
		
		$this->asCementery = $this->asAreaList = $this->asSectionList = $this->asRowList = $this->asPlotList = $this->asGraveList = $this->amGranteeDetails = $this->amGraveUnitType = $this->amStoneMason = $this->amGraveDetailsParams = $this->amChapelUnAssociated = $this->amChapelAssociated = $this->amRoomUnAssociated = $this->amRoomAssociated = array();

		//////////////////////////////////////////////////////////////////////////////////
		//							FOR BOOKING STEP - 1								//
		//////////////////////////////////////////////////////////////////////////////////
		
		$this->snCementeryId = $oRequest->getParameter('service_cem_cemetery_id', '');
		$this->snAreaId = $oRequest->getParameter('service_ar_area_id', '');
		$this->snSectionId = $oRequest->getParameter('service_ar_section_id', '');
		$this->snRowId = $oRequest->getParameter('service_ar_row_id', '');
		$this->snPlotId = $oRequest->getParameter('service_ar_plot_id', '');
		$this->snGraveId = $oRequest->getParameter('service_ar_grave_id', '');
		
		// Grantee Details variables declarations
		$this->snGranteeId = $oRequest->getParameter('service_grantee_id', '');
		$this->snGraveStatusId = $oRequest->getParameter('service_ar_grave_status', '');
		$this->ssGranteeRelationShip = $oRequest->getParameter('service_grantee_relationship', '');
		$this->ssGranteeRemarks1 = trim($oRequest->getParameter('service_grantee_remarks_1', ''));
		$this->ssGranteeRemarks2 = trim($oRequest->getParameter('service_grantee_remarks_2', ''));
		
		// Grave/Plot Details varibales declarations
		$this->amGraveDetailsParams['ssGraveLength'] = $oRequest->getParameter('service_grave_length', '');
		$this->amGraveDetailsParams['ssGraveWidth'] = $oRequest->getParameter('service_grave_width', '');
		$this->amGraveDetailsParams['ssGraveHeight'] = $oRequest->getParameter('service_grave_depth', '');
		$this->amGraveDetailsParams['snIdGraveUnitType'] = $oRequest->getParameter('service_grave_unit_type', '');
		$this->amGraveDetailsParams['snIdGraveUnitType'] = $oRequest->getParameter('service_grave_unit_type', '');
        
		$this->amGraveDetailsParams['ssGraveComment1'] = trim($oRequest->getParameter('service_grave_comment1', ''));
		$this->amGraveDetailsParams['ssGraveComment2'] = trim($oRequest->getParameter('service_grave_comment2', ''));

		$this->smIsFinalised = $oRequest->getParameter('is_finalise', '');
		$this->ssTakenBy = $this->amGraveDetailsParams['ssGraveStatus'] = $this->ssControlNumber = '';

		if($snIntermentBookingId)
		{   
            $oIntermentFifthDetail = Doctrine::getTable('IntermentBookingFive')->findOneByIntermentBookingId($snIntermentBookingId);            
            if(count($oIntermentFifthDetail) == 0)
            {  
               $ssType = 'letter';
               $this->asLetterDetail = Doctrine_Query::create()
                            ->select('mc.*')
                            ->from('MailContent mc')
							->andWhere('mc.country_id =?',$this->getUser()->getAttribute('int_country'))
							->andWhere('mc.cem_cemetery_id =?',$this->getUser()->getAttribute('int_cemetery'))                                                    
                            ->andWhere('mc.type = ?', $ssType)
							->fetchArray();
               
                foreach($this->asLetterDetail as $snKey=>$asVal)
                {
                   
                    $oBooking5 = new IntermentBookingFive();
                    $oBooking5->setIntermentBookingId($snIntermentBookingId);
                    $oBooking5->setMailContentId($asVal['id']);
                    //$oBooking5->setStatus($snIdIntermentBooking);
                    $oBooking5->save();
                }
            }
            
			$this->forward404Unless($oIntermentBooking = Doctrine::getTable('IntermentBooking')->find($snIntermentBookingId));
			
			if(($oIntermentBooking->getIsFinalized() == 0 && ($this->getUser()->getAttribute('groupid') == 2 || $this->getUser()->getAttribute('issuperadmin') == 1)))
				$this->finalize_button_check = true;
			else	
				$this->finalize_button_check = false;
			
			$this->oIntermentBookingForm = new IntermentBookingForm($oIntermentBooking);
			$ssSuccessKey = 2; // Success message key for edit
			
			$this->snCementeryId = ($this->snCementeryId != '') ? $this->snCementeryId : $oIntermentBooking->getCemCemeteryId();
			$this->ssIntermentDate = ($oIntermentBooking->getIntermentDate() != '') ? date('d-m-Y', strtotime($oIntermentBooking->getIntermentDate()) ) : sfConfig::get('app_default_date_formate');

			if($oIntermentBooking->getTakenBy() != '') 
			{
				$oUser =  Doctrine::getTable('sfGuardUser')->find($oIntermentBooking->getTakenBy());				
				$this->ssTakenBy = ($oUser) ? $oUser->getFirstName().' '.$oUser->getLastName() : '';				
			}
			else
				$this->ssTakenBy = '';
			
			///////////////////////////////////////////////////////
			//				FOR GET EMBED FORM DETAILS			 //
			///////////////////////////////////////////////////////				
			$oIntermentBookingTwo = Doctrine::getTable('IntermentBookingTwo')->findByIntermentBookingId($snIntermentBookingId);
			
			if(count($oIntermentBookingTwo) > 0)
			{
				// CHAPEL AND ROOM TYPES
				if($this->getUser()->isSuperAdmin())
				{
					$this->amChapelUnAssociated = Doctrine::getTable('CemChapel')->getCemChapelTypes(array(),$this->snCementeryId);
					$this->amRoomUnAssociated 	= Doctrine::getTable('CemRoom')->getCemRoomTypes(array(),$this->snCementeryId);
				
					$amCemChapelIds = ($oIntermentBookingTwo[0]->getCemChapelIds() != '') ? explode(',',$oIntermentBookingTwo[0]->getCemChapelIds()) : array();
					$amCemRoomIds = ($oIntermentBookingTwo[0]->getCemRoomIds() != '') ? explode(',',$oIntermentBookingTwo[0]->getCemRoomIds()) : array();
					
					if(count($amCemChapelIds) > 0)
						$this->amChapelAssociated = Doctrine::getTable('CemChapel')->getCemChapelTypes($amCemChapelIds,$this->snCementeryId);
					if(count($amCemRoomIds) > 0)
						$this->amRoomAssociated = Doctrine::getTable('CemRoom')->getCemRoomTypes($amCemRoomIds,$this->snCementeryId);
				}
			}
		}
		else {
			$this->oIntermentBookingForm = new IntermentBookingForm();
			$this->finalize_button_check = false;
		}

		$this->getConfigurationFields($this->oIntermentBookingForm);

		$amBookingFirstReq = $oRequest->getParameter($this->oIntermentBookingForm->getName());
		$this->snCementeryId = isset($amBookingFirstReq['cem_cemetery_id']) ? $amBookingFirstReq['cem_cemetery_id'] : $this->snCementeryId;

		$snCountryId = isset($amBookingFirstReq['country_id']) ? $amBookingFirstReq['country_id'] : '';
		
		if($snCountryId != '')
			$this->asCementery = Doctrine::getTable('CemCemetery')->getAllCemeteries($snCountryId);
		if($this->snCementeryId != '' && $snCountryId != '')
			$this->asAreaList = Doctrine::getTable('ArArea')->getAreaListAsPerCemetery($snCountryId, $this->snCementeryId);
		if($snCountryId != '' && $this->snCementeryId != '')
			$this->asSectionList = Doctrine::getTable('ArSection')->getSectionListAsPerArea($snCountryId, $this->snCementeryId, $this->snAreaId);
		if($snCountryId != '' && $this->snCementeryId != '')
			$this->asRowList = Doctrine::getTable('ArRow')->getRowListAsPerSection($snCountryId, $this->snCementeryId, $this->snAreaId, $this->snSectionId);
		if($snCountryId != '' && $this->snCementeryId != '')
			$this->asPlotList = Doctrine::getTable('ArPlot')->getPlotListAsPerArea($snCountryId,$this->snCementeryId,$this->snAreaId,$this->snSectionId,$this->snRowId);
		if($snCountryId != '' && $this->snCementeryId != '')
			$this->asGraveList = Doctrine::getTable('ArGrave')->getGraveListAsPerCriteria($snCountryId,$this->snCementeryId,$this->snAreaId,$this->snSectionId,$this->snRowId,$this->snPlotId,'true');
		if($snCountryId != '' && $this->snCementeryId != '')
			$this->amGranteeDetails = Doctrine::getTable('Grantee')->getGranteeDetailsAsPerGrave($this->snGraveId);

		// For get grave status array.
		$this->asGraveStatus = Doctrine::getTable('ArGraveStatus')->getGraveStatus();
		// For get Unit Type array.
		$this->amGraveUnitType = Doctrine::getTable('UnitType')->getGraveUnitTypes();
		// For get Stone Masons array.
		$this->amStoneMason = Doctrine::getTable('sfGuardUser')->getStoneMasonByUserRole();

		//////////////////////////////////////////////////////////////////
		//						FOR BOOKING STEP - 2					//
		//////////////////////////////////////////////////////////////////
		
		if($snIntermentBookingId)
		{
			$this->oAllocationDetailsForm = new AllocationDetailsForm($oIntermentBooking);
			$ssSuccessKey = 2; // Success message key for edit
			
			// For get Cemetery List As per Country
			$this->asCementery = Doctrine::getTable('CemCemetery')->getAllCemeteries($oIntermentBooking->getCountryId());
			
			// For get Area List as per Cemetery
			$this->asAreaList = Doctrine::getTable('ArArea')->getAreaListAsPerCemetery($oIntermentBooking->getCountryId(),$oIntermentBooking->getCemCemeteryId());
			
			// For get Section List as per area
			$this->asSectionList = Doctrine::getTable('ArSection')->getSectionListAsPerArea($oIntermentBooking->getCountryId(),$oIntermentBooking->getCemCemeteryId(),$oIntermentBooking->getArAreaId());
			
			// For get Row List as per section
			$this->asRowList = Doctrine::getTable('ArRow')->getRowListAsPerSection($oIntermentBooking->getCountryId(),$oIntermentBooking->getCemCemeteryId(),$oIntermentBooking->getArAreaId(),$oIntermentBooking->getArSectionId());
			
			// For get Plot List as per Row
			$this->asPlotList = Doctrine::getTable('ArPlot')->getPlotListAsPerArea($oIntermentBooking->getCountryId(),$oIntermentBooking->getCemCemeteryId(),$oIntermentBooking->getArAreaId(),$oIntermentBooking->getArSectionId(),$oIntermentBooking->getArRowId());
			
			// For get Plot List as per Row
			$this->asGraveList = Doctrine::getTable('ArGrave')->getGraveListAsPerCriteria($oIntermentBooking->getCountryId(),$oIntermentBooking->getCemCemeteryId(),$oIntermentBooking->getArAreaId(),$oIntermentBooking->getArSectionId(),$oIntermentBooking->getArRowId(),$oIntermentBooking->getArPlotId(),'true');
			
			// For get Grantee Details List
			$this->amGranteeDetails = Doctrine::getTable('Grantee')->getGranteeDetailsAsPerGrave($oIntermentBooking->getArGraveId());
			
			$this->snCementeryId = ($this->snCementeryId != '') ? $this->snCementeryId : $oIntermentBooking->getCemCemeteryId();
			$this->snAreaId = ($this->snAreaId != '') ? $this->snAreaId : $oIntermentBooking->getArAreaId();
			$this->snSectionId = ($this->snSectionId != '') ? $this->snSectionId : $oIntermentBooking->getArSectionId();
			$this->snRowId = ($this->snRowId != '') ? $this->snRowId : $oIntermentBooking->getArRowId();
			$this->snPlotId = ($this->snPlotId != '') ? $this->snPlotId : $oIntermentBooking->getArPlotId();
			$this->snGraveId = ($this->snGraveId != '') ? $this->snGraveId : $oIntermentBooking->getArGraveId();
			
			// For Grantee details
			$this->snGranteeId = ($this->snGranteeId != '') ? $this->snGranteeId : $oIntermentBooking->getGranteeId();
			$this->snGraveStatusId = ($this->snGraveStatusId != '') ? $this->snGraveStatusId : $oIntermentBooking->getArGraveStatus();
			$this->ssGranteeRelationShip = ($this->ssGranteeRelationShip != '') ? $this->ssGranteeRelationShip : $oIntermentBooking->getGranteeRelationship();
			
			if($this->snGraveId != '' && $this->snGraveId > 0)
			$oGrave = Doctrine::getTable('ArGrave')->find($this->snGraveId);
			
			if($this->snGranteeId != '' && $this->snGranteeId > 0)
			$omGranteeDetails = Doctrine::getTable('GranteeDetails')->find($this->snGranteeId);
			
			$this->ssGranteeRemarks1 = ( $this->ssGranteeRemarks1 != '' ) ? $this->ssGranteeRemarks1 : ( (isset($omGranteeDetails) && !empty($omGranteeDetails)) ? $omGranteeDetails->getremarks_1() : '');            
			$this->ssGranteeRemarks2 = ( $this->ssGranteeRemarks2 != '' ) ? $this->ssGranteeRemarks2 : ( (isset($omGranteeDetails) && !empty($omGranteeDetails)) ? $omGranteeDetails->getremarks_2() : '');
			
            
            
            /*if(isset($omGranteeDetails) && !empty($omGranteeDetails))
                $this->ssGranteeRemarks1 = $omGranteeDetails->getremarks_1();
            elseif($this->ssGranteeRemarks1 == '')
                $this->ssGranteeRemarks1 = '';
            elseif($this->ssGranteeRemarks1 != '')
                $this->ssGranteeRemarks1 = $this->ssGranteeRemarks1;*/
            
			// For Grave Details
			$this->amGraveDetailsParams['ssGraveLength'] = ($this->amGraveDetailsParams['ssGraveLength'] != '') ? $this->amGraveDetailsParams['ssGraveLength'] : $oIntermentBooking->getGraveLength();
			$this->amGraveDetailsParams['ssGraveWidth'] = ($this->amGraveDetailsParams['ssGraveWidth'] != '') ? $this->amGraveDetailsParams['ssGraveWidth'] : $oIntermentBooking->getGraveWidth();
			$this->amGraveDetailsParams['ssGraveHeight'] = ($this->amGraveDetailsParams['ssGraveHeight'] != '') ? $this->amGraveDetailsParams['ssGraveHeight'] : $oIntermentBooking->getGraveDepth();
			$this->amGraveDetailsParams['snIdGraveUnitType'] = ($this->amGraveDetailsParams['snIdGraveUnitType'] != '') ? $this->amGraveDetailsParams['snIdGraveUnitType'] : $oIntermentBooking->getGraveUnitType();
			
			$this->amGraveDetailsParams['ssGraveComment1'] = ($this->amGraveDetailsParams['ssGraveComment1'] != '') ? $this->amGraveDetailsParams['ssGraveComment1'] : ( (isset($oGrave) && !empty($oGrave)) ? $oGrave->getComment1() : '' );
			
			$this->amGraveDetailsParams['ssGraveComment2'] = ($this->amGraveDetailsParams['ssGraveComment2'] != '') ? $this->amGraveDetailsParams['ssGraveComment2'] : ( (isset($oGrave) && !empty($oGrave)) ? $oGrave->getComment2() : '' );
			
			if($oIntermentBooking->getArGraveId() != '' && $oIntermentBooking->getArGraveId() != 0)
			{
				$oGrave =  Doctrine::getTable('ArGrave')->find($oIntermentBooking->getArGraveId());
				$this->amGraveDetailsParams['ssGraveStatus'] = $oGrave->getArGraveStatus();
			}
			else
				$this->amGraveDetailsParams['ssGraveStatus'] = $this->snGraveStatus = '';
		
		}
		else 
		{
			$this->oAllocationDetailsForm = new AllocationDetailsForm();
			if($oRequest->isMethod('post') && $snIntermentBookingId == '' && $this->snTabKey != 'step1')
			{
				$this->getUser()->setFlash('snErrorMsgKey', 2);
				$this->redirect('servicebooking/addedit?tab=step1&back='.$oRequest->getParameter('back'));
			}
		}
		$this->getConfigurationFields($this->oAllocationDetailsForm);
		$amBookingTwoReq = $oRequest->getParameter($this->oAllocationDetailsForm->getName());
		//////////////////////////////////////////////////////////////////
		//						FOR BOOKING STEP - 3					//
		//////////////////////////////////////////////////////////////////
		if($snIntermentBookingId)
		{
			$oIntermentBookingThree = Doctrine::getTable('IntermentBookingThree')->findByIntermentBookingId($snIntermentBookingId);

			if(count($oIntermentBookingThree) > 0)
			{
				$omIntermentThree = Doctrine::getTable('IntermentBookingThree')->find($oIntermentBookingThree[0]->getId());
				$this->oIntermentBookingThreeForm = new IntermentBookingThreeForm($omIntermentThree);
			}
			else
				$this->oIntermentBookingThreeForm = new IntermentBookingThreeForm();
	
			$ssSuccessKey = 2; // Success message key for edit
		}
		else
		{
			$this->oIntermentBookingThreeForm = new IntermentBookingThreeForm();
			if($oRequest->isMethod('post') && $snIntermentBookingId == '' && $this->snTabKey != 'step1')
			{
				$this->getUser()->setFlash('snErrorMsgKey', 2);
				$this->redirect('servicebooking/addedit?tab=step1&back='.$oRequest->getParameter('back'));
			}
		}
		$this->getConfigurationFields($this->oIntermentBookingThreeForm);
		$amBookingThreeReq = $oRequest->getParameter($this->oIntermentBookingThreeForm->getName());
		
		//////////////////////////////////////////////////////////////////
		//						FOR BOOKING STEP - 4					//
		//////////////////////////////////////////////////////////////////

		if($snIntermentBookingId)
		{
			$oIntermentBookingFour = Doctrine::getTable('IntermentBookingFour')->findByIntermentBookingId($snIntermentBookingId);
			if(count($oIntermentBookingFour) > 0)
			{
				$omIntermentFour = Doctrine::getTable('IntermentBookingFour')->find($oIntermentBookingFour[0]->getId());
				$this->oIntermentBookingFourForm = new IntermentBookingFourForm($omIntermentFour);
				$this->ssControlNumber = $oIntermentBookingFour[0]->getControlNumber();
			}
			else
				$this->oIntermentBookingFourForm = new IntermentBookingFourForm();
	
			$ssSuccessKey = 2; // Success message key for edit
		}
		else
		{
			$this->oIntermentBookingFourForm = new IntermentBookingFourForm();
			if($oRequest->isMethod('post') && $snIntermentBookingId == '' && $this->snTabKey != 'step1')
			{
				$this->getUser()->setFlash('snErrorMsgKey', 2);
				$this->redirect('servicebooking/addedit?tab=step1&back='.$oRequest->getParameter('back'));
			}
		}
		$this->getConfigurationFields($this->oIntermentBookingFourForm);
		$amBookingFourReq = $oRequest->getParameter($this->oIntermentBookingFourForm->getName());

		//////////////////////////////////////////////////////////////////
		//						FOR BOOKING STEP - 5					//
		//////////////////////////////////////////////////////////////////

		if($snIntermentBookingId)
		{
			if(count($oIntermentBookingFour) > 0)
			{
				$omIntermentFour = Doctrine::getTable('IntermentBookingFour')->find($oIntermentBookingFour[0]->getId());
				$this->oApplicantDetailsForm = new ApplicantDetailsForm($omIntermentFour);
			}
			else
				$this->oApplicantDetailsForm = new ApplicantDetailsForm();
	
			$ssSuccessKey = 2; // Success message key for edit
		}
		else
		{
			$this->oApplicantDetailsForm = new ApplicantDetailsForm();
			if($oRequest->isMethod('post') && $snIntermentBookingId == '' && $this->snTabKey != 'step1')
			{
				$this->getUser()->setFlash('snErrorMsgKey', 2);
				$this->redirect('servicebooking/addedit?tab=step1&back='.$oRequest->getParameter('back'));
			}
		}
		$this->getConfigurationFields($this->oApplicantDetailsForm);
		$amBookingFiveReq = $oRequest->getParameter($this->oApplicantDetailsForm->getName());
		
		//////////////////////////////////////////////////////////////////
		//						FOR BOOKING STEP - 6					//
		//////////////////////////////////////////////////////////////////
        if($snIntermentBookingId)
		{
            $this->asLetterDetail = Doctrine::getTable('IntermentBookingFive')->getIntermentBookingDetailLetterwise($snIntermentBookingId);
            
            // following is temporary checked after complete task.
            $oIntermentBookingFive = Doctrine::getTable('IntermentBookingFive')->findByIntermentBookingId($snIntermentBookingId);
           
            //$this->snCementeryId = ($this->snCementeryId != '') ? $this->snCementeryId : $oIntermentBooking->getCemCemeteryId();
            
			if(count($oIntermentBookingFive) > 0)
			{
				$omIntermentFive = Doctrine::getTable('IntermentBookingFive')->find($oIntermentBookingFive[0]->getId());
				$this->oLettersForm = new IntermentBookingFiveForm($omIntermentFive);
			}
			else
				$this->oLettersForm = new IntermentBookingFiveForm();
	
			$ssSuccessKey = 2; // Success message key for edit
		}
		else
		{
			$this->asLetterDetail = Doctrine::getTable('MailContent')->getMailContentsDetail('','letter');
            
            $this->oLettersForm = new IntermentBookingFiveForm();
			if($oRequest->isMethod('post') && $snIntermentBookingId == '' && $this->snTabKey != 'step1')
			{
				$this->getUser()->setFlash('snErrorMsgKey', 2);
				$this->redirect('servicebooking/addedit?tab=step1&back='.$oRequest->getParameter('back'));
			}
		}
		$this->getConfigurationFields($this->oLettersForm);
		$amBookingSixReq = $oRequest->getParameter($this->oLettersForm->getName());
		///////////////////////////////////////////
		//				START HERE				//
		//////////////////////////////////////////

		try
		{
			switch($this->snTabKey)
			{
				case 'step1':
								
								// For save Booking Step-1 data.
								if($oRequest->isMethod('post'))
								{
									if($amBookingFirstReq['date_notified'] != '') 
									{
										list($snDay,$snMonth,$snYear) = explode('-',$amBookingFirstReq['date_notified']);
										$amBookingFirstReq['date_notified'] = $snYear.'-'.$snMonth.'-'.$snDay;
									}
									if($amBookingFirstReq['service_date'] != '')
									{
										list($snDay,$snMonth,$snYear) = explode('-',$amBookingFirstReq['service_date']);
										$amBookingFirstReq['service_date'] = $snYear.'-'.$snMonth.'-'.$snDay;
										if($amBookingFirstReq['service_date'] != '0000-00-00')
											$amBookingFirstReq['date1_day'] = date('l',strtotime($amBookingFirstReq['service_date']));
									}
									if($amBookingFirstReq['service_date2'] != '') 
									{
										list($snDay,$snMonth,$snYear) = explode('-',$amBookingFirstReq['service_date2']);
										$amBookingFirstReq['service_date2'] = $snYear.'-'.$snMonth.'-'.$snDay;
										if($amBookingFirstReq['service_date2'] != '0000-00-00')
											$amBookingFirstReq['date2_day'] = date('l',strtotime($amBookingFirstReq['service_date2']));
									}
									if($amBookingFirstReq['service_date3'] != '') 
									{
										list($snDay,$snMonth,$snYear) = explode('-',$amBookingFirstReq['service_date3']);
										$amBookingFirstReq['service_date3'] = $snYear.'-'.$snMonth.'-'.$snDay;
										if($amBookingFirstReq['service_date3'] != '0000-00-00')
											$amBookingFirstReq['date3_day'] = date('l',strtotime($amBookingFirstReq['service_date3']));
									}
									
									// SET EMBED FORM DETAILS
									if($amBookingFirstReq['other_details']['chapel_time_from'] != '') 
									{
										list($ssDate,$ssTime) = explode(' ', $amBookingFirstReq['other_details']['chapel_time_from']);
										list($snDay,$snMonth,$snYear) = explode('-',$ssDate);
										
										$amBookingFirstReq['other_details']['chapel_time_from'] = $snYear.'-'.$snMonth.'-'.$snDay.' '.$ssTime;																				
									}
									if($amBookingFirstReq['other_details']['chapel_time_to'] != '') 
									{
										list($ssDate,$ssTime) = explode(' ', $amBookingFirstReq['other_details']['chapel_time_to']);
										list($snDay,$snMonth,$snYear) = explode('-',$ssDate);
										
										$amBookingFirstReq['other_details']['chapel_time_to'] = $snYear.'-'.$snMonth.'-'.$snDay.' '.$ssTime;																				
									}
									if($amBookingFirstReq['other_details']['room_time_from'] != '') 
									{
										list($ssDate,$ssTime) = explode(' ', $amBookingFirstReq['other_details']['room_time_from']);
										list($snDay,$snMonth,$snYear) = explode('-',$ssDate);
										
										$amBookingFirstReq['other_details']['room_time_from'] = $snYear.'-'.$snMonth.'-'.$snDay.' '.$ssTime;																				
									}
									if($amBookingFirstReq['other_details']['room_time_to'] != '') 
									{
										list($ssDate,$ssTime) = explode(' ', $amBookingFirstReq['other_details']['room_time_to']);
										list($snDay,$snMonth,$snYear) = explode('-',$ssDate);
										
										$amBookingFirstReq['other_details']['room_time_to'] = $snYear.'-'.$snMonth.'-'.$snDay.' '.$ssTime;																				
									}
									
										
									
									$this->oIntermentBookingForm->bind($amBookingFirstReq);
									
									if($this->oIntermentBookingForm->isValid())
									{
										$snIdIntermentBooking = $this->oIntermentBookingForm->save()->getId();

										if($this->oIntermentBookingForm->isNew())
										{
											$oBooking3 = new IntermentBookingThree();
											$oBooking3->setIntermentBookingId($snIdIntermentBooking);
											$oBooking3->save();
											
											$oBooking4 = new IntermentBookingFour();
											$oBooking4->setIntermentBookingId($snIdIntermentBooking);
											$oBooking4->save();
											
											foreach($this->asLetterDetail as $snKey=>$asVal)
                                            {
                                                $oBooking5 = new IntermentBookingFive();
                                                $oBooking5->setIntermentBookingId($snIdIntermentBooking);
                                                $oBooking5->setMailContentId($asVal['id']);
                                                //$oBooking5->setStatus($snIdIntermentBooking);
                                                $oBooking5->save();
                                            }											
										}

										// Update Grave status into grave table.
										if($oRequest->getParameter('service_ar_grave_id') != '')
										{
											$oGrave = Doctrine::getTable('ArGrave')->find($oRequest->getParameter('service_ar_grave_id'));
											if($oGrave && $oGrave->getArGraveStatusId() == sfConfig::get('app_grave_status_vacant'))
												ArGrave::updateGraveTableField('ar_grave_status_id', sfConfig::get('app_grave_status_allocate'), $oGrave->getId());
											
											if( (($this->amGraveDetailsParams['ssGraveComment1'] != '' && $this->amGraveDetailsParams['ssGraveComment1'] != 'Comment1') 
												  || ($this->amGraveDetailsParams['ssGraveComment2'] != '' && $this->amGraveDetailsParams['ssGraveComment2'] != 'Comment2')) 
												  && $oGrave)
											{
												ArGrave::updateGraveComments($this->amGraveDetailsParams['ssGraveComment1'], $this->amGraveDetailsParams['ssGraveComment2'], $oGrave->getId());
											}
										}
										// FOR UPDATE GRANTEE DETAILS TABLE (REMARKS)
										if($oRequest->getParameter('service_grantee_id') != '')
										{
											$omGranteeDetails = Doctrine::getTable('GranteeDetails')->find($oRequest->getParameter('service_grantee_id'));                                            
											if( $omGranteeDetails && ($this->ssGranteeRemarks1 != '' || $this->ssGranteeRemarks2))
												GranteeDetails::updateGranteeRemarks($this->ssGranteeRemarks1, $this->ssGranteeRemarks2, $omGranteeDetails->getId());
										}
										$this->getUser()->setFlash('snSuccessMsgKey', $ssSuccessKey);   //Set messages for add and update records

										if($oRequest->getParameter($this->snTabKey.'Save')) {
											$this->redirect('servicebooking/addedit?id='.$snIdIntermentBooking.'&tab='.$this->snTabKey.'&massage=true&back='.$oRequest->getParameter('back'));
										}else {
											if($oRequest->getParameter('back') == true) {
												$this->redirect('intermentsearch/search?back=true');
											}else {                															
												$this->redirect('servicebooking/index?'.$this->amExtraParameters['ssQuerystr']);
											}
										}
									}
								}else {
									if($oRequest->getParameter('massage') == 'true') {
										$this->getUser()->setFlash('snSuccessMsgKey', $ssSuccessKey);   //Set messages for add and update records
									}
								}
								
								break;
				case 'step2': 
								// For save Booking Step-2 data.
								if($oRequest->isMethod('post'))
								{
									$this->oAllocationDetailsForm->bind($amBookingTwoReq);
									
									if($this->oAllocationDetailsForm->isValid())
									{
										$snIdIntermentBooking = $this->oAllocationDetailsForm->save()->getId();

										// Update Grave status into grave table.
										if($oRequest->getParameter('service_ar_grave_id') != '')
										{
											$oGrave = Doctrine::getTable('ArGrave')->find($oRequest->getParameter('service_ar_grave_id'));
											if($oGrave && $oGrave->getArGraveStatusId() == sfConfig::get('app_grave_status_vacant'))
												ArGrave::updateGraveTableField('ar_grave_status_id', sfConfig::get('app_grave_status_allocate'), $oGrave->getId());
											
											if((($this->amGraveDetailsParams['ssGraveComment1'] != '') || ($this->amGraveDetailsParams['ssGraveComment2'] != '')) && $oGrave)
											{
                                                $this->amGraveDetailsParams['ssGraveComment1'] = (($this->amGraveDetailsParams['ssGraveComment1'] == 'Comment1') ? '' : $this->amGraveDetailsParams['ssGraveComment1']);
                                                $this->amGraveDetailsParams['ssGraveComment2'] = (($this->amGraveDetailsParams['ssGraveComment2'] == 'Comment2') ? '' : $this->amGraveDetailsParams['ssGraveComment2']);
												ArGrave::updateGraveComments($this->amGraveDetailsParams['ssGraveComment1'], $this->amGraveDetailsParams['ssGraveComment2'], $oGrave->getId());
											}
										}
										// FOR UPDATE GRANTEE DETAILS TABLE (REMARKS)
										if($oRequest->getParameter('service_grantee_id') != '')
										{
											$omGranteeDetails = Doctrine::getTable('GranteeDetails')->find($oRequest->getParameter('service_grantee_id'));
											$this->ssGranteeRemarks1 = (trim($oRequest->getParameter('service_grantee_remarks_1')) != '' ) ? trim($oRequest->getParameter('service_grantee_remarks_1')) : '';
                                            $this->ssGranteeRemarks2 = (trim($oRequest->getParameter('service_grantee_remarks_2')) != '' ) ? trim($oRequest->getParameter('service_grantee_remarks_2')) : '';
                                            if($omGranteeDetails)
												GranteeDetails::updateGranteeRemarks($this->ssGranteeRemarks1, $this->ssGranteeRemarks2, $omGranteeDetails->getId());
										}
										$this->getUser()->setFlash('snSuccessMsgKey', $ssSuccessKey);   //Set messages for add and update records

										if($oRequest->getParameter($this->snTabKey.'Save')) {
											$this->redirect('servicebooking/addedit?id='.$snIdIntermentBooking.'&tab='.$this->snTabKey.'&massage=true&back='.$oRequest->getParameter('back'));
										}else {
											if($oRequest->getParameter('back') == true) {
												$this->redirect('intermentsearch/search?back=true');
											}else {                															
												$this->redirect('servicebooking/index?'.$this->amExtraParameters['ssQuerystr']);
											}
										}
									}
								}
								else 
								{
									if($oRequest->getParameter('massage') == 'true')
										$this->getUser()->setFlash('snSuccessMsgKey', $ssSuccessKey);   //Set messages for add and update records
								}
								break;
				case 'step3':
								// For save Booking Step-3 data.								
								if($oRequest->isMethod('post'))
								{
									$this->oIntermentBookingThreeForm->bind($amBookingThreeReq);
									
									if($this->oIntermentBookingThreeForm->isValid())
									{
										$snIdIntermentBooking = $this->oIntermentBookingThreeForm->save()->getIntermentBookingId();
										
										// FOR WHO UPDATE THE BOOKING/INTERMENT RECORDS.
										common::UpdateCompositeField('IntermentBooking','user_id',$this->getUser()->getAttribute('userid'),'id',$snIdIntermentBooking);

										$this->getUser()->setFlash('snSuccessMsgKey', $ssSuccessKey);   //Set messages for add and update records
										
										if($oRequest->getParameter($this->snTabKey.'Save')) {
											$this->redirect('servicebooking/addedit?id='.$snIdIntermentBooking.'&tab='.$this->snTabKey.'&massage=true&back='.$oRequest->getParameter('back'));
										}else {
											if($oRequest->getParameter('back') == true) {
												$this->redirect('intermentsearch/search?back=true');
											}else {                															
												$this->redirect('servicebooking/index?'.$this->amExtraParameters['ssQuerystr']);
											}
										}
									}
								}else {
									if($oRequest->getParameter('massage') == 'true') {
										$this->getUser()->setFlash('snSuccessMsgKey', $ssSuccessKey);   //Set messages for add and update records
									}
								}								

								break;
				case 'step4':
								// For save Booking Step-4 data.								
								if($oRequest->isMethod('post'))
								{
									
									if($amBookingFourReq['deceased_date_of_death'] != '') 
									{
										list($snDay,$snMonth,$snYear) = explode('-', trim($amBookingFourReq['deceased_date_of_death']));
										$amBookingFourReq['deceased_date_of_death'] = $snYear.'-'.$snMonth.'-'.$snDay;
									}
									if($amBookingFourReq['deceased_date_of_birth'] != '') 
									{
										list($snDay,$snMonth,$snYear) = explode('-', trim($amBookingFourReq['deceased_date_of_birth']));
										$amBookingFourReq['deceased_date_of_birth'] = $snYear.'-'.$snMonth.'-'.$snDay;
									}
									if($amBookingFourReq['cul_date_of_death'] != '') 
									{
										list($snDay,$snMonth,$snYear) = explode('-', trim($amBookingFourReq['cul_date_of_death']));
										$amBookingFourReq['cul_date_of_death'] = $snYear.'-'.$snMonth.'-'.$snDay;
									}
									if($amBookingFourReq['cul_date_of_interment'] != '') 
									{
										list($snDay,$snMonth,$snYear) = explode('-', trim($amBookingFourReq['cul_date_of_interment']));
										$amBookingFourReq['cul_date_of_interment'] = $snYear.'-'.$snMonth.'-'.$snDay;
									}
									if($amBookingFourReq['cul_date_of_birth'] != '') 
									{
										list($snDay,$snMonth,$snYear) = explode('-', trim($amBookingFourReq['cul_date_of_birth']));
										$amBookingFourReq['cul_date_of_birth'] = $snYear.'-'.$snMonth.'-'.$snDay;
									}
									
									//UPDATE INTERMENT DATE
									if($amBookingFourReq['interment_date'] != '') 
									{
										list($snDay,$snMonth,$snYear) = explode('-', trim($amBookingFourReq['interment_date']));
										$ssIntermentDate = $snYear.'-'.$snMonth.'-'.$snDay;
										
										$omCommon = new common();
										$omCommon->UpdateStatusComposite('IntermentBooking','interment_date', $snIntermentBookingId, $ssIntermentDate, 'id');
									}

									$this->oIntermentBookingFourForm->bind($amBookingFourReq);
									
									if($this->oIntermentBookingFourForm->isValid())
									{
										$snIdIntermentBooking = $this->oIntermentBookingFourForm->save()->getIntermentBookingId();
										
										// FOR WHO UPDATE THE BOOKING/INTERMENT RECORDS.
										common::UpdateCompositeField('IntermentBooking','user_id',$this->getUser()->getAttribute('userid'),'id',$snIdIntermentBooking);

										$this->getUser()->setFlash('snSuccessMsgKey', $ssSuccessKey);   //Set messages for add and update records
										
										if($oRequest->getParameter($this->snTabKey.'Save')) {
											$this->redirect('servicebooking/addedit?id='.$snIdIntermentBooking.'&tab='.$this->snTabKey.'&massage=true&back='.$oRequest->getParameter('back'));
										}else {
											if($oRequest->getParameter('back') == true) {
												$this->redirect('intermentsearch/search?back=true');
											}else {                															
												$this->redirect('servicebooking/index?'.$this->amExtraParameters['ssQuerystr']);
											}
										}
									}
								}else {
									if($oRequest->getParameter('massage') == 'true') {
										$this->getUser()->setFlash('snSuccessMsgKey', $ssSuccessKey);   //Set messages for add and update records
									}
								}								

								break;								
				case 'step5':
								// For save Booking Step-4 data.								
								if($oRequest->isMethod('post'))
								{
									$this->oApplicantDetailsForm->bind($amBookingFiveReq);
									
									if($this->oApplicantDetailsForm->isValid())
									{
										$snIdIntermentBooking = $this->oApplicantDetailsForm->save()->getIntermentBookingId();
										
										// FOR WHO UPDATE THE BOOKING/INTERMENT RECORDS.
										common::UpdateCompositeField('IntermentBooking','user_id',$this->getUser()->getAttribute('userid'),'id',$snIdIntermentBooking);

										$this->getUser()->setFlash('snSuccessMsgKey', $ssSuccessKey);   //Set messages for add and update records
										
										if($oRequest->getParameter($this->snTabKey.'Save')) {
											$this->redirect('servicebooking/addedit?id='.$snIdIntermentBooking.'&tab='.$this->snTabKey.'&massage=true&back='.$oRequest->getParameter('back'));
										}else {
											if($oRequest->getParameter('back') == true) {
												$this->redirect('intermentsearch/search?back=true');
											}else {                															
												$this->redirect('servicebooking/index?'.$this->amExtraParameters['ssQuerystr']);
											}
										}
									}
								}else {
									if($oRequest->getParameter('massage') == 'true') {
										$this->getUser()->setFlash('snSuccessMsgKey', $ssSuccessKey);   //Set messages for add and update records
									}
								}	
							
								break;
				case 'step6':
							// For save Booking Step-6 data.								
							if($oRequest->isMethod('post'))
							{
								$this->oLettersForm->bind($amBookingSixReq);
								
								if($this->oLettersForm->isValid())
								{
									$snIdIntermentBooking = $this->oLettersForm->save()->getIntermentBookingId();
									
									// FOR WHO UPDATE THE BOOKING/INTERMENT RECORDS.
									common::UpdateCompositeField('IntermentBooking','user_id',$this->getUser()->getAttribute('userid'),'id',$snIdIntermentBooking);

									$this->getUser()->setFlash('snSuccessMsgKey', $ssSuccessKey);   //Set messages for add and update records
									
									if($oRequest->getParameter($this->snTabKey.'Save')) {
										$this->redirect('servicebooking/addedit?id='.$snIdIntermentBooking.'&tab='.$this->snTabKey.'&massage=true&back='.$oRequest->getParameter('back'));
									}else {
										if($oRequest->getParameter('back') == true) {
											$this->redirect('intermentsearch/search?back=true');
										}else {                															
											$this->redirect('servicebooking/index?'.$this->amExtraParameters['ssQuerystr']);
										}
									}
								}
							}else {
								if($oRequest->getParameter('massage') == 'true') {
									$this->getUser()->setFlash('snSuccessMsgKey', $ssSuccessKey);   //Set messages for add and update records
								}
							}								

							break;	
								
			}
			
		}
		catch( Exception $oError)
		{
			echo "<pre>";print_r($oError);exit;
			$this->getUser()->setFlash('snErrorMsgKey', 2);
		}
        
    }
    
	/**
    * Executes Document action
    *
    * @access public
    * @param sfRequest $request A request object
    */
    public function executeDocument(sfWebRequest $oRequest)
    {
		//exec('rm -fR '.sfConfig::get('sf_upload_dir').'/bookingDocs/269191');exit;
		
		$snIdBookingDocs = $oRequest->getParameter('id', '');
		$this->snBookingId = $oRequest->getParameter('booking_id','');
		$ssSuccessKey   = 6; // Success message key for surrender grave to another grantee
		
		if($snIdBookingDocs != '')
        {
            $this->forward404Unless($oBookingDocs = Doctrine::getTable('IntermentBookingDocs')->find($snIdBookingDocs));
            $this->oBookingDocForm = new IntermentBookingDocsForm($oBookingDocs);
            $ssSuccessKey = 8; // Success message key for edit
        }
        else
			$this->oBookingDocForm = new IntermentBookingDocsForm();
			
		$this->getConfigurationFieldsForUploadDoc($this->oBookingDocForm);
		
		if($oRequest->isMethod('post'))
		{
			if($this->snBookingId != '')
			{
				$amBookingFormRequest = $oRequest->getParameter($this->oBookingDocForm->getName());
				$amBookingFileRequest = $oRequest->getFiles($this->oBookingDocForm->getName());
				
				$this->oBookingDocForm->bind($amBookingFormRequest,$amBookingFileRequest);
				if($this->oBookingDocForm->isValid())
				{
					// For Create booking id directory if not exists
					sfGeneral::createDirectory(sfConfig::get('sf_upload_dir').'/'.sfConfig::get('app_booking_path').'/'.$this->snBookingId);

					// For Upload File.
					$oFile = $this->oBookingDocForm->getValue('file_path');					
					// While edit document remove old doc.
					if(!empty($oFile))
					{
						if(isset($oBookingDocs))
						{
							if($oBookingDocs->getFilePath() != '')
							  sfGeneral::removeFile(sfConfig::get('sf_upload_dir').'/'.sfConfig::get('app_booking_path').'/'.$this->snBookingId.'/'.$oBookingDocs->getFilePath());
						}
						$ssFileName = $this->snBookingId.'_'.uniqid().'_'.sha1($oFile->getOriginalName());
						$amExtension = explode('.',$oFile->getOriginalName());
						$ssExtentions =  ((count($amExtension) > 0) ? '.'.end($amExtension) : '');
						$ssFileName = $ssFileName.$ssExtentions;					
						$oFile->save(sfConfig::get('sf_upload_dir').'/'.sfConfig::get('app_booking_path').'/'.$this->snBookingId.'/'.$ssFileName);
					}
					// End File Upload and Edit Uploaded File
					
					$ssExpiryDate = '0000-00-00';
					if($amBookingFormRequest['expiry_date'] != '') 
					{
						list($snDay,$snMonth,$snYear) = explode('-', trim($amBookingFormRequest['expiry_date']));
						$ssExpiryDate = $snYear.'-'.$snMonth.'-'.$snDay;
					}
					
					// For Save records.	
					$oSaveForm = $this->oBookingDocForm->getObject();
					$oSaveForm->setIntermentBookingId($this->snBookingId);
					$oSaveForm->setFileName($amBookingFormRequest['file_name']);
					$oSaveForm->setFileDescription($amBookingFormRequest['file_description']);
					$oSaveForm->setExpiryDate($ssExpiryDate);
					
					if($oSaveForm->isNew())
						$oSaveForm->setCreatedAt(date('Y-m-d H:i:s'));

					$oSaveForm->setUpdatedAt(date('Y-m-d H:i:s'));

					if(!empty($oFile))
						$oSaveForm->setFilePath($ssFileName);

					$oSaveForm->save();
					
					$this->getUser()->setFlash('snSuccessMsgKey', $ssSuccessKey);   //Set messages for add and update records
					$this->redirect('servicebooking/index?'.$this->amExtraParameters['ssQuerystr']);
				}
			}
			else
				$this->redirect('servicebooking/index?'.$this->amExtraParameters['ssQuerystr']);
		}
	}
	/**
    * Executes Document action
    *
    * @access public
    * @param sfRequest $request A request object
    */
    public function executeListDocuments(sfWebRequest $request)
    {
		$this->snBookingId = $request->getParameter('booking_id','');
		if($this->snBookingId != '')
		{
			//set search combobox field
			$this->amSearch = array();
	
			$omCommon = new common();
	
			if($request->getParameter('admin_act') == "delete" && $request->getParameter('id'))            
			{
				$amBookingDocs = Doctrine::getTable('IntermentBookingDocs')->getBookingDocsAsPerIds($request->getParameter('id'));
				if(count($amBookingDocs) > 0)
				{
					foreach($amBookingDocs as $asDataSet)
						sfGeneral::removeFile(sfConfig::get('sf_upload_dir').'/'.sfConfig::get('app_booking_path').'/'.$this->snBookingId.'/'.$asDataSet['file_path']);				

					$omCommon->DeleteRecordsComposite('IntermentBookingDocs', $request->getParameter('id'),'id');
					$this->getUser()->setFlash('snSuccessMsgKey', 3);
				}
			}
			if($request->getParameter('type') == 'download')
			{
				$ssFilename = base64_decode($request->getParameter('filename'));
				sfGeneral::downloadFile(sfConfig::get('app_booking_path').'/'.$this->snBookingId.'/'.$ssFilename);
			}
	
			$oBookingDocsPageListQuery = Doctrine::getTable('IntermentBookingDocs')->getBookingDocs($this->amExtraParameters, $this->amSearch,'',$this->snBookingId);
	
			// Set pager and get results
			$oPager               = new sfMyPager();
			$this->oBookingDocsList  = $oPager->getResults('IntermentBookingDocs', $this->snPaging,$oBookingDocsPageListQuery,$this->snPage);
			$this->amBookingDocsList = $this->oBookingDocsList->getResults(Doctrine::HYDRATE_ARRAY);
	
			unset($oPager);
	
			// Total number of records
			$this->snPageTotalBookingDocsPages = $this->oBookingDocsList->getNbResults();
	
			if($request->getParameter('request_type') == 'ajax_request')
				$this->setTemplate('listBookingDocsUpdate');
		}
		else		
			$this->redirect('servicebooking/index?'.$this->amExtraParameters['ssQuerystr']);
	}
    
    
	/**
    * Executes GeneratePDF action
    *
    * @access public
    * @param sfRequest $request A request object
    */
	public function executeGeneratePDF(sfWebRequest $request)
	{	
		$snIntermentBookingId = $request->getParameter('id', '');

		$oExistsRecord = Doctrine::getTable('IntermentBookingFive')->findOneByIntermentBookingId($snIntermentBookingId);		
		if(!$oExistsRecord)
		{
			$oBooking5 = new IntermentBookingFive();
			$oBooking5->setIntermentBookingId($snIntermentBookingId);
			$oBooking5->save();
		}
		$amBookingInfo = Doctrine::getTable('IntermentBooking')->getBookingDetailsForPrint($snIntermentBookingId);
		if(count($amBookingInfo) > 0)
		{
			// pdf object
			$oPDF = new sfTCPDF();
			
			// set document information
			$oPDF->SetCreator(PDF_CREATOR);
			$oPDF->SetAuthor('Cemetery');
			$oPDF->SetTitle('Service Booking Details');
			$oPDF->SetSubject('Service Booking Details');
			$oPDF->SetKeywords('Service, Booking');
			
			// set header and footer fonts
			$oPDF->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
			$oPDF->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
			
			// set default monospaced font
			$oPDF->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
			
			//set margins
			$oPDF->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
			$oPDF->SetHeaderMargin(PDF_MARGIN_HEADER);
			$oPDF->SetFooterMargin(PDF_MARGIN_FOOTER);
			
			//set auto page breaks
			$oPDF->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
			
			// Add a page
			// This method has several options, check the source code documentation for more information.
			$oPDF->AddPage();
			
			$oPDF->writeHTMLCell($w=0, $h=0, $x='90', $y='10', '<b>Booking Details</b>', 0, 0, 0, true, '', true);			
			$oPDF->SetFont('helvetica', '', 8, '', true);		
			$oPDF->setY('20');
			
			// Set some content to print
			$ssBooking1Content = get_partial('servicebooking/printBooking1',array('amBookingInfo' => $amBookingInfo[0]));
			// Print text using writeHTML()
			$oPDF->writeHTML($ssBooking1Content);
			
			// Add a page
			// This method has several options, check the source code documentation for more information.
			$oPDF->AddPage();
			
			$oPDF->writeHTMLCell($w=0, $h=0, $x='90', $y='10', '<b>Allocation Details</b>', 0, 1, 0, true, '', true);
			
			$oPDF->SetFont('helvetica', '', 8, '', true);		
			$oPDF->setY('20');
			
			// Set some content to print
			$ssBooking2Content = get_partial('servicebooking/printBooking2',array('amBookingInfo' => $amBookingInfo[0]));
			// Print text using writeHTML()
			$oPDF->writeHTML($ssBooking2Content);
			
			// Add a page
			// This method has several options, check the source code documentation for more information.
			$oPDF->AddPage();
			
			$oPDF->writeHTMLCell($w=0, $h=0, $x='90', $y='10', '<b>Final Booking Checklist</b>', 0, 1, 0, true, '', true);
			
			$oPDF->SetFont('helvetica', '', 8, '', true);		
			$oPDF->setY('20');
			
			// Set some content to print
			$ssBooking3Content = get_partial('servicebooking/printBooking3',array('amBookingInfo' => $amBookingInfo[0]));
			// Print text using writeHTML()
			$oPDF->writeHTML($ssBooking3Content);
			
			// Add a page
			// This method has several options, check the source code documentation for more information.
			$oPDF->AddPage();
			
			$oPDF->writeHTMLCell($w=0, $h=0, $x='90', $y='10', '<b>Deceased Details</b>', 0, 1, 0, true, '', true);
			
			$oPDF->SetFont('helvetica', '', 8, '', true);
			$oPDF->setY('20');
			// Set some content to print
			$ssBooking4Content = get_partial('servicebooking/printBooking4',array('amBookingInfo' => $amBookingInfo[0]));
			// Print text using writeHTML()
			$oPDF->writeHTML($ssBooking4Content);
			
			// Add a page
			// This method has several options, check the source code documentation for more information.
			$oPDF->AddPage();
			
			$oPDF->writeHTMLCell($w=0, $h=0, $x='90', $y='10', '<b>Informant/Applicant Details</b>', 0, 1, 0, true, '', true);
			
			$oPDF->SetFont('helvetica', '', 8, '', true);
			$oPDF->setY('20');
			// Set some content to print
			$ssBooking5Content = get_partial('servicebooking/printBooking5',array('amBookingInfo' => $amBookingInfo[0]));
			// Print text using writeHTML()
			$oPDF->writeHTML($ssBooking5Content);

			// Add a page
			// This method has several options, check the source code documentation for more information.
			$oPDF->AddPage();
			
			$oPDF->writeHTMLCell($w=0, $h=0, $x='90', $y='10', '<b>Letters & Mailout</b>', 0, 1, 0, true, '', true);
			
			$oPDF->SetFont('helvetica', '', 8, '', true);
			$oPDF->setY('20');
			// Set some content to print
			$ssBooking5Content = get_partial('servicebooking/printBooking6',array('amBookingInfo' => $amBookingInfo[0]));
			// Print text using writeHTML()
			$oPDF->writeHTML($ssBooking5Content);

			// Close and output PDF document
			// This method has several options, check the source code documentation for more information.
			$oPDF->Output('service_booking', 'I');
			
			// Stop symfony process
			throw new sfStopException();
		}
	}
    
	/**
    * Executes printLetters action
    *
    * @access public
    * @param sfRequest $request A request object
    */
	public function executePrintLetters(sfWebRequest $oRequest)
	{
		$snIntermentBookingId = $this->snBookingId = $oRequest->getParameter('id', '');
		$ssContentType = $oRequest->getParameter('content_type', '');
		$snCemeteryId = $this->getUser()->getAttribute('cemeteryid');
		
		$oExistsRecord = Doctrine::getTable('IntermentBookingFive')->findOneByIntermentBookingId($snIntermentBookingId);		
		if(!$oExistsRecord)
		{
			$oBooking5 = new IntermentBookingFive();
			$oBooking5->setIntermentBookingId($snIntermentBookingId);
			$oBooking5->save();
		}
		
		$amResultSet = Doctrine::getTable('IntermentBooking')->getLetterPrintStatusForBooking($snIntermentBookingId);
		if(count($amResultSet[0]['IntermentBookingFive']) > 0){

			$oPDF = new sfTCPDF();
			$oPDF->SetCreator(PDF_CREATOR);
			$oPDF->SetAuthor('Cemetery');
			$oPDF->SetTitle('Print Letters');
			$oPDF->SetSubject('Print Letters');
			$oPDF->SetKeywords('Service, Booking');
            
            $oPDF->SetMargins(PDF_MARGIN_LEFT, 5, PDF_MARGIN_RIGHT);

			//HEADER AND FOOTER IMAGE
			$amMailContent = Doctrine::getTable('MailContent')->getMailContentAsPerType($ssContentType,$snCemeteryId);

			//REPLACE STATIC VARIABLES WITH VALUE
			$amMailParams = array();			

            $ssLetterContent = $amMailContent[0]['content'];
			$asStaticVariables = sfGeneral::getAllStringBetween($ssLetterContent,'{','}');					

			foreach($asStaticVariables as $snKey => $ssValue) {
                $amMailParams['{'.$ssValue.'}'] = sfGeneral::getValueOfStaticVariables($ssValue,$amResultSet);
			}

            $ssLetterContent = sfGeneral::replaceMailContent($ssLetterContent, $amMailParams);
			$amContectArr = explode('<div style="page-break-after: always;">', $ssLetterContent);            
            
            $oPDF->SetMargins(PDF_MARGIN_LEFT, 5, PDF_MARGIN_RIGHT);
            $oPDF->SetFont('helvetica', '', 8, '', true);            
            $oPDF->SetAutoPageBreak(TRUE, 5);
            
			for($i=0;$i<count($amContectArr);$i++) 
            {   
                $oPDF->AddPage();
                $asFinalResult = str_replace('<span style="display: none;">&nbsp;</span></div>','',$amContectArr[$i]);
                $oPDF->writeHTML($asFinalResult);
			}

			// Close and output PDF document
			// This method has several options, check the source code documentation for more information.
			$ssFileName = 'letters.pdf';
			$ssContent = $oPDF->Output($ssFileName,'I');
			
			// Stop symfony process
			throw new sfStopException();
		}		
	}
	
	/**
    * Executes sendLetters action
    *
    * @access public
    * @param sfRequest $request A request object
    */
	public function executeSendLetters(sfWebRequest $oRequest)
	{
		$this->snBookingId = $oRequest->getParameter('id', '');        
		$snCemeteryId = $this->getUser()->getAttribute('cemeteryid');
		$this->ssContentType = $oRequest->getParameter('content_type', '');
        //add by arpita
        $this->snLetterId = $oRequest->getParameter('id_letter', '');
		$snBookingFiveId = '';

		$oBooking4 = Doctrine::getTable('IntermentBookingFour')->findOneByIntermentBookingId($this->snBookingId);
		$this->ssFwdOrReply = ($oBooking4) ? $oBooking4->getInformantEmail() :  '';
	
		$this->oSendLettersForm = new SendLettersForm();
		$this->getConfigurationFieldsForSendLetters($this->oSendLettersForm);
		
		if($oRequest->isMethod('post'))
		{

			$amSendLettersFormRequest = $oRequest->getParameter($this->oSendLettersForm->getName());
			$amSendLettersFileRequest = $oRequest->getFiles($this->oSendLettersForm->getName());
		
			$this->ssFwdOrReply = $amSendLettersFormRequest['mail_to'];
			$this->oSendLettersForm->bind($amSendLettersFormRequest,$amSendLettersFileRequest);
			
			if($this->oSendLettersForm->isValid())
			{
				
                //$oExistsRecord = Doctrine::getTable('IntermentBookingFive')->findOneByIntermentBookingId($this->snBookingId);
                $oExistsRecord = Doctrine::getTable('IntermentBookingFive')->findOneById($this->snLetterId);	
                $snBookingFiveId = $this->snLetterId;				

				$amResultSet = Doctrine::getTable('IntermentBooking')->getLetterPrintStatusForBooking($this->snBookingId);                
				if(count($amResultSet[0]['IntermentBookingFive']) > 0)
				{
					// pdf object
					$oPDF = new sfTCPDF();
					
					// set document information
					$oPDF->SetCreator(PDF_CREATOR);
					$oPDF->SetAuthor('Cemetery');
					$oPDF->SetTitle('Print Letters');
					$oPDF->SetSubject('Print Letters');
					$oPDF->SetKeywords('Service, Booking');
					
					// set default header data
					//$oPDF->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 001', PDF_HEADER_STRING);
					
					// set header and footer fonts
					$oPDF->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
					$oPDF->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
					
					// set default monospaced font
					$oPDF->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

					$amMailContent = Doctrine::getTable('MailContent')->getMailContentAsPerType($this->ssContentType, $snCemeteryId);
					
					// Add a page
					// This method has several options, check the source code documentation for more information.
					$oPDF->AddPage();
					
					$oPDF->SetFont('helvetica', '', 8, '', true);		
					$oPDF->setY('10');

					//////////////////////////////////////////////////
					// 		REPLACE STATIC VARIABLES WITH VALUE		//
					//////////////////////////////////////////////////
					$asStaticVariables = sfGeneral::getAllStringBetween($amMailContent[0]['content'],'{','}');					
					$amMailParams = array();
					
					foreach($asStaticVariables as $snKey => $ssValue)
						$amMailParams['{'.$ssValue.'}'] = sfGeneral::getValueOfStaticVariables($ssValue,$amResultSet);
					
					$ssMailContent = sfGeneral::replaceMailContent($amMailContent[0]['content'], $amMailParams);
					
                    
                    $amContectArr = explode('<div style="page-break-after: always;">', $ssMailContent);            
                    
                    $oPDF->SetMargins(PDF_MARGIN_LEFT, 5, PDF_MARGIN_RIGHT);
                    $oPDF->SetFont('helvetica', '', 8, '', true);            
                    $oPDF->SetAutoPageBreak(TRUE, 5);
                    
                    for($i=0;$i<count($amContectArr);$i++) 
                    {   
                        $oPDF->AddPage();
                        $asFinalResult = str_replace('<span style="display: none;">&nbsp;</span></div>','',$amContectArr[$i]);
                        $oPDF->writeHTML($asFinalResult);
                    }					
					// Close and output PDF document
					// This method has several options, check the source code documentation for more information.
					$ssFileName = 'letters.pdf';
					$ssPdfContent = $oPDF->Output($ssFileName,'S');
					
					// GENERATE TOKEN FOR LETTER CONFIRMATION
					$ssToken = sha1($snBookingFiveId.'_'.uniqid());					
					/*$ssConfirmationBody = get_partial('servicebooking/letterConfimationBody', 
												array('ssToken' 		=> $ssToken,
													  'snBookingFiveId' => $snBookingFiveId,
													  'ssContentType'	=> base64_encode($this->ssContentType)
													)
											 );	*/
					// ADD LINK INTO MAIL BODY WITH GENERATE TOKEN.
					//$amSendLettersFormRequest['mail_body'] = $amSendLettersFormRequest['mail_body'].$ssConfirmationBody;

					$ssImagePath = $oRequest->getHost().sfConfig::get('app_ckeditor_upload_image_path');
					$ssReplacedMailBody = str_replace(sfConfig::get('app_ckeditor_upload_image_path'), $ssImagePath, $amSendLettersFormRequest['mail_body']);

					$ssFromEmailId = sfConfig::get('app_admin_emailid');
					if(!$this->getUser()->isSuperAdmin() && $this->getUser()->getAttribute('cemeteryid') != '')
					{
						$oCemetery = Doctrine::getTable('CemCemetery')->find($this->getUser()->getAttribute('cemeteryid'));
						$ssFromEmailId = ($oCemetery->getEmail() != '') ? $oCemetery->getEmail() : sfConfig::get('app_admin_emailid');
					}

					// Send Letters in mail attachement.
					$ssMessage = Swift_Message::newInstance()
							  ->setFrom($ssFromEmailId)
							  ->setTo($this->ssFwdOrReply)
							  ->setSubject($amSendLettersFormRequest['mail_subject'])
							  ->setBody($ssReplacedMailBody,'text/html');
					
					// ADD DEFAULT ATTACHMENT FOR LETTER		  
					$ssMessage->attach(Swift_Attachment::newInstance($ssPdfContent,$ssFileName,'application/pdf'));
					
					// ADD USER ATTACHMENT IF UPLOADED
					$oFile = $this->oSendLettersForm->getValue('attachment');
					if(!empty($oFile))
					{
						$oFile->save(sfConfig::get('sf_upload_dir').'/'.$oFile->getOriginalName());
						$ssFileContent = file_get_contents(sfConfig::get('sf_upload_dir').'/'.$oFile->getOriginalName());
						$ssMessage->attach(Swift_Attachment::newInstance($ssFileContent,$oFile->getOriginalName(),$oFile->getType()));
						
						// REMOVE UPLODED FILE
						sfGeneral::removeFile(sfConfig::get('sf_upload_dir').'/'.$oFile->getOriginalName());
					}
					
					// SEND MAIL
					$oSend = sfContext::getInstance()->getMailer()->send($ssMessage);
					($oSend) ? $this->getUser()->setFlash('snSuccessMsgKey', 9) : $this->getUser()->setFlash('snErrorMsgKey', 4);

					// FOR LETTER CONFIMATION	
                    // following 1671 to 1695 commented by me(arpita) forjust checking issue.
					$amExistsRecord = Doctrine::getTable('LetterConfirmation')->checkForLetterExists($snBookingFiveId,$this->ssContentType);
                    
					if(count($amExistsRecord) == 0)
					{
						$amSaveData = array(
											'interment_booking_five_id'	=> $snBookingFiveId,
											'mail_content_type'			=> $this->ssContentType,
											'token'						=> $ssToken
											);
						
						// Saved Letter Information with new token.
						LetterConfirmation::saveConfirmationDetails($amSaveData,'new');
					}
					else
					{
						$amSaveData = array(
											'interment_booking_five_id'	=> $snBookingFiveId,
											'mail_content_type'			=> $this->ssContentType,
											'token'						=> $ssToken,
											'confirmed'					=> 0
											);

						// Update Letter Information with new token.
						LetterConfirmation::saveConfirmationDetails($amSaveData,'update');						
					}
					
					
					// UPDATE LETTERS STATUS
					$omCommon = new common();
					//$omCommon->UpdateStatusComposite('IntermentBookingFive',$this->ssContentType, $this->snBookingId, 'Yes', 'interment_booking_id');                    
                    $omCommon->UpdateStatusComposite('IntermentBookingFive','status', $this->snLetterId, 'Yes', 'id');

					echo "<script type='text/javascript'>
							var parent = window.opener;
							parent.location ='".url_for('servicebooking/addedit?id='.$this->snBookingId.'&tab=step6')."';
							window.close();
						 </script>";exit;
				}					
			}
		}
	}
	
	/**
    * Executes printBurialCertificate action
    *
    * @access public
    * @param sfRequest $request A request object
    */
	public function executePrintBurialCertificate(sfWebRequest $request)
	{
		$snIntementId = $request->getParameter('interment_id','');
		
		$amIntermentDetails = Doctrine::getTable('IntermentBooking')->getBurialDetailsForPrintAsPerId($snIntementId);
        
		if(count($amIntermentDetails) > 0)
		{
			// pdf object
			$oPDF = new sfTCPDF();
            
			$snCemeteryId = $this->getUser()->getAttribute('cemeteryid');
            $amMailContent = Doctrine::getTable('MailContent')->getMailContentAsPerType('burial_certificate', $snCemeteryId);
            
			// set document information
			$oPDF->SetCreator(PDF_CREATOR);
			$oPDF->SetAuthor('Cemetery');
			$oPDF->SetTitle('Burial Certifiacte');
			$oPDF->SetSubject('Burial Certifiacte');
			$oPDF->SetKeywords('Burial, Interment');			
			
			// set header and footer fonts
			$oPDF->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
			$oPDF->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
			
			// set default monospaced font
			$oPDF->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
			

			//set margins
			$oPDF->SetMargins(PDF_MARGIN_LEFT, 5, PDF_MARGIN_RIGHT);			
			//set auto page breaks
			$oPDF->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
						
			//////////////////////////////////////////////////
            // 		REPLACE STATIC VARIABLES WITH VALUE		//
            //////////////////////////////////////////////////
            
            $amMailParams = array();
            
            $ssMailContent = $amMailContent[0]['content'];
				
			$asStaticVariables = sfGeneral::getAllStringBetween($ssMailContent,'{','}');
	
            foreach($asStaticVariables as $snKey => $ssValue)
                $amMailParams['{'.$ssValue.'}'] = sfGeneral::getValueOfStaticVariables($ssValue, $amIntermentDetails);
			
			// Set some content to print		
            $ssHTML = sfGeneral::replaceMailContent($amMailContent[0]['content'], $amMailParams);
			
            $amContectArr = explode('<div style="page-break-after: always;">', $ssHTML);            
            
            $oPDF->SetMargins(PDF_MARGIN_LEFT, 5, PDF_MARGIN_RIGHT);
            $oPDF->SetFont('helvetica', '', 8, '', true);            
            $oPDF->SetAutoPageBreak(TRUE, 5);
            
			for($i=0;$i<count($amContectArr);$i++) 
            {   
                $oPDF->AddPage();
                $asFinalResult = str_replace('<span style="display: none;">&nbsp;</span></div>','',$amContectArr[$i]);
                $oPDF->writeHTML($asFinalResult);
			}            
			$ssFileName = $amIntermentDetails[0]['deceased_title'].$amIntermentDetails[0]['deceased_name'];			
			// Close and output PDF document
			// This method has several options, check the source code documentation for more information.
			$oPDF->Output($ssFileName, 'I');
			
			// Stop symfony process
			throw new sfStopException();
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
		return $this->renderPartial('getCementeryList', array('asCementery' => $asCementery));
	}
	/**
    * Executes getAreaListAsPerCemetery action
    *
    * @access public
    * @param sfRequest $request A request object
    */
    public function executeGetAreaListAsPerCemetery(sfWebRequest $request)
    {	
		$snIdCountry = $request->getParameter('country_id','');
		$snCemeteryId = $request->getParameter('cemetery_id','');
		$asAreaList = Doctrine::getTable('ArArea')->getAreaListAsPerCemetery($snIdCountry, $snCemeteryId);
		return $this->renderPartial('getAreaList', array('asAreaList' => $asAreaList));
	}
	/**
    * Executes getSectionListAsPerArea action
    *
    * @access public
    * @param sfRequest $request A request object
    */
    public function executeGetSectionListAsPerArea(sfWebRequest $request)
    {	
		$snIdCountry = $request->getParameter('country_id','');
		$snCemeteryId = $request->getParameter('cemetery_id','');
		$snAreaId = $request->getParameter('area_id','');
		$asSectionList = Doctrine::getTable('ArSection')->getSectionListAsPerArea($snIdCountry,$snCemeteryId,$snAreaId);

		return $this->renderPartial('getSectionList', array('asSectionList' => $asSectionList));
	}
	/**
    * Executes getRowListAsPerSection action
    *
    * @access public
    * @param sfRequest $request A request object
    */
    public function executeGetRowListAsPerSection(sfWebRequest $request)
    {	
		$snIdCountry = $request->getParameter('country_id','');
		$snCemeteryId = $request->getParameter('cemetery_id','');
		$snAreaId = $request->getParameter('area_id','');
		$snSectionId = $request->getParameter('section_id','');
		$asRowList = Doctrine::getTable('ArRow')->getRowListAsPerSection($snIdCountry,$snCemeteryId,$snAreaId,$snSectionId);

		return $this->renderPartial('getRowList', array('asRowList' => $asRowList));
	}
	/**
    * Executes getPlotListAsPerRow action
    *
    * @access public
    * @param sfRequest $request A request object
    */
    public function executeGetPlotListAsPerRow(sfWebRequest $request)
    {	
		$snIdCountry = $request->getParameter('country_id','');
		$snCemeteryId = $request->getParameter('cemetery_id','');
		$snAreaId = $request->getParameter('area_id','');
		$snSectionId = $request->getParameter('section_id','');
		$snRowId = $request->getParameter('row_id','');
		
		$asPlotList = Doctrine::getTable('ArPlot')->getPlotListAsPerArea($snIdCountry,$snCemeteryId,$snAreaId,$snSectionId,$snRowId);

		return $this->renderPartial('getPlotList', array('asPlotList' => $asPlotList));
	}
	/**
    * Executes getGraveListAsPerPlot action
    *
    * @access public
    * @param sfRequest $request A request object
    */


    public function executeGetGraveListAsPerPlot(sfWebRequest $request)
    {	
		$snIdCountry = $request->getParameter('country_id','');
		$snCemeteryId = $request->getParameter('cemetery_id','');
		$snAreaId = $request->getParameter('area_id','');
		$snSectionId = $request->getParameter('section_id','');
		$snRowId = $request->getParameter('row_id','');
		$snPlotId = $request->getParameter('plot_id','');
		
		$asGraveList = Doctrine::getTable('ArGrave')->getGraveListAsPerCriteria($snIdCountry,$snCemeteryId,$snAreaId,$snSectionId,$snRowId,$snPlotId,'true');

		return $this->renderPartial('getGraveList', array('asGraveList' => $asGraveList));
	}
	/**
    * Executes FillGranteeInfoAsPerGrave action
    *
    * @access public
    * @param sfRequest $request A request object
    */
    public function executeFillGranteeInfoAsPerGrave(sfWebRequest $request)
    {
		$snIdGrave = $request->getParameter('grave_id','');
		
		$amGranteeDetails = Doctrine::getTable('Grantee')->getGranteeDetailsAsPerGrave($snIdGrave);
		$this->asGraveStatus = Doctrine::getTable('ArGraveStatus')->getGraveStatus();

		return $this->renderPartial('fillGranteeDetails', array('amGranteeDetails' => $amGranteeDetails,'asGraveStatus' => $this->asGraveStatus));
	}
	/**
    * Executes FillGranteeInfoAsPerGrave action
    *
    * @access public
    * @param sfRequest $request A request object
    */
    public function executeFillGranteeRemarks(sfWebRequest $request)
    {
		$snIdGrantee = $request->getParameter('grantee_id','');
		$omGranteeDetails = Doctrine::getTable('GranteeDetails')->find($snIdGrantee);

		return $this->renderPartial('fillGranteeRemarks', array('omGranteeDetails' => $omGranteeDetails));
	}
	/**
    * Executes getGraveListAsPerPlot action
    *
    * @access public
    * @param sfRequest $request A request object
    */
    public function executeFillGraveSizeInfo(sfWebRequest $request)
    {
		$snIdGrave = $request->getParameter('grave_id','');
		$omGraveDetails = Doctrine::getTable('ArGrave')->find($snIdGrave);
		$amGraveUnitType = Doctrine::getTable('UnitType')->getGraveUnitTypes();

		return $this->renderPartial('fillGraveSizeDetails', array('omGraveDetails' => $omGraveDetails,'amGraveUnitType' => $amGraveUnitType));
	}
	/**
    * Executes getGraveListAsPerPlot action
    *
    * @access public
    * @param sfRequest $request A request object
    */
    public function executeFillMonumentDetails(sfWebRequest $request)
    {
		$snIntermentBookingId = $request->getParameter('id','');
		if($snIntermentBookingId != '') 
		{
			$this->forward404Unless($oIntermentBooking = Doctrine::getTable('IntermentBooking')->find($snIntermentBookingId));
			$oIntermentBookingForm = new IntermentBookingForm($oIntermentBooking);
		}
		else
			$oIntermentBookingForm = new IntermentBookingForm();
		
		$snIdGrave = $request->getParameter('grave_id','');
		$omGraveDetails = Doctrine::getTable('ArGrave')->find($snIdGrave);
		$amGraveUnitType = Doctrine::getTable('UnitType')->getGraveUnitTypes();
		$amStoneMason = Doctrine::getTable('sfGuardUser')->getStoneMasonByUserRole();
		
		return $this->renderPartial('fillMonumentsDetails', array('omGraveDetails' => $omGraveDetails,
																  'amGraveUnitType' => $amGraveUnitType,
																  'amStoneMason'	=> $amStoneMason,
																  'oIntermentBookingForm' => $oIntermentBookingForm
																));
	}
	/**
    * Executes displayInfo action
    *
    * @access public
    * @param sfRequest $request A request object
    */
    public function executeDisplayInfo(sfWebRequest $request)
    {
		$snIdGrave = $request->getParameter('id_grave','');
		
		// Display Grave Location, Grantees, Interments/Ashes/Exhumation
		$this->amDisplayInfo = Doctrine::getTable('IntermentBooking')->displayInfoAsPerGrave($snIdGrave);
		
		$this->amLinkedGrave = array();
		$this->ssLinkedArray = base64_decode($request->getParameter('linked_array',''));
		if($this->ssLinkedArray == ''){
		    // Get linked grave info
		    $this->amLinkedGraveInfo = Doctrine::getTable('GraveLink')->getLinkedGraveInfo($snIdGrave);
		    if(count($this->amLinkedGraveInfo) > 0){
		        $this->amLinkedGrave  = explode(',', $this->amLinkedGraveInfo[0]['grave_id']);
		        $this->ssLinkedArray = $this->amLinkedGraveInfo[0]['grave_id'];
            }
        }else{
            $this->amLinkedGrave  = explode(',', $this->ssLinkedArray);
        }
        
        //if($request->isXmlHttpRequest()){
            // Get grave info for display on map
            $this->ssCemetery 	= $this->amDisplayInfo[0]['CemCemetery']['name'];
		    $this->ssArea		= ($this->amDisplayInfo[0]['ArArea']['area_name'] != '' && $this->amDisplayInfo[0]['ArArea']['area_name'] != '0') ? $this->amDisplayInfo[0]['ArArea']['area_name'] : __('N/A');
		    $this->ssSection	= ($this->amDisplayInfo[0]['ArSection']['section_name'] != '' && $this->amDisplayInfo[0]['ArSection']['section_name'] != '0') ? $this->amDisplayInfo[0]['ArSection']['section_name'] : __('N/A');
		    $this->ssRow		= ($this->amDisplayInfo[0]['ArRow']['row_name'] != '' && $this->amDisplayInfo[0]['ArRow']['row_name'] != '0') ? $this->amDisplayInfo[0]['ArRow']['row_name'] : __('N/A');
		    $this->ssPlot		= ($this->amDisplayInfo[0]['ArPlot']['plot_name'] != '' && $this->amDisplayInfo[0]['ArPlot']['plot_name'] != '0') ? $this->amDisplayInfo[0]['ArPlot']['plot_name'] : __('N/A');
		    $this->ssGrave		= $this->amDisplayInfo[0]['grave_number'];
		    $this->smLat		= $this->amDisplayInfo[0]['latitude'];
		    $this->smLong		= $this->amDisplayInfo[0]['longitude'];
            
		    $this->ssCemLat		= $this->amDisplayInfo[0]['CemCemetery']['latitude'];
		    $this->ssCemLong	= $this->amDisplayInfo[0]['CemCemetery']['longitude'];	
		
		    // Get grave history
		    $this->ssFormName = 'frm_list_grantee_grave_history';
		    $this->amSearch = array();
            $omCommon = new common();
		
		    $this->snIdGrave = $request->getParameter('id_grave','');
            $oGraveHistoryPageListQuery = Doctrine::getTable('GranteeGraveHistory')->getGranteeGraveHistory($this->amExtraParameters, $this->amSearch,'',$this->snIdGrave);
                   
            // Set pager and get results
            $oPager               = new sfMyPager();
            $this->oGraveHistoryList  = $oPager->getResults('GranteeGraveHistory', '', $oGraveHistoryPageListQuery, $this->snPage);
            $this->amGraveHistoryList = $this->oGraveHistoryList->getResults(Doctrine::HYDRATE_ARRAY);
            unset($oPager);

            // Total number of records
            $this->snPageTotalGraveHistoryPages = $this->oGraveHistoryList->getNbResults();
        //}
	}

    /**
     * getConfigurationFieldsForUploadDoc
     *
     * Function for prepare configuration fields for form
     * @access private
     * @param  object $oForm form object
     *     
     */
    private function getConfigurationFieldsForUploadDoc($oForm)
    {
		$oForm->setWidgets(array());
		
		 $oForm->setLabels(
            array(
				'file_name'				 => __('File Name'),
				'file_path'				 => __('Select File'),
				 )
        );
		$oForm->setValidators(
            array(
    	            'file_name'    	=> array(
												'required'  => __('Please enter filename')
												),
					'file_path'	=> array(
												'required'  	=> __('Please select file'),
												'mime_types'	=> __('The file must be of PDF, DOC, EXCEL, TXT, IMAGE format')
												)
				)
        );				
	}
	/**
     * getConfigurationFields
     *
     * Function for prepare configuration fields for form
     * @access private
     * @param  object $oForm form object
     *     
     */
    private function getConfigurationFieldsForFinalizedBooking($oForm)
    {
		$oForm->setWidgets(array());
        $oForm->setLabels(
            array('interment_date'	=> __('Interment Date'),
				  'control_number'	=> __('Control Number')
				)
        );
		$oForm->setDefault('interment_date', $this->ssIntermentDate);
		$oForm->setValidators(
            array(
					'control_number'        => array(
												'required'  => __('Please enter control number')
												)
				)
        );
											
	}
	private function getConfigurationFieldsForSendLetters($oForm)
    {
		$oForm->setWidgets(array());
		
		 $oForm->setLabels(
            array(
				'mail_to'		=> __('To'),
				'mail_subject'	=> __('Subject'),
				'mail_body'		=> __('Content'),
				'attachment'	=> __('Attachment')
				 )
        );
		$oForm->setValidators(
            array(
    	            'mail_to'    	=> array('required'  => __('Please enter email id'),'invalid' => __('Please enter valid email id')),
					'mail_subject'	=> array('required'  	=> __('Please enter subject')),
					'mail_body'		=> array('required'  	=> __('Please enter body content'))
				)
        );				
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
        if($oForm->isNew())
        {
            $oCountry = Doctrine::getTable('Country')->findOneByName('Australia');
            if($oCountry)
                $oForm->setDefault('deceased_country_id_of_death', $oCountry->getId());
            else
                $oForm->setDefault('deceased_country_id_of_death',  __('Select Country Of Death'));
        }
        $oForm->setWidgets(
			array(
                    'catalog_id' => __('Select Catalog'),
                    'payment_id'=>__('Select pament status'),
					'cem_cemetery_id'	=> __('Select Cemetery'),
					'country_id'		=> __('Select Country'),
					'ar_grave_status'		=> __('Select Grave Statuss'),
					'denomination_id'  => __('Select Denomination'),
					'service_type_id' => __('Select Service Type'),
					'fnd_fndirector_id' => __('Select Funeral Director'),
					'cem_stonemason_id' => __('Select Stone Mason'),
					'disease_id' => __('Select Infectious Disease'),
					'unit_type_id' => __('Select Unit Type'),
					'coffin_type_id' => __('Select Type'),
					'lodged_by_id' => __('Select Lodged BY'),
					'deceased_country_id_of_death' => __('Select Country Of Death'),
					'deceased_country_id_of_birth' => __('Select Country Of Birth'),
					'deceased_country_id' => __('Select Country'),
					'informant_country_id' => __('Select Country'),
					'date_next'	=> __('Next'),
					'date_prev'	=> __('Previous'),
					'finageuom' => __('Select Finageuom'),
					'cul_calender_type'	=> __('Select One'),                    
				 )
		);

        $oForm->setLabels(
            array(
                'catalog_id' => __('Select Catalog'),
                'payment_id'=>__('Select pament status'),
				'cem_cemetery_id'				 => __('Select Cemetery'),
                'ar_grave_status'                => __('Grave Status'),
				'denomination_id'                => __('Denomination'),
				'service_type_id'                => __('Service Type'),
				'fnd_fndirector_id'              => __('Select Funeral Director'),
				'cem_stonemason_id'              => __('Select Stone Mason'),
				'disease_id'                     => __('Infectious Disease'),
				'unit_type_id'                   => __('Select Unit Type'),
				'coffin_type_id'                 => __('Select Type'),
				'lodged_by_id'                   => __('Select Lodged By'),
				'lodged_by_name'                 => __('Lodged By Name'),
				'deceased_place_of_death'        => __('Deceased Place of Death'),
				'deceased_country_id_of_death'   => __('Deceased Country of Death'),
				'deceased_country_id_of_birth'   => __('Deceased Country of Birth'),
				'deceased_place_of_birth'        => __('Deceased Place of Birth'),
				'deceased_date_of_birth'         => __('Deceased Date of Birth'),
				'deceased_date_of_death'         => __('Deceased Date of Death'),
				'deceased_age'                   => __('Deceased Age'),
				'deceased_title'               	 => __('Deceased Title'),
				'deceased_surname'               => __('Deceased Surname'),
				'deceased_first_name'            => __('Deceased First Name'),
				'deceased_middle_name'           => __('Deceased Last Name'),
				'deceased_other_surname'         => __('Other Surname'),
				'deceased_other_first_name'      => __('Other First Name'),
				'deceased_other_middle_name'     => __('Other Middle Name'),
				'deceased_usual_address'         => __('Deceased Usual Address'),
				'deceased_suburb_town'           => __('Deceased Subrb Town'),
				'deceased_state'                 => __('deceased_state'),
				'deceased_postal_code'           => __('Deceased Postal Code'),
				'deceased_country_id'            => __('Deceased Country'),
				'deceased_marital_status'        => __('Deceased Marital Status'),
				'deceased_partner_name'          => __('Deceased Partner Name'),
				'deceased_partner_surname'       => __('Deceased Partner Surname'),
				'deceased_father_name'           => __('Deceased Father Name'),
				'deceased_father_surname'        => __('Deceased Father Surname'),
				'deceased_mother_name'           => __('Deceased Mother Name'),
				'deceased_mother_maiden_surname' => __('Deceased Mother Maiden Surname'),
				'deceased_children1'             => __('Children of Deceased'),
				'deceased_children2'             => __('Deceased Children 2'),
				'deceased_children3'             => __('Deceased Children 3'),
				'deceased_children4'             => __('Deceased Children 4'),
				'deceased_children5'             => __('Deceased Children 5'),
				'deceased_children6'             => __('Deceased Children 6'),
				'deceased_children7'             => __('Deceased Children 7'),
				'deceased_children8'             => __('Deceased Children 8'),
				'deceased_children9'             => __('Deceased Children 9'),
				'deceased_children10'            => __('Deceased Children 10'),
				'deceased_children11'            => __('Deceased Children 11'),
				'deceased_children12'            => __('Deceased Children 12'),
				'deceased_gender'                => __('Deceased Gener'),
				'relationship_to_deceased'       => __('Relationship To Deceased'),                
                'informant_title'                => __('Title'),
				'informant_surname'              => __('Informant Surname'),
				'informant_first_name'           => __('Informant First Name'),
				'informant_middle_name'          => __('Informant Middle Name'),
				'informant_fax_area_code'		 => __('Fax Area Code'),
				'informant_fax'                  => __('Informant Fax'),
				'informant_email'                => __('Informant Email'),
				'informant_telephone_area_code'	 => __('Telephone Area Code'),
				'informant_telephone'            => __('Informant Telephone'),
				'informant_mobile'               => __('Informant Mobile'),
				'informant_address'              => __('Informant Address'),
				'informant_suburb_town'          => __('Informant Suburb Town'),
				'informant_state'                => __('informant_state'),
				'informant_postal_code'          => __('Informant Postal Code'),
				'informant_country_id'           => __('Informant Country'),
				'date_notified'                  => __('Date Notified'),
				'consultant'                     => __('Consultant'),
				'service_booking_time_from'      => __('Time From'),
				'service_booking_time_to'        => __('Time To'),
				'service_booking_day'            => __('Service Booking Day'),
				'control_number'                 => __('Control Number'),
				'interment_date'                 => __('Interment Date'),
				'death_certificate'              => __('Death Certificate'),
				'own_clergy'                     => __('Own Clergy'),
				'clergy_name'                    => __('Clergy Name'),
				'coffin_surcharge'               => __('Coffin Surcharge'),
				'burning_drum'                   => __('Burning Drum'),
				'fireworks'                      => __('Fireworks'),
				'facility'                       => __('Facility'),
				'facility_from'                  => __('From'),
				'facility_to'                    => __('To'),
				'file_location'                  => __('File Location'),
				'coffin_length'                  => __('Length'),
				'coffin_width'                   => __('Width'),
				'coffin_height'                  => __('Height'),
				'chapel'                         => __('Chapel'),
				'chapel_time_from'               => __('From'),
				'chapel_time_to'                 => __('To'),
				'room'                           => __('Room'),
				'room_time_from'                 => __('From'),
				'room_time_to'                   => __('To'),
				'special_instruction'            => __('Special Instruction'),
				'invoice_number'                 => __('Invoice Number'),
				'receipt_number'                 => __('Receipt Number'),
				'monument'                       => __('Monument'),
				'grantee_first_name'             => __('Grantee First Name'),
				'grantee_surname'                => __('Grantee Surname'),
				'grantee_relationship'           => __('Grantee Relationship'),

				'file_location'                     => __('File Location '),
				'cemetery_application'              => __('Cemetery Application'),
				'burial_booking_form'               => __('Burial Booking Form'),
				'ashes_booking_form'                => __('Ashes Booking Form'),
				'exhumation_booking_from'           => __('Exhumation Booking Form'),
				'remains_booking_from'              => __('Remains Booking Form'),
				'health_order'                      => __('Health Order'),
				'court_order'                       => __('Court Order'),
				'checked_fnd_details'               => __('Checked Funeral Directors detail- Name, address and Fax number'),
				'checked_owner_grave'        		=> __('Checked Grave and Section including owner details'),
				'living_grave_owner'                => __('Living grave owner'),
				'deceased_grave_owner'              => __('Deceased grave owner: all their heirs and or descendants'),
				'cecked_chapel_booking'             => __('Cecked Chapel booking(if requested)'),
				'advised_fd_to_check'     			=> __('Advised FD to check Chapel Equipment at least one day before'),
				'advised_fd_recommended'   			=> __('Advised FD of recommended Coffin Sizes'),
				'advised_fd_coffin_height' 			=> __('Advised FD of coffin height surcharges'),
				'medical_death_certificate'    		=> __('Recieved'),
				'medical_certificate_spelling'      => __('Checked spelling of deceased full name'),
				'medical_certificate_infectious' 	=> __('Checked for infectious diseases. If "Yes" noted same on booking sheets'),
				'request_probe_for_any_re_opens'    => __('Request probe for any re-opens'),
				'request_probe_reopen'				=> __('Request for triple depth grave on re-opens'),
				'request_triple_depth_reopen'		=> __('Request triple depth burial'),
				'checked_monumental'				=> __('Checked Monumental information'),
				'contacted_stonemason'    			=> __('Contacted Stonemason if needed (e.g. slab removal)'),
				'checked_accessories'               => __('Checked accessories'),
				'balloons_na'                       => __('BalloonsN/A'),
				'burning_drum'                      => __('Burning Drum'),
				'canopy'                            => __('Canopy'),
				'ceremonial_sand_bucket'            => __('Ceremonial Sand Bucket'),
				'fireworks'                         => __('Fireworks'),
				'lowering_device'                   => __('Lowering Device'),
				'other'                             => __('Other'),
				'checked_returned_signed'          	=> __('Checked confirmation signed and returned'),
				'check_coffin_sizes_surcharge'     	=> __('Check coffin sizes are acceptable and surcharge applied'),
				'surcharge_applied'     			=> __('Surcharge applied'),
				'compare_burial_booking'           	=> __('Compare Burial check to burial booking (coffin size/spear lowering)'),
				'for_between_burials'              	=> __('For in-between burials, check surcharge has been paid'),
				'double_check_yellow_date'         	=> __('Double check that yellow copy shows up to date information ie. coffin sizes, burial times etc...'),
				'grave_size'           			 	=> __('Size'),
				'grave_length'           			=> __('Length'),
				'grave_width'           		 	=> __('Width'),
				'grave_depth'           		 	=> __('Depth'),
				'grave_unit_type'					=> __('UnitType'),
				'monuments_grave_position'       	=> __('Grave Position'),
				'monument'                       	=> __('Monument'),
				'cem_stonemason_id'              	=> __('Stone Mason'),
				'monuments_unit_type'            	=> __('Plot Unit Type'),
				'monuments_depth'               	=> __('Depth'),
				'monuments_length'               	=> __('Length'),
				'monuments_width'					=> __('Width'),
				'comment1'							=> __('Comment 1'),
				'comment2'							=> __('Comment 2'),
				'service_date'						=> __('Service Date 1'),
				'service_date2'						=> __('Service Date 2'),
				'service_date3'						=> __('Service Date 3'),
				'service_booking2_time_from'      	=> __('Time From'),
				'service_booking2_time_to'        	=> __('Time To'),
				'service_booking3_time_from'      	=> __('Time From'),
				'service_booking3_time_to'        	=> __('Time To'),
				'ceremonial_sand'                	=> __('Ceremonial Sand'),
				'canopy'                 		 	=> __('Canopy'),
				'lowering_device'                	=> __('Lowering Device'),
				'balloons'                 		 	=> __('Balloons'),
				'chapel_multimedia'					=> __('Chapel Multimedia'),
				'period'							=> __('Period'),
				'chapel_grouplist'					=> __('Select Chapel Type'),
				'room_grouplist'					=> __('Select Room Type'),				
				
				'cul_calender_type'      	=> __('Background'),
				'cul_date_of_death'        	=> __('Date of Death'),
				'cul_date_of_interment'     => __('Date of Interment'),
				'cul_died_after_dust'       => __('Died After Dusk'),
				'cul_time_of_death'         => __('Time of Death'),
				'cul_date_of_birth'         => __('Date of Birth'),
				'cul_status'				=> __('Status'),
				'cul_remains_position'		=> __('Remains Position')
            )
        );
		
		$oForm->setDefault('interment_date', $this->ssIntermentDate);

        $oForm->setValidators(
            array(
    	            'deceased_surname'    	=> array(
												'required'  => __('Please enter deceased surname')
												),
					'deceased_first_name'	=> array(
												'required'  => __('Please enter deceased first name')
												),
	                'deceased_middle_name'	=> array(
												'required'  => __('Please enter deceased middle name')
												),
	                'informant_email'		=> array(
												'invalid'  => __('Please enter valid informant email')
												),
					'booking_invalid_date'	=> array(
												'invalid'  => __('Please select valid date')
												),
	                'booking_date_past'		=> array(
												'invalid'  => __('Please select greater than or equal current date')
												),
					'control_number'        => array(
												'required'  => __('Please enter control number')
												)
				)
        );
    }    
}
