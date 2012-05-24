<?php
/**
 * intermentsearch actions.
 *
 * @package	Cemetery
 * @subpackage intermentsearch
 * @author	 Nitin Barai
 * @author
 *
 */
sfProjectConfiguration::getActive()->loadHelpers(array('I18N'));
class intermentsearchActions extends sfActions
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
		$this->ssFormName = 'frm_list_intermentsearch';
		$omRequest		= sfContext::getInstance()->getRequest();

		$amIntermentFormRequest = $this->getRequestParameter('interment');


		// Set default values
		$this->amExtraParameters = array();
		$this->amExtraParameters['snPaging']		= $this->snPaging	   = $omRequest->getParameter('paging',sfConfig::get('app_default_paging_records'));
		$this->amExtraParameters['snPage']		  = $this->snPage		 = $omRequest->getParameter('page', sfConfig::get('app_default_page', 1));

		$country_id = (isset($amIntermentFormRequest['country_id']) == '') ? trim($omRequest->getParameter('country_id')) : $amIntermentFormRequest['country_id'];
		$cem_cemetery_id = (isset($amIntermentFormRequest['cem_cemetery_id']) == '') ? trim($omRequest->getParameter('interment_cem_cemetery_id')) : $amIntermentFormRequest['cem_cemetery_id'];
		$interment_first_name = ($amIntermentFormRequest['interment_first_name'] == '') ? trim($omRequest->getParameter('interment_first_name')) : $amIntermentFormRequest['interment_first_name'];
		$interment_middle_name = ($amIntermentFormRequest['interment_middle_name'] == '') ? trim($omRequest->getParameter('interment_middle_name')) : $amIntermentFormRequest['interment_middle_name'];
		$interment_surname = ($amIntermentFormRequest['interment_surname'] == '') ? trim($omRequest->getParameter('interment_surname')) : $amIntermentFormRequest['interment_surname'];
		
		$interment_date = ($amIntermentFormRequest['interment_date'] == '') ? trim($omRequest->getParameter('interment_date')) : $amIntermentFormRequest['interment_date'];
		
		$control_number = ($amIntermentFormRequest['control_number'] == '') ? trim($omRequest->getParameter('control_number')) : $amIntermentFormRequest['control_number'];
		$interment_dob = ($amIntermentFormRequest['interment_dob'] == '') ? trim($omRequest->getParameter('interment_dob')) : $amIntermentFormRequest['interment_dob'];
		$interment_birth_place = ($amIntermentFormRequest['interment_birth_place'] == '') ? trim($omRequest->getParameter('interment_birth_place')) : $amIntermentFormRequest['interment_birth_place'];
		$interment_birth_country_id = ($amIntermentFormRequest['interment_birth_country_id'] == '') ? trim($omRequest->getParameter('interment_birth_country_id')) : $amIntermentFormRequest['interment_birth_country_id'];
		$interment_deceased_age = ($amIntermentFormRequest['deceased_age'] == '') ? trim($omRequest->getParameter('deceased_age')) : $amIntermentFormRequest['deceased_age'];
		$interment_private_data = (isset($amIntermentFormRequest['is_private']) ) ? $amIntermentFormRequest['is_private'] : trim($omRequest->getParameter('is_private'));

		$this->amExtraParameters['ssSearchCountryId']   	= $this->ssSearchCountryId  	= ($country_id != '') ? $country_id : '';
		$this->amExtraParameters['ssSearchCemCemeteryId']   	= $this->ssSearchCemCemeteryId  	= ($cem_cemetery_id != '') ? $cem_cemetery_id : '';

		if($this->ssSearchCountryId != '' && $this->ssSearchCemCemeteryId == ''):
			$this->amExtraParameters['ssSearchCemCemeteryId'] = '';
		elseif($this->ssSearchCountryId == '' && $this->ssSearchCemCemeteryId == ''):
			$this->amExtraParameters['ssSearchCemCemeteryId'] = '';
			$this->amExtraParameters['ssSearchCountryId'] = '';
		endif;

		$this->amExtraParameters['ssSearchArAreaId']   	= $this->ssSearchArAreaId  	= ($omRequest->getParameter('interment_ar_area_id') != '' ) ? $omRequest->getParameter('interment_ar_area_id') : '';
		$this->amExtraParameters['ssSearchArSectionId']   	= $this->ssSearchArSectionId  	= ($omRequest->getParameter('interment_ar_section_id') != '') ? $omRequest->getParameter('interment_ar_section_id') : '';
		$this->amExtraParameters['ssSearchArRowId']   	= $this->ssSearchArRowId  	= ($omRequest->getParameter('interment_ar_row_id') != '') ? $omRequest->getParameter('interment_ar_row_id') : '';
		$this->amExtraParameters['ssSearchArPlotId']   	= $this->ssSearchArPlotId  	= ($omRequest->getParameter('interment_ar_plot_id') != '') ? $omRequest->getParameter('interment_ar_plot_id') : '';
		$this->amExtraParameters['ssSearchArGraveId']   = $this->ssSearchArGraveId  	= trim($omRequest->getParameter('interment_ar_grave_id'));

		// Set Advance search values
		$this->amExtraParameters['ssSearchDeceasedFirstName']   	= $this->ssSearchDeceasedFirstName  	= trim($interment_first_name);
		$this->amExtraParameters['ssSearchDeceasedMiddleName']   = $this->ssSearchDeceasedMiddleName  = trim($interment_middle_name);
		$this->amExtraParameters['ssSearchDeceasedSurname']   	= $this->ssSearchDeceasedSurname  	= trim($interment_surname);
		$this->amExtraParameters['ssSearchIntermentDate']   		= $this->ssSearchIntermentDate  		= trim($interment_date);
		$this->amExtraParameters['ssSearchControlNumber']   	= $this->ssSearchControlNumber  	= trim($control_number);

		$this->amExtraParameters['ssSearchDeceasedDateOfBirth']   		= $this->ssSearchDeceasedDateOfBirth  		= (trim($interment_dob) != '') ? date('Y-m-d',strtotime(trim($interment_dob))) : trim($interment_dob);
		$this->amExtraParameters['ssSearchDeceasedPlaceOfBirth']   	= $this->ssSearchDeceasedPlaceOfBirth  	= trim($interment_birth_place);
		$this->amExtraParameters['ssSearchDeceasedCountryIdOfBirth']   	= $this->ssSearchDeceasedCountryIdOfBirth  	= trim($interment_birth_country_id);
		$this->amExtraParameters['ssSearchDeceasedAge']   	= $this->ssSearchDeceasedAge  	= trim($interment_deceased_age);
		$this->amExtraParameters['ssSearchIsPrivate']   	= $this->ssSearchIsPrivate  	= trim($interment_private_data);


		$this->amExtraParameters['ssSortBy']		= $this->ssSortBy	   = $omRequest->getParameter('sortby','interment_date');
		$this->amExtraParameters['ssSortMode']	  = $this->ssSortMode	 = $omRequest->getParameter('sortmode','asc');

		$this->ssSortQuerystr = $this->ssQuerystr = 'page='.$this->snPage.'&paging='.$this->snPaging;

		if($this->ssSearchArGraveId != '' ){
			$this->ssQuerystr	.= '&searchGraveNumber='.$this->ssSearchArGraveId;
			$this->ssSortQuerystr.= '&searchGraveNumber='.$this->ssSearchArGraveId;
		}
		if($country_id != '' ){
			$this->ssQuerystr	.= '&searchCountryId='.$country_id;
			$this->ssSortQuerystr.= '&searchCountryId='.$country_id;
		}
		if($this->ssSearchCemCemeteryId != '' ){
			$this->ssQuerystr	.= '&searchCemCemeteryId='.$this->ssSearchCemCemeteryId;
			$this->ssSortQuerystr.= '&searchCemCemeteryId='.$this->ssSearchCemCemeteryId;
		}
		if($this->ssSearchArAreaId != '' ){
			$this->ssQuerystr	.= '&searchArAreaId='.$this->ssSearchArAreaId;
			$this->ssSortQuerystr.= '&searchArAreaId='.$this->ssSearchArAreaId;
		}
		if($this->ssSearchArSectionId != '' ){
			$this->ssQuerystr	.= '&searchArSectionId='.$this->ssSearchArSectionId;
			$this->ssSortQuerystr.= '&searchArSectionId='.$this->ssSearchArSectionId;
		}
		if($this->ssSearchArRowId != '' ){
			$this->ssQuerystr	.= '&searchArRowId='.$this->ssSearchArRowId;
			$this->ssSortQuerystr.= '&searchArRowId='.$this->ssSearchArRowId;
		}
		if($this->ssSearchArPlotId != '' ){
			$this->ssQuerystr	.= '&searchArPlotId='.$this->ssSearchArPlotId;
			$this->ssSortQuerystr.= '&searchArPlotId='.$this->ssSearchArPlotId;
		}
		if($this->ssSearchArGraveId != '' ){
			$this->ssQuerystr	.= '&searchArGraveId='.$this->ssSearchArGraveId;
			$this->ssSortQuerystr.= '&searchArGraveId='.$this->ssSearchArGraveId;
		}
		if($interment_first_name != '' ){
			$this->ssQuerystr	.= '&searchDeceasedFirstName='.$interment_first_name;
			$this->ssSortQuerystr.= '&searchDeceasedFirstName='.$interment_first_name;
		}
		if($interment_middle_name != '' ){
			$this->ssQuerystr	.= '&searchIntermentDeceasedName='.$interment_middle_name;
			$this->ssSortQuerystr.= '&searchIntermentDeceasedName='.$interment_middle_name;
		}
		if($interment_surname != '' ){
			$this->ssQuerystr	.= '&searchDeceasedSurname='.$interment_surname;
			$this->ssSortQuerystr.= '&searchDeceasedSurname='.$interment_surname;
		}
		if($interment_date != '' ){
			$this->ssQuerystr	.= '&searchIntermentDate='.$interment_date;
			$this->ssSortQuerystr.= '&searchIntermentDate='.$interment_date;
		}
		if($control_number != '' ){
			$this->ssQuerystr	.= '&searchControlNumber='.$control_number;
			$this->ssSortQuerystr.= '&searchControlNumber='.$control_number;
		}
		if($interment_dob != '' ){
			$this->ssQuerystr	.= '&searchDeceasedDateOfBirth='.$interment_dob;
			$this->ssSortQuerystr.= '&searchDeceasedDateOfBirth='.$interment_dob;
		}
		if($interment_birth_country_id != '' ){
			$this->ssQuerystr	.= '&searchDeceasedCountryIdOfBirth='.$interment_birth_country_id;
			$this->ssSortQuerystr.= '&searchDeceasedCountryIdOfBirth='.$interment_birth_country_id;
		}
		if($interment_birth_place != '' ){
			$this->ssQuerystr	.= '&searchDeceasedPlaceOfBirth='.$interment_birth_place;
			$this->ssSortQuerystr.= '&searchDeceasedPlaceOfBirth='.$interment_birth_place;
		}
		if($interment_deceased_age != '' ){
			$this->ssQuerystr	.= '&searchDeceasedAge='.$interment_deceased_age;
			$this->ssSortQuerystr.= '&searchDeceasedAge='.$interment_deceased_age;
		}




		if($this->getRequestParameter('sortby') != '' )		// Sorting parameters
			$this->ssQuerystr .= '&sortby='.$this->getRequestParameter('sortby').'&sortmode='.$this->getRequestParameter('sortmode');

		$this->amExtraParameters['ssQuerystr']	 = $this->ssQuerystr;
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
			$arr_session = $this->getRequestParameter('interment');

			$this->getUser()->setAttribute('gfname', $arr_session['interment_first_name']);
			$this->getUser()->setAttribute('gmname', $arr_session['interment_middle_name']);
			$this->getUser()->setAttribute('gsname', $arr_session['interment_surname']);
			$this->getUser()->setAttribute('gdob', $arr_session['interment_dob']);

			$this->getUser()->setAttribute('gbci', $arr_session['interment_birth_country_id']);
			$this->getUser()->setAttribute('gid', $arr_session['interment_date']);
			$this->getUser()->setAttribute('gcn', $arr_session['control_number']);
			$this->getUser()->setAttribute('gibp', $arr_session['interment_birth_place']);
			$this->getUser()->setAttribute('gage', $arr_session['deceased_age']);
			$this->getUser()->setAttribute('gpvt', (isset($arr_session['is_private'])) ? $arr_session['is_private'] : '');

			$this->getUser()->setAttribute('cn', $arr_session['country_id']);
			$this->getUser()->setAttribute('gn', ($request->getParameter('interment_ar_grave_id') != '') ? $request->getParameter('interment_ar_grave_id') : '');

			$temp_cem = '';
			if(isset($arr_session['cem_cemetery_id'])) {
				$temp_cem = $arr_session['cem_cemetery_id'];
			}

			if($temp_cem == '') {
				$temp_cem = $request->getParameter('interment_cem_cemetery_id');
			}



			$this->getUser()->setAttribute('cm', $temp_cem);

			$this->getUser()->setAttribute('ar', ($request->getParameter('interment_ar_area_id') != '') ? $request->getParameter('interment_ar_area_id') : '');
			$this->getUser()->setAttribute('sc', ($request->getParameter('interment_ar_section_id') != '') ? $request->getParameter('interment_ar_section_id') : '');
			$this->getUser()->setAttribute('rw', ($request->getParameter('interment_ar_row_id') != '') ? $request->getParameter('interment_ar_row_id') : '');
			$this->getUser()->setAttribute('pl', ($request->getParameter('interment_ar_plot_id') != '') ? $request->getParameter('interment_ar_plot_id') : '');


		}else {

			if($request->getParameter('request_type') != 'ajax_request') {
				$this->getUser()->setAttribute('gfname', '');
				$this->getUser()->setAttribute('gmname', '');
				$this->getUser()->setAttribute('gsname', '');
				 $this->getUser()->setAttribute('gdob', '');
				$this->getUser()->setAttribute('gbci', '');
				$this->getUser()->setAttribute('gid', '');
				$this->getUser()->setAttribute('gcn', '');
				$this->getUser()->setAttribute('gibp', '');
				$this->getUser()->setAttribute('gage', '');
				$this->getUser()->setAttribute('gpvt', '');

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
												'caption'	=> __('Country Name'),
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
								'deceased_first_name' => array(
												'caption'	=> __('Deceased First Name'),
												'id'		=> 'DeceasedFirstName',
												'type'		=> 'text',
											),
								'deceased_middle_name' => array(
												'caption'	=> __('Deceased Middle Name'),
												'id'		=> 'DeceasedMiddleName',
												'type'		=> 'text',
											),
								'deceased_surname' => array(
												'caption'	=> __('Deceased Surname'),
												'id'		=> 'DeceasedSurname',
												'type'		=> 'text',
											),
								'interment_date' => array(
												'caption'	=> __('Interment Year'),
												'id'		=> 'IntermentDate',
												'type'		=> 'year',
											),
								'is_private' => array(
												'caption'	=> __('Private'),
												'id'		=> 'IsPrivate',
												'type'		=> 'integer',
											),
								'ibf.control_number' => array(
												'caption'	=> __('Control Number'),
												'id'		=> 'ControlNumber',
												'type'		=> 'text',
											),
								'ibf.deceased_date_of_birth' => array(
												'caption'	=> __('Deceased Date Of Birth'),
												'id'		=> 'DeceasedDateOfBirth',
												'type'		=> 'text',
											),

								'ibf.deceased_place_of_birth' => array(
												'caption'	=> __('Deceased Place Of Birth'),
												'id'		=> 'DeceasedPlaceOfBirth',
												'type'		=> 'text',
											),
								'ibf.deceased_country_id_of_birth' => array(
												'caption'	=> __('Deceased Country Id Of Birth'),
												'id'		=> 'DeceasedCountryIdOfBirth',
												'type'		=> 'text',
											),
								'ibf.deceased_age' => array(
												'caption'	=> __('Deceased Age'),
												'id'		=> 'DeceasedAge',
												'type'		=> 'integer',
											),





							);
		$omCommon = new common();

		// Get cms page list for listing.
		$oArGravePageListQuery = Doctrine::getTable('IntermentBooking')->getIntermentListForSearch($this->amExtraParameters, $this->amSearch);

		// Replace Doctrine Pager Count Query By Mannual Count Query.
		$ssCountQuery = Doctrine::getTable('IntermentBooking')->getIntermentSearchCount($this->amExtraParameters, $this->amSearch);

		// Set pager and get results
		$oPager			   = new sfMyPager();
		$this->oArGraveList  = $oPager->getResults('IntermentBooking', $this->snPaging,$oArGravePageListQuery,$this->snPage,$ssCountQuery);
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
			$this->getUser()->setAttribute('gbci', '');
			$this->getUser()->setAttribute('gid', '');
			$this->getUser()->setAttribute('gcn', '');
			$this->getUser()->setAttribute('gibp', '');
			$this->getUser()->setAttribute('gage', '');
			$this->getUser()->setAttribute('gpvt', '');

			$this->getUser()->setAttribute('cn', '');
			$this->getUser()->setAttribute('gn', '');
			$this->getUser()->setAttribute('cm', '');
			$this->getUser()->setAttribute('ar', '');
			$this->getUser()->setAttribute('sc', '');
			$this->getUser()->setAttribute('rw', '');
			$this->getUser()->setAttribute('pl', '');
		}

		$ssSuccessKey   = 4; // Success message key for add

		$this->snCementeryId = $oRequest->getParameter('interment_cem_cemetery_id', '');
		$this->snAreaId = $oRequest->getParameter('interment_ar_area_id', '');
		$this->snSectionId = $oRequest->getParameter('interment_ar_section_id', '');
		$this->snRowId = $oRequest->getParameter('interment_ar_row_id', '');
		$this->snPlotId = $oRequest->getParameter('interment_ar_plot_id', '');
		$this->snGraveId = $oRequest->getParameter('interment_ar_grave_id', '');

		$this->asCementery = $this->asAreaList = $this->asSectionList = $this->asRowList = $this->asPlotList = $this->asGraveList = array();
		$this->oArGraveForm = new IntermentSearchForm();

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

		$asGraveList = Doctrine::getTable('ArGrave')->getGraveListAsPerCriteria($snIdCountry,$snCemeteryId,$snAreaId,$snSectionId,$snRowId,$snPlotId,'true');

		return $this->renderPartial('getGraveList', array('asGraveList' => $asGraveList, 'snGraveId' => $snGraveId));
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
					'interment_identity_id' => __('Select Interment Identity')
				 )
		);

		$oForm->setDefault('country_id', $this->getUser()->getAttribute('cn'));

		$oForm->setDefault('interment_first_name', $this->getUser()->getAttribute('gfname'));
		$oForm->setDefault('interment_middle_name', $this->getUser()->getAttribute('gmname'));
		$oForm->setDefault('interment_surname', $this->getUser()->getAttribute('gsname'));

		$oForm->setDefault('interment_dob', $this->getUser()->getAttribute('gdob'));

		$oForm->setDefault('control_number', $this->getUser()->getAttribute('gcn'));
		$oForm->setDefault('interment_birth_place', $this->getUser()->getAttribute('gibp'));
		$oForm->setDefault('deceased_age', $this->getUser()->getAttribute('gage'));
		$oForm->setDefault('is_private', $this->getUser()->getAttribute('gpvt'));


		$oForm->setDefault('interment_birth_country_id', $this->getUser()->getAttribute('gbci'));
		$oForm->setDefault('interment_date', $this->getUser()->getAttribute('gid'));


		$oForm->setLabels(
			array(
				'country_id'	   	=> __('Select Country'),
				'cem_cemetery_id'  => __('Select Cemetery'),
				'interment_first_name'  => __('	Deceased First Name'),
				'interment_surname'  => __('	Deceased Surname'),
				'interment_middle_name'  => __('Deceased Middle Name'),
				'interment_dob'  => __('Deceased Dob'),

				'interment_birth_country_id'  => __('Deceased Birth Country'),
				'interment_date'  => __('Interment Year'),
				'control_number'  => __('Control Number'),
				'interment_birth_place'  => __('Deceased Birth Place'),
				'deceased_age'  => __('Deceased Age'),
				'is_private'  => __('Private'),

			)
		);
	}
}
