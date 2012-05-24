<?php
/**
 * tasknotes actions.
 *
 * @package    Cemetery
 * @subpackage tasknotes
 * @author     Prakash Panchal
 * @author      
 *
 */
sfProjectConfiguration::getActive()->loadHelpers(array('I18N'));
class tasknotesActions extends sfActions
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
        $this->ssFormName = 'frm_list_tasknotes';
        $omRequest        = sfContext::getInstance()->getRequest();

        // Set default values
        $this->amExtraParameters = array();
        $this->amExtraParameters['snPaging']        = $this->snPaging       = $omRequest->getParameter('paging',sfConfig::get('app_default_paging_records'));
        $this->amExtraParameters['snPage']          = $this->snPage         = $omRequest->getParameter('page', sfConfig::get('app_default_page', 1));
        $this->amExtraParameters['ssSearchTaskTitle']   	= $this->ssSearchName  	= trim($omRequest->getParameter('searchTaskTitle',''));
        $this->amExtraParameters['ssSearchEntryDate']   	= $this->ssSearchName  	= trim($omRequest->getParameter('searchEntryDate',''));
        $this->amExtraParameters['ssSearchDueDate']   	= $this->ssSearchName  	= trim($omRequest->getParameter('searchDueDate',''));
        $this->amExtraParameters['ssSortBy']        = $this->ssSortBy       = $omRequest->getParameter('sortby','due_date');
        $this->amExtraParameters['ssSortMode']      = $this->ssSortMode     = $omRequest->getParameter('sortmode','asc');

        $this->ssSortQuerystr = $this->ssQuerystr = 'page='.$this->snPage.'&paging='.$this->snPaging;

        if($this->getRequestParameter('searchTaskTitle') != '' )        // Search parameters
        {
            $this->ssQuerystr    .= '&searchTaskTitle='.$this->getRequestParameter('searchTaskTitle');
            $this->ssSortQuerystr.= '&searchTaskTitle='.$this->getRequestParameter('searchTaskTitle');
        }

        if($this->getRequestParameter('searchEntryDate') != '' )        // Search parameters
        {
            $this->ssQuerystr    .= '&searchEntryDate='.$this->getRequestParameter('searchEntryDate');
            $this->ssSortQuerystr.= '&searchEntryDate='.$this->getRequestParameter('searchEntryDate');
        }
		if($this->getRequestParameter('searchDueDate') != '' )        // Search parameters
        {
            $this->ssQuerystr    .= '&searchDueDate='.$this->getRequestParameter('searchDueDate');
            $this->ssSortQuerystr.= '&searchDueDate='.$this->getRequestParameter('searchDueDate');
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
								'task_title' => array(
												'caption'	=> __('Task Title'),
												'id'		=> 'TaskTitle',
												'type'		=> 'text',																								
											),
								'entry_date' => array(
												'caption'	=> __('Entry Date'),
												'id'		=> 'EntryDate',
												'type'		=> 'date',
											),
								'due_date' => array(
												'caption'	=> __('Due Date'),
												'id'		=> 'DueDate',
												'type'		=> 'date',
											)
							);

        $omCommon = new common();

        if($request->getParameter('admin_act') == "delete" && $request->getParameter('id'))            
        {
            $omCommon->DeleteRecordsComposite('CemTaskNotes', $request->getParameter('id'),'id');
            $this->getUser()->setFlash('snSuccessMsgKey', 3);      
        }

        // Get cms page list for listing.
        $oUserTaskNotesPageListQuery = Doctrine::getTable('CemTaskNotes')->getUserTaskNotes($this->amExtraParameters, $this->amSearch);

        // Set pager and get results
        $oPager               = new sfMyPager();
        $this->oUserTaskNotesList  = $oPager->getResults('CemTaskNotes', $this->snPaging,$oUserTaskNotesPageListQuery,$this->snPage);
        $this->amUserTaskNotesList = $this->oUserTaskNotesList->getResults(Doctrine::HYDRATE_ARRAY);

        unset($oPager);

        // Total number of records
        $this->snPageTotalUserTaskNotesPages = $this->oUserTaskNotesList->getNbResults();

        if($request->getParameter('request_type') == 'ajax_request')
            $this->setTemplate('listUserTaskNotesUpdate');
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
        $snIdTaskNotes = $oRequest->getParameter('id', '');
        $ssSuccessKey   = 4; // Success message key for add
		
        if($snIdTaskNotes)
        {
            $this->forward404Unless($oCemTaskNotes = Doctrine::getTable('CemTaskNotes')->find($snIdTaskNotes));
            $this->oCemTaskNotesForm = new CemTaskNotesForm($oCemTaskNotes);
            $ssSuccessKey = 2; // Success message key for edit
        }
        else
            $this->oCemTaskNotesForm = new CemTaskNotesForm();

        $this->getConfigurationFields($this->oCemTaskNotesForm);

		//$this->amPostData = $oRequest->getParameter($this->oCemTaskNotesForm->getName());
		$amUserTaskNotesFormRequest = $oRequest->getParameter($this->oCemTaskNotesForm->getName());

        if($oRequest->isMethod('post'))
        {
			if($amUserTaskNotesFormRequest['entry_date'] != '') 
			{
				list($snDay,$snMonth,$snYear) = explode('-', trim($amUserTaskNotesFormRequest['entry_date']));
				$amUserTaskNotesFormRequest['entry_date'] = $snYear.'-'.$snMonth.'-'.$snDay;
			}
			if($amUserTaskNotesFormRequest['due_date'] != '') 
			{
				list($snDay,$snMonth,$snYear) = explode('-',trim($amUserTaskNotesFormRequest['due_date']));
				$amUserTaskNotesFormRequest['due_date'] = $snYear.'-'.$snMonth.'-'.$snDay;
			}
			
            $this->oCemTaskNotesForm->bind($amUserTaskNotesFormRequest);

            if($this->oCemTaskNotesForm->isValid())
            {
//				echo "<pre>";print_r($amUserTaskNotesFormRequest);exit;
                $snIdTaskNotes = $this->oCemTaskNotesForm->save()->getId();

                $this->getUser()->setFlash('snSuccessMsgKey', $ssSuccessKey);   //Set messages for add and update records
				$this->redirect('tasknotes/index?'.$this->amExtraParameters['ssQuerystr']);
            }
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
        $oForm->setWidgets(array());

        $oForm->setLabels(
            array(
                'task_title'  	 	=> __('Task Title'),
                'task_description'		=> __('Task Description'),
                'entry_date'  			=> __('Entry Date'),
                'due_date'  			=> __('Due Date')
            )
        );

        $oForm->setValidators(
            array(
	                'task_title'		=> array(
												'required'  => __('Please enter task title')
											),
	                'task_description'	=> array(
												'required'  => __('Please enter task description')
											),
					'due_date'			=> array(
											'invalid'  => __('Due date must be grater than entry date')
											)
				)
        );
    }
}
