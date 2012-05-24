<?php

/**
 * sfGuardGroup form.
 *
 * @package    arp
 * @subpackage form
 * @author     Bipin Patel
 *
 */
class sfGuardGroupForm extends BasesfGuardGroupForm
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
     * Function for set widgets for form elements.
     *
     * @access  public
     * @param   array   $asWidgets pass a widgets array.
     *
     */
    public function setWidgets(array $asWidgets)
    {
		$amPermission = Doctrine::getTable('sfGuardPermission')->findAll();

		$amAssociated = array();
		if(!$this->isNew()){
    			$amAssociated = Doctrine::getTable('sfGuardGroupPermission')->getPermissionsByGroupId($this->getObject()->getId());
		}
		
		$amAssociatedArray = array();
		foreach($amAssociated as $amValue)
			$amAssociatedArray[$amValue['id']] = $amValue['name'];

		$this->amPermissionArray = array();
		foreach($amPermission as $amValue)
			$this->amPermissionArray[$amValue['id']] = $amValue['name'];
			
        BasesfGuardGroupForm::setWidgets(
            array(
                    'name'              => new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 1)),
                    'description'       => new sfWidgetFormTextArea(array(), array('tabindex'=> 1)),
                    'permissions_list'  => new sfWidgetFormSelectDoubleList(array('choices' => $this->amPermissionArray, 'associated_first' => false, 'default' => array_keys($amAssociatedArray)), array('size' => 5)),
            )
        );

        $this->widgetSchema->setNameFormat('sf_guard_group[%s]'); 
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
        BasesfGuardGroupForm::setValidators(
            array(
                'name'              => new sfValidatorAnd( 
                                            array(
                                                new sfValidatorCallback(
                                                    array('callback' => array($this, 'checkGroupNameExist')),
                                                    array('invalid' => $amValidators['name']['invalid_unique'])
                                                ),
                                            ),
                                            array('required' => true, 'trim' => true),
                                            array('required' => $amValidators['name']['required'])
                                        ),                                                    
                'description'         => new sfValidatorString(
                                            array('required' => true, 'trim' => true),
                                            array('required' => $amValidators['description']['required'])
                                        ),
				'permissions_list' 	  => new sfValidatorChoice(
											array('multiple' => true, 'choices' => array_keys($this->amPermissionArray), 'required' => false),
											array('required' => $amValidators['permissions_list']['required'], 'invalid' => __('Please select at least one'))
										)
            )
        );
    }

    /**
     * Function for set form configuration.
     *
     * This function is access by admin user.
     * 
     * @access  public
     */        
    public function configure()
    {
        unset($this['id'], $this['created_at'], $this['updated_at']);
        // Disable the secret key
        $this->disableLocalCSRFProtection();
        $this->validatorSchema->setOption('allow_extra_fields', true);
        $this->validatorSchema->setOption('filter_extra_fields', false);
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
    public function checkGroupNameExist($oValidator, $ssValue)
    {
        $snIdGroup = '';
        if(!$this->isNew())
            $snIdGroup = $this->getObject()->getId();

        $oSfGuardGroup = new sfGuardGroup();
        $oResult    = $oSfGuardGroup->checkGroupNameExist($ssValue, $snIdGroup);
        unset($oSfGuardGroup);
      
        if(count($oResult) > 0)
            throw new sfValidatorError($oValidator, 'invalid');
        else
            return $ssValue;
    }

    public function updateDefaultsFromObject()
    {
        parent::updateDefaultsFromObject();

        if (isset($this->widgetSchema['permissions_list']))
        {
        $this->setDefault('permissions_list', $this->object->Permissions->getPrimaryKeys());
        }

    }

    protected function doSave($con = null)
    {
        $this->savePermissionsList($con);

        parent::doSave($con);
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
