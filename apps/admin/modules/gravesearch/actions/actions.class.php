<?php
/**
 * gravesearch actions.
 *
 * @package    Cemetery
 * @subpackage gravesearch
 * @author     Nitin Barai
 * @author
 *
 */
sfProjectConfiguration::getActive()->loadHelpers(array('I18N'));
class gravesearchActions extends sfActions
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
        $this->ssFormName = 'frm_list_gravesearch';
        $omRequest        = sfContext::getInstance()->getRequest();

		$arr_param = $this->getRequestParameter('grave');

		/*
		if($arr_param['grave_number'] == '')
			$grave_number = trim($omRequest->getParameter('grave_number'));
		elseif($omRequest->getParameter('searchGraveNumber') != '')
			$grave_number = $omRequest->getParameter('searchGraveNumber');
		else
			$grave_number = $arr_param['grave_number'];
		*/	
		
		if($arr_param['ar_grave_status_id'] == ''){
			$snIdGraveStatus = trim($omRequest->getParameter('ar_grave_status_id'));
		}
		elseif($omRequest->getParameter('searchArGraveStatusId') != ''){
			$snIdGraveStatus = $omRequest->getParameter('searchArGraveStatusId');
		}
		else{
			$snIdGraveStatus = $arr_param['ar_grave_status_id'];
		}
		if(isset($arr_param['country_id']) == ''){
			$country_id = trim($omRequest->getParameter('country_id'));
		}
		elseif($omRequest->getParameter('searchCountryId') != ''){
			$country_id = $omRequest->getParameter('searchCountryId');
		}
		else{
			$country_id = $arr_param['country_id'];
		}

		if(isset($arr_param['cem_cemetery_id']) == ''){
			$cem_cemetery_id = trim($omRequest->getParameter('grave_cem_cemetery_id'));
		}
		elseif($omRequest->getParameter('searchCemCemeteryId') != ''){
			$cem_cemetery_id = trim($omRequest->getParameter('searchCemCemeteryId'));
		}	
		else {
			$cem_cemetery_id = $arr_param['cem_cemetery_id'];
		}

        // Set default values
        $this->amExtraParameters = array();
        $this->amExtraParameters['snPaging']        = $this->snPaging       = $omRequest->getParameter('paging',sfConfig::get('app_default_paging_records'));
        $this->amExtraParameters['snPage']          = $this->snPage         = $omRequest->getParameter('page', sfConfig::get('app_default_page', 1));

        //$this->amExtraParameters['ssSearchGraveNumber']   	= $this->ssSearchName  	= trim($grave_number);
		
        $this->amExtraParameters['ssSearchCountryId']   	= $this->ssSearchCountryId = ($country_id != '') ? $country_id : '';
        $this->amExtraParameters['ssSearchCemCemeteryId'] = $this->ssSearchCemCemeteryId = ($cem_cemetery_id != '') ? $cem_cemetery_id : '';


        if($this->ssSearchCountryId != '' && $this->ssSearchCemCemeteryId == ''):
			$this->amExtraParameters['ssSearchCemCemeteryId'] = '';
		elseif($this->ssSearchCountryId == '' && $this->ssSearchCemCemeteryId == ''):
			$this->amExtraParameters['ssSearchCemCemeteryId'] = '';
			$this->amExtraParameters['ssSearchCountryId'] = '';
		endif;

        $this->amExtraParameters['ssSearchArAreaId']   	= $this->ssSearchArAreaId  	= ($omRequest->getParameter('grave_ar_area_id') != '' ) ? $omRequest->getParameter('grave_ar_area_id') : ( ($omRequest->getParameter('searchArAreaId') != '') ? $omRequest->getParameter('searchArAreaId') : '' );
		
        $this->amExtraParameters['ssSearchArSectionId']   	= $this->ssSearchArSectionId  	= ($omRequest->getParameter('grave_ar_section_id') != '') ? $omRequest->getParameter('grave_ar_section_id') : ( ($omRequest->getParameter('searchArSectionId') != '') ? $omRequest->getParameter('searchArSectionId') : '' );
		
        $this->amExtraParameters['ssSearchArRowId']   	= $this->ssSearchArRowId  	= ($omRequest->getParameter('grave_ar_row_id') != '') ? $omRequest->getParameter('grave_ar_row_id') : ( ($omRequest->getParameter('searchArRowId') != '') ? $omRequest->getParameter('searchArRowId') : '' );
		
        $this->amExtraParameters['ssSearchArPlotId']   	= $this->ssSearchArPlotId  	= ($omRequest->getParameter('grave_ar_plot_id') != '') ? $omRequest->getParameter('grave_ar_plot_id') : ( ($omRequest->getParameter('searchArPlotId') != '') ? $omRequest->getParameter('searchArPlotId') : '' );

		$this->amExtraParameters['ssSearchArGraveId']   	= $this->ssSearchArGraveId  	= trim($omRequest->getParameter('grave_ar_grave_id')); 

		$this->amExtraParameters['ssSearchArGraveStatusId']   	= $this->ssSearchArGraveStatusId = $snIdGraveStatus;
		
        $this->amExtraParameters['ssSortBy']        = $this->ssSortBy       = $omRequest->getParameter('sortby','id');
        $this->amExtraParameters['ssSortMode']      = $this->ssSortMode     = $omRequest->getParameter('sortmode','asc');

        $this->ssSortQuerystr = $this->ssQuerystr = 'page='.$this->snPage.'&paging='.$this->snPaging;

		/*
        if($grave_number != '' )        // Search parameters
        {
            $this->ssQuerystr    .= '&searchGraveNumber='.$grave_number;
            $this->ssSortQuerystr.= '&searchGraveNumber='.$grave_number;
        }
		*/
        if($country_id != '' )        // Search parameters
        {
            $this->ssQuerystr    .= '&searchCountryId='.$country_id;
            $this->ssSortQuerystr.= '&searchCountryId='.$country_id;
        }

        if($this->ssSearchCemCemeteryId != '' )        // Search parameters
        {
            $this->ssQuerystr    .= '&searchCemCemeteryId='.$this->ssSearchCemCemeteryId;
            $this->ssSortQuerystr.= '&searchCemCemeteryId='.$this->ssSearchCemCemeteryId;
        }
        if($this->ssSearchArAreaId != '')        // Search parameters
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
		if($this->ssSearchArGraveId != '' )        // Search parameters
        {
            $this->ssQuerystr    .= '&searchGraveNumber='.$this->ssSearchArGraveId;
            $this->ssSortQuerystr.= '&searchGraveNumber='.$this->ssSearchArGraveId;
        }
		if($this->snIdGraveStatus != '' )        // Search parameters
        {
            $this->ssQuerystr     .= '&searchArGraveStatusId='.$snIdGraveStatus;
            $this->ssSortQuerystr .= '&searchArGraveStatusId='.$snIdGraveStatus;
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
		 if($request->isMethod('post') && $request->getParameter('request_type') != 'ajax_request')
		 {
			$arr_session = $this->getRequestParameter('grave');
			$this->getUser()->setAttribute('cn', $arr_session['country_id']);
			$this->getUser()->setAttribute('gn', $request->getParameter('grave_ar_grave_id'));

			$temp_cem = '';
			if(isset($arr_session['cem_cemetery_id'])) {
				$temp_cem = $arr_session['cem_cemetery_id'];
			}

			if($temp_cem == '') {
				$temp_cem = $request->getParameter('grave_cem_cemetery_id');
			}

			$this->getUser()->setAttribute('cm', $temp_cem);
			$this->getUser()->setAttribute('ar', ($request->getParameter('grave_ar_area_id') != '') ? $request->getParameter('grave_ar_area_id') : '');
			$this->getUser()->setAttribute('sc', ($request->getParameter('grave_ar_section_id') != '') ? $request->getParameter('grave_ar_section_id') : '');
			$this->getUser()->setAttribute('rw', ($request->getParameter('grave_ar_row_id') != '') ? $request->getParameter('grave_ar_row_id') : '');
			$this->getUser()->setAttribute('pl', ($request->getParameter('grave_ar_plot_id') != '') ? $request->getParameter('grave_ar_plot_id') : '');

			$this->getUser()->setAttribute('gstatus', $arr_session['ar_grave_status_id']);
			
		}else 
		{
			if($request->getParameter('request_type') != 'ajax_request' && !$request->getParameter('back2search')) 
			{
				$this->getUser()->setAttribute('cn', '');
				$this->getUser()->setAttribute('gn', '');
				$this->getUser()->setAttribute('cm', '');
				$this->getUser()->setAttribute('ar', '');
				$this->getUser()->setAttribute('sc', '');
				$this->getUser()->setAttribute('rw', '');
				$this->getUser()->setAttribute('pl', '');
				$this->getUser()->setAttribute('gstatus', '');
			}
		}
		// For get Grave Status.
		
		$this->asStatusList = Doctrine::getTable('ArGraveStatus')->getGraveStatus();
        //set search combobox field
        $this->amSearch = array(
								/*'grave_number' => array(
												'caption'	=> __('Grave Number'),
												'id'		=> 'GraveNumber',
												'type'		=> 'text',
											),*/
								'is_enabled' => array(
												'caption' 	=> __('Enabled'),
												'id'		=> 'IsEnabled',
												'type' 		=> 'select',
												'options'	=> array(
												                    '' => __('All'),
																	'1' => __('Active'),
																	'0' => __('InActive'),
																)
											),
								'country_id' => array(
												'caption'	=> __('Country Name'),
												'id'		=> 'CountryId',
												'type'		=> 'integer',
											),

								'cem_cemetery_id' => array(
												'caption'	=> __('Cemetery Name'),
												'id'		=> 'CemCemeteryId',
												'type'		=> 'integer',
											),

								'ar_area_id' => array(
												'caption'	=> __('Area Name'),
												'id'		=> 'ArAreaId',
												'type'		=> 'integer',
											),
								'ar_section_id' => array(
												'caption'	=> __('Section Name'),
												'id'		=> 'ArSectionId',
												'type'		=> 'integer',
											),
								'ar_row_id' => array(
												'caption'	=> __('Row Name'),
												'id'		=> 'ArRowId',
												'type'		=> 'integer',
											),
								'ar_plot_id' => array(
												'caption'	=> __('Plot Name'),
												'id'		=> 'ArPlotId',
												'type'		=> 'integer',
											),
								'ar_grave_id' => array(
												'caption'	=> __('Grave Number'),
												'id'		=> 'ArGraveId',
												'type'		=> 'integer',																								
											),	
								'ar_grave_status_id' => array(
												'caption'	=> __('Status'),
												'id'		=> 'ArGraveStatusId',
												'type'		=> 'select',
												'options'	=> $this->asStatusList
											),
							);

        $omCommon = new common();

        if($request->getParameter('admin_act') == "delete" && $request->getParameter('id'))
        {
            $omCommon->DeleteRecordsComposite('ArPlot', $request->getParameter('id'),'id');
            $this->getUser()->setFlash('snSuccessMsgKey', 3);
        }

        // Get cms page list for listing.
        $oArGravePageListQuery = Doctrine::getTable('ArGrave')->getGraveListPerSearch($this->amExtraParameters, $this->amSearch, '', true);

//		echo $oArGravePageListQuery->getSqlQuery();exit;
		// Replace Doctrine Pager Count Query By Mannual Count Query.
		$ssCountQuery = Doctrine::getTable('ArGrave')->getGraveListPerSearchCount($this->amExtraParameters, $this->amSearch, '', true);

        // Set pager and get results
        $oPager               = new sfMyPager();
        $this->oArGraveList  = $oPager->getResults('ArGrave', $this->snPaging,$oArGravePageListQuery,$this->snPage,$ssCountQuery);
        $this->amArGraveList = $this->oArGraveList->getResults(Doctrine::HYDRATE_ARRAY);

        unset($oPager);

        // Total number of records
        $this->snPageTotalArGravePages = $this->oArGraveList->getNbResults();

        if($request->getParameter('request_type') == 'ajax_request')
            $this->setTemplate('listGraveUpdate');
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

		if($oRequest->getParameter('back') != 'true')
		{
			$this->getUser()->setAttribute('cn', '');
			$this->getUser()->setAttribute('gn', '');
			$this->getUser()->setAttribute('cm', '');
			$this->getUser()->setAttribute('ar', '');
			$this->getUser()->setAttribute('sc', '');
			$this->getUser()->setAttribute('rw', '');
			$this->getUser()->setAttribute('pl', '');
			$this->getUser()->setAttribute('gstatus', '');
		}

        $ssSuccessKey   = 4; // Success message key for add
		
        $this->snCementeryId = ($this->getUser()->getAttribute('cm') != '') ? $this->getUser()->getAttribute('cm') : $oRequest->getParameter('grave_cem_cemetery_id', '');

        $this->snAreaId = ($this->getUser()->getAttribute('ar') != '') ? $this->getUser()->getAttribute('ar') : $oRequest->getParameter('grave_ar_area_id', '');
        $this->snSectionId = ($this->getUser()->getAttribute('sc') != '') ? $this->getUser()->getAttribute('sc') : $oRequest->getParameter('grave_ar_section_id', '');
        $this->snRowId = ($this->getUser()->getAttribute('rw') != '') ? $this->getUser()->getAttribute('rw') : $oRequest->getParameter('grave_ar_row_id', '');
        $this->snPlotId = ($this->getUser()->getAttribute('pl') != '') ? $this->getUser()->getAttribute('pl') : $oRequest->getParameter('grave_ar_plot_id', '');
		$this->snGraveId = ($this->getUser()->getAttribute('gn') != '') ? $this->getUser()->getAttribute('gn') : $oRequest->getParameter('grave_ar_grave_id', '');

		$this->asCementery = $this->asAreaList = $this->asSectionList = $this->asRowList = $this->asPlotList = $this->asGraveList = array();

        $this->oArGraveForm = new GraveSearchForm();

        $this->getConfigurationFields($this->oArGraveForm);

		$amGraveFormRequest = $oRequest->getParameter($this->oArGraveForm->getName());

		$this->snCemeteryCountryId = ($this->getUser()->getAttribute('cn') != '') ? $this->getUser()->getAttribute('cn') : $amGraveFormRequest['country_id'];

		if($this->snCemeteryCountryId != '')
			$this->asCementery = Doctrine::getTable('CemCemetery')->getAllCemeteries($this->snCemeteryCountryId);
		if($this->snCementeryId != '' && $this->snCemeteryCountryId != '')
			$this->asAreaList = Doctrine::getTable('ArArea')->getAreaListAsPerCemetery($this->snCemeteryCountryId, $this->snCementeryId);
		if($this->snCemeteryCountryId != '' && $this->snCementeryId != '')
			$this->asSectionList = Doctrine::getTable('ArSection')->getSectionListAsPerArea($this->snCemeteryCountryId, $this->snCementeryId, $this->snAreaId);
		if($this->snCemeteryCountryId != '' && $this->snCementeryId != '' )
			$this->asRowList = Doctrine::getTable('ArRow')->getRowListAsPerSection($this->snCemeteryCountryId, $this->snCementeryId, $this->snAreaId, $this->snSectionId);
		if($this->snCemeteryCountryId != '' && $this->snCementeryId != '')
			$this->asPlotList = Doctrine::getTable('ArPlot')->getPlotListAsPerArea($this->snCemeteryCountryId,$this->snCementeryId,$this->snAreaId,$this->snSectionId,$this->snRowId);
		if($this->snCemeteryCountryId != '' && $this->snCementeryId != '')
			$this->asGraveList = Doctrine::getTable('ArGrave')->getGraveListAsPerCriteria($this->snCemeteryCountryId,$this->snCementeryId,$this->snAreaId,$this->snSectionId,$this->snRowId,$this->snPlotId);

		if($oRequest->isMethod('post'))
		{
			if($this->snGraveId != '')
			{
				$this->getUser()->setAttribute('cn', $amGraveFormRequest['country_id']);
				$this->getUser()->setAttribute('gn', $oRequest->getParameter('grave_ar_grave_id'));
	
				$snTempCemeteryId = '';
				if(isset($amGraveFormRequest['cem_cemetery_id']))
					$snTempCemeteryId = $amGraveFormRequest['cem_cemetery_id'];
	
				if($snTempCemeteryId == '')
					$snTempCemeteryId = $oRequest->getParameter('grave_cem_cemetery_id');
	
				$this->getUser()->setAttribute('cm', $snTempCemeteryId);
				$this->getUser()->setAttribute('ar', ($oRequest->getParameter('grave_ar_area_id') != '') ? $oRequest->getParameter('grave_ar_area_id') : '');
				$this->getUser()->setAttribute('sc', ($oRequest->getParameter('grave_ar_section_id') != '') ? $oRequest->getParameter('grave_ar_section_id') : '');
				$this->getUser()->setAttribute('rw', ($oRequest->getParameter('grave_ar_row_id') != '') ? $oRequest->getParameter('grave_ar_row_id') : '');
				$this->getUser()->setAttribute('pl', ($oRequest->getParameter('grave_ar_plot_id') != '') ? $oRequest->getParameter('grave_ar_plot_id') : '');
	
				$this->getUser()->setAttribute('gstatus', $amGraveFormRequest['ar_grave_status_id']);
				
				$this->redirect('servicebooking/displayInfo?gsearch=true&id_grave='.$this->snGraveId);
			}
			else
				$this->getUser()->setFlash('ssErrorGrave',__('Please select grave'));
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
		
		$asGraveList = Doctrine::getTable('ArGrave')->getGraveListAsPerCriteria($snIdCountry,$snCemeteryId,$snAreaId,$snSectionId,$snRowId,$snPlotId,'search');

		return $this->renderPartial('getGraveList', array('asGraveList' => $asGraveList, 'snGraveId' => $snGraveId));
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
					'cem_stonemason_id' => __('Select Stone Mason'),
					'cem_cemetery_id'  => __('Select Cemetery'),
					'unit_type_id' 		=> __('Select Unit Type'),
					'ar_grave_status_id' => __('Select Grave Status')
				 )
		);

		$oForm->setDefault('country_id', $this->getUser()->getAttribute('cn'));
		//$oForm->setDefault('grave_number', $this->getUser()->getAttribute('gn'));
		$oForm->setDefault('ar_grave_status_id', $this->getUser()->getAttribute('gstatus'));

        $oForm->setLabels(
            array(
                'country_id'       	=> __('Select Country'),
				'cem_stonemason_id' => __('Select Stone Mason'),
				'cem_cemetery_id'  => __('Select Cemetery'),
				'unit_type_id' 		=> __('Select Unit Type'),
                'grave_number'  	=> __('Grave Number'),
                'length'  	 		=> __('Length'),
                'width'				=> __('Width'),
                'height'  			=> __('Height'),
                'details'  			=> __('Grave Detail'),
				'ar_grave_status_id' => __('Grave Status'),
                'is_enabled'   		=> __('Enabled')

            )
        );

        $oForm->setValidators(
            array(
	                'grave_number'		=> array(
												'required'  => __('Please enter grave  name')
											),
	                'cem_stonemason_id'	=> array(
												'required'  => __('Please select stone mason')
											),
	                'unit_type_id'	=> array(
												'required'  => __('Please select unit type')
											),
    	            'cem_cemetery_id'        => array(
														'required'  => __('Please select cemetery')
												),
    	            'country_id'    => array(
												'required'  => __('Please select Country')
											)
				)
        );
    }
}
