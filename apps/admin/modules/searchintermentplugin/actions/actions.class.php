<?php

/**
 * searchintermentplugin actions.
 *
 * @package    cemetery
 * @subpackage searchintermentplugin
 * @author     Prakash Panchal
 * @version    SVN: $Id: actions.class.php,v 1.1.1.1 2012/03/24 12:19:39 nitin Exp $
 */
sfProjectConfiguration::getActive()->loadHelpers(array('I18N'));
class searchintermentpluginActions extends sfActions
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
        $this->amExtraParameters['ssSearchDeceasedSurname']   	= $this->ssSearchDeceasedSurname  	= trim($omRequest->getParameter('surnm',''));
        $this->amExtraParameters['ssSearchDeceasedFirstName']   = $this->ssSearchDeceasedFirstName 	= trim($omRequest->getParameter('nm',''));
		$this->ssSearchYearFrom = trim($omRequest->getParameter('db',''));
		$this->ssSearchYearTo 	= trim($omRequest->getParameter('dd',''));
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
		$this->oSearchIntermentList  = $oPager->getResults('Country', $this->snPaging,$oSearchInterment,$this->snPage);
		$this->amSearchIntermentList = $this->oSearchIntermentList->getResults(Doctrine::HYDRATE_ARRAY);
	
		// Total number of records
		$this->snPageTotalSearchInterment = $this->oSearchIntermentList->getNbResults();
		unset($oPager);
	
		if($request->getParameter('request_type') == 'ajax_request')
			$this->setTemplate('listIntermentsUpdate');
			
		$this->setLayout(false);
	}
    
    /**
	* Executes index action
	*
	* @param sfRequest $request A request object
	*/
	public function executeDisplayInfo(sfWebRequest $request)
	{
        //echo "displayInfo";exit;
        $this->amDisplayInfo = Doctrine::getTable('IntermentBooking')->getIntermentInfoAsPerId($request->getParameter('id'));
        
        
        $this->ssCemetery 	= $this->amDisplayInfo[0]['name'];
		    $this->ssArea		= ($this->amDisplayInfo[0]['area_name'] != '' && $this->amDisplayInfo[0]['area_name'] != '0') ? $this->amDisplayInfo[0]['area_name'] : __('N/A');
		    $this->ssSection	= ($this->amDisplayInfo[0]['section_name'] != '' && $this->amDisplayInfo[0]['section_name'] != '0') ? $this->amDisplayInfo[0]['section_name'] : __('N/A');
		    $this->ssRow		= ($this->amDisplayInfo[0]['row_name'] != '' && $this->amDisplayInfo[0]['row_name'] != '0') ? $this->amDisplayInfo[0]['row_name'] : __('N/A');
		    $this->ssPlot		= ($this->amDisplayInfo[0]['plot_name'] != '' && $this->amDisplayInfo[0]['plot_name'] != '0') ? $this->amDisplayInfo[0]['plot_name'] : __('N/A');
		    $this->ssGrave		= $this->amDisplayInfo[0]['grave_number'];
		    $this->smLat		= $this->amDisplayInfo[0]['latitude'];
		    $this->smLong		= $this->amDisplayInfo[0]['longitude'];
            
		    //$this->ssCemLat		= $this->amDisplayInfo[0]['CemCemetery']['latitude'];
		    //$this->ssCemLong	= $this->amDisplayInfo[0]['CemCemetery']['longitude'];
            $this->ssCemLat		= $this->amDisplayInfo[0]['cem_latitude'];
		    $this->ssCemLong	= $this->amDisplayInfo[0]['cem_longitude'];
            
        //echo "<pre>";print_R($amDisplayInfo);exit;
    }
}
