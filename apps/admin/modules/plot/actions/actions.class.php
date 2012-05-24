<?php
/**
 * Plot actions.
 *
 * @package    Cemetery
 * @subpackage Plot
 * @author     Prakash Panchal
 * @author      
 *
 */
sfProjectConfiguration::getActive()->loadHelpers(array('I18N'));
class plotActions extends sfActions
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
        $this->ssFormName = 'frm_list_plot';
        $omRequest        = sfContext::getInstance()->getRequest();

        // Set default values
        $this->amExtraParameters = array();
        $this->amExtraParameters['snPaging']        = $this->snPaging       = $omRequest->getParameter('paging',sfConfig::get('app_default_paging_records'));
        $this->amExtraParameters['snPage']          = $this->snPage         = $omRequest->getParameter('page', sfConfig::get('app_default_page', 1));
        $this->amExtraParameters['ssSearchPlotName']   	= $this->ssSearchName  	= trim($omRequest->getParameter('searchPlotName',''));
        $this->amExtraParameters['ssSearchIsEnabled']   	= $this->ssSearchIsEnabled  	= trim($omRequest->getParameter('searchIsEnabled',''));        
        $this->amExtraParameters['ssSortBy']        = $this->ssSortBy       = $omRequest->getParameter('sortby','id');
        $this->amExtraParameters['ssSortMode']      = $this->ssSortMode     = $omRequest->getParameter('sortmode','desc');

        $this->ssSortQuerystr = $this->ssQuerystr = 'page='.$this->snPage.'&paging='.$this->snPaging;

        if($this->getRequestParameter('searchPlotName') != '' )        // Search parameters
        {
            $this->ssQuerystr    .= '&searchPlotName='.$this->getRequestParameter('searchPlotName');
            $this->ssSortQuerystr.= '&searchPlotName='.$this->getRequestParameter('searchPlotName');
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
								'plot_name' => array(
												'caption'	=> __('Plot Name'),
												'id'		=> 'PlotName',
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
            $omCommon->DeleteRecordsComposite('ArPlot', $request->getParameter('id'),'id');
            $this->getUser()->setFlash('snSuccessMsgKey', 3);      
        }

        // Get cms page list for listing.
        $oArPlotPageListQuery = Doctrine::getTable('ArPlot')->getPlotList($this->amExtraParameters, $this->amSearch);

        // Set pager and get results
        $oPager               = new sfMyPager();
        $this->oArPlotList  = $oPager->getResults('ArPlot', $this->snPaging,$oArPlotPageListQuery,$this->snPage);
        $this->amArPlotList = $this->oArPlotList->getResults(Doctrine::HYDRATE_ARRAY);

        unset($oPager);

        // Total number of records
        $this->snPageTotalArPlotPages = $this->oArPlotList->getNbResults();

        if($request->getParameter('request_type') == 'ajax_request')
            $this->setTemplate('listArPlotUpdate');
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
        $snIdPlot = $oRequest->getParameter('id', '');
        $ssSuccessKey   = 4; // Success message key for add

        $this->snCementeryId = $oRequest->getParameter('plot_cem_cemetery_id', '');
        $this->snAreaId = $oRequest->getParameter('plot_ar_area_id', '');
        $this->snSectionId = $oRequest->getParameter('plot_ar_section_id', '');
        $this->snRowId = $oRequest->getParameter('plot_ar_row_id', '');
		$this->asCementery = $this->asAreaList = $this->asSectionList = $this->asRowList = array();
		
        if($snIdPlot)
        {
            $this->forward404Unless($oAreaPlot = Doctrine::getTable('ArPlot')->find($snIdPlot));
            $this->oArPlotForm = new ArPlotForm($oAreaPlot);
            $ssSuccessKey = 2; // Success message key for edit
			
			// For get Cemetery List As per Country
			$this->asCementery = Doctrine::getTable('CemCemetery')->getAllCemeteries($oAreaPlot->getCountryId());
			
			// For get Area List as per Cemetery
			$this->asAreaList = Doctrine::getTable('ArArea')->getAreaListAsPerCemetery($oAreaPlot->getCountryId(),$oAreaPlot->getCemCemeteryId());

			// For get Section List as per area
			$this->asSectionList = Doctrine::getTable('ArSection')->getSectionListAsPerArea($oAreaPlot->getCountryId(),$oAreaPlot->getCemCemeteryId(),$oAreaPlot->getArAreaId());

			// For get Area List as per section
			$this->asRowList = Doctrine::getTable('ArRow')->getRowListAsPerSection($oAreaPlot->getCountryId(),$oAreaPlot->getCemCemeteryId(),$oAreaPlot->getArAreaId(),$oAreaPlot->getArSectionId());

			$this->snCementeryId = ($this->snCementeryId != '') ? $this->snCementeryId : $oAreaPlot->getCemCemeteryId();
			$this->snAreaId = ($this->snAreaId != '') ? $this->snAreaId : $oAreaPlot->getArAreaId();
			$this->snSectionId = ($this->snSectionId != '') ? $this->snSectionId : $oAreaPlot->getArSectionId();
			$this->snRowId = ($this->snRowId != '') ? $this->snRowId : $oAreaPlot->getArRowId();
        }
        else
            $this->oArPlotForm = new ArPlotForm();

        $this->getConfigurationFields($this->oArPlotForm);

		$amPlotFormRequest = $oRequest->getParameter($this->oArPlotForm->getName());
		$this->snCementeryId = isset($amPlotFormRequest['cem_cemetery_id']) ? $amPlotFormRequest['cem_cemetery_id'] : $this->snCementeryId;

		if($amPlotFormRequest['country_id'] != '')
			$this->asCementery = Doctrine::getTable('CemCemetery')->getAllCemeteries($amPlotFormRequest['country_id']);
		if($this->snCementeryId != '' && $amPlotFormRequest['country_id'] != '')
			$this->asAreaList = Doctrine::getTable('ArArea')->getAreaListAsPerCemetery($amPlotFormRequest['country_id'], $this->snCementeryId);
		if($amPlotFormRequest['country_id'] != '' && $this->snCementeryId != '')
			$this->asSectionList = Doctrine::getTable('ArSection')->getSectionListAsPerArea($amPlotFormRequest['country_id'], $this->snCementeryId, $this->snAreaId);
		if($amPlotFormRequest['country_id'] != '' && $this->snCementeryId != '')
			$this->asRowList = Doctrine::getTable('ArRow')->getRowListAsPerSection($amPlotFormRequest['country_id'], $this->snCementeryId, $this->snAreaId, $this->snSectionId);

        if($oRequest->isMethod('post'))
        {
            $this->oArPlotForm->bind($oRequest->getParameter($this->oArPlotForm->getName()),$oRequest->getFiles($this->oArPlotForm->getName()));
			
			$bSelectCemetery = false;
			if($this->getUser()->isSuperAdmin())
			{
				if($oRequest->getParameter('plot_cem_cemetery_id') != '')
					$bSelectCemetery = true;
			}
			else
				$bSelectCemetery = true;
				
            if($this->oArPlotForm->isValid() && $bSelectCemetery)
            {
				// For Upload Doc.
				$oFile = $this->oArPlotForm->getValue('plot_map_path');

				// Remove old Image while upload new grave image1
				if(!empty($oFile) && isset($oAreaPlot))
				{
					if($oAreaPlot->getPlotMapPath() != '')
					  sfGeneral::removeFile(sfConfig::get('sf_upload_dir').'/'.sfConfig::get('app_mappath_dir').'/'.sfConfig::get('app_plot_dir').'/'.$oAreaPlot->getPlotMapPath());
				}
				// Save Records
                $snIdPlot = $this->oArPlotForm->save()->getId();

				// For Create mappath directory if not exists
				sfGeneral::createDirectory(sfConfig::get('sf_upload_dir').'/'.sfConfig::get('app_mappath_dir'));
				
                // While edit document remove old doc.
                if(!empty($oFile))
                {
                    $ssFileName = $snIdPlot.'_'.uniqid().'_'.sha1($oFile->getOriginalName());
                    $amExtension = explode('.',$oFile->getOriginalName());
                    $ssExtentions =  ((count($amExtension) > 0) ? '.'.end($amExtension) : '');
                    $ssFileName = $ssFileName.$ssExtentions;
                  
                    $oFile->save(sfConfig::get('sf_upload_dir').'/'.sfConfig::get('app_mappath_dir').'/'.sfConfig::get('app_plot_dir').'/'.$ssFileName);
                }

				// For update Field Name
				if( !empty($oFile) )
					common::UpdateCompositeField('ArPlot','plot_map_path',$ssFileName,'id',$snIdPlot);

                $this->getUser()->setFlash('snSuccessMsgKey', $ssSuccessKey);   //Set messages for add and update records

                if($oRequest->getParameter('tab'))
                    $this->redirect('plot/addedit?id='.$snIdGroup.'&tab='.$oRequest->getParameter('tab').'&'.$this->amExtraParameters['ssQuerystr']);
                else
                	$this->redirect('plot/index?'.$this->amExtraParameters['ssQuerystr']);
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
    * Executes getCementryListAsPerCountry action
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
                'plot_name'  	=> __('Plot Name'),
                'plot_user'  	=> __('Plot User'),
                'length'  	 	=> __('Length'),
                'width'			=> __('Width'),
                'depth'  		=> __('Depth'),
                'is_enabled'    => __('Enabled')
                
            )
        );

        $oForm->setValidators(
            array(
	                'plot_name'		=> array(
												'required'  => __('Please enter plot  name')
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
