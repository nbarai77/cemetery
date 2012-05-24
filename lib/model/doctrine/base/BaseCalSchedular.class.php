<?php
// Connection Component Binding
Doctrine_Manager::getInstance()->bindComponent('CalSchedular', 'doctrine');

/**
 * BaseCalSchedular
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $cal_schedular_id
 * @property integer $cal_template_id
 * @property timestamp $start_date
 * @property timestamp $created_at
 * @property timestamp $updated_at
 * @property CalTemplate $CalTemplate
 * @property Doctrine_Collection $CalCalendar
 * 
 * @method integer             getCalSchedularId()   Returns the current record's "cal_schedular_id" value
 * @method integer             getCalTemplateId()    Returns the current record's "cal_template_id" value
 * @method timestamp           getStartDate()        Returns the current record's "start_date" value
 * @method timestamp           getCreatedAt()        Returns the current record's "created_at" value
 * @method timestamp           getUpdatedAt()        Returns the current record's "updated_at" value
 * @method CalTemplate         getCalTemplate()      Returns the current record's "CalTemplate" value
 * @method Doctrine_Collection getCalCalendar()      Returns the current record's "CalCalendar" collection
 * @method CalSchedular        setCalSchedularId()   Sets the current record's "cal_schedular_id" value
 * @method CalSchedular        setCalTemplateId()    Sets the current record's "cal_template_id" value
 * @method CalSchedular        setStartDate()        Sets the current record's "start_date" value
 * @method CalSchedular        setCreatedAt()        Sets the current record's "created_at" value
 * @method CalSchedular        setUpdatedAt()        Sets the current record's "updated_at" value
 * @method CalSchedular        setCalTemplate()      Sets the current record's "CalTemplate" value
 * @method CalSchedular        setCalCalendar()      Sets the current record's "CalCalendar" collection
 * 
 * @package    cemetery
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseCalSchedular extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('cal_schedular');
        $this->hasColumn('cal_schedular_id', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => true,
             'autoincrement' => true,
             'length' => 4,
             ));
        $this->hasColumn('cal_template_id', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             'length' => 4,
             ));
        $this->hasColumn('start_date', 'timestamp', 25, array(
             'type' => 'timestamp',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             'length' => 25,
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
        $this->hasOne('CalTemplate', array(
             'local' => 'cal_template_id',
             'foreign' => 'cal_template_id'));

        $this->hasMany('CalCalendar', array(
             'local' => 'cal_schedular_id',
             'foreign' => 'cal_schedular_id'));
    }
}