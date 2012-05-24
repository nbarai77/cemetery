<?php

/**
 * User table.
 *
 * @package    sfDoctrineGuardPlugin
 * @subpackage model
 * @author     Fabien Potencier <fabien.potencier@symfony-project.com>
 * @version    SVN: $Id: PluginsfGuardUserTable.class.php,v 1.1.1.1 2012/03/24 12:16:35 nitin Exp $
 */
abstract class PluginsfGuardUserTable extends Doctrine_Table
{
  /**
   * Retrieves a sfGuardUser object by username and is_active flag.
   *
   * @param  string  $username The username
   * @param  boolean $isActive The user's status
   *
   * @return sfGuardUser
   */
  public function retrieveByUsername($username, $isActive = true)
  {
    $query = Doctrine_Core::getTable('sfGuardUser')->createQuery('u')
      ->where('u.username = ?', $username)
      ->addWhere('u.is_active = ?', $isActive)
    ;

    return $query->fetchOne();
  }

  /**
   * Retrieves a sfGuardUser object by username or email_address and is_active flag.
   *
   * @param  string  $username The username
   * @param  boolean $isActive The user's status
   *
   * @return sfGuardUser
   */
  public function retrieveByUsernameOrEmailAddress($username, $isActive = true)
  {
    $query = Doctrine_Core::getTable('sfGuardUser')->createQuery('u')
      ->where('u.username = ? OR u.email_address = ?', array($username, $username))
      ->addWhere('u.is_active = ?', $isActive)
    ;

    return $query->fetchOne();
  }

    /**
    * Retrieves a sfGuardUser object by username or email_address and groupname and is_active flag.
    *
    * @param  string  $ssUsername The username
    * @param  integer  $snIdUserGroup The usergroupid
    * @param  boolean $isActive The user's status
    *
    * @return sfGuardUser
    */
    public function retrieveByUsernameOrEmailAddressAndUserGroup($ssUsername, $snIdUserGroup, $isActive = true)
    {
        return Doctrine_Query::create()
                ->select('U.*, UG.user_id, UG.group_id')
                ->from('sfGuardUser U')
                ->innerJoin('U.sfGuardUserGroup UG')
                ->where('U.username = ? OR U.email_address = ?', array($ssUsername, $ssUsername))
                ->addWhere('UG.group_id = ?', $snIdUserGroup)
                ->addWhere('U.is_active = ?', $isActive)
                ->fetchOne();
    }
}
