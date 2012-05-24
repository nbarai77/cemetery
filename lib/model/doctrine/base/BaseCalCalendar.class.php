<?php
// Connection Component Binding
Doctrine_Manager::getInstance()->bindComponent('CalCalendar', 'doctrine');

/**
 * BaseCalCalendar
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $cal_calendar_id
 * @property integer $cal_schedular_id
 * @property integer $periode
 * @property integer $periode_type
 * @property integer $duration
 * @property integer $slot
 * @property integer $cal_special_reservation_id
 * @property string $lab_list
 * @property string $artical_list
 * @property string $rate_bace
 * @property timestamp $created_at
 * @property timestamp $updated_at
 * @property CalSchedular $CalSchedular
 * @property CalSpecialReservation $CalSpecialReservation
 * 
 * @method integer               getCalCalendarId()              Returns the current record's "cal_calendar_id" value
 * @method integer               getCalSchedularId()             Returns the current record's "cal_schedular_id" value
 * @method integer               getPeriode()                    Returns the current record's "periode" value
 * @method integer               getPeriodeType()                Returns the current record's "periode_type" value
 * @method integer               getDuration()                   Returns the current record's "duration" value
 * @method integer               getSlot()                       Returns the current record's "slot" value
 * @method integer               getCalSpecialReservationId()    Returns the current record's "cal_special_reservation_id" value
 * @method string                getLabList()                    Returns the current record's "lab_list" value
 * @method string                getArticalList()                Returns the current record's "artical_list" value
 * @method string                getRateBace()                   Returns the current record's "rate_bace" value
 * @method timestamp             getCreatedAt()                  Returns the current record's "created_at" value
 * @method timestamp             getUpdatedAt()                  Returns the current record's "updated_at" value
 * @method CalSchedular          getCalSchedular()               Returns the current record's "CalSchedular" value
 * @method CalSpecialReservation getCalSpecialReservation()      Returns the current record's "CalSpecialReservation" value
 * @method CalCalendar           setCalCalendarId()              Sets the current record's "cal_calendar_id" value
 * @method CalCalendar           setCalSchedularId()             Sets the current record's "cal_schedular_id" value
 * @method CalCalendar           setPeriode()                    Sets the current record's "periode" value
 * @method CalCalendar           setPeriodeType()                Sets the current record's "periode_type" value
 * @method CalCalendar           setDuration()                   Sets the current record's "duration" value
 * @method CalCalendar           setSlot()                       Sets the current record's "slot" value
 * @method CalCalendar           setCalSpecialReservationId()    Sets the current record's "cal_special_reservation_id" value
 * @method CalCalendar           setLabList()                    Sets the current record's "lab_list" value
 * @method CalCalendar           setArticalList()                Sets the current record's "artical_list" value
 * @method CalCalendar           setRateBace()                   Sets the current record's "rate_bace" value
 * @method CalCalendar           setCreatedAt()                  Sets the current record's "created_at" value
 * @method CalCalendar           setUpdatedAt()                  Sets the current record's "updated_at" value
 * @method CalCalendar           setCalSchedular()               Sets the current record's "CalSchedular" value
 * @method CalCalendar           setCalSpecialReservation()      Sets the current record's "CalSpecialReservation" value
 * 
 * @package    cemetery
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseCalCalendar extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('cal_calendar');
        $this->hasColumn('cal_calendar_id', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => true,
             'autoincrement' => true,
             'length' => 4,
             ));
        $this->hasColumn('cal_schedular_id', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             'length' => 4,
             ));
        $this->hasColumn('periode', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             'length' => 4,
             ));
        $this->hasColumn('periode_type', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             'length' => 4,
             ));
        $this->hasColumn('duration', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             'length' => 4,
             ));
        $this->hasColumn('slot', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             'length' => 4,
             ));
        $this->hasColumn('cal_special_reservation_id', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             'length' => 4,
             ));
        $this->hasColumn('lab_list', 'string', null, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => '',
             ));
        $this->hasColumn('artical_list', 'string', null, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => '',
             ));
        $this->hasColumn('rate_bace', 'string', 1, array(
             'type' => 'string',
             'fixed' => 1,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => 1,
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
        $this->hasOne('CalSchedular', array(
             'local' => 'cal_schedular_id',
             'foreign' => 'cal_schedular_id'));

        $this->hasOne('CalSpecialReservation', array(
             'local' => 'cal_special_reservation_id',
             'foreign' => 'cal_special_reservation_id'));
    }
}