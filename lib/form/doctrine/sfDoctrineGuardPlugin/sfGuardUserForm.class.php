<?php
/**
 * sfGuardUser form.
 *
 * @package    arp
 * @subpackage form
 * @author     Nitin Barai
 * @author     Prakash Panchal
 *
 */
sfProjectConfiguration::getActive()->loadHelpers(array('jQuery', 'Url'));
class sfGuardUserForm extends BasesfGuardUserForm
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
				'title'       => new sfWidgetFormInputText(array(), array('maxlength' => 255, 'tabindex' => 1)),
				'last_name'        => new sfWidgetFormInputText(array(), array('maxlength' => 255, 'tabindex' => 2)),
		        'first_name'       => new sfWidgetFormInputText(array(), array('maxlength' => 255, 'tabindex' => 3)),
				'middle_name'       => new sfWidgetFormInputText(array(), array('maxlength' => 255, 'tabindex' => 4)),
		        'email_address'    => new sfWidgetFormInputText(array(), array('maxlength' => 255, 'tabindex' => 5)),
		        'username'         => ($this->isNew()) ? new sfWidgetFormInputText(array(), array('maxlength' => 128, 'tabindex' => 6)) : new sfWidgetFormInputHidden(array(), array('readonly' => true)),
		        
			)
		);

		if($this->isNew())
		{
    		$this->widgetSchema['password'] = new sfWidgetFormInputPassword(array(), array('tabindex' => 6));
    		$this->widgetSchema['password_again'] = new sfWidgetFormInputPassword(array(), array('tabindex' => 7));
			$this->widgetSchema->moveField('password_again', 'after', 'password');
    	}

		$amGroupList = Doctrine::getTable('SfGuardGroup')->getAllGroupsByUserRole();	
		$amGroupList = array('' => $asWidgets['group_id']) + $amGroupList;		
		
    	
		if(sfContext::getInstance()->getUser()->isSuperAdmin())
		{
			
			$this->widgetSchema['cem_country_id'] =  new sfWidgetFormChoice(
													array('choices' => array('' => $asWidgets['cem_country_id']) + $this->asCountryList),
													array('tabindex'=>8, 'onChange' => "callAjaxRequest(this.value,'".url_for('user/getCementryListAsPerCountry')."','user_cementery_list');")
												);
			
			if(!$this->isNew())
			{
				// For get Cemetery List
				$oUserCemetery = Doctrine::getTable('UserCemetery')->findByUserId($this->getObject()->getId());
				if(count($oUserCemetery) > 0)
					$oCemeteryCountry = Doctrine::getTable('CemCemetery')->find($oUserCemetery[0]->getCemCemeteryId());
	
				$snCountryId = ($oCemeteryCountry) ? $oCemeteryCountry->getCountryId() : '';
				
				$this->setDefault('cem_country_id',$snCountryId);
			}
			else
			{
				if($this->isNew())
					$this->setDefault('cem_country_id', $this->snDefaultCountryId);
			}
		}
		else
		{
			$snCemeteryId = sfContext::getInstance()->getUser()->getAttribute('cemeteryid');
			$oCemetery = Doctrine::getTable('CemCemetery')->find($snCemeteryId);
			$this->widgetSchema['cem_country_id'] = new sfWidgetFormInputHidden(array(), array('value' => $oCemetery->getCountryId(),'readonly' => 'true'));
			$this->widgetSchema['cem_cemetery_id'] = new sfWidgetFormInputHidden(array(), array('value' => $snCemeteryId,'readonly' => 'true'));
			
			$this->setDefault('cem_cemetery_id',$snCemeteryId);
			$this->setDefault('cem_country_id',$oCemetery->getCountryId());
		} 
		
		
		if(sfContext::getInstance()->getUser()->getAttribute('groupid') == 5 || sfContext::getInstance()->getUser()->getAttribute('groupid') == 6)
			$this->widgetSchema['group_id'] = new sfWidgetFormInputHidden(array(), array('readonly' => true));
		else	
			$this->widgetSchema['group_id'] = new sfWidgetFormChoice(array('choices' => $amGroupList), array('tabindex' => 10));
		

    	if($this->isNew()) {
			/*$this->widgetSchema['country_id'] = new sfWidgetFormChoice(
													array('choices' => array('' => $asWidgets['country_id']) + $this->asCountryList),
													array('tabindex'=> 11));*/
			
		}else {
			$amUserCemetery = Doctrine_Query::create()
					->select('P.*')
					->from('UserCemetery P')
					->where('P.user_id = ?', $this->getObject()->getId())
					->limit(1)
					->fetchArray();				
			
			if(isset($amUserCemetery[0]['group_id'])) {
				$this->setDefault('group_id',$amUserCemetery[0]['group_id']);					
			}
			

			if(isset($amUserCemetery[0]['cem_cemetery_id'])) {
				$this->setDefault('cem_cemetery_id',$amUserCemetery[0]['cem_cemetery_id']);
			}
			
			/*$amCountryList = Doctrine::getTable('Country')->getAllCountriesIdWise();	
			$amCountryList = array('' => $asWidgets['country_id']) + $amCountryList;		
			$this->widgetSchema['country_id'] = new sfWidgetFormChoice(array('choices' => $amCountryList));		*/
			
			if(isset($amUserCemetery[0])) {
				$this->setDefault('title',$amUserCemetery[0]['title']);
				$this->setDefault('middle_name',$amUserCemetery[0]['middle_name']);
				$this->setDefault('area_code',$amUserCemetery[0]['area_code']);
                $this->setDefault('user_code',$amUserCemetery[0]['user_code']);
				//$this->setDefault('country_id',$amUserCemetery[0]['country_id']);			
				$this->setDefault('organisation',$amUserCemetery[0]['organisation']);		
				$this->setDefault('code',$amUserCemetery[0]['code']);
				$this->setDefault('address',$amUserCemetery[0]['address']);			
				$this->setDefault('state',$amUserCemetery[0]['state']);			
				$this->setDefault('phone',$amUserCemetery[0]['phone']);			
				$this->setDefault('suburb',$amUserCemetery[0]['suburb']);			
				$this->setDefault('postal_code',$amUserCemetery[0]['postal_code']);	
				$this->setDefault('fax',$amUserCemetery[0]['fax']);	
				$this->setDefault('fax_area_code',$amUserCemetery[0]['fax_area_code']);	
			}
			
			$amCemStonemason = Doctrine_Query::create()
					->select('csm.*')
					->from('CemStonemason csm')
					->where('csm.user_id = ?', $this->getObject()->getId())
					->limit(1)
					->fetchArray();			
			if(isset($amCemStonemason[0])) {
				$this->setDefault('bond',$amCemStonemason[0]['bond']);
				$this->setDefault('annual_license_fee',$amCemStonemason[0]['annual_license_fee']);
				$this->setDefault('abn_acn_number',$amCemStonemason[0]['abn_acn_number']);
				$this->setDefault('contractors_license_number',$amCemStonemason[0]['contractors_license_number']);
				$this->setDefault('general_induction_cards',$amCemStonemason[0]['general_induction_cards']);
				$this->setDefault('operator_licenses',$amCemStonemason[0]['operator_licenses']);
				$this->setDefault('list_current_employees',$amCemStonemason[0]['list_current_employees']);			
				$this->setDefault('list_contractors',$amCemStonemason[0]['list_contractors']);		
				$this->setDefault('work_type_stone_mason_id',$amCemStonemason[0]['work_type_stone_mason_id']);
			}
		}

    	$this->widgetSchema['organisation'] = new sfWidgetFormInputText(array(), array('maxlength' => 255, 'tabindex' => 11));
    	$this->widgetSchema['code'] = new sfWidgetFormInputText(array(), array('maxlength' => 255, 'tabindex' => 11));
    	$this->widgetSchema['address'] = new sfWidgetFormInputText(array(), array('maxlength' => 255, 'tabindex' => 12));
		$this->widgetSchema['suburb'] = new sfWidgetFormInputText(array(), array('maxlength' => 255, 'tabindex' => 13));
    	$this->widgetSchema['state'] = new sfWidgetFormInputText(array(), array('maxlength' => 255, 'tabindex' => 14));
		$this->widgetSchema['postal_code'] = new sfWidgetFormInputText(array(), array('maxlength' => 255, 'tabindex' => 15));
		$this->widgetSchema['area_code'] = new sfWidgetFormInputText(array(), array('maxlength' => 255, 'tabindex' => 16));
        $this->widgetSchema['user_code'] = new sfWidgetFormInputText(array(), array('maxlength' => 100, 'tabindex' => 17));
    	$this->widgetSchema['phone'] = new sfWidgetFormInputText(array(), array('maxlength' => 255, 'tabindex' => 18));
		$this->widgetSchema['fax_area_code'] = new sfWidgetFormInputText(array(), array('maxlength' => 255, 'tabindex' => 19));
    	$this->widgetSchema['fax'] = new sfWidgetFormInputText(array(), array('maxlength' => 255, 'tabindex' => 20));
		

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

		if(sfContext::getInstance()->getUser()->getAttribute('groupid') == 5) {
			$this->widgetSchema['service_list'] = new sfWidgetFormSelectDoubleList(
										array('choices' => $this->amGroupArray, 'associated_first' => false, 'default' => array_keys($amAssociatedGroupArray)), 
										array('size' => 5, 'tabindex' => 17));
		}

		if(sfContext::getInstance()->getUser()->getAttribute('groupid') == 6) {
				/*$this->widgetSchema['work_type_stone_mason_id']	= new sfWidgetFormDoctrineChoice(
												array('model' => 'CemWorktypeStonemason', 'add_empty' => __('Work Type Stone Mason')),
												array('tabindex'=>20)
											);*/
			$this->widgetSchema['bond'] = new sfWidgetFormInputText(array(), array('maxlength' => 255, 'tabindex' => 21));
			$this->widgetSchema['annual_license_fee'] = new sfWidgetFormInputText(array(), array('maxlength' => 255, 'tabindex' => 22));
			$this->widgetSchema['abn_acn_number'] = new sfWidgetFormInputText(array(), array('maxlength' => 255, 'tabindex' => 22));			
			$this->widgetSchema['contractors_license_number'] = new sfWidgetFormInputText(array(), array('maxlength' => 255, 'tabindex' => 23));
			$this->widgetSchema['general_induction_cards'] = new sfWidgetFormInputText(array(), array('maxlength' => 255, 'tabindex' => 24));
			$this->widgetSchema['operator_licenses'] = new sfWidgetFormInputText(array(), array('maxlength' => 255, 'tabindex' => 25));
			$this->widgetSchema['list_current_employees'] = new sfWidgetFormInputText(array(), array('maxlength' => 255, 'tabindex' => 26));
			$this->widgetSchema['list_contractors'] = new sfWidgetFormInputText(array(), array('maxlength' => 255, 'tabindex' => 27));
			
		}




		$this->widgetSchema['is_active'] = new sfWidgetFormInputCheckbox(array(), array('tabindex' => 20));
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
		                                    array('required' => false, 'trim' => true ),
		                                    array('required' => $amValidators['email_address']['required'])
		                                ),
		        'username'         => new sfValidatorString(array('max_length' => 50, 'required' => true, 'trim' => true), array('required' => $amValidators['username']['required'])),
		      	'is_active'        => new sfValidatorBoolean(array('required' => false)),
                /*'country_id'		=> new sfValidatorDoctrineChoice(
										array('model'=>'Country','multiple'=>false,'required'=>false)
										),*/
										
                'group_id'	=> new sfValidatorDoctrineChoice(
										array('model'=>'SfGuardGroup','multiple'=>false,'required'=>true),
										array('required'=> $amValidators['group_id']['required'])),										
				
				'title'       => new sfValidatorString(array('max_length' => 255, 'required' => false, 'trim' => true)),
				'middle_name'       => new sfValidatorString(array('max_length' => 255, 'required' => false, 'trim' => true)),
				'organisation'       => new sfValidatorString(array('max_length' => 255, 'required' => true, 'trim' => true), array('required' => $amValidators['organisation']['required'])),
				'code'       => new sfValidatorString(array('max_length' => 255, 'required' => false, 'trim' => true)),
				'address'       => new sfValidatorString(array('max_length' => 255, 'required' => false, 'trim' => true)),
				'state'       => new sfValidatorString(array('max_length' => 255, 'required' => false, 'trim' => true)),
				'phone'       => new sfValidatorString(array('max_length' => 255, 'required' => false, 'trim' => true)),
				'suburb'       => new sfValidatorString(array('max_length' => 255, 'required' => false, 'trim' => true)),
				'postal_code'       => new sfValidatorString(array('max_length' => 255, 'required' => false, 'trim' => true)),
				'fax'       => new sfValidatorString(array('max_length' => 255, 'required' => false, 'trim' => true)),
				'area_code'       => new sfValidatorString(array('max_length' => 255, 'required' => false, 'trim' => true)),
                'user_code'       => new sfValidatorString(array('max_length' => 100, 'required' => false, 'trim' => true)),
				'fax_area_code'       => new sfValidatorString(array('max_length' => 255, 'required' => false, 'trim' => true)),
				
        	)
		);

		if(sfContext::getInstance()->getUser()->isSuperAdmin())
		{
			$this->validatorSchema['cem_country_id'] = new sfValidatorChoice(
														array('required' => true, 'choices' => array_keys($this->asCountryList)),
														array('required'=> $amValidators['cem_country_id']['required'])
														);
		}
		else
		{
			$this->validatorSchema['cem_country_id']	= new sfValidatorDoctrineChoice(
														array('model'=>'Country','multiple'=>false,'required'=>false));

			$this->validatorSchema['cem_cemetery_id']	= new sfValidatorString(
	                                            			array('required' => false, 'trim' => true));
		}   


		if(sfContext::getInstance()->getUser()->getAttribute('groupid') == 5) {
			$this->validatorSchema['service_list'] = new sfValidatorChoice(array('multiple' => true, 'choices' => array_keys($this->amGroupArray), 'required' => false));
		}

		if(sfContext::getInstance()->getUser()->getAttribute('groupid') == 6) {

			/*$this->validatorSchema['work_type_stone_mason_id']	= new sfValidatorDoctrineChoice(
													array('model'=>'CemWorktypeStonemason','multiple'=>false,'required'=>true),
													array('required'=> __('Please select work type stone mason')));*/
													
			$this->validatorSchema['bond'] = new sfValidatorString(array('required' => false, 'trim' => true));
			$this->validatorSchema['annual_license_fee'] = new sfValidatorString(array('required' => false, 'trim' => true));
			$this->validatorSchema['abn_acn_number'] = new sfValidatorString(array('required' => false, 'trim' => true));
			$this->validatorSchema['contractors_license_number'] = new sfValidatorString(array('required' => false, 'trim' => true));
			$this->validatorSchema['general_induction_cards'] = new sfValidatorString(array('required' => false, 'trim' => true));
			$this->validatorSchema['operator_licenses']	= new sfValidatorString(array('required' => false, 'trim' => true));
			$this->validatorSchema['list_current_employees'] = new sfValidatorString(array('required' => false, 'trim' => true));
			$this->validatorSchema['list_contractors'] = new sfValidatorString(array('required' => false, 'trim' => true));
		}
		
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
