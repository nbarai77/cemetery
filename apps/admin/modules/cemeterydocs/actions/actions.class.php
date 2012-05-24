<?php
/**
 * Service Booking actions.
 *
 * @package    Cemetery
 * @subpackage Service Booking
 * @author     Prakash Panchal
 *
 */
sfProjectConfiguration::getActive()->loadHelpers(array('I18N','Url'));
class cemeterydocsActions extends sfActions
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
									5 => __('Record has been finalized successfully'),
									6 => __('Document has been successfully uploaded'),
									7 => __('Document has been successfully download'),
									8 => __('Document has been successfully updated'),
									9 => __('Document has been sent successfully'),
                                );

		$this->amErrorMsg   = array(
									1 => __('Select atleast one'), 
									2 => __('Some information was missing'),
									3 => __('This page is in a restricted area'),
									4 => __('Document sending failed!'),
									);

        $this->ssFormName = 'frm_list_cemetery_docs';
        $omRequest        = sfContext::getInstance()->getRequest();

        // Set default values
        $this->amExtraParameters = array();
        $this->amExtraParameters['snPaging']        = $this->snPaging       = $omRequest->getParameter('paging',sfConfig::get('app_default_paging_records'));
        $this->amExtraParameters['snPage']          = $this->snPage         = $omRequest->getParameter('page', sfConfig::get('app_default_page', 1));
        $this->amExtraParameters['ssSortBy']        = $this->ssSortBy       = $omRequest->getParameter('sortby','id');
        $this->amExtraParameters['ssSortMode']      = $this->ssSortMode     = $omRequest->getParameter('sortmode','desc');

        $this->ssSortQuerystr = $this->ssQuerystr = 'page='.$this->snPage.'&paging='.$this->snPaging;

        if($this->getRequestParameter('sortby') != '' )        // Sorting parameters
            $this->ssQuerystr .= '&sortby='.$this->getRequestParameter('sortby').'&sortmode='.$this->getRequestParameter('sortmode');

        $this->amExtraParameters['ssQuerystr']     = $this->ssQuerystr;
        $this->amExtraParameters['ssSortQuerystr'] = $this->ssSortQuerystr;
    }
	
	/**
    * Executes Document action
    *
    * @access public
    * @param sfRequest $request A request object
    */
    public function executeListDocuments(sfWebRequest $request)
    {
		$this->snCemeteryId = $this->getUser()->getAttribute('cemeteryid');
		
		//set search combobox field
		$this->amSearch = array();

		$omCommon = new common();
		
		// For Delete the Document.
		if($request->getParameter('admin_act') == "delete" && $request->getParameter('id'))            
		{
			$amCemeteryDocs = Doctrine::getTable('CemCemeteryDocs')->getCemeteryDocsAsPerIds($request->getParameter('id'));
			if(count($amCemeteryDocs) > 0)
			{
				foreach($amCemeteryDocs as $asDataSet)
					sfGeneral::removeFile(sfConfig::get('sf_upload_dir').'/'.sfConfig::get('app_cemetery_doc_path').'/'.$this->snCemeteryId.'/'.$asDataSet['doc_path']);				

				$omCommon->DeleteRecordsComposite('CemCemeteryDocs', $request->getParameter('id'),'id');
				$this->getUser()->setFlash('snSuccessMsgKey', 3);
			}
		}
		// For Download the Document
		if($request->getParameter('type') == 'download')
		{
			$ssFilename = base64_decode($request->getParameter('filename'));
			sfGeneral::downloadFile(sfConfig::get('app_cemetery_doc_path').'/'.$this->snCemeteryId.'/'.$ssFilename);
		}

		$oCemeteryDocsPageListQuery = Doctrine::getTable('CemCemeteryDocs')->getCemeteryDocs($this->amExtraParameters, $this->amSearch);

		// Set pager and get results
		$oPager               = new sfMyPager();
		$this->oCemeteryDocsList  = $oPager->getResults('CemCemeteryDocs', $this->snPaging,$oCemeteryDocsPageListQuery,$this->snPage);
		$this->amCemeteryDocsList = $this->oCemeteryDocsList->getResults(Doctrine::HYDRATE_ARRAY);

		unset($oPager);

		// Total number of records
		$this->snPageTotalCemeteryDocsPages = $this->oCemeteryDocsList->getNbResults();

		if($request->getParameter('request_type') == 'ajax_request')
			$this->setTemplate('listCemeteryDocsUpdate');
	}
	/**
    * Executes Document action
    *
    * @access public
    * @param sfRequest $request A request object
    */
    public function executeUpload(sfWebRequest $oRequest)
    {
		$snIdCemeteryDocs = $oRequest->getParameter('id', '');
        $ssSuccessKey   = 6; // Success message key for add
        
        if($snIdCemeteryDocs != '')
        {
            $this->forward404Unless($oCemDocs = Doctrine::getTable('CemCemeteryDocs')->find($snIdCemeteryDocs));
            $this->oCemeteryDocForm = new CemCemeteryDocsForm($oCemDocs);
            $ssSuccessKey = 8; // Success message key for edit
        }
        else
			$this->oCemeteryDocForm = new CemCemeteryDocsForm();

		$this->snCemeteryId = $this->getUser()->getAttribute('cemeteryid');

		$this->getConfigurationFieldsForUploadDoc($this->oCemeteryDocForm);
		
		if($oRequest->isMethod('post'))
		{
			$amFormRequest = $oRequest->getParameter($this->oCemeteryDocForm->getName());
			$amFileRequest = $oRequest->getFiles($this->oCemeteryDocForm->getName());
			$this->oCemeteryDocForm->bind($amFormRequest,$amFileRequest);
			
			if($this->oCemeteryDocForm->isValid())
			{
				// For Create cemetery doc directory if not exists
				sfGeneral::createDirectory(sfConfig::get('sf_upload_dir').'/'.sfConfig::get('app_cemetery_doc_path'));

				// For Create cemetery id directory if not exists
				sfGeneral::createDirectory(sfConfig::get('sf_upload_dir').'/'.sfConfig::get('app_cemetery_doc_path').'/'.$this->snCemeteryId);

				// For Upload Doc.
				$oFile = $this->oCemeteryDocForm->getValue('doc_path');

                // While edit document remove old doc.
                if(!empty($oFile))
                {
                    // Remove old Image while upload new grave image1
                    if(isset($oCemDocs))
                    {
                        if($oCemDocs->getDocPath() != '')
                          sfGeneral::removeFile(sfConfig::get('sf_upload_dir').'/'.sfConfig::get('app_cemetery_doc_path').'/'.$this->snCemeteryId.'/'.$oCemDocs->getDocPath());
                    }
                    $ssFileName = uniqid().'_'.sha1($oFile->getOriginalName());
                    $amExtension = explode('.',$oFile->getOriginalName());
                    $ssExtentions =  ((count($amExtension) > 0) ? '.'.end($amExtension) : '');
                    $ssFileName = $ssFileName.$ssExtentions;
                  
                    $oFile->save(sfConfig::get('sf_upload_dir').'/'.sfConfig::get('app_cemetery_doc_path').'/'.$this->snCemeteryId.'/'.$ssFileName);
                }
				
				// For Save records.	
				$oSaveForm = $this->oCemeteryDocForm->getObject();
				$oSaveForm->setCemCemeteryId($amFormRequest['cem_cemetery_id']);
				$oSaveForm->setDocName($amFormRequest['doc_name']);
				$oSaveForm->setDocDescription($amFormRequest['doc_description']);
				$oSaveForm->setCreatedAt(date('Y-m-d H:i:s'));
				$oSaveForm->setUpdatedAt(date('Y-m-d H:i:s'));

                if(!empty($oFile) > 0)
                  $oSaveForm->setDocPath($ssFileName);

				$oSaveForm->save();
				
				$this->getUser()->setFlash('snSuccessMsgKey', $ssSuccessKey);   //Set messages for add and update records
				$this->redirect('cemeterydocs/listDocuments?'.$this->amExtraParameters['ssQuerystr']);
			}
		}
	}
    /**
    * Executes Document action
    *
    * @access public
    * @param sfRequest $request A request object
    */
    public function executeSendDocument(sfWebRequest $oRequest)
    {
		$this->snCemeteryId = $this->getUser()->getAttribute('cemeteryid');
		$this->ssFilename = base64_decode($oRequest->getParameter('filename'));

		$this->oSendDocumentForm = new SendDocumentForm();
		$this->getConfigurationFieldsForSendDoc($this->oSendDocumentForm);
		
		if($oRequest->isMethod('post'))
		{
			$amFormRequest = $oRequest->getParameter($this->oSendDocumentForm->getName());
			$this->oSendDocumentForm->bind($amFormRequest);
			
			$this->ssFilename = base64_decode($amFormRequest['filename']);
			if($this->oSendDocumentForm->isValid())
			{
				$ssMimeType = shell_exec("file -bi " . sfConfig::get('sf_upload_dir').'/'.sfConfig::get('app_cemetery_doc_path').'/'.$this->snCemeteryId.'/'.$this->ssFilename);
				
				// File get content
				$ssContent = file_get_contents(sfConfig::get('sf_upload_dir').'/'.sfConfig::get('app_cemetery_doc_path').'/'.$this->snCemeteryId.'/'.$this->ssFilename);
			
				$ssFromEmailId = sfConfig::get('app_admin_emailid');
				if(!$this->getUser()->isSuperAdmin() && $this->getUser()->getAttribute('cemeteryid') != '')
				{
					$oCemetery = Doctrine::getTable('CemCemetery')->find($this->getUser()->getAttribute('cemeteryid'));
					$ssFromEmailId = ($oCemetery->getEmail() != '') ? $oCemetery->getEmail() : sfConfig::get('app_admin_emailid');
				}
				// Send Document.
				$ssMessage = Swift_Message::newInstance()
						  ->setFrom($ssFromEmailId)
						  ->setTo($amFormRequest['mail_to'])
						  ->setSubject($amFormRequest['mail_subject'])
						  ->setBody($amFormRequest['mail_body'],'text/html')
						  ->attach(Swift_Attachment::newInstance($ssContent,$this->ssFilename,'$ssMimeType'));
						 
				$oSend = sfContext::getInstance()->getMailer()->send($ssMessage);
				
				$snMsgKey = ($oSend) ? 9 : 4;

				$this->getUser()->setFlash('snSuccessMsgKey', $snMsgKey);   //Set messages for add and update records
				$this->redirect('cemeterydocs/listDocuments');
			}
		}		
	}
	private function getConfigurationFieldsForSendDoc($oForm)
    {
		$oForm->setWidgets(array());
		
		 $oForm->setLabels(
            array(
				'mail_to'			=> __('To'),
				'mail_subject'		=> __('Subject'),
				'mail_body'			=> __('Body'),
				 )
        );
		$oForm->setValidators(
            array(
    	            'mail_to'    	=> array('required'  	=> __('Please enter email id'),'invalid'  	=> __('Please enter valid email id')),
					'mail_subject'	=> array('required'  	=> __('Please enter email subject')),
					'mail_body'		=> array('required'  	=> __('Please enter email body'))
				)
        );				
	}
	
    private function getConfigurationFieldsForUploadDoc($oForm)
    {
		$oForm->setWidgets(array());
		
		 $oForm->setLabels(
            array(
				'doc_name'			=> __('Name'),
				'doc_description'	=> __('Description'),
				'doc_path'			=> __('Select File'),
				 )
        );
		$oForm->setValidators(
            array(
    	            'doc_name'    	=> array('required'  => __('Please enter document name')),
					'doc_path'		=> array('required'  	=> __('Please select document'))
				)
        );				
	}
}
