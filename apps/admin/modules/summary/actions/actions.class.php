<?php
/**
 * Service Booking actions.
 *
 * @package    Cemetery
 * @subpackage Service Booking
 * @author     Prakash Panchal
 * @author      
 *
 */
sfProjectConfiguration::getActive()->loadHelpers(array('I18N','Url'));
class summaryActions extends sfActions
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

        $this->ssFormName = 'frm_list_today_summary';
        $omRequest        = sfContext::getInstance()->getRequest();

        // Set default values
        $this->amExtraParameters = array();
        $this->amExtraParameters['snPaging']        = $this->snPaging       = $omRequest->getParameter('paging', sfConfig::get('app_default_paging_records'));
        $this->amExtraParameters['snPage']          = $this->snPage         = $omRequest->getParameter('page', sfConfig::get('app_default_page', 1));
        $this->amExtraParameters['ssSortBy']        = $this->ssSortBy       = $omRequest->getParameter('sortby','id');
        $this->amExtraParameters['ssSortMode']      = $this->ssSortMode     = $omRequest->getParameter('sortmode','desc');

        $this->ssSortQuerystr = $this->ssQuerystr = 'page='.$this->snPage.'&paging='.$this->snPaging;

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
    public function executeIndex(sfWebRequest $oRequest)
    {
        //set search combobox field
        $this->amSearch = array();

        $omCommon = new common();

		$this->oSummaryForm = new SummaryForm();
		$this->getConfigurationFields($this->oSummaryForm);
		
		$this->oBurialSummaryList = $this->oAshesSummaryList = $this->oExhumationSummaryList = $this->oChapelSummaryList = $this->oRoomSummaryList = $this->ssServiceDate = '';
		$this->snPageTotalBurialRecords = $this->snPageTotalExhumationRecords = $this->snPageTotalAshesRecords = $this->snPageTotalChapelRecords = $this->snPageTotalRoomRecords = 0;
		$this->amBurialSummaryList = $this->amAshesSummaryList = $this->amExhumationSummaryList = $this->amChapelSummaryList = $this->amRoomSummaryList = array();
		$this->snServiceType     = $oRequest->getParameter('service_type','');
		
		$amSummaryRequestParameter = $oRequest->getParameter($this->oSummaryForm->getName());
		
		$bAjaxRequest = ($oRequest->isXmlHttpRequest()) ? true : false;
		
		if($oRequest->isMethod('post'))
			$this->ssServiceDate = (isset($amSummaryRequestParameter['service_date'])) ? $amSummaryRequestParameter['service_date'] : $oRequest->getParameter('service_date');
		else
		{
			$this->ssServiceDate = date('d-m-Y');
			$amSummaryRequestParameter['service_date'] = $this->ssServiceDate;
		}
        
		$snDay = $snMonth = $snYear = '';
		if($this->ssServiceDate != '')
			list($snDay,$snMonth,$snYear) = explode('-',trim($this->ssServiceDate));

		$ssServiceDateFormated = $snYear.'-'.$snMonth.'-'.$snDay;			

		if($this->ssServiceDate != '')
		{
			$this->oSummaryForm->bind($amSummaryRequestParameter);

			// Set pager and get results
			$oPager = new sfMyPager();

			// --------------------------- For Burials Summary -------------------------------
			if($oRequest->getParameter('request_type') == 'ajax_request_burials' || !$bAjaxRequest)
			{
				$oBurialSummaryPageListQuery = Doctrine::getTable('IntermentBooking')->getTodaySummary($ssServiceDateFormated, sfConfig::get('app_service_type_id_interment'));
				$this->oBurialSummaryList  = $oPager->getResults('IntermentBooking', $this->snPaging, $oBurialSummaryPageListQuery,$this->snPage);
				$this->amBurialSummaryList = $this->oBurialSummaryList->getResults(Doctrine::HYDRATE_ARRAY);
				
				$this->snPageTotalBurialRecords = $this->oBurialSummaryList->getNbResults();
			}
							
			// --------------------------- For Exhumation Summary -------------------------
			if($oRequest->getParameter('request_type') == 'ajax_request_exhumation' || !$bAjaxRequest)
			{
				$oExhumationSummaryPageListQuery = Doctrine::getTable('IntermentBooking')->getTodaySummary($ssServiceDateFormated, sfConfig::get('app_service_type_id_exhumation'));
				$this->oExhumationSummaryList  = $oPager->getResults('IntermentBooking', $this->snPaging,$oExhumationSummaryPageListQuery,$this->snPage);
				$this->amExhumationSummaryList = $this->oExhumationSummaryList->getResults(Doctrine::HYDRATE_ARRAY);

				$this->snPageTotalExhumationRecords = $this->oExhumationSummaryList->getNbResults();
			}
							
			// --------------------------- For Ashes Summary -------------------------------
			if($oRequest->getParameter('request_type') == 'ajax_request_ashes' || !$bAjaxRequest)
			{
				$oAshesSummaryPageListQuery = Doctrine::getTable('IntermentBooking')->getTodaySummary($ssServiceDateFormated, sfConfig::get('app_service_type_id_ashes'));
				$this->oAshesSummaryList  = $oPager->getResults('IntermentBooking', $this->snPaging,$oAshesSummaryPageListQuery,$this->snPage);
				$this->amAshesSummaryList = $this->oAshesSummaryList->getResults(Doctrine::HYDRATE_ARRAY);
				
				$this->snPageTotalAshesRecords = $this->oAshesSummaryList->getNbResults();
			}
			// --------------------------- For Chapel Summary -------------------------
			if($oRequest->getParameter('request_type') == 'ajax_request_chapel' || !$bAjaxRequest)
			{
				$amChapelBooking = Doctrine::getTable('FacilityBooking')->getFacilityBookingInfo($ssServiceDateFormated, 'chapel');
				
				$oChapelSummaryPageListQuery = Doctrine::getTable('IntermentBooking')->getTodaySummary($ssServiceDateFormated, '','chapel');
				$this->oChapelSummaryList  = $oPager->getResults('IntermentBooking', $this->snPaging,$oChapelSummaryPageListQuery,$this->snPage);
				$amTemp1 = $this->oChapelSummaryList->getResults(Doctrine::HYDRATE_ARRAY);
				
				$this->amChapelSummaryList = array_merge($amTemp1,$amChapelBooking);
				
				function fromChapelSort($amFrist, $amSecond)
				{
					if ($amFrist == $amSecond) 
						return 0;
					return ( strtotime(date('H:i:s',strtotime($amFrist['chapel_time_from']))) < strtotime(date('H:i:s', strtotime($amSecond['chapel_time_from']))) ) ? -1 : 1;
				}
				uasort($this->amChapelSummaryList, "fromChapelSort");

				$this->snPageTotalChapelRecords = count($this->amChapelSummaryList);	
			}

			// --------------------------- For Room Summary -------------------------
			if($oRequest->getParameter('request_type') == 'ajax_request_room' || !$bAjaxRequest)
			{
				$amRoomBooking = Doctrine::getTable('FacilityBooking')->getFacilityBookingInfo($ssServiceDateFormated, 'room');
				
				$oRoomSummaryPageListQuery = Doctrine::getTable('IntermentBooking')->getTodaySummary($ssServiceDateFormated, '','room');
				$this->oRoomSummaryList  = $oPager->getResults('IntermentBooking', $this->snPaging,$oRoomSummaryPageListQuery,$this->snPage);
				$amTemp1 = $this->oRoomSummaryList->getResults(Doctrine::HYDRATE_ARRAY);

				$this->amRoomSummaryList = array_merge($amTemp1,$amRoomBooking);
				function fromRoomSort($amFrist, $amSecond)
				{
					if ($amFrist == $amSecond) 
						return 0;
					return ( strtotime(date('H:i:s',strtotime($amFrist['chapel_time_from']))) < strtotime(date('H:i:s', strtotime($amSecond['chapel_time_from']))) ) ? -1 : 1;
				}
				uasort($this->amRoomSummaryList, "fromRoomSort");

				$this->snPageTotalRoomRecords = count($this->amRoomSummaryList);
			}
			unset($oPager);
		}
		
        if($oRequest->getParameter('request_type') == 'ajax_request_burials')
            $this->setTemplate('listBurialsUpdate');
		if($oRequest->getParameter('request_type') == 'ajax_request_chapel')
            $this->setTemplate('listChapelUpdate');
		if($oRequest->getParameter('request_type') == 'ajax_request_ashes')
            $this->setTemplate('listAshesUpdate');
		if($oRequest->getParameter('request_type') == 'ajax_request_room')
            $this->setTemplate('listRoomUpdate');
		if($oRequest->getParameter('request_type') == 'ajax_request_exhumation')
            $this->setTemplate('listExhumationUpdate');

						
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
				'service_date'       => __('Service Date')
            )
        );

        $oForm->setValidators(array());
    }
}
