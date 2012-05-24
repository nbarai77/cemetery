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
class stonemasondocsActions extends sfActions
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
									8 => __('Document has been successfully updated')
                                );

		$this->amErrorMsg   = array(
									1 => __('Select atleast one'), 
									2 => __('Some information was missing'),
									3 => __('This page is in a restricted area')
									);
        $this->ssFormName = 'frm_list_stonemason_docs';
        $omRequest        = sfContext::getInstance()->getRequest();

        // Set default values
        $this->amExtraParameters = array();
        $this->amExtraParameters['snPaging']        = $this->snPaging       = $omRequest->getParameter('paging',sfConfig::get('app_default_paging_records'));
        $this->amExtraParameters['snPage']          = $this->snPage         = $omRequest->getParameter('page', sfConfig::get('app_default_page', 1));
        $this->amExtraParameters['ssSortBy']        = $this->ssSortBy       = $omRequest->getParameter('sortby','id');
        $this->amExtraParameters['ssSortMode']      = $this->ssSortMode     = $omRequest->getParameter('sortmode','asc');

        $this->ssSortQuerystr = $this->ssQuerystr = 'page='.$this->snPage.'&paging='.$this->snPaging;

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
        $this->amSearch = array();
        $omCommon = new common();

		// Delete Records.
        if($request->getParameter('admin_act') == "delete" && $request->getParameter('id_user'))            
        {
            $omCommon->DeleteRecordsComposite('sfGuardUser', $request->getParameter('id_user'),'id');
            $omCommon->DeleteRecordsComposite('UserCemetery', $request->getParameter('id_user'),'user_id');
            $this->getUser()->setFlash('snSuccessMsgKey', 3);      
        }

        // Get stonemason list for listing.
        $oStonemasonPageListQuery = Doctrine::getTable('sfGuardUser')->getsfGuardStonemasonList($this->amExtraParameters, $this->amSearch);

        // Set pager and get results
        $oPager               = new sfMyPager();
        $this->oStonemasonList  = $oPager->getResults('sfGuardUser', $this->snPaging,$oStonemasonPageListQuery,$this->snPage);
        $this->amStonemasonList = $this->oStonemasonList->getResults(Doctrine::HYDRATE_ARRAY);

        unset($oPager);

        // Total number of records
        $this->snPageTotalStonemasonPages = $this->oStonemasonList->getNbResults();

        if($request->getParameter('request_type') == 'ajax_request')
            $this->setTemplate('listStonemasonUpdate');
    }

	/**
    * Executes Document action
    *
    * @access public
    * @param sfRequest $request A request object
    */
    public function executeListDocuments(sfWebRequest $request)
    {
		$this->snStoneMasonId	= $request->getParameter('id_stonemason','');


		$this->snCemeteryId = $this->getUser()->getAttribute('cemeteryid');
		$this->snStoneMasonId = ($this->snStoneMasonId != '') ? $this->snStoneMasonId : $this->getUser()->getAttribute('userid');
		
		//set search combobox field
		$this->amSearch = array();

		$omCommon = new common();
		
		// For Delete the Document.
		if($request->getParameter('admin_act') == "delete" && $request->getParameter('id'))            
		{
			$amStonemasonDocs = Doctrine::getTable('CemStonemasonDocs')->getStonemasonDocsAsPerIds($request->getParameter('id'));
			if(count($amStonemasonDocs) > 0)
			{
				foreach($amStonemasonDocs as $asDataSet)
					sfGeneral::removeFile(sfConfig::get('sf_upload_dir').'/'.sfConfig::get('app_stonemason_doc_path').'/'.$this->snCemeteryId.'/'.$this->snStoneMasonId.'/'.$asDataSet['doc_path']);				

				$omCommon->DeleteRecordsComposite('CemStonemasonDocs', $request->getParameter('id'),'id');
				$this->getUser()->setFlash('snSuccessMsgKey', 3);
			}
		}
		// For Download the Document
		if($request->getParameter('type') == 'download')
		{
			$ssFileName = base64_decode($request->getParameter('filename'));
			sfGeneral::downloadFile(sfConfig::get('app_stonemason_doc_path').'/'.$this->snCemeteryId.'/'.$this->snStoneMasonId.'/'.$ssFileName);
		}
		$oStonemasonDocsPageListQuery = Doctrine::getTable('CemStonemasonDocs')->getStonemasonDocs($this->amExtraParameters, $this->amSearch,'',$this->snStoneMasonId);

		// Set pager and get results
		$oPager               = new sfMyPager();
		$this->oStonemasonDocsList  = $oPager->getResults('CemStonemasonDocs', $this->snPaging,$oStonemasonDocsPageListQuery,$this->snPage);
		$this->amStonemasonDocsList = $this->oStonemasonDocsList->getResults(Doctrine::HYDRATE_ARRAY);

		unset($oPager);

		// Total number of records
		$this->snPageTotalStonemasonDocsPages = $this->oStonemasonDocsList->getNbResults();

		if($request->getParameter('request_type') == 'ajax_request')
			$this->setTemplate('listStonemasonDocsUpdate');
	}
    /**
    * Executes Document action
    *
    * @access public
    * @param sfRequest $request A request object
    */
    public function executeUpload(sfWebRequest $oRequest)
    {
//		exec('rm -fR '.sfConfig::get('sf_upload_dir').'/'.sfConfig::get('app_stonemason_doc_path'));exit;

		$snIdStonmasonDocs = $oRequest->getParameter('id', '');
        $ssSuccessKey   = 6; // Success message key for add
        
        if($snIdStonmasonDocs != '')
        {
            $this->forward404Unless($oCemDocs = Doctrine::getTable('CemStonemasonDocs')->find($snIdStonmasonDocs));
            $this->oStonemasonDocForm = new CemStonemasonDocsForm($oCemDocs);
            $ssSuccessKey = 8; // Success message key for edit
        }
        else
			$this->oStonemasonDocForm = new CemStonemasonDocsForm();

		$this->snCemeteryId = $this->getUser()->getAttribute('cemeteryid');
		$this->snStoneMasonId = $this->getUser()->getAttribute('userid');

		$this->getConfigurationFieldsForUploadDoc($this->oStonemasonDocForm);
		
		if($oRequest->isMethod('post'))
		{
		
			$amFormRequest = $oRequest->getParameter($this->oStonemasonDocForm->getName());
			$amFileRequest = $oRequest->getFiles($this->oStonemasonDocForm->getName());

			if($amFormRequest['expiry_date'] != '' && $amFormRequest['expiry_date'] != '0000-00-00') 
			{
				list($snDay,$snMonth,$snYear) = explode('-',$amFormRequest['expiry_date']);
				$amFormRequest['expiry_date'] = $snYear.'-'.$snMonth.'-'.$snDay;
			}
									
			$this->oStonemasonDocForm->bind($amFormRequest,$amFileRequest);
			
			if($this->oStonemasonDocForm->isValid())
			{
				// For Create stonemason doc directory if not exists
				sfGeneral::createDirectory(sfConfig::get('sf_upload_dir').'/'.sfConfig::get('app_stonemason_doc_path'));
				
				// For Create cemetery id directory if not exists
				sfGeneral::createDirectory(sfConfig::get('sf_upload_dir').'/'.sfConfig::get('app_stonemason_doc_path').'/'.$this->snCemeteryId);

				// For Create stonemason id directory if not exists
				sfGeneral::createDirectory(sfConfig::get('sf_upload_dir').'/'.sfConfig::get('app_stonemason_doc_path').'/'.$this->snCemeteryId.'/'.$this->snStoneMasonId);

				// For Upload Doc.
				$oFile = $this->oStonemasonDocForm->getValue('doc_path');

                // While edit document remove old doc.
                if(!empty($oFile))
                {
                    // Remove old Image while upload new grave image1
                    if(isset($oCemDocs))
                    {
                        if($oCemDocs->getDocPath() != '')
                          sfGeneral::removeFile(sfConfig::get('sf_upload_dir').'/'.sfConfig::get('app_stonemason_doc_path').'/'.$this->snCemeteryId.'/'.$this->snStoneMasonId.'/'.$oCemDocs->getDocPath());
                    }
                    $ssFileName = uniqid().'_'.sha1($oFile->getOriginalName());
                    $amExtension = explode('.',$oFile->getOriginalName());
                    $ssExtentions =  ((count($amExtension) > 0) ? '.'.end($amExtension) : '');
                    $ssFileName = $ssFileName.$ssExtentions;
                  
                    $oFile->save(sfConfig::get('sf_upload_dir').'/'.sfConfig::get('app_stonemason_doc_path').'/'.$this->snCemeteryId.'/'.$this->snStoneMasonId.'/'.$ssFileName);
                }

				// For Save records.	
				$oSaveForm = $this->oStonemasonDocForm->getObject();
				$oSaveForm->setUserId($this->getUser()->getAttribute('userid'));
				$oSaveForm->setCemCemeteryId($this->getUser()->getAttribute('cemeteryid'));
				$oSaveForm->setDocName($amFormRequest['doc_name']);
				$oSaveForm->setDocDescription($amFormRequest['doc_description']);
				$oSaveForm->setExpiryDate($amFormRequest['expiry_date']);
				$oSaveForm->setCreatedAt(date('Y-m-d H:i:s'));
				$oSaveForm->setUpdatedAt(date('Y-m-d H:i:s'));

                if(!empty($oFile) > 0)
                  $oSaveForm->setDocPath($ssFileName);

				$oSaveForm->save();
				
				$this->getUser()->setFlash('snSuccessMsgKey', $ssSuccessKey);   //Set messages for add and update records
				$this->redirect('stonemasondocs/listDocuments?'.$this->amExtraParameters['ssQuerystr']);
			}
		}
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
