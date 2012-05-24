<?php

/*
 * This file is part of the symfony package.
 * (c) Fabien Potencier <fabien.potencier@symfony-project.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 *
 * @package    symfony
 * @subpackage plugin
 * @author     Fabien Potencier <fabien.potencier@symfony-project.com>
 * @version    SVN: $Id: sfGuardValidatorUser.class.php,v 1.1.1.1 2012/03/24 12:16:34 nitin Exp $
 */
class sfGuardValidatorUser extends sfValidatorBase
{
  public function configure($options = array(), $messages = array())
  {
    $this->addOption('username_field', 'username');
    $this->addOption('password_field', 'password');
    $this->addOption('usergroup_field', 'usergroup');       //  added by bipin
    $this->addOption('throw_global_error', false);

    $this->setMessage('invalid', 'The username and/or password is invalid.');
  }

  protected function doClean($values)
  {
    $username       = isset($values[$this->getOption('username_field')]) ? $values[$this->getOption('username_field')] : '';
    $password       = isset($values[$this->getOption('password_field')]) ? $values[$this->getOption('password_field')] : '';
    $ssUserGroup    = isset($values[$this->getOption('usergroup_field')]) ? $values[$this->getOption('usergroup_field')] : '';      //  added by bipin

    $allowEmail = sfConfig::get('app_sf_guard_plugin_allow_login_with_email', true);
    $method = $allowEmail ? 'retrieveByUsernameOrEmailAddress' : 'retrieveByUsername';

    // don't allow to sign in with an empty username
    if ($username && $password)
    {
       if ($callable = sfConfig::get('app_sf_guard_plugin_retrieve_by_username_callable'))
       {
           $user = call_user_func_array($callable, array($username));
       } else {
           //$user = $this->getTable()->retrieveByUsername($username);

            //  change by bipin
            if($ssUserGroup)
            {
                $method         = 'retrieveByUsernameOrEmailAddressAndUserGroup';   //  added by dattesh
                $osfGuardGroup  = Doctrine_Core::getTable('sfGuardGroup')->findOneByName($ssUserGroup);

                if($osfGuardGroup)
                {
                    $snIdUserGroup  = $osfGuardGroup->getId();
                    $user           = $this->getTable()->$method($username, $snIdUserGroup);
                }
            }
            else
            {
                $method = $allowEmail ? 'retrieveByUsernameOrEmailAddress' : 'retrieveByUsername';      
                $user   = $this->getTable()->$method($username);
            }
                
            //  end
       }
        // user exists?
       if(isset($user) && $user)        //if($user)
       {
          // password is ok?
          if ($user->getIsActive() && $user->checkPassword($password))
          {
            return array_merge($values, array('user' => $user));
          }
       }

       if ($this->getOption('throw_global_error'))
       {
        throw new sfValidatorError($this, 'invalid');
       }

    throw new sfValidatorErrorSchema($this, array($this->getOption('username_field') => new sfValidatorError($this, 'invalid')));
    }
  }

  protected function getTable()
  {
    return Doctrine::getTable('sfGuardUser');
  }
}
