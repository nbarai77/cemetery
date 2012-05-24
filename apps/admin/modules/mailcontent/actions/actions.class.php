<?php
/**
 * CemCemetery actions.
 *
 * @package    Cemetery
 * @subpackage CemCemetery
 * @author     Prakash Panchal
 */
sfProjectConfiguration::getActive()->loadHelpers(array('I18N'));
class mailcontentActions extends sfActions
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
        $this->ssFormName = 'frm_list_mailcontent';
        $omRequest        = sfContext::getInstance()->getRequest();

        // Set default values
        $this->amExtraParameters = array();
        $this->amExtraParameters['snPaging']        	= $this->snPaging       	= $omRequest->getParameter('paging',sfConfig::get('app_default_paging_records'));
        $this->amExtraParameters['snPage']          	= $this->snPage         	= $omRequest->getParameter('page', sfConfig::get('app_default_page', 1));
        $this->amExtraParameters['ssSearchName']   		= $this->ssSearchName  		= trim($omRequest->getParameter('searchName',''));
        $this->amExtraParameters['ssSearchIsEnabled']   = $this->ssSearchIsEnabled  = trim($omRequest->getParameter('searchIsEnabled',''));        
        $this->amExtraParameters['ssSortBy']        	= $this->ssSortBy       	= $omRequest->getParameter('sortby','id');
        $this->amExtraParameters['ssSortMode']      	= $this->ssSortMode     	= $omRequest->getParameter('sortmode','asc');
        
        $this->ssType = $omRequest->getParameter('type', 'letter');
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

        $this->ssQuerystr .= '&type='.$this->ssType; // Type parameter
        $this->ssSortQuerystr .= '&type='.$this->ssType; // Type parameter

        $this->amExtraParameters['ssQuerystr']     = $this->ssQuerystr;
        $this->amExtraParameters['ssSortQuerystr'] = $this->ssSortQuerystr;
    }

   /**
    * Executes index action
    *
    * @access public
    * @param sfRequest $request A request object
    */
    public function executeCustomCemetery(sfWebRequest $oRequest)
    {
		if($oRequest->getParameter('back') != 'true')
		{
			$this->getUser()->setAttribute('countryid', '');
			$this->getUser()->setAttribute('cemeteryid', '');
		}
		
		$this->snCementeryId = $oRequest->getParameter('customcemetery_cem_cemetery_id', '');
		$this->asCementery = $this->amMailContentList = array();
		$this->oMailContentList = '';
		$this->snPageTotalMailContentPages = 0;

		$this->oCustomCemeteryForm = new CustomCemeteryForm();	
		$this->getConfigurationFieldsForCustomCemetery($this->oCustomCemeteryForm);
		
		$amFormRequest = $oRequest->getParameter($this->oCustomCemeteryForm->getName());
		
		$this->snCementeryId = isset($amFormRequest['cem_cemetery_id']) ? $amFormRequest['cem_cemetery_id'] : $this->snCementeryId;
		
		if($amFormRequest['country_id'] != '')
			$this->asCementery = Doctrine::getTable('CemCemetery')->getAllCemeteries($amFormRequest['country_id']);
		
		if($oRequest->isMethod('post'))
		{
			$this->oCustomCemeteryForm->bind($amFormRequest);
			
			if($this->oCustomCemeteryForm->isValid() && $oRequest->getParameter('customcemetery_cem_cemetery_id') != '')
			{
				$this->getUser()->setAttribute('countryid', $amFormRequest['country_id']);				
				$this->getUser()->setAttribute('cemeteryid', $this->snCementeryId);
				$this->redirect('mailcontent/index?type='.$this->ssType);
			}
			else
			{
				if($oRequest->getParameter('customcemetery_cem_cemetery_id') == '')
					$this->getUser()->setFlash('ssErrorCemeter',__('Please select cemetery'));
			}
		}
	}
   /**
    * Executes index action
    *
    * @access public
    * @param sfRequest $request A request object
    */
    public function executeIndex(sfWebRequest $oRequest)
    {
        //set search combobox field
        $this->amSearch = array();

        $omCommon = new common();

		$this->snCemeteryId = $this->getUser()->getAttribute('cemeteryid');

		// Get cms page list for listing.
		$oMailContentPageListQuery = Doctrine::getTable('MailContent')->getMailContents($this->amExtraParameters, $this->amSearch,'', $this->snCemeteryId, $this->ssType);

		// Set pager and get results
		$oPager               = new sfMyPager();
		$this->oMailContentList  = $oPager->getResults('MailContent', $this->snPaging,$oMailContentPageListQuery,$this->snPage);
		$this->amMailContentList = $this->oMailContentList->getResults(Doctrine::HYDRATE_ARRAY);

		unset($oPager);

		// Total number of records
		$this->snPageTotalMailContentPages = $this->oMailContentList->getNbResults();

        if($oRequest->getParameter('request_type') == 'ajax_request')
            $this->setTemplate('listMailContentUpdate');
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
            $this->forward404Unless($oMailContent = Doctrine::getTable('MailContent')->find($snIdGuardGroup));
            $this->oMailContentForm = new MailContentForm($oMailContent);
            $ssSuccessKey = 2; // Success message key for edit
        }
        else {
            $this->oMailContentForm = new MailContentForm();
		}

        $this->getConfigurationFields($this->oMailContentForm);

        if($oRequest->isMethod('post'))
        {
            $this->oMailContentForm->bind($oRequest->getParameter($this->oMailContentForm->getName()),$oRequest->getFiles($this->oMailContentForm->getName()));

            if($this->oMailContentForm->isValid())
            {
				// Save Records
				$snIdMailContent = $this->oMailContentForm->save()->getId();
				
                $this->getUser()->setFlash('snSuccessMsgKey', $ssSuccessKey);   //Set messages for add and update records
               	$this->redirect('mailcontent/index?customcemetery_cem_cemetery_id='.$oMailContent->getCemCemeteryId().'&'.$this->amExtraParameters['ssQuerystr']);
            }
        }
    }
	
	/**
     * Executes executeSelectdate action
     *
     * @access public
     * @param sfRequest $request A request object
     */
    public function executeSelectdate(sfWebRequest $oRequest)
    {
		$this->oSummaryForm = new SummaryForm();
		$this->getConfigurationFieldsForServiceDate($this->oSummaryForm);
		
		$amSummaryRequestParameter = $oRequest->getParameter($this->oSummaryForm->getName());		
		if($oRequest->isMethod('post'))
		{			
			$this->ssServiceDate = (isset($amSummaryRequestParameter['service_date'])) ? $amSummaryRequestParameter['service_date'] : $oRequest->getParameter('service_date');
			
			$ssServiceDateFormated = date('Y-m-d',strtotime($this->ssServiceDate));
			$this->oBurialSummaryPageListQuery = Doctrine::getTable('IntermentBooking')->getTodaySummary($ssServiceDateFormated, sfConfig::get('app_service_type_id_interment'));
			
			$asBurialSummaryPageList = $this->oBurialSummaryPageListQuery->fetchArray();
			
			// pdf object
			$oPDF = new sfTCPDF();
			
			// set document information
			$oPDF->SetCreator(PDF_CREATOR);
			$oPDF->SetAuthor('Cemetery');
			$oPDF->SetTitle('Grantee Grave Details');
			$oPDF->SetSubject('Grantee Grave Details');
			$oPDF->SetKeywords('Grantee, Grave');
			
			// set default header data
			$oPDF->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 001', PDF_HEADER_STRING);
			
			// set header and footer fonts
			$oPDF->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
			$oPDF->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
			
			// set default monospaced font
			$oPDF->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
			
			//set margins
			$oPDF->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
			$oPDF->SetHeaderMargin(PDF_MARGIN_HEADER);
						
			//set auto page breaks
			$oPDF->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
			
			// Add a page
			// This method has several options, check the source code documentation for more information.
			$oPDF->AddPage();
			
			// Get mail content 
			$oMailContent = Doctrine::getTable('MailContent')->findOneById($oRequest->getParameter('id'));
			
			//////////////////////////////////////////////////
            // 		REPLACE STATIC VARIABLES WITH VALUE		//
            //////////////////////////////////////////////////
            $asStaticVariables = sfGeneral::getAllStringBetween($oMailContent->getContent(),'{','}');					
            $amMailParams = array();
			
			foreach($asStaticVariables as $snKey => $ssValue)
				$amMailParams['{'.$ssValue.'}'] = sfGeneral::getValueOfStaticVariables($ssValue, $asBurialSummaryPageList);

			$asDetail = array();
			foreach($amMailParams as $ssColumnDetail=>$asValue)
			{
				if($ssColumnDetail != '{SELECTED_DATE}')
				{
					if(is_array($asValue) && !empty($asValue))
					{
						foreach($asValue as $snKey=>$ssValue)
							$asDetail[$snKey][$ssColumnDetail]	 = $ssValue;
					}
				}
			}			
			$ssString = sfGeneral::getAllStringBetween($oMailContent->getContent(),'<div id="commonletter">','</div>');
			$ssString = $ssString[0];
			
            $ssReplaceString = '';
			
			foreach($asDetail as $aSubData)
			{
               	if($ssReplaceString=='')
					$ssReplaceString = $ssString;
				else
					$ssReplaceString.="<br>".$ssString;
					
				foreach($aSubData as $ssKey=>$ssValue)
				{
					$ssReplaceString = str_replace($ssKey,$ssValue,$ssReplaceString);
				}
			}
			
			$substr = sfGeneral::getAllStringBetween($oMailContent->getContent(),'<div id="commonletter">','</div>');
			
			$ssHTML = str_replace($substr[0],$ssReplaceString,$oMailContent->getContent());
           
            $asStaticVariablee = sfGeneral::getAllStringBetween($ssHTML,'{','}');
			
 			$ssServiceDateFormated = date('l jS F, Y',strtotime($this->ssServiceDate)); 			
			foreach($asStaticVariablee as $snKey => $ssValue)
                $amMailParam['{'.$ssValue.'}'] = sfGeneral::getValueOfStaticVariables($ssValue, $ssServiceDateFormated);
            
            $ssHTML = sfGeneral::replaceMailContent($ssHTML, $amMailParam);
			
			
			$ssFileName = 'commonLetter.pdf';
			// Print text using writeHTML()
			$oPDF->writeHTML($ssHTML);
			
			// Close and output PDF document
			// This method has several options, check the source code documentation for more information.
			$oPDF->Output($ssFileName, 'I');
			
			exit;
		}
		else
		{
			$this->ssServiceDate = date('d-m-Y');
			$amSummaryRequestParameter['service_date'] = $this->ssServiceDate;
		}
	}
	
	/**
    * Executes listStaticVariables action
    *
    * @access public
    * @param sfRequest $request A request object
    */
    public function executeListStaticVariables(sfWebRequest $oRequest)
    {
		
	}
	/**
    * Executes getCementryListAsPerCountry action
    *
    * @access public
    * @param sfRequest $request A request object
    */
    public function executeGetCementryListAsPerCountry(sfWebRequest $request)
    {
		$snCementeryId = $request->getParameter('cnval','');		
		$snIdCountry = $request->getParameter('id','');	
		$asCementery = Doctrine::getTable('CemCemetery')->getAllCemeteries($snIdCountry);
		return $this->renderPartial('getCementeryList', array('asCementryList' => $asCementery,'snCementeryId' => $snCementeryId));
	}

	/**
     * getConfigurationFields
     *
     * Function for prepare configuration fields for form
     * @access private
     * @param  object $oForm form object
     *     
     */
    private function getConfigurationFieldsForServiceDate($oForm)
    {
        $oForm->setWidgets(array());

        $oForm->setLabels(
            array(
				'service_date'       => __('Service Date')
            )
        );

        $oForm->setValidators(array());
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
				'subject'	=> __('Subject'),
                'content'	=> __('Content')
            )
        );
		
        $oForm->setValidators(
            array(
                'subject'	=> array('required'	=> __('Please enter subject')),
    	        'content'	=> array('required'	=> __('Please enter content'))
            )
        );
    }
	/**
     * getConfigurationFieldsForCustomCemetery
     *
     * Function for prepare configuration fields for form
     * @access private
     * @param  object $oForm form object
     *     
     */
    private function getConfigurationFieldsForCustomCemetery($oForm)
    {
        $oForm->setWidgets(
			array(
					'cem_cemetery_id' 	=> __('Select Cemetery'),
					'country_id'		=> __('Select Country'),
				 )
		);
		
		if(sfContext::getInstance()->getRequest()->getParameter('back'))
			$oForm->setDefault('country_id', $this->getUser()->getAttribute('countryid'));

        $oForm->setLabels(
            array(
				'country_id'       	=> __('Country'),
				'cem_cemetery_id'  	=> __('Cemetery'),
            )
        );

        $oForm->setValidators(
            array(
    	            'country_id'        => array(
														'required'  => __('Please select country')
												),
    	            'cem_cemetery_id'        => array(
														'required'  => __('Please select cemetery')
												),
				)
        );
    }
}
