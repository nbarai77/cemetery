<?php
/**
 * Section actions.
 *
 * @package    Cemetery
 * @subpackage Section
 * @author     Prakash Panchal
 * @author      
 *
 */
sfProjectConfiguration::getActive()->loadHelpers(array('I18N'));
class sectionActions extends sfActions
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
        $this->ssFormName = 'frm_list_section';
        $omRequest        = sfContext::getInstance()->getRequest();

        // Set default values
        $this->amExtraParameters = array();
        $this->amExtraParameters['snPaging']        = $this->snPaging       = $omRequest->getParameter('paging',sfConfig::get('app_default_paging_records'));
        $this->amExtraParameters['snPage']          = $this->snPage         = $omRequest->getParameter('page', sfConfig::get('app_default_page', 1));
        $this->amExtraParameters['ssSearchSectionName']   	= $this->ssSearchName  	= trim($omRequest->getParameter('searchSectionName',''));
        $this->amExtraParameters['ssSearchIsEnabled']   	= $this->ssSearchIsEnabled  	= trim($omRequest->getParameter('searchIsEnabled',''));        
        $this->amExtraParameters['ssSortBy']        = $this->ssSortBy       = $omRequest->getParameter('sortby','id');
        $this->amExtraParameters['ssSortMode']      = $this->ssSortMode     = $omRequest->getParameter('sortmode','desc');

        $this->ssSortQuerystr = $this->ssQuerystr = 'page='.$this->snPage.'&paging='.$this->snPaging;

        if($this->getRequestParameter('searchSectionName') != '' )        // Search parameters
        {
            $this->ssQuerystr    .= '&searchSectionName='.$this->getRequestParameter('searchSectionName');
            $this->ssSortQuerystr.= '&searchSectionName='.$this->getRequestParameter('searchSectionName');
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
								'section_name' => array(
												'caption'	=> __('Section Name'),
												'id'		=> 'SectionName',
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
            $omCommon->DeleteRecordsComposite('ArSection', $request->getParameter('id'),'id');
            $this->getUser()->setFlash('snSuccessMsgKey', 3);      
        }

        // Get cms page list for listing.
        $oArSectionPageListQuery = Doctrine::getTable('ArSection')->getSectionList($this->amExtraParameters, $this->amSearch);

        // Set pager and get results
        $oPager               = new sfMyPager();
        $this->oArSectionList  = $oPager->getResults('ArSection', $this->snPaging,$oArSectionPageListQuery,$this->snPage);
        $this->amArSectionList = $this->oArSectionList->getResults(Doctrine::HYDRATE_ARRAY);

        unset($oPager);

        // Total number of records
        $this->snPageTotalArSectionPages = $this->oArSectionList->getNbResults();

        if($request->getParameter('request_type') == 'ajax_request')
            $this->setTemplate('listArSectionUpdate');
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
        $snIdArea = $oRequest->getParameter('id', '');
        $ssSuccessKey   = 4; // Success message key for add
        $this->snCementeryId = $oRequest->getParameter('section_cem_cemetery_id', '');
        $this->snAreaId = $oRequest->getParameter('section_ar_area_id', '');
		$this->asCementery = $this->asAreaList = array();
        if($snIdArea)
        {
            $this->forward404Unless($oAreaSection = Doctrine::getTable('ArSection')->find($snIdArea));
            $this->oArSectionForm = new ArSectionForm($oAreaSection);
            $ssSuccessKey = 2; // Success message key for edit
			
			// For get Cementry List
			$this->asCementery = Doctrine::getTable('CemCemetery')->getAllCemeteries($oAreaSection->getCountryId());
			
			// For get Area List
			$this->asAreaList = Doctrine::getTable('ArArea')->getAreaListAsPerCemetery($oAreaSection->getCountryId(), $oAreaSection->getCemCemeteryId());
			
			$this->snAreaId = ($this->snAreaId != '') ? $this->snAreaId : $oAreaSection->getArAreaId();
			$this->snCementeryId = ($this->snCementeryId != '') ? $this->snCementeryId : $oAreaSection->getCemCemeteryId();
        }
        else
            $this->oArSectionForm = new ArSectionForm();

        $this->getConfigurationFields($this->oArSectionForm);

		$amSectionFormRequest = $oRequest->getParameter($this->oArSectionForm->getName());
		$this->snCementeryId = isset($amSectionFormRequest['cem_cemetery_id']) ? $amSectionFormRequest['cem_cemetery_id'] : $this->snCementeryId;
		
		if($amSectionFormRequest['country_id'] != '')
			$this->asCementery = Doctrine::getTable('CemCemetery')->getAllCemeteries($amSectionFormRequest['country_id']);
		if($this->snCementeryId != '' && $amSectionFormRequest['country_id'] != '')
			$this->asAreaList = Doctrine::getTable('ArArea')->getAreaListAsPerCemetery($amSectionFormRequest['country_id'], $this->snCementeryId);
			
        if($oRequest->isMethod('post'))
        {
            $this->oArSectionForm->bind($amSectionFormRequest,$oRequest->getFiles($this->oArSectionForm->getName()));

			$bSelectCemetery = false;
			if($this->getUser()->isSuperAdmin())
			{
				if($oRequest->getParameter('section_cem_cemetery_id') != '')
					$bSelectCemetery = true;
			}
			else
				$bSelectCemetery = true;

            if($this->oArSectionForm->isValid() && $bSelectCemetery)
            {
				// For Upload Doc.
				$oFile = $this->oArSectionForm->getValue('section_map_path');
				
				// Remove old Image while upload new grave image1
				if(!empty($oFile) && isset($oAreaSection))
				{
					if($oAreaSection->getSectionMapPath() != '')
					  sfGeneral::removeFile(sfConfig::get('sf_upload_dir').'/'.sfConfig::get('app_mappath_dir').'/'.sfConfig::get('app_section_dir').'/'.$oAreaSection->getSectionMapPath());
				}
				// Save Records
                $snIdAreaSection = $this->oArSectionForm->save();

				// For Create mappath directory if not exists
				sfGeneral::createDirectory(sfConfig::get('sf_upload_dir').'/'.sfConfig::get('app_mappath_dir'));
				
                // While edit document remove old doc.
                if(!empty($oFile))
                {                    
                    $ssFileName = $snIdAreaSection.'_'.uniqid().'_'.sha1($oFile->getOriginalName());
                    $amExtension = explode('.',$oFile->getOriginalName());
                    $ssExtentions =  ((count($amExtension) > 0) ? '.'.end($amExtension) : '');
                    $ssFileName = $ssFileName.$ssExtentions;
                  
                    $oFile->save(sfConfig::get('sf_upload_dir').'/'.sfConfig::get('app_mappath_dir').'/'.sfConfig::get('app_section_dir').'/'.$ssFileName);
                }

				// For update Field Name
				if( !empty($oFile) )
					common::UpdateCompositeField('ArSection','section_map_path',$ssFileName,'id',$snIdAreaSection);

                $this->getUser()->setFlash('snSuccessMsgKey', $ssSuccessKey);   //Set messages for add and update records
               	$this->redirect('section/index?'.$this->amExtraParameters['ssQuerystr']);
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
    * Executes getCementryListAsPerCountry action
    *
    * @access public
    * @param sfRequest $request A request object
    */
    public function executeGetAreaListAsPerCemetery(sfWebRequest $request)
    {	
		$snIdCountry = $request->getParameter('country_id','');
		$snCemeteryId = $request->getParameter('cemetery_id','');
		$asCementery = Doctrine::getTable('ArArea')->getAreaListAsPerCemetery($snIdCountry, $snCemeteryId);
		return $this->renderPartial('getAreaList', array('asAreaList' => $asCementery));
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
					'country_id'	=> __('Select Country'),
					'cem_cemetery_id'  => __('Select Cemetery'),
				 )
		);
        $oForm->setLabels(
            array(
				'country_id'       => __('Select Country'),
				'cem_cemetery_id'  => __('Select Cemetery'),
                'section_code'  => __('Section Code'),
                'section_name'  => __('Section Name'),
                'first_grave'   => __('First Grave'),
                'last_grave'	=> __('Last Grave'),
                'section_user'  => __('Section User'),
                'is_enabled'    => __('Enabled')
                
            )
        );

        $oForm->setValidators(
            array(
	                'section_name'		=> array(
												'required'  => __('Please enter section name')
												),
					'section_code'		=> array(
												'required'  => __('Please enter section code')
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
