<?php
/**
 * GraveLogs actions.
 *
 * @package    Cemetery
 * @subpackage graveLogs
 * @author     Nitin Barai
 * @author      
 *
 */
sfProjectConfiguration::getActive()->loadHelpers(array('I18N','Partial'));
class gravelogActions extends sfActions
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
        $this->ssFormName = 'frm_list_graveLogs';
        $omRequest        = sfContext::getInstance()->getRequest();

        // Set default values
        $this->amExtraParameters = array();
        $this->amExtraParameters['snPaging']        = $this->snPaging       = $omRequest->getParameter('paging',sfConfig::get('app_default_paging_records'));
        $this->amExtraParameters['snPage']          = $this->snPage         = $omRequest->getParameter('page', sfConfig::get('app_default_page', 1));

		$this->ssSearchCemId = ( !$this->getUser()->isSuperAdmin() ) ? $this->getUser()->getAttribute('cemeteryid') : trim($omRequest->getParameter('searchCemId',''));
        $this->amExtraParameters['ssSearchCemId']   		= $this->ssSearchCemId;
        $this->amExtraParameters['ssSearchOperationDate']   = $this->ssSearchOperationDate  = trim($omRequest->getParameter('searchOperationDate',''));
        $this->amExtraParameters['ssSearchUserId']   		= $this->ssSearchUserId  		= trim($omRequest->getParameter('searchUserId',''));
        
        $this->amExtraParameters['ssSortBy']        = $this->ssSortBy       = $omRequest->getParameter('sortby','operation_date');
        $this->amExtraParameters['ssSortMode']      = $this->ssSortMode     = $omRequest->getParameter('sortmode','desc');

        $this->ssSortQuerystr = $this->ssQuerystr = 'page='.$this->snPage.'&paging='.$this->snPaging;

		if($this->ssSearchCemId != '' )        // Search parameters
        {
            $this->ssQuerystr    .= '&searchCemId='.$this->ssSearchCemId;
            $this->ssSortQuerystr.= '&searchCemId='.$this->ssSearchCemId;
        } 
        if($this->getRequestParameter('searchOperationDate') != '' )        // Search parameters
        {
            $this->ssQuerystr    .= '&searchOperationDate='.$this->getRequestParameter('searchOperationDate');
            $this->ssSortQuerystr.= '&searchOperationDate='.$this->getRequestParameter('searchOperationDate');
        }
        if($this->getRequestParameter('searchUserId') != '' )        // Search parameters
        {
            $this->ssQuerystr    .= '&searchUserId='.$this->getRequestParameter('searchUserId');
            $this->ssSortQuerystr.= '&searchUserId='.$this->getRequestParameter('searchUserId');
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
								'user_id' => array(
												'caption'	=> __('User'),
												'id'		=> 'UserId',
												'type'		=> 'selectajax',
												'ssPartial' => 'getCemeteryStaffList',
												'ssArrayKey' => 'asCemStaffList',
												'ssArrayValue' 	=> 'snCompletedBy',
												'options'	=> array()
											),
								'operation_date' => array(
												'caption'	=> __('Date'),
												'id'		=> 'OperationDate',
												'type'		=> 'date',																								
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
								'cem_id' => array(
												'caption'	=> __('Cemetery'),
												'id'		=> 'CemId',
												'type'		=> 'selectajax',
												'ssPartial' => 'getCustomCementeryList',
												'ssArrayKey' => 'asCementryList',
												'ssArrayValue' 	=> 'snCementeryId',
												'options'	=> array()
											)															
							) + $this->amSearch;
		}

		$this->oGuardGroupList = '';
		$this->amGuardGroupList = array();
		$this->snPageTotalGuardGroupPages = 0;
		
		if($this->ssSearchCemId != '' && ($this->ssSearchOperationDate != '' || $this->ssSearchUserId != '') ) 
		{
			// Get cms page list for listing.
			$oGuardGroupPageListQuery = Doctrine::getTable('GraveLogs')->getGraveLogsList($this->amExtraParameters, $this->amSearch);

			// Set pager and get results
			$oPager               = new sfMyPager();
			$this->oGuardGroupList  = $oPager->getResults('GraveLogs', $this->snPaging,$oGuardGroupPageListQuery,$this->snPage);
			$this->amGuardGroupList = $this->oGuardGroupList->getResults(Doctrine::HYDRATE_ARRAY);

			unset($oPager);

			// Total number of records
			$this->snPageTotalGuardGroupPages = $this->oGuardGroupList->getNbResults();
			
		}
		if($request->getParameter('request_type') == 'ajax_request')
			$this->setTemplate('listGraveLogsUpdate');
    }

	/**
    * Executes index action
    *
    * @access public
    * @param sfRequest $request A request object
    */
    public function executeGranteeLog(sfWebRequest $request)
    {
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
								'user_id' => array(
												'caption'	=> __('User'),
												'id'		=> 'UserId',
												'type'		=> 'selectajax',
												'ssPartial' => 'getCemeteryStaffList',
												'ssArrayKey' => 'asCemStaffList',
												'ssArrayValue' 	=> 'snCompletedBy',
												'options'	=> array()
											),
								'operation_date' => array(
												'caption'	=> __('Date'),
												'id'		=> 'OperationDate',
												'type'		=> 'date',																								
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
								'cem_id' => array(
												'caption'	=> __('Cemetery'),
												'id'		=> 'CemId',
												'type'		=> 'selectajax',
												'ssPartial' => 'getCustomCementeryList',
												'ssArrayKey' => 'asCementryList',
												'ssArrayValue' 	=> 'snCementeryId',
												'options'	=> array()
											)															
							) + $this->amSearch;
		}

		$this->oGranteeLogList = '';
		$this->amGranteeLogList = array();
		$this->snPageTotalGranteeLogPages = 0;
		
		if($this->ssSearchCemId != '' && ($this->ssSearchOperationDate != '' || $this->ssSearchUserId != '') ) 
		{
			// Get cms page list for listing.
			$oGranteeLogPageListQuery = Doctrine::getTable('GranteeLogs')->getGranteeLogsList($this->amExtraParameters, $this->amSearch);
			
			// Set pager and get results
			$oPager               = new sfMyPager();
			$this->oGranteeLogList  = $oPager->getResults('GranteeLogs', $this->snPaging,$oGranteeLogPageListQuery,$this->snPage);
			$this->amGranteeLogList = $this->oGranteeLogList->getResults(Doctrine::HYDRATE_ARRAY);

			unset($oPager);

			// Total number of records
			$this->snPageTotalGranteeLogPages = $this->oGranteeLogList->getNbResults();
		}
		if($request->getParameter('request_type') == 'ajax_request')
			$this->setTemplate('listGranteeLogsUpdate');
	}
	
	/**
    * Executes index action
    *
    * @access public
    * @param sfRequest $request A request object
    */
    public function executeBookingLog(sfWebRequest $request)
    {
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
								'user_id' => array(
												'caption'	=> __('User'),
												'id'		=> 'UserId',
												'type'		=> 'selectajax',
												'ssPartial' => 'getCemeteryStaffList',
												'ssArrayKey' => 'asCemStaffList',
												'ssArrayValue' 	=> 'snCompletedBy',
												'options'	=> array()
											),
								'operation_date' => array(
												'caption'	=> __('Date'),
												'id'		=> 'OperationDate',
												'type'		=> 'date',																								
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
								'cem_id' => array(
												'caption'	=> __('Cemetery'),
												'id'		=> 'CemId',
												'type'		=> 'selectajax',
												'ssPartial' => 'getCustomCementeryList',
												'ssArrayKey' => 'asCementryList',
												'ssArrayValue' 	=> 'snCementeryId',
												'options'	=> array()
											)															
							) + $this->amSearch;
		}

		$this->oBookingLogList = '';
		$this->amBookingLogList = array();
		$this->snPageTotalBookingLogPages = 0;
		
		if($this->ssSearchCemId != '' && ($this->ssSearchOperationDate != '' || $this->ssSearchUserId != '') ) 
		{
			// Get cms page list for listing.
			$oBookingLogPageListQuery = Doctrine::getTable('IntermentBookingLogs')->getBookingLogsList($this->amExtraParameters, $this->amSearch);
			
			// Set pager and get results
			$oPager               = new sfMyPager();
			$this->oBookingLogList  = $oPager->getResults('IntermentBookingLogs', $this->snPaging,$oBookingLogPageListQuery,$this->snPage);
			$this->amBookingLogList = $this->oBookingLogList->getResults(Doctrine::HYDRATE_ARRAY);

			unset($oPager);

			// Total number of records
			$this->snPageTotalBookingLogPages = $this->oBookingLogList->getNbResults();
		}
		if($request->getParameter('request_type') == 'ajax_request')
			$this->setTemplate('listBookingLogsUpdate');
	}
	/**
    * Executes getCementryListAsPerCountry action
    *
    * @access public
    * @param sfRequest $request A request object
    */
    public function executeSaveLogIntoPDF(sfWebRequest $oRequest)
    {
		$ssLogType 				= $oRequest->getParameter('logtype','');		
		$ssSearchCemId 		 	= $oRequest->getParameter('cemetery_id','');
		$ssSearchUserId			= $oRequest->getParameter('user_id','');
		$ssSearchOperationDate	= $oRequest->getParameter('operation_date','');
		$amLogsResult 			= array();
		$ssPDFHeading 			= '';

		if($ssSearchCemId != '' && ($ssSearchOperationDate != '' || $ssSearchUserId != '') ) 
		{
			if($ssLogType == 'gravelog')
			{
				// Get grave logs ist for store into pdf.
				$amLogsResult = Doctrine::getTable('GraveLogs')->getGraveLogsForPDF($ssSearchCemId,$ssSearchUserId, $ssSearchOperationDate);
				$ssPDFHeading = __('Grave Log');
			}
			elseif($ssLogType == 'granteelog')
			{
				// Get grantee logs list for store into pdf.
				$amLogsResult = Doctrine::getTable('GranteeLogs')->getGranteeLogsForPDF($ssSearchCemId,$ssSearchUserId, $ssSearchOperationDate);
				$ssPDFHeading = __('Grantee Log');
			}
			else
			{
				// Get grantee logs list for store into pdf.
				$amLogsResult = Doctrine::getTable('IntermentBookingLogs')->getBookingLogsForPDF($ssSearchCemId,$ssSearchUserId, $ssSearchOperationDate);
				$ssPDFHeading = __('Booking/Interment Log');
			}
			//echo $ssPDFHeading."<pre>";print_R($amLogsResult);exit;
			if(count($amLogsResult) > 0)
			{
				// pdf object
				$oPDF = new sfTCPDF();
				
				// set document information
				$oPDF->SetCreator(PDF_CREATOR);
				$oPDF->SetAuthor('Cemetery');
				$oPDF->SetTitle($ssPDFHeading);
				$oPDF->SetSubject($ssPDFHeading);
				$oPDF->SetKeywords('Grantee, Grave','Booking');
				
				// set default header data
				$oPDF->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 001', PDF_HEADER_STRING);
				
				// set header and footer fonts
				$oPDF->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
				$oPDF->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
				
				// set default monospaced font
				$oPDF->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
				
				//set margins
				$oPDF->SetMargins(0, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
				$oPDF->SetHeaderMargin(PDF_MARGIN_HEADER);
				$oPDF->SetFooterMargin(PDF_MARGIN_FOOTER);
				
				//set auto page breaks
				$oPDF->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
				
				// Add a page
				// This method has several options, check the source code documentation for more information.
				$oPDF->AddPage();
				
				$oPDF->writeHTMLCell($w=0, $h=0, $x='0', $y='10', '', 0, 1, 0, true, '', true);				
				$oPDF->SetFont('helvetica', '', 10, '', true);
				
				$ssPartial = ($ssLogType == 'bookinglog') ? 'pdf_for_booking_log' : 'pdf_for_log';
				$oPDF->setX(0);
				// Set some content to print
				$ssHTML = get_partial('gravelog/'.$ssPartial,array('ssPDFHeading'			=> $ssPDFHeading,
																	'ssLogType'				=> $ssLogType,
																	'ssUsername'			=> $amLogsResult[0]['username'],
																	'ssCemetery' 			=> $amLogsResult[0]['cem_name'],
																	'ssSearchOperationDate' => $ssSearchOperationDate,
																	'ssSearchUserId'		=> $ssSearchUserId,
																	'amLogsResult' 	 	 	=> $amLogsResult
																 ));
				
				$file_name = $ssPDFHeading.'.pdf';
				// Print text using writeHTML()
				$oPDF->writeHTML($ssHTML);
				
				// Close and output PDF document
				// This method has several options, check the source code documentation for more information.
				$oPDF->Output($file_name, 'D');
				
				// Stop symfony process
				throw new sfStopException();
			}
		}
		exit;
	}
	//-----------------------
	// Custom Ajax Actions
	//------------------------
	/**
    * Executes getCementryListAsPerCountry action
    *
    * @access public
    * @param sfRequest $request A request object
    */
    public function executeGetCustomCementryListAsPerCountry(sfWebRequest $request)
    {	
		$snIdCountry = $request->getParameter('id','');	
		$asCementery = Doctrine::getTable('CemCemetery')->getAllCemeteries($snIdCountry);

		return $this->renderPartial('getCustomCementeryList', array('asCementryList' => $asCementery));
	}
	/**
    * Executes getStaffListAsPerCemetery action
    *
    * @access public
    * @param sfRequest $request A request object
    */
    public function executeGetStaffListAsPerCemetery(sfWebRequest $request)
    {	
		$snCemeteryId = $request->getParameter('cemetery_id','');
		$ssLogType = $request->getParameter('logtype','');
		$asCemStaffList = Doctrine::getTable('sfGuardUser')->getCemeteryStaffList($snCemeteryId,$ssLogType);
		return $this->renderPartial('getCemeteryStaffList', array('asCemStaffList' => $asCemStaffList));
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
        $oForm->setWidgets(array());

        $oForm->setLabels(
            array(
                'name'              => __('Name'),
                'is_enabled'       => __('Enabled')
                
            )
        );

        $oForm->setValidators(
            array(
                'name'              => array(
                                            'required'        => __('Name required'),
                                            'invalid_unique'  => __('Name already exists'),
                                        ),
            )
        );
    }
}
