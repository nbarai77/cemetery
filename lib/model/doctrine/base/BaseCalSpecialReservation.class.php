<?php
// Connection Component Binding
Doctrine_Manager::getInstance()->bindComponent('CalSpecialReservation', 'doctrine');

/**
 * BaseCalSpecialReservation
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $cal_special_reservation_id
 * @property integer $equ_equipment_id
 * @property integer $user_id
 * @property string $name
 * @property enum $reservation_type
 * @property string $user_list
 * @property integer $sort_order
 * @property timestamp $created_at
 * @property timestamp $updated_at
 * @property Doctrine_Collection $CalCalendar
 * 
 * @method integer               getCalSpecialReservationId()    Returns the current record's "cal_special_reservation_id" value
 * @method integer               getEquEquipmentId()             Returns the current record's "equ_equipment_id" value
 * @method integer               getUserId()                     Returns the current record's "user_id" value
 * @method string                getName()                       Returns the current record's "name" value
 * @method enum                  getReservationType()            Returns the current record's "reservation_type" value
 * @method string                getUserList()                   Returns the current record's "user_list" value
 * @method integer               getSortOrder()                  Returns the current record's "sort_order" value
 * @method timestamp             getCreatedAt()                  Returns the current record's "created_at" value
 * @method timestamp             getUpdatedAt()                  Returns the current record's "updated_at" value
 * @method Doctrine_Collection   getCalCalendar()                Returns the current record's "CalCalendar" collection
 * @method CalSpecialReservation setCalSpecialReservationId()    Sets the current record's "cal_special_reservation_id" value
 * @method CalSpecialReservation setEquEquipmentId()             Sets the current record's "equ_equipment_id" value
 * @method CalSpecialReservation setUserId()                     Sets the current record's "user_id" value
 * @method CalSpecialReservation setName()                       Sets the current record's "name" value
 * @method CalSpecialReservation setReservationType()            Sets the current record's "reservation_type" value
 * @method CalSpecialReservation setUserList()                   Sets the current record's "user_list" value
 * @method CalSpecialReservation setSortOrder()                  Sets the current record's "sort_order" value
 * @method CalSpecialReservation setCreatedAt()                  Sets the current record's "created_at" value
 * @method CalSpecialReservation setUpdatedAt()                  Sets the current record's "updated_at" value
 * @method CalSpecialReservation setCalCalendar()                Sets the current record's "CalCalendar" collection
 * 
 * @package    cemetery
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseCalSpecialReservation extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('cal_special_reservation');
        $this->hasColumn('cal_special_reservation_id', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => true,
             'autoincrement' => true,
             'length' => 4,
             ));
        $this->hasColumn('equ_equipment_id', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             'length' => 4,
             ));
        $this->hasColumn('user_id', 'integer', 8, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             'length' => 8,
             ));
        $this->hasColumn('name', 'string', 100, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             'length' => 100,
             ));
        $this->hasColumn('reservation_type', 'enum', 11, array(
             'type' => 'enum',
             'fixed' => 0,
             'unsigned' => false,
             'values' => 
             array(
              0 => 'special',
              1 => 'maintenance',
             ),
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             'length' => 11,
             ));
        $this->hasColumn('user_list', 'string', null, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             'length' => '',
             ));
        $this->hasColumn('sort_order', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => 4,
             ));
        $this->hasColumn('created_at', 'timestamp', 25, array(
             'type' => 'timestamp',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             'length' => 25,
             ));
        $this->hasColumn('updated_at', 'timestamp', 25, array(
             'type' => 'timestamp',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             'length' => 25,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasMany('CalCalendar', array(
             'local' => 'cal_special_reservation_id',
             'foreign' => 'cal_special_reservation_id'));
    }
}