<?php
/**
 * cemmail actions.
 *
 * @package    Cemetery
 * @subpackage cemmail
 * @author     Prakash Panchal
 * @author      
 *
 */
sfProjectConfiguration::getActive()->loadHelpers(array('I18N'));
class cemmailActions extends sfActions
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
									5 => __('Mail has been sent successfully')
                                );

        $this->amErrorMsg = array(1 => __('Please select at least one'),);
        $this->ssFormName = 'frm_list_granteedetails';
        $omRequest        = sfContext::getInstance()->getRequest();

        // Set default values
        $this->amExtraParameters = array();
        $this->amExtraParameters['snPaging']        	= $this->snPaging       		= $omRequest->getParameter('paging',sfConfig::get('app_default_paging_records'));
        $this->amExtraParameters['snPage']          	= $this->snPage         		= $omRequest->getParameter('page', sfConfig::get('app_default_page', 1));
        $this->amExtraParameters['ssSearchMailSubject']	= $this->ssSearchMailSubject	= trim($omRequest->getParameter('searchMailSubject',''));
        $this->amExtraParameters['ssSortBy']        	= $this->ssSortBy       		= $omRequest->getParameter('sortby','created_at');
        $this->amExtraParameters['ssSortMode']      	= $this->ssSortMode     		= $omRequest->getParameter('sortmode','desc');

        $this->ssSortQuerystr = $this->ssQuerystr = 'page='.$this->snPage.'&paging='.$this->snPaging;

        if($this->getRequestParameter('searchMailSubject') != '' )        // Search parameters
        {
            $this->ssQuerystr    .= '&searchMailSubject='.$this->ssSearchMailSubject;
            $this->ssSortQuerystr.= '&searchMailSubject='.$this->ssSearchMailSubject;
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
								'mail_subject' => array(
												'caption'	=> __('Subject'),
												'id'		=> 'MailSubject',
												'type'		=> 'text',																								
											)
							);

        $omCommon = new common();

		// For Move to trash folder
        if($request->getParameter('admin_act') == "delete" && $request->getParameter('id'))            
        {
			CemMailUsers::updateMailStatus('delete_status',$request->getParameter('id'));			
            $this->getUser()->setFlash('snSuccessMsgKey', 3);
        }

        // Get cms page list for listing.
		$this->ssMailType = $request->getParameter('mail_type','inbox');
        $oCemMailListQuery = Doctrine::getTable('CemMail')->getMails($this->amExtraParameters, $this->amSearch,'',$this->ssMailType);

        // Set pager and get results
        $oPager               	= new sfMyPager();
        $this->oCemMailsList	= $oPager->getResults('CemMail', $this->snPaging,$oCemMailListQuery,$this->snPage);
        $amCemMails 			= $this->oCemMailsList->getResults(Doctrine::HYDRATE_ARRAY);

		$this->amCemMailsList = $amCemMails;
		
        unset($oPager);

        // Total number of records
        $this->snPageTotalCemMails = count($this->amCemMailsList);

        if($request->getParameter('request_type') == 'ajax_request')
            $this->setTemplate('listCemMailsUpdate');
    }
   /**
    * Executes showDetails action
    *
    * @access public
    * @param sfRequest $request A request object
    */
    public function executeShowDetails(sfWebRequest $request)
    {
		// For Change Mail Read Status
		if($request->getParameter('request_type') == 'ajax_request' && $request->getParameter('cmu_id'))
			CemMailUsers::updateMailStatus('read_unread_status',$request->getParameter('cmu_id'));
		
		$this->snMailId = $request->getParameter('id');
		$this->snUserMailId = $request->getParameter('from_user_id');
		// For Get Show mail Details
		$this->amCemMailsDetails = Doctrine::getTable('CemMail')->getMailsDeails($this->snMailId);

        if($request->getParameter('request_type') == 'ajax_request')
            $this->setTemplate('listCemMailsDetailsUpdate');
	}
	   /**
    * Executes sendMail action
    *
    * @access public
    * @param sfRequest $request A request object
    */
    public function executeSendMail(sfWebRequest $oRequest)
    {
		$snIdCemMail = $oRequest->getParameter('id', '');
		$snFromUserId	= $oRequest->getParameter('from_user_id', '');        
		$ssSuccessKey   = 5; // Success message key for add
        
		$this->ssFwdOrReply = $oRequest->getParameter('ssFwdOrReply', '');
        if($snIdCemMail != '')
        {
            $this->forward404Unless($oCemMail = Doctrine::getTable('CemMail')->find($snIdCemMail));
            $this->oCemMailForm = new CemMailForm($oCemMail);
            $ssSuccessKey = 5; // Success message key for edit
			
			$oUserEmail = Doctrine::getTable('sfGuardUser')->find($snFromUserId);
			$this->ssFwdOrReply = ($this->ssFwdOrReply != '') ? $this->ssFwdOrReply : $oUserEmail->getEmailAddress();
        }
        else
			$this->oCemMailForm = new CemMailForm();

		$this->getConfigurationFields($this->oCemMailForm);
		
		if($oRequest->isMethod('post'))
		{
			$amFormRequest = $oRequest->getParameter($this->oCemMailForm->getName());
			$amFileRequest = $oRequest->getFiles($this->oCemMailForm->getName());
			$this->oCemMailForm->bind($amFormRequest,$amFileRequest);
			
			if($this->oCemMailForm->isValid())
			{
				$amMailTo = explode(',',$amFormRequest['mail_to']);
				// Send Mail.
				if(count($amMailTo) > 0)
				{
					foreach($amMailTo as $ssToEmailId)
					{
						$ssMessage = Swift_Message::newInstance()
									  ->setFrom($this->getUser()->getAttribute('email_address','','sfGuardSecurityUser'))
									  ->setTo($ssToEmailId)
									  ->setSubject($amFormRequest['mail_subject'])
									  ->setBody($amFormRequest['mail_body'],'text/html');
								  //->attach(Swift_Attachment::newInstance($ssContent,$this->ssFilename,'$ssMimeType'));

						$oSend = sfContext::getInstance()->getMailer()->send($ssMessage);
					}
				}
				$snIdMail = $this->oCemMailForm->save();

				$snI=0;
				if(count($amMailTo) > 0)
				{
					$snToUserId = NULL;
					foreach($amMailTo as $ssToEmailId)
					{
						$oUser = Doctrine::getTable('sfGuardUser')->findOneByEmailAddress(trim($ssToEmailId));

						if($oUser)
							$snToUserId = $oUser->getId();
						
						// Save User 
						$bSentStatus = 0;
						for($snI=0;$snI<2;$snI++)
						{
							$amDetails = array('snMailId'		=> $snIdMail,
												'snFromUserId'	=> $this->getUser()->getAttribute('userid'),
												'snToUserId'	=> $snToUserId,
												'bSentStatus'	=> $bSentStatus
											  );

							CemMailUsers::saveSendMailDetails($amDetails);
							$bSentStatus = 1;
						}
					}
				}
				$this->getUser()->setFlash('snSuccessMsgKey', $ssSuccessKey);   //Set messages for add and update records
				$this->redirect('cemmail/index?'.$this->amExtraParameters['ssQuerystr']);
			}
		}		
	}
	 private function getConfigurationFields($oForm)
    {
		$oForm->setWidgets(array());
		
		 $oForm->setLabels(
            array(
				'mail_to'		=> __('To'),
				'mail_subject'	=> __('Subject'),
				'mail_body'		=> __('Content')
				 )
        );
		$oForm->setValidators(
            array(
    	            'mail_to'    	=> array('required'  => __('Please enter to email id')),
					'mail_subject'	=> array('required'  	=> __('Please enter subject')),
					'mail_body'		=> array('required'  	=> __('Please body content'))
				)
        );				
	}	
}
