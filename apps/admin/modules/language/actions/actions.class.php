<?php
/**
 * Language actions.
 *
 * @package    Cemetery
 * @subpackage Language
 * @author     Nitin Barai
 * @author      
 *
 */
sfProjectConfiguration::getActive()->loadHelpers(array('I18N'));
class languageActions extends sfActions
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
        $this->ssFormName = 'frm_list_language';
        $omRequest        = sfContext::getInstance()->getRequest();

        // Set default values
        $this->amExtraParameters = array();
        $this->amExtraParameters['snPaging']        = $this->snPaging       = $omRequest->getParameter('paging',sfConfig::get('app_default_paging_records'));
        $this->amExtraParameters['snPage']          = $this->snPage         = $omRequest->getParameter('page', sfConfig::get('app_default_page', 1));
        $this->amExtraParameters['ssSearchLanguageName']   	= $this->ssSearchName  	= trim($omRequest->getParameter('searchLanguageName',''));
        $this->amExtraParameters['ssSearchIsEnabled']   	= $this->ssSearchIsEnabled  	= trim($omRequest->getParameter('searchIsEnabled',''));        
        $this->amExtraParameters['ssSortBy']        = $this->ssSortBy       = $omRequest->getParameter('sortby','id');
        $this->amExtraParameters['ssSortMode']      = $this->ssSortMode     = $omRequest->getParameter('sortmode','desc');

        $this->ssSortQuerystr = $this->ssQuerystr = 'page='.$this->snPage.'&paging='.$this->snPaging;

        if($this->getRequestParameter('searchLanguageName') != '' )        // Search parameters
        {
            $this->ssQuerystr    .= '&searchLanguageName='.$this->getRequestParameter('searchLanguageName');
            $this->ssSortQuerystr.= '&searchLanguageName='.$this->getRequestParameter('searchLanguageName');
        }

        if($this->getRequestParameter('searchIsEnabled') != '' )        // Search parameters
        {
            $this->ssQuerystr    .= '&searchIsEnabled='.$this->getRequestParameter('searchIsEnabled');
            $this->ssSortQuerystr.= '&searchIsEnabled='.$this->getRequestParameter('searchIsEnabled');
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
								'language_name' => array(
												'caption'	=> __('Language Name'),
												'id'		=> 'LanguageName',
												'type'		=> 'text',																								
											),
								'is_enabled' => array(
												'caption' 	=> __('Enabled'),
												'id'		=> 'IsEnabled',														
												'type' 		=> 'select',
												'options'	=> array(
												                    '' => __('All'),
																	'1' => __('Active'),
																	'0' => __('InActive'),																			
																)															
											),										
							);

        $omCommon = new common();

        if($request->getParameter('admin_act') == "delete" && $request->getParameter('id'))            
        {
			//delete i18n files
            $arr_ids = $request->getParameter('id');
            $i18nDirectory = sfConfig::get('sf_app_i18n_dir');
            for($i=0;$i<count($arr_ids);$i++) {
				$oLang = Doctrine::getTable('Language')->find($arr_ids[$i]);
				$new_file = $i18nDirectory.'/messages.'.$oLang['culture'].'.xml';
				if(file_exists($new_file)) {
					unlink($new_file);
				}
			}
			//delete record from language table
			$omCommon->DeleteRecordsComposite('Language', $request->getParameter('id'),'id');
            $this->getUser()->setFlash('snSuccessMsgKey', 3);      
        }

        // Get cms page list for listing.
        $oGuardGroupPageListQuery = Doctrine::getTable('Language')->getLanguageList($this->amExtraParameters, $this->amSearch);

        // Set pager and get results
        $oPager               = new sfMyPager();
        $this->oGuardGroupList  = $oPager->getResults('Language', $this->snPaging,$oGuardGroupPageListQuery,$this->snPage);
        $this->amGuardGroupList = $this->oGuardGroupList->getResults(Doctrine::HYDRATE_ARRAY);

        unset($oPager);

        // Total number of records
        $this->snPageTotalGuardGroupPages = $this->oGuardGroupList->getNbResults();

        if($request->getParameter('request_type') == 'ajax_request')
            $this->setTemplate('listLanguageUpdate');
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
        
        // Add edit part
        $edit_form = false;

        if($snIdGuardGroup)
        {
			$edit_form = true;
            $this->forward404Unless($oGroup = Doctrine::getTable('Language')->find($snIdGuardGroup));
            $this->oLanguageForm = new LanguageForm($oGroup);
            $ssSuccessKey = 2; // Success message key for edit
        }
        else {
            $this->oLanguageForm = new LanguageForm();
		}

        $this->getConfigurationFields($this->oLanguageForm);

        if($oRequest->isMethod('post'))
        {
			$arr_par = $oRequest->getParameter($this->oLanguageForm->getName());

            $this->oLanguageForm->bind($oRequest->getParameter($this->oLanguageForm->getName()));

            if($this->oLanguageForm->isValid())
            {
                $snIdGroup = $this->oLanguageForm->save()->getId();

				 if(!$edit_form) {					 
					$i18nDirectory = sfConfig::get('sf_app_i18n_dir');
					$new_file = $i18nDirectory.'/messages.'.$arr_par['culture'].'.xml';
					$org_file = $i18nDirectory.'/messages.en.xml';

					$data = file_get_contents($org_file);
					
					chmod($i18nDirectory,777); 
					$handle = fopen($new_file, "w");
					fwrite($handle, $data);
					fclose($handle);					
				 }

                $this->getUser()->setFlash('snSuccessMsgKey', $ssSuccessKey);   //Set messages for add and update records

                if($oRequest->getParameter('tab'))
                    $this->redirect('language/addedit?id='.$snIdGroup.'&tab='.$oRequest->getParameter('tab').'&'.$this->amExtraParameters['ssQuerystr']);
                else
                	$this->redirect('language/index?'.$this->amExtraParameters['ssQuerystr']);
            }
        }
    }


  /**
    * changelanguage action
    *
    * changelanguage    
    * @access public
    * @param  object $oRequest A request object
    *     
    */
    public function executeChangelanguage(sfWebRequest $oRequest){
		// Culture setter		
		$this->getUser()->setCulture($oRequest->getParameter('culture', ''));
		//$this->getUser()->setCulture('en_US');
		return '1';
		//return $this->redirect('' != $signinUrl ? $signinUrl : '@homepage');
		//echo $oRequest->getUri();exit;
		//$oRequest->getReferer()
		//$this->redirect($oRequest->getUri());
		// Culture getter		
		//$culture = $this->getUser()->getCulture();
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
                'language_name'              => __('Language Name'),
                'culture'              => __('Culture'),
                'is_enabled'       => __('Enabled'),
                'default'       => __('Default')
                
            )
        );

        $oForm->setValidators(array());
    }
}
