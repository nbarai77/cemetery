<?php

/**
 * IntermentSearch form.
 *
 * @package    cemetery
 * @subpackage IntermentSearch
 * @author     Prakash Panchal
 * @version    SVN: $Id: IntermentSearchForm.class.php,v 1.1.1.1 2012/03/24 11:56:25 nitin Exp $
 */
sfProjectConfiguration::getActive()->loadHelpers(array('jQuery', 'Url'));
class IntermentSearchForm extends BaseIntermentBookingForm
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
		if(!sfContext::getInstance()->getUser()->isSuperAdmin())
			$this->amCementeryList = Doctrine::getTable('CemCemetery')->getAllCemeteriesByUserRole();	
		
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
        BaseIntermentBookingForm::setWidgets(
            array(
                    'interment_first_name'		=> new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 8)),
                    'interment_surname'    		=> new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 9)),
                    'interment_middle_name'   	=> new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 10)),
                    'control_number'    		=> new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 11)),
                    
					'interment_dob'				=> new sfWidgetFormDateJQueryUI(
														array("change_month"	=> true, 
															  "change_year" 	=> true,
															  "dateFormat"		=> "dd-mm-yy",
															  "showSecond"		=> false,
															  "buttonImageOnly" => false,
															  "show_button_panel" => true),
														array('tabindex'=>14,'readonly'=>false)),
					'interment_date'    		=> new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 15)),	
					'interment_birth_place'    	=> new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 13)),
					'deceased_age'    			=> new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 16)),
					'is_private'        		=> new MyWidgetFormInputCheckbox(array(), array('tabindex' => 17, 'value' => 1)),
					
            	));
            	
		$this->widgetSchema['interment_birth_country_id'] =  new sfWidgetFormChoice(
																array('choices' => array('' => $asWidgets['country_id']) + $this->asCountryList),
																array('tabindex'=>12)
															);           	
            	
		if(sfContext::getInstance()->getUser()->isSuperAdmin())
		{
			$this->widgetSchema['country_id'] =  new sfWidgetFormChoice(
													array('choices' => array('' => $asWidgets['country_id']) + $this->asCountryList),
													array('tabindex'=>1, 'onChange' => "callAjaxRequest(this.value,'".url_for('intermentsearch/getCementryListAsPerCountry')."','interment_cemetery_list');")
												);
			if($this->isNew())
				$this->setDefault('country_id', $this->snDefaultCountryId);
		}
		else
		{
			$snCemeteryId = sfContext::getInstance()->getUser()->getAttribute('cemeteryid');			
			$oCemetery = Doctrine::getTable('CemCemetery')->find($snCemeteryId);
			$this->widgetSchema['country_id'] = new sfWidgetFormInputHidden(array(), array('value' => $oCemetery->getCountryId(),'readonly' => 'true'));

			$this->setDefault('country_id',$oCemetery->getCountryId());
			$this->widgetSchema['cem_cemetery_id'] = new sfWidgetFormInputHidden(array(), array('value' => $snCemeteryId,'readonly' => 'true'));			
			
			if(sfContext::getInstance()->getUser()->getAttribute('cm') != '') {
				$this->setDefault('cem_cemetery_id',$snCemeteryId);	
			}
			
		}            	
            	
        $this->widgetSchema->setNameFormat('interment[%s]'); 
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
        BaseIntermentBookingForm::setValidators(
	    	array(
                'country_id'				=> new sfValidatorChoice(
												array('required' => false, 'choices' => array_keys($this->asCountryList))
												),
				'interment_first_name'       	=> new sfValidatorString(
                                            		array('required' => false, 'trim' => true)
                                        		),
				'interment_middle_name'       => new sfValidatorString(
                                            		array('required' => false, 'trim' => true)
                                        		),
				'interment_surname'       	=> new sfValidatorString(
                                            		array('required' => false, 'trim' => true)
                                        		),
				'interment_dob'       		=> new sfValidatorString(
                                            		array('required' => false, 'trim' => true)
                                        		),
                'interment_birth_country_id'				=> new sfValidatorDoctrineChoice(
													array('model'=>'Country','multiple'=>false,'required'=>false)
												),
				'control_number'       	=> new sfValidatorString(
                                            		array('required' => false, 'trim' => true)
                                        		),
				'interment_birth_place'       	=> new sfValidatorString(
                                            		array('required' => false, 'trim' => true)
                                        		),                                        		                                        														
				'deceased_age'       	=> new sfValidatorString(
                                            		array('required' => false, 'trim' => true)
                                        		), 
				'is_private'       		=> new sfValidatorString(
                                            		array('required' => false, 'trim' => true)
                                        		),                                        		
												                     		

			)
        );		
    }
}
