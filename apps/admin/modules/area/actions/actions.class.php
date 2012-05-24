<?php
/**
 * Area actions.
 *
 * @package    Cemetery
 * @subpackage Area
 * @author     Prakash Panchal
 *
 */
sfProjectConfiguration::getActive()->loadHelpers(array('I18N'));
class areaActions extends sfActions
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
        $this->ssFormName = 'frm_list_area';
        $omRequest        = sfContext::getInstance()->getRequest();

        // Set default values
        $this->amExtraParameters = array();
        $this->amExtraParameters['snPaging']        = $this->snPaging       = $omRequest->getParameter('paging',sfConfig::get('app_default_paging_records'));
        $this->amExtraParameters['snPage']          = $this->snPage         = $omRequest->getParameter('page', sfConfig::get('app_default_page', 1));
        $this->amExtraParameters['ssSearchAreaName']   	= $this->ssSearchName  	= trim($omRequest->getParameter('searchAreaName',''));
        $this->amExtraParameters['ssSearchIsEnabled']   	= $this->ssSearchIsEnabled  	= trim($omRequest->getParameter('searchIsEnabled',''));
        $this->amExtraParameters['ssSortBy']        = $this->ssSortBy       = $omRequest->getParameter('sortby','id');
        $this->amExtraParameters['ssSortMode']      = $this->ssSortMode     = $omRequest->getParameter('sortmode','desc');

        $this->ssSortQuerystr = $this->ssQuerystr = 'page='.$this->snPage.'&paging='.$this->snPaging;

        if($this->getRequestParameter('searchAreaName') != '' )        // Search parameters
        {
            $this->ssQuerystr    .= '&searchAreaName='.$this->getRequestParameter('searchAreaName');
            $this->ssSortQuerystr.= '&searchAreaName='.$this->getRequestParameter('searchAreaName');
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
								'area_name' => array(
												'caption'	=> __('Area Name'),
												'id'		=> 'AreaName',
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
            $omCommon->DeleteRecordsComposite('ArArea', $request->getParameter('id'),'id');
            $this->getUser()->setFlash('snSuccessMsgKey', 3);      
        }

        // Get cms page list for listing.
        $oArAreaPageListQuery = Doctrine::getTable('ArArea')->getArAreaList($this->amExtraParameters, $this->amSearch);

        // Set pager and get results
        $oPager               = new sfMyPager();
        $this->oArAreaList  = $oPager->getResults('ArArea', $this->snPaging,$oArAreaPageListQuery,$this->snPage);
        $this->amArAreaList = $this->oArAreaList->getResults(Doctrine::HYDRATE_ARRAY);

        unset($oPager);

        // Total number of records
        $this->snPageTotalArAreaPages = $this->oArAreaList->getNbResults();

        if($request->getParameter('request_type') == 'ajax_request')
            $this->setTemplate('listArAreaUpdate');
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
		//exec('rm -fR '.sfConfig::get('sf_upload_dir').'/'.sfConfig::get('app_mappath_dir').'/'.sfConfig::get('app_area_dir'));exit;
        $snIdArea = $oRequest->getParameter('id', '');
        $ssSuccessKey   = 4; // Success message key for add        
		$this->snCementeryId = $oRequest->getParameter('area_cem_cemetery_id', '');
		$this->asCementery = array();
        if($snIdArea)
        {
            $this->forward404Unless($oArea = Doctrine::getTable('ArArea')->find($snIdArea));
            $this->oArAreaForm = new ArAreaForm($oArea);
			
            $ssSuccessKey = 2; // Success message key for edit
			
			// For get Cemetery List
			$this->asCementery = Doctrine::getTable('CemCemetery')->getAllCemeteries($oArea->getCountryId());
			$this->snCementeryId = ($this->snCementeryId == '') ? $oArea->getCemCemeteryId() : $this->snCementeryId;

        }
        else
            $this->oArAreaForm = new ArAreaForm();

        $this->getConfigurationFields($this->oArAreaForm);

		$amAreaRequestParameter = $oRequest->getParameter($this->oArAreaForm->getName());
		if($amAreaRequestParameter['country_id'] != '')
			$this->asCementery = Doctrine::getTable('CemCemetery')->getAllCemeteries($amAreaRequestParameter['country_id']);


        if($oRequest->isMethod('post'))
        {
            $this->oArAreaForm->bind($amAreaRequestParameter,$oRequest->getFiles($this->oArAreaForm->getName()));
			
			$bSelectCemetery = false;
			if($this->getUser()->isSuperAdmin())
			{
				if($oRequest->getParameter('area_cem_cemetery_id') != '')
					$bSelectCemetery = true;
			}
			else
				$bSelectCemetery = true;
			
            if($this->oArAreaForm->isValid() && $bSelectCemetery)
            {
				// For Upload Doc.
				$oFile = $this->oArAreaForm->getValue('area_map_path');
				
				// Remove old Image while upload new grave image1
				if(!empty($oFile) && isset($oArea))
				{					
					if($oArea->getAreaMapPath() != '')
					  sfGeneral::removeFile(sfConfig::get('sf_upload_dir').'/'.sfConfig::get('app_mappath_dir').'/'.sfConfig::get('app_area_dir').'/'.$oArea->getAreaMapPath());
				}
				// Save Records
				$snIdArea = $this->oArAreaForm->save();

				// For Create mappath directory if not exists
				sfGeneral::createDirectory(sfConfig::get('sf_upload_dir').'/'.sfConfig::get('app_mappath_dir'));
				
                // While edit document remove old doc.
                if(!empty($oFile))
                {
                    $ssFileName = $snIdArea.'_'.uniqid().'_'.sha1($oFile->getOriginalName());
                    $amExtension = explode('.',$oFile->getOriginalName());
                    $ssExtentions =  ((count($amExtension) > 0) ? '.'.end($amExtension) : '');
                    $ssFileName = $ssFileName.$ssExtentions;
                  
                    $oFile->save(sfConfig::get('sf_upload_dir').'/'.sfConfig::get('app_mappath_dir').'/'.sfConfig::get('app_area_dir').'/'.$ssFileName);
                }
				
				// For update Field Name
				if( !empty($oFile) )
					common::UpdateCompositeField('ArArea','area_map_path',$ssFileName,'id',$snIdArea);
				
				$this->getUser()->setFlash('snSuccessMsgKey', $ssSuccessKey);   //Set messages for add and update records
				$this->redirect('area/index?'.$this->amExtraParameters['ssQuerystr']);
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
				'country_id'       => __('Select Country'),
				'cem_cemetery_id'  => __('Select Cemetery'),
                'area_name'             => __('Area Name'),
                'area_code'             => __('Area Code'),
                'area_description'      => __('Area Description'),
                'area_control_numberr'	=> __('Area Control Number'),
                'area_user'             => __('Area User'),
                'is_enabled'       		=> __('Enabled')
            )
        );

        $oForm->setValidators(
            array(
	                'area_name'              => array(
														'required'  => __('Please enter area name')
													),
					'area_code'              => array(
														'required'  => __('Please enter area code')
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
