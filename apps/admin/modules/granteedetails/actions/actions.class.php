<?php
/**
 * granteedetails actions.
 *
 * @package    Cemetery
 * @subpackage granteedetails
 * @author     Prakash Panchal
 * @author      
 *
 */
sfProjectConfiguration::getActive()->loadHelpers(array('I18N','Partial'));
class granteedetailsActions extends sfActions
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
        $this->ssFormName = 'frm_list_granteedetails';
        $omRequest        = sfContext::getInstance()->getRequest();

        // Set default values
        $this->amExtraParameters = array();
        $this->amExtraParameters['snPaging']        = $this->snPaging       = $omRequest->getParameter('paging',sfConfig::get('app_default_paging_records'));
        $this->amExtraParameters['snPage']          = $this->snPage         = $omRequest->getParameter('page', sfConfig::get('app_default_page', 1));
		
		if($omRequest->getParameter('flag') == 'true' || $omRequest->getParameter('reset') == 'true') 
		{
			$this->getUser()->setAttribute('gt_country', '');
			$this->getUser()->setAttribute('gt_cemetery', '');
			$this->getUser()->setAttribute('gt_area', '');
			$this->getUser()->setAttribute('gt_section', '');
			$this->getUser()->setAttribute('gt_row', '');
			$this->getUser()->setAttribute('gt_plot', '');
			$this->getUser()->setAttribute('gt_grave', '');
		}
		if(!$this->getUser()->isSuperAdmin())
		{
			$this->snCemeteryId = $this->getUser()->getAttribute('cemeteryid');
			$oCemetery = Doctrine::getTable('CemCemetery')->find($this->snCemeteryId);
			$this->snCountryId = ($oCemetery) ? $oCemetery->getCountryId() : '';
			
			$this->getUser()->setAttribute('gt_country', $this->snCountryId);
			$this->getUser()->setAttribute('gt_cemetery', $this->snCemeteryId);
		}
		
        $this->amExtraParameters['ssSearchGranteeFirstName']   	= $this->ssSearchName  	= trim($omRequest->getParameter('searchGranteeFirstName',''));
        $this->amExtraParameters['ssSearchGranteeSurname']   	= $this->ssSearchName  	= trim($omRequest->getParameter('searchGranteeSurname',''));
		
		$this->amExtraParameters['ssSearchCountryId']   	= $this->ssSearchCountryId  = trim($omRequest->getParameter('searchCountryId',''));
		$this->amExtraParameters['ssSearchCountryId'] 		= ($this->ssSearchCountryId != '') ? $this->ssSearchCountryId : ( $this->getUser()->getAttribute('gt_country') != '' ? $this->getUser()->getAttribute('gt_country') : '');
		
		$this->amExtraParameters['ssSearchCemCemeteryId']   = $this->ssSearchCemeteryId = trim($omRequest->getParameter('searchCemCemeteryId',''));
		$this->amExtraParameters['ssSearchCemCemeteryId'] = ($this->ssSearchCemeteryId != '') ? $this->ssSearchCemeteryId : ($this->getUser()->getAttribute('gt_cemetery') != '' ? $this->getUser()->getAttribute('gt_cemetery') : '' );
		
		$this->ssSearchAreaId 		= trim($omRequest->getParameter('searchArAreaId',''));
		$this->ssSearchSectionId  	= trim($omRequest->getParameter('searchArSectionId',''));
		$this->ssSearchRowId 		= trim($omRequest->getParameter('searchArRowId',''));
		$this->ssSearchPlotId		= trim($omRequest->getParameter('searchArPlotId',''));
		$this->ssSearchArGraveId	= trim($omRequest->getParameter('searchArGraveId',''));
		
		$this->ssSearchAreaId 		= ($this->ssSearchAreaId != '') ? $this->ssSearchAreaId : ( $this->getUser()->getAttribute('gt_area') != '' ? $this->getUser()->getAttribute('gt_area') : '' );
		$this->ssSearchSectionId 	= ($this->ssSearchSectionId != '') ? $this->ssSearchSectionId : ( $this->getUser()->getAttribute('gt_section') != '' ? $this->getUser()->getAttribute('gt_section') : '' );
		$this->ssSearchRowId 		= ($this->ssSearchRowId != '') ? $this->ssSearchRowId : ( $this->getUser()->getAttribute('gt_row') != '' ? $this->getUser()->getAttribute('gt_row') : '' );
		$this->ssSearchPlotId 		= ($this->ssSearchPlotId != '') ? $this->ssSearchPlotId : ( $this->getUser()->getAttribute('gt_plot') != '' ? $this->getUser()->getAttribute('gt_plot') : '' );
		$this->ssSearchArGraveId 		= ($this->ssSearchArGraveId != '') ? $this->ssSearchArGraveId : ( $this->getUser()->getAttribute('gt_grave') != '' ? $this->getUser()->getAttribute('gt_grave') : '' );

		$this->amExtraParameters['ssSearchArAreaId']   		= $this->ssSearchAreaId;
		$this->amExtraParameters['ssSearchArSectionId']   	= $this->ssSearchSectionId;
		$this->amExtraParameters['ssSearchArRowId']   		= $this->ssSearchRowId;
		$this->amExtraParameters['ssSearchArPlotId']   		= $this->ssSearchPlotId;
        $this->amExtraParameters['ssSearchArGraveId'] 		= $this->ssSearchArGraveId;
		
        $this->amExtraParameters['ssSortBy']        = $this->ssSortBy       = $omRequest->getParameter('sortby','id');
        $this->amExtraParameters['ssSortMode']      = $this->ssSortMode     = $omRequest->getParameter('sortmode','desc');

        $this->ssSortQuerystr = $this->ssQuerystr = 'page='.$this->snPage.'&paging='.$this->snPaging;
		
		if($this->ssSearchCountryId != '' )        // Search parameters
        {
            $this->ssQuerystr    .= '&searchCountryId='.$this->ssSearchCountryId;
            $this->ssSortQuerystr.= '&searchCountryId='.$this->ssSearchCountryId;
        }
		if($this->ssSearchCemeteryId != '' )        // Search parameters
        {
            $this->ssQuerystr    .= '&searchCemCemeteryId='.$this->ssSearchCemeteryId;
            $this->ssSortQuerystr.= '&searchCemCemeteryId='.$this->ssSearchCemeteryId;
        }
		if($this->ssSearchAreaId != '' )        // Search parameters
        {
            $this->ssQuerystr    .= '&searchArAreaId='.$this->ssSearchAreaId;
            $this->ssSortQuerystr.= '&searchArAreaId='.$this->ssSearchAreaId;
        }
		if($this->ssSearchSectionId != '' )        // Search parameters
        {
            $this->ssQuerystr    .= '&searchArSectionId='.$this->ssSearchSectionId;
            $this->ssSortQuerystr.= '&searchArSectionId='.$this->ssSearchSectionId;
        }
		if($this->ssSearchRowId != '' )        // Search parameters
        {
            $this->ssQuerystr    .= '&searchArRowId='.$this->ssSearchRowId;
            $this->ssSortQuerystr.= '&searchArRowId='.$this->ssSearchRowId;
        }
        if($this->ssSearchPlotId != '' )        // Search parameters
        {
            $this->ssQuerystr    .= '&searchArPlotId='.$this->ssSearchPlotId;
            $this->ssSortQuerystr.= '&searchArPlotId='.$this->ssSearchPlotId;
        }
		if($this->ssSearchArGraveId != '' )        // Search parameters
        {
            $this->ssQuerystr    .= '&searchArGraveId='.$this->ssSearchArGraveId;
            $this->ssSortQuerystr.= '&searchArGraveId='.$this->ssSearchArGraveId;
        }
		
        if($this->getRequestParameter('searchGranteeFirstName') != '' )        // Search parameters
        {
            $this->ssQuerystr    .= '&searchGranteeFirstName='.$this->getRequestParameter('searchGranteeFirstName');
            $this->ssSortQuerystr.= '&searchGranteeFirstName='.$this->getRequestParameter('searchGranteeFirstName');
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
		if($request->isMethod('post') && $request->getParameter('request_type') == 'ajax_request')
		{
			$ssSearchCountryId  = trim($request->getParameter('searchCountryId',''));
			$ssSearchCemeteryId = trim($request->getParameter('searchCemCemeteryId',''));
			$ssSearchAreaId 	= trim($request->getParameter('searchArAreaId',''));
			$ssSearchSectionId  = trim($request->getParameter('searchArSectionId',''));
			$ssSearchRowId 		= trim($request->getParameter('searchArRowId',''));
			$ssSearchPlotId		= trim($request->getParameter('searchArPlotId',''));
			$ssSearchGraveId	= trim($request->getParameter('searchArGraveId',''));
			
			$this->getUser()->setAttribute('gt_country', $ssSearchCountryId);
			$this->getUser()->setAttribute('gt_cemetery', $ssSearchCemeteryId);
			$this->getUser()->setAttribute('gt_area', ($ssSearchAreaId != '') ? $ssSearchAreaId : '');
			$this->getUser()->setAttribute('gt_section', ($ssSearchSectionId != '') ? $ssSearchSectionId : '');
			$this->getUser()->setAttribute('gt_row', ($ssSearchRowId != '') ? $ssSearchRowId : '');
			$this->getUser()->setAttribute('gt_plot', ($ssSearchPlotId != '') ? $ssSearchPlotId : '');
			$this->getUser()->setAttribute('gt_grave', ($ssSearchGraveId != '') ? $ssSearchGraveId : '');
		}
		
		// For get Country list to fill Country Combo.
		$this->asCountryList = array();
		$omCriteria = Doctrine::getTable('Country')->getCountryList(array(),array());
		$amCountry = $omCriteria->orderBy('sf.name')->fetchArray();
		if(count($amCountry) > 0)
		{
			foreach($amCountry as $asDataSet)
				$this->asCountryList[$asDataSet['id']] = $asDataSet['name'];
		}
		
        //set search combobox field
        $this->amSearch = array(
								'ar_area_id' => array(
												'caption'	=> __('Area'),
												'id'		=> 'ArAreaId',
												'type'		=> 'selectajax',
												'ssPartial' => 'getCustomAreaList',
												'ssArrayKey' => 'asAreaList',
												'ssArrayValue' 	=> 'snAreaId',
												'options'	=> array(),
												'alias'		=> 'gt'
											),
								'ar_section_id' => array(
												'caption'	=> __('Section'),
												'id'		=> 'ArSectionId',
												'type'		=> 'selectajax',
												'ssPartial' => 'getCustomSectionList',
												'ssArrayKey' => 'asSectionList',
												'ssArrayValue' 	=> 'snSectionId',
												'options'	=> array(),
												'alias'		=> 'gt'
											),
								'ar_row_id' => array(
												'caption'	=> __('Row'),
												'id'		=> 'ArRowId',
												'type'		=> 'selectajax',
												'ssPartial' => 'getRowList',
												'ssArrayKey' => 'asRowList',
												'ssArrayValue' 	=> 'snRowId',
												'options'	=> array()
											),
								'ar_plot_id' => array(
												'caption'	=> __('Plot'),
												'id'		=> 'ArPlotId',
												'type'		=> 'selectajax',
												'ssPartial' => 'getCustomPlotList',
												'ssArrayKey' => 'asPlotList',
												'ssArrayValue' 	=> 'snPlotId',
												'options'	=> array(),
												'alias'		=> 'gt'
											),
								'ar_grave_id' => array(
												'caption'	=> __('Grave'),
												'id'		=> 'ArGraveId',
												'type'		=> 'selectajax',
												'ssPartial' => 'getCustomGraveList',
												'ssArrayKey' => 'asGraveList',
												'ssArrayValue' 	=> 'snGraveId',
												'options'	=> array(),
												'alias'		=> 'gt'
											),
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

		if($this->getUser()->isSuperAdmin())
		{
			$this->amSearch = array(
								'country_id' => array(
												'caption'	=> __('Country'),
												'id'		=> 'CountryId',
												'type'		=> 'selectcountry',
												'alias'		=> 'gt',
												'options'	=> $this->asCountryList
											),
								'cem_cemetery_id' => array(
												'caption'	=> __('Cemetery'),
												'id'		=> 'CemCemeteryId',
												'type'		=> 'selectajax',
												'ssPartial' => 'getCustomCementeryList',
												'ssArrayKey' => 'asCementryList',
												'ssArrayValue' 	=> 'snCementeryId',
												'options'	=> array(),
												'alias'		=> 'gt'
											)															
							) + $this->amSearch;
		}

        $omCommon = new common();

        if($request->getParameter('admin_act') == "delete" && $request->getParameter('id'))            
        {
            $omCommon->DeleteRecordsComposite('GranteeDetails', $request->getParameter('id'),'id');
            $this->getUser()->setFlash('snSuccessMsgKey', 3);      
        }

        // Get grantee page list for listing.
        $oGranteeDetailsPageListQuery = Doctrine::getTable('GranteeDetails')->getGranteeDetailsList($this->amExtraParameters, $this->amSearch);

		// Replace Doctrine Pager Count Query By Mannual Count Query.		
		$ssCountQuery = Doctrine::getTable('GranteeDetails')->getGranteeDetailsListCount($this->amExtraParameters, $this->amSearch);

        // Set pager and get results
        $oPager               = new sfMyPager();
        $this->oGranteeDetailsList  = $oPager->getResults('GranteeDetails', $this->snPaging,$oGranteeDetailsPageListQuery,$this->snPage,$ssCountQuery);
        $this->amGranteeDetailsList = $this->oGranteeDetailsList->getResults(Doctrine::HYDRATE_ARRAY);

        unset($oPager);

        // Total number of records
        $this->snPageTotalGranteeDetailsPages = $this->oGranteeDetailsList->getNbResults();

        if($request->getParameter('request_type') == 'ajax_request')
            $this->setTemplate('listGranteeDetailsUpdate');
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
        $snIdGranteeDetails = $oRequest->getParameter('id', '');
        $this->snGraveId = $oRequest->getParameter('grave_id', '');
        
        $ssSuccessKey   = 4; // Success message key for add
        $ssGranteeUniqueID = '';
		
        if($snIdGranteeDetails)
        {
            $this->forward404Unless($oGranteeDetails = Doctrine::getTable('GranteeDetails')->find($snIdGranteeDetails));
            $this->oGranteeDetailsForm = new GranteeDetailsForm($oGranteeDetails);
			$ssGranteeUniqueID = $oGranteeDetails->getGranteeUniqueId();
            $ssSuccessKey = 2; // Success message key for edit
        }
        else
            $this->oGranteeDetailsForm = new GranteeDetailsForm();

        $this->getConfigurationFields($this->oGranteeDetailsForm);

		//$this->amPostData = $oRequest->getParameter($this->oGranteeDetailsForm->getName());
		$amGranteeDetailsFormRequest = $oRequest->getParameter($this->oGranteeDetailsForm->getName());

        if($oRequest->isMethod('post'))
        {
			$amGranteeDetailsFormRequest['grantee_dob'] = (date("Y-m-d",strtotime($amGranteeDetailsFormRequest['grantee_dob'])));
            $this->oGranteeDetailsForm->bind($amGranteeDetailsFormRequest);

            if($this->oGranteeDetailsForm->isValid())
            {
                $snIdGrantee = $this->oGranteeDetailsForm->save()->getId();

				//Update Grantee Unique ID if not insertd.
				if($ssGranteeUniqueID == '')
					GranteeDetails::updateGranteeUniqueID($snIdGrantee);

                $this->getUser()->setFlash('snSuccessMsgKey', $ssSuccessKey);   //Set messages for add and update records
				
				if($this->snGraveId != '') 
				{ 
					$oGrave = Doctrine::getTable('ArGrave')->find($this->snGraveId);
					
					$ssPurchaseDate = $amGranteeDetailsFormRequest['date_of_purchase'];
					$ssPurchaseDate = ($ssPurchaseDate != '' && ($ssPurchaseDate != '00-00-0000' || $ssPurchaseDate != '0000-00-00')) 
										? (date("Y-m-d",strtotime($ssPurchaseDate))) 
										: '';

					$ssTenureExpiryDate = $amGranteeDetailsFormRequest['tenure_expiry_date'];
					$ssTenureExpiryDate = ($ssTenureExpiryDate != '' && ($ssTenureExpiryDate != '00-00-0000' || $ssTenureExpiryDate != '0000-00-00') ) 
											? (date("Y-m-d",strtotime($ssTenureExpiryDate))) 
											: '';
					
					$amGranteeData = array('grantee_id'	=> $snIdGrantee,
									  'country_id' 		=> $oGrave->getCountryId(),
									  'cemetery_id' 	=> $oGrave->getCemCemeteryId(),
									  'area_id' 		=> $oGrave->getArAreaId(),
									  'section_id' 		=> $oGrave->getArSectionId(),
									  'row_id' 			=> $oGrave->getArRowId(),
									  'plot_id' 		=> $oGrave->getArPlotId(),
									  'grave_id'		=> $oGrave->getId(),
									  'grantee_identity_id' 	=> $amGranteeDetailsFormRequest['grantee_identity_id'],
									  'grantee_identity_number'	=> $amGranteeDetailsFormRequest['grantee_identity_number'],
									  'date_of_purchase' 		=> $ssPurchaseDate,
									  'tenure_expiry_date' 		=> $ssTenureExpiryDate,
									  'user_id'					=> $this->getUser()->getAttribute('userid')
									);
									
					
					Grantee::saveGranteeRecords($amGranteeData);					
					
					$this->redirect('grave/showGrantees?grave_id='.$this->snGraveId);
				}else 
				{
					if($oRequest->getParameter('back') == true) {
						$this->redirect('granteesearch/search?back=true');
					}else {                
						$this->redirect('granteedetails/index?'.$this->amExtraParameters['ssQuerystr']);
					}					
				}
            }
        }
    }
	
	/**
    * Executes showAllGranteeGraves action
    *
    * @access public
    * @param sfRequest $request A request object
    */
	public function executeShowAllGranteeGraves(sfWebRequest $request)
	{
		$snGranteeId = $request->getParameter('grantee_id','');
		
		$amGranteeGraveDetails = Doctrine::getTable('Grantee')->getListAllGravesOwnedByGrantee($snGranteeId);

		if(count($amGranteeGraveDetails) > 0)
		{
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
			$oPDF->SetFooterMargin(PDF_MARGIN_FOOTER);
			
			//set auto page breaks
			$oPDF->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
			
			// Add a page
			// This method has several options, check the source code documentation for more information.
			$oPDF->AddPage();
			
			
			$oPDF->writeHTMLCell($w=0, $h=0, $x='60', $y='50', '<b>GRANTEE BURIAL LICENCE CERTIFICATE</b>', 0, 1, 0, true, '', true);
			
			
			$oPDF->SetFont('helvetica', 'I', 10, '', true);		
			$oPDF->setY('65');	
			
			$snCemeteryId = $this->getUser()->getAttribute('cemeteryid');
			// Get mail content
			$amMailContent = Doctrine::getTable('MailContent')->getMailContentAsPerType('grantee_burial_certificate', $snCemeteryId);
			$ssGranteeResults = '';
			$ssGranteeResults .= '<table width="100%" cellpadding="3" cellspacing="0" border="01">';
	        $ssGranteeResults .= '<tr>';
		    $ssGranteeResults .= '<td><b>'.__('Grave No.').'</b></td>';
		    $ssGranteeResults .= '<td><b>'.__('Section').'</b></td>';
		    $ssGranteeResults .= '<td><b>'.__('Date of Purchase').'</b></td>';
	        $ssGranteeResults .= '</tr>';
	        foreach($amGranteeGraveDetails as $asValues){
		        $ssGranteeResults .= '<tr>';
			    $ssGranteeResults .= '<td>'.$asValues['grave_number'].'</td>';
			    $ssGranteeResults .= '<td>'.(($asValues['section_name'] != '') ? $asValues['section_name'] : 'N/A').'</td>';
			    $ssGranteeResults .= '<td>';
                list($snYear,$snMonth,$snDay) = explode('-',$asValues['date_of_purchase']);
				$ssGranteeResults .= $snDay.'-'.$snMonth.'-'.$snYear;
                $ssGranteeResults .= '</td>';
		        $ssGranteeResults .= '</tr>';
	        }
            $ssGranteeResults .= '</table>';
			
			// Replace parameter with value
			$amMailParams = array(
			    '{GRANTEE_NAME}' => $amGranteeGraveDetails[0]['grantee_name'],
			    '{GRANTEE_RESULTS}' => $ssGranteeResults
            );
			
			// Set some content to print
			$ssHTML = sfGeneral::replaceMailContent($amMailContent[0]['content'], $amMailParams);
			
			$ssFileName = 'print_all_graves';
			// Print text using writeHTML()
			$oPDF->writeHTML($ssHTML);
			
			// Close and output PDF document
			// This method has several options, check the source code documentation for more information.
			$oPDF->Output($ssFileName, 'I');
			
			// Stop symfony process
			throw new sfStopException();
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
        $oForm->setWidgets(
			array(
					'date_next'	=> __('Next'),
					'date_prev'	=> __('Previous'),
					'cem_id'  => __('Select Cemetery'),
					
					'grantee_identity_id' => __('Select Grantee Identity')
				 )
		);

        $oForm->setLabels(
            array(
				'cem_id'  => __('Select Cemetery'),
                'grantee_first_name'  	 	=> __('Grantee First Name'),
                'grantee_middle_name'		=> __('Grantee Middle Name'),
                'grantee_surname'  			=> __('Grantee Surname'),
                'grantee_relationship'  	=> __('Grantee Relationship'),
                'grantee_address'  			=> __('Grantee Address'),
                'grantee_dob'				=> __('Grantee DOB'),
                'grantee_id_number'  		=> __('Grantee Id Number'),
                'town'  					=> __('Suburb/Town'),
                'phone'  					=> __('Telephone'),
				'contact_mobile'  			=> __('Mobile'),
                'grantee_email'				=> __('Grantee Email'),
				'postal_code'  				=> __('Postal Code'),
				'area_code'  				=> __('Telephone Area Code'),
				'fax_area_code'  			=> __('Fax Area Code'),
                'remarks_1'  				=> __('Remarks 1'),
                'remarks_2'  				=> __('Remarks 2'),
				'grantee_identity_id'  		=> __('Grantee Identity'),
                'grantee_identity_number'	=> __('Grantee Identity Number'),
				'date_of_purchase'			=> __('Tenure From'),
				'tenure_expiry_date'		=> __('Tenure To')
            )
        );

        $oForm->setValidators(
            array(
					'cem_id'        => array(
												'required'  => __('Please select cemetery')
											),            
	                'grantee_first_name'	=> array(
												'required'  => __('Please enter grantee first name')
											),
	                'grantee_middle_name'	=> array(
												'required'  => __('Please enter grantee middle name')
											),
	                'grantee_surname'	=> array(
												'required'  => __('Please enter grantee surname')
											),
					'grantee_email'	=> array(
												'invalid'  => __('Please enter valid email')
											),
					'tenure_expiry_date' 	=> array(
												'invalid'  => __('Tenure To date must be grater than Tenure From')
												), 
				)
        );
    }
}
