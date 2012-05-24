<?php
/**
 * Grave actions.
 *
 * @package    Cemetery
 * @subpackage Grave
 * @author     Prakash Panchal
 * @author      
 *
 */
sfProjectConfiguration::getActive()->loadHelpers(array('I18N','Url','Partial'));
class graveActions extends sfActions
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
									5 => __('Multiple Graves has been inserted successfully'),
                                );

        $this->amErrorMsg = array(1 => __('Please select at least one'),
								  2 => __('No latitude & longitude define for this grave'),
								);
        $this->ssFormName = 'frm_list_grave';
        $omRequest        = sfContext::getInstance()->getRequest();

        // Set default values
        $this->amExtraParameters = array();
        $this->amExtraParameters['snPaging']        = $this->snPaging       = $omRequest->getParameter('paging',sfConfig::get('app_default_paging_records'));
        $this->amExtraParameters['snPage']          = $this->snPage         = $omRequest->getParameter('page', sfConfig::get('app_default_page', 1));
		
		if($omRequest->getParameter('flag') == 'true' || $omRequest->getParameter('reset') == 'true') 
		{
			$this->getUser()->setAttribute('gr_country', '');
			$this->getUser()->setAttribute('gr_cemetery', '');
			$this->getUser()->setAttribute('gr_area', '');
			$this->getUser()->setAttribute('gr_section', '');
			$this->getUser()->setAttribute('gr_row', '');
			$this->getUser()->setAttribute('gr_plot', '');
			$this->getUser()->setAttribute('gr_grave', '');
			$this->getUser()->setAttribute('gr_gstatus', '');
		}
		if(!$this->getUser()->isSuperAdmin())
		{
			$this->snCemeteryId = $this->getUser()->getAttribute('cemeteryid');
			$oCemetery = Doctrine::getTable('CemCemetery')->find($this->snCemeteryId);
			$this->snCountryId = ($oCemetery) ? $oCemetery->getCountryId() : '';
			
			$this->getUser()->setAttribute('gr_country', $this->snCountryId);
			$this->getUser()->setAttribute('gr_cemetery', $this->snCemeteryId);
		}
		
		$this->amExtraParameters['ssSearchCountryId'] = $this->ssSearchCountryId  	= trim($omRequest->getParameter('searchCountryId',''));
		$this->amExtraParameters['ssSearchCountryId'] = ($this->ssSearchCountryId != '') ? $this->ssSearchCountryId : ( $this->getUser()->getAttribute('gr_country') != '' ? $this->getUser()->getAttribute('gr_country') : '');

		$this->amExtraParameters['ssSearchCemCemeteryId']   = $this->ssSearchCemeteryId  	= trim($omRequest->getParameter('searchCemCemeteryId',''));
		$this->amExtraParameters['ssSearchCemCemeteryId'] = ($this->ssSearchCemeteryId != '') ? $this->ssSearchCemeteryId : ($this->getUser()->getAttribute('gr_cemetery') != '' ? $this->getUser()->getAttribute('gr_cemetery') : '' );

		$this->ssSearchAreaId 		= trim($omRequest->getParameter('searchArAreaId',''));
		$this->ssSearchSectionId  	= trim($omRequest->getParameter('searchArSectionId',''));
		$this->ssSearchRowId 		= trim($omRequest->getParameter('searchArRowId',''));
		$this->ssSearchPlotId		= trim($omRequest->getParameter('searchArPlotId',''));
		
		$this->ssSearchAreaId 		= ($this->ssSearchAreaId != '') ? $this->ssSearchAreaId : ( $this->getUser()->getAttribute('gr_area') != '' ? $this->getUser()->getAttribute('gr_area') : '' );
		$this->ssSearchSectionId 	= ($this->ssSearchSectionId != '') ? $this->ssSearchSectionId : ( $this->getUser()->getAttribute('gr_section') != '' ? $this->getUser()->getAttribute('gr_section') : '' );
		$this->ssSearchRowId 		= ($this->ssSearchRowId != '') ? $this->ssSearchRowId : ( $this->getUser()->getAttribute('gr_row') != '' ? $this->getUser()->getAttribute('gr_row') : '' );
		$this->ssSearchPlotId 		= ($this->ssSearchPlotId != '') ? $this->ssSearchPlotId : ( $this->getUser()->getAttribute('gr_plot') != '' ? $this->getUser()->getAttribute('gr_plot') : '' );
		
		$this->amExtraParameters['ssSearchArAreaId']   	= $this->ssSearchAreaId  		= ( $this->ssSearchAreaId != '') ? $this->ssSearchAreaId : '';
		$this->amExtraParameters['ssSearchArSectionId']   = $this->ssSearchSectionId  	= ( $this->ssSearchSectionId != '') ? $this->ssSearchSectionId : '';
		$this->amExtraParameters['ssSearchArRowId']   	= $this->ssSearchRowId  		= ( $this->ssSearchRowId != '') ? $this->ssSearchRowId : '';
		$this->amExtraParameters['ssSearchArPlotId']   	= $this->ssSearchPlotId  		= ( $this->ssSearchPlotId != '') ? $this->ssSearchPlotId : '';
		
		$this->amExtraParameters['ssSearchArGraveStatusId']   	= $this->ssSearchArGraveStatusId = trim($omRequest->getParameter('searchArGraveStatusId',''));
		$this->amExtraParameters['ssSearchArGraveStatusId'] = ($this->ssSearchArGraveStatusId != '') ? $this->ssSearchArGraveStatusId : ( $this->getUser()->getAttribute('gr_gstatus') != '' ? $this->getUser()->getAttribute('gr_gstatus') : '');

        $this->amExtraParameters['ssSearchGraveNumber'] = $this->ssSearchGraveNumber	= trim($omRequest->getParameter('searchGraveNumber',''));
		$this->amExtraParameters['ssSearchGraveNumber'] = ($this->ssSearchGraveNumber != '') ? $this->ssSearchGraveNumber : ( $this->getUser()->getAttribute('gr_grave') != '' ? $this->getUser()->getAttribute('gr_grave') : '');
		
        $this->amExtraParameters['ssSortBy']        = $this->ssSortBy       = $omRequest->getParameter('sortby','id');
        $this->amExtraParameters['ssSortMode']      = $this->ssSortMode     = $omRequest->getParameter('sortmode','desc');

        $this->ssSortQuerystr = $this->ssQuerystr = 'page='.$this->snPage.'&paging='.$this->snPaging;

		if($this->ssSearchCountryId != '' )        // Search parameters
        {
            $this->ssQuerystr    .= '&searchCountryId='.$this->ssSearchCountryId;
            $this->ssSortQuerystr.= '&searchCountryId='.$this->ssSearchCountryId;
        }
		if($this->ssSearchCemeteryId != '' )        // Search parameters
        {
            $this->ssQuerystr    .= '&searchCemCemeteryId='.$this->ssSearchCemeteryId;
            $this->ssSortQuerystr.= '&searchCemCemeteryId='.$this->ssSearchCemeteryId;
        }
		if($this->ssSearchAreaId != '' )        // Search parameters
        {
            $this->ssQuerystr    .= '&searchArAreaId='.$this->ssSearchAreaId;
            $this->ssSortQuerystr.= '&searchArAreaId='.$this->ssSearchAreaId;
        }
		if($this->ssSearchSectionId != '' )        // Search parameters
        {
            $this->ssQuerystr    .= '&searchArSectionId='.$this->ssSearchSectionId;
            $this->ssSortQuerystr.= '&searchArSectionId='.$this->ssSearchSectionId;
        }
		if($this->ssSearchRowId != '' )        // Search parameters
        {
            $this->ssQuerystr    .= '&searchArRowId='.$this->ssSearchRowId;
            $this->ssSortQuerystr.= '&searchArRowId='.$this->ssSearchRowId;
        }
        if($this->ssSearchPlotId != '' )        // Search parameters
        {
            $this->ssQuerystr    .= '&searchArPlotId='.$this->ssSearchPlotId;
            $this->ssSortQuerystr.= '&searchArPlotId='.$this->ssSearchPlotId;
        }
        if($this->ssSearchArGraveStatusId != '' )        // Search parameters
        {
            $this->ssQuerystr     .= '&searchArGraveStatusId='.$this->ssSearchArGraveStatusId;
            $this->ssSortQuerystr .= '&searchArGraveStatusId='.$this->ssSearchArGraveStatusId;
        }        
        
		 if($this->ssSearchGraveNumber != '' )        // Search parameters
        {
            $this->ssQuerystr    .= '&searchGraveNumber='.$this->ssSearchGraveNumber;
            $this->ssSortQuerystr.= '&searchGraveNumber='.$this->ssSearchGraveNumber;
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
		if($request->isMethod('post') && $request->getParameter('request_type') == 'ajax_request')
		{
			$ssSearchCountryId  = trim($request->getParameter('searchCountryId',''));
			$ssSearchCemeteryId = trim($request->getParameter('searchCemCemeteryId',''));
			$ssSearchAreaId 	= trim($request->getParameter('searchArAreaId',''));
			$ssSearchSectionId  = trim($request->getParameter('searchArSectionId',''));
			$ssSearchRowId 		= trim($request->getParameter('searchArRowId',''));
			$ssSearchPlotId		= trim($request->getParameter('searchArPlotId',''));
			$ssGraveNumber		= trim($request->getParameter('searchGraveNumber',''));
			$ssGraveStatus		= trim($request->getParameter('searchArGraveStatusId',''));
			
			$this->getUser()->setAttribute('gr_country', $ssSearchCountryId);
			$this->getUser()->setAttribute('gr_cemetery', $ssSearchCemeteryId);
			$this->getUser()->setAttribute('gr_area', ($ssSearchAreaId != '') ? $ssSearchAreaId : '');
			$this->getUser()->setAttribute('gr_section', ($ssSearchSectionId != '') ? $ssSearchSectionId : '');
			$this->getUser()->setAttribute('gr_row', ($ssSearchRowId != '') ? $ssSearchRowId : '');
			$this->getUser()->setAttribute('gr_plot', ($ssSearchPlotId != '') ? $ssSearchPlotId : '');
			$this->getUser()->setAttribute('gr_grave', ($ssGraveNumber != '') ? $ssGraveNumber : '');
			$this->getUser()->setAttribute('gr_gstatus', ($ssGraveStatus != '') ? $ssGraveStatus : '');
		}

		// For get Country list to fill Country Combo.
		$this->asCountryList = array();
		$omCriteria = Doctrine::getTable('Country')->getCountryList(array(),array());
		$amCountry = $omCriteria->orderBy('sf.name')->fetchArray();
		if(count($amCountry) > 0)
		{
			foreach($amCountry as $asDataSet)
				$this->asCountryList[$asDataSet['id']] = $asDataSet['name'];
		}

		$this->asStatusList = Doctrine::getTable('ArGraveStatus')->getGraveStatus();

		
        //set search combobox field
        $this->amSearch = array(								
								'ar_area_id' => array(
												'caption'	=> __('Area'),
												'id'		=> 'ArAreaId',
												'type'		=> 'selectajax',
												'ssPartial' => 'getCustomAreaList',
												'ssArrayKey' => 'asAreaList',
												'ssArrayValue' 	=> 'snAreaId',
												'options'	=> array()
											),
								'ar_section_id' => array(
												'caption'	=> __('Section'),
												'id'		=> 'ArSectionId',
												'type'		=> 'selectajax',
												'ssPartial' => 'getCustomSectionList',
												'ssArrayKey' => 'asSectionList',
												'ssArrayValue' 	=> 'snSectionId',
												'options'	=> array()
											),
								'ar_row_id' => array(
												'caption'	=> __('Row'),
												'id'		=> 'ArRowId',
												'type'		=> 'selectajax',
												'ssPartial' => 'getCustomRowList',
												'ssArrayKey' => 'asRowList',
												'ssArrayValue' 	=> 'snRowId',
												'options'	=> array()
											),
								'ar_plot_id' => array(
												'caption'	=> __('Plot'),
												'id'		=> 'ArPlotId',
												'type'		=> 'selectajax',
												'ssPartial' => 'getCustomPlotList',
												'ssArrayKey' => 'asPlotList',
												'ssArrayValue' 	=> 'snPlotId',
												'options'	=> array()
											),
								'ar_grave_status_id' => array(
												'caption'	=> __('Status'),
												'id'		=> 'ArGraveStatusId',
												'type'		=> 'select',
												'options'	=> array('' => __('Select Status')) + $this->asStatusList
											),
								'grave_number' => array(
												'caption'	=> __('Grave Number'),
												'id'		=> 'GraveNumber',
												'type'		=> 'text',
											)								
							);
		if($this->getUser()->isSuperAdmin())
		{
			$this->amSearch = array(
								'country_id' => array(
												'caption'	=> __('Country'),
												'id'		=> 'CountryId',
												'type'		=> 'selectcountry',
												'options'	=> $this->asCountryList
											),
								'cem_cemetery_id' => array(
												'caption'	=> __('Cemetery'),
												'id'		=> 'CemCemeteryId',
												'type'		=> 'selectajax',
												'ssPartial' => 'getCustomCementeryList',
												'ssArrayKey' => 'asCementryList',
												'ssArrayValue' 	=> 'snCementeryId',
												'options'	=> array()
											)															
							) + $this->amSearch;
		}
        $omCommon = new common();

        if($request->getParameter('admin_act') == "delete" && $request->getParameter('id'))            
        {
			// FOR UPDATE user_id WHO DELETE THE RECORDS.
			$omCommon->UpdateStatusComposite('ArGrave','user_id', $request->getParameter('id'), $this->getUser()->getAttribute('userid'), 'id');

            $omCommon->DeleteRecordsComposite('ArGrave', $request->getParameter('id'),'id');
            $this->getUser()->setFlash('snSuccessMsgKey', 3);      
        }

        // Get cms page list for listing.
        $oArGravePageListQuery = Doctrine::getTable('ArGrave')->getGraveList($this->amExtraParameters, $this->amSearch);

		// Replace Doctrine Pager Count Query By Mannual Count Query.
		$ssCountQuery = Doctrine::getTable('ArGrave')->getGraveListCount($this->amExtraParameters, $this->amSearch);

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
		//exec('rm -fR '.sfConfig::get('sf_upload_dir').'/'.sfConfig::get('app_graveimages_dir'));exit;
        
		$snIdGrave = $oRequest->getParameter('id', '');
        $ssSuccessKey   = 4; // Success message key for add

        $this->snCementeryId = $oRequest->getParameter('grave_cem_cemetery_id', '');
        $this->snAreaId = $oRequest->getParameter('grave_ar_area_id', '');
        $this->snSectionId = $oRequest->getParameter('grave_ar_section_id', '');
        $this->snRowId = $oRequest->getParameter('grave_ar_row_id', '');
        $this->snPlotId = $oRequest->getParameter('grave_ar_plot_id', '');
		
		$this->asCementery = $this->asAreaList = $this->asSectionList = $this->asRowList = $this->asPlotList = array();
		
        if($snIdGrave)
        {
            $this->forward404Unless($oGrave = Doctrine::getTable('ArGrave')->find($snIdGrave));
            $this->oArGraveForm = new ArGraveForm($oGrave);
            $ssSuccessKey = 2; // Success message key for edit
			
			// For get Cemetery List As per Country
			$this->asCementery = Doctrine::getTable('CemCemetery')->getAllCemeteries($oGrave->getCountryId());
			
			// For get Area List as per Cemetery
			$this->asAreaList = Doctrine::getTable('ArArea')->getAreaListAsPerCemetery($oGrave->getCountryId(),$oGrave->getCemCemeteryId());

			// For get Section List as per area
			$this->asSectionList = Doctrine::getTable('ArSection')->getSectionListAsPerArea($oGrave->getCountryId(),$oGrave->getCemCemeteryId(),$oGrave->getArAreaId());

			// For get Row List as per section
			$this->asRowList = Doctrine::getTable('ArRow')->getRowListAsPerSection($oGrave->getCountryId(),$oGrave->getCemCemeteryId(),$oGrave->getArAreaId(),$oGrave->getArSectionId());
			
			// For get Plot List as per Row
			$this->asPlotList = Doctrine::getTable('ArPlot')->getPlotListAsPerArea($oGrave->getCountryId(),$oGrave->getCemCemeteryId(),$oGrave->getArAreaId(),$oGrave->getArSectionId(),$oGrave->getArRowId());

			$this->snCementeryId = ($this->snCementeryId != '') ? $this->snCementeryId : $oGrave->getCemCemeteryId();
			$this->snAreaId = ($this->snAreaId != '') ? $this->snAreaId : $oGrave->getArAreaId();
			$this->snSectionId = ($this->snSectionId != '') ? $this->snSectionId : $oGrave->getArSectionId();
			$this->snRowId = ($this->snRowId != '') ? $this->snRowId : $oGrave->getArRowId();
			$this->snPlotId = ($this->snPlotId != '') ? $this->snPlotId : $oGrave->getArPlotId();
        }
        else
            $this->oArGraveForm = new ArGraveForm();

        $this->getConfigurationFields($this->oArGraveForm);

		$amGraveFormRequest = $oRequest->getParameter($this->oArGraveForm->getName());
		$this->snCementeryId = isset($amGraveFormRequest['cem_cemetery_id']) ? $amGraveFormRequest['cem_cemetery_id'] : $this->snCementeryId;

		if($amGraveFormRequest['country_id'] != '')
			$this->asCementery = Doctrine::getTable('CemCemetery')->getAllCemeteries($amGraveFormRequest['country_id']);
		if($this->snCementeryId != '' && $amGraveFormRequest['country_id'] != '')
			$this->asAreaList = Doctrine::getTable('ArArea')->getAreaListAsPerCemetery($amGraveFormRequest['country_id'], $this->snCementeryId);
		if($amGraveFormRequest['country_id'] != '' && $this->snCementeryId != '')
			$this->asSectionList = Doctrine::getTable('ArSection')->getSectionListAsPerArea($amGraveFormRequest['country_id'], $this->snCementeryId, $this->snAreaId);
		if($amGraveFormRequest['country_id'] != '' && $this->snCementeryId != '')
			$this->asRowList = Doctrine::getTable('ArRow')->getRowListAsPerSection($amGraveFormRequest['country_id'], $this->snCementeryId, $this->snAreaId, $this->snSectionId);
		if($amGraveFormRequest['country_id'] != '' && $this->snCementeryId != '')
			$this->asPlotList = Doctrine::getTable('ArPlot')->getPlotListAsPerArea($amGraveFormRequest['country_id'],$this->snCementeryId,$this->snAreaId,$this->snSectionId,$this->snRowId);

        if($oRequest->isMethod('post'))
        {
			$amGraveFileRequest = $oRequest->getFiles($this->oArGraveForm->getName());
			
            $this->oArGraveForm->bind($amGraveFormRequest,$amGraveFileRequest);
			
			$bSelectCemetery = false;
			if($this->getUser()->isSuperAdmin())
			{
				if($oRequest->getParameter('grave_cem_cemetery_id') != '')
					$bSelectCemetery = true;
			}
			else
				$bSelectCemetery = true;
			
			// Check Valid Grantee unique id.
			$bValidGranteeUniqueId = true;
			if(isset($amGraveFormRequest['grantee_unique_id']) && trim($amGraveFormRequest['grantee_unique_id']) != '')
			{
				$bValidGranteeUniqueId = false;
				$oGranteeDetails = Doctrine::getTable('GranteeDetails')->findOneByGranteeUniqueId($amGraveFormRequest['grantee_unique_id']);
				if($oGranteeDetails)
					$bValidGranteeUniqueId = true;
			}
            if($this->oArGraveForm->isValid() && $bSelectCemetery && $bValidGranteeUniqueId)
            {
				$ssFileName1 = $ssFileName2 = '';

				// For Create grave images amd thumbnail directory if not exists
				sfGeneral::createDirectory(sfConfig::get('sf_upload_dir').'/'.sfConfig::get('app_graveimages_dir'));
				sfGeneral::createDirectory(sfConfig::get('sf_upload_dir').'/'.sfConfig::get('app_graveimages_thumbnail_dir'));

				// For Upload Grave Image 1.
				$oImage1 = $this->oArGraveForm->getValue('grave_image1');
				if(!empty($oImage1))
				{
					// Remove old Image while upload new grave image1
					if(isset($oGrave))
					{
						if($oGrave->getGraveImage1() != '')
						{					
							sfGeneral::removeFile(sfConfig::get('sf_upload_dir').'/'.sfConfig::get('app_graveimages_dir').'/'.$oGrave->getGraveImage1());
							sfGeneral::removeFile(sfConfig::get('sf_upload_dir').'/'.sfConfig::get('app_graveimages_thumbnail_dir').'/'.$oGrave->getGraveImage1());
						}
					}
					// For Upload Grave Image 2.
					$ssFileName1 = $snIdGrave.'_'.uniqid().'_'.sha1($oImage1->getOriginalName());
					$amExtension = explode('.',$oImage1->getOriginalName());
					$ssExtentions =  ((count($amExtension) > 0) ? '.'.end($amExtension) : '');

					$ssFileName1 = $ssFileName1.$ssExtentions;
					$ssFileType = $oImage1->getType();
					$oImage1->save(sfConfig::get('sf_upload_dir').'/'.sfConfig::get('app_graveimages_dir').'/'.$ssFileName1);			
					
					// For Make Thumbnail of Image 1.
					sfGeneral::generateThumbNail(sfConfig::get('app_grave_thumb_width'),sfConfig::get('app_grave_thumb_height'),sfConfig::get('sf_upload_dir').'/'.sfConfig::get('app_graveimages_dir'),sfConfig::get('sf_upload_dir').'/'.sfConfig::get('app_graveimages_thumbnail_dir'),$ssFileName1,$ssFileType);
				}
				
				// For Upload Grave Image 2.
				$oImage2 = $this->oArGraveForm->getValue('grave_image2');
				if(!empty($oImage2))
				{
					// Remove old Image while upload new grave image 2.
					if(isset($oGrave))
					{
						if($oGrave->getGraveImage2() != '')
						{					
							sfGeneral::removeFile(sfConfig::get('sf_upload_dir').'/'.sfConfig::get('app_graveimages_dir').'/'.$oGrave->getGraveImage2());
							sfGeneral::removeFile(sfConfig::get('sf_upload_dir').'/'.sfConfig::get('app_graveimages_thumbnail_dir').'/'.$oGrave->getGraveImage2());
						}
					}

					// For Upload Grave Image 1.
					$ssFileName2 = $snIdGrave.'_'.uniqid().'_'.sha1($oImage2->getOriginalName());
					$amExtension = explode('.',$oImage2->getOriginalName());
					$ssExtentions =  ((count($amExtension) > 0) ? '.'.end($amExtension) : '');
					
					$ssFileName2 = $ssFileName2.$ssExtentions;					
					$ssFileType = $oImage2->getType();
					$oImage2->save(sfConfig::get('sf_upload_dir').'/'.sfConfig::get('app_graveimages_dir').'/'.$ssFileName2);
					
					// For Make Thumbnail of Image 1.
					sfGeneral::generateThumbNail(sfConfig::get('app_grave_thumb_width'),sfConfig::get('app_grave_thumb_height'),sfConfig::get('sf_upload_dir').'/'.sfConfig::get('app_graveimages_dir'),sfConfig::get('sf_upload_dir').'/'.sfConfig::get('app_graveimages_thumbnail_dir'),$ssFileName2,$ssFileType);
				}
				
				$omGrave = $this->oArGraveForm->save();		
				$snIdGrave = $omGrave->getId();
				
				// For update grave images name
				if( !empty($oImage1) || !empty($oImage2) )
					ArGrave::updateGraveImageName($snIdGrave,$ssFileName1,$ssFileName2);

				// If Grantee Unique is valid then insert grave details into grantee table.
				if($this->oArGraveForm->isNew())
				{
					if(trim($amGraveFormRequest['grantee_unique_id']) != '')
					{
						$amGranteeData = array('grantee_id'	=> $oGranteeDetails->getId(),
										  'country_id' 		=> $omGrave->getCountryId(),
										  'cemetery_id' 	=> $omGrave->getCemCemeteryId(),
										  'area_id' 		=> $omGrave->getArAreaId(),
										  'section_id' 		=> $omGrave->getArSectionId(),
										  'row_id' 			=> $omGrave->getArRowId(),
										  'plot_id' 		=> $omGrave->getArPlotId(),
										  'grave_id'		=> $omGrave->getId(),
										  'user_id'			=> $this->getUser()->getAttribute('userid')
										);
										
						// Insert Grave Details Grantee table.
						Grantee::saveGranteeRecords($amGranteeData);
					}
				}				
                $this->getUser()->setFlash('snSuccessMsgKey', $ssSuccessKey);   //Set messages for add and update records

				if($oRequest->getParameter('back') == true) {
					$this->redirect('gravesearch/addedit?back=true');
				}else {
					$this->redirect('grave/index?'.$this->amExtraParameters['ssQuerystr']);
				}
            }
			else
			{
				if(!$bSelectCemetery)
					$this->getUser()->setFlash('ssErrorCemeter',__('Please select cemetery'));
				
				if(!$bValidGranteeUniqueId)
					$this->getUser()->setFlash('ssErrorGranteeNotExists', __('Grantee unique ID does not exists'));
			}
        }
    }
	/**
    * update action
    *
    * Update import greave pages   
    * @access public
    * @param  object $oRequest A request object
    *     
    */
    public function executeImportGraves(sfWebRequest $oRequest)
    {
		if($this->getUser()->hasCredential('cemadmin'))
		{
			$snIdGrave = $oRequest->getParameter('id', '');
			$ssSuccessKey   = 5; // Success message key for add
	
			$this->snCementeryId = $oRequest->getParameter('grave_cem_cemetery_id', '');
			$this->snAreaId = $oRequest->getParameter('grave_ar_area_id', '');
			$this->snSectionId = $oRequest->getParameter('grave_ar_section_id', '');
			$this->snRowId = $oRequest->getParameter('grave_ar_row_id', '');
			$this->snPlotId = $oRequest->getParameter('grave_ar_plot_id', '');
			
			$this->asCementery = $this->asAreaList = $this->asSectionList = $this->asRowList = $this->asPlotList = array();
			
			 $this->oImportGraveForm = new ImportGraveForm();
			 
			 $this->getConfigurationFields($this->oImportGraveForm);
	
			$amGraveFormRequest = $oRequest->getParameter($this->oImportGraveForm->getName());
			$this->snCementeryId = isset($amGraveFormRequest['cem_cemetery_id']) ? $amGraveFormRequest['cem_cemetery_id'] : $this->snCementeryId;
	
			if($amGraveFormRequest['country_id'] != '')
				$this->asCementery = Doctrine::getTable('CemCemetery')->getAllCemeteries($amGraveFormRequest['country_id']);
			if($this->snCementeryId != '' && $amGraveFormRequest['country_id'] != '')
				$this->asAreaList = Doctrine::getTable('ArArea')->getAreaListAsPerCemetery($amGraveFormRequest['country_id'], $this->snCementeryId);
			if($amGraveFormRequest['country_id'] != '' && $this->snCementeryId != '')
				$this->asSectionList = Doctrine::getTable('ArSection')->getSectionListAsPerArea($amGraveFormRequest['country_id'], $this->snCementeryId, $this->snAreaId);
			if($amGraveFormRequest['country_id'] != '' && $this->snCementeryId != '')
				$this->asRowList = Doctrine::getTable('ArRow')->getRowListAsPerSection($amGraveFormRequest['country_id'], $this->snCementeryId, $this->snAreaId, $this->snSectionId);
			if($amGraveFormRequest['country_id'] != '' && $this->snCementeryId != '')
				$this->asPlotList = Doctrine::getTable('ArPlot')->getPlotListAsPerArea($amGraveFormRequest['country_id'],$this->snCementeryId,$this->snAreaId,$this->snSectionId,$this->snRowId);
				
			if($oRequest->isMethod('post'))
			{
				$amGraveFileRequest = $oRequest->getFiles($this->oImportGraveForm->getName());
				
				$this->oImportGraveForm->bind($amGraveFormRequest,$amGraveFileRequest);
				
				$bSelectCemetery = false;
				if($this->getUser()->isSuperAdmin())
				{
					if($oRequest->getParameter('grave_cem_cemetery_id') != '')
						$bSelectCemetery = true;
				}
				else
					$bSelectCemetery = true;
				
				// Check Valid Grantee unique id.
				$bValidGranteeUniqueId = true;
				if(trim($amGraveFormRequest['grantee_unique_id']) != '')
				{
					$bValidGranteeUniqueId = false;
					$oGranteeDetails = Doctrine::getTable('GranteeDetails')->findOneByGranteeUniqueId($amGraveFormRequest['grantee_unique_id']);
					if($oGranteeDetails)
						$bValidGranteeUniqueId = true;
				}
				if($this->oImportGraveForm->isValid() && $bSelectCemetery && $bValidGranteeUniqueId)
				{
					// For Save records.	
					$snCemeteryId = (sfContext::getInstance()->getUser()->isSuperAdmin()) ? $oRequest->getParameter('grave_cem_cemetery_id') : $amGraveFormRequest['cem_cemetery_id'];
					$snAreaId = ($oRequest->getParameter('grave_ar_area_id') != '') ? $oRequest->getParameter('grave_ar_area_id') : NULL;
					$snSectionId = ($oRequest->getParameter('grave_ar_section_id') != '') ? $oRequest->getParameter('grave_ar_section_id') : NULL;
					$snRowId = ($oRequest->getParameter('grave_ar_row_id') != '') ? $oRequest->getParameter('grave_ar_row_id') : NULL;
					$snPlotId = ($oRequest->getParameter('grave_ar_plot_id') != '') ? $oRequest->getParameter('grave_ar_plot_id') : NULL;
	
					$snStartGraveNumber = $amGraveFormRequest['grave_number_start'];
					$snEndingGraveNumber = $amGraveFormRequest['grave_number_end'];
					
					$ssZeros = $snStart = '';
					for($snI=0;$snI<strlen($snStartGraveNumber);$snI++)
					{
						if($snStartGraveNumber[$snI] > 0)
							break;
						else
							$ssZeros .= 0;
					}
					$bFirst = true;
					for($snI=$snStartGraveNumber;$snI<=$snEndingGraveNumber;$snI++)
					{
						$snGraveNumber = ($bFirst) ? $snI : $ssZeros.$snI;
						$amImportData = array('country_id' 		=> $amGraveFormRequest['country_id'],
											  'cemetery_id' 	=> $snCemeteryId,
											  'area_id' 		=> $snAreaId,
											  'section_id' 		=> $snSectionId,
											  'row_id' 			=> $snRowId,
											  'plot_id' 		=> $snPlotId,
											  'grave_number'	=> $snGraveNumber,
											  'ar_grave_status_id'	=> $amGraveFormRequest['ar_grave_status_id'],
											  'length' 			=> $amGraveFormRequest['length'],
											  'width' 			=> $amGraveFormRequest['width'],
											  'height' 			=> $amGraveFormRequest['height'],
											  'unit_type_id' 	=> $amGraveFormRequest['unit_type_id'],
											  'details' 		=> $amGraveFormRequest['details'],
											  'enabled' 		=> $amGraveFormRequest['is_enabled'],
											  'user_id' 		=> $this->getUser()->getAttribute('userid')
											);
	
						// Save Import grave data into db.
						$oGrave = ArGrave::saveImportGraves($amImportData);
						
						if(trim($amGraveFormRequest['grantee_unique_id']) != '' && $oGranteeDetails)
						{
							$amGranteeData = array('grantee_id'	=> $oGranteeDetails->getId(),
											  'country_id' 		=> $oGrave->getCountryId(),
											  'cemetery_id' 	=> $oGrave->getCemCemeteryId(),
											  'area_id' 		=> $oGrave->getArAreaId(),
											  'section_id' 		=> $oGrave->getArSectionId(),
											  'row_id' 			=> $oGrave->getArRowId(),
											  'plot_id' 		=> $oGrave->getArPlotId(),
											  'grave_id'		=> $oGrave->getId(),
											  'user_id'			=> $this->getUser()->getAttribute('userid')
											);
											
							// Insert Grave Details Grantee table.
							Grantee::saveGranteeRecords($amGranteeData);
						}
						unset($oGrave);
						$bFirst = false;
					}
	
					$this->getUser()->setFlash('snSuccessMsgKey', $ssSuccessKey);   //Set messages for add and update records
	
					$this->redirect('grave/index?'.$this->amExtraParameters['ssQuerystr']);
				}
				else
				{
					if(!$bSelectCemetery)
						$this->getUser()->setFlash('ssErrorCemeter',__('Please select cemetery'));
					
					if(!$bValidGranteeUniqueId)
						$this->getUser()->setFlash('ssErrorGranteeNotExists', __('Grantee unique ID does not exists'));
				}
			}
		}
		else
			$this->redirect('default/secure');
			
	}
	/**
    * Executes purchaseGrave action
    *
    * @access public
    * @param sfRequest $request A request object
    */
    public function executePurchaseGrave(sfWebRequest $oRequest)
    {
		$snGraveId = $oRequest->getParameter('id','');
		$ssSuccessKey   = 4; // Success message key for insert grave details in grantee table
		
		$this->oPurchaseGraveForm = new PurchaseGraveForm();

		$this->getConfigurationFieldsForPurchaseGrave($this->oPurchaseGraveForm);
		if($oRequest->isMethod('post'))
        {
			$amPurchaseGraveFormRequest = $oRequest->getParameter($this->oPurchaseGraveForm->getName());
			$this->oPurchaseGraveForm->bind($amPurchaseGraveFormRequest);
						
			if($this->oPurchaseGraveForm->isValid())
			{
				$oGranteeDetails = Doctrine::getTable('GranteeDetails')->findOneByGranteeUniqueId($amPurchaseGraveFormRequest['grantee_unique_id']);
				$oGrave = Doctrine::getTable('ArGrave')->find($snGraveId);

				if($oGranteeDetails)
				{
					$ssPurchaseDate = $amPurchaseGraveFormRequest['purchase_date'];
					$ssPurchaseDate = ($ssPurchaseDate != '' && $ssPurchaseDate != '00-00-0000') ? (date("Y-m-d",strtotime($ssPurchaseDate))) : '';

					$ssTenureExpiryDate = $amPurchaseGraveFormRequest['tenure_expiry_date'];
					$ssTenureExpiryDate = ($ssTenureExpiryDate != '' && $ssTenureExpiryDate != '00-00-0000') ? (date("Y-m-d",strtotime($ssTenureExpiryDate))) : '';

					$amGranteeData = array('grantee_id'		=> $oGranteeDetails->getId(),
										  'country_id' 		=> $oGrave->getCountryId(),
										  'cemetery_id' 	=> $oGrave->getCemCemeteryId(),
										  'area_id' 		=> $oGrave->getArAreaId(),
										  'section_id' 		=> $oGrave->getArSectionId(),
										  'row_id' 			=> $oGrave->getArRowId(),
										  'plot_id' 		=> $oGrave->getArPlotId(),
										  'grave_id'		=> $oGrave->getId(),
										  'date_of_purchase' => $ssPurchaseDate,
										  'tenure_expiry_date' => $ssTenureExpiryDate,
										  'grantee_identity_id' => $amPurchaseGraveFormRequest['grantee_identity_id'],
										  'grantee_identity_number' => $amPurchaseGraveFormRequest['grantee_identity_number'],
										  'user_id'			=> $this->getUser()->getAttribute('userid')
										);

					// Insert Grave Details Grantee table.
					Grantee::saveGranteeRecords($amGranteeData);
					
					$this->getUser()->setFlash('snSuccessMsgKey', $ssSuccessKey);   //Set messages for add and update records
					echo "<script type='text/javascript'>";
					echo "document.location.href='".url_for('grave/showGrantees?grave_id='.$snGraveId)."';";
					echo "</script>";exit;
				}
				else
				{
					if(!$oGranteeDetails)
						$this->getUser()->setFlash('ssErrorGranteeNotExists', __('Grantee unique ID does not exists'));
				}
			}

			if($oRequest->getParameter('request_type') == 'ajax_request')
	            return $this->renderPartial('purchaseGrave', array('oPurchaseGraveForm' => $this->oPurchaseGraveForm,
																	'amExtraParameters'	=> $this->amExtraParameters));
		}        
	}
	/**
    * Executes showAllGrantee action
    *
    * @access public
    * @param sfRequest $request A request object
    */
	public function executeShowAllGrantee(sfWebRequest $request)
	{
		$snGraveId = $request->getParameter('id','');
		
		$amGranteeGraveDetails = Doctrine::getTable('ArGrave')->getAllGranteeAsPerGrave($snGraveId);

		if(count($amGranteeGraveDetails) > 0)
		{
			// pdf object
			$oPDF = new sfTCPDF();
			
			// set document information
			$oPDF->SetCreator(PDF_CREATOR);
			$oPDF->SetAuthor('Cemetery');
			$oPDF->SetTitle('Grantee Grave Details');
			$oPDF->SetSubject('Grantee Grave Details');
			$oPDF->SetKeywords('Grantee, Grave');
			
			// set default header data
			$oPDF->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 001', PDF_HEADER_STRING);
			
			// set header and footer fonts
			$oPDF->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
			$oPDF->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
			
			// set default monospaced font
			$oPDF->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
			

			//set margins
			$oPDF->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
			$oPDF->SetHeaderMargin(PDF_MARGIN_HEADER);
			$oPDF->SetFooterMargin(PDF_MARGIN_FOOTER);
			
			//set auto page breaks
			$oPDF->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
			
			// Add a page
			// This method has several options, check the source code documentation for more information.
			$oPDF->AddPage();
			
			
			$oPDF->writeHTMLCell($w=0, $h=0, $x='70', $y='35', '<b>GRAVE BURIAL LICENCE CERTIFICATE</b>', 0, 1, 0, true, '', true);
			
			
			$oPDF->SetFont('helvetica', 'I', 10, '', true);		
			$oPDF->setY('50');	
			
			$snCemeteryId = $this->getUser()->getAttribute('cemeteryid');
			// Get mail content
			$amMailContent = Doctrine::getTable('MailContent')->getMailContentAsPerType('grave_licence_certificate', $snCemeteryId);
			$ssGraveResults = '';
			$ssGraveResults .= '<table width="100%" cellpadding="3" cellspacing="0" border="01">';
	        $ssGraveResults .= '<tr>';
		    $ssGraveResults .= '<td><b>'.__('Grantee').'</b></td>';
		    $ssGraveResults .= '<td><b>'.__('Section').'</b></td>';
		    $ssGraveResults .= '<td><b>'.__('Status').'</b></td>';
		    $ssGraveResults .= '<td><b>'.__('Date of Purchase').'</b></td>';
	        $ssGraveResults .= '</tr>';
	        foreach( $amGranteeGraveDetails[0]['Grantee'] as $asValues){
		        $ssGraveResults .= '<tr>';
			    $ssGraveResults .= '<td>';
				$ssGraveResults .= (( $asValues['GranteeDetails']['title'] != '' ) ? $asValues['GranteeDetails']['title'].'&nbsp;'.$asValues['GranteeDetails']['grantee_name'] : $asValues['GranteeDetails']['grantee_name']);
				$ssGraveResults .= '</td>';
			    $ssGraveResults .= '<td>'.(($amGranteeGraveDetails[0]['section_name'] != '') ? $amGranteeGraveDetails[0]['section_name'] : 'N/A').'</td>';
			    $ssGraveResults .= '<td>'.$amGranteeGraveDetails[0]['grave_status'].'</td>';
			    $ssGraveResults .= '<td>';
                list($snYear,$snMonth,$snDay) = explode('-',$asValues['date_of_purchase']);
				$ssGraveResults .= $snDay.'-'.$snMonth.'-'.$snYear;
    			$ssGraveResults .= '</td>';
		        $ssGraveResults .= '</tr>';
	        }
            $ssGraveResults .= '</table>';

            // Replace parameter with value
			$amMailParams = array(
			    '{GRAVE_NUMBER}' => $amGranteeGraveDetails[0]['grave_number'],
			    '{GRAVE_RESULTS}' => $ssGraveResults
            );
            
            // Set some content to print
			$ssHTML = sfGeneral::replaceMailContent($amMailContent[0]['content'], $amMailParams);
			
			$ssFileName = 'print_all_grantee';
			// Print text using writeHTML()
			$oPDF->writeHTML($ssHTML);
			
			// Close and output PDF document
			// This method has several options, check the source code documentation for more information.
			$oPDF->Output($ssFileName, 'I');
			
			// Stop symfony process
			throw new sfStopException();
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
		$ssRenderPartial = trim($request->getParameter('render_partial') != '') ? $request->getParameter('render_partial') : 'getCementeryList';
		$asCementery = Doctrine::getTable('CemCemetery')->getAllCemeteries($snIdCountry);

		return $this->renderPartial($ssRenderPartial, array('asCementryList' => $asCementery));
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
		$ssRenderPartial = trim($request->getParameter('render_partial') != '') ? $request->getParameter('render_partial') : 'getAreaList';
		$snCemeteryId = $request->getParameter('cemetery_id','');
		$asAreaList = Doctrine::getTable('ArArea')->getAreaListAsPerCemetery($snIdCountry, $snCemeteryId);

		return $this->renderPartial($ssRenderPartial, array('asAreaList' => $asAreaList));
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
		$ssRenderPartial = trim($request->getParameter('render_partial') != '') ? $request->getParameter('render_partial') : 'getSectionList';
		$snCemeteryId = $request->getParameter('cemetery_id','');
		$snAreaId = $request->getParameter('area_id','');
		$asSectionList = Doctrine::getTable('ArSection')->getSectionListAsPerArea($snIdCountry,$snCemeteryId,$snAreaId);

		return $this->renderPartial($ssRenderPartial, array('asSectionList' => $asSectionList));
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
		$ssRenderPartial = trim($request->getParameter('render_partial') != '') ? $request->getParameter('render_partial') : 'getRowList';
		$asRowList = Doctrine::getTable('ArRow')->getRowListAsPerSection($snIdCountry,$snCemeteryId,$snAreaId,$snSectionId);

		return $this->renderPartial($ssRenderPartial, array('asRowList' => $asRowList));
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
		$ssRenderPartial = trim($request->getParameter('render_partial') != '') ? $request->getParameter('render_partial') : 'getPlotList';
		$asPlotList = Doctrine::getTable('ArPlot')->getPlotListAsPerArea($snIdCountry,$snCemeteryId,$snAreaId,$snSectionId,$snRowId);

		return $this->renderPartial($ssRenderPartial, array('asPlotList' => $asPlotList));
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
		
		$asGraveList = Doctrine::getTable('ArGrave')->getGraveListAsPerCriteria($snIdCountry,$snCemeteryId,$snAreaId,$snSectionId,$snRowId,$snPlotId);

		return $this->renderPartial('getGraveListLink', array('asGraveList' => $asGraveList));
	}
	
	//-----------------------
	// Custom Ajax Actions
	//------------------------
	/**
    * Executes getCementryListAsPerCountry action
    *
    * @access public
    * @param sfRequest $request A request object
    */
    public function executeGetCustomCementryListAsPerCountry(sfWebRequest $request)
    {	
		$snIdCountry = $request->getParameter('id','');	
		$asCementery = Doctrine::getTable('CemCemetery')->getAllCemeteries($snIdCountry);

		return $this->renderPartial('getCustomCementeryList', array('asCementryList' => $asCementery));
	}
	/**
    * Executes getAreaListAsPerCemetery action
    *
    * @access public
    * @param sfRequest $request A request object
    */
    public function executeGetCustomAreaListAsPerCemetery(sfWebRequest $request)
    {	
		$snIdCountry = $request->getParameter('country_id','');
		$snCemeteryId = $request->getParameter('cemetery_id','');
		$asAreaList = Doctrine::getTable('ArArea')->getAreaListAsPerCemetery($snIdCountry, $snCemeteryId);

		return $this->renderPartial('getCustomAreaList', array('asAreaList' => $asAreaList));
	}
	/**
    * Executes getSectionListAsPerArea action
    *
    * @access public
    * @param sfRequest $request A request object
    */
    public function executeGetCustomSectionListAsPerArea(sfWebRequest $request)
    {	
		$snIdCountry = $request->getParameter('country_id','');
		$snCemeteryId = $request->getParameter('cemetery_id','');
		$snAreaId = $request->getParameter('area_id','');
		$asSectionList = Doctrine::getTable('ArSection')->getSectionListAsPerArea($snIdCountry,$snCemeteryId,$snAreaId);

		return $this->renderPartial('getCustomSectionList', array('asSectionList' => $asSectionList));
	}
	/**
    * Executes getRowListAsPerSection action
    *
    * @access public
    * @param sfRequest $request A request object
    */
    public function executeGetCustomRowListAsPerSection(sfWebRequest $request)
    {	
		$snIdCountry = $request->getParameter('country_id','');
		$snCemeteryId = $request->getParameter('cemetery_id','');
		$snAreaId = $request->getParameter('area_id','');
		$snSectionId = $request->getParameter('section_id','');
		$asRowList = Doctrine::getTable('ArRow')->getRowListAsPerSection($snIdCountry,$snCemeteryId,$snAreaId,$snSectionId);

		return $this->renderPartial('getCustomRowList', array('asRowList' => $asRowList));
	}
	/**
    * Executes getPlotListAsPerRow action
    *
    * @access public
    * @param sfRequest $request A request object
    */
    public function executeGetCustomPlotListAsPerRow(sfWebRequest $request)
    {	
		$snIdCountry = $request->getParameter('country_id','');
		$snCemeteryId = $request->getParameter('cemetery_id','');
		$snAreaId = $request->getParameter('area_id','');
		$snSectionId = $request->getParameter('section_id','');
		$snRowId = $request->getParameter('row_id','');
		$asPlotList = Doctrine::getTable('ArPlot')->getPlotListAsPerArea($snIdCountry,$snCemeteryId,$snAreaId,$snSectionId,$snRowId);

		return $this->renderPartial('getCustomPlotList', array('asPlotList' => $asPlotList));
	}
	/**
    * Executes showGrantees action
    *
    * @access public
    * @param sfRequest $request A request object
    */
    public function executeShowGrantees(sfWebRequest $request)
    {
		$this->amSearch = array();
		$this->snIdGrave = trim($request->getParameter('grave_id',''));

		$omCommon = new common();
        if($request->getParameter('admin_act') == "delete" && $request->getParameter('id'))            
        {
			// FOR UPDATE user_id FOR WHO DELETE THE RECORDS.
			$omCommon->UpdateStatusComposite('Grantee','user_id', $request->getParameter('id'), $this->getUser()->getAttribute('userid'), 'id');
			
            $omCommon->DeleteRecordsComposite('Grantee', $request->getParameter('id'),'id');
            $this->getUser()->setFlash('snSuccessMsgKey', 3);
        }
		if($this->snIdGrave != '')
		{
			$oGrantee = Doctrine::getTable('Grantee')->findOneByArGraveId($this->snIdGrave);
			
			// If there is no grantee update grave status vacant for that grave.
			if(!$oGrantee)
				ArGrave::updateGraveTableField('ar_grave_status_id', sfConfig::get('app_grave_status_vacant'), $this->snIdGrave);
		}
					
		$this->amGranteesList = Doctrine::getTable('GranteeDetails')->getGranteesAsPerGrave($this->snIdGrave);
		
		 // Total number of records        
        $this->snPageTotalGrantee = count($this->amGranteesList);

        if($request->getParameter('request_type') == 'ajax_request')
            $this->setTemplate('listShowGranteeUpdate');
	}
	/**
    * Executes showGraveOnMap action
    *
    * @access public
    * @param sfRequest $request A request object
    */
    public function executeShowGraveOnMap(sfWebRequest $request)
    {
		$amGraveDetails = explode(",", base64_decode($request->getParameter('ssParams')) );
		if(count($amGraveDetails) > 0)
		{
			$this->ssCemetery 	= $amGraveDetails[0];
			$this->ssArea		= $amGraveDetails[1];
			$this->ssSection	= $amGraveDetails[2];
			$this->ssRow		= $amGraveDetails[3];
			$this->ssPlot		= $amGraveDetails[4];
			$this->ssGrave		= $amGraveDetails[5];
			$this->smLat		= $amGraveDetails[6];
			$this->smLong		= $amGraveDetails[7];
			$this->ssCemLat		= $amGraveDetails[8];
			$this->ssCemLong	= $amGraveDetails[9];			
		}
		$this->setLayout(false);
	}
	
	/**
    * Executes graveLink action
    *
    * @access public
    * @param sfRequest $request A request object
    */
    public function executeGraveLink(sfWebRequest $request)
    {
        $omCommon = new common();

        if($request->getParameter('admin_act') == "delete" && $request->getParameter('id'))            
        {
            $omCommon->DeleteRecordsComposite('GraveLink', $request->getParameter('id'), 'id');
            $this->getUser()->setFlash('snSuccessMsgKey', 3);      
        }
        
        // Get grave link list for listing.
        $oGraveLinkPageListQuery = Doctrine::getTable('GraveLink')->getGraveLinkList($this->amExtraParameters);

		// Replace Doctrine Pager Count Query By Mannual Count Query.
		$ssCountQuery = Doctrine::getTable('GraveLink')->getGraveLinkListCount($this->amExtraParameters);

        // Set pager and get results
        $oPager                = new sfMyPager();
        $this->oGraveLinkList  = $oPager->getResults('GraveLink', $this->snPaging, $oGraveLinkPageListQuery, $this->snPage, $ssCountQuery);
        $this->amGraveLinkList = $this->oGraveLinkList->getResults(Doctrine::HYDRATE_ARRAY);

        unset($oPager);

        // Total number of records        
        $this->snPageTotalGraveLinkPages = $this->oGraveLinkList->getNbResults();

        if($request->getParameter('request_type') == 'ajax_request')
            $this->setTemplate('listGraveLinkUpdate');
    }
    
    /**
    * addEditGraveLink action
    *
    * Update grave link
    * @access public
    * @param  object $oRequest A request object
    *     
    */
    public function executeAddEditGraveLink(sfWebRequest $oRequest)
    {
		$snIdGraveLink  = $oRequest->getParameter('id', '');
        $ssSuccessKey   = 4; // Success message key for add

        $this->snCementeryId = $oRequest->getParameter('grave_cem_cemetery_id', '');
        $this->snAreaId = $oRequest->getParameter('grave_ar_area_id', '');
        $this->snSectionId = $oRequest->getParameter('grave_ar_section_id', '');
        $this->snRowId = $oRequest->getParameter('grave_ar_row_id', '');
        $this->snPlotId = $oRequest->getParameter('grave_ar_plot_id', '');
        $this->snGraveId = $oRequest->getParameter('grave_ar_grave_id', '');
		$ssMode = ($snIdGraveLink != '') ? 'edit' : '';
		
		$this->asCementery = $this->asAreaList = $this->asSectionList = $this->asRowList = $this->asPlotList = $this->asGraveList = $this->anGraveIds = array();
		
        if($snIdGraveLink)
        {
            $this->forward404Unless($oGraveLink = Doctrine::getTable('GraveLink')->find($snIdGraveLink));
            $this->oGraveLinkForm = new GraveLinkForm($oGraveLink);
            $ssSuccessKey = 2; // Success message key for edit
        }
        else
            $this->oGraveLinkForm = new GraveLinkForm();

        $this->getConfigurationFieldsForGraveLink($this->oGraveLinkForm);

		$amGraveLinkFormRequest = $oRequest->getParameter($this->oGraveLinkForm->getName());
		$this->snCementeryId = isset($amGraveLinkFormRequest['cem_cemetery_id']) ? $amGraveLinkFormRequest['cem_cemetery_id'] : $this->snCementeryId;

		if($amGraveLinkFormRequest['country_id'] != '')
			$this->asCementery = Doctrine::getTable('CemCemetery')->getAllCemeteries($amGraveLinkFormRequest['country_id']);
		if($this->snCementeryId != '' && $amGraveLinkFormRequest['country_id'] != '')
			$this->asAreaList = Doctrine::getTable('ArArea')->getAreaListAsPerCemetery($amGraveLinkFormRequest['country_id'], $this->snCementeryId);
		if($amGraveLinkFormRequest['country_id'] != '' && $this->snCementeryId != '')
			$this->asSectionList = Doctrine::getTable('ArSection')->getSectionListAsPerArea($amGraveLinkFormRequest['country_id'], $this->snCementeryId, $this->snAreaId);
		if($amGraveLinkFormRequest['country_id'] != '' && $this->snCementeryId != '')
			$this->asRowList = Doctrine::getTable('ArRow')->getRowListAsPerSection($amGraveLinkFormRequest['country_id'], $this->snCementeryId, $this->snAreaId, $this->snSectionId);
		if($amGraveLinkFormRequest['country_id'] != '' && $this->snCementeryId != '')
			$this->asPlotList = Doctrine::getTable('ArPlot')->getPlotListAsPerArea($amGraveLinkFormRequest['country_id'],$this->snCementeryId,$this->snAreaId,$this->snSectionId,$this->snRowId);
        if($amGraveLinkFormRequest['country_id'] != '' && $this->snCementeryId != '')
			$this->asGraveList = Doctrine::getTable('ArGrave')->getGraveListAsPerCriteria($amGraveLinkFormRequest['country_id'],$this->snCementeryId,$this->snAreaId,$this->snSectionId,$this->snRowId,$this->snPlotId);

        if($oRequest->isMethod('post'))
        {
            $this->oGraveLinkForm->bind($amGraveLinkFormRequest);
			
			$bSelectCemetery = $bSelectGrave = false;
			if($this->getUser()->isSuperAdmin())
			{
				if($oRequest->getParameter('grave_cem_cemetery_id') != '')
					$bSelectCemetery = true;
			}
			else
				$bSelectCemetery = true;
			
			if($oRequest->getParameter('grave_ar_grave_id') != '')
			    $bSelectGrave = true;
			
            if($this->oGraveLinkForm->isValid() && $bSelectCemetery && $bSelectGrave)
            {
				$omGraveLink   = $this->oGraveLinkForm->save();		
				$snIdGraveLink = $omGraveLink->getId();
				
                $this->getUser()->setFlash('snSuccessMsgKey', $ssSuccessKey);   //Set messages for add and update records

                $this->redirect('grave/graveLink?'.$this->amExtraParameters['ssQuerystr']);
            }
			else
			{
				if(!$bSelectCemetery)
					$this->getUser()->setFlash('ssErrorCemeter',__('Please select cemetery'));
                if(!$bSelectGrave)
					$this->getUser()->setFlash('ssErrorGrave',__('Please select grave'));
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
    private function getConfigurationFieldsForPurchaseGrave($oForm)
    {
		$oForm->setWidgets(array('grantee_identity_id' => __('Select Grantee Identity')));
        $oForm->setLabels(
            array(
                'grantee_unique_id'       		=> __('Grantee Unique ID'),
				'purchase_date'					=> __('Tenure From'),
				'tenure_expiry_date'			=> __('Tenure To'),
				'grantee_identity_id'			=> __('Grantee Identity'),
				'grantee_identity_number'		=> __('Grantee Identity Number')
				)
        );
        $oForm->setValidators(
            array(
    	            'grantee_unique_id'    => array(
												'required'  => __('Please select grantee unique ID')
											),
					'tenure_expiry_date' 	=> array(
												'invalid'  => __('Tenure To date must be grater than Tenure From')
												), 
				)
        );
											
	}
	
	/**
     * getConfigurationFieldsForGraveLink
     *
     * Function for prepare configuration fields for form
     * @access private
     * @param  object $oForm form object
     *     
     */
    private function getConfigurationFieldsForGraveLink($oForm)
    {
		$oForm->setWidgets(
			array(
				'country_id'		=> __('Select Country'),
				'cem_stonemason_id' => __('Select Stone Mason'),
				'cem_cemetery_id'  => __('Select Cemetery'),
            )
		);

		$oForm->setDefault('country_id', $this->getUser()->getAttribute('cn'));

        $oForm->setLabels(
            array(
                'country_id'       	=> __('Select Country'),
				'cem_stonemason_id' => __('Select Stone Mason'),
				'cem_cemetery_id'  => __('Select Cemetery'),
            )
        );

        $oForm->setValidators(
            array(
	            'cem_cemetery_id' => array('required'  => __('Please select cemetery')),
	            'country_id'      => array('required'  => __('Please select Country'))
			)
        );
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
					'cem_stonemason_id' => __('Select Stone Mason'),
					'unit_type_id' 		=> __('Select Unit Type'),
					'ar_grave_status_id' => __('Select Grave Status')
				 )
		);

        $oForm->setLabels(
            array(
                'country_id'       	=> __('Select Country'),
				'cem_cemetery_id'  => __('Select Cemetery'),
				'cem_stonemason_id' => __('Select Stone Mason'),
				'unit_type_id' 		=> __('Select Unit Type'),
                'ar_grave_status_id'  	=> __('ar_grave_status'),
                'grave_number'  	=> __('Grave Number'),
                'length'  	 		=> __('Length'),
                'width'				=> __('Width'),
                'height'  			=> __('Height'),
                'details'  			=> __('Grave Detail'),
				'latitude'  		=> __('Latitude'),
				'longitude'  		=> __('Longitude'),
                'is_enabled'   		=> __('Enabled'),
				'grave_number_start' => __('Starting Range of Grave Number'),
				'grave_number_end' 	 => __('Ending Range of Grave Number'),
				'grantee_unique_id'  => __('Grantee Unique ID'),
				
				'monuments_grave_position'	=> __('Grave Position'),
                'monument'					=> __('Monument'),
                'monuments_unit_type'		=> __('Monument Unit Type'),
                'monuments_depth'			=> __('Monument Depth'),
                'monuments_length'			=> __('Monument Length'),
                'monuments_width'			=> __('Monument Width'),
				'comment1'					=> __('Comment 1'),
				'comment2'					=> __('Comment 2')
            )
        );

        $oForm->setValidators(
            array(
					'grave_number'			=> array(
												'required'  => __('Please enter grave number')
											),
					'ar_grave_status_id'	=> array(
												'required'  => __('Please select grave status')
											),
					'grave_number_start'	=> array(
												'required'  => __('Please enter starting range of grave number')
											),
	                'grave_number_end'		=> array(
												'required'  => __('Please enter ending range of grave number'),
												'invalid'  => __('Ending range of grave number must be greater than starting range of grave number')
											),
	                'cem_stonemason_id'	=> array(
												'required'  => __('Please select stone mason')
											),
	                'grave_image1'	=> array(
												'mime_types'  => __('The file must be of BMP, GIF, JPG, PNG format')
											),
	                'grave_image2'	=> array(
												'mime_types'  => __('The file must be of BMP, GIF, JPG, PNG format')
											),
    	            'country_id'    => array(
												'required'  => __('Please select country')
											),
					'cem_cemetery_id'        => array(
														'required'  => __('Please select cemetery')
												),
				)
        );
    }
}
