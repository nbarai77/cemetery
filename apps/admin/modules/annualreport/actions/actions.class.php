<?php
/**
 * annualreport actions.
 *
 * @package    Cemetery
 * @subpackage annualreport
 * @author     Prakash Panchal
 * @author      
 *
 */
sfProjectConfiguration::getActive()->loadHelpers(array('I18N','Url'));
class annualreportActions extends sfActions
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

        $this->ssFormName = 'frm_list_annualreport';
        $omRequest        = sfContext::getInstance()->getRequest();

        // Set default values
        $this->amExtraParameters = array();
        $this->amExtraParameters['snPaging']        = $this->snPaging       = $omRequest->getParameter('paging', sfConfig::get('app_default_paging_records'));
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

		$this->oAnnualReportForm = new AnnualReportForm();
		$this->getConfigurationFields($this->oAnnualReportForm);
		
		$this->oAnnualReportList = $this->ssFromDate = $this->ssToDate = '';
		$this->snPageTotalAnnualReportRecords = 0;
		$this->amAnnualReportList = array();
		
		$amAnnualReportFormParameter = $oRequest->getParameter($this->oAnnualReportForm->getName());
		
		if($oRequest->isMethod('post'))
        {
			$this->ssFromDate = (isset($amAnnualReportFormParameter['from_date'])) ? $amAnnualReportFormParameter['from_date'] : $oRequest->getParameter('from_date');
			$this->ssToDate = (isset($amAnnualReportFormParameter['to_date'])) ? $amAnnualReportFormParameter['to_date'] : $oRequest->getParameter('to_date');
			$snDay = $snMonth = $snYear = '';

			if($this->ssFromDate != '')
				list($snDay,$snMonth,$snYear) = explode('-',trim($this->ssFromDate));
			$ssFromDate = $snYear.'-'.$snMonth.'-'.$snDay;

			if($this->ssToDate != '')
				list($snDay,$snMonth,$snYear) = explode('-',trim($this->ssToDate));
			$ssToDate = $snYear.'-'.$snMonth.'-'.$snDay;

			$this->oAnnualReportForm->bind($amAnnualReportFormParameter);
			
			if($this->ssFromDate != '' && $this->ssToDate != '')
			{
				// Set pager and get results
				$oPager = new sfMyPager();

				$oAnnualReportPageListQuery = Doctrine::getTable('ArGraveMaintenance')->getAnnulaReport($ssFromDate, $ssToDate);
				
				// Replace Doctrine Pager Count Query By Mannual Count Query.
				$ssCountQuery = Doctrine::getTable('ArGraveMaintenance')->getAnnulaReportCount($ssFromDate, $ssToDate);
		
				$this->oAnnualReportList  = $oPager->getResults('ArGraveMaintenance', $this->snPaging, $oAnnualReportPageListQuery,$this->snPage,$ssCountQuery);
				$this->amAnnualReportList = $this->oAnnualReportList->getResults(Doctrine::HYDRATE_ARRAY);
				
				$this->snPageTotalAnnualReportRecords = $this->oAnnualReportList->getNbResults();
				unset($oPager);
			}
		}
		
        if($oRequest->getParameter('request_type') == 'ajax_request')
            $this->setTemplate('listAnnualUpdate');
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
				'from_date'       => __('From Date'),
				'to_date'       => __('To Date'),
            )
        );

        $oForm->setValidators(array());
    }
}
