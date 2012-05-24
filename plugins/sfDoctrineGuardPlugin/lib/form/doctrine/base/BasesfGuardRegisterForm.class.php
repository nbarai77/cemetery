<?php

/**
 * BasesfGuardRegisterForm for registering new users
 *
 * @package    sfDoctrineGuardPlugin
 * @subpackage form
 * @author     Jonathan H. Wage <jonwage@gmail.com>
 * @version    SVN: $Id: BasesfGuardRegisterForm.class.php,v 1.1.1.1 2012/03/24 12:16:36 nitin Exp $
 */
class BasesfGuardRegisterForm extends sfGuardUserAdminForm
{
  public function setup()
  {
    parent::setup();

    unset(
      $this['is_active'],
      $this['is_super_admin'],
      $this['updated_at'],
      $this['groups_list'],
      $this['permissions_list']
    );

    $this->validatorSchema['password']->setOption('required', true);
  }
}