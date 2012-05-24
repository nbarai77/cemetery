<?php
/**
 * LodgedBy actions.
 *
 * @package    Cemetery
 * @subpackage LodgedBy
 * @author     Nitin Barai
 * @author      
 *
 */
sfProjectConfiguration::getActive()->loadHelpers(array('I18N'));
class lodgedbyActions extends sfActions
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
        $this->ssFormName = 'frm_list_lodgedby';
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
            $omCommon->DeleteRecordsComposite('LodgedBy', $request->getParameter('id'),'id');
            $this->getUser()->setFlash('snSuccessMsgKey', 3);      
        }

        // Get cms page list for listing.
        $oGuardGroupPageListQuery = Doctrine::getTable('LodgedBy')->getLodgedByList($this->amExtraParameters, $this->amSearch);

        // Set pager and get results
        $oPager               = new sfMyPager();
        $this->oGuardGroupList  = $oPager->getResults('LodgedBy', $this->snPaging,$oGuardGroupPageListQuery,$this->snPage);
        $this->amGuardGroupList = $this->oGuardGroupList->getResults(Doctrine::HYDRATE_ARRAY);

        unset($oPager);

        // Total number of records
        $this->snPageTotalGuardGroupPages = $this->oGuardGroupList->getNbResults();

        if($request->getParameter('request_type') == 'ajax_request')
            $this->setTemplate('listLodgedByUpdate');
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
        $ssSuccessKey   = 4; // Success message key for add
        
        if($snIdGuardGroup)
        {
            $this->forward404Unless($oGroup = Doctrine::getTable('LodgedBy')->find($snIdGuardGroup));
            $this->oLodgedByForm = new LodgedByForm($oGroup);
            $ssSuccessKey = 2; // Success message key for edit
        }
        else {
            $this->oLodgedByForm = new LodgedByForm();
		}

        $this->getConfigurationFields($this->oLodgedByForm);

        if($oRequest->isMethod('post'))
        {
            $this->oLodgedByForm->bind($oRequest->getParameter($this->oLodgedByForm->getName()));

            if($this->oLodgedByForm->isValid())
            {
                $snIdGroup = $this->oLodgedByForm->save()->getId();

                $this->getUser()->setFlash('snSuccessMsgKey', $ssSuccessKey);   //Set messages for add and update records

                if($oRequest->getParameter('tab'))
                    $this->redirect('lodgedby/addedit?id='.$snIdGroup.'&tab='.$oRequest->getParameter('tab').'&'.$this->amExtraParameters['ssQuerystr']);
                else
                	$this->redirect('lodgedby/index?'.$this->amExtraParameters['ssQuerystr']);
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
        $oForm->setWidgets(array());

        $oForm->setLabels(
            array(
                'name'              => __('Name'),
                'is_enabled'       => __('Enabled')
                
            )
        );

        $oForm->setValidators(
            array(
                'name'              => array(
                                            'required'        => __('Name required'),
                                            'invalid_unique'  => __('Name already exists'),
                                        ),
            )
        );
    }
}
