<?php

/**
 * GranteeDetails form.
 *
 * @package    cemetery
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: GranteeDetailsForm.class.php,v 1.1.1.1 2012/03/24 11:56:28 nitin Exp $
 */
class GranteeDetailsForm extends BaseGranteeDetailsForm
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

		// Post Request Data.
		$this->amPostData = sfContext::getInstance()->getRequest()->getParameter('grantee');
		
		$this->ssInvalidDateMessage = '';
		$this->snGraveId = sfContext::getInstance()->getRequest()->getParameter('grave_id','');
		
		// Get cemetery List as per user role
		if(sfContext::getInstance()->getUser()->isSuperAdmin())
			$this->amCementeryList = Doctrine::getTable('CemCemetery')->getAllCemeteriesByUserRole();
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
        BaseGranteeDetailsForm::setWidgets(
            array(
					'title' 				=> new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 2)),
                    'grantee_surname'    	=> new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 3)),
                    'grantee_first_name'    => new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 4)),
                    'grantee_middle_name'   => new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 5)),
					'grantee_dob'			=> new sfWidgetFormDateJQueryUI(
														array("change_month"	=> true, 
															  "change_year" 	=> true,
															  "dateFormat"		=> "dd-mm-yy",
															  "showSecond" 		=> false, 
															  'show_button_panel' => true),
														array('tabindex'=>10,'readonly'=>false)),
                    'grantee_address' 		=> new sfWidgetFormTextarea(array(), array('tabindex'=> 11)),
					'town' 					=> new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 12)),
					'state' 				=> new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 13)),
					'postal_code' 			=> new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 14)),
					'grantee_email' 		=> new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 15)),
					'area_code' 			=> new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 16)),
					'phone' 				=> new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 17)),
					'contact_mobile' 		=> new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 18)),
					'fax_area_code' 		=> new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 19)),
					'fax' 					=> new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 20)),
                    'remarks_1'    			=> new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 21)),
                    'remarks_2'    			=> new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 22)),
            	));

		if(sfContext::getInstance()->getUser()->isSuperAdmin())
		{
			$this->widgetSchema['cem_id'] = new sfWidgetFormChoice(
												array('choices' => array('' => $asWidgets['cem_id']) + $this->amCementeryList),
												array('tabindex'=>1)
											);
		}
		else
		{
			$snCemeteryId = sfContext::getInstance()->getUser()->getAttribute('cemeteryid');			
			$this->widgetSchema['cem_id'] = new sfWidgetFormInputHidden(array(), array('value' => $snCemeteryId,'readonly' => 'true'));
			$this->setDefault('cem_id',$snCemeteryId);
		}
		
		if($this->snGraveId != '')
		{
			$this->widgetSchema['grantee_identity_id'] = new sfWidgetFormDoctrineChoice(array('model' => 'GranteeIdentity', 'add_empty' => $asWidgets['grantee_identity_id']),
														 array('tabindex'=>6));
			$this->widgetSchema['grantee_identity_number'] = new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 7));
			$this->widgetSchema['date_of_purchase'] = new sfWidgetFormDateJQueryUI(
														array("change_month"	=> true, 
															  "change_year" 	=> true,
															  "dateFormat"		=> "dd-mm-yy",
															  "showSecond" 		=> false, 
															  'show_button_panel' => false),
														array('tabindex'=> 8,'readonly'=>false));
			$this->widgetSchema['tenure_expiry_date'] = new sfWidgetFormDateJQueryUI(
															array("change_month"	=> true, 
																  "change_year" 	=> true,
																  "dateFormat"		=> "dd-mm-yy",
																  "showSecond" 		=> false, 
																  'show_button_panel' => false),
															array('tabindex'=>9,'readonly'=>false));
		}
		
		if($this->isNew()){
            $this->setDefault('date_of_purchase', sfConfig::get('app_default_date_formate'));
            $this->setDefault('tenure_expiry_date', sfConfig::get('app_default_date_formate'));
			$this->setDefault('grantee_dob', sfConfig::get('app_default_date_formate'));
		}else {
            if($this->getObject()->getGranteeDob() != '')
                $this->setDefault('grantee_dob', date('d-m-Y',strtotime($this->getObject()->getGranteeDob())));           
		}
        $this->widgetSchema->setNameFormat('grantee[%s]'); 
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
        BaseGranteeDetailsForm::setValidators(
	    	array(
				'cem_id'					=> new sfValidatorString(
                                            		array('required' => false, 'trim' => true)
                                        		),
				'title'       				=> new sfValidatorString(
                                            		array('required' => false, 'trim' => true)
                                        		),
				'grantee_first_name'       	=> new sfValidatorString(
                                            		array('required' => true, 'trim' => true),
													array('required'=> $amValidators['grantee_first_name']['required'])
                                        		),
				'grantee_middle_name'       => new sfValidatorString(
                                            		array('required' => false, 'trim' => true)
                                        		),
				'grantee_surname'       	=> new sfValidatorString(
                                            		array('required' => true, 'trim' => true),
													array('required'=> $amValidators['grantee_surname']['required'])
                                        		),
				'grantee_address'			=> new sfValidatorString(
                                            		array('required' => false, 'trim' => true)
                                        		),
				'grantee_email'       				=> new sfValidatorEmail(
                                            		array('required' => false, 'trim' => true),
													array('invalid' => $amValidators['grantee_email']['invalid'])
                                        		),
				'state'    					=> new sfValidatorString(
                                            		array('required' => false, 'trim' => true)
                                        		),
				'town'     					=> new sfValidatorString(
                                            		array('required' => false, 'trim' => true)
                                        		),
				'postal_code'     			=> new sfValidatorString(
                                            		array('required' => false, 'trim' => true)
                                        		),
				'phone'    					=> new sfValidatorString(
                                            		array('required' => false, 'trim' => true)
                                        		),
				'contact_mobile'    		=> new sfValidatorString(
                                            		array('required' => false, 'trim' => true)
                                        		),
				'fax'     					=> new sfValidatorString(
                                            		array('required' => false, 'trim' => true)
                                        		),
				'area_code'     			=> new sfValidatorString(
                                            		array('required' => false, 'trim' => true)
                                        		),
				'fax_area_code'     			=> new sfValidatorString(
                                            		array('required' => false, 'trim' => true)
                                        		),
				'fax_area_code'     		=> new sfValidatorString(
                                            		array('required' => false, 'trim' => true)
                                        		),
				'grantee_dob'       		=> new sfValidatorString(
                                            		array('required' => false, 'trim' => true)
                                        		),
				'remarks_1'       			=> new sfValidatorString(
                                            		array('required' => false, 'trim' => true)
                                        		),
				'remarks_2'       			=> new sfValidatorString(
                                            		array('required' => false, 'trim' => true)
                                        		)
			)
        );
		
		if(sfContext::getInstance()->getUser()->isSuperAdmin())
		{
			$this->validatorSchema['cem_id'] = new sfValidatorChoice(
														array('required' => true, 'choices' => array_keys($this->amCementeryList)),
														array('required'=> $amValidators['cem_id']['required'])
														);
		}
		if($this->snGraveId != '')
		{
			$this->ssInvalidDateMessage = $amValidators['tenure_expiry_date']['invalid'];
			$this->validatorSchema['grantee_identity_id'] = new sfValidatorString(
																array('required' => false, 'trim' => true)
															);
			$this->validatorSchema['grantee_identity_number'] = new sfValidatorString(
																	array('required' => false, 'trim' => true)
																);
			$this->validatorSchema['date_of_purchase'] = new sfValidatorString(
																array('required' => false, 'trim' => true)
															);
			$this->validatorSchema['tenure_expiry_date'] = new sfValidatorAnd(array(new sfValidatorDate(), new sfValidatorCallback(
															array('callback'=> array($this,'checkValidDate'),
																  'arguments' => array('ssTenureFrom' => $this->amPostData['date_of_purchase'],
																					   'ssTenureTo' => $this->amPostData['tenure_expiry_date']
																					   )),
															array('invalid'=> $amValidators['tenure_expiry_date']['invalid']))
															),															
															array('required' => false, 'trim' => true)
														);
		}
    }
	/**
     * Fuction checkValidDate to check date is greater than or equal to current date
     * @param $validator 	= Call Validator
     * @param $snCurrentDate 	= date
	 
	 * return  $snCurrentDate valid date
     */
	public function checkValidDate($validator, $ssTenureFrom, $asArguments) 
	{		
		if( date("Y-m-d", strtotime($asArguments['ssTenureTo'])) <= date("Y-m-d", strtotime($asArguments['ssTenureFrom'])) )
			throw new sfValidatorError($validator, $this->ssInvalidDateMessage);
		else
			return date("d-m-Y",strtotime($asArguments['ssTenureTo']));
	}
}
