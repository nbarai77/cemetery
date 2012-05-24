<?php
/**
 * user actions.
 *
 * @package    cemetery
 * @subpackage user
 * @author     nitin barai 
 *
 */
sfProjectConfiguration::getActive()->loadHelpers(array('I18N', 'jQuery', 'Partial','Url'));
class userActions extends sfActions
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
		        
		$this->amExtraParameters['ssSearchOrganisation']   = $this->ssSearchOrganisation = trim($omRequest->getParameter('searchOrganisation',''));

		$this->amExtraParameters['ssSearchGroupId']   = $this->ssSearchGroupId  	= trim($omRequest->getParameter('searchGroupId',''));
		
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
        
        if($this->getRequestParameter('searchOrganisation') != '' )        // Status selection
        {
            $this->ssQuerystr    .= '&searchOrganisation='.$this->getRequestParameter('searchOrganisation');
            $this->ssSortQuerystr.= '&searchOrganisation='.$this->getRequestParameter('searchOrganisation');
        }        
        
        if($this->getRequestParameter('searchGroupId') != '' )        // Status selection
        {
            $this->ssQuerystr    .= '&searchGroupId='.$this->getRequestParameter('searchGroupId');
            $this->ssSortQuerystr.= '&searchGroupId='.$this->getRequestParameter('searchGroupId');
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
    public function executeIndex(sfWebRequest $request){
		
        //set search combobox field
        $this->amSearchStatus = array('All' => __('All'), 'Active' => __('Active'), 'InActive' => __('InActive'));
        
			if($this->getUser()->getAttribute('issuperadmin')) {
				$arr_user_role = array('' => __('All'), '2'	=> __('Cemetery Manager'), '3'	=> __('Staff'), '4'	=> __('Admin Staff'), '5'	=> __('Funeral Director'), '6'	=> __('Stone Mason'), '7' =>__('Normal Staff'));
			}else {
				$arr_user_role = array('' => __('All'), '3'	=> __('Staff'), '4'	=> __('Admin Staff'), '5'	=> __('Funeral Director'), '6'	=> __('Stone Mason'), '7' =>__('Normal Staff'));
			}
        
        
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
							
								'organisation' => array(
														'caption' 	=> __('Organisation'),
														'id' 		=> 'Organisation',														
														'type' 		=> 'text',														
													),
								'sfug.group_id' 	=> array(
														'caption' 	=> __('User Role'),
														'id' 		=> 'GroupId',											
														'type' 		=> 'select',
														'options'	=> $arr_user_role,
													),																			
													
							);

        $omCommon = new common();

        if($request->getParameter('admin_act') == "delete" && $request->getParameter('id_user'))            
        {
            $omCommon->DeleteRecordsComposite('sfGuardUser', $request->getParameter('id_user'),'id');
            $omCommon->DeleteRecordsComposite('UserCemetery', $request->getParameter('id_user'),'user_id');

            $this->getUser()->setFlash('snSuccessMsgKey', 3);
						
			///////////////////////////////////////////////////////////////////////////////////////////////
			//								DELETE USER FROM CEMETERY GO OFFICE							 //
			///////////////////////////////////////////////////////////////////////////////////////////////
			$ssjQueryPath = sfConfig::get('app_site_url').'sfJqueryReloadedPlugin/js/jquery-1.4.1.min.js';
			$snUserIds = base64_encode(implode(',', $request->getParameter('id_user') ));
			if($request->gethost() == 'hunter.interments.info')
                $ssDeleteGoUserUrl = sfConfig::get('app_goffice_other_domain_goffice_url').'/deleteGoUser.php';
            else
                $ssDeleteGoUserUrl = sfConfig::get('app_goffice_url').'/deleteGoUser.php';
			
			echo "<script type='text/javascript' src='".$ssjQueryPath."'></script>
					<script type='text/javascript'>
						var snUserIds = '".$snUserIds."';
						jQuery.ajax({
							type:'POST',
							data:{user_ids: snUserIds},
							url:'".$ssDeleteGoUserUrl."'
						});
					</script>";
			//////////////////////////////////////////////////////////////////////////////////////////////
			//										END HERE											//
			//////////////////////////////////////////////////////////////////////////////////////////////
        }

       

        $ssStatus = $request->getParameter('selectstatus', 'All');
        $ssStatusRole = $request->getParameter('selectstatusRole', 'All');
        
        

        // Get cms page list for listing.
		if($request->getParameter('request_type') == 'ajax_request') {
			unset($this->amSearch['organisation']);
		}
			
		//unset($this->amSearch['organisation']);	
        $oGuardUserPageListQuery = Doctrine::getTable('sfGuardUser')->getsfGuardUserList($this->amExtraParameters, $ssStatus, $ssStatusRole, $this->ssSearchOrganisation, $this->amSearch);

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
		$this->snCementeryId = $oRequest->getParameter('user_cem_cemetery_id', '');
		
		$this->asCementery = array();
        $this->asAward = array();
        $this->asAwards = Doctrine::getTable('Award')->getAllAwards();
        
        // Add edit part
        $edit_form = false;
        if($snIdUser)
        {
			$edit_form = true;		
            $this->forward404Unless($oGuardUser = Doctrine::getTable('sfGuardUser')->find($snIdUser));
            $this->oSfGuardUsersForm = new sfGuardUserForm($oGuardUser);
            $ssSuccessKey = 2; // Success message key for add
			
			// For get Cemetery List
			$oUserCemetery = Doctrine::getTable('UserCemetery')->findByUserId($snIdUser);
			if(count($oUserCemetery) > 0)
				$oCemeteryCountry = Doctrine::getTable('CemCemetery')->find($oUserCemetery[0]->getCemCemeteryId());

			$snCountryId = (isset($oCemeteryCountry)) ? $oCemeteryCountry->getCountryId() : '';
			
			
			$this->asCementery = Doctrine::getTable('CemCemetery')->getAllCemeteries($snCountryId);
			$this->snCementeryId = ($this->snCementeryId == '') ? $oUserCemetery[0]->getCemCemeteryId() : $this->snCementeryId;
        }
        else
            $this->oSfGuardUsersForm = new sfGuardUserForm();
            
        $this->getConfigurationFields($this->oSfGuardUsersForm);                    
 
        $amUserRequestParameter = $oRequest->getParameter($this->oSfGuardUsersForm->getName());
		if($amUserRequestParameter['cem_country_id'] != '')
			$this->asCementery = Doctrine::getTable('CemCemetery')->getAllCemeteries($amUserRequestParameter['cem_country_id']);
 
        if($oRequest->isMethod('post'))
        {

			$this->oSfGuardUsersForm->bind($amUserRequestParameter);
			
			$arr_param = $oRequest->getParameter($this->oSfGuardUsersForm->getName());	
			//$grp_list = $arr_param['groups_list'];
			
			$bSelectCemetery = false;
			if($this->getUser()->isSuperAdmin())
			{
				if($oRequest->getParameter('user_cem_cemetery_id') != '')
					$bSelectCemetery = true;
			}
			else
				$bSelectCemetery = true;

			if($this->oSfGuardUsersForm->isValid() && $bSelectCemetery){
				
				$snIdUser = $this->oSfGuardUsersForm->save()->getId();

				//delete entries from user_cemetery table and sf_guard_user_group
				if($edit_form) {
					$omCommon = new common();
					$omCommon->DeleteRecordsComposite('UserCemetery', $snIdUser,'user_id');
					$omCommon->DeleteRecordsComposite('sfGuardUserGroup', $snIdUser,'user_id');								
				}
				
				//user is become super admin if group id is 1
				if($arr_param['group_id'] == 1) {
					$oGuardUser1 = Doctrine::getTable('sfGuardUser')->find($snIdUser);
					$oGuardUser1->setIsSuperAdmin(1);
					$oGuardUser1->save();
				}
				
				//add record in sfGuardUserGroup
				$oGuardUserGroup1 = new sfGuardUserGroup();
				$oGuardUserGroup1->setUserId($snIdUser);
				$oGuardUserGroup1->setGroupId($arr_param['group_id']);
				$oGuardUserGroup1->save();              	                            
			
                //add record in user_cemetery with user and group role.
				$snCemeteryId = ($this->getUser()->isSuperAdmin()) ? $oRequest->getParameter('user_cem_cemetery_id') : $arr_param['cem_cemetery_id'];
				$snAwardId = $oRequest->getParameter('user_award_id');
                
				$ug = new UserCemetery();
				$ug->setUserId($snIdUser);
				$ug->setGroupId($arr_param['group_id']);
				$ug->setCemCemeteryId($snCemeteryId);
                $ug->setAwardId($snAwardId);
				//$ug->setCountryId($arr_param['country_id']);
				$ug->setOrganisation($arr_param['organisation']);
				$ug->setCode($arr_param['code']);
				$ug->setAddress($arr_param['address']);
				$ug->setState($arr_param['state']);
				$ug->setPhone($arr_param['phone']);
				$ug->setSuburb($arr_param['suburb']);
				$ug->setTitle($arr_param['title']);
				$ug->setMiddleName($arr_param['middle_name']);
				$ug->setPostalCode($arr_param['postal_code']);
				$ug->setFax($arr_param['fax']);
				$ug->setAreaCode($arr_param['area_code']);
                $ug->setUserCode($arr_param['user_code']);
				$ug->setFaxAreaCode($arr_param['fax_area_code']);
				$ug->save();
	
				$this->getUser()->setFlash('snSuccessMsgKey', $ssSuccessKey);   //Set messages for add and update records		

				//////////////////////////////////////////////////////////////////////////////
				//			FOR INSERT USER DETAILS INTO CEMETERY GROUP OFFICE DB.			//
				//////////////////////////////////////////////////////////////////////////////				
				if($this->oSfGuardUsersForm->isNew())
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
								data:{user_id: snUserId, username: ssUsername,password: ssPassword,first_name: ssFirstName, last_name : ssLastName, email_address : ssEmail},
								url:'".$ssURL."',
                                success:document.location.href = '".url_for('user/index?'.$this->amExtraParameters['ssQuerystr'])."',
							});							
						</script>";exit;
				}
				//////////////////////////////////////////////////////////////////////////////
				//									END										//
				//////////////////////////////////////////////////////////////////////////////
				if($oRequest->getParameter($oRequest->getParameter('tab').'Save'))
					$this->redirect('user/addedit?id='.$snIdUser.'&tab='.$oRequest->getParameter('tab').'&'.$this->amExtraParameters['ssQuerystr']);
				else                    
					$this->redirect('user/index?'.$this->amExtraParameters['ssQuerystr']);                
			}
			else
			{
				if(!$bSelectCemetery)
					$this->getUser()->setFlash('ssErrorCemeter',__('Cemetery required'));
			}
        }
    }
    
    /**
	 * profile action
	 *
	 * Update profile of funeral director   
	 * @access public
	 * @param  object $oRequest A request object
	 *     
     */
    public function executeProfile(sfWebRequest $oRequest){
        $snIdUser = $oRequest->getParameter('id','');
        //$snIdUser = $this->getUser()->getAttribute('user_id', null, 'sfGuardSecurityUser');
        $this->snTabKey = $oRequest->getParameter('tab','info');
        $ssSuccessKey   = 4; // Success message key for add
		$this->snCementeryId = $oRequest->getParameter('user_cem_cemetery_id', '');
		$this->asCementery = array();
        // Add edit part
        $edit_form = false;
        if($snIdUser){
			$edit_form = true;		
            $this->forward404Unless($oGuardUser = Doctrine::getTable('sfGuardUser')->find($snIdUser));
            $this->oSfGuardUsersForm = new sfGuardUserForm($oGuardUser);
            $ssSuccessKey = 2; // Success message key for add
			
			// For get Cemetery List
			$oUserCemetery = Doctrine::getTable('UserCemetery')->findByUserId($snIdUser);
			if(count($oUserCemetery) > 0)
				$oCemeteryCountry = Doctrine::getTable('CemCemetery')->find($oUserCemetery[0]->getCemCemeteryId());

			$snCountryId = (isset($oCemeteryCountry)) ? $oCemeteryCountry->getCountryId() : '';
			
			
			$this->asCementery = Doctrine::getTable('CemCemetery')->getAllCemeteries($snCountryId);
			$this->snCementeryId = ($this->snCementeryId == '') ? $oUserCemetery[0]->getCemCemeteryId() : $this->snCementeryId;
        }
        else
            $this->oSfGuardUsersForm = new sfGuardUserForm();
            
        $this->getConfigurationFields($this->oSfGuardUsersForm);                    
 
        $amUserRequestParameter = $oRequest->getParameter($this->oSfGuardUsersForm->getName());
		if($amUserRequestParameter['cem_country_id'] != '')
			$this->asCementery = Doctrine::getTable('CemCemetery')->getAllCemeteries($amUserRequestParameter['cem_country_id']);
 
        if($oRequest->isMethod('post')) {
			$this->oSfGuardUsersForm->bind($amUserRequestParameter);
			$arr_param = $oRequest->getParameter($this->oSfGuardUsersForm->getName());
			$grp_list = isset($arr_param['service_list']) ? $arr_param['service_list'] : '';						
			$bSelectCemetery = false;
			if($this->getUser()->isSuperAdmin()){
				if($oRequest->getParameter('user_cem_cemetery_id') != '')
					$bSelectCemetery = true;
			}
			else
				$bSelectCemetery = true;

			if($this->oSfGuardUsersForm->isValid() && $bSelectCemetery){
				$snIdUser = $this->oSfGuardUsersForm->save()->getId();
				
				if($edit_form) {
					$omCommon = new common();
					$omCommon->DeleteRecordsComposite('FndServiceFndirector', $snIdUser,'fnd_fndirector_id');
				}							
				
				if($snIdUser) { 
					if($grp_list != ''){
						for($i=0;$i<count($grp_list);$i++) {
							$ug = new FndServiceFndirector();
							$ug->setFndFndirectorId($snIdUser);
							$ug->setFndServiceId($grp_list[$i]);
							$ug->save();                            
						}                
					}						
					
					// update user cemetery table
					Doctrine_Query::create()
					  ->update('UserCemetery uc')
					  ->set('uc.organisation', '?', $arr_param['organisation'])
					  ->set('uc.code', '?', $arr_param['code'])
					  ->set('uc.address', '?', $arr_param['address'])
					  ->set('uc.state', '?', $arr_param['state'])
					  ->set('uc.phone', '?', $arr_param['phone'])
					  ->set('uc.suburb', '?', $arr_param['suburb'])
					  ->set('uc.title', '?', $arr_param['title'])
					  ->set('uc.middle_name', '?', $arr_param['middle_name'])
					  ->set('uc.postal_code', '?', $arr_param['postal_code'])
					  ->set('uc.fax', '?', $arr_param['fax'])
					  ->set('uc.area_code', '?', $arr_param['area_code'])
                      ->set('uc.user_code', '?', $arr_param['user_code'])
					  ->set('uc.fax_area_code', '?', $arr_param['fax_area_code'])
					  ->where('uc.user_id = ?', $snIdUser)
					  ->execute();	
				}	  
						  
				$this->getUser()->setFlash('snSuccessMsgKey', $ssSuccessKey);   //Set messages for add and update records
				unset($this->oSfGuardUsersForm);
				
				$this->redirect('user/profile?id='.$snIdUser);

			}else{
				if(!$bSelectCemetery) {
					$this->getUser()->setFlash('ssErrorCemeter',__('Cemetery required'));
				}
			}
		}
    }
    
    
/**
	* update stone mason profile action
	*
	* Update profile of stone mason
	* @access public
	* @param  object $oRequest A request object
	*     
*/
    public function executeStoneMasonProfile(sfWebRequest $oRequest){
        $snIdUser = $oRequest->getParameter('id','');
        //$snIdUser = $this->getUser()->getAttribute('user_id', null, 'sfGuardSecurityUser');
        $this->snTabKey = $oRequest->getParameter('tab','info');
        $ssSuccessKey   = 4; // Success message key for add
		$this->snCementeryId = $oRequest->getParameter('user_cem_cemetery_id', '');
		$this->asCementery = array();
        // Add edit part
        $edit_form = false;
        if($snIdUser){
			$edit_form = true;		
            $this->forward404Unless($oGuardUser = Doctrine::getTable('sfGuardUser')->find($snIdUser));
            $this->oSfGuardUsersForm = new sfGuardUserForm($oGuardUser);
            $ssSuccessKey = 2; // Success message key for add
			
			// For get Cemetery List
			$oUserCemetery = Doctrine::getTable('UserCemetery')->findByUserId($snIdUser);
			if(count($oUserCemetery) > 0)
				$oCemeteryCountry = Doctrine::getTable('CemCemetery')->find($oUserCemetery[0]->getCemCemeteryId());

			$snCountryId = (isset($oCemeteryCountry)) ? $oCemeteryCountry->getCountryId() : '';
			
			
			$this->asCementery = Doctrine::getTable('CemCemetery')->getAllCemeteries($snCountryId);
			$this->snCementeryId = ($this->snCementeryId == '') ? $oUserCemetery[0]->getCemCemeteryId() : $this->snCementeryId;
        }
        else
            $this->oSfGuardUsersForm = new sfGuardUserForm();
            
        $this->getConfigurationFields($this->oSfGuardUsersForm);                    
 
        $amUserRequestParameter = $oRequest->getParameter($this->oSfGuardUsersForm->getName());
		if($amUserRequestParameter['cem_country_id'] != '')
			$this->asCementery = Doctrine::getTable('CemCemetery')->getAllCemeteries($amUserRequestParameter['cem_country_id']);
 
        if($oRequest->isMethod('post')) {
			$this->oSfGuardUsersForm->bind($amUserRequestParameter);
			$arr_param = $oRequest->getParameter($this->oSfGuardUsersForm->getName());

			
			$grp_list = isset($arr_param['service_list']) ? $arr_param['service_list'] : '';						
			$bSelectCemetery = false;
			if($this->getUser()->isSuperAdmin()){
				if($oRequest->getParameter('user_cem_cemetery_id') != '')
					$bSelectCemetery = true;
			}
			else
				$bSelectCemetery = true;
			
			
			if($this->oSfGuardUsersForm->isValid() && $bSelectCemetery){
				
				$snIdUser = $this->oSfGuardUsersForm->save()->getId();
				
				if($snIdUser) {
					$q = Doctrine::getTable('CemStonemason')->findByUserId($snIdUser);
						
					if(count($q) > 0):	
						// update stone mason table
						Doctrine_Query::create()
						  ->update('CemStonemason csm')
						  ->set('csm.bond', '?', $arr_param['bond'])
						  ->set('csm.annual_license_fee', '?', $arr_param['annual_license_fee'])
						  ->set('csm.abn_acn_number', '?', $arr_param['abn_acn_number'])
						  ->set('csm.contractors_license_number', '?', $arr_param['contractors_license_number'])
						  ->set('csm.general_induction_cards', '?', $arr_param['general_induction_cards'])
						  ->set('csm.operator_licenses', '?', $arr_param['operator_licenses'])
						  ->set('csm.list_current_employees', '?', $arr_param['list_current_employees'])
						  ->set('csm.list_contractors', '?', $arr_param['list_contractors'])
						  ->where('csm.user_id = ?', $snIdUser)
						  ->execute();
					else:
						//add record in stone mason table
						$ug = new CemStonemason();
						$ug->setUserId($snIdUser);
						$ug->setBond($arr_param['bond']);
						$ug->setAnnualLicenseFee($arr_param['annual_license_fee']);
						$ug->setAbnAcnNumber($arr_param['abn_acn_number']);
						$ug->setContractorsLicenseNumber($arr_param['contractors_license_number']);
						$ug->setGeneralInductionCards($arr_param['general_induction_cards']);
						$ug->setOperatorLicenses($arr_param['operator_licenses']);
						$ug->setListCurrentEmployees($arr_param['list_current_employees']);
						$ug->setListContractors($arr_param['list_contractors']);
						$ug->save();
					endif;	
					
						// update user cemetery table
						Doctrine_Query::create()
						  ->update('UserCemetery uc')
						  ->set('uc.organisation', '?', $arr_param['organisation'])
						  ->set('uc.code', '?', $arr_param['code'])
						  ->set('uc.address', '?', $arr_param['address'])
						  ->set('uc.state', '?', $arr_param['state'])
						  ->set('uc.phone', '?', $arr_param['phone'])
						  ->set('uc.suburb', '?', $arr_param['suburb'])
						  ->set('uc.title', '?', $arr_param['title'])
						  ->set('uc.middle_name', '?', $arr_param['middle_name'])
						  ->set('uc.postal_code', '?', $arr_param['postal_code'])
						  ->set('uc.fax', '?', $arr_param['fax'])
						  ->set('uc.area_code', '?', $arr_param['area_code'])
                          ->set('uc.user_code', '?', $arr_param['user_code'])
						  ->set('uc.fax_area_code', '?', $arr_param['fax_area_code'])
						  ->where('uc.user_id = ?', $snIdUser)
						  ->execute();	
				}		
				

				$this->getUser()->setFlash('snSuccessMsgKey', $ssSuccessKey);   //Set messages for add and update records
				unset($this->oSfGuardUsersForm);
				
				$this->redirect('user/stoneMasonProfile?id='.$snIdUser);

			}else{
				if(!$bSelectCemetery) {
					$this->getUser()->setFlash('ssErrorCemeter',__('Cemetery required'));
				}
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
    * Executes welcome action
    *
    * @access public
    * @param sfRequest $request A request object
    */
    public function executeWelcome(sfWebRequest $request){
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
		
        $oForm->setWidgets(array(			
							'cem_country_id' => __('Select Cemetery Country'),
							//'country_id' => __('Select User Country'),
							//'cem_cemetery_id' => __('Select Cemetery'),
                            'award_id' => __('Select Award'),
							'group_id' => __('Select User Role')
							));

        $oForm->setLabels(
                            array(
							'first_name'      => __('First name'),
							'service_list'       => __('Select Services'),
							'last_name'       => __('Surname'),
							'email_address'   => __('Email'),
							'username'   => __('Username'),
							'is_active'		=> __('Is active'),
							'is_super_admin'		=> __('Is super admin'),
							'password'		=> __('Password'),
							'password_again'	=> __('Password again'),
							//'cem_cemetery_id'	=> __('Select Cementery'),
                            'award_id' => __('Select Award'),
							//'country_id'	=> __('User Country'),
							'group_id'	=> __('Select User Role'),
							'organisation'	=> __('Organisation'),
							'address'	=> __('Address'),
							'state'	=> __('State'),
							'phone'	=> __('Telephone'),
							'area_code'	=> __('Telephone Area Code'),
                            'user_code'	=> __('User Code'),
							'postal_code' => __('Postal Code'),
							'fax_area_code'	=> __('Fax Area Code'),
							'phone'	=> __('Telephone'),
							'suburb'	=> __('Suburb/Town'),
							'contact_phone'	=> __('Contact Phone'),
							'cem_country_id' => __('Select Country')
								
                            )
                        );

        $oForm->setValidators(
                            array(
                                'first_name'      => array(
                                                            'required'          => __('First name required'),
                                                        ),
                                'last_name'       => array(
                                                            'required'          => __('Surname required'),
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
                                'cem_cemetery_id'      => array(
                                                            'required'          => __('Cemetery required'),
                                                        ),                                                        
                                /*'country_id'      => array(
                                                            'required'          => __(' User Country required'),
                                                        ),*/
                                'group_id'      => array(
                                                            'required'          => __('User role required'),
                                                        ),
								'cem_country_id'      => array(
                                                            'required'          => __('Cemetery Country required'),
                                                        ),                                                          
								'organisation'      => array(
                                                            'required'          => __('Organisation required'),
                                                        ),                                                         
                                         
                            )
                        );
    }

   /**
    * Executes groupoffice action
    *
    * @access public
    * @param sfRequest $request A request object
    */
	public function executeGroupoffice(sfWebRequest $request)
	{
	}
	/**
    * Executes groupofficeChangePwd action
    *
    * @access public
    * @param sfRequest $request A request object
    */
	public function executeGroupofficeChangePwd(sfWebRequest $request)
	{
	}

    public function executeMailchimps(sfWebRequest $request){
		
		$listId = sfConfig::get('app_ohMailChimp_list_id');
		$response = ohMailChimpApi::getInstance()->listSubscribe($listId, 'nitin@virtueinfo.com');		
		
		$response1 = ohMailChimpApi::getInstance()->listMembers($listId, 'subscribed');		
		//echo '<pre>';
		//print_r($response1);		
	}

	/**
    * Executes subscription action
    *
    * @access public
    * @param sfRequest $request A request object
    */
	public function executeSubscription(sfWebRequest $oRequest)
	{
		$this->oCemSubscriptionForm = new CemSubscriptionForm();
		$ssSuccessKey   		= 4; // Success message key for add
		
		 $this->getConfigurationFieldsForCemetery($this->oCemSubscriptionForm);
		 
		if($oRequest->isMethod('post'))
        {
			$amFormRequestParams = $oRequest->getParameter($this->oCemSubscriptionForm->getName());
			$amFileRequestParams = $oRequest->getFiles($this->oCemSubscriptionForm->getName());
			
            $this->oCemSubscriptionForm->bind($amFormRequestParams,$amFileRequestParams);			
            if($this->oCemSubscriptionForm->isValid())
            {
				// Save Records
				$oSaveData = $this->oCemSubscriptionForm->save();
				$snIdCemetery = $oSaveData->getId();
				
				// GET EMBED FORM OBJECT
				$oEmbedForm	= $this->oCemSubscriptionForm->getEmbeddedForm('user_subscription');
				$snIdUser	= $oEmbedForm->getObject()->getId(); 
				
				// BUILD DATA ARRAY
				$amBuildData = array(
							'user_id'		=> $snIdUser,
							'cem_id'		=> $snIdCemetery,
							'title'			=> $amFormRequestParams['user_subscription']['title'],
							'organisation'	=> $amFormRequestParams['user_subscription']['organisation'],
							'code'			=> $amFormRequestParams['user_subscription']['code'],
							'address'		=> $amFormRequestParams['user_subscription']['address'],
							'state'			=> $amFormRequestParams['user_subscription']['state'],
							'phone'			=> $amFormRequestParams['user_subscription']['phone'],
//							'suburb'		=> $amFormRequestParams['user_subscription']['suburb'],
							'middle_name'	=> $amFormRequestParams['user_subscription']['middle_name'],
							'postal_code'	=> $amFormRequestParams['user_subscription']['postal_code'],
							'fax'			=> $amFormRequestParams['user_subscription']['fax'],
							'area_code'		=> $amFormRequestParams['user_subscription']['area_code'],
							'fax_area_code'	=> $amFormRequestParams['user_subscription']['fax_area_code']
							);
							
				// SAVE USER CEMETERY DETAILS INTO USER CEMETERY TABLE
				UserCemetery::saveUserCemeteryInfo($amBuildData);
				
				// FOR UPDATE user_id WHO DELETE THE RECORDS.
				common::UpdateCompositeField('sfGuardUser','is_active','0','id',$snIdUser);
		
				// For Create mappath directory if not exists
				sfGeneral::createDirectory(sfConfig::get('sf_upload_dir').'/'.sfConfig::get('app_mappath_dir'));
				
				// For Upload Doc.
				$oFile = $this->oCemSubscriptionForm->getValue('cemetery_map_path');

                // While edit document remove old doc.
                if(!empty($oFile))
                {
                    $ssFileName = $snIdCemetery.'_'.uniqid().'_'.sha1($oFile->getOriginalName());
                    $amExtension = explode('.',$oFile->getOriginalName());
                    $ssExtentions =  ((count($amExtension) > 0) ? '.'.end($amExtension) : '');
                    $ssFileName = $ssFileName.$ssExtentions;
                  
                    $oFile->save(sfConfig::get('sf_upload_dir').'/'.sfConfig::get('app_mappath_dir').'/'.sfConfig::get('app_cemeter_dir').'/'.$ssFileName);
                }
				
				// For update grave images name
				if( !empty($oFile) )
					common::UpdateCompositeField('CemCemetery','cemetery_map_path',$ssFileName,'id',$snIdCemetery);

				//Set messages for add and update records
				
				$mail_subject = "Your Subcription info for Cemetery";
				
				$mail_body = get_partial('user/submail',array('username' => $amFormRequestParams['user_subscription']['username'], 'password' => $amFormRequestParams['user_subscription']['password']));
				//adde by nitin
				$ssMessage = Swift_Message::newInstance()
						  ->setFrom(sfConfig::get('app_admin_emailid'))
						  ->setTo($amFormRequestParams['user_subscription']['email_address'])
						  ->setSubject($mail_subject)
						  ->setBody($mail_body,'text/html');				
				
				$oSend = sfContext::getInstance()->getMailer()->send($ssMessage);
				
				// BUILD DATA ARRAY
				$oPasswordHash = new PasswordHash(8, true);
	        	$ssPassword = $oPasswordHash->HashPassword($amFormRequestParams['user_subscription']['password']);

				$amData = array(
							'login'		=> $amFormRequestParams['user_subscription']['username'],
							'pass'		=> $ssPassword,
							'email'		=> $amFormRequestParams['user_subscription']['email_address'],
							'name_f'	=> $amFormRequestParams['user_subscription']['first_name'],
							'name_l'	=> $amFormRequestParams['user_subscription']['last_name'],
							'street'	=> $amFormRequestParams['user_subscription']['address'],
							'state'		=> $amFormRequestParams['user_subscription']['state'],
							'phone'		=> $amFormRequestParams['user_subscription']['phone'],
							'zip'		=> $amFormRequestParams['user_subscription']['postal_code'],
							'status'	=> 1,
							'is_approved'	=> 1,
							);				
				
				//aMemberdb::registration($amData);
								
                $this->getUser()->setFlash('ssSuccessRegisteration', __('Thank you for subscription.Details has been sent to the registered email address') ); 

               	$this->redirect('@sf_guard_signin');
            }
        }
	}
	 /**
     * getConfigurationFieldsForCemetery
     *
     * Function for prepare configuration fields for form
     * @access private
     * @param  object $oForm form object
     *     
     */
    private function getConfigurationFieldsForCemetery($oForm)
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
                'user_code'         => __('User Code'),
                'fax_area_code'     => __('Fax Area Code'),
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
