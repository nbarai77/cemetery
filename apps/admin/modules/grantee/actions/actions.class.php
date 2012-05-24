<?php
/**
 * Grave actions.
 *
 * @package    Cemetery
 * @subpackage Grave
 * @author     Prakash Panchal
 * @author     Arpita Rana 
 *
 */
sfProjectConfiguration::getActive()->loadHelpers(array('I18N','Url','Partial'));
class granteeActions extends sfActions
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
									5 => __('Grave has been successfully surrendered to another grantee')                                    
                                );

        $this->amErrorMsg = array(1 => __('Please select at least one'),
                                  2 => __('No record found for this selected date'));
        $this->ssFormName = 'frm_list_grantee';
        $omRequest        = sfContext::getInstance()->getRequest();

        // Set default values
        $this->amExtraParameters = array();
        $this->amExtraParameters['snPaging']        = $this->snPaging       = $omRequest->getParameter('paging',sfConfig::get('app_default_paging_records'));
        $this->amExtraParameters['snPage']          = $this->snPage         = $omRequest->getParameter('page', sfConfig::get('app_default_page', 1));
        $this->amExtraParameters['ssSearchGranteeFirstName']   	= $this->ssSearchGranteeFirstName  	= trim($omRequest->getParameter('searchGranteeFirstName',''));
        $this->amExtraParameters['ssSearchGranteeMiddleName']   	= $this->ssSearchGranteeMiddleName  	= trim($omRequest->getParameter('searchGranteeMiddleName',''));
        $this->amExtraParameters['ssSearchGranteeSurname']   	= $this->ssSearchGranteeSurname  	= trim($omRequest->getParameter('searchGranteeSurname',''));
        $this->amExtraParameters['ssSortBy']        = $this->ssSortBy       = $omRequest->getParameter('sortby','id');
        $this->amExtraParameters['ssSortMode']      = $this->ssSortMode     = $omRequest->getParameter('sortmode','desc');

        $this->ssSortQuerystr = $this->ssQuerystr = 'page='.$this->snPage.'&paging='.$this->snPaging;

        if($this->getRequestParameter('searchGranteeFirstName') != '' )        // Search parameters
        {
            $this->ssQuerystr    .= '&searchGranteeFirstName='.$this->getRequestParameter('searchGranteeFirstName');
            $this->ssSortQuerystr.= '&searchGranteeFirstName='.$this->getRequestParameter('searchGranteeFirstName');
        }

        if($this->getRequestParameter('searchGranteeMiddleName') != '' )        // Search parameters
        {
            $this->ssQuerystr    .= '&searchGranteeMiddleName='.$this->getRequestParameter('searchGranteeMiddleName');
            $this->ssSortQuerystr.= '&searchGranteeMiddleName='.$this->getRequestParameter('searchGranteeMiddleName');
        }

        if($this->getRequestParameter('searchGranteeSurname') != '' )        // Search parameters
        {
            $this->ssQuerystr    .= '&searchGranteeSurname='.$this->getRequestParameter('searchGranteeSurname');
            $this->ssSortQuerystr.= '&searchGranteeSurname='.$this->getRequestParameter('searchGranteeSurname');
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
								'grantee_first_name' => array(
												'caption'	=> __('First Name'),
												'id'		=> 'GranteeFirstName',
												'type'		=> 'text',																								
											),
								'grantee_surname' => array(
												'caption'	=> __('Surname'),
												'id'		=> 'GranteeSurname',
												'type'		=> 'text',										
											)
							);

        $omCommon = new common();

        if($request->getParameter('admin_act') == "delete" && $request->getParameter('id'))            
        {
			// FOR UPDATE user_id FOR WHO DELETE THE RECORDS.
			$omCommon->UpdateStatusComposite('Grantee','user_id', $request->getParameter('id'), $this->getUser()->getAttribute('userid'), 'id');
			
            $omCommon->DeleteRecordsComposite('Grantee', $request->getParameter('id'),'id');
            $this->getUser()->setFlash('snSuccessMsgKey', 3);      
        }

        // Get Grantee Page list for listing.
		$this->snGranteeId = $request->getParameter('grantee_id', '');
		$bGranteeExists = true;
		if($this->snGranteeId)
		{ 	
			$oGranteeDetails = Doctrine::getTable('GranteeDetails')->find($this->snGranteeId);
			if($oGranteeDetails) $this->snGranteeId = $oGranteeDetails->getId(); 
			else
				$bGranteeExists = false;
		}
		else
			$bGranteeExists = false;
		
		if(!$bGranteeExists)
			$this->redirect('granteedetails/index?'.$this->amExtraParameters['ssQuerystr']);

		$this->snCementeryId = $request->getParameter('cemetery_id', '');

        $oGranteePageListQuery = Doctrine::getTable('Grantee')->getGranteeList($this->amExtraParameters, $this->amSearch, '',$this->snGranteeId);

        // Set pager and get results
        $oPager               = new sfMyPager();
        $this->oGranteeList  = $oPager->getResults('Grantee', $this->snPaging,$oGranteePageListQuery,$this->snPage);
        $this->amGranteeList = $this->oGranteeList->getResults(Doctrine::HYDRATE_ARRAY);        
        unset($oPager);

        // Total number of records
        $this->snPageTotalGranteePages = $this->oGranteeList->getNbResults();

        if($request->getParameter('request_type') == 'ajax_request')
            $this->setTemplate('listGranteeUpdate');
    }

   /**
    * Executes Grantee invoce export action
    *
    * @access public
    * @param sfRequest $request A request object


    */

    public function executeGranteeInvoice(sfWebRequest $oRequest)
    {
         //set search combobox field
        $this->amSearch = array(
								'grantee_first_name' => array(
												'caption'	=> __('First Name'),
												'id'		=> 'GranteeFirstName',
												'type'		=> 'text',																								
											),
								'grantee_surname' => array(
												'caption'	=> __('Surname'),
												'id'		=> 'GranteeSurname',
												'type'		=> 'text',										
											)
							);

        $omCommon = new common();
       
        // Get Grantee Page list for listing.
        $this->snCementeryId = $this->getUser()->getAttribute('cemeteryid');

        $oGranteePageListQuery = Doctrine::getTable('Grantee')->getGranteeListAll($this->amExtraParameters, $this->amSearch, '','');
        
        // Set pager and get results
        $oPager               = new sfMyPager();
        $this->oGranteeList  = $oPager->getResults('Grantee', $this->snPaging,$oGranteePageListQuery,$this->snPage);
        $this->amGranteeList = $this->oGranteeList->getResults(Doctrine::HYDRATE_ARRAY);        
        
        unset($oPager);
        
        $this->oGravePlotReportForm = new ServiceReportForm();        
        $this->getExportConfigurationFields($this->oGravePlotReportForm);
        
        $amGraveFormRequest = $oRequest->getParameter($this->oGravePlotReportForm->getName());
        
        if($oRequest->isMethod('post') && $oRequest->getParameter('request_type') != 'ajax_request')
       	{			
            $this->ssFromDate 	= ((isset($amGraveFormRequest['from_date']) && $amGraveFormRequest['from_date'] != '') ? $amGraveFormRequest['from_date'] : '');
			$this->ssToDate		= ((isset($amGraveFormRequest['to_date']) && $amGraveFormRequest['to_date'] != '') ? $amGraveFormRequest['to_date'] : '');

			// FOR SERVICE REPORT AS PER BETWEEN FROM AND TO DATE
			if($this->ssToDate != '')
			{
				$ssFormatedFromDate = (($this->ssFromDate != '') ?date('Y-m-d', strtotime($this->ssFromDate)):'');
                $ssFormatedToDate = date('Y-m-d', strtotime($this->ssToDate));
                $asServiceReport = Doctrine::getTable('Grantee')->getGranteeListAll($this->amExtraParameters, $this->amSearch,'','','',$ssFormatedFromDate, $ssFormatedToDate)->fetchArray();
            }
            
            if(isset($asServiceReport) && count($asServiceReport) > 0)
            {
                $ssFilename = "Invoices.csv"; 
                $this->getResponse()->setHttpHeader('Content-Disposition', 'attachment; filename=' . basename($ssFilename));
                $this->getResponse()->setContentType('text/csv;charset=ISO-8859-2');
                $ssContents = "";
                $ssContents .= 'Deceased Name,Catalog Name,Cost Price,Special Cost Price, Service Type Name';
                $ssContents .= "\n"; 
                foreach($asServiceReport as $snKey=>$asValues)
                {
                    $ssContents .= $asValues['grantee_surname'].' '.$asValues['grantee_first_name'].","; 
                    $ssContents .= $asValues['catalog_name'].",";
                    $ssContents .= $asValues['cost_price'].",";
                    $ssContents .= $asValues['special_cost_price'].",";
                    //$ssContents .= $asValues['service_type_name'].",";
                    $ssContents .= ($asValues['payment_id'] == 1 ? 'Credit' : ($asValues['payment_id'] == 2 ? 'Waiting' : ($asValues['payment_id'] == 3 ? 'Pending' : '')))."";
                    $ssContents .= "\n"; 
                }
                
                $this->getResponse()->setContent($ssContents);        
                $this->getResponse()->sendHttpHeaders();
                
                return sfView::NONE;
            }
            else
                $this->getUser()->setFlash('snErrorMsgKey', 2);
		}

        // Total number of records
        $this->snPageTotalGranteePages = $this->oGranteeList->getNbResults();

        if($oRequest->getParameter('request_type') == 'ajax_request')
            $this->setTemplate('listGranteeUpdateInvoice');
    }

	/**
    * Executes ViewHistory action
    *
    * @access public
    * @param sfRequest $request A request object
    */
	public function executeViewHistory(sfWebRequest $request)
	{
		$this->ssFormName = 'frm_list_grantee_grave_history';
		$this->snGranteeId = $request->getParameter('grantee_id','');
		$this->amSearch = array();
        $omCommon = new common();
		
        if($request->getParameter('admin_act') == "delete" && $request->getParameter('id'))
        {
            $omCommon->DeleteRecordsComposite('GranteeGraveHistory', $request->getParameter('id'),'id');
            $this->getUser()->setFlash('snSuccessMsgKey', 3);      
        }
		$this->snIdGrave = $request->getParameter('grave_id','');
        $oGranteeGraveHistoryPageListQuery = Doctrine::getTable('GranteeGraveHistory')->getGranteeGraveHistory($this->amExtraParameters, $this->amSearch,'',$this->snIdGrave);

        // Set pager and get results
        $oPager               = new sfMyPager();
        $this->oGranteeGraveHistoryList  = $oPager->getResults('GranteeGraveHistory', $this->snPaging,$oGranteeGraveHistoryPageListQuery,$this->snPage);
        $this->amGranteeGraveHistoryList = $this->oGranteeGraveHistoryList->getResults(Doctrine::HYDRATE_ARRAY);

        unset($oPager);

        // Total number of records
        $this->snPageTotalGranteeGraveHistoryPages = $this->oGranteeGraveHistoryList->getNbResults();

        if($request->getParameter('request_type') == 'ajax_request')
            $this->setTemplate('listGranteeGraveHistoryUpdate');
	}
	/**
    * Executes ViewHistory action
    *
    * @access public
    * @param sfRequest $request A request object
    */
	public function executeChangeTransferDate(sfWebRequest $oRequest)
	{
		$snHistoryId = $oRequest->getParameter('id_history');

		$ssTransferDate = trim($oRequest->getParameter('transf_date',''));
		$ssTransferDate = ($ssTransferDate != '') ? date('Y-m-d',strtotime($oRequest->getParameter('transf_date')) ) : date('Y-m-d');

		// UPDATE TRANSFER DATE INTO HISTORY TABLE.
		GranteeGraveHistory::updateGraveHistoryField('surrender_date',$ssTransferDate,'id',$snHistoryId);
					
		$oResultGraveHistory = Doctrine::getTable('GranteeGraveHistory')->find($snHistoryId);

		return $this->renderPartial('transferDate', array('snHistoryId' => $oResultGraveHistory->getId(), 
														  'ssTransferDate' => date('d-m-Y',strtotime( $oResultGraveHistory->getSurrenderDate() )) 
														  )
									);
	}
    
    /**
     * Executes GenerateGranteeInvoice action
     *
     * @access public
     * @param sfRequest $request A request object
     */
    public function executeGenerateGranteeInvoice(sfWebRequest $oRequest)
    {        
        $snGranteeId = $oRequest->getParameter('grantee_id','');
        $this->oGranteePageListQuery = Doctrine::getTable('Grantee')->getGranteeListAll($this->amExtraParameters, $this->amSearch, '',$snGranteeId,true)->fetchArray();
        $ssContent = '';        
        if(count($this->oGranteePageListQuery) > 0)
        {
            $ssContent .= '<table><tr><td>Invoices</td><td></td><td></td><td></td><td>'.date('d-m-Y H:m').'</td></tr></table>';
            $ssContent .= '<table cellspacing="0" cellpadding="0" border="1">            
            <tr><td>Grantee</td><td>Payment name</td><td>Cost price</td><td>Special price</td><td>Payment status</td></tr>';
            foreach($this->oGranteePageListQuery as $snKey=>$asValues)
            {
                $ssContent .= '<tr><td valign="top" align="left">'.$asValues['grantee_surname'].' '.$asValues['grantee_first_name'].'</td>
                <td valign="top" align="left">'.$asValues['catalog_name'].'</td>
                <td valign="top" align="left">'.$asValues['cost_price'].'</td>
                <td valign="top" align="left">'.$asValues['special_cost_price'].'</td>
                <td valign="top" align="left">'.($asValues['payment_id'] == 1 ? 'Credit' : ($asValues['payment_id'] == 2 ? 'Waiting' : ($asValues['payment_id'] == 3 ? 'Pending' : ''))).'</td></tr>';                                
            }
            $ssContent .= '</table>';
        }        
        sfGeneral::getPDFContentReport($ssContent);
    }
    
    /**
     * Executes GenerateTransferGraveInvoice action
     *
     * @access public
     * @param sfRequest $request A request object
     */
    public function executeGenerateTransferGraveInvoice(sfWebRequest $oRequest)
    {        
        $snGraveId = $oRequest->getParameter('grave_history_id','');
        $this->snCementeryId = $this->getUser()->getAttribute('cemeteryid');
        $this->oGranteePageListQuery = Doctrine::getTable('GranteeGraveHistory')->getAllGraveTransferDetailAsCemeteryWise($this->snCementeryId, $snGraveId)->fetchArray();
        
        $ssContent = '';
        
        if(count($this->oGranteePageListQuery) > 0)
        {
            $ssContent .= '<table><tr><td>Invoices</td><td></td><td></td><td></td><td>'.date('d-m-Y H:m').'</td></tr></table>';
            $ssContent .= '<table cellspacing="0" cellpadding="0" border="1"><tr><td>From</td><td>To</td><td>Payment name</td><td>Cost price</td><td>Special price</td><td>Payment status</td></tr>';
            foreach($this->oGranteePageListQuery as $snKey=>$asValues)
            {
                $ssContent .= '<tr><td valign="top" align="left">'.$asValues['surrender_from_name'].'</td>
                <td valign="top" align="left">'.$asValues['surrender_from_to'].'</td>
                <td valign="top" align="left">'.$asValues['Catalog']['name'].'</td>
                <td valign="top" align="left">'.$asValues['Catalog']['cost_price'].'</td>
                <td valign="top" align="left">'.$asValues['Catalog']['special_cost_price'].'</td>
                <td valign="top" align="left">'.($asValues['payment_id'] == 1 ? 'Credit' : ($asValues['payment_id'] == 2 ? 'Waiting' : ($asValues['payment_id'] == 3 ? 'Pending' : ''))).'</td></tr>';                
            }
            $ssContent .= '</table>';
        }
        sfGeneral::getPDFContentReport($ssContent);
    }
    
	/**
    * Executes GeneratePDF action
    *
    * @access public
    * @param sfRequest $request A request object
    */
	public function executeGeneratePDF(sfWebRequest $request)
	{
		$snGraveId = $request->getParameter('grave_id','');
		$amGranteeGraveDetails = Doctrine::getTable('ArGrave')->getAllGranteeAsPerGrave($snGraveId); 
		   
		if(count($amGranteeGraveDetails) > 0)
		{
			// pdf object
			$oPDF = new sfTCPDF();
            
            $snCemeteryId = $this->getUser()->getAttribute('cemeteryid');
			// Get mail content             
			$amMailContent = Doctrine::getTable('MailContent')->getMailContentAsPerType('right_of_burial', $snCemeteryId);
            
			// set document information
			$oPDF->SetCreator(PDF_CREATOR);
			$oPDF->SetAuthor('Cemetery');
			$oPDF->SetTitle('Grantee Grave Details');
			$oPDF->SetSubject('Grantee Grave Details');
			$oPDF->SetKeywords('Grantee, Grave');
						
			// set header and footer fonts
			$oPDF->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
			$oPDF->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
			
			// set default monospaced font
			$oPDF->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
			
            //////////////////////////////////////////////////
            // 		REPLACE STATIC VARIABLES WITH VALUE		//
            //////////////////////////////////////////////////
            
            $amMailParams = array();
			
            $ssMailContent = $amMailContent[0]['content'];
			
            $asStaticVariables = sfGeneral::getAllStringBetween($ssMailContent,'{','}');
            foreach($asStaticVariables as $snKey => $ssValue)
				$amMailParams['{'.$ssValue.'}'] = sfGeneral::getValueOfStaticVariables($ssValue, $amGranteeGraveDetails);

			$asDetail = array();
			foreach($amMailParams as $ssColumnDetail=>$asValue)
			{
				if(is_array($asValue) && !empty($asValue))
				{
					foreach($asValue as $snKey=>$ssValue)
						$asDetail[$snKey][$ssColumnDetail]	 = $ssValue;
				}
			}			
			$ssString = sfGeneral::getAllStringBetween($ssMailContent,'<div id="granteeDetails">','</div>');
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
            
			$substr = sfGeneral::getAllStringBetween($ssMailContent,'<div id="granteeDetails">','</div>');
			
            $ssHTML = str_replace($substr[0],$ssReplaceString,$ssMailContent);
            
            $asStaticVariablee = sfGeneral::getAllStringBetween($ssHTML,'{','}');
           
            foreach($asStaticVariablee as $snKey => $ssValue)
                $amMailParam['{'.$ssValue.'}'] = sfGeneral::getValueOfStaticVariables($ssValue, $amGranteeGraveDetails);
            
            $ssHTML = sfGeneral::replaceMailContent($ssHTML, $amMailParam);
			
            $amContectArr = explode('<div style="page-break-after: always;">', $ssHTML);            
            
            $oPDF->SetMargins(PDF_MARGIN_LEFT, 5, PDF_MARGIN_RIGHT);
            $oPDF->SetFont('helvetica', '', 8, '', true);            
            $oPDF->SetAutoPageBreak(TRUE, 5);
            
			for($i=0;$i<count($amContectArr);$i++) 
            {   
                $oPDF->AddPage();
                $asFinalResult = str_replace('<span style="display: none;">&nbsp;</span></div>','',$amContectArr[$i]);
                $oPDF->writeHTML($asFinalResult);
			}            
			$ssFileName = 'RightOfBurial.pdf';			
			// Close and output PDF document
			// This method has several options, check the source code documentation for more information.
			$oPDF->Output($ssFileName, 'I');			
			// Stop symfony process
			throw new sfStopException();
		}
	}
	
	/**
    * Executes transferGraveCertificate action
    *
    * @access public
    * @param sfRequest $request A request object
    */
	public function executeTransferGraveCertificate(sfWebRequest $request)
	{
		$snGraveId = $request->getParameter('grave_id','');
		
		$amGranteeGraveDetails = Doctrine::getTable('GranteeGraveHistory')->getTransferGraveCertificateForPrint($snGraveId);

		if(count($amGranteeGraveDetails) > 0)
		{
			// pdf object
			$oPDF = new sfTCPDF();
            $snCemeteryId = $this->getUser()->getAttribute('cemeteryid');
            $amMailContent = Doctrine::getTable('MailContent')->getMailContentAsPerType('grave_transfer', $snCemeteryId);
            
			// set document information
			$oPDF->SetCreator(PDF_CREATOR);
			$oPDF->SetAuthor('Cemetery');
			$oPDF->SetTitle('Grantee Grave Details');
			$oPDF->SetSubject('Grantee Grave Details');
			$oPDF->SetKeywords('Grantee, Grave');
			
			// set header and footer fonts
			$oPDF->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
			$oPDF->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
			
			// set default monospaced font
			$oPDF->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
			
			//set margins
			$oPDF->SetMargins(PDF_MARGIN_LEFT, 5, PDF_MARGIN_RIGHT);
			
			//set auto page breaks
			$oPDF->SetAutoPageBreak(TRUE, 5);

			list($snYear,$snMonth,$snDay) = explode('-',$amGranteeGraveDetails[0]['surrender_date']);			
			
			//////////////////////////////////////////////////
            // 		REPLACE STATIC VARIABLES WITH VALUE		//
            //////////////////////////////////////////////////
            
            $amMailParams = array();            
            $ssMailContent = $amMailContent[0]['content'];
			$asStaticVariables = sfGeneral::getAllStringBetween($amMailContent[0]['content'],'{','}');	
            foreach($asStaticVariables as $snKey => $ssValue)
                $amMailParams['{'.$ssValue.'}'] = sfGeneral::getValueOfStaticVariables($ssValue, $amGranteeGraveDetails);
			
			// Set some content to print		
            $ssHTML = sfGeneral::replaceMailContent($ssMailContent, $amMailParams);
			
            $amContectArr = explode('<div style="page-break-after: always;">', $ssHTML);            
            
            $oPDF->SetMargins(PDF_MARGIN_LEFT, 5, PDF_MARGIN_RIGHT);
            $oPDF->SetFont('helvetica', '', 8, '', true);            
            $oPDF->SetAutoPageBreak(TRUE, 5);
            
			for($i=0;$i<count($amContectArr);$i++) 
            {   
                $oPDF->AddPage();
                $asFinalResult = str_replace('<span style="display: none;">&nbsp;</span></div>','',$amContectArr[$i]);
                $oPDF->writeHTML($asFinalResult);
			}
			$ssFileName = 'GraveTransfer.pdf';
			
			// Close and output PDF document
			// This method has several options, check the source code documentation for more information.
			$oPDF->Output($ssFileName, 'I');
			
			// Stop symfony process
			throw new sfStopException();
		}
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
        $snIdGrantee = $oRequest->getParameter('id', '');
		$this->snIdGranteeDetailId = $oRequest->getParameter('grantee_id', '');
		$this->snCementeryId = $oRequest->getParameter('cemetery_id', '');

        $ssSuccessKey   = 4; // Success message key for add

        $this->snAreaId = $oRequest->getParameter('grantee_ar_area_id', '');
        $this->snSectionId = $oRequest->getParameter('grantee_ar_section_id', '');
        $this->snRowId = $oRequest->getParameter('grantee_ar_row_id', '');
        $this->snPlotId = $oRequest->getParameter('grantee_ar_plot_id', '');
        $this->snGraveId = $oRequest->getParameter('grantee_ar_grave_id', '');
		$ssMode = ($snIdGrantee != '') ? 'edit' : '';
		
		$this->asCementery = $this->asAreaList = $this->asSectionList = $this->asRowList = $this->asPlotList = $this->asGraveList = array();
		
        if($snIdGrantee)
        {
            $this->forward404Unless($oGrantee = Doctrine::getTable('Grantee')->find($snIdGrantee));
            $this->forward404Unless($this->oGranteeDetails = Doctrine::getTable('GranteeDetails')->find($this->snIdGranteeDetailId));
            $this->oGranteeForm = new GranteeForm($oGrantee);
            $ssSuccessKey = 2; // Success message key for edit
			
			// For get Area List as per Cemetery
			$this->asAreaList = Doctrine::getTable('ArArea')->getAreaListAsPerCemetery($oGrantee->getCountryId(),$oGrantee->getCemCemeteryId());

			// For get Section List as per area
			$this->asSectionList = Doctrine::getTable('ArSection')->getSectionListAsPerArea($oGrantee->getCountryId(),$oGrantee->getCemCemeteryId(),$oGrantee->getArAreaId());

			// For get Row List as per section
			$this->asRowList = Doctrine::getTable('ArRow')->getRowListAsPerSection($oGrantee->getCountryId(),$oGrantee->getCemCemeteryId(),$oGrantee->getArAreaId(),$oGrantee->getArSectionId());
			// For get Plot List as per Row
			$this->asPlotList = Doctrine::getTable('ArPlot')->getPlotListAsPerArea($oGrantee->getCountryId(),$oGrantee->getCemCemeteryId(),$oGrantee->getArAreaId(),$oGrantee->getArSectionId(),$oGrantee->getArRowId());
			
			// For get Grave List as per Plot
			$this->asGraveList = Doctrine::getTable('ArGrave')->getGraveListAsPerCriteria($oGrantee->getCountryId(),$oGrantee->getCemCemeteryId(),$oGrantee->getArAreaId(),$oGrantee->getArSectionId(),$oGrantee->getArRowId(),$oGrantee->getArPlotId(),$ssMode,$oGrantee->getGranteeDetailsId());
			
			// For get Funeral Direcors List as per Cemetery
			$this->asFuneralList = Doctrine::getTable('FndFndirector')->getFuneralListAsPerCemetery($oGrantee->getCemCemeteryId());
			
			$this->snCementeryId = ($this->snCementeryId != '') ? $this->snCementeryId : $oGrantee->getCemCemeteryId();
			$this->snAreaId = ($this->snAreaId != '') ? $this->snAreaId : $oGrantee->getArAreaId();
			$this->snSectionId = ($this->snSectionId != '') ? $this->snSectionId : $oGrantee->getArSectionId();
			$this->snRowId = ($this->snRowId != '') ? $this->snRowId : $oGrantee->getArRowId();
			$this->snPlotId = ($this->snPlotId != '') ? $this->snPlotId : $oGrantee->getArPlotId();
			$this->snGraveId = ($this->snGraveId != '') ? $this->snGraveId : $oGrantee->getArGraveId();
        }
        else
            $this->oGranteeForm = new GranteeForm();

        $this->getConfigurationFields($this->oGranteeForm);

		$amGranteeFormRequest = $oRequest->getParameter($this->oGranteeForm->getName());

		if($this->snCementeryId != '' && $amGranteeFormRequest['country_id'] != '')
			$this->asAreaList = Doctrine::getTable('ArArea')->getAreaListAsPerCemetery($amGranteeFormRequest['country_id'], $this->snCementeryId);
		if($amGranteeFormRequest['country_id'] != '' && $this->snCementeryId != '')
			$this->asSectionList = Doctrine::getTable('ArSection')->getSectionListAsPerArea($amGranteeFormRequest['country_id'], $this->snCementeryId, $this->snAreaId);
		if($amGranteeFormRequest['country_id'] != '' && $this->snCementeryId != '')
			$this->asRowList = Doctrine::getTable('ArRow')->getRowListAsPerSection($amGranteeFormRequest['country_id'], $this->snCementeryId, $this->snAreaId, $this->snSectionId);
		if($amGranteeFormRequest['country_id'] != '' && $this->snCementeryId != '')
			$this->asPlotList = Doctrine::getTable('ArPlot')->getPlotListAsPerArea($amGranteeFormRequest['country_id'],$this->snCementeryId,$this->snAreaId,$this->snSectionId,$this->snRowId);
		if($amGranteeFormRequest['country_id'] != '' && $this->snCementeryId != '')
			$this->asGraveList = Doctrine::getTable('ArGrave')->getGraveListAsPerCriteria($amGranteeFormRequest['country_id'],$this->snCementeryId,$this->snAreaId,$this->snSectionId,$this->snRowId,$this->snPlotId,$ssMode,$this->snIdGranteeDetailId);

        if($oRequest->isMethod('post'))
        {
			$ssPurchaseDate = $amGranteeFormRequest['date_of_purchase'];
			$ssPurchaseDate = ($ssPurchaseDate != '' && $ssPurchaseDate != '00-00-0000' && $ssPurchaseDate != '0000-00-00' )
								? (date("Y-m-d",strtotime($ssPurchaseDate))) 
								: sfConfig::get('app_default_date_formate');
           
			$amGranteeFormRequest['date_of_purchase'] = $ssPurchaseDate;
            
			$ssTenureExpiryDate = $amGranteeFormRequest['tenure_expiry_date'];            
			$ssTenureExpiryDate = ($ssTenureExpiryDate != '' && $ssTenureExpiryDate != '00-00-0000' && $ssTenureExpiryDate != '0000-00-00') 
									? (date("Y-m-d",strtotime($ssTenureExpiryDate))) 
									: sfConfig::get('app_default_date_formate');
			$amGranteeFormRequest['tenure_expiry_date']  = $ssTenureExpiryDate;
            $this->oGranteeForm->bind($amGranteeFormRequest);
			
            if($this->oGranteeForm->isValid() && $oRequest->getParameter('grantee_ar_grave_id') != '')
            {
                $oGrantee = $this->oGranteeForm->save();

				// Check Grave Status and Update.
				$oGrave = Doctrine::getTable('ArGrave')->find($oGrantee->getArGraveId());
				if($oGrave && $oGrave->getArGraveStatusId() == sfConfig::get('app_grave_status_vacant'))
					ArGrave::updateGraveTableField('ar_grave_status_id', sfConfig::get('app_grave_status_pre_Purchased'), $oGrave->getId());
					
                $this->getUser()->setFlash('snSuccessMsgKey', $ssSuccessKey);   //Set messages for add and update records
				
				if($oRequest->getParameter('back') == true):
					$this->redirect(url_for('gravesearch/addedit?back=true'));
				else:	
					$this->redirect(url_for('grantee/index?grantee_id='.$this->snIdGranteeDetailId.'&cemetery_id='.$this->snCementeryId.'&'.$this->amExtraParameters['ssQuerystr']));
				endif;	
            }
			else
			{
				if($oRequest->getParameter('grantee_ar_grave_id') == '')
					$this->getUser()->setFlash('ssErrorGrave',__('Please select grave'));
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
    * Executes GetFuneralListAsPerCemetery action
    *
    * @access public
    * @param sfRequest $request A request object
    */
    public function executeGetFuneralListAsPerCemetery(sfWebRequest $request)
    {
		$snCemeteryId = $request->getParameter('cemetery_id','');
		$asFuneralList = Doctrine::getTable('FndFndirector')->getFuneralListAsPerCemetery($snCemeteryId);
		
		return $this->renderPartial('getFuneralList', array('asFuneralList' => $asFuneralList));
	}

	/**
    * Executes getAreaListAsPerCemetery action
    *
    * @access public
    * @param sfRequest $request A request object
    */
    public function executeGetAreaListAsPerCemetery(sfWebRequest $request)
    {	
		$snIdCountry = $request->getParameter('country_id','');
		$snCemeteryId = $request->getParameter('cemetery_id','');
		$asAreaList = Doctrine::getTable('ArArea')->getAreaListAsPerCemetery($snIdCountry, $snCemeteryId);
		return $this->renderPartial('getAreaList', array('asAreaList' => $asAreaList));
	}
	
	/**
    * Executes getSectionListAsPerArea action
    *
    * @access public
    * @param sfRequest $request A request object
    */
    public function executeGetSectionListAsPerArea(sfWebRequest $request)
    {	
		$snIdCountry = $request->getParameter('country_id','');
		$snCemeteryId = $request->getParameter('cemetery_id','');
		$snAreaId = $request->getParameter('area_id','');
		$asSectionList = Doctrine::getTable('ArSection')->getSectionListAsPerArea($snIdCountry,$snCemeteryId,$snAreaId);

		return $this->renderPartial('getSectionList', array('asSectionList' => $asSectionList));
	}
	/**
    * Executes getRowListAsPerSection action
    *
    * @access public
    * @param sfRequest $request A request object
    */
    public function executeGetRowListAsPerSection(sfWebRequest $request)
    {	
		$snIdCountry = $request->getParameter('country_id','');
		$snCemeteryId = $request->getParameter('cemetery_id','');
		$snAreaId = $request->getParameter('area_id','');
		$snSectionId = $request->getParameter('section_id','');
		$asRowList = Doctrine::getTable('ArRow')->getRowListAsPerSection($snIdCountry,$snCemeteryId,$snAreaId,$snSectionId);

		return $this->renderPartial('getRowList', array('asRowList' => $asRowList));
	}
	/**
    * Executes getPlotListAsPerRow action
    *
    * @access public
    * @param sfRequest $request A request object
    */
    public function executeGetPlotListAsPerRow(sfWebRequest $request)
    {	
		$snIdCountry = $request->getParameter('country_id','');
		$snCemeteryId = $request->getParameter('cemetery_id','');
		$snAreaId = $request->getParameter('area_id','');
		$snSectionId = $request->getParameter('section_id','');
		$snRowId = $request->getParameter('row_id','');
		
		$asPlotList = Doctrine::getTable('ArPlot')->getPlotListAsPerArea($snIdCountry,$snCemeteryId,$snAreaId,$snSectionId,$snRowId);

		return $this->renderPartial('getPlotList', array('asPlotList' => $asPlotList));
	}
	/**
    * Executes getGraveListAsPerPlot action
    *
    * @access public
    * @param sfRequest $request A request object
    */
    public function executeGetGraveListAsPerPlot(sfWebRequest $request)
    {	
		$snIdCountry = $request->getParameter('country_id','');
		$snCemeteryId = $request->getParameter('cemetery_id','');
		$snAreaId = $request->getParameter('area_id','');
		$snSectionId = $request->getParameter('section_id','');
		$snRowId = $request->getParameter('row_id','');
		$snPlotId = $request->getParameter('plot_id','');		
		$snGranteeId = $request->getParameter('grantee_id','');
		
		$asGraveList = Doctrine::getTable('ArGrave')->getGraveListAsPerCriteria($snIdCountry,$snCemeteryId,$snAreaId,$snSectionId,$snRowId,$snPlotId,'',$snGranteeId);

		return $this->renderPartial('getGraveList', array('asGraveList' => $asGraveList));
	}
	/**
    * Executes surrenderGrave action
    *
    * @access public
    * @param sfRequest $request A request object
    */
    public function executeSurrenderGrave(sfWebRequest $oRequest)
    {
		$snGranteeId = $oRequest->getParameter('id','');
		$this->snGraveId = $oRequest->getParameter('grave_id','');
		$this->snIdGranteeDetailId = $oRequest->getParameter('grantee_id','');
		$this->snCemeteryId = $oRequest->getParameter('cemetery_id','');
		
		$ssSuccessKey   = 5; // Success message key for surrender grave to another grantee
		
		$this->oSurrenderdGraveForm = new SurrenderdGraveForm();

		$this->getConfigurationFieldsForSurrenderGrave($this->oSurrenderdGraveForm);
		if($oRequest->isMethod('post'))
        {
			$amSurrenderdGraveFormRequest = $oRequest->getParameter($this->oSurrenderdGraveForm->getName());
			$this->oSurrenderdGraveForm->bind($amSurrenderdGraveFormRequest);
						
			if($this->oSurrenderdGraveForm->isValid())
			{
				$oGranteeDetails = Doctrine::getTable('GranteeDetails')->findOneByGranteeUniqueId($amSurrenderdGraveFormRequest['grantee_unique_id']);
				if($oGranteeDetails && $this->snIdGranteeDetailId != $oGranteeDetails->getId())
				{
					// Update Surrendered Grantee Grave.
					$oGrantee = Doctrine::getTable('Grantee')->find($snGranteeId);
					$oGrantee->setGranteeDetailsId($oGranteeDetails->getId());
					
					if($amSurrenderdGraveFormRequest['grantee_identity_id'] != '')
						$oGrantee->setGranteeIdentityId($amSurrenderdGraveFormRequest['grantee_identity_id']);
                        
                    if($amSurrenderdGraveFormRequest['catalog_id'] != '')
						$oGrantee->setCatalogId($amSurrenderdGraveFormRequest['catalog_id']);
                        
                    if($amSurrenderdGraveFormRequest['payment_id'] != '')
						$oGrantee->setPaymentId($amSurrenderdGraveFormRequest['payment_id']);
					
					$oGrantee->setGranteeIdentityNumber($amSurrenderdGraveFormRequest['grantee_identity_number']);
					$oGrantee->setReceiptNumber($amSurrenderdGraveFormRequest['receipt_number']);
					$oGrantee->setUserId($this->getUser()->getAttribute('userid'));
					$oGrantee->save();

					$ssSurrenderDate = $amSurrenderdGraveFormRequest['transfer_date'];
					$ssSurrenderDate = ($ssSurrenderDate != '' && $ssSurrenderDate != '00-00-0000 00:00:00') ? (date("Y-m-d H:i:s",strtotime($ssSurrenderDate))) : date('Y-m-d H:i:s');
					
					// Save Old Grantee History who surrenderd grave to another grantee.
					$oGranteeGraveHistory = new GranteeGraveHistory();
					$oGranteeGraveHistory->setGranteeDetailsId($this->snIdGranteeDetailId);
					$oGranteeGraveHistory->setGranteeDetailsSurrenderId($oGranteeDetails->getId());
					$oGranteeGraveHistory->setArGraveId($oGrantee->getArGraveId());
                    $oGranteeGraveHistory->setCatalogId($amSurrenderdGraveFormRequest['catalog_id']);
                    $oGranteeGraveHistory->setPaymentId($amSurrenderdGraveFormRequest['payment_id']);
					$oGranteeGraveHistory->setSurrenderDate($ssSurrenderDate);
					//$oGranteeGraveHistory->setTransfer_cost($amSurrenderdGraveFormRequest['transfer_cost']);
					$oGranteeGraveHistory->setReceiptNumber($amSurrenderdGraveFormRequest['receipt_number']);
					$oGranteeGraveHistory->save();
					
					$this->getUser()->setFlash('snSuccessMsgKey', $ssSuccessKey);   //Set messages for add and update records
					if($this->snGraveId != '') {
						echo "<script type='text/javascript'>";
						echo "document.location.href='".url_for('grave/showGrantees?grave_id='.$this->snGraveId)."';";
						echo "</script>";exit;						
					}else {
						echo "<script type='text/javascript'>";
						echo "document.location.href='".url_for('grantee/index?grantee_id='.$this->snIdGranteeDetailId.'&'.$this->amExtraParameters['ssQuerystr'])."';";
						echo "</script>";exit;
					}
				}
				else
				{
					if(!$oGranteeDetails)
						$this->getUser()->setFlash('ssErrorGranteeNotExists', __('Grantee unique ID does not exists'));
					if($oGranteeDetails && $this->snIdGranteeDetailId == $oGranteeDetails->getId())
						$this->getUser()->setFlash('ssErrorSameGrantee', __("You can't surrender grave your self"));
					
				}
			}
			
			if($oRequest->getParameter('request_type') == 'ajax_request')
	            return $this->renderPartial('surrenderGrave', array('oSurrenderdGraveForm' => $this->oSurrenderdGraveForm,
																	'snIdGranteeDetailId' => $this->snIdGranteeDetailId,
																	'amExtraParameters'	=> $this->amExtraParameters,
																	'snGraveId'         => $this->snGraveId));
																	 
		}        
	}
    
    /**
     * Executes surrenderGrave action
     *
     * @access public
     * @param sfRequest $oRequest A request object
     */
    public function executeTransferGraveInvoice(sfWebRequest $oRequest)
    {         
        //set search combobox field
        $this->amSearch = array(
								'grantee_first_name' => array(
												'caption'	=> __('First Name'),
												'id'		=> 'GranteeFirstName',
												'type'		=> 'text',																								
											),
								'grantee_surname' => array(
												'caption'	=> __('Surname'),
												'id'		=> 'GranteeSurname',
												'type'		=> 'text',										
											)
							);

        $omCommon = new common();
        $this->snCementeryId = $this->getUser()->getAttribute('cemeteryid');

        $oTransferGravePageListQuery = Doctrine::getTable('GranteeGraveHistory')->getAllGraveTransferDetailAsCemeteryWise($this->snCementeryId);

        // Set pager and get results
        $oPager               = new sfMyPager();
        $this->oTransferGrave  = $oPager->getResults('GranteeGraveHistory', $this->snPaging,$oTransferGravePageListQuery,$this->snPage);
        $this->amTransferGraveList = $this->oTransferGrave->getResults(Doctrine::HYDRATE_ARRAY);        
        
        unset($oPager);
        
        $this->oGravePlotReportForm = new ServiceReportForm();        
        $this->getExportConfigurationFields($this->oGravePlotReportForm);
        
        $amGraveFormRequest = $oRequest->getParameter($this->oGravePlotReportForm->getName());
        
        if($oRequest->isMethod('post') && $oRequest->getParameter('request_type') != 'ajax_request')
       	{			
            $this->ssFromDate 	= ((isset($amGraveFormRequest['from_date']) && $amGraveFormRequest['from_date'] != '') ? $amGraveFormRequest['from_date'] : '');
			$this->ssToDate		= ((isset($amGraveFormRequest['to_date']) && $amGraveFormRequest['to_date'] != '') ? $amGraveFormRequest['to_date'] : '');

			// FOR SERVICE REPORT AS PER BETWEEN FROM AND TO DATE
			if($this->ssToDate != '')
			{
				$ssFormatedFromDate = (($this->ssFromDate != '') ?date('Y-m-d', strtotime($this->ssFromDate)):'');
                $ssFormatedToDate = date('Y-m-d', strtotime($this->ssToDate));
                $asServiceReport = Doctrine::getTable('GranteeGraveHistory')->getAllGraveTransferDetailAsCemeteryWise($this->snCementeryId,'',$ssFormatedFromDate, $ssFormatedToDate)->fetchArray();
            }
            if(count($asServiceReport) > 0)
            {
                $ssFilename = "Invoices.csv"; 
                $this->getResponse()->setHttpHeader('Content-Disposition', 'attachment; filename=' . basename($ssFilename));
                $this->getResponse()->setContentType('text/csv;charset=ISO-8859-2');
                $ssContents = "";
                $ssContents .= 'Surrender From,Surrender To,Payment Name,Cost Price,Special Price, Payment Status';
                $ssContents .= "\n"; 
                foreach($asServiceReport as $snKey=>$asValues)
                {
                    $ssContents .= $asValues['surrender_from_name'].","; 
                    $ssContents .= $asValues['surrender_from_to'].",";
                    $ssContents .= $asValues['Catalog']['name'].",";
                    $ssContents .= $asValues['Catalog']['cost_price'].",";
                    $ssContents .= $asValues['Catalog']['special_cost_price'].",";
                    $ssContents .= $asValues['payment_id'] == 1 ? 'Credit' : ($asValues['payment_id'] == 2 ? 'Waiting' : ($asValues['payment_id'] == 3 ? 'Pending' : '')).",";
                    $ssContents .= "\n"; 
                }
                
                $this->getResponse()->setContent($ssContents);        
                $this->getResponse()->sendHttpHeaders();
                
                return sfView::NONE;
            }
            else
                $this->getUser()->setFlash('snErrorMsgKey', 2);
		}
        // Total number of records
        $this->snPageTotalGranteePages = $this->oTransferGrave->getNbResults();

        if($oRequest->getParameter('request_type') == 'ajax_request')
            $this->setTemplate('transferGraveUpdate');
        
    }

    /**
     * getConfigurationFields
     *
     * Function for prepare configuration fields for form
     * @access private
     * @param  object $oForm form object
     *     
     */
    private function getExportConfigurationFields($oForm)
    {
        $oForm->setWidgets(
			array(
					'country_id'		=> __('Select Country'),
					'cem_cemetery_id'  => __('Select Cemetery'),
					'reports_identity_id' => __('Select Grantee Identity')
				 )
		);
		
		$oForm->setDefault('country_id', $this->amPostRequest['country_id']);
		$oForm->setDefault('from_date', $this->amPostRequest['from_date']);
		$oForm->setDefault('to_date', $this->amPostRequest['to_date']);
		
        $oForm->setLabels(
            array(
                'country_id'       	=> __('Select Country'),
                'cem_cemetery_id'  	=> __('Select Cemetery'),
				'from_date'  		=> __('From Date'),
				'to_date'  			=> __('To Date')
            )
        );
    }
	/**
     * getConfigurationFields
     *
     * Function for prepare configuration fields for form
     * @access private
     * @param  object $oForm form object
     *     
     */
    private function getConfigurationFieldsForSurrenderGrave($oForm)
    {
		$oForm->setWidgets(array('grantee_identity_id' => __('Select Grantee Identity'),'catalog_id' => __('Select Catalog'),'payment_id'=>__('Select Payment Status')));
        $oForm->setLabels(
            array(
                'grantee_unique_id'       		=> __('Grantee Unique ID'),				
				'transfer_date'					=> __('Transfer Date'),
				'transfer_cost'					=> __('Transfer Cost'),
				'receipt_number'				=> __('Receipt Number'),
				'grantee_identity_id'			=> __('Grantee Identity'),
				'grantee_identity_number'		=> __('Grantee Identity Number'),
                'catalog_id' => __('Catalog'),
                'payment_id'=>__('Payment Status')   
				)
        );
        $oForm->setValidators(
            array(
    	            'grantee_unique_id'    => array(
												'required'  => __('Please select grantee unique ID')
											),
				)
        );
											
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
					'country_id'		=> __('Select Country'),
					'cem_cemetery_id'  => __('Select Cemetery'),
					'ar_grave_status_id' => __('Select Grave Status'),
					'fnd_fndirector_id' => __('Select Funeral Director'),
					'grantee_identity_id' => __('Select Grantee Identity'),
					'cem_stonemason_id' => __('Select Stone Mason'),
					'date_next'	=> __('Next'),
					'date_prev'	=> __('Previous'),
                    'catalog_id' => __('Select Catalog'),
                    'payment_id'=>__('Select Payment Status')                    
				 )
		);

        $oForm->setLabels(
            array(
                'country_id'       		=> __('Country'),
				'cem_cemetery_id'  => __('Select Cemetery'),
                'ar_grave_status_id'	=> __('Grave Status'),
                'fnd_fndirector_id'     => __('Funeral Directory'),
                'grantee_identity_id'   => __('Grantee Identity'),
				'cem_stonemason_id' 	=> __('Stone Mason'),
				'grantee_identity_number' => __('Grantee Identity Number'),
                'receipt_number'  			=> __('Receipt Number'),
                'control_number'  	 		=> __('Control Number'),
                'invoice_number'			=> __('Invoice Number'),
                'date_of_purchase'  		=> __('Tenure From'),
                'tenure_expiry_date'  		=> __('Tenure To'),
                'cost'  					=> __('Cost'),
                'grantee_first_name'  	 	=> __('Grantee First Name'),
                'grantee_middle_name'		=> __('Grantee Middle Name'),
                'grantee_surname'  			=> __('Grantee Surname'),
                'grantee_relationship'  	=> __('Grantee Relationship'),
                'grantee_address_line1'  	=> __('Grantee Address Line 1'),
                'grantee_address_line2'  	=> __('Grantee Address Line 2'),
                'grantee_dob'				=> __('Grantee DOB'),
                'grantee_id_number'  		=> __('Grantee Id Number'),
                'remarks_1'  				=> __('Remarks 1'),
                'remarks_2'  				=> __('Remarks 2'),
                'catalog_id' => __('Catalog'),
                'payment_id'=>__('Payment Status')   
            )
        );

        $oForm->setValidators(
            array(
    	            'country_id'    => array(
												'required'  => __('Please select country')
											),
					'cem_cemetery_id'        => array(
												'required'  => __('Please select cemetery')
											),
	                'fnd_fndirector_id'		=> array(
												'required'  => __('Please enter funeral director')
											),
	                'cem_stonemason_id'	=> array(
												'required'  => __('Please select stone mason')
											),
	                'grantee_identity_id'	=> array(
												'required'  => __('Please select grantee identity')
											),
	                'grantee_first_name'	=> array(
												'required'  => __('Please enter grantee first name')
											),
	                'grantee_middle_name'	=> array(
												'required'  => __('Please enter grantee middle name')
											),
	                'grantee_surname'		=> array(
												'required'  => __('Please enter grantee surname')
											),
					'tenure_expiry_date' 	=> array(
												'invalid'  => __('Tenure To date must be grater than Tenure From')
												), 
				)
        );
    }
}