<?php

/**
 * chapel actions.
 *
 * @package    cemetery
 * @subpackage chapel
 * @author     Prakash Panchal
 * @version    SVN: $Id: actions.class.php,v 1.1.1.1 2012/03/24 12:19:33 nitin Exp $
 */
sfProjectConfiguration::getActive()->loadHelpers(array('I18N'));
class roomActions extends sfActions
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
            $omCommon->DeleteRecordsComposite('CemRoom', $request->getParameter('id'),'id');
            $this->getUser()->setFlash('snSuccessMsgKey', 3);      
        }

        // Get cms page list for listing.
        $oCemRoomPageListQuery = Doctrine::getTable('CemRoom')->getRoomList($this->amExtraParameters, $this->amSearch);

        // Set pager and get results
        $oPager               = new sfMyPager();
        $this->oCemRoomList  = $oPager->getResults('CemRoom', $this->snPaging,$oCemRoomPageListQuery,$this->snPage);
        $this->amCemRoomList = $this->oCemRoomList->getResults(Doctrine::HYDRATE_ARRAY);

        unset($oPager);

        // Total number of records
        $this->snPageTotalCemRoomPages = $this->oCemRoomList->getNbResults();

        if($request->getParameter('request_type') == 'ajax_request')
            $this->setTemplate('listCemRoomUpdate');
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
        $snIdRoom = $oRequest->getParameter('id', '');
        $ssSuccessKey   = 4; // Success message key for add        
		$this->snCementeryId = trim($oRequest->getParameter('room_cem_cemetery_id', ''));
		$this->asCementery = array();
        if($snIdRoom)
        {
            $this->forward404Unless($oRoom = Doctrine::getTable('CemRoom')->find($snIdRoom));
            $this->oCemRoomForm = new CemRoomForm($oRoom);
			
            $ssSuccessKey = 2; // Success message key for edit
			
			// For get Cemetery List
			$this->asCementery = Doctrine::getTable('CemCemetery')->getAllCemeteries($oRoom->getCountryId());
			$this->snCementeryId = ($this->snCementeryId == '') ? $oRoom->getCemCemeteryId() : $this->snCementeryId;

        }
        else
            $this->oCemRoomForm = new CemRoomForm();

        $this->getConfigurationFields($this->oCemRoomForm);

		$amRoomRequestParameter = $oRequest->getParameter($this->oCemRoomForm->getName());
		if($amRoomRequestParameter['country_id'] != '')
			$this->asCementery = Doctrine::getTable('CemCemetery')->getAllCemeteries($amRoomRequestParameter['country_id']);


        if($oRequest->isMethod('post'))
        {
            $this->oCemRoomForm->bind($amRoomRequestParameter);
			
			$bSelectCemetery = false;
			if($this->getUser()->isSuperAdmin())
			{
				if($oRequest->getParameter('room_cem_cemetery_id') != '')
					$bSelectCemetery = true;
			}
			else
				$bSelectCemetery = true;
			
            if($this->oCemRoomForm->isValid() && $bSelectCemetery)
            {
				// Save Records
				$snIdRoom = $this->oCemRoomForm->save();

				$this->getUser()->setFlash('snSuccessMsgKey', $ssSuccessKey);   //Set messages for add and update records
				$this->redirect('room/index?'.$this->amExtraParameters['ssQuerystr']);
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
