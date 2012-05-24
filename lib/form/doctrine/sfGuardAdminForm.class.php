<?php
/**
 * sfGuardAdmin form.
 *
 * @package    arp
 * @subpackage form
 * @author     Jaimin Shelat
 * @author     Raghuvir Dodiya
 * @author     Bipin Patel  
 *
 */
class sfGuardAdminForm extends BasesfGuardUserForm
{
	/**
	 * Function for ovrwrite parent class method.
     *
     * @access  public
     * 
     */
    public function setup()
    {
    }
    
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
		$amGroup = Doctrine::getTable('sfGuardGroup')->findAll();

		$amAssociatedGroup = array();
		if(!$this->isNew())
		{
			$amAssociatedGroup = Doctrine::getTable('sfGuardUserGroup')->getGroupByUserId($this->getObject()->getId());
		}
		
		$amAssociatedGroupArray = array();
		foreach($amAssociatedGroup as $amValue)
			$amAssociatedGroupArray[$amValue['id']] = $amValue['name'];

		$this->amGroupArray = array();
		foreach($amGroup as $amValue)
			$this->amGroupArray[$amValue['id']] = $amValue['name'];


        BasesfGuardUserForm::setWidgets(
        	array(		        
				//'id'               => new sfWidgetFormInputHidden(),
		        'first_name'       => new sfWidgetFormInputText(array(), array('maxlength' => 255, 'tabindex' => 1)),
		        'last_name'        => new sfWidgetFormInputText(array(), array('maxlength' => 255, 'tabindex' => 1)),
		        'email_address'    => new sfWidgetFormInputText(array(), array('maxlength' => 255, 'tabindex' => 1)),
		        'username'         => ($this->isNew()) ? new sfWidgetFormInputText(array(), array('maxlength' => 128, 'tabindex' => 1)) : new sfWidgetFormInputHidden(array(), array('readonly' => true)),
				
			)
		);

		if($this->isNew())
		{
    		$this->widgetSchema['password'] = new sfWidgetFormInputPassword(array(), array('tabindex' => 1));
    		$this->widgetSchema['password_again'] = new sfWidgetFormInputPassword(array(), array('tabindex' => 1));
			$this->widgetSchema->moveField('password_again', 'after', 'password');
    	}


		$this->widgetSchema['is_active'] = new sfWidgetFormInputCheckbox(array(), array('tabindex' => 1));
        $this->widgetSchema->setNameFormat('sf_guard_user[%s]');
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
		BasesfGuardUserForm::setValidators(
			array(
		        'id'               => new sfValidatorString(array('required' => false, 'trim' => true)),
		        'first_name'       => new sfValidatorString(array('max_length' => 255, 'required' => true, 'trim' => true), array('required' => $amValidators['first_name']['required'])),
		        'last_name'        => new sfValidatorString(array('max_length' => 255, 'required' => true, 'trim' => true), array('required' => $amValidators['last_name']['required'])),
		        'email_address'	=> new sfValidatorAnd(
		                                    array(
		                                        new sfValidatorEmail(
		                                            array(),
		                                            array('invalid' => $amValidators['email_address']['invalid'])
		                                        ),
		                                    ),
		                                    array('required' => true, 'trim' => true ),
		                                    array('required' => $amValidators['email_address']['required'])
		                                ),
		        'username'         => new sfValidatorString(array('max_length' => 50, 'required' => true, 'trim' => true), array('required' => $amValidators['username']['required'])),
		      	'is_active'        => new sfValidatorBoolean(array('required' => false)),
  									
				
        	)
		);

		if($this->isNew())
		{
			//Get post all data
        	$amPostData = sfContext::getInstance()->getRequest()->getParameter('sf_guard_user');
			$this->validatorSchema['password'] = new sfValidatorString(array('min_length' => 3, 'max_length' => 25, 'required' => true), 
                                                                                       array('required' => $amValidators['password']['required'], 'min_length' => $amValidators['password']['min_length'],
                                                                                       'max_length' => $amValidators['password']['max_length']));
			$this->validatorSchema['password_again'] = new sfValidatorAnd
                                                                (
                                                                    array (
                                                                                new sfValidatorCallback
                                                                                    (
                                                                                       array('callback'=> array($this,'comparePassword'),'arguments'=> $amPostData['password']),
											                                           array('invalid'=>$amValidators['password_again']['invalid'])
											                                         )
                                                                             ),
                                                                    array('required' => true, 'trim' => true , 'halt_on_error'=>true),
                                                                    array('required'=>$amValidators['password_again']['required'])
                                                                  );
		}

		//$this->validatorSchema['groups_list'] = new sfValidatorChoice(array('multiple' => true, 'choices' => array_keys($this->amGroupArray), 'required' => true));

        $this->validatorSchema->setPostValidator(
                            new sfValidatorAnd(
                            array(
                                new sfValidatorDoctrineUnique(array('model' => 'sfGuardUser', 'column' => 'email_address', 'primary_key' => 'id'), array('invalid' => 'Email already registered')),
                                new sfValidatorDoctrineUnique(array('model' => 'sfGuardUser', 'column' => 'username', 'primary_key' => 'id'), array('invalid' => 'Username already registered')),
                            ))
        );

        $this->validatorSchema->setOption('allow_extra_fields', true);
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

  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['groups_list']))
    {
      $this->setDefault('groups_list', $this->object->Groups->getPrimaryKeys());
    }
  }

  protected function doSave($con = null)
  {
    $this->saveGroupsList($con);
    $this->savePermissionsList($con);
    $this->saveUserCemetery($con);

    parent::doSave($con);
  }
  

  public function saveUserCemetery($con = null) {
	  
  }

  public function saveGroupsList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['groups_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->Groups->getPrimaryKeys();
    $values = $this->getValue('groups_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('Groups', array_values($unlink));
    }

    $link = array_diff($values, $existing);

    if (count($link))
    {
      $this->object->link('Groups', array_values($link));
    }
  }
  
  public function savePermissionsList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['permissions_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->Permissions->getPrimaryKeys();
    $values = $this->getValue('permissions_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('Permissions', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('Permissions', array_values($link));
    }
  }  
  
  
}
