<?php
/**
 * group actions.
 *
 * @package    arp
 * @subpackage group
 * @author     Jaimin Shelat
 * @author     Raghuvir Dodiya
 * @author     Bipin Patel
 *
 */
sfProjectConfiguration::getActive()->loadHelpers(array('I18N'));
class groupActions extends sfActions
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
        $this->ssFormName = 'frm_list_group';
        $omRequest        = sfContext::getInstance()->getRequest();

        // Set default values
        $this->amExtraParameters = array();
        $this->amExtraParameters['snPaging']        = $this->snPaging       = $omRequest->getParameter('paging',sfConfig::get('app_default_paging_records'));
        $this->amExtraParameters['snPage']          = $this->snPage         = $omRequest->getParameter('page', sfConfig::get('app_default_page', 1));
        $this->amExtraParameters['ssSearchName']   	= $this->ssSearchName  	= trim($omRequest->getParameter('searchName',''));
        $this->amExtraParameters['ssSearchDescription']   	= $this->ssSearchDescription  	= trim($omRequest->getParameter('searchDescription',''));        
        $this->amExtraParameters['ssSortBy']        = $this->ssSortBy       = $omRequest->getParameter('sortby','id');
        $this->amExtraParameters['ssSortMode']      = $this->ssSortMode     = $omRequest->getParameter('sortmode','desc');

        $this->ssSortQuerystr = $this->ssQuerystr = 'page='.$this->snPage.'&paging='.$this->snPaging;

        if($this->getRequestParameter('searchName') != '' )        // Search parameters
        {
            $this->ssQuerystr    .= '&searchName='.$this->getRequestParameter('searchName');
            $this->ssSortQuerystr.= '&searchName='.$this->getRequestParameter('searchName');
        }

        if($this->getRequestParameter('searchDescription') != '' )        // Search parameters
        {
            $this->ssQuerystr    .= '&searchDescription='.$this->getRequestParameter('searchDescription');
            $this->ssSortQuerystr.= '&searchDescription='.$this->getRequestParameter('searchDescription');
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
								'description' => array(
												'caption'	=> __('Description'),
												'id'		=> 'Description',
												'type'		=> 'text',																								
											),											
							);

        $omCommon = new common();

        if($request->getParameter('admin_act') == "delete" && $request->getParameter('id_group'))            
        {
            $omCommon->DeleteRecordsComposite('sfGuardGroup', $request->getParameter('id_group'),'id');
            $this->getUser()->setFlash('snSuccessMsgKey', 3);      
        }

        // Get cms page list for listing.
        $oGuardGroupPageListQuery = Doctrine::getTable('sfGuardGroup')->getsfGuardGroupList($this->amExtraParameters, $this->amSearch);

        // Set pager and get results
        $oPager               = new sfMyPager();
        $this->oGuardGroupList  = $oPager->getResults('sfGuardGroup', $this->snPaging,$oGuardGroupPageListQuery,$this->snPage);
        $this->amGuardGroupList = $this->oGuardGroupList->getResults(Doctrine::HYDRATE_ARRAY);

        unset($oPager);

        // Total number of records
        $this->snPageTotalGuardGroupPages = $this->oGuardGroupList->getNbResults();

        if($request->getParameter('request_type') == 'ajax_request')
            $this->setTemplate('listGuardGroupUpdate');
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
            $this->forward404Unless($oGroup = Doctrine::getTable('sfGuardGroup')->find($snIdGuardGroup));
            $this->oSfGuardGroupForm = new sfGuardGroupForm($oGroup);
            $ssSuccessKey = 2; // Success message key for edit
        }
        else
            $this->oSfGuardGroupForm = new sfGuardGroupForm();

        $this->getConfigurationFields($this->oSfGuardGroupForm);

        if($oRequest->isMethod('post'))
        {
            $this->oSfGuardGroupForm->bind($oRequest->getParameter($this->oSfGuardGroupForm->getName()));

            if($this->oSfGuardGroupForm->isValid())
            {
                $snIdGroup = $this->oSfGuardGroupForm->save()->getId();

                $this->getUser()->setFlash('snSuccessMsgKey', $ssSuccessKey);   //Set messages for add and update records

                if($oRequest->getParameter('tab'))
                    $this->redirect('group/addedit?id='.$snIdGroup.'&tab='.$oRequest->getParameter('tab').'&'.$this->amExtraParameters['ssQuerystr']);
                else
                	$this->redirect('group/index?'.$this->amExtraParameters['ssQuerystr']);
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
                'description'       => __('Description'),
                'permissions_list'  => __('Permissions')
            )
        );

        $oForm->setValidators(
            array(
                'name'              => array(
                                            'required'        => __('Name required'),
                                            'invalid_unique'  => __('Name already exists'),
                                        ),
                'description'       => array(
                                            'required'        => __('Description required'),
                                        ),
			    'permissions_list'  => array(
                                            'required'        => __('Permission required'),
                                        ),
            )
        );
    }
}
