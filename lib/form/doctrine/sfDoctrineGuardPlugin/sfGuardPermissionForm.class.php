<?php

/**
 * sfGuardPermission form.
 *
 * @package    arp
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfGuardPermissionForm.class.php,v 1.1.1.1 2012/03/24 11:56:44 nitin Exp $
 */
class sfGuardPermissionForm extends BasesfGuardPermissionForm
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

        BasesfGuardPermissionForm::setWidgets(
            array(
                    'name'        => new sfWidgetFormInputText(array(), array('maxlength' => 255, 'tabindex'=> 1)),
                    'description' => new sfWidgetFormTextArea(array(), array('tabindex'=> 1)),
            )
        );

        $this->widgetSchema->setNameFormat('sf_guard_permission[%s]'); 
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
        BasesfGuardPermissionForm::setValidators(
            array(
                'name'              => new sfValidatorAnd( 
                                            array(
                                                new sfValidatorCallback(
                                                    array('callback' => array($this, 'checkPermissionNameExist')),
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
    public function checkPermissionNameExist($oValidator, $ssValue)
    {
        $snIdPermission = '';
        if(!$this->isNew())
            $snIdPermission = $this->getObject()->getId();

        $oSfGuardPermission = new sfGuardPermission();
        $oResult    = $oSfGuardPermission->checkPermissionNameExist($ssValue, $snIdPermission);
        unset($oSfGuardPermission);
      
        if(count($oResult) > 0)
            throw new sfValidatorError($oValidator, 'invalid');
        else
            return $ssValue;
    }
}
