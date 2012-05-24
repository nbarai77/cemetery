<?php
// Connection Component Binding
Doctrine_Manager::getInstance()->bindComponent('calSpecialReservation', 'doctrine');

/**
 * BasecalSpecialReservation
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $cal_special_reservation_id
 * @property integer $equ_equipment_id
 * @property integer $user_id
 * @property string $name
 * @property enum $reservation_type
 * @property clob $user_list
 * @property integer $sort_order
 * @property sfGuardUser $sfGuardUser
 * @property Doctrine_Collection $calCalendar
 * 
 * @method integer               getCalSpecialReservationId()    Returns the current record's "cal_special_reservation_id" value
 * @method integer               getEquEquipmentId()             Returns the current record's "equ_equipment_id" value
 * @method integer               getUserId()                     Returns the current record's "user_id" value
 * @method string                getName()                       Returns the current record's "name" value
 * @method enum                  getReservationType()            Returns the current record's "reservation_type" value
 * @method clob                  getUserList()                   Returns the current record's "user_list" value
 * @method integer               getSortOrder()                  Returns the current record's "sort_order" value
 * @method sfGuardUser           getSfGuardUser()                Returns the current record's "sfGuardUser" value
 * @method Doctrine_Collection   getCalCalendar()                Returns the current record's "calCalendar" collection
 * @method calSpecialReservation setCalSpecialReservationId()    Sets the current record's "cal_special_reservation_id" value
 * @method calSpecialReservation setEquEquipmentId()             Sets the current record's "equ_equipment_id" value
 * @method calSpecialReservation setUserId()                     Sets the current record's "user_id" value
 * @method calSpecialReservation setName()                       Sets the current record's "name" value
 * @method calSpecialReservation setReservationType()            Sets the current record's "reservation_type" value
 * @method calSpecialReservation setUserList()                   Sets the current record's "user_list" value
 * @method calSpecialReservation setSortOrder()                  Sets the current record's "sort_order" value
 * @method calSpecialReservation setSfGuardUser()                Sets the current record's "sfGuardUser" value
 * @method calSpecialReservation setCalCalendar()                Sets the current record's "calCalendar" collection
 * 
 * @package    cemetery
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BasecalSpecialReservation extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('cal_special_reservation');
        $this->hasColumn('cal_special_reservation_id', 'integer', 4, array(
             'type' => 'integer',
             'primary' => true,
             'autoincrement' => true,
             'length' => 4,
             ));
        $this->hasColumn('equ_equipment_id', 'integer', 4, array(
             'type' => 'integer',
             'notnull' => true,
             'length' => 4,
             ));
        $this->hasColumn('user_id', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             ));
        $this->hasColumn('name', 'string', 100, array(
             'type' => 'string',
             'unique' => true,
             'notnull' => true,
             'length' => 100,
             ));
        $this->hasColumn('reservation_type', 'enum', null, array(
             'type' => 'enum',
             'notnull' => true,
             'values' => 
             array(
              0 => 'special',
              1 => 'maintenance',
             ),
             ));
        $this->hasColumn('user_list', 'clob', 65532, array(
             'type' => 'clob',
             'notnull' => true,
             'length' => 65532,
             ));
        $this->hasColumn('sort_order', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('sfGuardUser', array(
             'local' => 'user_id',
             'foreign' => 'id',
             'onDelete' => 'Cascade'));

        $this->hasMany('calCalendar', array(
             'local' => 'cal_special_reservation_id',
             'foreign' => 'cal_special_reservation_id'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $this->actAs($timestampable0);
    }
}