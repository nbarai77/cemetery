<?php
// Connection Component Binding
Doctrine_Manager::getInstance()->bindComponent('DayType', 'doctrine');

/**
 * BaseDayType
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property string $name
 * @property Doctrine_Collection $TimeInOut
 * 
 * @method integer             getId()        Returns the current record's "id" value
 * @method string              getName()      Returns the current record's "name" value
 * @method Doctrine_Collection getTimeInOut() Returns the current record's "TimeInOut" collection
 * @method DayType             setId()        Sets the current record's "id" value
 * @method DayType             setName()      Sets the current record's "name" value
 * @method DayType             setTimeInOut() Sets the current record's "TimeInOut" collection
 * 
 * @package    cemetery
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseDayType extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('day_type');
        $this->hasColumn('id', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => true,
             'autoincrement' => true,
             'length' => 4,
             ));
        $this->hasColumn('name', 'string', 255, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             'length' => 255,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasMany('TimeInOut', array(
             'local' => 'id',
             'foreign' => 'day_type_id'));
    }
}