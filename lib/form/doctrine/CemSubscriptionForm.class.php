<?php

/**
 * CemSubscriptionForm form.
 *
 * @package    cemetery
 * @subpackage form
 * @author     Prakash Panchal
 */
class CemSubscriptionForm extends BaseCemCemeteryForm
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


		
		$this->validatorSchema->setOption('allow_extra_fields', true);
		$this->validatorSchema->setOption('filter_extra_fields', false);
  }
   /**
     * Function for set widgets for form elements.
     *
     * @access  public
     * @param   array   $asWidgets pass a widgets array.
     *
     */
    public function setWidgets(array $asWidgets){   				
        BaseCemCemeteryForm::setWidgets(
            array(
					'country_id'  => new sfWidgetFormChoice(
										array('choices' => array('' => $asWidgets['country_id']) + $this->asCountryList),
										array('tabindex'=> 1)),
                    'name' => new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 2)),
                    'description' => new sfWidgetFormTextarea(array(), array('tabindex'=> 3)),
                    
                    'url' => new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 4)),
                    'address' => new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 5)),
                    'suburb_town' => new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 6)),
                    'state' => new sfWidgetFormInputText(array(), array('tabindex'=> 7)),
                    'postcode' => new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 8)),
					'area_code' => new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 9)),
                    'phone' => new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 10)),
					'fax_area_code' => new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 11)),
                    'fax' => new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 12)),
                    'email' => new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 13)),
					'cemetery_map_path' => new sfWidgetFormInputFile(array(),array('tabindex'=> 14)),
                    'is_enabled'         => new MyWidgetFormInputCheckbox(array(), array('tabindex' => 15, 'value' => 1)),
            )
        );

		if($this->isNew())
			$this->setDefault('country_id', $this->snDefaultCountryId);

		$this->oSubscriptionForm = new SubscriptionForm();
		$this->embedForm('user_subscription',$this->oSubscriptionForm);
		
        $this->widgetSchema->setNameFormat('cemetery[%s]'); 
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
        BaseCemCemeteryForm::setValidators(
            array(
                'name'       => new sfValidatorAnd( 
    		        						array(
	                       						new sfValidatorCallback(
                       								array('callback' => array($this, 'checkCemeteryNameExist')),
                                        			array('invalid' => $amValidators['name']['invalid_unique'])
                           						),
                   							),
                   							array('required' => true, 'trim' => true),
                   							array('required' => $amValidators['name']['required'])
                 						),  														
														
                'description'         => new sfValidatorString(
                                            array('required' => false, 'trim' => true)
                                        ),
                'url'         => new sfValidatorString(
                                            array('required' => false, 'trim' => true)
                                        ),
                'address'         => new sfValidatorString(
                                            array('required' => false, 'trim' => true)
                                        ),
                'suburb_town'         => new sfValidatorString(
                                            array('required' => false, 'trim' => true)
                                        ),
                'state'         => new sfValidatorString(
                                            array('required' => false, 'trim' => true)
                                        ),
                'postcode'         => new sfValidatorString(
                                            array('required' => false, 'trim' => true)
                                        ),
                'phone'         => new sfValidatorString(
                                            array('required' => false, 'trim' => true)
                                        ),
                'fax'         => new sfValidatorString(
                                            array('required' => false, 'trim' => true)
                                        ),                
				'fax_area_code'         => new sfValidatorString(
                                            array('required' => false, 'trim' => true)
                                        ),
                'area_code'         => new sfValidatorString(
                                            array('required' => false, 'trim' => true)
                                        ),
                'email'         => new sfValidatorString(
                                            array('required' => false, 'trim' => true)
                                        ),                                                     
                                                                                                                        
                'is_enabled'         => new sfValidatorString(
                                            array('required' => false, 'trim' => true)
                                        ),
				'cemetery_map_path'    => new sfValidatorFile(
											array('required'=> false,'trim' => true)
											),
                'country_id'	=>  new sfValidatorChoice(
									array('required' => true, 'choices' => array_keys($this->asCountryList)),
									array('required'=> $amValidators['country_id']['required']))

            )
        );
		$this->validatorSchema['user_subscription'] = $this->oSubscriptionForm->getValidatorSchema();

    }
    
    /**
     * Function for check name is exists or not.
     *
     * @access  public
     * @param   object  $oValidator pass sfValidatorCallback.
     * @param   string  $ssValue pass fields value.
     * @return  string
     *  
     */
    public function checkCemeteryNameExist($oValidator, $ssValue)
    {
        $snIdGroup = '';
        if(!$this->isNew())
            $snIdGroup = $this->getObject()->getId();

        $oSfGuardGroup = new CemCemetery();
        $oResult    = $oSfGuardGroup->checkCemeteryNameExist($ssValue, $snIdGroup);
        unset($oSfGuardGroup);
      
        if(count($oResult) > 0)
            throw new sfValidatorError($oValidator, 'invalid');
        else
            return $ssValue;
    }  
	public function saveEmbeddedForms($con = null, $forms = null)
	{
		parent::saveEmbeddedForms($con, $forms);
	}
}
