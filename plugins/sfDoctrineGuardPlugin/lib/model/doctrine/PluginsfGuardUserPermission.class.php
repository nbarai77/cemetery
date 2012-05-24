<?php

/**
 * User permission reference model.
 *
 * @package    sfDoctrineGuardPlugin
 * @subpackage model
 * @author     Fabien Potencier <fabien.potencier@symfony-project.com>
 * @version    SVN: $Id: PluginsfGuardUserPermission.class.php,v 1.1.1.1 2012/03/24 12:16:35 nitin Exp $
 */
abstract class PluginsfGuardUserPermission extends BasesfGuardUserPermission
{
  public function postSave($event)
  {
    parent::postSave($event);
    $this->getUser()->reloadGroupsAndPermissions();
  }
}