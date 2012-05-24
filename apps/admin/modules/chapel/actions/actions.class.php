<?php

/**
 * chapel actions.
 *
 * @package    cemetery
 * @subpackage chapel
 * @author     Prakash Panchal
 * @version    SVN: $Id: actions.class.php,v 1.1.1.1 2012/03/24 12:19:30 nitin Exp $
 */
sfProjectConfiguration::getActive()->loadHelpers(array('I18N'));
class chapelActions extends sfActions
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
        $this->ssFormName = 'frm_list_chapel';
        $omRequest        = sfContext::getInstance()->getRequest();

        // Set default values
        $this->amExtraParameters = array();
        $this->amExtraParameters['snPaging']        = $this->snPaging       = $omRequest->getParameter('paging',sfConfig::get('app_default_paging_records'));
        $this->amExtraParameters['snPage']          = $this->snPage         = $omRequest->getParameter('page', sfConfig::get('app_default_page', 1));
        $this->amExtraParameters['ssSearchName']   	= $this->ssSearchName  	= trim($omRequest->getParameter('searchName',''));
        $this->amExtraParameters['ssSortBy']        = $this->ssSortBy       = $omRequest->getParameter('sortby','id');
        $this->amExtraParameters['ssSortMode']      = $this->ssSortMode     = $omRequest->getParameter('sortmode','desc');

        $this->ssSortQuerystr = $this->ssQuerystr = 'page='.$this->snPage.'&paging='.$this->snPaging;

        if($this->getRequestParameter('searchName') != '' )        // Search parameters
        {
            $this->ssQuerystr    .= '&searchName='.$omRequest->getParameter('searchName');
            $this->ssSortQuerystr.= '&searchName='.$omRequest->getParameter('searchName');
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
											)
							);

        $omCommon = new common();

        if($request->getParameter('admin_act') == "delete" && $request->getParameter('id'))            
        {
            $omCommon->DeleteRecordsComposite('CemChapel', $request->getParameter('id'),'id');
            $this->getUser()->setFlash('snSuccessMsgKey', 3);      
        }

        // Get cms page list for listing.
        $oCemChapelPageListQuery = Doctrine::getTable('CemChapel')->getChapelList($this->amExtraParameters, $this->amSearch);

        // Set pager and get results
        $oPager               = new sfMyPager();
        $this->oCemChapelList  = $oPager->getResults('CemChapel', $this->snPaging,$oCemChapelPageListQuery,$this->snPage);
        $this->amCemChapelList = $this->oCemChapelList->getResults(Doctrine::HYDRATE_ARRAY);

        unset($oPager);

        // Total number of records
        $this->snPageTotaloCemChapelPages = $this->oCemChapelList->getNbResults();

        if($request->getParameter('request_type') == 'ajax_request')
            $this->setTemplate('listCemChapelUpdate');
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
        $snIdChapel = $oRequest->getParameter('id', '');
        $ssSuccessKey   = 4; // Success message key for add        
		$this->snCementeryId = trim($oRequest->getParameter('chapel_cem_cemetery_id', ''));
		$this->asCementery = array();
        if($snIdChapel)
        {
            $this->forward404Unless($oChapel = Doctrine::getTable('CemChapel')->find($snIdChapel));
            $this->oCemChapelForm = new CemChapelForm($oChapel);
			
            $ssSuccessKey = 2; // Success message key for edit
			
			// For get Cemetery List
			$this->asCementery = Doctrine::getTable('CemCemetery')->getAllCemeteries($oChapel->getCountryId());
			$this->snCementeryId = ($this->snCementeryId == '') ? $oChapel->getCemCemeteryId() : $this->snCementeryId;

        }
        else
            $this->oCemChapelForm = new CemChapelForm();

        $this->getConfigurationFields($this->oCemChapelForm);

		$amChapelRequestParameter = $oRequest->getParameter($this->oCemChapelForm->getName());
		if($amChapelRequestParameter['country_id'] != '')
			$this->asCementery = Doctrine::getTable('CemCemetery')->getAllCemeteries($amChapelRequestParameter['country_id']);


        if($oRequest->isMethod('post'))
        {
            $this->oCemChapelForm->bind($amChapelRequestParameter);
			
			$bSelectCemetery = false;
			if($this->getUser()->isSuperAdmin())
			{
				if($oRequest->getParameter('chapel_cem_cemetery_id') != '')
					$bSelectCemetery = true;
			}
			else
				$bSelectCemetery = true;
			
            if($this->oCemChapelForm->isValid() && $bSelectCemetery)
            {
				// Save Records
				$snIdChapel = $this->oCemChapelForm->save();

				$this->getUser()->setFlash('snSuccessMsgKey', $ssSuccessKey);   //Set messages for add and update records
				$this->redirect('chapel/index?'.$this->amExtraParameters['ssQuerystr']);
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
                'name'             => __('Name'),
                'description'      => __('Description'),
            )
        );

        $oForm->setValidators(
            array(
	                'name'              => array(
														'required'  => __('Please enter name')
													),
    	            'country_id'        => array(
														'required'  => __('Please select country')
												),
    	            'cem_cemetery_id'        => array(
														'required'  => __('Please select cemetery')
												)
				)
        );
    }
}
