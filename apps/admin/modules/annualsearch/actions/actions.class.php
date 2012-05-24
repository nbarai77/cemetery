<?php
/**
 * granteesearch actions.
 *
 * @package    Cemetery
 * @subpackage granteesearch
 * @author     Nitin Barai
 * @author
 *
 */
sfProjectConfiguration::getActive()->loadHelpers(array('I18N'));
class annualsearchActions extends sfActions
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
        $this->ssFormName = 'frm_list_annualsearch';
        $omRequest        = sfContext::getInstance()->getRequest();

		$amAnnualSearchRequest = $this->getRequestParameter('annualsearch');


        $snCountryId = (!isset($amAnnualSearchRequest['country_id'])) ? trim($omRequest->getParameter('country_id')) : $amAnnualSearchRequest['country_id'];
        $snCemeteryId = (!isset($amAnnualSearchRequest['cem_cemetery_id'])) ? trim($omRequest->getParameter('annualsearch_cem_cemetery_id')) : $amAnnualSearchRequest['cem_cemetery_id'];

        // Set default values
        $this->amExtraParameters = array();
        $this->amExtraParameters['snPaging']        = $this->snPaging       = $omRequest->getParameter('paging',sfConfig::get('app_default_paging_records'));
        $this->amExtraParameters['snPage']          = $this->snPage         = $omRequest->getParameter('page', sfConfig::get('app_default_page', 1));

        $this->amExtraParameters['ssSearchCountryId']   	= $this->ssSearchCountryId  	= ($snCountryId != '') ? $snCountryId : '0';
        $this->amExtraParameters['ssSearchCemCemeteryId']   	= $this->ssSearchCemCemeteryId  	= ($snCemeteryId != '') ? $snCemeteryId : '0';

		if($this->ssSearchCountryId != '0' && $this->ssSearchCemCemeteryId == '0'):
			$this->amExtraParameters['ssSearchCemCemeteryId'] = '';
		elseif($this->ssSearchCountryId == '0' && $this->ssSearchCemCemeteryId == '0'):
			$this->amExtraParameters['ssSearchCemCemeteryId'] = '';
			$this->amExtraParameters['ssSearchCountryId'] = '';
		endif;

        $this->amExtraParameters['ssSearchArAreaId']   	= $this->ssSearchArAreaId  	= ($omRequest->getParameter('annualsearch_ar_area_id') != '' ) ? $omRequest->getParameter('annualsearch_ar_area_id') : '';
        $this->amExtraParameters['ssSearchArSectionId']   	= $this->ssSearchArSectionId  	= ($omRequest->getParameter('annualsearch_ar_section_id') != '') ? $omRequest->getParameter('annualsearch_ar_section_id') : '';
        $this->amExtraParameters['ssSearchArRowId']   	= $this->ssSearchArRowId  	= ($omRequest->getParameter('annualsearch_ar_row_id') != '') ? $omRequest->getParameter('annualsearch_ar_row_id') : '';
        $this->amExtraParameters['ssSearchArPlotId']   	= $this->ssSearchArPlotId  	= ($omRequest->getParameter('annualsearch_ar_plot_id') != '') ? $omRequest->getParameter('annualsearch_ar_plot_id') : '';
        $this->amExtraParameters['ssSearchArGraveId']   	= $this->ssSearchArGraveId  	= trim($omRequest->getParameter('annualsearch_ar_grave_id'));


		// Set Advance search values
        $ssRenewalDate = (isset($amAnnualSearchRequest['renewal_date']) && $amAnnualSearchRequest['renewal_date'] != '') ? date('Y-m-d',strtotime($amAnnualSearchRequest['renewal_date'])) : (trim($omRequest->getParameter('annualsearch_renewal_date')) != '' ? trim($omRequest->getParameter('annualsearch_renewal_date')) : '') ;

        $ssFirstName = (isset($amAnnualSearchRequest['first_name']) && $amAnnualSearchRequest['first_name'] != '') ? trim($amAnnualSearchRequest['first_name']) : trim($omRequest->getParameter('annualsearch_first_name'));

        $ssSurname = (isset($amAnnualSearchRequest['surname']) && $amAnnualSearchRequest['surname'] != '') ? trim($amAnnualSearchRequest['surname']) : trim($omRequest->getParameter('annualsearch_surname'));

        $this->amExtraParameters['ssSearchFirstName']   	= $this->ssAnnualSearchFirstName  	= $ssFirstName;
        $this->amExtraParameters['ssSearchSurname']   		= $this->ssAnnualSearchSurname  	= $ssSurname;
        $this->amExtraParameters['ssSearchRenewalDate']   	= $this->ssAnnualSearchRenewalDate 	= $ssRenewalDate;

        $this->amExtraParameters['ssSortBy']        = $this->ssSortBy       = $omRequest->getParameter('sortby','id');
        $this->amExtraParameters['ssSortMode']      = $this->ssSortMode     = $omRequest->getParameter('sortmode','asc');

        $this->ssSortQuerystr = $this->ssQuerystr = 'page='.$this->snPage.'&paging='.$this->snPaging;

        if($amAnnualSearchRequest['country_id'] != '' )        // Search parameters
        {
            $this->ssQuerystr    .= '&searchCountryId='.$amAnnualSearchRequest['country_id'];
            $this->ssSortQuerystr.= '&searchCountryId='.$amAnnualSearchRequest['country_id'];
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
		if($this->ssSearchArGraveId != '' )        // Search parameters
        {
            $this->ssQuerystr    .= '&searchArGraveId='.$this->ssSearchArGraveId;
            $this->ssSortQuerystr.= '&searchArGraveId='.$this->ssSearchArGraveId;
        }

		// Advance search parameters
        if($this->ssAnnualSearchFirstName != '' )        // Search parameters
        {
            $this->ssQuerystr    .= '&searchFirstName='.$this->ssAnnualSearchFirstName;
            $this->ssSortQuerystr.= '&searchFirstName='.$this->ssAnnualSearchFirstName;
        }
		if($this->ssAnnualSearchSurname != '' )        // Search parameters
        {
            $this->ssQuerystr    .= '&searchSurname='.$this->ssAnnualSearchSurname;
            $this->ssSortQuerystr.= '&searchSurname='.$this->ssAnnualSearchSurname;
        }
		if($this->ssAnnualSearchRenewalDate != '' )        // Search parameters
        {
            $this->ssQuerystr    .= '&searchRenewalDate='.$this->ssAnnualSearchRenewalDate;
            $this->ssSortQuerystr.= '&searchRenewalDate='.$this->ssAnnualSearchRenewalDate;
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

		 if($request->isMethod('post'))
		 {
			$arr_session = $this->getRequestParameter('annualsearch');

			$this->getUser()->setAttribute('agfname', $arr_session['first_name']);
			$this->getUser()->setAttribute('asname', $arr_session['surname']);
			$this->getUser()->setAttribute('arendate', $arr_session['renewal_date']);

			$this->getUser()->setAttribute('cn', $arr_session['country_id']);
			$this->getUser()->setAttribute('gn', ($request->getParameter('annualsearch_ar_grave_id') != '') ? $request->getParameter('annualsearch_ar_grave_id') : '0');



			$temp_cem = '';
			if(isset($arr_session['cem_cemetery_id'])) {
				$temp_cem = $arr_session['cem_cemetery_id'];
			}

			if($temp_cem == '') {
				$temp_cem = $request->getParameter('annualsearch_cem_cemetery_id');
			}

			$this->getUser()->setAttribute('cm', $temp_cem);
			$this->getUser()->setAttribute('ar', ($request->getParameter('annualsearch_ar_area_id') != '') ? $request->getParameter('annualsearch_ar_area_id') : '');
			$this->getUser()->setAttribute('sc', ($request->getParameter('annualsearch_ar_section_id') != '') ? $request->getParameter('annualsearch_ar_section_id') : '');
			$this->getUser()->setAttribute('rw', ($request->getParameter('annualsearch_ar_row_id') != '') ? $request->getParameter('annualsearch_ar_row_id') : '');
			$this->getUser()->setAttribute('pl', ($request->getParameter('annualsearch_ar_plot_id') != '') ? $request->getParameter('annualsearch_ar_plot_id') : '');
		}else {

			$this->getUser()->setAttribute('agfname', '');
			$this->getUser()->setAttribute('asname', '');
			$this->getUser()->setAttribute('arendate', '');
			$this->getUser()->setAttribute('cn', '');
			$this->getUser()->setAttribute('gn', '');
			$this->getUser()->setAttribute('cm', '');
			$this->getUser()->setAttribute('ar', '');
			$this->getUser()->setAttribute('sc', '');
			$this->getUser()->setAttribute('rw', '');
			$this->getUser()->setAttribute('pl', '');
		}

        //set search combobox field
        $this->amSearch = array(
								'country_id' => array(
												'caption'	=> __('Country Name'),
												'id'		=> 'CountryId',
												'type'		=> 'integer',
											),
								'cem_cemetery_id' => array(
												'caption'	=> __('Cem Cemetery Id'),
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
								'first_name' => array(
												'caption'	=> __('FirstName'),
												'id'		=> 'FirstName',
												'type'		=> 'text',
											),
								'surname' => array(
												'caption'	=> __('Surname'),
												'id'		=> 'Surname',
												'type'		=> 'text',
											),
								'renewal_date' => array(
												'caption'	=> __('Renewal Date'),
												'id'		=> 'RenewalDate',
												'type'		=> 'text',
											)
							);

        $omCommon = new common();

        // Get cms page list for listing.
        $oAnnualSearchPageListQuery = Doctrine::getTable('ArGraveMaintenance')->getAnnualSearchList($this->amExtraParameters, $this->amSearch);

		// Replace Doctrine Pager Count Query By Mannual Count Query.
		$ssCountQuery = Doctrine::getTable('ArGraveMaintenance')->getAnnualSearchListCount($this->amExtraParameters, $this->amSearch);
				
        // Set pager and get results
        $oPager               = new sfMyPager();
        $this->oAnnualSearchList  = $oPager->getResults('ArGraveMaintenance', $this->snPaging,$oAnnualSearchPageListQuery,$this->snPage,$ssCountQuery);
        $this->amAnnualSearchList = $this->oAnnualSearchList->getResults(Doctrine::HYDRATE_ARRAY);

        unset($oPager);

        // Total number of records
        $this->snPageTotalAnnualSearchPages = $this->oAnnualSearchList->getNbResults();

        if($request->getParameter('request_type') == 'ajax_request')
            $this->setTemplate('listAnnualSearchUpdate');
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
			$this->getUser()->setAttribute('agfname', '');
			$this->getUser()->setAttribute('asname', '');
			$this->getUser()->setAttribute('arendate', '');

			$this->getUser()->setAttribute('cn', '');
			$this->getUser()->setAttribute('gn', '');
			$this->getUser()->setAttribute('cm', '');
			$this->getUser()->setAttribute('ar', '');
			$this->getUser()->setAttribute('sc', '');
			$this->getUser()->setAttribute('rw', '');
			$this->getUser()->setAttribute('pl', '');
		}

        $ssSuccessKey   = 4; // Success message key for add

        $this->snCementeryId = $oRequest->getParameter('annualsearch_cem_cemetery_id', '');
        $this->snAreaId = $oRequest->getParameter('annualsearch_ar_area_id', '');
        $this->snSectionId = $oRequest->getParameter('annualsearch_ar_section_id', '');
        $this->snRowId = $oRequest->getParameter('annualsearch_ar_row_id', '');
        $this->snPlotId = $oRequest->getParameter('annualsearch_ar_plot_id', '');
        $this->snGraveId = $oRequest->getParameter('annualsearch_ar_grave_id', '');

		$this->asCementery = $this->asAreaList = $this->asSectionList = $this->asRowList = $this->asPlotList = $this->asGraveList = array();
        $this->oAnnualSearchForm = new AnnualSearchForm();

        $this->getConfigurationFields($this->oAnnualSearchForm);
		$amAnnualSearchFormRequest = $oRequest->getParameter($this->oAnnualSearchForm->getName());

		if($amAnnualSearchFormRequest['country_id'] != '')
			$this->asCementery = Doctrine::getTable('CemCemetery')->getAllCemeteries($amAnnualSearchFormRequest['country_id']);
		if($this->snCementeryId != '' && $amAnnualSearchFormRequest['country_id'] != '')
			$this->asAreaList = Doctrine::getTable('ArArea')->getAreaListAsPerCemetery($amAnnualSearchFormRequest['country_id'], $this->snCementeryId);
		if($amAnnualSearchFormRequest['country_id'] != '' && $this->snCementeryId != '' && $this->snAreaId != '')
			$this->asSectionList = Doctrine::getTable('ArSection')->getSectionListAsPerArea($amAnnualSearchFormRequest['country_id'], $this->snCementeryId, $this->snAreaId);
		if($amAnnualSearchFormRequest['country_id'] != '' && $this->snCementeryId != '' && $this->snAreaId != '' && $this->snSectionId != '')
			$this->asRowList = Doctrine::getTable('ArRow')->getRowListAsPerSection($amAnnualSearchFormRequest['country_id'], $this->snCementeryId, $this->snAreaId, $this->snSectionId);
		if($amAnnualSearchFormRequest['country_id'] != '' && $this->snCementeryId != '' && $this->snAreaId != '' && $this->snSectionId != '' && $this->snRowId != '')
			$this->asPlotList = Doctrine::getTable('ArPlot')->getPlotListAsPerArea($amAnnualSearchFormRequest['country_id'],$this->snCementeryId,$this->snAreaId,$this->snSectionId,$this->snRowId);

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
					'grantee_identity_id' => __('Select Grantee Identity')
				 )
		);

		$oForm->setDefault('country_id', $this->getUser()->getAttribute('cn'));

		$oForm->setDefault('first_name', $this->getUser()->getAttribute('agfname'));
		$oForm->setDefault('surname', $this->getUser()->getAttribute('asname'));
		$oForm->setDefault('renewal_date', $this->getUser()->getAttribute('arendate'));


        $oForm->setLabels(
            array(
                'country_id'       	=> __('Select Country'),
                'cem_cemetery_id'  => __('Select Cemetery'),
				'grantee_first_name' 	=> __('Grantee First Name'),
				'grantee_surname'		=> __('Grantee Surname'),
				'grantee_middle_name'	=> __('Grantee Middle Name'),
            )
        );
    }
}
