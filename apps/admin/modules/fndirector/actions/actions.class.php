<?php
/**
 * fndirector actions.
 *
 * @package    Cemetery
 * @subpackage fndirector
 * @author     Nitin Barai
 * @author      
 *
 */
sfProjectConfiguration::getActive()->loadHelpers(array('I18N'));
class fndirectorActions extends sfActions
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
        $this->ssFormName = 'frm_list_cem_fnd_fndirector';
        $omRequest        = sfContext::getInstance()->getRequest();

        // Set default values
        $this->amExtraParameters = array();
        $this->amExtraParameters['snPaging']        = $this->snPaging       = $omRequest->getParameter('paging',sfConfig::get('app_default_paging_records'));
        $this->amExtraParameters['snPage']          = $this->snPage         = $omRequest->getParameter('page', sfConfig::get('app_default_page', 1));
        $this->amExtraParameters['ssSearchFirstName']   	= $this->ssSearchContactName  	= trim($omRequest->getParameter('searchFirstName',''));
        $this->amExtraParameters['ssSearchLastName']   	= $this->ssSearchContactName  	= trim($omRequest->getParameter('searchLastName',''));
        $this->amExtraParameters['ssSearchCompanyName']   	= $this->ssSearchContactName  	= trim($omRequest->getParameter('searchCompanyName',''));
        $this->amExtraParameters['ssSearchIsEnabled']   	= $this->ssSearchIsEnabled  	= trim($omRequest->getParameter('searchIsEnabled',''));        
        $this->amExtraParameters['ssSortBy']        = $this->ssSortBy       = $omRequest->getParameter('sortby','id');
        $this->amExtraParameters['ssSortMode']      = $this->ssSortMode     = $omRequest->getParameter('sortmode','asc');

        $this->ssSortQuerystr = $this->ssQuerystr = 'page='.$this->snPage.'&paging='.$this->snPaging;

        if($this->getRequestParameter('searchFirstName') != '' )        // Search parameters
        {
            $this->ssQuerystr    .= '&searchFirstName='.$this->getRequestParameter('searchFirstName');
            $this->ssSortQuerystr.= '&searchFirstName='.$this->getRequestParameter('searchFirstName');
        }
		if($this->getRequestParameter('searchLastName') != '' )        // Search parameters
        {
            $this->ssQuerystr    .= '&searchLastName='.$this->getRequestParameter('searchLastName');
            $this->ssSortQuerystr.= '&searchLastName='.$this->getRequestParameter('searchLastName');
        }
		
        if($this->getRequestParameter('searchCompanyName') != '' )        // Search parameters
        {
            $this->ssQuerystr    .= '&searchCompanyName='.$this->getRequestParameter('searchCompanyName');
            $this->ssSortQuerystr.= '&searchCompanyName='.$this->getRequestParameter('searchCompanyName');
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
								'first_name' => array(
												'caption'	=> __('First Name'),
												'id'		=> 'FirstName',
												'type'		=> 'text',																								
											),
								'last_name' => array(
												'caption'	=> __('LastName'),
												'id'		=> 'LastName',
												'type'		=> 'text',																								
											),
								'company_name' => array(
												'caption'	=> __('Company Name'),
												'id'		=> 'CompanyName',
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
            $omCommon->DeleteRecordsComposite('FndFndirector', $request->getParameter('id'),'id');
            $omCommon->DeleteRecordsComposite('FndServiceFndirector', $request->getParameter('id'),'fnd_fndirector_id');
            $this->getUser()->setFlash('snSuccessMsgKey', 3);      
        }

        // Get cms page list for listing.
        $oGuardGroupPageListQuery = Doctrine::getTable('FndFndirector')->getFndFndirectorList($this->amExtraParameters, $this->amSearch);

        // Set pager and get results
        $oPager               = new sfMyPager();
        $this->oGuardGroupList  = $oPager->getResults('FndFndirector', $this->snPaging,$oGuardGroupPageListQuery,$this->snPage);
        $this->amGuardGroupList = $this->oGuardGroupList->getResults(Doctrine::HYDRATE_ARRAY);

        unset($oPager);

        // Total number of records
        $this->snPageTotalGuardGroupPages = $this->oGuardGroupList->getNbResults();

        if($request->getParameter('request_type') == 'ajax_request')
            $this->setTemplate('listFndFndirectorUpdate');
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
        $snIdGuardGroup = $oRequest->getParameter('id', '');
        $this->snCementeryId = $oRequest->getParameter('fndirector_cem_cemetery_id', '');
        $this->asCementery = array();
        $ssSuccessKey   = 4; // Success message key for add
        
        if($snIdGuardGroup)
        {
			$edit_form = true;
            $this->forward404Unless($oGroup = Doctrine::getTable('FndFndirector')->find($snIdGuardGroup));
            $this->oFndFndirectorForm = new FndFndirectorForm($oGroup);
            $ssSuccessKey = 2; // Success message key for edit
            
			// For get Cementry List
			$this->asCementery = Doctrine::getTable('CemCemetery')->getAllCemeteries($oGroup->getCountryId()); 
			$this->snCementeryId = ($this->snCementeryId != '') ? $this->snCementeryId : $oGroup->getCemCemeteryId();                       
        }
        else {
			$edit_form = false;	
            $this->oFndFndirectorForm = new FndFndirectorForm();
		}

        $this->getConfigurationFields($this->oFndFndirectorForm);
        
		$amFnDirectorFormRequest = $oRequest->getParameter($this->oFndFndirectorForm->getName());
		$this->snCementeryId = isset($amFnDirectorFormRequest['cem_cemetery_id']) ? $amFnDirectorFormRequest['cem_cemetery_id'] : $this->snCementeryId;
		
		if($amFnDirectorFormRequest['country_id'] != '')
			$this->asCementery = Doctrine::getTable('CemCemetery')->getAllCemeteries($amFnDirectorFormRequest['country_id']);                
        
        if($oRequest->isMethod('post'))
        {
            $this->oFndFndirectorForm->bind($oRequest->getParameter($this->oFndFndirectorForm->getName()));

			$arr_param = $oRequest->getParameter($this->oFndFndirectorForm->getName());
			$grp_list = isset($arr_param['groups_list']) ? $arr_param['groups_list'] : '';

			
			$bSelectCemetery = false;
			if($this->getUser()->isSuperAdmin())
			{
				if($oRequest->getParameter('fndirector_cem_cemetery_id') != '')
					$bSelectCemetery = true;
			}
			else
				$bSelectCemetery = true;
				
            if($this->oFndFndirectorForm->isValid() && $bSelectCemetery)
            {
                $snIdGroup = $this->oFndFndirectorForm->save()->getId();
				if($edit_form) {
					$omCommon = new common();
					$omCommon->DeleteRecordsComposite('FndServiceFndirector', $snIdGroup,'fnd_fndirector_id');
				}
				
				if($grp_list != '')
				{
					for($i=0;$i<count($grp_list);$i++) {
						$ug = new FndServiceFndirector();
						$ug->setFndFndirectorId($snIdGroup);
						$ug->setFndServiceId($grp_list[$i]);
						$ug->save();                            
					}                
				}			                

                $this->getUser()->setFlash('snSuccessMsgKey', $ssSuccessKey);   //Set messages for add and update records

                if($oRequest->getParameter('tab'))
                    $this->redirect('fndirector/addedit?id='.$snIdGroup.'&tab='.$oRequest->getParameter('tab').'&'.$this->amExtraParameters['ssQuerystr']);
                else
                	$this->redirect('fndirector/index?'.$this->amExtraParameters['ssQuerystr']);
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
        $oForm->setWidgets(array(
        'country_id'       			=> __('Select Country'),
        'cem_cemetery_id' => __('Select Cemetery')));

        $oForm->setLabels(
            array(
				'groups_list'       => __('Select Services'),
				'last_name'       => __('Surname'),
				'cem_cemetery_id'       => __('Select Cemetery'),
				'country_id'       => __('Select Country'),
                'contact_name'              => __('Name'),
                'code'              => __('code'),
                'company_name'              => __('Company Name'),
				'first_name'		=> __('First Name'),
				'middle_name'		=> __('Middle Name'),
                'address1'              => __('Address1'),
                'address2'              => __('Address2'),
                'address3'              => __('Address3'),
                'state'              => __('State'),
                'postal_code'              => __('Postal Code'),
                'phone'              => __('Telephone'),
				'area_code'              => __('Telephone Area Code'),
                'contact_telephone'              => __('Contact Telephone'),
				'fax_area_code'              => __('Fax Area Code'),
                'fax_number'              => __('Fax'),
                'email'              => __('Email'),
                'town'              => __('Suburb/Town'),
                'is_enabled'       => __('Enabled')
                
            )
        );

        $oForm->setValidators(
            array(
				'first_name'              => array(
                                            'required'        => __('Please enter first name')
                                        ),
                'last_name'              => array(
                                            'required'        => __('Please enter surname')
                                        ),
                'company_name'              => array(
                                            'required'        => __('Please enter comapny name'),
                                        ),
    	       'country_id'        =>  array(
											'required'  => __('Please select country')
										),
    	       'cem_cemetery_id'        =>  array(
											'required'  => __('Please select cemetery')
										),										
										                                        
            )
        );
    }
}
