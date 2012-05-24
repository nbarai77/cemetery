<?php

/**
 * CemStonemason form.
 *
 * @package    cemetery
 * @subpackage form
 * @author     Prakash Panchal
 * @version    SVN: $Id: CemStonemasonForm.class.php,v 1.1.1.1 2012/03/24 11:56:43 nitin Exp $
 */
sfProjectConfiguration::getActive()->loadHelpers(array('jQuery', 'Url')); 
class CemStonemasonForm extends BaseCemStonemasonForm
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
        BaseCemStonemasonForm::setWidgets(
            array(
				'work_type_stone_mason_id' 	=> new sfWidgetFormDoctrineChoice(
												array('model' => 'CemWorktypeStonemason', 'add_empty' => $asWidgets['work_type_stone_mason_id']),
												array('tabindex'=>2)
											),
				'company_name' 			=> new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 3)),
				'address' 				=> new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 4)),
				'town' 					=> new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 5)),
				'state' 				=> new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 6)),
				'zip_code' 				=> new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 7)),
				'area_code' 			=> new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 8)),
				'telephone' 			=> new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 9)),
				'fax_area_code' 		=> new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 10)),
				'fax_number' 			=> new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 11)),				
				'email' 				=> new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 12)),
				'accredited_to' 		=> new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 13)),
				'contact_name' 			=> new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 14)),
				'company_telephone' 	=> new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 15)),
				'contact_area_number' 	=> new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 16)),
				'comment' 				=> new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 17)),
				'is_enabled'         => new MyWidgetFormInputCheckbox(array(), array('tabindex' => 18, 'value' => 1)),
           	));


		if(sfContext::getInstance()->getUser()->isSuperAdmin())
		{
			$this->widgetSchema['country_id'] =  new sfWidgetFormChoice(
													array('choices' => array('' => $asWidgets['country_id']) + $this->asCountryList),
													array('tabindex'=>1, 'onChange' => "callAjaxRequest(this.value,'".url_for('stonemason/getCementryListAsPerCountry')."','stonemason_cementery_list');")
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

        $this->widgetSchema->setNameFormat('stonemason[%s]'); 
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
        BaseCemStonemasonForm::setValidators(
	    	array(
				
				'work_type_stone_mason_id'	=> new sfValidatorDoctrineChoice(
													array('model'=>'CemWorktypeStonemason','multiple'=>false,'required'=>true),
													array('required'=> $amValidators['work_type_stone_mason_id']['required'])
												),
                'company_name'				=> new sfValidatorString( 
                       								array('required' => true, 'trim' => true),
                       								array('required' => $amValidators['company_name']['required'])
												),
				'address'       			=> new sfValidatorString(
                                            		array('required' => false, 'trim' => true)
                                        		),
				'town'       				=> new sfValidatorString(
                                            		array('required' => false, 'trim' => true)
                                        		),
				'state'     			 	=> new sfValidatorString(
                                            		array('required' => false, 'trim' => true)
                                        		),
				'zip_code'       			=> new sfValidatorString(
                                            		array('required' => false, 'trim' => true)
                                        		),
				'telephone'       			=> new sfValidatorString(
                                            		array('required' => false, 'trim' => true)
                                        		),
				'fax_number'       			=> new sfValidatorString(
                                            		array('required' => false, 'trim' => true)
                                        		),
				'fax_area_code'       		=> new sfValidatorString(
                                            		array('required' => false, 'trim' => true)
                                        		),
				'area_code'       		=> new sfValidatorString(
                                            		array('required' => false, 'trim' => true)
                                        		),
				'email'       				=> new sfValidatorEmail(
                                            		array('required' => false, 'trim' => true),
													array('invalid' => $amValidators['email']['invalid'])
                                        		),
				'contact_name'       		=> new sfValidatorString(
                                            		array('required' => false, 'trim' => true)
                                        		),
				'company_telephone'       	=> new sfValidatorString(
                                            		array('required' => false, 'trim' => true)
                                        		),
				'contact_area_number'       => new sfValidatorString(
                                            		array('required' => false, 'trim' => true)
                                        		),
				'comment'       			=> new sfValidatorString(
                                            		array('required' => false, 'trim' => true)
                                        		),
				'accredited_to'       		=> new sfValidatorString(
                                            		array('required' => false, 'trim' => true)
                                        		),
				'is_enabled'       			=> new sfValidatorString(
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
			$this->validatorSchema['country_id']		= new sfValidatorDoctrineChoice(
															array('model'=>'Country','multiple'=>false,'required'=>false));
														
			$this->validatorSchema['cem_cemetery_id']	= new sfValidatorString(
	                                            			array('required' => false, 'trim' => true));
		}        
        
    }
	// over ride parent object named updateObject for set manual values 
	public function updateObject($values = null)
	{
		if(sfContext::getInstance()->getUser()->isSuperAdmin())
			$this->values['cem_cemetery_id'] =sfContext::getInstance()->getRequest()->getParameter('stonemason_cem_cemetery_id');

		

		parent::updateObject($this->values);
	}    
    
}
