<?php
/**
 * Work Order actions.
 *
 * @package    Cemetery
 * @subpackage Work Order
 * @author     Prakash Panchal
 * @author      
 *
 */
sfProjectConfiguration::getActive()->loadHelpers(array('I18N'));
class workorderActions extends sfActions
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
        $this->ssFormName = 'frm_list_workorder';
        $omRequest        = sfContext::getInstance()->getRequest();

        // Set default values
        $this->amExtraParameters = array();
        $this->amExtraParameters['snPaging']        = $this->snPaging       = $omRequest->getParameter('paging',sfConfig::get('app_default_paging_records'));
        $this->amExtraParameters['snPage']          = $this->snPage         = $omRequest->getParameter('page', sfConfig::get('app_default_page', 1));
        $this->amExtraParameters['ssSearchSurname']   	= $this->ssSearchSurname  	= trim($omRequest->getParameter('searchSurname',''));
        $this->amExtraParameters['ssSearchName']   	= $this->ssSearchName  	= trim($omRequest->getParameter('searchName',''));
        $this->amExtraParameters['ssSortBy']        = $this->ssSortBy       = $omRequest->getParameter('sortby','work_date');
        $this->amExtraParameters['ssSortMode']      = $this->ssSortMode     = $omRequest->getParameter('sortmode','asc');

        $this->ssSortQuerystr = $this->ssQuerystr = 'page='.$this->snPage.'&paging='.$this->snPaging;

        if($this->getRequestParameter('searchSurname') != '' )        // Search parameters
        {
            $this->ssQuerystr    .= '&searchSurname='.$this->getRequestParameter('searchSurname');
            $this->ssSortQuerystr.= '&searchSurname='.$this->getRequestParameter('searchSurname');
        }

        if($this->getRequestParameter('searchName') != '' )        // Search parameters
        {
            $this->ssQuerystr    .= '&searchName='.$this->getRequestParameter('searchName');
            $this->ssSortQuerystr.= '&searchName='.$this->getRequestParameter('searchName');
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
								'surname' => array(
												'caption'	=> __('Surname'),
												'id'		=> 'Surname',
												'type'		=> 'text',
											),
								'name' => array(
												'caption'	=> __('Name'),
												'id'		=> 'Name',
												'type'		=> 'text',
											)
							);

        $omCommon = new common();

        if($request->getParameter('admin_act') == "delete" && $request->getParameter('id'))            
        {
            $omCommon->DeleteRecordsComposite('Workflow', $request->getParameter('id'),'id');
            $this->getUser()->setFlash('snSuccessMsgKey', 3);      
        }

        // Get cms page list for listing.
        $oWorkorderPageListQuery = Doctrine::getTable('Workflow')->getWorkOrderList($this->amExtraParameters, $this->amSearch);

        // Set pager and get results
        $oPager               = new sfMyPager();
        $this->oWorkorderList  = $oPager->getResults('Workflow', $this->snPaging,$oWorkorderPageListQuery,$this->snPage);
        $this->amWorkorderList = $this->oWorkorderList->getResults(Doctrine::HYDRATE_ARRAY);

        unset($oPager);

        // Total number of records
        $this->snPageTotalWorkorderPages = $this->oWorkorderList->getNbResults();

        if($request->getParameter('request_type') == 'ajax_request')
            $this->setTemplate('listWorkorderUpdate');
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
		$snIdWorkorder = $oRequest->getParameter('id', '');
        $ssSuccessKey   = 4; // Success message key for add

        $this->snCementeryId = $oRequest->getParameter('workorder_cem_cemetery_id', '');
        $this->snAreaId = $oRequest->getParameter('workorder_ar_area_id', '');
        $this->snSectionId = $oRequest->getParameter('workorder_ar_section_id', '');
        $this->snRowId = $oRequest->getParameter('workorder_ar_row_id', '');
        $this->snPlotId = $oRequest->getParameter('workorder_ar_plot_id', '');
        $this->snGraveId = $oRequest->getParameter('workorder_ar_grave_id', '');
		$this->snCompletedBy = $oRequest->getParameter('workorder_completed_by', '');
		$this->snDeptId = $oRequest->getParameter('workorder_department_delegation', '');
		
		
		$this->asCementery = $this->asAreaList = $this->asSectionList = $this->asRowList = $this->asPlotList = $this->asGraveList = $this->asDeptList = $this->asCemStaffList = array();
		
        if($snIdWorkorder)
        {
            $oWorkflows  = Doctrine::getTable('Workflow')->getWorkFlowDetail($snIdWorkorder);             
            foreach($oWorkflows as $oWork)
                $oWorkflow = $oWork;
            $this->forward404Unless($oWorkflow);
            $this->oWorkflowForm = new WorkflowForm($oWorkflow);
            $ssSuccessKey = 2; // Success message key for edit
			
			// For get Cemetery List As per Country
			$this->asCementery = Doctrine::getTable('CemCemetery')->getAllCemeteries($oWorkflow->getCountryId());
			
			// For get Area List as per Cemetery
			$this->asAreaList = Doctrine::getTable('ArArea')->getAreaListAsPerCemetery($oWorkflow->getCountryId(),$oWorkflow->getCemCemeteryId());

			// For get Section List as per area
			$this->asSectionList = Doctrine::getTable('ArSection')->getSectionListAsPerArea($oWorkflow->getCountryId(),$oWorkflow->getCemCemeteryId(),$oWorkflow->getArAreaId());

			// For get Row List as per section
			$this->asRowList = Doctrine::getTable('ArRow')->getRowListAsPerSection($oWorkflow->getCountryId(),$oWorkflow->getCemCemeteryId(),$oWorkflow->getArAreaId(),$oWorkflow->getArSectionId());
			
			// For get Plot List as per Row
			$this->asPlotList = Doctrine::getTable('ArPlot')->getPlotListAsPerArea($oWorkflow->getCountryId(),$oWorkflow->getCemCemeteryId(),$oWorkflow->getArAreaId(),$oWorkflow->getArSectionId(),$oWorkflow->getArRowId());
			
			// For get Grave List as per Plot
			$this->asGraveList = Doctrine::getTable('ArGrave')->getGraveListAsPerCriteria($oWorkflow->getCountryId(),$oWorkflow->getCemCemeteryId(),$oWorkflow->getArAreaId(),$oWorkflow->getArSectionId(),$oWorkflow->getArRowId(),$oWorkflow->getArPlotId(),'true');
			
			$this->snCementeryId = ($this->snCementeryId != '') ? $this->snCementeryId : $oWorkflow->getCemCemeteryId();
			$this->snAreaId = ($this->snAreaId != '') ? $this->snAreaId : $oWorkflow->getArAreaId();
			$this->snSectionId = ($this->snSectionId != '') ? $this->snSectionId : $oWorkflow->getArSectionId();
			$this->snRowId = ($this->snRowId != '') ? $this->snRowId : $oWorkflow->getArRowId();
			$this->snPlotId = ($this->snPlotId != '') ? $this->snPlotId : $oWorkflow->getArPlotId();
			$this->snGraveId = ($this->snGraveId != '') ? $this->snGraveId : $oWorkflow->getArGraveId();
		
			$this->snCompletedBy = ($this->snCompletedBy != '') ? $this->snCompletedBy : $oWorkflow->getCompletedBy();
			$this->snDeptId = ($this->snDeptId != '') ? $this->snDeptId  : $oWorkflow['department_delegation'];

	
			// Get all departments as per cemetery wise.
			$this->asDeptList = Doctrine::getTable('DepartmentDelegation')->getAllDepartment($this->snCementeryId);
			// Get cemetery staff list as per cemetery wise.
			$this->asCemStaffList = Doctrine::getTable('sfGuardUser')->getCemeteryStaffList($this->snCementeryId);	
        }
        else
            $this->oWorkflowForm = new WorkflowForm();

        $this->getConfigurationFields($this->oWorkflowForm);

		$amWorkorderFormRequest = $oRequest->getParameter($this->oWorkflowForm->getName());
		$this->snCementeryId = isset($amWorkorderFormRequest['cem_cemetery_id']) ? $amWorkorderFormRequest['cem_cemetery_id'] : $this->snCementeryId;

		if($amWorkorderFormRequest['country_id'] != '')
			$this->asCementery = Doctrine::getTable('CemCemetery')->getAllCemeteries($amWorkorderFormRequest['country_id']);
		if($this->snCementeryId != '' && $amWorkorderFormRequest['country_id'] != '')
			$this->asAreaList = Doctrine::getTable('ArArea')->getAreaListAsPerCemetery($amWorkorderFormRequest['country_id'], $this->snCementeryId);
		if($amWorkorderFormRequest['country_id'] != '' && $this->snCementeryId != '')
			$this->asSectionList = Doctrine::getTable('ArSection')->getSectionListAsPerArea($amWorkorderFormRequest['country_id'], $this->snCementeryId, $this->snAreaId);
		if($amWorkorderFormRequest['country_id'] != '' && $this->snCementeryId != '')
			$this->asRowList = Doctrine::getTable('ArRow')->getRowListAsPerSection($amWorkorderFormRequest['country_id'], $this->snCementeryId, $this->snAreaId, $this->snSectionId);
		if($amWorkorderFormRequest['country_id'] != '' && $this->snCementeryId != '')
			$this->asPlotList = Doctrine::getTable('ArPlot')->getPlotListAsPerArea($amWorkorderFormRequest['country_id'],$this->snCementeryId,$this->snAreaId,$this->snSectionId,$this->snRowId);
		if($amWorkorderFormRequest['country_id'] != '' && $this->snCementeryId != '')
			$this->asGraveList = Doctrine::getTable('ArGrave')->getGraveListAsPerCriteria($amWorkorderFormRequest['country_id'],$this->snCementeryId,$this->snAreaId,$this->snSectionId,$this->snRowId,$this->snPlotId,'true');

        if($oRequest->isMethod('post'))
        {
			if($amWorkorderFormRequest['work_date'] != '' && $amWorkorderFormRequest['work_date'] != '0000-00-00') 
			{
				list($snDay,$snMonth,$snYear) = explode('-',$amWorkorderFormRequest['work_date']);
				$amWorkorderFormRequest['work_date'] = $snYear.'-'.$snMonth.'-'.$snDay;
			}
			if($amWorkorderFormRequest['completion_date'] != '' && $amWorkorderFormRequest['completion_date'] != '0000-00-00') 
			{
				list($snDay,$snMonth,$snYear) = explode('-',$amWorkorderFormRequest['completion_date']);
				$amWorkorderFormRequest['completion_date'] = $snYear.'-'.$snMonth.'-'.$snDay;
			}
			
            $this->oWorkflowForm->bind($amWorkorderFormRequest);
			
			$bSelectCemetery = $bSelectGrave = false;
			if($this->getUser()->isSuperAdmin())
			{
				if($oRequest->getParameter('workorder_cem_cemetery_id') != '')
					$bSelectCemetery = true;
			}
			else
				$bSelectCemetery = true;

            if($this->oWorkflowForm->isValid() && $bSelectCemetery)
            {
				$snIdWorkOrder = $this->oWorkflowForm->save()->getId();

                $this->getUser()->setFlash('snSuccessMsgKey', $ssSuccessKey);   //Set messages for add and update records
				$this->redirect('workorder/index?'.$this->amExtraParameters['ssQuerystr']);
            }
			else
			{
				if(!$bSelectCemetery)
					$this->getUser()->setFlash('ssErrorCemeter',__('Please select cemetery'));
			}
        }
    }
	/**
    * Executes getDepartmentListAsPerCemetery action
    *
    * @access public
    * @param sfRequest $request A request object
    */
    public function executeGetDepartmentListAsPerCemetery(sfWebRequest $request)
    {	
		$snCemeteryId = $request->getParameter('cemetery_id','');	
		$asDeptList = Doctrine::getTable('DepartmentDelegation')->getAllDepartment($snCemeteryId);
		return $this->renderPartial('getDeptDelegationList', array('asDeptList' => $asDeptList));
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
		$asCemStaffList = Doctrine::getTable('sfGuardUser')->getCemeteryStaffList($snCemeteryId);	
		return $this->renderPartial('getCemeteryStaffList', array('asCemStaffList' => $asCemStaffList));
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
					'country_id'				=> __('Select Country'),
					'department_delegation'		=> __('Select Department Delegation'),
					'completed_by'				=> __('Select Completed By'),
				 )
		);

        $oForm->setLabels(
            array(
				'work_date' 			=> __('Work Date'),
				'title' 				=> __('Title'),
				'name' 					=> __('Name'),
				'surname' 				=> __('Surname'),
				'email' 				=> __('Email'),
				'area_code' 			=> __('Area Code'),
				'telephone'				=> __('Telephone'),
				'department_delegation'	=> __('Deparment Delegation'),
				'work_description' 		=> __('Work/Issue Description'),
				'completed_by' 			=> __('Completed By'),
				'completion_date' 		=> __('Completion Date'),
				'action_taken'        	=> __('Action Taken/Notes'),
				'feed_charges' 			=> __('Feed Charges'),
				'receipt_number' 		=> __('Receipt Number'),
            )
        );

        $oForm->setValidators(
            array(
					'country_id'	=> array(
											'required'  => __('Please select country')
										),
					'name'			=> array(
											'required'  => __('Please enter name')
										),
					'surname'		=> array(
											'required'  => __('Please enter surname')
										),
				)
        );
    }
}
