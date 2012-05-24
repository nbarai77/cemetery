<?php
/**
 * CemCemetery actions.
 *
 * @package    Cemetery
 * @subpackage CemCemetery
 * @author     Nitin Barai
 * @author      
 *
 */
sfProjectConfiguration::getActive()->loadHelpers(array('I18N'));
class cemeteryActions extends sfActions
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
        $this->ssFormName = 'frm_list_cem_cemetery';
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
			// For get users as per cemetery.
			$amUsers = Doctrine::getTable('UserCemetery')->getUsersAsPerCemetery($request->getParameter('id'));
			
			// For delete cemetery
            $omCommon->DeleteRecordsComposite('CemCemetery', $request->getParameter('id'),'id');
			
			// For delete users as per related deleted cemetery.
			if(count($amUsers) > 0) 
				UserCemetery::deleteUsersAsPerCemetery($amUsers);
				
			// delete service booking under cemetery.
			IntermentBooking::deleteBookingRecords($request->getParameter('id'));				
				
            $this->getUser()->setFlash('snSuccessMsgKey', 3);      
        }

        // Get cms page list for listing.
        $oGuardGroupPageListQuery = Doctrine::getTable('CemCemetery')->getCemCemeteryList($this->amExtraParameters, $this->amSearch);

        // Set pager and get results
        $oPager               = new sfMyPager();
        $this->oGuardGroupList  = $oPager->getResults('CemCemetery', $this->snPaging,$oGuardGroupPageListQuery,$this->snPage);
        $this->amGuardGroupList = $this->oGuardGroupList->getResults(Doctrine::HYDRATE_ARRAY);

        unset($oPager);

        // Total number of records
        $this->snPageTotalGuardGroupPages = $this->oGuardGroupList->getNbResults();

        if($request->getParameter('request_type') == 'ajax_request')
            $this->setTemplate('listCemCemeteryUpdate');
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
		//exec('rm -fR '.sfConfig::get('sf_upload_dir').'/'.sfConfig::get('app_mappath_dir'));exit;
        $snIdGuardGroup = $oRequest->getParameter('id', '');
        $ssSuccessKey   = 4; // Success message key for add
        
        if($snIdGuardGroup)
        {
            $this->forward404Unless($oGroup = Doctrine::getTable('CemCemetery')->find($snIdGuardGroup));
            $this->oCemCemeteryForm = new CemCemeteryForm($oGroup);
            $ssSuccessKey = 2; // Success message key for edit
        }
        else {
            $this->oCemCemeteryForm = new CemCemeteryForm();
		}

        $this->getConfigurationFields($this->oCemCemeteryForm);

        if($oRequest->isMethod('post'))
        {
            $this->oCemCemeteryForm->bind($oRequest->getParameter($this->oCemCemeteryForm->getName()),$oRequest->getFiles($this->oCemCemeteryForm->getName()));

            if($this->oCemCemeteryForm->isValid())
            {
				// Remove old Image while upload new grave image1
				if(isset($oGroup))
				{
					if($oGroup->getCemeteryMapPath() != '')
					  sfGeneral::removeFile(sfConfig::get('sf_upload_dir').'/'.sfConfig::get('app_mappath_dir').'/'.sfConfig::get('app_cemeter_dir').'/'.$oGroup->getCemeteryMapPath());
				}
					
				// Save Records
				$oCemSaved = $this->oCemCemeteryForm->save();
				$snIdCemetery = $oCemSaved->getId();
				$snIdCountry = $oCemSaved->getCountryId();
				
				// For Create mappath directory if not exists
				sfGeneral::createDirectory(sfConfig::get('sf_upload_dir').'/'.sfConfig::get('app_mappath_dir'));
				
				// For Upload Doc.
				$oFile = $this->oCemCemeteryForm->getValue('cemetery_map_path');

                // While edit document remove old doc.
                if(!empty($oFile))
                {
                    $ssFileName = $snIdCemetery.'_'.uniqid().'_'.sha1($oFile->getOriginalName());
                    $amExtension = explode('.',$oFile->getOriginalName());
                    $ssExtentions =  ((count($amExtension) > 0) ? '.'.end($amExtension) : '');
                    $ssFileName = $ssFileName.$ssExtentions;
                  
                    $oFile->save(sfConfig::get('sf_upload_dir').'/'.sfConfig::get('app_mappath_dir').'/'.sfConfig::get('app_cemeter_dir').'/'.$ssFileName);
                }
				
				//////////////////////////////////////////////////////////////////////////////
				//			FOR CHECK AND INSERT DEFAULT MAIL CONTENT FOR CEMETERY			//
				//////////////////////////////////////////////////////////////////////////////
				Doctrine::getTable('MailContent')->getDefaultMailContents($snIdCountry,$snIdCemetery);
				
				// For update grave images name
				if( !empty($oFile) )
					common::UpdateCompositeField('CemCemetery','cemetery_map_path',$ssFileName,'id',$snIdCemetery);

                $this->getUser()->setFlash('snSuccessMsgKey', $ssSuccessKey);   //Set messages for add and update records

                if($oRequest->getParameter('tab'))
                    $this->redirect('cemetery/addedit?id='.$snIdGroup.'&tab='.$oRequest->getParameter('tab').'&'.$this->amExtraParameters['ssQuerystr']);
                else
                	$this->redirect('cemetery/index?'.$this->amExtraParameters['ssQuerystr']);
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
        $oForm->setWidgets(array('country_id'       => __('Select Country')));

        $oForm->setLabels(
            array(
				'country_id'		=> __('Select Country'),
                'name'              => __('Name'),
                'description'       => __('Description'),
                'url'              	=> __('Url'),
                'address'           => __('Address'),
                'suburb_town'       => __('Suburb/Town'),
                'state'             => __('State'),
                'postcode'          => __('Postal Code'),
                'phone'             => __('Telephone'),
                'area_code'         => __('Telephone Area Code'),
                'fax_area_code'     => __('Fax Area Code'),
				'latitude'  		=> __('Latitude'),
				'longitude'  		=> __('Longitude'),                
                'fax'              	=> __('Fax'),
                'email'             => __('Email'),
				'cemetery_map_path'	=> __('Map Path'),
                'is_enabled'       	=> __('Enabled')
                
            )
        );

        $oForm->setValidators(
            array(
                'name'              => array(
                                            'required'        => __('Name required'),
                                            'invalid_unique'  => __('Name already exists'),
                                        ),
    	       'country_id'        =>  array(
											'required'  => __('Please select Country')
										)                                        
            )
        );
    }
}
