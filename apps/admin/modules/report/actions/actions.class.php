<?php

/**
 * report actions.
 *
 * @package    cemetery
 * @subpackage report
 * @author     Prakash Panchal
 * @version    SVN: $Id: actions.class.php,v 1.1.1.1 2012/03/24 12:17:50 nitin Exp $
 */
sfProjectConfiguration::getActive()->loadHelpers(array('I18N'));
class reportActions extends sfActions
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
        $this->ssFormName = 'frm_list_granteesearch';
        $omRequest        = sfContext::getInstance()->getRequest();

		$amGranteeFormRequest = $this->getRequestParameter('grantee');
		
		$this->amPostRequest = $omRequest->getParameter('reports');
		
        // Set default values
        $this->amExtraParameters = array();
        $this->amExtraParameters['snPaging']        = $this->snPaging       = $omRequest->getParameter('paging',sfConfig::get('app_default_paging_records'));
        $this->amExtraParameters['snPage']          = $this->snPage         = $omRequest->getParameter('page', sfConfig::get('app_default_page', 1));
        $this->amExtraParameters['ssSearchCountryId']   	= $this->ssSearchCountryId  	= trim($amGranteeFormRequest['country_id']);

        $this->amExtraParameters['ssSearchCemCemeteryId']   	= $this->ssSearchCemCemeteryId  	= trim($omRequest->getParameter('reports_cem_cemetery_id'));		
        $this->amExtraParameters['ssSearchArAreaId']   	= $this->ssSearchArAreaId  	= trim($omRequest->getParameter('reports_ar_area_id'));
        $this->amExtraParameters['ssSearchArSectionId']   	= $this->ssSearchArSectionId  	= trim($omRequest->getParameter('reports_ar_section_id'));
        $this->amExtraParameters['ssSearchArRowId']   	= $this->ssSearchArRowId  	= trim($omRequest->getParameter('reports_ar_row_id'));        
        $this->amExtraParameters['ssSearchArPlotId']   	= $this->ssSearchArPlotId  	= trim($omRequest->getParameter('reports_ar_plot_id'));        
        
        $this->amExtraParameters['ssSortBy']        = $this->ssSortBy       = $omRequest->getParameter('sortby','id');
        $this->amExtraParameters['ssSortMode']      = $this->ssSortMode     = $omRequest->getParameter('sortmode','desc');

        $this->ssSortQuerystr = $this->ssQuerystr = 'page='.$this->snPage.'&paging='.$this->snPaging;

        if($amGranteeFormRequest['country_id'] != '' )        // Search parameters
        {
            $this->ssQuerystr    .= '&searchCountryId='.$amGranteeFormRequest['country_id'];
            $this->ssSortQuerystr.= '&searchCountryId='.$amGranteeFormRequest['country_id'];
        }
		if($this->ssSearchCemCemeteryId != '' )        // Search parameters
        {
            $this->ssQuerystr    .= '&searchCemCemeteryId='.$this->ssSearchCemCemeteryId;
            $this->ssSortQuerystr.= '&searchCemCemeteryId='.$this->ssSearchCemCemeteryId;
        }
		if($this->ssSearchArAreaId != '' )        // Search parameters
        {
            $this->ssQuerystr    .= '&searchArAreaId='.$this->ssSearchArAreaId;
            $this->ssSortQuerystr.= '&searchArAreaId='.$this->ssSearchArAreaId;
        }
        if($this->ssSearchArSectionId != '' )        // Search parameters
        {
            $this->ssQuerystr    .= '&searchArSectionId='.$this->ssSearchArSectionId;
            $this->ssSortQuerystr.= '&searchArSectionId='.$this->ssSearchArSectionId;
        }
        if($this->ssSearchArRowId != '' )        // Search parameters
        {
            $this->ssQuerystr    .= '&searchArRowId='.$this->ssSearchArRowId;
            $this->ssSortQuerystr.= '&searchArRowId='.$this->ssSearchArRowId;
        }
        if($this->ssSearchArPlotId != '' )        // Search parameters
        {
            $this->ssQuerystr    .= '&searchArPlotId='.$this->ssSearchArPlotId;
            $this->ssSortQuerystr.= '&searchArPlotId='.$this->ssSearchArPlotId;
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
  		$arr_session = $request->getParameter('reports');

		if($request->isMethod('post'))
		{
			$temp_cem = '';
			if(isset($arr_session['cem_cemetery_id'])) 
				$temp_cem = $arr_session['cem_cemetery_id'];
		
			if($temp_cem == '') 
				$temp_cem = $request->getParameter('reports_cem_cemetery_id');		

			$this->getUser()->setAttribute('cn', $arr_session['country_id']);
			$this->getUser()->setAttribute('cm', $temp_cem);
			$this->getUser()->setAttribute('ar', ($request->getParameter('reports_ar_area_id') != '') ? $request->getParameter('reports_ar_area_id') : 'NULL');
			$this->getUser()->setAttribute('sc', ($request->getParameter('reports_ar_section_id') != '') ? $request->getParameter('reports_ar_section_id') : 'NULL');
			$this->getUser()->setAttribute('rw', ($request->getParameter('reports_ar_row_id') != '') ? $request->getParameter('reports_ar_row_id') : 'NULL');	
			$this->getUser()->setAttribute('pl', ($request->getParameter('reports_ar_plot_id') != '') ? $request->getParameter('reports_ar_plot_id') : 'NULL');
			
			$this->getUser()->setAttribute('from_date', $arr_session['from_date']);
			$this->getUser()->setAttribute('to_date', $arr_session['to_date']);
			
		}
		elseif($request->getParameter('back') != 'true') 
		{
			$this->getUser()->setAttribute('cn', '');
			$this->getUser()->setAttribute('cm', '');
			$this->getUser()->setAttribute('ar', '');
			$this->getUser()->setAttribute('sc', '');
			$this->getUser()->setAttribute('rw', '');	
			$this->getUser()->setAttribute('pl', '');
			$this->getUser()->setAttribute('from_date', '');
			$this->getUser()->setAttribute('to_date', '');
		}
		
		$this->snCountryId = (isset($arr_session['country_id']) && $arr_session['country_id'] != '') ? $arr_session['country_id'] : '';
		$this->snCountryId = ($this->snCountryId != '') ? $this->snCountryId : $this->getUser()->getAttribute('cn');
		
		$snCemeteryId = (isset($arr_session['cem_cemetery_id']) && $arr_session['cem_cemetery_id'] != '') ? $arr_session['cem_cemetery_id'] : '';			
		$this->snCemeteryId = (($snCemeteryId != '') ? $snCemeteryId : ($request->getParameter('reports_cem_cemetery_id') != '' ? $request->getParameter('reports_cem_cemetery_id') : ''));	
		$this->snCemeteryId = ($this->snCemeteryId != '') ? $this->snCemeteryId : $this->getUser()->getAttribute('cm');
			
		$this->snAreaId = $request->getParameter('reports_ar_area_id') != '' ? $request->getParameter('reports_ar_area_id') : '';
		$this->snAreaId = ($this->snAreaId != '') ? $this->snAreaId : $this->getUser()->getAttribute('ar');
		
		$this->snSectionId = $request->getParameter('reports_ar_section_id') != '' ? $request->getParameter('reports_ar_section_id') : '';
		$this->snSectionId = ($this->snSectionId != '') ? $this->snSectionId : $this->getUser()->getAttribute('sc');
		
		$this->snRowId = $request->getParameter('reports_ar_row_id') != '' ? $request->getParameter('reports_ar_row_id') : '';
		$this->snRowId = ($this->snRowId != '') ? $this->snRowId : $this->getUser()->getAttribute('rw');
		
		$this->snPlotId = $request->getParameter('reports_ar_plot_id') != '' ? $request->getParameter('reports_ar_plot_id') : '';
		$this->snPlotId = ($this->snPlotId != '') ? $this->snPlotId : $this->getUser()->getAttribute('pl');
		
		$this->ssFromDate = (isset($arr_session['from_date']) && $arr_session['from_date'] != '') ? $arr_session['from_date'] : '';
		$this->ssFromDate = ($this->ssFromDate != '') ? $this->ssFromDate : $this->getUser()->getAttribute('from_date');
		
		$this->ssToDate = (isset($arr_session['to_date']) && $arr_session['to_date'] != '') ? $arr_session['to_date'] : '';
		$this->ssToDate = ($this->ssToDate != '') ? $this->ssToDate : $this->getUser()->getAttribute('to_date');
		
		$ssFromDate = $ssToDate = '';
		if($this->ssFromDate != '')
		{
			list($snDay,$snMonth,$snYear) = explode('-',trim($this->ssFromDate));
			$ssFromDate = $snYear.'-'.$snMonth.'-'.$snDay;
		}	
		if($this->ssToDate != '')
		{
			list($snDay,$snMonth,$snYear) = explode('-',trim($this->ssToDate));
			$ssToDate = $snYear.'-'.$snMonth.'-'.$snDay;
		}
		$this->amFinalReport = $this->anRequestIds = array();
		$this->ssCemeteryName = $this->ssAreaName = $this->ssSectionName = $this->ssRowName = $this->ssPlotName = '';

		$this->anRequestIds = array('country_id'	=> $this->snCountryId,
		 							'cemetery_id'	=> $this->snCemeteryId,
		 							'area_id'		=> $this->snAreaId,
		 							'section_id'	=> $this->snSectionId,
		 							'row_id'		=> $this->snRowId,
		 							'plot_id'		=> $this->snPlotId,
									'from_date'		=> $ssFromDate,
									'to_date'		=> $ssToDate
									);
		// For get total of interment as per cemetery
		if(($this->snCountryId != '' && $this->snCemeteryId != '') || ($this->ssFromDate != '' && $this->ssToDate != ''))
		{
	        $this->amFinalReport['Cemetery'] = Doctrine::getTable('IntermentBooking')->getReports($this->snCountryId,$this->snCemeteryId,'','','','',$ssFromDate,$ssToDate);
			$oCemetery = Doctrine::getTable('CemCemetery')->find($this->snCemeteryId);
			if($oCemetery)
				$this->ssCemeteryName = $oCemetery->getName();
			
			$this->amFinalReport['Cemetery']['name'] = $this->ssCemeteryName;
		}

		// For get total of interment as per cemetery, row
		if(($this->snCountryId != '' && $this->snCemeteryId != '' && $this->snAreaId != '') || ($this->ssFromDate != '' && $this->ssToDate != ''))
		{
	        $this->amFinalReport['Area'] = Doctrine::getTable('IntermentBooking')->getReports($this->snCountryId,$this->snCemeteryId,$this->snAreaId,'','','',$ssFromDate,$ssToDate);
			$oArea = Doctrine::getTable('ArArea')->find($this->snAreaId);
			if($oArea)
				$this->ssAreaName = $oArea->getAreaName();
			
			$this->amFinalReport['Area']['name'] = $this->ssAreaName;
		}

		// For get total of interment as per cemetery, row, section
		if(($this->snCountryId != '' && $this->snCemeteryId != '' && $this->snSectionId != '') || ($this->ssFromDate != '' && $this->ssToDate != ''))
		{
	        $this->amFinalReport['Section'] = Doctrine::getTable('IntermentBooking')->getReports($this->snCountryId,$this->snCemeteryId,$this->snAreaId,$this->snSectionId,'','',$ssFromDate,$ssToDate);
			$oSection = Doctrine::getTable('ArSection')->find($this->snSectionId);
			if($oSection)
				$this->ssSectionName = $oSection->getSectionName();
			
			$this->amFinalReport['Section']['name'] = $this->ssSectionName;
		}

		// For get total of interment as per cemetery, row, section, row
		if(($this->snCountryId != '' && $this->snCemeteryId != '' && $this->snRowId != '') || ($this->ssFromDate != '' && $this->ssToDate != ''))
		{
	        $this->amFinalReport['Row'] = Doctrine::getTable('IntermentBooking')->getReports($this->snCountryId,$this->snCemeteryId,$this->snAreaId,$this->snSectionId,$this->snRowId,'',$ssFromDate,$ssToDate);
			$oRow = Doctrine::getTable('ArRow')->find($this->snRowId);
			if($oRow)
				$this->ssRowName = $oRow->getRowName();
				
			$this->amFinalReport['Row']['name'] = $this->ssRowName;
		}

		// For get total of interment as per cemetery, row, section, row, plot
		if(($this->snCountryId != '' && $this->snCemeteryId != '' && $this->snPlotId != '') || ($this->ssFromDate != '' && $this->ssToDate != ''))
		{
	        $this->amFinalReport['Plot'] = Doctrine::getTable('IntermentBooking')->getReports($this->snCountryId,$this->snCemeteryId,$this->snAreaId,$this->snSectionId,$this->snRowId,$this->snPlotId,$ssFromDate,$ssToDate);
			$oPlot = Doctrine::getTable('ArPlot')->find($this->snPlotId);
			if($oPlot)
				$this->ssPlotName = $oPlot->getPlotName();
			
			$this->amFinalReport['Plot']['name'] = $this->ssPlotName;
		}
    }

   /**
    * update action
    *
    * Update cms pages   
    * @access public
    * @param  object $oRequest A request object
    *     
    */
    public function executeReport(sfWebRequest $oRequest)
    {
	
		if($oRequest->getParameter('back') != 'true')
		{
			$this->getUser()->setAttribute('gfname', '');		
			$this->getUser()->setAttribute('gmname', '');		
			$this->getUser()->setAttribute('gsname', '');		
			$this->getUser()->setAttribute('gdob', '');		
			$this->getUser()->setAttribute('grn', '');		
			$this->getUser()->setAttribute('gdop', '');		
			$this->getUser()->setAttribute('gted', '');		
			$this->getUser()->setAttribute('gin', '');		
			$this->getUser()->setAttribute('gii', '');			
			
			$this->getUser()->setAttribute('cn', '');
			$this->getUser()->setAttribute('gn', '');
			$this->getUser()->setAttribute('cm', '');
			$this->getUser()->setAttribute('ar', '');
			$this->getUser()->setAttribute('sc', '');
			$this->getUser()->setAttribute('rw', '');	
			$this->getUser()->setAttribute('pl', '');
			$this->getUser()->setAttribute('from_date', '');
			$this->getUser()->setAttribute('to_date', '');
		}	
		
        $ssSuccessKey   = 4; // Success message key for add

        $this->snCementeryId = $oRequest->getParameter('reports_cem_cemetery_id', '');
        $this->snAreaId = $oRequest->getParameter('reports_ar_area_id', '');
        $this->snSectionId = $oRequest->getParameter('reports_ar_section_id', '');
        $this->snRowId = $oRequest->getParameter('reports_ar_row_id', '');
        $this->snPlotId = $oRequest->getParameter('reports_ar_plot_id', '');
		
		$this->asCementery = $this->asAreaList = $this->asSectionList = $this->asRowList = $this->asPlotList = $this->asGraveList = array();
        $this->oReportForm = new ReportForm();

        $this->getConfigurationFields($this->oReportForm);
		$amGraveFormRequest = $oRequest->getParameter($this->oReportForm->getName());

		if($amGraveFormRequest['country_id'] != '')
			$this->asCementery = Doctrine::getTable('CemCemetery')->getAllCemeteries($amGraveFormRequest['country_id']);
		if($this->snCementeryId != '' && $amGraveFormRequest['country_id'] != '')
			$this->asAreaList = Doctrine::getTable('ArArea')->getAreaListAsPerCemetery($amGraveFormRequest['country_id'], $this->snCementeryId);
		if($amGraveFormRequest['country_id'] != '' && $this->snCementeryId != '')
			$this->asSectionList = Doctrine::getTable('ArSection')->getSectionListAsPerArea($amGraveFormRequest['country_id'], $this->snCementeryId, $this->snAreaId);
		if($amGraveFormRequest['country_id'] != '' && $this->snCementeryId != '')
			$this->asRowList = Doctrine::getTable('ArRow')->getRowListAsPerSection($amGraveFormRequest['country_id'], $this->snCementeryId, $this->snAreaId, $this->snSectionId);
		if($amGraveFormRequest['country_id'] != '' && $this->snCementeryId != '')
			$this->asPlotList = Doctrine::getTable('ArPlot')->getPlotListAsPerArea($amGraveFormRequest['country_id'],$this->snCementeryId,$this->snAreaId,$this->snSectionId,$this->snRowId);

    }
	/**
    * Executes getCementryListAsPerCountry action
    *
    * @access public
    * @param sfRequest $request A request object
    */
    public function executeGetCementryListAsPerCountry(sfWebRequest $request)
    {	
		$snCementeryId = $request->getParameter('cnval','');	
		$snIdCountry = $request->getParameter('id','');	
		$asCementery = Doctrine::getTable('CemCemetery')->getAllCemeteries($snIdCountry);
		return $this->renderPartial('getCementeryList', array('asCementryList' => $asCementery, 'snCementeryId' => $snCementeryId));
	}
	/**
    * Executes getAreaListAsPerCemetery action
    *
    * @access public
    * @param sfRequest $request A request object
    */
    public function executeGetAreaListAsPerCemetery(sfWebRequest $request)
    {	
		$snAreaId = $request->getParameter('arval','');
		$snIdCountry = $request->getParameter('country_id','');
		$snCemeteryId = $request->getParameter('cemetery_id','');
		$asAreaList = Doctrine::getTable('ArArea')->getAreaListAsPerCemetery($snIdCountry, $snCemeteryId);
		return $this->renderPartial('getAreaList', array('asAreaList' => $asAreaList, 'snAreaId' => $snAreaId));
	}
	/**
    * Executes getSectionListAsPerArea action
    *
    * @access public
    * @param sfRequest $request A request object
    */
    public function executeGetSectionListAsPerArea(sfWebRequest $request)
    {	
		
		$snSectionId = $request->getParameter('secval','');
		$snIdCountry = $request->getParameter('country_id','');
		$snCemeteryId = $request->getParameter('cemetery_id','');
		$snAreaId = $request->getParameter('area_id','');
		$asSectionList = Doctrine::getTable('ArSection')->getSectionListAsPerArea($snIdCountry,$snCemeteryId,$snAreaId);

		return $this->renderPartial('getSectionList', array('asSectionList' => $asSectionList, 'snSectionId' => $snSectionId));
	}
	/**
    * Executes getRowListAsPerSection action
    *
    * @access public
    * @param sfRequest $request A request object
    */
    public function executeGetRowListAsPerSection(sfWebRequest $request)
    {	
		
		$snRowId = $request->getParameter('rwval','');
		$snIdCountry = $request->getParameter('country_id','');
		$snCemeteryId = $request->getParameter('cemetery_id','');
		$snAreaId = $request->getParameter('area_id','');
		$snSectionId = $request->getParameter('section_id','');
		$asRowList = Doctrine::getTable('ArRow')->getRowListAsPerSection($snIdCountry,$snCemeteryId,$snAreaId,$snSectionId);

		return $this->renderPartial('getRowList', array('asRowList' => $asRowList, 'snRowId' => $snRowId));
	}
	/**
    * Executes getPlotListAsPerRow action
    *
    * @access public
    * @param sfRequest $request A request object
    */
    public function executeGetPlotListAsPerRow(sfWebRequest $request)
    {	
		
		$snPlotId = $request->getParameter('plval','');
		$snIdCountry = $request->getParameter('country_id','');
		$snCemeteryId = $request->getParameter('cemetery_id','');
		$snAreaId = $request->getParameter('area_id','');
		$snSectionId = $request->getParameter('section_id','');
		$snRowId = $request->getParameter('row_id','');
		$asPlotList = Doctrine::getTable('ArPlot')->getPlotListAsPerArea($snIdCountry,$snCemeteryId,$snAreaId,$snSectionId,$snRowId);

		return $this->renderPartial('getPlotList', array('asPlotList' => $asPlotList, 'snPlotId' => $snPlotId));
	}

	/**
    * Executes getGraveListAsPerPlot action
    *
    * @access public
    * @param sfRequest $request A request object
    */
    public function executeGetGraveListAsPerPlot(sfWebRequest $request)
    {	
		$snGraveId = $request->getParameter('gnval','');
		$snIdCountry = $request->getParameter('country_id','');
		$snCemeteryId = $request->getParameter('cemetery_id','');
		$snAreaId = $request->getParameter('area_id','');
		$snSectionId = $request->getParameter('section_id','');
		$snRowId = $request->getParameter('row_id','');
		$snPlotId = $request->getParameter('plot_id','');
		
		$asGraveList = Doctrine::getTable('ArGrave')->getGraveListAsPerCriteria($snIdCountry,$snCemeteryId,$snAreaId,$snSectionId,$snRowId,$snPlotId,'true');

		return $this->renderPartial('getGraveList', array('asGraveList' => $asGraveList, 'snGraveId' => $snGraveId));
	}
	/**
    * Executes getIntermentDetails action
    *
    * @access public
    * @param sfRequest $request A request object
    */
    public function executeIntermentDetails(sfWebRequest $request)
    {
		//set search combobox field
        $this->amSearch = array();

        $omCommon = new common();

        if($request->getParameter('admin_act') == "delete" && $request->getParameter('id'))            
        {
            $omCommon->DeleteRecordsComposite('IntermentBooking', $request->getParameter('id'),'id');
            $this->getUser()->setFlash('snSuccessMsgKey', 3);      
        }

		$this->ssRequestIds = $request->getParameter('ssRequestIds');
		$this->ssSearchFor = $request->getParameter('ssSearchFor');

		//list($snCountryId,$snCemeteryId,$snAreaId,$snSectionId,$snRowId,$snPlotId,$ssFromIntDate,$ssToIntDate) = explode(',', base64_decode($request->getParameter('ssRequestIds')));
		$amDecodeRequest = explode(',', base64_decode($request->getParameter('ssRequestIds')));

		if($request->getParameter('ssSearchFor') == "cemetery")
			$snAreaId = $snSectionId = $snRowId = $snPlotId = '';
		elseif($request->getParameter('ssSearchFor') == "area")
			$snSectionId = $snRowId = $snPlotId = '';
		elseif($request->getParameter('ssSearchFor') == "section")
			$snRowId = $snPlotId = '';
		elseif($request->getParameter('ssSearchFor') == "row")
			$snPlotId = '';

		
        $oIntermentDetailsPageListQuery = Doctrine::getTable('IntermentBooking')->getIntermentDetailsAsPerReport($amDecodeRequest[0],$amDecodeRequest[1],$amDecodeRequest[2],$amDecodeRequest[3],$amDecodeRequest[4],$amDecodeRequest[5],$amDecodeRequest[6],$amDecodeRequest[7]);

		// Replace Doctrine Pager Count Query By Mannual Count Query.
		$ssCountQuery = Doctrine::getTable('IntermentBooking')->getIntermentDetailsAsPerReportCount($amDecodeRequest[0],$amDecodeRequest[1],$amDecodeRequest[2],$amDecodeRequest[3],$amDecodeRequest[4],$amDecodeRequest[5],$amDecodeRequest[6],$amDecodeRequest[7]);
		
        // Set pager and get results
        $oPager               = new sfMyPager();
        $this->oIntermentDetailsList  = $oPager->getResults('IntermentBooking', $this->snPaging,$oIntermentDetailsPageListQuery,$this->snPage,$ssCountQuery);
        $this->amIntermentDetailsList = $this->oIntermentDetailsList->getResults(Doctrine::HYDRATE_ARRAY);
        unset($oPager);

        // Total number of records
        $this->snPageTotalIntermentDetailsPages = $this->oIntermentDetailsList->getNbResults();

        if($request->getParameter('request_type') == 'ajax_request')
            $this->setTemplate('listIntermentDetailsUpdate');
	}
	/**
    * Executes getIntermentDetails action
    *
    * @access public
    * @param sfRequest $request A request object
    */
    public function executeOccupancy(sfWebRequest $oRequest)
    {
		//ini_set('memory_limit','712M');		// FOR LIVE.
		
		$this->snTotalRecords = 0;
		$this->asCementryList = Doctrine::getTable('CemCemetery')->getAllCemeteries();
		$this->snCementeryId = $oRequest->getParameter('report_cem_cemetery_id','');
		if(!$this->getUser()->isSuperAdmin())
		{
			$amResult = Doctrine::getTable('IntermentBooking')->getOccupanyReport();
	
			$asResults = array();
			$snTotalVacantGrave = 0;
			foreach($amResult as $snKey => $asValue)
			{
				$asResults[$snKey] = $asValue['tot_interments'];
				$snTotalVacantGrave = $asValue['tot_grave'];
			}
			$this->results = array_count_values($asResults);
			ksort($this->results);
			$this->snTotalVacantGrave = $snTotalVacantGrave - array_sum($this->results);		
			$this->snTotalRecords = count($this->results);
		}
		else
		{
			if($oRequest->isMethod('post'))
        	{
				$bSelectCemetery = false;
				if($this->snCementeryId != '' && $this->snCementeryId > 0)
					$bSelectCemetery = true;

				if($bSelectCemetery)
				{
					$amResult = Doctrine::getTable('IntermentBooking')->getOccupanyReport($this->snCementeryId);
		
					$asResults = array();
					$snTotalVacantGrave = 0;
					foreach($amResult as $snKey => $asValue)
					{
						$asResults[$snKey] = $asValue['tot_interments'];
						$snTotalVacantGrave = $asValue['tot_grave'];
					}
					$this->results = array_count_values($asResults);
					ksort($this->results);
					$this->snTotalVacantGrave = $snTotalVacantGrave - array_sum($this->results);		
					$this->snTotalRecords = count($this->results);
				}
				else
				{
					if(!$bSelectCemetery)
						$this->getUser()->setFlash('ssErrorCemeter',__('Please select cemetery'));
				}
			}
		}
	}

    /**
	 * Executes serviceReport action
	 *	
	 * @param sfRequest $request A request object
	 */
	public function executeServiceReport($oRequest)
	{
		$this->snCementeryId = $oRequest->getParameter('reports_cem_cemetery_id', '');
        $this->snAreaId = $oRequest->getParameter('reports_ar_area_id', '');
		
		$this->asCementery = $this->asAreaList = $this->amServiceReportResult = array();
        $this->oGravePlotReportForm = new ServiceReportForm();

        $this->getConfigurationFields($this->oGravePlotReportForm);
		
		$amGraveFormRequest = $oRequest->getParameter($this->oGravePlotReportForm->getName());
		$this->snCementeryId = (!$this->getUser()->isSuperAdmin()) ? $amGraveFormRequest['cem_cemetery_id'] : $this->snCementeryId;
		
		if($amGraveFormRequest['country_id'] != '')
			$this->asCementery = Doctrine::getTable('CemCemetery')->getAllCemeteries($amGraveFormRequest['country_id']);
		if($this->snCementeryId != '' && $amGraveFormRequest['country_id'] != '')
			$this->asAreaList = Doctrine::getTable('ArArea')->getAreaListAsPerCemetery($amGraveFormRequest['country_id'], $this->snCementeryId);

		if($oRequest->isMethod('post'))
       	{
			$this->snCountryId = (isset($amGraveFormRequest['country_id']) && $amGraveFormRequest['country_id'] != '') ? $amGraveFormRequest['country_id'] : '';
					
			$this->snCountryId  = ($this->snCountryId != '') ? $this->snCountryId : $oRequest->getParameter('reports_country_id', '');
			$this->snCemeteryId = ($this->snCementeryId != '') ? $this->snCementeryId : $oRequest->getParameter('reports_cem_cemetery_id', '');
			$this->snAreaId = $oRequest->getParameter('reports_ar_area_id') != '' ? $oRequest->getParameter('reports_ar_area_id') : '';
			
			$this->ssFromDate 	= (isset($amGraveFormRequest['from_date']) && $amGraveFormRequest['from_date'] != '') ? $amGraveFormRequest['from_date'] : '';
			$this->ssToDate		= (isset($amGraveFormRequest['to_date']) && $amGraveFormRequest['to_date'] != '') ? $amGraveFormRequest['to_date'] : '';

            // FOR TOTAL SERVICE REPORT
			$this->amServiceReportResult = Doctrine::getTable('IntermentBooking')->getServiceReport($this->snCountryId, $this->snCemeteryId);

			// FOR SERVICE REPORT AS PER BETWEEN FROM AND TO DATE
			if($this->ssFromDate != '' && $this->ssToDate != '')
			{
				$ssFormatedFromDate = date('Y-m-d', strtotime($this->ssFromDate));
				$ssFormatedToDate = date('Y-m-d', strtotime($this->ssToDate));
				$this->amServiceReportAsPerDateResult = Doctrine::getTable('IntermentBooking')->getServiceReport($this->snCountryId, $this->snCemeteryId, '', $ssFormatedFromDate, $ssFormatedToDate);
			}
			
			// FOR SERVICE REPORT AS PER AREA
			if($this->snAreaId != '')
			{
				$oServiceReportAsPerAreaQuery = Doctrine::getTable('IntermentBooking')->getServiceReport($this->snCountryId, $this->snCemeteryId, $this->snAreaId, '', '', true);
				$oPager               = new sfMyPager();
				
                $this->oSerReportAsPerAreaList  = $oPager->getResults('IntermentBooking', $this->snPaging, $oServiceReportAsPerAreaQuery, $this->snPage);
                $this->amSerReportAsPerAreaList = $this->oSerReportAsPerAreaList->getResults(Doctrine::HYDRATE_ARRAY);
                unset($oPager);
                
                // Total number of records
                $this->snPageTotalSerReportAsPerPages = $this->oSerReportAsPerAreaList->getNbResults();
			}
		}
		
		if($oRequest->getParameter('request_type') == 'ajax_request')
                $this->setTemplate('listSerReportPerAreaUpdate');    
	}
	
	/**
	 * Executes index action
	 *	
	 * @param sfRequest $request A request object
	 */
	public function executeGravePlotReport($oRequest)
	{
		$this->snCemeteryId = $oRequest->getParameter('reports_cem_cemetery_id', '');
        $this->snAreaId = $oRequest->getParameter('reports_ar_area_id', '');
		
		$this->asCementery = $this->asAreaList = $this->amGravePlotReportResult = $this->amGravePlotReportAsPerDateResult = $this->amGraveSectionsReportList = $this->amGraveAreaTotalReportResult = array();
		$this->ssFromDate = $this->ssToDate = $this->oGraveSectionsReportList = '';
		$this->snPageTotalGraveSectionsReportPages = 0;
		
        $this->oGravePlotReportForm = new GravePlotReportForm();
        $this->getConfigurationFields($this->oGravePlotReportForm);
		
		$amGraveFormRequest = $oRequest->getParameter($this->oGravePlotReportForm->getName());

		$this->snCountryId = (isset($amGraveFormRequest['country_id']) && $amGraveFormRequest['country_id'] != '') ? $amGraveFormRequest['country_id'] : '';					
		$this->snCountryId  = ($this->snCountryId != '') ? $this->snCountryId : $oRequest->getParameter('reports_country_id', '');
		
		$this->snCemeteryId = (!$this->getUser()->isSuperAdmin()) ? $amGraveFormRequest['cem_cemetery_id'] : $this->snCemeteryId;
				
		if($amGraveFormRequest['country_id'] != '')
			$this->asCementery = Doctrine::getTable('CemCemetery')->getAllCemeteries($amGraveFormRequest['country_id']);
		if($this->snCemeteryId != '' && $amGraveFormRequest['country_id'] != '')
			$this->asAreaList = Doctrine::getTable('ArArea')->getAreaListAsPerCemetery($amGraveFormRequest['country_id'], $this->snCemeteryId);

		if($oRequest->isMethod('post'))
       	{
			// FOR TOTAL GRAVE REPORT
            $this->amGravePlotReportResult = Doctrine::getTable('ArGrave')->getGravePlotReports($this->snCountryId, $this->snCemeteryId);
			//$this->amGravePlotReportResult = Doctrine::getTable('ArGrave')->getGravePlotReport($this->snCountryId, $this->snCemeteryId);
			
			// FOR GRAVE REPORT AS PER BETWEEN FROM AND TO UPDATE DATE INTO GRAVE
			$this->ssFromDate 	= (isset($amGraveFormRequest['from_date']) && $amGraveFormRequest['from_date'] != '') ? $amGraveFormRequest['from_date'] : '';			
			$this->ssToDate		= (isset($amGraveFormRequest['to_date']) && $amGraveFormRequest['to_date'] != '') ? $amGraveFormRequest['to_date'] : '';
			if($this->ssFromDate != '' && $this->ssToDate != '')
			{
				$ssFormatedFromDate = date('Y-m-d', strtotime($this->ssFromDate));
				$ssFormatedToDate = date('Y-m-d', strtotime($this->ssToDate));
				
                $this->amGravePlotReportAsPerDateResult = Doctrine::getTable('ArGrave')->getGravePlotReports($this->snCountryId, $this->snCemeteryId, '', $ssFormatedFromDate, $ssFormatedToDate);
				//$this->amGravePlotReportAsPerDateResult = Doctrine::getTable('ArGrave')->getGravePlotReport($this->snCountryId, $this->snCemeteryId, '', $ssFormatedFromDate, $ssFormatedToDate);
			}
			// FOR AREA WISE GRAVE/PLOT REPORT
			$this->snCountryId = (isset($amGraveFormRequest['country_id']) && $amGraveFormRequest['country_id'] != '') ? $amGraveFormRequest['country_id'] : '';
			$snCemeteryId = (isset($amGraveFormRequest['cem_cemetery_id']) && $amGraveFormRequest['cem_cemetery_id'] != '') ? $amGraveFormRequest['cem_cemetery_id'] : '';			
			$this->snCemeteryId = ($snCemeteryId != '') ? $snCemeteryId : $this->snCemeteryId;
			$this->snAreaId = $oRequest->getParameter('reports_ar_area_id') != '' ? $oRequest->getParameter('reports_ar_area_id') : '';

			if($this->snAreaId != '')
			{
				$this->snCountryId  = ($this->snCountryId != '') ? $this->snCountryId : $oRequest->getParameter('reports_country_id', '');			
				//$oGraveAreaReportPageListQuery = Doctrine::getTable('ArGrave')->getGravePlotReport($this->snCountryId, $this->snCemeteryId, $this->snAreaId,'','',true);
                $oGraveAreaReportPageListQuery = Doctrine::getTable('ArGrave')->getGravePlotReports($this->snCountryId, $this->snCemeteryId, $this->snAreaId,'','',true);
				// Set pager and get results
				$oPager               = new sfMyPager();
				$this->oGraveSectionsReportList  = $oPager->getResults('ArGrave', $this->snPaging, $oGraveAreaReportPageListQuery,$this->snPage);
				$this->amGraveSectionsReportList = $this->oGraveSectionsReportList->getResults(Doctrine::HYDRATE_ARRAY);
				unset($oPager);
				
				// Total number of records
				$this->snPageTotalGraveSectionsReportPages = $this->oGraveSectionsReportList->getNbResults();
				
				// FOR TOTAL OF GRAVE STATUS GRAVE AS PER AREA
				//$this->amGraveAreaTotalReportResult = Doctrine::getTable('ArGrave')->getGravePlotReport($this->snCountryId, $this->snCemeteryId, $this->snAreaId,'','',false,true);
                $this->amGraveAreaTotalReportResult = Doctrine::getTable('ArGrave')->getGravePlotReports($this->snCountryId, $this->snCemeteryId, $this->snAreaId,'','',false,true);
				
				if($oRequest->getParameter('request_type') == 'ajax_request')
					$this->setTemplate('listGraveReportsUpdate');

			}
		}
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
				'from_date'  		=> __('From Interment Date'),
				'to_date'  			=> __('To Interment Date')
            )
        );
    }
    
    
    /**
	 * Executes printServiceReport action
	 *	
	 * @param sfRequest $request A request object
	 */
	public function executePrintServiceReport($oRequest)
	{
	    $snCountryId   = $oRequest->getParameter('country_id', '');
		$snCementeryId = $oRequest->getParameter('cemetery_id', '');
        $this->ssFromDate 	 = $oRequest->getParameter('from_date', '');
        $this->ssToDate		 = $oRequest->getParameter('to_date', '');
        $ssReportType		 = $oRequest->getParameter('report_type', '');
        
        if($ssReportType == 'service'){
            // FOR TOTAL SERVICE REPORT
            $this->amServiceReportResult = Doctrine::getTable('IntermentBooking')->getServiceReport($snCountryId, $snCementeryId);

            // FOR SERVICE REPORT AS PER BETWEEN FROM AND TO DATE
            if($this->ssFromDate != '' && $this->ssToDate != '')
            {
                $ssFormatedFromDate = date('Y-m-d', strtotime($this->ssFromDate));
                $ssFormatedToDate = date('Y-m-d', strtotime($this->ssToDate));
                $this->amServiceReportAsPerDateResult = Doctrine::getTable('IntermentBooking')->getServiceReport($snCountryId, $snCementeryId, '', $ssFormatedFromDate, $ssFormatedToDate);
            }
        }
        
        if($ssReportType == 'grave'){
            // FOR TOTAL GRAVE REPORT
            $this->amGravePlotReportResult = Doctrine::getTable('ArGrave')->getGravePlotReports($snCountryId, $snCementeryId);
		    //$this->amGravePlotReportResult = Doctrine::getTable('ArGrave')->getGravePlotReport($snCountryId, $snCementeryId);
		
		    // FOR GRAVE REPORT AS PER BETWEEN FROM AND TO UPDATE DATE INTO GRAVE
		    if($this->ssFromDate != '' && $this->ssToDate != '')
		    {
			    $ssFormatedFromDate = date('Y-m-d', strtotime($this->ssFromDate));
			    $ssFormatedToDate = date('Y-m-d', strtotime($this->ssToDate));
                $this->amGravePlotReportAsPerDateResult = Doctrine::getTable('ArGrave')->getGravePlotReports($snCountryId, $snCementeryId, '', $ssFormatedFromDate, $ssFormatedToDate);
			    //$this->amGravePlotReportAsPerDateResult = Doctrine::getTable('ArGrave')->getGravePlotReport($snCountryId, $snCementeryId, '', $ssFormatedFromDate, $ssFormatedToDate);
		    }
        }
        
		// pdf object
		$oPDF = new sfTCPDF();
		
		// set document information
		$oPDF->SetCreator(PDF_CREATOR);
		$oPDF->SetAuthor('Cemetery');
		$oPDF->SetTitle('Cemetery Service Report');
		$oPDF->SetSubject('Cemetery Service Report');
		$oPDF->SetKeywords('Cemetery, Report');
		
		// set default header data
		$oPDF->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 001', PDF_HEADER_STRING);
		
		// set header and footer fonts
		$oPDF->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$oPDF->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
		
		// set default monospaced font
		$oPDF->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
		
		//set margins
		$oPDF->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
		$oPDF->SetHeaderMargin(PDF_MARGIN_HEADER);
		//$oPDF->SetFooterMargin(PDF_MARGIN_FOOTER);
		
		//set auto page breaks
		$oPDF->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
		
		// Add a page
		// This method has several options, check the source code documentation for more information.
		$oPDF->AddPage();			
		
		// Set some content to print		
        $ssHTML = '';
        $ssHTML .= ($ssReportType == 'service') ? $this->getPartial('report/printServiceReport') : $this->getPartial('report/printGravePlotReport');
        
		$ssFileName = 'CemeteryReport.pdf';
		// Print text using writeHTML()
		$oPDF->writeHTML($ssHTML);
		
		// Close and output PDF document
		// This method has several options, check the source code documentation for more information.
		$oPDF->Output($ssFileName, 'I');
		
		// Stop symfony process
		throw new sfStopException();
		
		return sfView::NONE;
	}
}
