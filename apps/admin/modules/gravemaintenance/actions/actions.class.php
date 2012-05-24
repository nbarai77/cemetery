<?php
/**
 * Grave actions.
 *
 * @package    Cemetery
 * @subpackage Grave Maintenance
 * @author     Prakash Panchal
 * @author      
 *
 */
sfProjectConfiguration::getActive()->loadHelpers(array('I18N'));
class gravemaintenanceActions extends sfActions
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
        $this->ssFormName = 'frm_list_grave';
        $omRequest        = sfContext::getInstance()->getRequest();

        // Set default values
        $this->amExtraParameters = array();
        $this->amExtraParameters['snPaging']        = $this->snPaging       = $omRequest->getParameter('paging',sfConfig::get('app_default_paging_records'));
        $this->amExtraParameters['snPage']          = $this->snPage         = $omRequest->getParameter('page', sfConfig::get('app_default_page', 1));
        $this->amExtraParameters['ssSearchGraveNumber']   	= $this->ssSearchName  	= trim($omRequest->getParameter('searchGraveNumber',''));
        $this->amExtraParameters['ssSearchIsEnabled']   	= $this->ssSearchIsEnabled  	= trim($omRequest->getParameter('searchIsEnabled',''));
        $this->amExtraParameters['ssSortBy']        = $this->ssSortBy       = $omRequest->getParameter('sortby','renewal_date');
        $this->amExtraParameters['ssSortMode']      = $this->ssSortMode     = $omRequest->getParameter('sortmode','asc');

        $this->ssSortQuerystr = $this->ssQuerystr = 'page='.$this->snPage.'&paging='.$this->snPaging;

        if($this->getRequestParameter('searchGraveNumber') != '' )        // Search parameters
        {
            $this->ssQuerystr    .= '&searchGraveNumber='.$this->getRequestParameter('searchGraveNumber');
            $this->ssSortQuerystr.= '&searchGraveNumber='.$this->getRequestParameter('searchGraveNumber');
        }

        if($this->getRequestParameter('searchIsEnabled') != '' )        // Search parameters
        {
            $this->ssQuerystr    .= '&searchIsEnabled='.$this->getRequestParameter('searchIsEnabled');
            $this->ssSortQuerystr.= '&searchIsEnabled='.$this->getRequestParameter('searchIsEnabled');
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
								'grave_number' => array(
												'caption'	=> __('Grave Number'),
												'id'		=> 'GraveNumber',
												'type'		=> 'text',
											),
								'is_enabled' => array(
												'caption' 	=> __('Enabled'),
												'id'		=> 'IsEnabled',
												'type' 		=> 'select',
												'options'	=> array(
																'' => __('All'),
																'1' => __('Active'),
																'0' => __('InActive'),
																)															
											)
							);

        $omCommon = new common();

        if($request->getParameter('admin_act') == "delete" && $request->getParameter('id'))            
        {
            $omCommon->DeleteRecordsComposite('ArGraveMaintenance', $request->getParameter('id'),'id');
            $this->getUser()->setFlash('snSuccessMsgKey', 3);      
        }

        // Get cms page list for listing.
        $oArGraveMaintenancePageListQuery = Doctrine::getTable('ArGraveMaintenance')->getGraveMaintenanceList($this->amExtraParameters, $this->amSearch);

        // Set pager and get results
        $oPager               = new sfMyPager();
        $this->oArGraveMaintenanceList  = $oPager->getResults('ArGraveMaintenance', $this->snPaging,$oArGraveMaintenancePageListQuery,$this->snPage);
        $this->amArGraveMaintenanceList = $this->oArGraveMaintenanceList->getResults(Doctrine::HYDRATE_ARRAY);

        unset($oPager);

        // Total number of records        
        $this->snPageTotalArGraveMaintenancePages = $this->oArGraveMaintenanceList->getNbResults();

        if($request->getParameter('request_type') == 'ajax_request')
            $this->setTemplate('listGraveMaintenanceUpdate');
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
		//exec('rm -fR '.sfConfig::get('sf_upload_dir').'/'.sfConfig::get('app_graveimages_dir'));exit;
        
		$snIdGraveMaintenance = $oRequest->getParameter('id', '');
        $ssSuccessKey   = 4; // Success message key for add

        $this->snCementeryId = $oRequest->getParameter('gravemaintenance_cem_cemetery_id', '');
        $this->snAreaId = $oRequest->getParameter('gravemaintenance_ar_area_id', '');
        $this->snSectionId = $oRequest->getParameter('gravemaintenance_ar_section_id', '');
        $this->snRowId = $oRequest->getParameter('gravemaintenance_ar_row_id', '');
        $this->snPlotId = $oRequest->getParameter('gravemaintenance_ar_plot_id', '');
        $this->snGraveId = $oRequest->getParameter('gravemaintenance_ar_grave_id', '');
		
		$this->asCementery = $this->asAreaList = $this->asSectionList = $this->asRowList = $this->asPlotList = $this->asGraveList = array();
		
        if($snIdGraveMaintenance)
        {
            $this->forward404Unless($oGraveMaintenance = Doctrine::getTable('ArGraveMaintenance')->find($snIdGraveMaintenance));
            $this->oArGraveMaintenanceForm = new ArGraveMaintenanceForm($oGraveMaintenance);
            $ssSuccessKey = 2; // Success message key for edit
			
			// For get Cemetery List As per Country
			$this->asCementery = Doctrine::getTable('CemCemetery')->getAllCemeteries($oGraveMaintenance->getCountryId());
			
			// For get Area List as per Cemetery
			$this->asAreaList = Doctrine::getTable('ArArea')->getAreaListAsPerCemetery($oGraveMaintenance->getCountryId(),$oGraveMaintenance->getCemCemeteryId());

			// For get Section List as per area
			$this->asSectionList = Doctrine::getTable('ArSection')->getSectionListAsPerArea($oGraveMaintenance->getCountryId(),$oGraveMaintenance->getCemCemeteryId(),$oGraveMaintenance->getArAreaId());

			// For get Row List as per section
			$this->asRowList = Doctrine::getTable('ArRow')->getRowListAsPerSection($oGraveMaintenance->getCountryId(),$oGraveMaintenance->getCemCemeteryId(),$oGraveMaintenance->getArAreaId(),$oGraveMaintenance->getArSectionId());
			
			// For get Plot List as per Row
			$this->asPlotList = Doctrine::getTable('ArPlot')->getPlotListAsPerArea($oGraveMaintenance->getCountryId(),$oGraveMaintenance->getCemCemeteryId(),$oGraveMaintenance->getArAreaId(),$oGraveMaintenance->getArSectionId(),$oGraveMaintenance->getArRowId());
			
			// For get Grave List as per Plot
			$this->asGraveList = Doctrine::getTable('ArGrave')->getGraveListAsPerCriteria($oGraveMaintenance->getCountryId(),$oGraveMaintenance->getCemCemeteryId(),$oGraveMaintenance->getArAreaId(),$oGraveMaintenance->getArSectionId(),$oGraveMaintenance->getArRowId(),$oGraveMaintenance->getArPlotId(),'edit');

			$this->snCementeryId = ($this->snCementeryId != '') ? $this->snCementeryId : $oGraveMaintenance->getCemCemeteryId();
			$this->snAreaId = ($this->snAreaId != '') ? $this->snAreaId : $oGraveMaintenance->getArAreaId();
			$this->snSectionId = ($this->snSectionId != '') ? $this->snSectionId : $oGraveMaintenance->getArSectionId();
			$this->snRowId = ($this->snRowId != '') ? $this->snRowId : $oGraveMaintenance->getArRowId();
			$this->snPlotId = ($this->snPlotId != '') ? $this->snPlotId : $oGraveMaintenance->getArPlotId();
			$this->snGraveId = ($this->snGraveId != '') ? $this->snGraveId : $oGraveMaintenance->getArGraveId();
        }
        else
            $this->oArGraveMaintenanceForm = new ArGraveMaintenanceForm();

        $this->getConfigurationFields($this->oArGraveMaintenanceForm);

		$amGraveMaintenanceFormRequest = $oRequest->getParameter($this->oArGraveMaintenanceForm->getName());
		$this->snCementeryId = isset($amGraveMaintenanceFormRequest['cem_cemetery_id']) ? $amGraveMaintenanceFormRequest['cem_cemetery_id'] : $this->snCementeryId;

		if($amGraveMaintenanceFormRequest['country_id'] != '')
			$this->asCementery = Doctrine::getTable('CemCemetery')->getAllCemeteries($amGraveMaintenanceFormRequest['country_id']);
		if($this->snCementeryId != '' && $amGraveMaintenanceFormRequest['country_id'] != '')
			$this->asAreaList = Doctrine::getTable('ArArea')->getAreaListAsPerCemetery($amGraveMaintenanceFormRequest['country_id'], $this->snCementeryId);
		if($amGraveMaintenanceFormRequest['country_id'] != '' && $this->snCementeryId != '')
			$this->asSectionList = Doctrine::getTable('ArSection')->getSectionListAsPerArea($amGraveMaintenanceFormRequest['country_id'], $this->snCementeryId, $this->snAreaId);
		if($amGraveMaintenanceFormRequest['country_id'] != '' && $this->snCementeryId != '')
			$this->asRowList = Doctrine::getTable('ArRow')->getRowListAsPerSection($amGraveMaintenanceFormRequest['country_id'], $this->snCementeryId, $this->snAreaId, $this->snSectionId);
		if($amGraveMaintenanceFormRequest['country_id'] != '' && $this->snCementeryId != '')
			$this->asPlotList = Doctrine::getTable('ArPlot')->getPlotListAsPerArea($amGraveMaintenanceFormRequest['country_id'],$this->snCementeryId,$this->snAreaId,$this->snSectionId,$this->snRowId);
		if($amGraveMaintenanceFormRequest['country_id'] != '' && $this->snCementeryId != '')
			$this->asGraveList = Doctrine::getTable('ArGrave')->getGraveListAsPerCriteria($amGraveMaintenanceFormRequest['country_id'],$this->snCementeryId,$this->snAreaId,$this->snSectionId,$this->snRowId,$this->snPlotId,'true');

        if($oRequest->isMethod('post'))
        {
			if($amGraveMaintenanceFormRequest['onsite_work_date'] != '') 
			{
				list($snDay,$snMonth,$snYear) = explode('-',$amGraveMaintenanceFormRequest['onsite_work_date']);
				$amGraveMaintenanceFormRequest['onsite_work_date'] = $snYear.'-'.$snMonth.'-'.$snDay;
			}
			if($amGraveMaintenanceFormRequest['date_paid'] != '') 
			{
				list($snDay,$snMonth,$snYear) = explode('-',$amGraveMaintenanceFormRequest['date_paid']);
				$amGraveMaintenanceFormRequest['date_paid'] = $snYear.'-'.$snMonth.'-'.$snDay;
			}
			if($amGraveMaintenanceFormRequest['renewal_date'] != '')
			{
				list($snDay,$snMonth,$snYear) = explode('-',$amGraveMaintenanceFormRequest['renewal_date']);
				$amGraveMaintenanceFormRequest['renewal_date'] = $snYear.'-'.$snMonth.'-'.$snDay;
			}

            $this->oArGraveMaintenanceForm->bind($amGraveMaintenanceFormRequest);
			
			$bSelectCemetery = $bSelectGrave = false;
			if($this->getUser()->isSuperAdmin())
			{
				if($oRequest->getParameter('gravemaintenance_cem_cemetery_id') != '')
					$bSelectCemetery = true;
			}
			else
				$bSelectCemetery = true;

            if($this->oArGraveMaintenanceForm->isValid() && $bSelectCemetery && $oRequest->getParameter('gravemaintenance_ar_grave_id') != '')
            {
				$snIdGrave = $this->oArGraveMaintenanceForm->save()->getId();

                $this->getUser()->setFlash('snSuccessMsgKey', $ssSuccessKey);   //Set messages for add and update records
                
				if($oRequest->getParameter('back') == true) {
					$this->redirect('annualsearch/report?back=true');
				}else {                
					$this->redirect('gravemaintenance/index?'.$this->amExtraParameters['ssQuerystr']);
				}
            }
			else
			{
				if(!$bSelectCemetery)
					$this->getUser()->setFlash('ssErrorCemeter',__('Please select cemetery'));
				if($oRequest->getParameter('gravemaintenance_ar_grave_id') == '')
					$this->getUser()->setFlash('ssErrorGrave',__('Please select grave'));
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
	public function executeOnsiteGraves(sfWebRequest $oRequest)
    {
		$this->ssOnsiteWorkDate = $oRequest->getParameter('onsite_work_date','');
		$this->amOnSiteGraves = $amLatLongDirections = array();
		$this->smLatLongDirections = '';
		
		if($oRequest->isMethod('post'))
        {			
			$snDay = $snMonth = $snYear = '';

			if($this->ssOnsiteWorkDate != '')
				list($snDay,$snMonth,$snYear) = explode('-',trim($this->ssOnsiteWorkDate));
			$ssOnsiteWorkDate = $snYear.'-'.$snMonth.'-'.$snDay;

			if($this->ssOnsiteWorkDate != '')
			{
				$this->amOnSiteGraves = Doctrine::getTable('ArGraveMaintenance')->getOnsiteGravesLocation($ssOnsiteWorkDate);
				foreach($this->amOnSiteGraves as $snKey => $asValues)
					$amLatLongDirections[$asValues['id']] = implode(',', array( 'lat' => $asValues['latitude'], 'long' => $asValues['longitude']));
				$this->smLatLongDirections = implode('|',$amLatLongDirections);
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
					'renewal_term'		=> __('Select Row Term')
				 )
		);

        $oForm->setLabels(
            array(
				'onsite_work_date' 	=> __('Onsite Work Date'),
				'date_paid' 		=> __('Date Paid'),
				'amount_paid' 		=> __('Amount Paid'),
				'receipt' 			=> __('Receipt'),
				'renewal_term' 		=> __('Renewal Term'),
				'renewal_date' 		=> __('Renewal Date'),
				'interred_name' 	=> __('Interred Name'),
				'interred_surname' 	=> __('Interred Surname'),
				'title' 			=> __('Title'),
				'organization_name' => __('Organization Name'),
				'first_name'        => __('First Name'),
				'surname' 			=> __('Surname'),
				'address' 			=> __('Address'),
				'subrub' 			=> __('Subrub/Town'),
				'state' 			=> __('State'),
				'postal_code' 		=> __('Postal Code'),
				'user_country' 		=> __('User Country'),
				'email' 			=> __('Email'),
				'area_code' 		=> __('Area Code'),
				'notes' 			=> __('Operational Notes')
            )
        );

        $oForm->setValidators(
            array(
					'country_id'	=> array(
											'required'  => __('Please select country')
										),
					'interred_name'	=> array(
											'required'  => __('Please enter interred name')
										),
					'interred_surname'	=> array(
											'required'  => __('Please enter interred surname')
										),
					'renewal_term'		=> array(
											'required'  => __('Please select renewal term')
										),
	                'email'			=> array(
											'invalid'  => __('Please enter valid email')
										)
				)
        );
    }
}
