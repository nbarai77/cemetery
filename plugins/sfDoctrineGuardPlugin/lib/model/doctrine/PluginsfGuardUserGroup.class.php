<?php

/**
 * User group reference model.
 *
 * @package    sfDoctrineGuardPlugin
 * @subpackage model
 * @author     Fabien Potencier <fabien.potencier@symfony-project.com>
 * @version    SVN: $Id: PluginsfGuardUserGroup.class.php,v 1.1.1.1 2012/03/24 12:16:35 nitin Exp $
 */
abstract class PluginsfGuardUserGroup extends BasesfGuardUserGroup
{
  public function postSave($event)
  {
    parent::postSave($event);
    $this->getUser()->reloadGroupsAndPermissions();
  }
}
