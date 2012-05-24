<?php
/**
 * SubscriptionForm form.
 *
 * @package    cemetery
 * @subpackage form
 * @author     Prakash Panchal
 *
 */
sfProjectConfiguration::getActive()->loadHelpers(array('I18N','jQuery', 'Url'));
class SubscriptionForm extends BasesfGuardUserForm
{
	/**
	 * Function for ovrwrite parent class method.
     *
     * @access  public
     * 
     */
	 /*
    public function setup()
    {
    }
    */
    /**
     * Function for set form configuration.
     *
     * This function is access by admin user.
     * 
     * @access  public
     * 
     */        
    public function configure()
    {
        unset($this['id'], $this['created_at'], $this['updated_at'],$this['is_super_admin'], $this['last_login']);
        // Disable the secret key
        $this->disableLocalCSRFProtection();
		
		$this->setWidgets(array(
		  		'title'				=> new sfWidgetFormInputText(array(), array('maxlength' => 255, 'tabindex' => 16)),
				'last_name'			=> new sfWidgetFormInputText(array(), array('maxlength' => 255, 'tabindex' => 17)),
		        'first_name'		=> new sfWidgetFormInputText(array(), array('maxlength' => 255, 'tabindex' => 18)),
				'middle_name'		=> new sfWidgetFormInputText(array(), array('maxlength' => 255, 'tabindex' => 19)),
		        'email_address'		=> new sfWidgetFormInputText(array(), array('maxlength' => 255, 'tabindex' => 20)),
		        'username'			=> ($this->isNew()) ? new sfWidgetFormInputText(array(), array('maxlength' => 128, 'tabindex' => 21)) : new sfWidgetFormInputHidden(array(), array('readonly' => true)),
		));
		
		if($this->isNew())
		{
    		$this->widgetSchema['password'] = new sfWidgetFormInputPassword(array(), array('tabindex' => 22));
    		$this->widgetSchema['password_again'] = new sfWidgetFormInputPassword(array(), array('tabindex' => 23));
			$this->widgetSchema->moveField('password_again', 'after', 'password');
    	}

    	$this->widgetSchema['organisation'] = new sfWidgetFormInputText(array(), array('maxlength' => 255, 'tabindex' => 24));
    	$this->widgetSchema['code'] = new sfWidgetFormInputText(array(), array('maxlength' => 255, 'tabindex' => 25));
    	$this->widgetSchema['address'] = new sfWidgetFormInputText(array(), array('maxlength' => 255, 'tabindex' => 26));
		$this->widgetSchema['suburb'] = new sfWidgetFormInputText(array(), array('maxlength' => 255, 'tabindex' => 27));
    	$this->widgetSchema['state'] = new sfWidgetFormInputText(array(), array('maxlength' => 255, 'tabindex' => 28));
		$this->widgetSchema['postal_code'] = new sfWidgetFormInputText(array(), array('maxlength' => 255, 'tabindex' => 29));
		$this->widgetSchema['area_code'] = new sfWidgetFormInputText(array(), array('maxlength' => 255, 'tabindex' => 30));
    	$this->widgetSchema['phone'] = new sfWidgetFormInputText(array(), array('maxlength' => 255, 'tabindex' => 31));
		$this->widgetSchema['fax_area_code'] = new sfWidgetFormInputText(array(), array('maxlength' => 255, 'tabindex' => 32));
    	$this->widgetSchema['fax'] = new sfWidgetFormInputText(array(), array('maxlength' => 255, 'tabindex' => 33));
		
		// set labels
		$this->widgetSchema->setLabels(array(
			'first_name'      	=> __('First name'),
			'last_name'       	=> __('Surname'),
			'email_address'		=> __('Email'),
			'username'			=> __('Username'),
			'is_active'			=> __('Is active'),
			'is_super_admin'	=> __('Is super admin'),
			'password'			=> __('Password'),
			'password_again'	=> __('Password again'),
			'organisation'		=> __('Organisation'),
			'address'			=> __('Address'),
			'state'				=> __('State'),
			'phone'				=> __('Telephone'),
			'area_code'			=> __('Telephone Area Code'),
			'postal_code' 		=> __('Postal Code'),
			'fax_area_code'		=> __('Fax Area Code'),
			'phone'				=> __('Telephone'),
			'suburb'			=> __('Suburb/Town'),
			'contact_phone'		=> __('Contact Phone'),
			'cem_country_id' 	=> __('Select Country')
		));
		
		$this->setValidators(array(
	     		'id'				=> new sfValidatorString(array('required' => false, 'trim' => true)),
		        'first_name'		=> new sfValidatorString(array('max_length' => 255, 'required' => true, 'trim' => true), array('required' =>  __('First name required'))),
		        'last_name'			=> new sfValidatorString(array('max_length' => 255, 'required' => true, 'trim' => true), array('required' => __('Surname required'))),
		        'email_address'		=> new sfValidatorAnd(
		                                    array(
		                                        new sfValidatorEmail(
		                                            array(),
		                                            array('invalid' => __('Invalid email address'))
		                                        ),
		                                    ),
		                                    array('required' => true, 'trim' => true ),
		                                    array('required' => __('Email address required'))
		                                ),
		        'username'         	=> new sfValidatorString(array('max_length' => 50, 'required' => true, 'trim' => true), array('required' => __('Username required'))),
				'title'				=> new sfValidatorString(array('max_length' => 255, 'required' => false, 'trim' => true)),
				'middle_name'		=> new sfValidatorString(array('max_length' => 255, 'required' => false, 'trim' => true)),
				'organisation'		=> new sfValidatorString(array('max_length' => 255, 'required' => true, 'trim' => true), array('required' => __('Organisation required'))),
				'code'				=> new sfValidatorString(array('max_length' => 255, 'required' => false, 'trim' => true)),
				'address'			=> new sfValidatorString(array('max_length' => 255, 'required' => false, 'trim' => true)),
				'state'				=> new sfValidatorString(array('max_length' => 255, 'required' => false, 'trim' => true)),
				'phone'				=> new sfValidatorString(array('max_length' => 255, 'required' => false, 'trim' => true)),
				'suburb'			=> new sfValidatorString(array('max_length' => 255, 'required' => false, 'trim' => true)),
				'postal_code'       => new sfValidatorString(array('max_length' => 255, 'required' => false, 'trim' => true)),
				'fax'				=> new sfValidatorString(array('max_length' => 255, 'required' => false, 'trim' => true)),
				'area_code'			=> new sfValidatorString(array('max_length' => 255, 'required' => false, 'trim' => true)),
				'fax_area_code'		=> new sfValidatorString(array('max_length' => 255, 'required' => false, 'trim' => true)),
	    ));
		
		if($this->isNew())
		{
			//Get post all data
        	$amPostData = sfContext::getInstance()->getRequest()->getParameter('cemetery');
			$this->validatorSchema['password'] = new sfValidatorString(array('min_length' => 3, 'max_length' => 25, 'required' => true), 
																	   array('required' => __('Password required'), 'min_length' => __('Enter atleast 3 characters'),
																	   'max_length' => __('Enter atmost 25 characters')));
			$this->validatorSchema['password_again'] = new sfValidatorAnd(array (new sfValidatorCallback(
																			   array('callback'=> array($this,'comparePassword'),'arguments'=> $amPostData['user_subscription']['password']),
																			   array('invalid'=> __('Password and password again must be same.'))
										                                         )
                                                                            ),
                                                                    array('required' => true, 'trim' => true , 'halt_on_error'=>true),
                                                                    array('required'=> __('Password again required'))
                                                                  );
		}
        $this->validatorSchema->setPostValidator(new sfValidatorAnd(array(new sfValidatorDoctrineUnique(
																			array('model' => 'sfGuardUser', 'column' => 'email_address', 'primary_key' => 'id'), 
																			array('invalid' => __('Email already registered') )),
												                          new sfValidatorDoctrineUnique(array('model' => 'sfGuardUser', 'column' => 'username', 'primary_key' => 'id'), 
																		  	array('invalid' => __('Username already registered') )),
					    					                        ))
										        );
    }    

   /**
    * comparePassword
    *
    * Function for compare both password values
    *
    * @access  logged in user
    * @param 	object $validator pass sfValidatorCallback
    * @param 	string $values values of current password
    * @param 	array  $arguments array of values
    * @return 	string or error 
    */
    public function comparePassword($validator,$values,$arguments)
	{
		if($values == $arguments)
			return $values;
		else
	         throw new sfValidatorError($validator, 'invalid'); 
	}
}
