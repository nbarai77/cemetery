<?php
/**
 * user actions.
 *
 * @package    cemetery
 * @subpackage admin
 * @author     nitin barai
 
 *
 */
sfProjectConfiguration::getActive()->loadHelpers(array('I18N'));
class adminActions extends sfActions
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
                                    4 => __('Record has been inserted successfully'),
                                );

        $this->amErrorMsg   = array(1 => __('Select atleast one'), 2 => __('Some information was missing'));
        $this->ssFormName = 'frm_list_user';
        $omRequest        = sfContext::getInstance()->getRequest();

        // Set default values
        $this->amExtraParameters = array();
        $this->amExtraParameters['snPaging']        = $this->snPaging       = $omRequest->getParameter('paging',sfConfig::get('app_default_paging_records'));
        $this->amExtraParameters['snPage']          = $this->snPage         = $omRequest->getParameter('page', sfConfig::get('app_default_page', 1));
        $this->amExtraParameters['ssSearchFirstName']  = $this->ssSearchFirstName  	= trim($omRequest->getParameter('searchFirstName',''));
        $this->amExtraParameters['ssSearchLastName']   = $this->ssSearchLastName  	= trim($omRequest->getParameter('searchLastName',''));        
        $this->amExtraParameters['ssSearchEmailAddress']      = $this->ssSearchEmailAddress  		= trim($omRequest->getParameter('searchEmailAddress',''));        
		$this->amExtraParameters['ssSearchIsActive']   = $this->ssSearchIsActive  	= trim($omRequest->getParameter('searchIsActive',''));        
        $this->amExtraParameters['ssSortBy']        = $this->ssSortBy       = $omRequest->getParameter('sortby','id');
        $this->amExtraParameters['ssSortMode']      = $this->ssSortMode     = $omRequest->getParameter('sortmode','desc');

        $this->ssSortQuerystr = $this->ssQuerystr = 'page='.$this->snPage.'&paging='.$this->snPaging;

        if($this->getRequestParameter('searchFirstName') != '' )        // Search parameters
        {
            $this->ssQuerystr    .= '&searchFirstName='.$this->getRequestParameter('searchFirstName');
            $this->ssSortQuerystr.= '&searchFirstName='.$this->getRequestParameter('searchFirstName');
        }
        
		if($this->getRequestParameter('searchLastName') != '' )        // Search parameters
        {
            $this->ssQuerystr    .= '&searchLastName='.$this->getRequestParameter('searchLastName');
            $this->ssSortQuerystr.= '&searchLastName='.$this->getRequestParameter('searchLastName');
        }
        
		if($this->getRequestParameter('searchEmailAddress') != '' )        // Search parameters
        {
            $this->ssQuerystr    .= '&searchEmailAddress='.$this->getRequestParameter('searchEmailAddress');
            $this->ssSortQuerystr.= '&searchEmailAddress='.$this->getRequestParameter('searchEmailAddress');
        }                

        if($this->getRequestParameter('searchIsActive') != '' )        // Status selection
        {
            $this->ssQuerystr    .= '&searchIsActive='.$this->getRequestParameter('searchIsActive');
            $this->ssSortQuerystr.= '&searchIsActive='.$this->getRequestParameter('searchIsActive');
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
    public function executeWhmsexample(sfWebRequest $oRequest)
    {
        //$asAllClientDetail = $this->getWHMSClientDetail();
        $this->OmWhmsClientForm = new WhmsClientForm();
        
        if($oRequest->isMethod('post'))
        {
			
            $this->OmWhmsClientForm->bind($oRequest->getParameter($this->OmWhmsClientForm->getName()));
			//if($this->OmWhmsClientForm->isValid()){
				//echo "here";exit;
                $asClientDetail = $oRequest->getParameter($this->OmWhmsClientForm->getName());
                $asPostFields = array();
                $asPostFields["clientid"] = $asClientDetail['clients'];
                $asPostFields["description"] = $asClientDetail['description'];
                $asPostFields["amount"] = $asClientDetail['amount'];
                $asPostFields["recur"] = $asClientDetail['recur'];
                $asPostFields["recurcycle"] = $asClientDetail['recurcycle'];
                $asPostFields["recurfor"] = $asClientDetail['recurfor'];
                //$asPostFields["invoiceaction"] = "noinvoice";
                $asPostFields["duedate"] = $asClientDetail['duedate'];
				//echo "<pre>";print_R($asClientDetail);exit;
                
                $asClientName = sfGeneral::getAndSetWHMSDetail('addbillableitem',$asPostFields);
                /*echo  "<pre>";
                print_R($asClientName);
                exit;*/
                /*if($oRequest->getParameter($oRequest->getParameter('tab').'Save'))
					$this->redirect('admin/addedit?id='.$snIdUser.'&tab='.$oRequest->getParameter('tab').'&'.$this->amExtraParameters['ssQuerystr']);
				else */                
					$this->redirect('admin/whmsexample?'.$this->amExtraParameters['ssQuerystr']);
			//}
        }
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
        $this->amSearchStatus = array('All' => __('All'), 'Active' => __('Active'), 'InActive' => __('InActive'));
        $this->amSearch = array(
								'first_name' 	=> array(
														'caption' 	=> __('First name'),
														'id' 		=> 'FirstName',														
														'type' 		=> 'text',														
													),
								'last_name' 	=> array(
														'caption' 	=> __('Last name'),
														'id' 		=> 'LastName',														
														'type' 		=> 'text',														
													),
								'email_address' => array(
														'caption' 	=> __('Email'),
														'id' 		=> 'EmailAddress',														
														'type' 		=> 'text',														
													),
								'is_active' 	=> array(
														'caption' 	=> __('Status'),
														'id' 		=> 'IsActive',														
														'type' 		=> 'select',
														'options'	=> array(
																			''	=> __('All'),
																			'1'	=> __('Active'),
																			'0'	=> __('InActive'),																																						
																		),														
													),																																							
							);

        $omCommon = new common();

        if($request->getParameter('admin_act') == "delete" && $request->getParameter('id_user'))            
        {
            $omCommon->DeleteRecordsComposite('sfGuardUser', $request->getParameter('id_user'),'id');
            $this->getUser()->setFlash('snSuccessMsgKey', 3);      
        }

        // Change status
        if($request->getParameter('admin_act') == "status" && $request->getParameter('id_user'))
        {   
            $ssStatus     = ($request->getParameter('request_status') == "Active") ? 1 : '0';
            $ssSuccessKey = 1;

            $omCommon->UpdateStatusComposite('sfGuardUser','is_active', $request->getParameter('id_user'), $ssStatus, 'id');
            $this->getUser()->setFlash('snSuccessMsgKey', $ssSuccessKey); // set flag variable to display proper message
            unset($omCommon);
        }  

        $ssStatus = $request->getParameter('selectstatus', 'All');

        // Get cms page list for listing.
        $oGuardUserPageListQuery = Doctrine::getTable('sfGuardUser')->getsfGuardAdminList($this->amExtraParameters, $ssStatus, $this->amSearch);

        // Set pager and get results
        $oPager               = new sfMyPager();
        $this->oGuardUserList  = $oPager->getResults('sfGuardUser', $this->snPaging,$oGuardUserPageListQuery,$this->snPage);
        $this->amGuardUserList = $this->oGuardUserList->getResults(Doctrine::HYDRATE_ARRAY);

        unset($oPager);

        // Total number of records
        $this->snPageTotalGuardUserPages = $this->oGuardUserList->getNbResults();

        if($request->getParameter('request_type') == 'ajax_request')
            $this->setTemplate('listGuardUserUpdate');
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
        $snIdUser       = $oRequest->getParameter('id','');
        $this->snTabKey = $oRequest->getParameter('tab','info');
        $ssSuccessKey   = 4; // Success message key for add
        
        // Add edit part
        
        if($snIdUser)
        {
            $this->forward404Unless($oGuardUser = Doctrine::getTable('sfGuardUser')->find($snIdUser));
            $this->osfGuardAdminsForm = new sfGuardAdminForm($oGuardUser);
            $ssSuccessKey = 2; // Success message key for add
        }
        else
            $this->osfGuardAdminsForm = new sfGuardAdminForm();
            
        $this->getConfigurationFields($this->osfGuardAdminsForm);                    
 
        if($oRequest->isMethod('post'))
        {
			$this->osfGuardAdminsForm->bind($oRequest->getParameter($this->osfGuardAdminsForm->getName()));
            $arr_param = $oRequest->getParameter($this->osfGuardAdminsForm->getName());
            
			if($this->osfGuardAdminsForm->isValid()){
				$snIdUser = $this->osfGuardAdminsForm->save()->getId();
				
				$oGuardUser1 = Doctrine::getTable('sfGuardUser')->find($snIdUser);
				$oGuardUser1->setIsSuperAdmin(1);
				$oGuardUser1->save();

				$this->getUser()->setFlash('snSuccessMsgKey', $ssSuccessKey);   //Set messages for add and update records
				//unset($this->osfGuardAdminsForm);
                
                //////////////////////////////////////////////////////////////////////////////
				//			FOR INSERT USER DETAILS INTO CEMETERY GROUP OFFICE DB.			//
				//////////////////////////////////////////////////////////////////////////////				
				if($this->osfGuardAdminsForm->isNew())
				{
					$ssjQueryPath = sfConfig::get('app_site_url').'sfJqueryReloadedPlugin/js/jquery-1.4.1.min.js';
                    if($oRequest->gethost() == 'hunter.interments.info')
                        $ssURL = sfConfig::get('app_goffice_other_domain_goffice_url').'/createGoUser.php';
                    else
                        $ssURL = sfConfig::get('app_goffice_url').'/createGoUser.php';
                    
					echo "<script type='text/javascript' src='".$ssjQueryPath."'></script>
						  <script type='text/javascript'>
						  	var snUserId   = '".$snIdUser."';
							var ssUsername = '".$arr_param['username']."';
							var ssPassword = '".$arr_param['password']."';
							var ssFirstName = '".$arr_param['first_name']."';
							var ssLastName = '".$arr_param['last_name']."';
							var ssEmail = '".$arr_param['email_address']."';
														
							jQuery.ajax({
								type:'POST',
								data:{user_id: snUserId, username: ssUsername,password: ssPassword,first_name: ssFirstName, last_name : ssLastName, email_address : ssEmail, group_id: 1},
								url:'".$ssURL."',
                                success:document.location.href = '".url_for('admin/index?'.$this->amExtraParameters['ssQuerystr'])."',
							});							
						</script>";exit;
				}
                
				if($oRequest->getParameter($oRequest->getParameter('tab').'Save'))
					$this->redirect('admin/addedit?id='.$snIdUser.'&tab='.$oRequest->getParameter('tab').'&'.$this->amExtraParameters['ssQuerystr']);
				else                    
					$this->redirect('admin/index?'.$this->amExtraParameters['ssQuerystr']);                
			}
        }
    }
    
    /**
     * getConfigurationFields
     *
     * Function for prepare configuration fields for form
     * 
     * @access 	private
     * @param  	object $oForm form object
     *     
     */
    private function getConfigurationFields($oForm)
    {
        $oForm->setWidgets(array());

        $oForm->setLabels(
                            array(
                                'first_name'      => __('First name'),
                                'last_name'       => __('Last name'),
                                'email_address'   => __('Email'),
								'username'   => __('Username'),
								'is_active'		=> __('Is active'),
								'is_super_admin'		=> __('Is super admin'),
								'password'		=> __('Password'),
								'password_again'	=> __('Password again'),
                            )
                        );

        $oForm->setValidators(
			array(
				'first_name'      => array(
											'required'          => __('First name required'),
										),
				'last_name'       => array(
											'required'          => __('Last name required'),
										),
				'email_address'       => array(
											'required'          => __('Email address required'),
											'invalid'           => __('Invalid email address'),
										),
				'username'       => array(
											'required'          => __('Username required'),
										),
				'password'       => array(
											'required'          => __('Password required'),
											'min_length' => __('Enter atleast 3 characters'),
											'max_length' => __('Enter atmost 25 characters'),
										),
				'password_again' => array(
											'required'          => __('Password again required'),
											'invalid'			=> __('Password and password again must be same.')
										),
			)
		);
    }
 
}
