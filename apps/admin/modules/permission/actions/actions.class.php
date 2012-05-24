<?php
/**
 * permission actions.
 *
 * @package    arp
 * @subpackage group
 * @author     Jaimin Shelat
 * @author     Raghuvir Dodiya
 * @author     Bipin Patel
 *
 */
sfProjectConfiguration::getActive()->loadHelpers(array('I18N'));
class permissionActions extends sfActions
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
        $this->amSuccessMsg = array(1 => __('Status changes successfully'),
                                    2 => __('Record has been updated successfully'),
                                    3 => __('Record has been deleted successfully'),
                                    4 => __('Record has been inserted successfully'),);

        $this->amErrorMsg = array(1 => __('Please select at least one'),);
        $this->ssFormName = 'frm_list_permission';
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

        if($request->getParameter('admin_act') == "delete" && $request->getParameter('id_permission'))            
        {
            $omCommon->DeleteRecordsComposite('sfGuardPermission', $request->getParameter('id_permission'),'id');
            $this->getUser()->setFlash('snSuccessMsgKey', 3);      
        }

        // Get cms page list for listing.
        $oGuardPermissionPageListQuery = Doctrine::getTable('sfGuardPermission')->getsfGuardPermissionList($this->amExtraParameters, $this->amSearch);

        // Set pager and get results
        $oPager               = new sfMyPager();
        $this->oGuardPermissionList  = $oPager->getResults('sfGuardPermission', $this->snPaging,$oGuardPermissionPageListQuery,$this->snPage);
        $this->amGuardPermissionList = $this->oGuardPermissionList->getResults(Doctrine::HYDRATE_ARRAY);

        unset($oPager);

        // Total number of records
        $this->snPageTotalGuardPermissionPages = $this->oGuardPermissionList->getNbResults();

        if($request->getParameter('request_type') == 'ajax_request')
            $this->setTemplate('listGuardPermissionUpdate');
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
        $snIdGuardPermission = $oRequest->getParameter('id', '');
        $ssSuccessKey = 4; // Success message key for add
        if($snIdGuardPermission)
        {
            $this->forward404Unless($oPermission = Doctrine::getTable('sfGuardPermission')->find($snIdGuardPermission));
            $this->oSfGuardPermissionForm = new sfGuardPermissionForm($oPermission);
            $ssSuccessKey = 2; // Success message key for add
        }
        else
            $this->oSfGuardPermissionForm = new sfGuardPermissionForm();
      
        $this->getConfigurationFields($this->oSfGuardPermissionForm);
          
        if($oRequest->isMethod('post'))
        {
            $this->oSfGuardPermissionForm->bind($oRequest->getParameter($this->oSfGuardPermissionForm->getName()));

            if($this->oSfGuardPermissionForm->isValid())
            {
                $this->oSfGuardPermissionForm->save();

                $this->getUser()->setFlash('snSuccessMsgKey', $ssSuccessKey);   //Set messages for add and update records
                unset($this->oSfGuardPermissionForm, $oRequest);

                $this->redirect('permission/index?'.$this->amExtraParameters['ssQuerystr']);
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

        $oForm->setLabels(array(
                                'name'          => __('Name'),
                                'description'   => __('Description'),
                                'group_list'    => __('Group list'),
                                'user_list'     => __('User list'),
                                ));

      $oForm->setValidators(array(
                                    'name'      => array(
                                                            'required'        => __('Name required'),
                                                            'invalid_unique'  => __('Name already exists'),
                                                    ),
                                    'description'  => array(
                                                            'required'        => __('Description required'),
                                                    ),
                                ));

    }
}
