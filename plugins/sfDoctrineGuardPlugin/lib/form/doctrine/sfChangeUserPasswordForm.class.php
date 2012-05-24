<?php

/**
 * Changepassword form.
 * @package    form
 * @subpackage Admin
 * @author     Sandip Limbachiya
 *
 */
sfProjectConfiguration::getActive()->loadHelpers('I18N');
class sfChangeUserPasswordForm extends PluginsfGuardUserForm
{
  public function configure()
  {
    
    unset($this['username'],$this['algorithm'],$this['first_name'],$this['last_name'],$this['email_address'],$this['email_address'],$this['is_active'],$this['created_at'],$this['updated_at'],$this['is_super_admin'],$this['last_login'],$this['groups_list'],$this['permissions_list']);
    
    $this->widgetSchema['password'] = new sfWidgetFormInputPassword(array(),array('maxlength'=>60));
    $this->widgetSchema['new_password'] = new sfWidgetFormInputPassword(array(),array('maxlength'=>60));
    $this->widgetSchema['confirm_password'] = new sfWidgetFormInputPassword(array(),array('maxlength'=>60));
    
    $this->validatorSchema['password'] = new sfValidatorAnd
                                                      (
                                                          array(
                                                              new sfValidatorString(),
                                                              new sfValidatorCallback(
                                                                  array('callback'=> array($this,'checkOldPassword'),'arguments' => array()),
                                                                  array('invalid' => __('Your old password is wrong'))
                                                              )
                                                          ),
                                                          array('required' => true, 'trim' => true),
                                                          array('required' =>__('Password required'))
                                                      );

    $this->validatorSchema['new_password'] = new sfValidatorString(array('required'=>true, 'trim' => true, 'min_length'=>5,'max_length'=>15 ),array('required'=>__('New password required'),'min_length'=>__('Please enter minimum 5 character'),'max_length'=>__('Please enter maximum 5 character')));
    $this->validatorSchema['confirm_password'] = new sfValidatorString(array('required'=>true, 'trim' => true, 'min_length'=>5,'max_length'=>15),array('required'=>__('Confirm password required'),'min_length'=>__('Please enter minimum 5 character'),'max_length'=>__('Please enter maximum 5 character')));
    $amValues =  sfContext::getInstance()->getRequest()->getParameter('sf_change_password'); 

    
  //For compare the two passwp
    if($amValues['new_password'] && $amValues['confirm_password'] )
    {
       $this->mergePostValidator(new sfValidatorSchemaCompare('confirm_password', '==', 'new_password', array(), array('invalid' =>__('Password and password again must be same'))));
    }    

    //Set the all labels
    $this->widgetSchema->setLabels(array(
          'password'    => __('Old password'),
          'new_password'    => __('New password'),
          'confirm_password'    => __('Confirm password'),
    ));     

    $this->widgetSchema->setNameFormat('sf_change_password[%s]'); 
   
    $this->disableLocalCSRFProtection();   
         
  }  

    /**
     * checkOldPassword
     *
     * Function for check current password is valid or not
     *
     * @access  logged in user
     * @param   object $oValidator pass sfValidatorCallback
     * @param   string $smOldPassword values of current password
     * @return  string $smOldPassword values of current password or error
     */
    public function checkOldPassword($oValidator, $smOldPassword)
    {
        $allowEmail = sfConfig::get('app_sf_guard_plugin_allow_login_with_email', true);
        $method = $allowEmail ? 'retrieveByUsernameOrEmailAddress' : 'retrieveByUsername';

        $ssUsername     = sfContext::getInstance()->getUser()->getAttribute('username','','sfGuardSecurityUser');
        $oUser          = Doctrine::getTable('SfGuardUser')->$method($ssUsername);
        
        if($oUser) 
        {
            // password is ok?
            if ($oUser->getIsActive() && sfContext::getInstance()->getUser()->checkPassword($smOldPassword))
            {
              return $smOldPassword;
            }  
            else
                throw new sfValidatorError($oValidator, 'invalid');
        }
    }
}
