<?php
/**
 * Departments actions.
 *
 * @package    Cemetery
 * @subpackage departments
 * @author     Prakash Panchal
 * @author      
 *
 */
sfProjectConfiguration::getActive()->loadHelpers(array('I18N'));
class departmentsActions extends sfActions
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
        $this->ssFormName = 'frm_list_department';
        $omRequest        = sfContext::getInstance()->getRequest();

        // Set default values
        $this->amExtraParameters = array();
        $this->amExtraParameters['snPaging']        = $this->snPaging       = $omRequest->getParameter('paging',sfConfig::get('app_default_paging_records'));
        $this->amExtraParameters['snPage']          = $this->snPage         = $omRequest->getParameter('page', sfConfig::get('app_default_page', 1));
        $this->amExtraParameters['ssSearchName']   	= $this->ssSearchName  	= trim($omRequest->getParameter('searchName',''));
        $this->amExtraParameters['ssSearchIsEnabled']   	= $this->ssSearchIsEnabled  	= trim($omRequest->getParameter('searchIsEnabled',''));        
        $this->amExtraParameters['ssSortBy']        = $this->ssSortBy       = $omRequest->getParameter('sortby','id');
        $this->amExtraParameters['ssSortMode']      = $this->ssSortMode     = $omRequest->getParameter('sortmode','desc');

        $this->ssSortQuerystr = $this->ssQuerystr = 'page='.$this->snPage.'&paging='.$this->snPaging;

        if($this->getRequestParameter('searchName') != '' )        // Search parameters
        {
            $this->ssQuerystr    .= '&searchName='.$this->getRequestParameter('searchName');
            $this->ssSortQuerystr.= '&searchName='.$this->getRequestParameter('searchName');
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
								'name' => array(
												'caption'	=> __('Name'),
												'id'		=> 'Name',
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
											),										
							);

        $omCommon = new common();

        if($request->getParameter('admin_act') == "delete" && $request->getParameter('id'))            
        {
            $omCommon->DeleteRecordsComposite('DepartmentDelegation', $request->getParameter('id'),'id');
            $this->getUser()->setFlash('snSuccessMsgKey', 3);      
        }

        // Change status
        if($request->getParameter('admin_act') == "status" && $request->getParameter('id'))
        {   
            $ssStatus     = ($request->getParameter('request_status') == "Active") ? 1 : '0';
            $ssSuccessKey = 1;

            $omCommon->UpdateStatusComposite('DepartmentDelegation','is_active', $request->getParameter('id'), $ssStatus, 'id');
            $this->getUser()->setFlash('snSuccessMsgKey', $ssSuccessKey); // set flag variable to display proper message
            unset($omCommon);
        } 


        // Get cms page list for listing.
        $oDepartmentPageListQuery = Doctrine::getTable('DepartmentDelegation')->getDepartmentList($this->amExtraParameters, $this->amSearch);

        // Set pager and get results
        $oPager               = new sfMyPager();
        $this->oDepartmentList  = $oPager->getResults('DepartmentDelegation', $this->snPaging,$oDepartmentPageListQuery,$this->snPage);
        $this->amDepartmentList = $this->oDepartmentList->getResults(Doctrine::HYDRATE_ARRAY);

        unset($oPager);

        // Total number of records
        $this->snPageTotalDepartmentPages = $this->oDepartmentList->getNbResults();

        if($request->getParameter('request_type') == 'ajax_request')
            $this->setTemplate('listDepartmentUpdate');
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
        $snIdDepartment = $oRequest->getParameter('id', '');
        $ssSuccessKey   = 4; // Success message key for add
        $this->snCementeryId = $oRequest->getParameter('department_cem_cemetery_id', '');
		$this->asCementery = array();
        if($snIdDepartment)
        {
            $this->forward404Unless($oDepartment = Doctrine::getTable('DepartmentDelegation')->find($snIdDepartment));
            $this->oDepartmentForm = new DepartmentDelegationForm($oDepartment);
            $ssSuccessKey = 2; // Success message key for edit
			
			// For get Cemetery List
			$this->asCementery = Doctrine::getTable('CemCemetery')->getAllCemeteries($oDepartment->getCountryId());
			$this->snCementeryId = ($this->snCementeryId == '') ? $oDepartment->getCemCemeteryId() : $this->snCementeryId;
        }
        else
            $this->oDepartmentForm = new DepartmentDelegationForm();

        $this->getConfigurationFields($this->oDepartmentForm);

        if($oRequest->isMethod('post'))
        {
            $this->oDepartmentForm->bind($oRequest->getParameter($this->oDepartmentForm->getName()));
			
			$bSelectCemetery = false;
			if($this->getUser()->isSuperAdmin())
			{
				if($oRequest->getParameter('department_cem_cemetery_id') != '')
					$bSelectCemetery = true;
			}
			else
				$bSelectCemetery = true;

            if($this->oDepartmentForm->isValid() && $bSelectCemetery)
            {
                $snIdGroup = $this->oDepartmentForm->save()->getId();

                $this->getUser()->setFlash('snSuccessMsgKey', $ssSuccessKey);   //Set messages for add and update records

               	$this->redirect('departments/index?'.$this->amExtraParameters['ssQuerystr']);
            }
			else
			{
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
					'country_id'       => __('Select Country'),
					'cem_cemetery_id'  => __('Select Cemetery'),
				 )
		);

        $oForm->setLabels(
            array(
                'name'             => __('Name'),
                'is_enabled'       => __('Enabled')
                
            )
        );

        $oForm->setValidators(
            array(
                'name'	=> array(
								'required'        => __('Name required'),
								'invalid_unique'  => __('Name already exists'),
                                ),
				'country_id'        => array(
														'required'  => __('Please select country')
												),
				'cem_cemetery_id'        => array(
													'required'  => __('Please select cemetery')
											),
            )
        );
    }
}
