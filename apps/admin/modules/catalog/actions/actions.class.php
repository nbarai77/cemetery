<?php

/**
 * catalog actions.
 *
 * @package    cemetery
 * @subpackage catalog
 * @author     Arpita Rana
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
sfProjectConfiguration::getActive()->loadHelpers(array('I18N'));
class catalogActions extends sfActions
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
        $this->ssFormName = 'frm_list_award';
        $omRequest        = sfContext::getInstance()->getRequest();

        // Set default values
        $this->amExtraParameters = array();
        $this->amExtraParameters['snPaging']        = $this->snPaging       = $omRequest->getParameter('paging',sfConfig::get('app_default_paging_records'));
        $this->amExtraParameters['snPage']          = $this->snPage         = $omRequest->getParameter('page', sfConfig::get('app_default_page', 1));
        $this->amExtraParameters['ssSearchName']   	= $this->ssSearchName  	= trim($omRequest->getParameter('searchName',''));
        $this->amExtraParameters['ssSortBy']        = $this->ssSortBy       = $omRequest->getParameter('sortby','id');
        $this->amExtraParameters['ssSortMode']      = $this->ssSortMode     = $omRequest->getParameter('sortmode','desc');

        $this->ssSortQuerystr = $this->ssQuerystr = 'page='.$this->snPage.'&paging='.$this->snPaging;

        if($this->getRequestParameter('searchName') != '' )        // Search parameters
        {
            $this->ssQuerystr    .= '&searchName='.$omRequest->getParameter('searchName');
            $this->ssSortQuerystr.= '&searchName='.$omRequest->getParameter('searchName');
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
								'name' => array(
												'caption'	=> __('Name'),
												'id'		=> 'Name',
												'type'		=> 'text',																								
											)
							);

        $omCommon = new common();

        if($request->getParameter('admin_act') == "delete" && $request->getParameter('id'))            
        {
            $omCommon->DeleteRecordsComposite('Catalog', $request->getParameter('id'),'id');
            $this->getUser()->setFlash('snSuccessMsgKey', 3);      
        }

        // Get cms page list for listing.
        $oAwardPageListQuery = Doctrine::getTable('Catalog')->getCatalogList($this->amExtraParameters, $this->amSearch);

        // Set pager and get results
        $oPager               = new sfMyPager();
        $this->oCatalogList  = $oPager->getResults('Catalog', $this->snPaging,$oAwardPageListQuery,$this->snPage);
        $this->amCatalogList = $this->oCatalogList->getResults(Doctrine::HYDRATE_ARRAY);
        
        unset($oPager);

        // Total number of records
        $this->snPageTotaloAwardPages = $this->oCatalogList->getNbResults();

        if($request->getParameter('request_type') == 'ajax_request')
            $this->setTemplate('listCatalogUpdate');
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
		$snIdAward = $oRequest->getParameter('id', '');
        $ssSuccessKey   = 4; // Success message key for add        
		
		$this->asCementery = array();
        if($snIdAward)
        {
            $this->forward404Unless($oAward = Doctrine::getTable('Catalog')->find($snIdAward));
            $this->oCatalogForm = new CatalogForm($oAward);
			
            $ssSuccessKey = 2; // Success message key for edit			
        }
        else
            $this->oCatalogForm = new CatalogForm();                     
                
        $this->getConfigurationFields($this->oCatalogForm);
		$amAwardRequestParameter = $oRequest->getParameter($this->oCatalogForm->getName());
        
        if($oRequest->isMethod('post'))
        {            
            $this->oCatalogForm->bind($amAwardRequestParameter);
            //$this->oAwardPayRateForm->bind($amAwardPayRateRequestParameter);
			
            if($this->oCatalogForm->isValid())
            {
				// Save Records                
				$snIdAward = $this->oCatalogForm->save();
                $this->getUser()->setFlash('snSuccessMsgKey', $ssSuccessKey);   //Set messages for add and update records
				$this->redirect('catalog/index?'.$this->amExtraParameters['ssQuerystr']);
            }
			/*else
			{
				if(!$bSelectCemetery)
					$this->getUser()->setFlash('ssErrorCemeter',__('Please select cemetery'));
			}*/
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
				 )
		);

        $oForm->setLabels(
            array(				
                'name'             => __('Name'),
                'description'      => __('Description'),
                'cost_price'      => __('Cost price'),
                'special_cost_price' => __('Special Cost price'),
            )
        );

        $oForm->setValidators(
            array(
	                'name'              => array(
														'required'  => __('Please enter name')
													),
				)
        );
    }
}