<?php

/**
 * FndFndirector form.
 *
 * @package    cemetery
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: FndFndirectorForm.class.php,v 1.1.1.1 2012/03/24 11:56:34 nitin Exp $
 */
sfProjectConfiguration::getActive()->loadHelpers(array('jQuery', 'Url')); 
class FndFndirectorForm extends BaseFndFndirectorForm
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
		if(count($amCountry) > 0)
		{
			foreach($amCountry as $asDataSet)
				$this->asCountryList[$asDataSet['id']] = $asDataSet['name'];
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
		$amGroup = Doctrine::getTable('FndService')->findAll();

		$amAssociatedGroup = array();
		if(!$this->isNew())
		{
			$amAssociatedGroup = Doctrine::getTable('FndServiceFndirector')->getGroupByFuneralId($this->getObject()->getId());
		}
		
		$amAssociatedGroupArray = array();
		foreach($amAssociatedGroup as $amValue)
			$amAssociatedGroupArray[$amValue['id']] = $amValue['name'];

		$this->amGroupArray = array();
		foreach($amGroup as $amValue)
			$this->amGroupArray[$amValue['id']] = $amValue['name'];		
		
		
		
        BaseFndFndirectorForm::setWidgets(
            array(
					'title' 				=> new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 2)),
					'last_name' 			=> new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 3)),
					'first_name' 			=> new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 4)),
					
					'middle_name' 			=> new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 5)),
                    'company_name' 			=> new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 6)),
					'code' 					=> new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 7)),
					'address' 				=> new sfWidgetFormTextarea(array(), array('tabindex'=> 8)),
					
					'town' 					=> new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 9)),
					'state' 				=> new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 10)),
					'postal_code' 			=> new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 11)),
					'area_code' 			=> new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 12)),
                    'phone' 				=> new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 13)),
					'fax_area_code' 			=> new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 14)),
                    'fax_number' 			=> new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 15)),										
					'email' 				=> new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 16)),					
					'groups_list' 			=> new sfWidgetFormSelectDoubleList(
													array('choices' => $this->amGroupArray, 'associated_first' => false, 'default' => array_keys($amAssociatedGroupArray)), 
													array('size' => 5, 'tabindex' => 17)
												),
                    'is_enabled'        	=> new MyWidgetFormInputCheckbox(array(), array('tabindex' => 18, 'value' => 1)),
            )
        );
        
        
		if(sfContext::getInstance()->getUser()->isSuperAdmin())
		{
			$this->widgetSchema['country_id'] = new sfWidgetFormChoice(
													array('choices' => array('' => $asWidgets['country_id']) + $this->asCountryList),
													array('tabindex'=>1, 'onChange' => "callAjaxRequest(this.value,'".url_for('fndirector/getCementryListAsPerCountry')."','fndirector_cementery_list');")
												);
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
 	        
        $this->widgetSchema->setNameFormat('fnd_fndirector[%s]'); 
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
        BaseFndFndirectorForm::setValidators(
            array(
				'groups_list' 	=> new sfValidatorChoice(array('multiple' => true, 'choices' => array_keys($this->amGroupArray), 'required' => false)), 
				'title'         => new sfValidatorString(
                                            array('required' => false, 'trim' => true)
                                        ),
                'first_name'       => new sfValidatorString(array('max_length' => 255, 'required' => true, 'trim' => true),
															array('required' => $amValidators['first_name']['required'])	
														),
				'last_name'       => new sfValidatorString(array('max_length' => 255, 'required' => true, 'trim' => true),
															array('required' => $amValidators['last_name']['required'])	
														),
				 'middle_name'         => new sfValidatorString(
                                            array('required' => false, 'trim' => true)
                                        ),
                'code'         => new sfValidatorString(
                                            array('required' => false, 'trim' => true)
                                        ),
                'company_name'         => new sfValidatorString(
                                            array('required' => true, 'trim' => true),
											array('required' => $amValidators['company_name']['required'])
                                        ),
                'address'         => new sfValidatorString(
                                            array('required' => false, 'trim' => true)
                                        ),
				'town'   		=> new sfValidatorString(
                                            array('required' => false, 'trim' => true)
                                        ),
                'state'         => new sfValidatorString(
                                            array('required' => false, 'trim' => true)
                                        ),
                'postal_code'         => new sfValidatorString(
                                            array('required' => false, 'trim' => true)
                                        ),
                'phone'         => new sfValidatorString(
                                            array('required' => false, 'trim' => true)
                                        ),         
                'area_code'   => new sfValidatorString(
                                            array('required' => false, 'trim' => true)
                                        ), 
                'fax_area_code'   => new sfValidatorString(
                                            array('required' => false, 'trim' => true)
                                        ), 
                'fax_number'         => new sfValidatorString(
                                            array('required' => false, 'trim' => true)
                                        ),                           
                'email'         => new sfValidatorString(
                                            array('required' => false, 'trim' => true)
                                        ),                           
                'is_enabled'         => new sfValidatorString(
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

			$this->validatorSchema['cem_cemetery_id'] = new sfValidatorString(
															array('required' => false, 'trim' => true)
														);
		}   
    } 
    
	// over ride parent object named updateObject for set manual values 
	public function updateObject($values = null)
	{
		if(sfContext::getInstance()->getUser()->isSuperAdmin())
			$this->values['cem_cemetery_id'] =sfContext::getInstance()->getRequest()->getParameter('fndirector_cem_cemetery_id');

		parent::updateObject($this->values);
	}        
}
