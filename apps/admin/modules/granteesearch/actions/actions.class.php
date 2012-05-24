<?php
/**
 * granteesearch actions.
 *
 * @package    Cemetery
 * @subpackage granteesearch
 * @author     Nitin Barai
 * @author      
 *
 */
sfProjectConfiguration::getActive()->loadHelpers(array('I18N'));
class granteesearchActions extends sfActions
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
        $this->ssFormName = 'frm_list_granteesearch';
        $omRequest        = sfContext::getInstance()->getRequest();

		$amGranteeFormRequest = $this->getRequestParameter('grantee');
		
        // Set default values
        $this->amExtraParameters = array();
        $this->amExtraParameters['snPaging']        = $this->snPaging       = $omRequest->getParameter('paging',sfConfig::get('app_default_paging_records'));
        $this->amExtraParameters['snPage']          = $this->snPage         = $omRequest->getParameter('page', sfConfig::get('app_default_page', 1));
        
        $country_id = (isset($amGranteeFormRequest['country_id']) == '') ? trim($omRequest->getParameter('country_id')) : $amGranteeFormRequest['country_id'];
        $cem_cemetery_id = (isset($amGranteeFormRequest['cem_cemetery_id']) == '') ? trim($omRequest->getParameter('grantee_cem_cemetery_id')) : $amGranteeFormRequest['cem_cemetery_id'];
        
        $grantee_first_name = ($amGranteeFormRequest['grantee_first_name'] == '') ? trim($omRequest->getParameter('grantee_first_name')) : $amGranteeFormRequest['grantee_first_name'];        
        $grantee_middle_name = ($amGranteeFormRequest['grantee_middle_name'] == '') ? trim($omRequest->getParameter('grantee_middle_name')) : $amGranteeFormRequest['grantee_middle_name'];
        $grantee_surname = ($amGranteeFormRequest['grantee_surname'] == '') ? trim($omRequest->getParameter('grantee_surname')) : $amGranteeFormRequest['grantee_surname'];                
        $grantee_dob = ($amGranteeFormRequest['grantee_dob'] == '') ? trim($omRequest->getParameter('grantee_dob')) : $amGranteeFormRequest['grantee_dob'];
        $receipt_number = ($amGranteeFormRequest['receipt_number'] == '') ? trim($omRequest->getParameter('receipt_number')) : $amGranteeFormRequest['receipt_number'];
        $date_of_purchase = ($amGranteeFormRequest['date_of_purchase'] == '') ? trim($omRequest->getParameter('date_of_purchase')) : $amGranteeFormRequest['date_of_purchase'];
        $tenure_expiry_date = ($amGranteeFormRequest['tenure_expiry_date'] == '') ? trim($omRequest->getParameter('tenure_expiry_date')) : $amGranteeFormRequest['tenure_expiry_date'];
        $grantee_id_number = ($amGranteeFormRequest['grantee_id_number'] == '') ? trim($omRequest->getParameter('grantee_id_number')) : $amGranteeFormRequest['grantee_id_number'];
        $grantee_identity_id = ($amGranteeFormRequest['grantee_identity_id'] == '') ? trim($omRequest->getParameter('grantee_identity_id')) : $amGranteeFormRequest['grantee_identity_id'];

        $this->amExtraParameters['ssSearchCountryId']   	= $this->ssSearchCountryId  		= ($country_id != '') ? $country_id : '0';        
        $this->amExtraParameters['ssSearchCemCemeteryId']   = $this->ssSearchCemCemeteryId  	= ($cem_cemetery_id != '') ? $cem_cemetery_id : '0';
       
	   if($this->ssSearchCountryId != '0' && $this->ssSearchCemCemeteryId == '0'):
			$this->amExtraParameters['ssSearchCemCemeteryId'] = '';
		elseif($this->ssSearchCountryId == '0' && $this->ssSearchCemCemeteryId == '0'):
			$this->amExtraParameters['ssSearchCemCemeteryId'] = '';
			$this->amExtraParameters['ssSearchCountryId'] = '';
		endif;
	   
	    $this->amExtraParameters['ssSearchArAreaId']   	= $this->ssSearchArAreaId  	= ($omRequest->getParameter('grantee_ar_area_id') != '' ) ? $omRequest->getParameter('grantee_ar_area_id') : '';
        $this->amExtraParameters['ssSearchArSectionId']   	= $this->ssSearchArSectionId  	= ($omRequest->getParameter('grantee_ar_section_id') != '') ? $omRequest->getParameter('grantee_ar_section_id') : '';
        $this->amExtraParameters['ssSearchArRowId']   	= $this->ssSearchArRowId  	= ($omRequest->getParameter('grantee_ar_row_id') != '') ? $omRequest->getParameter('grantee_ar_row_id') : '';
        $this->amExtraParameters['ssSearchArPlotId']   	= $this->ssSearchArPlotId  	= ($omRequest->getParameter('grantee_ar_plot_id') != '') ? $omRequest->getParameter('grantee_ar_plot_id') : '';

        $this->amExtraParameters['ssSearchArGraveId']   	= $this->ssSearchArGraveId  	= trim($omRequest->getParameter('grantee_ar_grave_id')); 
        
		// Set Advance search values
        $this->amExtraParameters['ssSearchGranteeFirstName']   	= $this->ssSearchGranteeFirstName  	= trim($grantee_first_name);
        $this->amExtraParameters['ssSearchGranteeMiddleName']   = $this->ssSearchGranteeMiddleName  = trim($grantee_middle_name);
        $this->amExtraParameters['ssSearchGranteeSurname']   	= $this->ssSearchGranteeSurname  	= trim($grantee_surname);
        $this->amExtraParameters['ssSearchGranteeDob']   		= $this->ssSearchGranteeDOB  		= (trim($grantee_dob) != '') ? date('Y-m-d',strtotime(trim($grantee_dob))) : trim($grantee_dob);
        $this->amExtraParameters['ssSearchReceiptNumber']   	= $this->ssSearchReceiptNumber  	= trim($receipt_number);
        $this->amExtraParameters['ssSearchDateOfPurchase']   	= $this->ssSearchDateOfPurchase 	= ($date_of_purchase != '') ? date('Y-m-d',strtotime(trim($date_of_purchase))) : trim($date_of_purchase);
        $this->amExtraParameters['ssSearchTenureExpiryDate']   	= $this->ssSearchTenureExpiryDate  	= ($tenure_expiry_date != '') ? date('Y-m-d',strtotime(trim($tenure_expiry_date))) : trim($tenure_expiry_date);
        $this->amExtraParameters['ssSearchGranteeIdNumber']   	= $this->ssSearchGranteeIdNumber  	= trim($grantee_id_number);
        $this->amExtraParameters['ssSearchGranteeIdentityId']   	= $this->ssSearchGranteeIdentity  	= trim($grantee_identity_id);
        
        $this->amExtraParameters['ssSortBy']        = $this->ssSortBy       = $omRequest->getParameter('sortby','id');
        $this->amExtraParameters['ssSortMode']      = $this->ssSortMode     = $omRequest->getParameter('sortmode','asc');

        $this->ssSortQuerystr = $this->ssQuerystr = 'page='.$this->snPage.'&paging='.$this->snPaging;

        if($this->ssSearchArGraveId != '' )        // Search parameters
        {
            $this->ssQuerystr    .= '&searchGraveNumber='.$this->ssSearchArGraveId;
            $this->ssSortQuerystr.= '&searchGraveNumber='.$this->ssSearchArGraveId;
        }
        if($country_id != '' )        // Search parameters
        {
            $this->ssQuerystr    .= '&searchCountryId='.$country_id;
            $this->ssSortQuerystr.= '&searchCountryId='.$country_id;
        }
		if($this->ssSearchCemCemeteryId != '' )        // Search parameters
        {
            $this->ssQuerystr    .= '&searchCemCemeteryId='.$this->ssSearchCemCemeteryId;
            $this->ssSortQuerystr.= '&searchCemCemeteryId='.$this->ssSearchCemCemeteryId;
        }
		if($this->ssSearchArAreaId != '' )        // Search parameters
        {
            $this->ssQuerystr    .= '&searchArAreaId='.$this->ssSearchArAreaId;
            $this->ssSortQuerystr.= '&searchArAreaId='.$this->ssSearchArAreaId;
        }
        if($this->ssSearchArSectionId != '' )        // Search parameters
        {
            $this->ssQuerystr    .= '&searchArSectionId='.$this->ssSearchArSectionId;
            $this->ssSortQuerystr.= '&searchArSectionId='.$this->ssSearchArSectionId;
        }
        if($this->ssSearchArRowId != '' )        // Search parameters
        {
            $this->ssQuerystr    .= '&searchArRowId='.$this->ssSearchArRowId;
            $this->ssSortQuerystr.= '&searchArRowId='.$this->ssSearchArRowId;
        }
        if($this->ssSearchArPlotId != '' )        // Search parameters
        {
            $this->ssQuerystr    .= '&searchArPlotId='.$this->ssSearchArPlotId;
            $this->ssSortQuerystr.= '&searchArPlotId='.$this->ssSearchArPlotId;
        }
		if($this->ssSearchArGraveId != '' )        // Search parameters
        {
            $this->ssQuerystr    .= '&searchArGraveId='.$this->ssSearchArGraveId;
            $this->ssSortQuerystr.= '&searchArGraveId='.$this->ssSearchArGraveId;
        }
        
		// Advance search parameters             
        if($grantee_first_name != '' )        // Search parameters
        {
            $this->ssQuerystr    .= '&searchGranteeFirstName='.$grantee_first_name;
            $this->ssSortQuerystr.= '&searchGranteeFirstName='.$grantee_first_name;
        }
		if($grantee_middle_name != '' )        // Search parameters
        {
            $this->ssQuerystr    .= '&searchGranteeMiddleName='.$grantee_middle_name;
            $this->ssSortQuerystr.= '&searchGranteeMiddleName='.$grantee_middle_name;
        }
		if($grantee_surname != '' )        // Search parameters
        {
            $this->ssQuerystr    .= '&searchGranteeSurname='.$grantee_surname;
            $this->ssSortQuerystr.= '&searchGranteeSurname='.$grantee_surname;
        }
		if($grantee_dob != '' )        // Search parameters
        {
            $this->ssQuerystr    .= '&searchGranteeDob='.$grantee_dob;
            $this->ssSortQuerystr.= '&searchGranteeDob='.$grantee_dob;
        }
		if($receipt_number != '' )        // Search parameters
        {
            $this->ssQuerystr    .= '&searchReceiptNumber='.$receipt_number;
            $this->ssSortQuerystr.= '&searchReceiptNumber='.$receipt_number;
        }
		if($date_of_purchase != '' )        // Search parameters
        {
            $this->ssQuerystr    .= '&searchDateOfPurchase='.$date_of_purchase;
            $this->ssSortQuerystr.= '&searchDateOfPurchase='.$date_of_purchase;
        }
		if($tenure_expiry_date != '' )        // Search parameters
        {
            $this->ssQuerystr    .= '&searchTenureExpiryDate='.$tenure_expiry_date;
            $this->ssSortQuerystr.= '&searchTenureExpiryDate='.$tenure_expiry_date;
        }
		if($grantee_id_number != '' )        // Search parameters
        {
            $this->ssQuerystr    .= '&searchGranteeIdNumber='.$grantee_id_number;
            $this->ssSortQuerystr.= '&searchGranteeIdNumber='.$grantee_id_number;
        }
		if($grantee_identity_id != '' )        // Search parameters
        {
            $this->ssQuerystr    .= '&searchGranteeIdentityId='.$grantee_identity_id;
            $this->ssSortQuerystr.= '&searchGranteeIdentityId='.$grantee_identity_id;
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
		
		 if($request->isMethod('post') && $request->getParameter('request_type') != 'ajax_request'){
			$arr_session = $this->getRequestParameter('grantee');
			
			$this->getUser()->setAttribute('gfname', $arr_session['grantee_first_name']);		
			$this->getUser()->setAttribute('gmname', $arr_session['grantee_middle_name']);		
			$this->getUser()->setAttribute('gsname', $arr_session['grantee_surname']);		
			$this->getUser()->setAttribute('gdob', $arr_session['grantee_dob']);		
			$this->getUser()->setAttribute('grn', $arr_session['receipt_number']);		
			$this->getUser()->setAttribute('gdop', $arr_session['date_of_purchase']);		
			$this->getUser()->setAttribute('gted', $arr_session['tenure_expiry_date']);		
			$this->getUser()->setAttribute('gin', $arr_session['grantee_id_number']);		
			$this->getUser()->setAttribute('gii', $arr_session['grantee_identity_id']);		
			
			
			
			$this->getUser()->setAttribute('cn', $arr_session['country_id']);		
			$this->getUser()->setAttribute('gn', ($request->getParameter('grantee_ar_grave_id') != '') ? $request->getParameter('grantee_ar_grave_id') : '');		
			

			
			$temp_cem = '';
			if(isset($arr_session['cem_cemetery_id'])) {
				$temp_cem = $arr_session['cem_cemetery_id'];
			}
			
			if($temp_cem == '') {
				$temp_cem = $request->getParameter('grantee_cem_cemetery_id');		
			}			
			
			
			$this->getUser()->setAttribute('cm', $temp_cem);
			
			$this->getUser()->setAttribute('ar', ($request->getParameter('grantee_ar_area_id') != '') ? $request->getParameter('grantee_ar_area_id') : '');
			$this->getUser()->setAttribute('sc', ($request->getParameter('grantee_ar_section_id') != '') ? $request->getParameter('grantee_ar_section_id') : '');
			$this->getUser()->setAttribute('rw', ($request->getParameter('grantee_ar_row_id') != '') ? $request->getParameter('grantee_ar_row_id') : '');	
			$this->getUser()->setAttribute('pl', ($request->getParameter('grantee_ar_plot_id') != '') ? $request->getParameter('grantee_ar_plot_id') : '');			
			
			
			
		}else {
			if($request->getParameter('request_type') != 'ajax_request') {
				$this->getUser()->setAttribute('gfname', '');		
				$this->getUser()->setAttribute('gmname', '');		
				$this->getUser()->setAttribute('gsname', '');		
				$this->getUser()->setAttribute('gdob', '');		
				$this->getUser()->setAttribute('grn', '');		
				$this->getUser()->setAttribute('gdop', '');		
				$this->getUser()->setAttribute('gted', '');		
				$this->getUser()->setAttribute('gin', '');		
				$this->getUser()->setAttribute('gii', '');					
				
				$this->getUser()->setAttribute('cn', '');
				$this->getUser()->setAttribute('gn', '');
				$this->getUser()->setAttribute('cm', '');
				$this->getUser()->setAttribute('ar', '');
				$this->getUser()->setAttribute('sc', '');
				$this->getUser()->setAttribute('rw', '');	
				$this->getUser()->setAttribute('pl', '');
			}
		}		
		
		
        //set search combobox field
        $this->amSearch = array(
								'country_id' => array(
												'caption'	=> __('Country'),
												'id'		=> 'CountryId',
												'type'		=> 'integer',																								
											),		
								'cem_cemetery_id' => array(
												'caption'	=> __('Cemetery'),
												'id'		=> 'CemCemeteryId',
												'type'		=> 'integer',																								
											),													
																				
								'ar_area_id' => array(
												'caption'	=> __('Area Name'),
												'id'		=> 'ArAreaId',
												'type'		=> 'integer',																								
											),			
								'ar_section_id' => array(
												'caption'	=> __('Section Name'),
												'id'		=> 'ArSectionId',
												'type'		=> 'integer',																								
											),			
								'ar_row_id' => array(
												'caption'	=> __('Row Name'),
												'id'		=> 'ArRowId',
												'type'		=> 'integer',																								
											),			
											
								'ar_plot_id' => array(
												'caption'	=> __('Plot Name'),
												'id'		=> 'ArPlotId',
												'type'		=> 'integer',
											),
								'ar_grave_id' => array(
												'caption'	=> __('Grave Number'),
												'id'		=> 'ArGraveId',
												'type'		=> 'integer',																								
											),													
								'gtd.grantee_first_name' => array(
												'caption'	=> __('Grantee First Name'),
												'id'		=> 'GranteeFirstName',
												'type'		=> 'text',
											),
								'gtd.grantee_middle_name' => array(
												'caption'	=> __('Grantee Middle Name'),
												'id'		=> 'GranteeMiddleName',
												'type'		=> 'text',
											),
								'gtd.grantee_surname' => array(
												'caption'	=> __('Grantee Surname'),
												'id'		=> 'GranteeSurname',
												'type'		=> 'text',
											),
								'gtd.grantee_dob' => array(
												'caption'	=> __('Grantee Dob'),
												'id'		=> 'GranteeDob',
												'type'		=> 'text',
											),
								'receipt_number' => array(
												'caption'	=> __('Receipt Number'),
												'id'		=> 'ReceiptNumber',
												'type'		=> 'text',
											),
								'date_of_purchase' => array(
												'caption'	=> __('Date Of Purchase'),
												'id'		=> 'DateOfPurchase',
												'type'		=> 'text',
											),
								'tenure_expiry_date' => array(
												'caption'	=> __('Tenure Expiry Date'),
												'id'		=> 'TenureExpiryDate',
												'type'		=> 'text',
											),
								'gtd.grantee_id_number' => array(
												'caption'	=> __('Grantee Id Number'),
												'id'		=> 'GranteeIdNumber',
												'type'		=> 'text',
											),
								'grantee_identity_id' => array(
												'caption'	=> __('Grantee Identity Id'),
												'id'		=> 'GranteeIdentityId',
												'type'		=> 'integer',
											),
							);
        $omCommon = new common();

        // Get cms page list for listing.
        $oArGravePageListQuery = Doctrine::getTable('Grantee')->getGranteeListForSearch($this->amExtraParameters, $this->amSearch);
	
		// Replace Doctrine Pager Count Query By Mannual Count Query.
		$ssCountQuery = Doctrine::getTable('Grantee')->getGranteeListForSearchCount($this->amExtraParameters, $this->amSearch);

        // Set pager and get results
        $oPager               = new sfMyPager();
        $this->oArGraveList  = $oPager->getResults('Grantee', $this->snPaging,$oArGravePageListQuery,$this->snPage,$ssCountQuery);
        $this->amArGraveList = $this->oArGraveList->getResults(Doctrine::HYDRATE_ARRAY);

        unset($oPager);

        // Total number of records
        $this->snPageTotalArGravePages = $this->oArGraveList->getNbResults();

        if($request->getParameter('request_type') == 'ajax_request')
            $this->setTemplate('listGraveUpdate');
    }

   /**
    * update action
    *
    * Update cms pages   
    * @access public
    * @param  object $oRequest A request object
    *     
    */
    public function executeSearch(sfWebRequest $oRequest)
    {
	
		if($oRequest->getParameter('back') != 'true'){
			$this->getUser()->setAttribute('gfname', '');		
			$this->getUser()->setAttribute('gmname', '');		
			$this->getUser()->setAttribute('gsname', '');		
			$this->getUser()->setAttribute('gdob', '');		
			$this->getUser()->setAttribute('grn', '');		
			$this->getUser()->setAttribute('gdop', '');		
			$this->getUser()->setAttribute('gted', '');		
			$this->getUser()->setAttribute('gin', '');		
			$this->getUser()->setAttribute('gii', '');			
			
			$this->getUser()->setAttribute('cn', '');
			$this->getUser()->setAttribute('gn', '');
			$this->getUser()->setAttribute('cm', '');
			$this->getUser()->setAttribute('ar', '');
			$this->getUser()->setAttribute('sc', '');
			$this->getUser()->setAttribute('rw', '');	
			$this->getUser()->setAttribute('pl', '');
		}	
		
        $ssSuccessKey   = 4; // Success message key for add

        $this->snCementeryId = $oRequest->getParameter('grantee_cem_cemetery_id', '');
        $this->snAreaId = $oRequest->getParameter('grantee_ar_area_id', '');
        $this->snSectionId = $oRequest->getParameter('grantee_ar_section_id', '');
        $this->snRowId = $oRequest->getParameter('grantee_ar_row_id', '');
        $this->snPlotId = $oRequest->getParameter('grantee_ar_plot_id', '');
        $this->snGraveId = $oRequest->getParameter('grantee_ar_grave_id', '');
		
		$this->asCementery = $this->asAreaList = $this->asSectionList = $this->asRowList = $this->asPlotList = $this->asGraveList = array();
        $this->oArGraveForm = new GranteeSearchForm();

        $this->getConfigurationFields($this->oArGraveForm);
		$amGraveFormRequest = $oRequest->getParameter($this->oArGraveForm->getName());

		if($amGraveFormRequest['country_id'] != '')
			$this->asCementery = Doctrine::getTable('CemCemetery')->getAllCemeteries($amGraveFormRequest['country_id']);
		if($this->snCementeryId != '' && $amGraveFormRequest['country_id'] != '')
			$this->asAreaList = Doctrine::getTable('ArArea')->getAreaListAsPerCemetery($amGraveFormRequest['country_id'], $this->snCementeryId);
		if($amGraveFormRequest['country_id'] != '' && $this->snCementeryId != '' && $this->snAreaId != '')
			$this->asSectionList = Doctrine::getTable('ArSection')->getSectionListAsPerArea($amGraveFormRequest['country_id'], $this->snCementeryId, $this->snAreaId);
		if($amGraveFormRequest['country_id'] != '' && $this->snCementeryId != '' && $this->snAreaId != '' && $this->snSectionId != '')
			$this->asRowList = Doctrine::getTable('ArRow')->getRowListAsPerSection($amGraveFormRequest['country_id'], $this->snCementeryId, $this->snAreaId, $this->snSectionId);
		if($amGraveFormRequest['country_id'] != '' && $this->snCementeryId != '' && $this->snAreaId != '' && $this->snSectionId != '' && $this->snRowId != '')
			$this->asPlotList = Doctrine::getTable('ArPlot')->getPlotListAsPerArea($amGraveFormRequest['country_id'],$this->snCementeryId,$this->snAreaId,$this->snSectionId,$this->snRowId);

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
		return $this->renderPartial('getCementeryList', array('asCementryList' => $asCementery, 'snCementeryId' => $snCementeryId));
	}
	/**
    * Executes getAreaListAsPerCemetery action
    *
    * @access public
    * @param sfRequest $request A request object
    */
    public function executeGetAreaListAsPerCemetery(sfWebRequest $request)
    {	
		$snAreaId = $request->getParameter('arval','');
		$snIdCountry = $request->getParameter('country_id','');
		$snCemeteryId = $request->getParameter('cemetery_id','');
		$asAreaList = Doctrine::getTable('ArArea')->getAreaListAsPerCemetery($snIdCountry, $snCemeteryId);
		return $this->renderPartial('getAreaList', array('asAreaList' => $asAreaList, 'snAreaId' => $snAreaId));
	}
	/**
    * Executes getSectionListAsPerArea action
    *
    * @access public
    * @param sfRequest $request A request object
    */
    public function executeGetSectionListAsPerArea(sfWebRequest $request)
    {	
		
		$snSectionId = $request->getParameter('secval','');
		$snIdCountry = $request->getParameter('country_id','');
		$snCemeteryId = $request->getParameter('cemetery_id','');
		$snAreaId = $request->getParameter('area_id','');
		$asSectionList = Doctrine::getTable('ArSection')->getSectionListAsPerArea($snIdCountry,$snCemeteryId,$snAreaId);

		return $this->renderPartial('getSectionList', array('asSectionList' => $asSectionList, 'snSectionId' => $snSectionId));
	}
	/**
    * Executes getRowListAsPerSection action
    *
    * @access public
    * @param sfRequest $request A request object
    */
    public function executeGetRowListAsPerSection(sfWebRequest $request)
    {	
		
		$snRowId = $request->getParameter('rwval','');
		$snIdCountry = $request->getParameter('country_id','');
		$snCemeteryId = $request->getParameter('cemetery_id','');
		$snAreaId = $request->getParameter('area_id','');
		$snSectionId = $request->getParameter('section_id','');
		$asRowList = Doctrine::getTable('ArRow')->getRowListAsPerSection($snIdCountry,$snCemeteryId,$snAreaId,$snSectionId);

		return $this->renderPartial('getRowList', array('asRowList' => $asRowList, 'snRowId' => $snRowId));
	}
	/**
    * Executes getPlotListAsPerRow action
    *
    * @access public
    * @param sfRequest $request A request object
    */
    public function executeGetPlotListAsPerRow(sfWebRequest $request)
    {	
		
		$snPlotId = $request->getParameter('plval','');
		$snIdCountry = $request->getParameter('country_id','');
		$snCemeteryId = $request->getParameter('cemetery_id','');
		$snAreaId = $request->getParameter('area_id','');
		$snSectionId = $request->getParameter('section_id','');
		$snRowId = $request->getParameter('row_id','');
		$asPlotList = Doctrine::getTable('ArPlot')->getPlotListAsPerArea($snIdCountry,$snCemeteryId,$snAreaId,$snSectionId,$snRowId);

		return $this->renderPartial('getPlotList', array('asPlotList' => $asPlotList, 'snPlotId' => $snPlotId));
	}

	/**
    * Executes getGraveListAsPerPlot action
    *
    * @access public
    * @param sfRequest $request A request object
    */
    public function executeGetGraveListAsPerPlot(sfWebRequest $request)
    {	
		$snGraveId = $request->getParameter('gnval','');
		$snIdCountry = $request->getParameter('country_id','');
		$snCemeteryId = $request->getParameter('cemetery_id','');
		$snAreaId = $request->getParameter('area_id','');
		$snSectionId = $request->getParameter('section_id','');
		$snRowId = $request->getParameter('row_id','');
		$snPlotId = $request->getParameter('plot_id','');
		
		$asGraveList = Doctrine::getTable('ArGrave')->getGraveListAsPerCriteria($snIdCountry,$snCemeteryId,$snAreaId,$snSectionId,$snRowId,$snPlotId,'search');

		return $this->renderPartial('getGraveList', array('asGraveList' => $asGraveList, 'snGraveId' => $snGraveId));
	}
	
	//----------------------
	// Custom Filter Ajax 
	//----------------------

	/**
    * Executes getCementryListAsPerCountry action
    *
    * @access public
    * @param sfRequest $request A request object
    */
    public function executeGetCustomCementryListAsPerCountry(sfWebRequest $request)
    {
		$snCementeryId = $request->getParameter('cnval','');	
		$snIdCountry = $request->getParameter('id','');	
		$asCementery = Doctrine::getTable('CemCemetery')->getAllCemeteries($snIdCountry);
		
		return $this->renderPartial('getCustomCementeryList', array('asCementryList' => $asCementery, 'snCementeryId' => $snCementeryId));
	}
	/**
    * Executes getAreaListAsPerCemetery action
    *
    * @access public
    * @param sfRequest $request A request object
    */
    public function executeGetCustomAreaListAsPerCemetery(sfWebRequest $request)
    {	
		$snAreaId = $request->getParameter('arval','');
		$snIdCountry = $request->getParameter('country_id','');
		$snCemeteryId = $request->getParameter('cemetery_id','');
		$asAreaList = Doctrine::getTable('ArArea')->getAreaListAsPerCemetery($snIdCountry, $snCemeteryId);
		return $this->renderPartial('getCustomAreaList', array('asAreaList' => $asAreaList, 'snAreaId' => $snAreaId));
	}
	/**
    * Executes getSectionListAsPerArea action
    *
    * @access public
    * @param sfRequest $request A request object
    */
    public function executeGetCustomSectionListAsPerArea(sfWebRequest $request)
    {	
		
		$snSectionId = $request->getParameter('secval','');
		$snIdCountry = $request->getParameter('country_id','');
		$snCemeteryId = $request->getParameter('cemetery_id','');
		$snAreaId = $request->getParameter('area_id','');
		$asSectionList = Doctrine::getTable('ArSection')->getSectionListAsPerArea($snIdCountry,$snCemeteryId,$snAreaId);

		return $this->renderPartial('getCustomSectionList', array('asSectionList' => $asSectionList, 'snSectionId' => $snSectionId));
	}
	/**
    * Executes getRowListAsPerSection action
    *
    * @access public
    * @param sfRequest $request A request object
    */
    public function executeGetCustomRowListAsPerSection(sfWebRequest $request)
    {	
		
		$snRowId = $request->getParameter('rwval','');
		$snIdCountry = $request->getParameter('country_id','');
		$snCemeteryId = $request->getParameter('cemetery_id','');
		$snAreaId = $request->getParameter('area_id','');
		$snSectionId = $request->getParameter('section_id','');
		$asRowList = Doctrine::getTable('ArRow')->getRowListAsPerSection($snIdCountry,$snCemeteryId,$snAreaId,$snSectionId);

		return $this->renderPartial('getCustomRowList', array('asRowList' => $asRowList, 'snRowId' => $snRowId));
	}
	/**
    * Executes getPlotListAsPerRow action
    *
    * @access public
    * @param sfRequest $request A request object
    */
    public function executeGetCustomPlotListAsPerRow(sfWebRequest $request)
    {	
		
		$snPlotId = $request->getParameter('plval','');
		$snIdCountry = $request->getParameter('country_id','');
		$snCemeteryId = $request->getParameter('cemetery_id','');
		$snAreaId = $request->getParameter('area_id','');
		$snSectionId = $request->getParameter('section_id','');
		$snRowId = $request->getParameter('row_id','');
		$asPlotList = Doctrine::getTable('ArPlot')->getPlotListAsPerArea($snIdCountry,$snCemeteryId,$snAreaId,$snSectionId,$snRowId);

		return $this->renderPartial('getCustomPlotList', array('asPlotList' => $asPlotList, 'snPlotId' => $snPlotId));
	}

	/**
    * Executes getGraveListAsPerPlot action
    *
    * @access public
    * @param sfRequest $request A request object
    */
    public function executeGetCustomGraveListAsPerPlot(sfWebRequest $request)
    {	
		$snGraveId = $request->getParameter('gnval','');
		$snIdCountry = $request->getParameter('country_id','');
		$snCemeteryId = $request->getParameter('cemetery_id','');
		$snAreaId = $request->getParameter('area_id','');
		$snSectionId = $request->getParameter('section_id','');
		$snRowId = $request->getParameter('row_id','');
		$snPlotId = $request->getParameter('plot_id','');
		
		$asGraveList = Doctrine::getTable('ArGrave')->getGraveListAsPerCriteria($snIdCountry,$snCemeteryId,$snAreaId,$snSectionId,$snRowId,$snPlotId,'search');

		return $this->renderPartial('getCustomGraveList', array('asGraveList' => $asGraveList, 'snGraveId' => $snGraveId));
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
					'grantee_identity_id' => __('Select Grantee Identity')
				 )
		);

		$oForm->setDefault('country_id', $this->getUser()->getAttribute('cn'));
		
		$oForm->setDefault('grantee_first_name', $this->getUser()->getAttribute('gfname'));
		$oForm->setDefault('grantee_middle_name', $this->getUser()->getAttribute('gmname'));
		$oForm->setDefault('grantee_surname', $this->getUser()->getAttribute('gsname'));
		
		$oForm->setDefault('grantee_dob', $this->getUser()->getAttribute('gdob'));
		$oForm->setDefault('receipt_number', $this->getUser()->getAttribute('grn'));
		$oForm->setDefault('date_of_purchase', $this->getUser()->getAttribute('gdop'));
		$oForm->setDefault('tenure_expiry_date', $this->getUser()->getAttribute('gted'));
		$oForm->setDefault('grantee_id_number', $this->getUser()->getAttribute('gin'));
		$oForm->setDefault('grantee_identity_id', $this->getUser()->getAttribute('gii'));
		
					
	
			
		

        $oForm->setLabels(
            array(
                'country_id'       	=> __('Select Country'),
                'cem_cemetery_id'  => __('Select Cemetery'),
				'grantee_first_name' 	=> __('Grantee First Name'),
				'grantee_surname'		=> __('Grantee Surname'),
				'grantee_middle_name'	=> __('Grantee Middle Name'),
				'grantee_dob'			=> __('Grantee DOB'),
				'receipt_number'		=> __('Receipt Number'),
				'date_of_purchase'		=> __('Date Of Purchase'),
				'grantee_id_number'		=> __('Grantee Id Number'),
				'tenure_expiry_date'	=> __('Tenure Expiry Date'),
				'grantee_identity_id'		=> __('Grantee Identity'),
            )
        );
    }
}
