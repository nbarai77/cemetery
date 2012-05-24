<?php
/**
 * Stone Mason actions.
 *
 * @package    Cemetery
 * @subpackage Stone Mason
 * @author     Prakash Panchal
 *
 */
sfProjectConfiguration::getActive()->loadHelpers(array('I18N'));
class stonemasonActions extends sfActions
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
        $this->ssFormName = 'frm_list_stonemason';
        $omRequest        = sfContext::getInstance()->getRequest();

        // Set default values
        $this->amExtraParameters = array();
        $this->amExtraParameters['snPaging']        = $this->snPaging       = $omRequest->getParameter('paging',sfConfig::get('app_default_paging_records'));
        $this->amExtraParameters['snPage']          = $this->snPage         = $omRequest->getParameter('page', sfConfig::get('app_default_page', 1));
        $this->amExtraParameters['ssSearchCompanyName']   	= $this->ssSearchName  	= trim($omRequest->getParameter('searchCompanyName',''));
        $this->amExtraParameters['ssSearchIsEnabled']   	= $this->ssSearchIsEnabled  	= trim($omRequest->getParameter('searchIsEnabled',''));
        $this->amExtraParameters['ssSortBy']        = $this->ssSortBy       = $omRequest->getParameter('sortby','id');
        $this->amExtraParameters['ssSortMode']      = $this->ssSortMode     = $omRequest->getParameter('sortmode','desc');

        $this->ssSortQuerystr = $this->ssQuerystr = 'page='.$this->snPage.'&paging='.$this->snPaging;

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
            $omCommon->DeleteRecordsComposite('CemStonemason', $request->getParameter('id'),'id');
            $this->getUser()->setFlash('snSuccessMsgKey', 3);      
        }

        // Get cms page list for listing.
        $oCemStonemasonPageListQuery = Doctrine::getTable('CemStonemason')->getStoneMasonList($this->amExtraParameters, $this->amSearch);

        // Set pager and get results
        $oPager               = new sfMyPager();
        $this->oCemStonemasonList  = $oPager->getResults('CemStonemason', $this->snPaging,$oCemStonemasonPageListQuery,$this->snPage);
        $this->amCemStonemasonList = $this->oCemStonemasonList->getResults(Doctrine::HYDRATE_ARRAY);

        unset($oPager);

        // Total number of records
        $this->snPageTotalCemStonemasonPages = $this->oCemStonemasonList->getNbResults();

        if($request->getParameter('request_type') == 'ajax_request')
            $this->setTemplate('listStoneMasonUpdate');
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
        $snIdStoneMason = $oRequest->getParameter('id', '');
        $this->snCementeryId = $oRequest->getParameter('stonemason_cem_cemetery_id', '');
        $this->asCementery = array();
        $ssSuccessKey   = 4; // Success message key for add        
        if($snIdStoneMason)
        {
            $this->forward404Unless($oStoneMason = Doctrine::getTable('CemStonemason')->find($snIdStoneMason));
            $this->oCemStonemasonForm = new CemStonemasonForm($oStoneMason);
			
            $ssSuccessKey = 2; // Success message key for edit
            
			// For get Cementry List
			$this->asCementery = Doctrine::getTable('CemCemetery')->getAllCemeteries($oStoneMason->getCountryId()); 
			$this->snCementeryId = ($this->snCementeryId != '') ? $this->snCementeryId : $oStoneMason->getCemCemeteryId();           
            
        }
        else
            $this->oCemStonemasonForm = new CemStonemasonForm();

        $this->getConfigurationFields($this->oCemStonemasonForm);
        
        
		$amStonemasonFormRequest = $oRequest->getParameter($this->oCemStonemasonForm->getName());
		$this->snCementeryId = isset($amStonemasonFormRequest['cem_cemetery_id']) ? $amStonemasonFormRequest['cem_cemetery_id'] : $this->snCementeryId;
		
		if($amStonemasonFormRequest['country_id'] != '')
			$this->asCementery = Doctrine::getTable('CemCemetery')->getAllCemeteries($amStonemasonFormRequest['country_id']);        
        


        if($oRequest->isMethod('post'))
        {
            $this->oCemStonemasonForm->bind($amStonemasonFormRequest);
			
			$bSelectCemetery = false;
			if($this->getUser()->isSuperAdmin())
			{
				if($oRequest->getParameter('stonemason_cem_cemetery_id') != '')
					$bSelectCemetery = true;
			}
			else
				$bSelectCemetery = true;
				
            if($this->oCemStonemasonForm->isValid() && $bSelectCemetery)
            {
				$snIdStoneMason = $this->oCemStonemasonForm->save();

				$this->getUser()->setFlash('snSuccessMsgKey', $ssSuccessKey);   //Set messages for add and update records
				$this->redirect('stonemason/index?'.$this->amExtraParameters['ssQuerystr']);
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
					'country_id'       			=> __('Select Country'),
					'cem_cemetery_id'       	=> __('Select Cemetery'),
					'work_type_stone_mason_id'	=> __('Select Work Type Stone Mason'),
				 )
		);

        $oForm->setLabels(
            array(
				'cem_cemetery_id'       	=> __('Cemetery'),
				'work_type_stone_mason_id'	=> __('Work Type Stone Mason'),
                'company_name'            	=> __('Company Name'),
                'address'             		=> __('Address'),
                'town'     	 				=> __('Suburb/Town'),
                'state'            			=> __('State'),
                'zip_code'            	 	=> __('Postal Code'),
				'country_id'       			=> __('Select Country'),
                'telephone'     	 		=> __('Telephone'),
                'area_code'             	=> __('Telephone Area Code'),
                'fax_number'            	=> __('Fax Number'),
                'fax_area_code'             => __('Fax Area Code'),
                'email'     	 			=> __('Email'),
                'accredited_to'             => __('Accredited To'),
                'contact_name'            	=> __('Conatact Name'),
                'company_telephone'         => __('Contact Telephone'),
                'contact_area_number'     	=> __('Contact Area Code'),
                'comment'					=> __('Comment'),
                'is_enabled'       			=> __('Enabled')
                
            )
        );

        $oForm->setValidators(
            array(
    	            'country_id'        		=> array(
														'required'  => __('Please select Country')
														),
    	            'cem_cemetery_id'        	=> array(
														'required'  => __('Please select cemetery')
														),
    	            'work_type_stone_mason_id'	=> array(
														'required'  => __('Please select work type stone mason')
														),
	                'company_name'              => array(
														'required'  => __('Please enter company name')
														),
	                'email'             		=> array(
														'invalid'  => __('Please enter valid email')
														)
				)
        );
    }
}
