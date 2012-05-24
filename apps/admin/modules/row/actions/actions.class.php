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
class rowActions extends sfActions
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
        $this->ssFormName = 'frm_list_row';
        $omRequest        = sfContext::getInstance()->getRequest();

        // Set default values
        $this->amExtraParameters = array();
        $this->amExtraParameters['snPaging']        = $this->snPaging       = $omRequest->getParameter('paging',sfConfig::get('app_default_paging_records'));
        $this->amExtraParameters['snPage']          = $this->snPage         = $omRequest->getParameter('page', sfConfig::get('app_default_page', 1));
        $this->amExtraParameters['ssSearchRowName']   	= $this->ssSearchName  	= trim($omRequest->getParameter('searchRowName',''));
        $this->amExtraParameters['ssSearchIsEnabled']   	= $this->ssSearchIsEnabled  	= trim($omRequest->getParameter('searchIsEnabled',''));        
        $this->amExtraParameters['ssSortBy']        = $this->ssSortBy       = $omRequest->getParameter('sortby','id');
        $this->amExtraParameters['ssSortMode']      = $this->ssSortMode     = $omRequest->getParameter('sortmode','desc');

        $this->ssSortQuerystr = $this->ssQuerystr = 'page='.$this->snPage.'&paging='.$this->snPaging;

        if($this->getRequestParameter('searchRowName') != '' )        // Search parameters
        {
            $this->ssQuerystr    .= '&searchRowName='.$this->getRequestParameter('searchRowName');
            $this->ssSortQuerystr.= '&searchRowName='.$this->getRequestParameter('searchRowName');
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
								'row_name' => array(
												'caption'	=> __('Row Name'),
												'id'		=> 'RowName',
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
            $omCommon->DeleteRecordsComposite('ArRow', $request->getParameter('id'),'id');
            $this->getUser()->setFlash('snSuccessMsgKey', 3);      
        }

        // Get cms page list for listing.
        $oArRowPageListQuery = Doctrine::getTable('ArRow')->getAreaRowList($this->amExtraParameters, $this->amSearch);

        // Set pager and get results
        $oPager               = new sfMyPager();
        $this->oArRowList  = $oPager->getResults('ArRow', $this->snPaging,$oArRowPageListQuery,$this->snPage);
        $this->amArRowList = $this->oArRowList->getResults(Doctrine::HYDRATE_ARRAY);

        unset($oPager);

        // Total number of records
        $this->snPageTotalArRowPages = $this->oArRowList->getNbResults();

        if($request->getParameter('request_type') == 'ajax_request')
            $this->setTemplate('listArRowUpdate');
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
        $snIdRow = $oRequest->getParameter('id', '');
        $ssSuccessKey   = 4; // Success message key for add
        $this->snCementeryId = $oRequest->getParameter('row_cem_cemetery_id', '');
        $this->snAreaId = $oRequest->getParameter('row_ar_area_id', '');
        $this->snSectionId = $oRequest->getParameter('row_ar_section_id', '');
		$this->asCementery = $this->asAreaList = $this->asSectionList = array();
        if($snIdRow)
        {
            $this->forward404Unless($oRow = Doctrine::getTable('ArRow')->find($snIdRow));
            $this->oArRowForm = new ArRowForm($oRow);
            $ssSuccessKey = 2; // Success message key for edit
			
			// For get Cementry List
			$this->asCementery = Doctrine::getTable('CemCemetery')->getAllCemeteries($oRow->getCountryId());
			
			// For get Area List
			$this->asAreaList = Doctrine::getTable('ArArea')->getAreaListAsPerCemetery($oRow->getCountryId(),$oRow->getCemCemeteryId());

			// For get Section List
			$this->asSectionList = Doctrine::getTable('ArSection')->getSectionListAsPerArea($oRow->getCountryId(),$oRow->getCemCemeteryId(),$oRow->getArAreaId());

			$this->snCementeryId = ($this->snCementeryId != '') ? $this->snCementeryId : $oRow->getCemCemeteryId();
			$this->snAreaId = ($this->snAreaId != '') ? $this->snAreaId : $oRow->getArAreaId();
			$this->snSectionId = ($this->snSectionId != '') ? $this->snSectionId : $oRow->getArSectionId();
        }
        else
            $this->oArRowForm = new ArRowForm();

        $this->getConfigurationFields($this->oArRowForm);

		$amRowFormRequest = $oRequest->getParameter($this->oArRowForm->getName());
		$this->snCementeryId = isset($amRowFormRequest['cem_cemetery_id']) ? $amRowFormRequest['cem_cemetery_id'] : $this->snCementeryId;

		if($amRowFormRequest['country_id'] != '')
			$this->asCementery = Doctrine::getTable('CemCemetery')->getAllCemeteries($amRowFormRequest['country_id']);
		if($this->snCementeryId != '' && $amRowFormRequest['country_id'] != '')
			$this->asAreaList = Doctrine::getTable('ArArea')->getAreaListAsPerCemetery($amRowFormRequest['country_id'], $this->snCementeryId);
		if($amRowFormRequest['country_id'] != '' && $this->snCementeryId != '' && $this->snAreaId != '')
			$this->asSectionList = Doctrine::getTable('ArSection')->getSectionListAsPerArea($amRowFormRequest['country_id'], $this->snCementeryId, $this->snAreaId);

        if($oRequest->isMethod('post'))
        {
            $this->oArRowForm->bind($amRowFormRequest,$oRequest->getFiles($this->oArRowForm->getName()));
			
			$bSelectCemetery = false;
			if($this->getUser()->isSuperAdmin())
			{
				if($oRequest->getParameter('row_cem_cemetery_id') != '')
					$bSelectCemetery = true;
			}
			else
				$bSelectCemetery = true;
				
            if($this->oArRowForm->isValid() && $bSelectCemetery)
            {
				// For Upload Doc.
				$oFile = $this->oArRowForm->getValue('row_map_path');
				
				 // Remove old Image while upload new grave image1
				if(!empty($oFile) && isset($oRow))
				{
					if($oRow->getRowMapPath() != '')
					  sfGeneral::removeFile(sfConfig::get('sf_upload_dir').'/'.sfConfig::get('app_mappath_dir').'/'.sfConfig::get('app_row_dir').'/'.$oRow->getRowMapPath());
				}
				
				// Save Records.
                $snIdAreaRow = $this->oArRowForm->save()->getId();

				// For Create mappath directory if not exists
				sfGeneral::createDirectory(sfConfig::get('sf_upload_dir').'/'.sfConfig::get('app_mappath_dir'));
				
                // While edit document remove old doc.
                if(!empty($oFile))
                {
                    $ssFileName = $snIdAreaRow.'_'.uniqid().'_'.sha1($oFile->getOriginalName());
                    $amExtension = explode('.',$oFile->getOriginalName());
                    $ssExtentions =  ((count($amExtension) > 0) ? '.'.end($amExtension) : '');
                    $ssFileName = $ssFileName.$ssExtentions;
                  
                    $oFile->save(sfConfig::get('sf_upload_dir').'/'.sfConfig::get('app_mappath_dir').'/'.sfConfig::get('app_row_dir').'/'.$ssFileName);
                }
				
				// For update Field Name
				if( !empty($oFile) )
					common::UpdateCompositeField('ArRow','row_map_path',$ssFileName,'id',$snIdAreaRow);

                $this->getUser()->setFlash('snSuccessMsgKey', $ssSuccessKey);   //Set messages for add and update records
               	$this->redirect('row/index?'.$this->amExtraParameters['ssQuerystr']);
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
		$asAreaList = Doctrine::getTable('ArArea')->getAreaListAsPerCemetery($snIdCountry, $snCemeteryId);
		return $this->renderPartial('getAreaList', array('asAreaList' => $asAreaList));
	}
	/**
    * Executes getCementryListAsPerCountry action
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
                'row_name'  => __('Row Name'),
                'row_user'  => __('Row User'),
                'is_enabled'    => __('Enabled')
                
            )
        );

        $oForm->setValidators(
            array(
	                'row_name'		=> array(
												'required'  => __('Please enter row name')
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
