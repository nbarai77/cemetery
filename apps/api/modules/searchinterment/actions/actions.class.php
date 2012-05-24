<?php

/**
 * searchinterment actions.
 *
 * @package    cemetery
 * @subpackage searchinterment
 * @author     Prakash Panchal
 * @version    SVN: $Id: actions.class.php,v 1.1.1.1 2012/03/24 12:16:48 nitin Exp $
 */
sfProjectConfiguration::getActive()->loadHelpers(array('I18N'));
class searchintermentActions extends sfActions
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

        $omRequest        = sfContext::getInstance()->getRequest();
		$this->ssFormName = 'frm_list_interments';
		
        // Set default values
        $this->amExtraParameters = array();
        $this->amExtraParameters['snPaging']        = $this->snPaging       = $omRequest->getParameter('paging', sfConfig::get('app_default_paging_records')); //
        $this->amExtraParameters['snPage']          = $this->snPage         = $omRequest->getParameter('page', sfConfig::get('app_default_page', 1));
        
		$ssIntermentDate = trim($omRequest->getParameter('interment_date',''));
		if($ssIntermentDate != '')
		{
			list($snDay,$snMonth,$snYear) = explode('-',$ssIntermentDate);
			$ssIntermentDate = $snYear.'-'.$snMonth.'-'.$snDay;
		}

        // Search Parameter
        $this->amExtraParameters['ssSearchDeceasedSurname']   	= $this->ssSearchDeceasedSurname  	= trim($omRequest->getParameter('surname',''));
        $this->amExtraParameters['ssSearchDeceasedFirstName']   = $this->ssSearchDeceasedFirstName 	= trim($omRequest->getParameter('name',''));
		$this->ssSearchYearFrom = trim($omRequest->getParameter('yrfrom',''));
		$this->ssSearchYearTo 	= trim($omRequest->getParameter('yrto',''));
        $this->amExtraParameters['ssSearchIntermentDate']   	= $this->ssSearchIntermentDate  	= $ssIntermentDate;
        // Sort Parameter        
        $this->amExtraParameters['ssSortBy']       				= $this->ssSortBy       			= trim($omRequest->getParameter('sortby','id'));
        $this->amExtraParameters['ssSortMode']      			= $this->ssSortMode    				= trim($omRequest->getParameter('sortmode','asc'));

        $this->ssSortQuerystr = $this->ssQuerystr = 'page='.$this->snPage.'&paging='.$this->snPaging;

        // Advance search parameters                     
		if($this->ssSearchDeceasedSurname != '' )        // Search parameters
        {
            $this->ssQuerystr    .= '&searchDeceasedSurname='.$this->ssSearchDeceasedSurname;
            $this->ssSortQuerystr.= '&searchDeceasedSurname='.$this->ssSearchDeceasedSurname;
        }
        if($this->ssSearchDeceasedFirstName != '' )        // Search parameters
        {
            $this->ssQuerystr    .= '&searchDeceasedFirstName='.$this->ssSearchDeceasedFirstName;
            $this->ssSortQuerystr.= '&searchDeceasedFirstName='.$this->ssSearchDeceasedFirstName;
        }		
		if($this->ssSearchIntermentDate != '' )        // Search parameters
        {
            $this->ssQuerystr    .= '&searchIntermentDate='.$this->ssSearchIntermentDate;
            $this->ssSortQuerystr.= '&searchIntermentDate='.$this->ssSearchIntermentDate;
        }

        if($this->getRequestParameter('sortby') != '' )     // Sorting parameters
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
								'deceased_first_name' => array(
												'caption'	=> __('Deceased First Name'),
												'id'		=> 'DeceasedFirstName',
												'type'		=> 'text',
											),
								'deceased_surname' => array(
												'caption'	=> __('Deceased Surname'),
												'id'		=> 'DeceasedSurname',
												'type'		=> 'text',
											),
								'interment_date' => array(
												'caption'	=> __('Interment Date'),
												'id'		=> 'IntermentDate',
												'type'		=> 'text',
											)
							);
							
    	// Get cms page list for listing.
		$oSearchInterment = Doctrine::getTable('IntermentBooking')->searchIntermentInfo($this->amExtraParameters, $this->amSearch,'', $this->ssSearchYearFrom, $this->ssSearchYearTo);	

		// Set pager and get results
		$oPager               = new sfMyPager();
		$oSearchIntermentList  = $oPager->getResults('Country', $this->snPaging,$oSearchInterment,$this->snPage);
		$amSearchIntermentList = $oSearchIntermentList->getResults(Doctrine::HYDRATE_ARRAY);
	
		// Total number of records
		$snPageTotalSearchInterment = $oSearchIntermentList->getNbResults();
		unset($oPager);

		$asSearchIntermentList = array();
		$snI = 0;
		if(count($amSearchIntermentList) > 0)
		{
			$ssImagePath = sfConfig::get('app_site_url').sfConfig::get('app_upload_dir').'/'.sfConfig::get('app_graveimages_thumbnail_dir').'/';
			foreach($amSearchIntermentList as $asDataSet)
			{
				$asSearchIntermentList[$snI]['id'] 	= $asDataSet['id'];
				$asSearchIntermentList[$snI]['name'] 		= $asDataSet['name'];
				$asSearchIntermentList[$snI]['interment_date'] 			= $asDataSet['interment_date'];
				$asSearchIntermentList[$snI]['cem_name'] 				= $asDataSet['cem_name'];
				$asSearchIntermentList[$snI]['cem_phone'] 				= $asDataSet['cem_phone'];
				$asSearchIntermentList[$snI]['cem_fax'] 				= $asDataSet['cem_fax'];
				$asSearchIntermentList[$snI]['cem_email'] 				= $asDataSet['cem_email'];
				$asSearchIntermentList[$snI]['cem_url'] 				= $asDataSet['cem_url'];
				$asSearchIntermentList[$snI]['cem_address'] 			= $asDataSet['cem_address'];
				$asSearchIntermentList[$snI]['area_code'] 				= ($asDataSet['area_code'] != '') ? $asDataSet['area_code'] : __('N/A');
				$asSearchIntermentList[$snI]['section_code'] 			= ($asDataSet['section_code'] != '') ? $asDataSet['section_code'] : __('N/A');
				$asSearchIntermentList[$snI]['row_name'] 				= ($asDataSet['row_name'] != '') ? $asDataSet['row_name'] : __('N/A');
				$asSearchIntermentList[$snI]['plot_name'] 				= ($asDataSet['plot_name'] != '' && $asDataSet['plot_name'] != '0') ? $asDataSet['plot_name'] : __('N/A');

				$asSearchIntermentList[$snI]['grave_number'] 			= $asDataSet['grave_number'];
				$ssGraveImage = ($asDataSet['grave_image1'] != '') ? $ssImagePath.$asDataSet['grave_image1'] : ( ($asDataSet['grave_image2'] != '') ? $ssImagePath.$asDataSet['grave_image2'] : 'images/noimage.jpeg');
				$asSearchIntermentList[$snI]['grave_image'] 			= $ssGraveImage;
				$asSearchIntermentList[$snI]['deceased_date_of_birth'] 	= $asDataSet['deceased_date_of_birth'];
				$snI++;
			}
		}

        $amResponse = array('data' 			=> $amSearchIntermentList,
        					'totalrecord' 	=> $snPageTotalSearchInterment,
        					'page' 			=> $this->snPage,
        					'paging'		=> $this->snPaging,
							'havetopaginate' => $oSearchIntermentList->haveToPaginate(),
							'currentpage'	=> $oSearchIntermentList->getPage(),
							'firstpage'		=> $oSearchIntermentList->getFirstPage(),
							'lastpage'		=> $oSearchIntermentList->getLastPage()
        					);

		$ssXmlResponse = sfGeneral::showXML($amResponse);
		echo $ssXmlResponse;exit;
    }
	/**
    * Executes getIntermentInfo action
    *
    * @access public
    * @param sfRequest $oRequest A request object
    */
    public function executeGetIntermentInfo(sfWebRequest $oRequest)
    {
		$snIdInterment = $oRequest->getParameter('id','');
		$amResults = Doctrine::getTable('IntermentBooking')->getIntermentInfoAsPerId($snIdInterment);

		$ssXmlResponse = sfGeneral::showXML($amResults);
		echo $ssXmlResponse;exit;
	}
}
