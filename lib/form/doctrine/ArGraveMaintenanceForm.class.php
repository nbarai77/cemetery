<?php

/**
 * ArGraveMaintenance form.
 *
 * @package    cemetery
 * @subpackage form
 * @author     Prakash Panchal
 * @version    SVN: $Id: ArGraveMaintenanceForm.class.php,v 1.1.1.1 2012/03/24 11:56:39 nitin Exp $
 */
sfProjectConfiguration::getActive()->loadHelpers(array('jQuery', 'Url'));
class ArGraveMaintenanceForm extends BaseArGraveMaintenanceForm
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
		$this->amRenewalTerm = array('6 Months'=>'6 Months','1 Year'=>'1 Year','5 Years'=>'5 Years','10 Years'=>'10 Years','Perpetual'=>'Perpetual');
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
		$this->amPostData = sfContext::getInstance()->getRequest()->getParameter('gravemaintenance');
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
        BaseArGraveMaintenanceForm::setWidgets(
            array(
					'onsite_work_date' 	=> new sfWidgetFormDateJQueryUI(
														array("change_month"	=> true, 
															  "change_year" 	=> true,
															  "dateFormat"		=> "dd-mm-yy",
															  "showSecond" 		=> false, 
															  'show_button_panel' => true),
														array('tabindex'=>9,'readonly'=>false)),
                    'date_paid' 		=> new sfWidgetFormDateJQueryUI(
														array("change_month"	=> true, 
															  "change_year" 	=> true,
															  "dateFormat"		=> "dd-mm-yy",
															  "showSecond" 		=> false, 
															  'show_button_panel' => true),
														array('tabindex'=>10,'readonly'=>false)),                    
					'amount_paid' 		=> new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 11)),
					'receipt' 			=> new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 12)),
                    'renewal_term' 		=> new sfWidgetFormChoice(array('choices' => array('' => $asWidgets['renewal_term']) + $this->amRenewalTerm),array('tabindex'=>13)),
                    'renewal_date' 		=> new sfWidgetFormDateJQueryUI(
														array("change_month"	=> true, 
															  "change_year" 	=> true,
															  "dateFormat"		=> "dd-mm-yy",
															  "showSecond" 		=> false, 
															  'show_button_panel' => true),
														array('tabindex'=>14,'readonly'=>false)),
                    'interred_name' 	=> new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 8)),
                    'interred_surname' 	=> new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 15)),
                    'title' 			=> new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 16)),
                    'organization_name' => new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 17)),
                    'first_name'        => new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 18)),
					'surname' 			=> new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 19)),
					'address' 			=> new sfWidgetFormTextarea(array(), array('tabindex'=> 20)),
					'subrub' 			=> new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 21)),
					'state' 			=> new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 22)),
					'postal_code' 		=> new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 23)),
					'user_country' 		=> new sfWidgetFormChoice(
													array('choices' => array('' => $asWidgets['country_id']) + $this->asCountryList),
													array('tabindex'=>24)
												),
					'email' 			=> new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 25)),
					'area_code' 		=> new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 26)),
					'number' 			=> new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 27)),
					'notes' 			=> new sfWidgetFormTextarea(array(), array('tabindex'=> 28)),
            	));

		if(sfContext::getInstance()->getUser()->isSuperAdmin())
		{
			$this->widgetSchema['country_id'] = new sfWidgetFormChoice(
													array('choices' => array('' => $asWidgets['country_id']) + $this->asCountryList),
													array('tabindex'=>1, 'onChange' => "callAjaxRequest(this.value,'".url_for('gravemaintenance/getCementryListAsPerCountry')."','gravemaintenance_cemetery_list');")
												);
			if($this->isNew())
				$this->setDefault('country_id', $this->snDefaultCountryId);
			/*
			else
			{			
				if($this->getObject()->getUserCountry() == '')
					$this->setDefault('user_country', $this->snDefaultCountryId);
			}*/
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
            $this->setDefault('onsite_work_date', sfConfig::get('app_default_date_formate'));
            $this->setDefault('date_paid', sfConfig::get('app_default_date_formate'));
            $this->setDefault('renewal_date', sfConfig::get('app_default_date_formate'));            
        }
        
		$ssOnsiteWorkDate 	= (!$this->isNew()) ? $this->getObject()->getOnsiteWorkDate() : $this->amPostData['onsite_work_date'];
		$ssDatePaid 		= (!$this->isNew()) ? $this->getObject()->getDatePaid() : $this->amPostData['date_paid'];
		$ssRenewalDate 		= (!$this->isNew()) ? $this->getObject()->getRenewalDate() : $this->amPostData['renewal_date'];
		
		if($ssOnsiteWorkDate != '')
		{
			list($snYear,$snMonth,$snDay) = explode('-',$ssOnsiteWorkDate);
			$ssOnsiteWorkDate = $snDay.'-'.$snMonth.'-'.$snYear;
			$this->setDefault('onsite_work_date', $ssOnsiteWorkDate);
		}
		if($ssDatePaid != '')
		{
			list($snYear,$snMonth,$snDay) = explode('-',$ssDatePaid);
			$ssDatePaid = $snDay.'-'.$snMonth.'-'.$snYear;
			$this->setDefault('date_paid', $ssDatePaid);
		}
		if($ssRenewalDate != '')
		{
			list($snYear,$snMonth,$snDay) = explode('-',$ssRenewalDate);
			$ssRenewalDate = $snDay.'-'.$snMonth.'-'.$snYear;
			$this->setDefault('renewal_date', $ssRenewalDate);
		}                
        $this->widgetSchema->setNameFormat('gravemaintenance[%s]'); 
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
        BaseArGraveMaintenanceForm::setValidators(
	    	array(
				'onsite_work_date' 	=> new sfValidatorString( 
                       								array('required' => false, 'trim' => true)
												),
				'date_paid' 		=> new sfValidatorString( 
                       								array('required' => false, 'trim' => true)
												),
				'amount_paid' 		=> new sfValidatorString( 
                       								array('required' => false, 'trim' => true)
												),
				'receipt' 			=> new sfValidatorString( 
                       								array('required' => false, 'trim' => true)
												),
				'renewal_term' 		=> new sfValidatorChoice(
                                            		array('required' => true, 'choices' => array_keys($this->amRenewalTerm)),
													array('required'=> $amValidators['renewal_term']['required'])
                                        			),
				'renewal_date' 		=> new sfValidatorString( 
                       								array('required' => false, 'trim' => true)
												),
				'interred_name' 	=> new sfValidatorString( 
                       								array('required' => false, 'trim' => true),
													array('required' => $amValidators['interred_name']['required'])
												),
				'interred_surname' 	=> new sfValidatorString( 
                       								array('required' => false, 'trim' => true),
													array('required' => $amValidators['interred_surname']['required'])
												),
				'title' 			=> new sfValidatorString( 
                       								array('required' => false, 'trim' => true)
												),
				'organization_name' => new sfValidatorString( 
                       								array('required' => false, 'trim' => true)
												),
				'first_name'        => new sfValidatorString( 
                       								array('required' => false, 'trim' => true)
												),
				'surname' 			=> new sfValidatorString( 
                       								array('required' => false, 'trim' => true)
												),
				'address' 			=> new sfValidatorString( 
                       								array('required' => false, 'trim' => true)
												),
				'subrub' 			=> new sfValidatorString( 
                       								array('required' => false, 'trim' => true)
												),
				'state' 			=> new sfValidatorString( 
                       								array('required' => false, 'trim' => true)
												),
				'postal_code' 		=> new sfValidatorString( 
                       								array('required' => false, 'trim' => true)
												),
				'user_country' 		=> new sfValidatorString( 
                       								array('required' => false, 'trim' => true)
												),
				'email' 			=> new sfValidatorEmail(
                                            		array('required' => false, 'trim' => true),
													array('invalid' => $amValidators['email']['invalid'])
                                        		),
				'area_code' 		=> new sfValidatorString( 
                       								array('required' => false, 'trim' => true)
												),
				'number' 			=> new sfValidatorString( 
                       								array('required' => false, 'trim' => true)
												),
				'notes' 			=> new sfValidatorString( 
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
			$this->values['cem_cemetery_id'] = sfContext::getInstance()->getRequest()->getParameter('gravemaintenance_cem_cemetery_id');

		$this->values['ar_area_id']  		= (sfContext::getInstance()->getRequest()->getParameter('gravemaintenance_ar_area_id') != '') ? sfContext::getInstance()->getRequest()->getParameter('gravemaintenance_ar_area_id') : NULL;
		$this->values['ar_section_id']  	= (sfContext::getInstance()->getRequest()->getParameter('gravemaintenance_ar_section_id') != '') ? sfContext::getInstance()->getRequest()->getParameter('gravemaintenance_ar_section_id') : NULL;
		$this->values['ar_row_id']  		= (sfContext::getInstance()->getRequest()->getParameter('gravemaintenance_ar_row_id') != '') ? sfContext::getInstance()->getRequest()->getParameter('gravemaintenance_ar_row_id') : NULL;
		$this->values['ar_plot_id']  		= (sfContext::getInstance()->getRequest()->getParameter('gravemaintenance_ar_plot_id')) ? sfContext::getInstance()->getRequest()->getParameter('gravemaintenance_ar_plot_id') : NULL;
		$this->values['ar_grave_id']  		= (sfContext::getInstance()->getRequest()->getParameter('gravemaintenance_ar_grave_id') != '') ? sfContext::getInstance()->getRequest()->getParameter('gravemaintenance_ar_grave_id') : NULL;
		
		parent::updateObject($this->values);
	}
}
