<?php

/**
 * sfGuardFormSignin for sfGuardAuth signin action
 *
 * @package    sfDoctrineGuardPlugin
 * @subpackage form
 * @author     Fabien Potencier <fabien.potencier@symfony-project.com>
 * @version    SVN: $Id: sfGuardFormSignin.class.php,v 1.1.1.1 2012/03/24 12:16:35 nitin Exp $
 */
sfProjectConfiguration::getActive()->loadHelpers(array('I18N'));
class sfGuardFormSignin extends BasesfGuardFormSignin
{
    /**
    * @see sfForm
    */
    public function configure()
    {
        $this->setWidgets(array(
            //'usergroup' => new sfWidgetFormInputHidden(array(), array('readonly' => true)),
            'username' => new sfWidgetFormInputText(),
            'password' => new sfWidgetFormInputPassword(array('type' => 'password')),
            'remember' => new sfWidgetFormInputCheckbox(),
        ));

        $this->setValidators(array(
            //'usergroup' => new sfValidatorString(array('trim' => true)),
            'username' => new sfValidatorString(array('trim' => true),array('required' => __('Please enter username'))),
            'password' => new sfValidatorString(array('trim' => true),array('required' => __('Please enter password'))),
            'remember' => new sfValidatorBoolean(),
        ));

        /*$this->setDefaults(array(
            'usergroup' => 'admin'
        ));*/

        if (sfConfig::get('app_sf_guard_plugin_allow_login_with_email', true))
        {
            $this->widgetSchema['username']->setLabel(__('Username'));
            $this->widgetSchema['password']->setLabel(__('Password'));
        }

        

        $this->validatorSchema->setPostValidator(new sfGuardValidatorUser());

        $this->widgetSchema->setNameFormat('signin[%s]');
    }
}
