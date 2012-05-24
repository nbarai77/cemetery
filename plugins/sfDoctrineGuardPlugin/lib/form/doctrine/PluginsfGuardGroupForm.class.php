<?php

/**
 * PluginsfGuardGroup form.
 *
 * @package    sfDoctrineGuardPlugin
 * @subpackage form
 * @author     Fabien Potencier <fabien.potencier@symfony-project.com>
 * @version    SVN: $Id: PluginsfGuardGroupForm.class.php,v 1.1.1.1 2012/03/24 12:16:35 nitin Exp $
 */
abstract class PluginsfGuardGroupForm extends BasesfGuardGroupForm
{
  /**
   * @see sfForm
   */
  public function setupInheritance()
  {
    parent::setupInheritance();

    unset(
      $this['created_at'],
      $this['updated_at']
    );

    $this->widgetSchema['users_list']->setLabel('Users');
    $this->widgetSchema['permissions_list']->setLabel('Permissions');
  }
}