<?php

/**
 * Workflow form.
 *
 * @package    cemetery
 * @subpackage form
 * @author     Prakash Panchal
 * @version    SVN: $Id: WorkflowForm.class.php,v 1.1.1.1 2012/03/24 11:56:36 nitin Exp $
 */
sfProjectConfiguration::getActive()->loadHelpers(array('jQuery', 'Url'));
class WorkflowForm extends BaseWorkflowForm
{
	/**
     * Function for ovrwrite parent class method.
     *
     * This function is access by admin user.
     * 
     * @access  public
     */
    public function setup()
    {
    }
	/**
     * Function for ovrwrite parent class method.
     *
     * This function is access by admin user.
     * 
     * @access  public
     */
	public function configure()
	{
		unset($this['id']);
		$this->asCountryList = array();
		$omCriteria = Doctrine::getTable('Country')->getCountryList(array(),array());
		$amCountry = $omCriteria->orderBy('sf.name')->fetchArray();
		$this->snDefaultCountryId = 0;
		if(count($amCountry) > 0)
		{
			foreach($amCountry as $asDataSet)
			{
				$this->asCountryList[$asDataSet['id']] = $asDataSet['name'];
				if($asDataSet['name'] == sfConfig::get('app_default_country'))
					$this->snDefaultCountryId = $asDataSet['id'];
			}
		}
	}
	/**
     * Function for set widgets for form elements.
     *
     * @access  public
     * @param   array   $asWidgets pass a widgets array.
     *
     */
    public function setWidgets(array $asWidgets)
    {	
        BaseWorkflowForm::setWidgets(
            array(
                    'work_date' 			=> new sfWidgetFormDateJQueryUI(
														array("change_month"	=> true, 
															  "change_year" 	=> true,
															  "dateFormat"		=> "dd-mm-yy",
															  "showSecond" 		=> false, 
															  'show_button_panel' => true),
														array('tabindex'=>1,'readonly'=>false)),
					'title' 				=> new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 2)),
					'name' 					=> new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 4)),					
                    'surname' 				=> new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 5)),
					'email' 				=> new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 3)),
					'area_code' 			=> new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 6)),
                    
                    'telephone'				=> new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 7)),
					'work_description' 		=> new sfWidgetFormTextarea(array(), array('tabindex'=> 16)),
                    'completion_date' 		=> new sfWidgetFormDateJQueryUI(
														array("change_month"	=> true, 
															  "change_year" 	=> true,
															  "dateFormat"		=> "dd-mm-yy",
															  "showSecond" 		=> false, 
															  'show_button_panel' => true),
														array('tabindex'=>19,'readonly'=>false)),
                    'action_taken'        	=> new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 18)),
					'feed_charges' 			=> new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 20)),
					'receipt_number' 		=> new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 21)),
            	));

		if(sfContext::getInstance()->getUser()->isSuperAdmin())
		{
			$this->widgetSchema['country_id'] = new sfWidgetFormChoice(
													array('choices' => array('' => $asWidgets['country_id']) + $this->asCountryList),
													array('tabindex'=> 8, 'onChange' => "callAjaxRequest(this.value,'".url_for('workorder/getCementryListAsPerCountry')."','workorder_cemetery_list');")
												);
			if($this->isNew())
				$this->setDefault('country_id', $this->snDefaultCountryId);
		}
		else
		{
			$snCemeteryId = sfContext::getInstance()->getUser()->getAttribute('cemeteryid');			
			$oCemetery = Doctrine::getTable('CemCemetery')->find($snCemeteryId);

			$this->widgetSchema['country_id'] = new sfWidgetFormInputHidden(array(), array('value' => $oCemetery->getCountryId(),'readonly' => 'true'));
			$this->widgetSchema['cem_cemetery_id'] = new sfWidgetFormInputHidden(array(), array('value' => $snCemeteryId,'readonly' => 'true'));			

			$this->setDefault('cem_cemetery_id',$snCemeteryId);			
			$this->setDefault('country_id',$oCemetery->getCountryId());
		}
		
        if($this->isNew())
        {
            $this->setDefault('work_date', sfConfig::get('app_default_date_formate'));
            $this->setDefault('completion_date', sfConfig::get('app_default_date_formate'));            
        }
		else
		{
			if($this->getObject()->getWorkDate() != '')
			{
				list($snYear,$snMonth,$snDay) = explode('-',$this->getObject()->getWorkDate());
				$ssWorkDate = $snDay.'-'.$snMonth.'-'.$snYear;
				$this->setDefault('work_date', $ssWorkDate);
			}
			if($this->getObject()->getCompletionDate() != '')
			{
				list($snYear,$snMonth,$snDay) = explode('-',$this->getObject()->getCompletionDate());
				$ssCompletionDate = $snDay.'-'.$snMonth.'-'.$snYear;
				$this->setDefault('completion_date', $ssCompletionDate);
			}
		}
        $this->widgetSchema->setNameFormat('workorder[%s]'); 
    }  
  
  
    /**
     * Function for set labels for form elements.
     *
     * @access  public
     * @param   array   $asLabels pass a labels array.
     *
     */
    public function setLabels($asLabels)
    {
        $this->widgetSchema->setLabels($asLabels);
    }
    /**
     * Function for set validators for form elements.
     *
     * @access  public
     * @param   array   $amValidators pass a validators array.
     *
     */
    public function setValidators(array $amValidators)
    {
        BaseWorkflowForm::setValidators(
	    	array(
				'work_date' 			=> new sfValidatorString( 
                       								array('required' => false, 'trim' => true)
												),
				'title' 				=> new sfValidatorString( 
                       								array('required' => false, 'trim' => true)
												),
				'name' 					=> new sfValidatorString( 
                       								array('required' => true, 'trim' => true),
													array('required'=> $amValidators['name']['required'])
												),
				'surname' 				=> new sfValidatorString( 
                       								array('required' => true, 'trim' => true),
													array('required'=> $amValidators['surname']['required'])
												),
				'email' 				=> new sfValidatorString( 
                       								array('required' => false, 'trim' => true)
												),
				'area_code' 			=> new sfValidatorString( 
                       								array('required' => false, 'trim' => true)
												),
				'telephone'				=> new sfValidatorString( 
                       								array('required' => false, 'trim' => true)
												),
				'work_description' 		=> new sfValidatorString( 
                       								array('required' => false, 'trim' => true)
												),
				'completion_date' 		=> new sfValidatorString( 
                       								array('required' => false, 'trim' => true)
												),
				'action_taken'        	=> new sfValidatorString( 
                       								array('required' => false, 'trim' => true)
												),
				'feed_charges' 			=> new sfValidatorString( 
                       								array('required' => false, 'trim' => true)
												),
				'receipt_number' 		=> new sfValidatorString(
                       								array('required' => false, 'trim' => true)
												)	
			)
        );
		
		if(sfContext::getInstance()->getUser()->isSuperAdmin())
		{
			$this->validatorSchema['country_id'] = new sfValidatorChoice(
                                            		array('required' => true, 'choices' => array_keys($this->asCountryList)),
													array('required'=> $amValidators['country_id']['required'])
                                        			);
		}
		else
		{
			$this->validatorSchema['country_id']	= new sfValidatorDoctrineChoice(
														array('model'=>'Country','multiple'=>false,'required'=>false));

			$this->validatorSchema['cem_cemetery_id'] =	new sfValidatorString(
        		                                   		array('required' => false, 'trim' => true));
		}
    }
	// over ride parent object named updateObject for set manual values 
	public function updateObject($values = null)
	{
		if(sfContext::getInstance()->getUser()->isSuperAdmin())
			$this->values['cem_cemetery_id'] = sfContext::getInstance()->getRequest()->getParameter('workorder_cem_cemetery_id');

		$this->values['ar_area_id']  		= (sfContext::getInstance()->getRequest()->getParameter('workorder_ar_area_id') != '') ? sfContext::getInstance()->getRequest()->getParameter('workorder_ar_area_id') : NULL;
		$this->values['ar_section_id']  	= (sfContext::getInstance()->getRequest()->getParameter('workorder_ar_section_id') != '') ? sfContext::getInstance()->getRequest()->getParameter('workorder_ar_section_id') : NULL;
		$this->values['ar_row_id']  		= (sfContext::getInstance()->getRequest()->getParameter('workorder_ar_row_id') != '') ? sfContext::getInstance()->getRequest()->getParameter('workorder_ar_row_id') : NULL;
		$this->values['ar_plot_id']  		= (sfContext::getInstance()->getRequest()->getParameter('workorder_ar_plot_id')) ? sfContext::getInstance()->getRequest()->getParameter('workorder_ar_plot_id') : NULL;
		$this->values['ar_grave_id']  		= (sfContext::getInstance()->getRequest()->getParameter('workorder_ar_grave_id') != '') ? sfContext::getInstance()->getRequest()->getParameter('workorder_ar_grave_id') : NULL;
		
        if(trim(sfContext::getInstance()->getRequest()->getParameter('workorder_department_delegation')) != '')
            $this->values['department_delegation']  = sfContext::getInstance()->getRequest()->getParameter('workorder_department_delegation');
		
		$this->values['completed_by']  			= (sfContext::getInstance()->getRequest()->getParameter('workorder_completed_by') != '') ? sfContext::getInstance()->getRequest()->getParameter('workorder_completed_by') : NULL;
		
		parent::updateObject($this->values);
	}
}
