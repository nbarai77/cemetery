<?php
// Connection Component Binding
Doctrine_Manager::getInstance()->bindComponent('LodgedBy', 'doctrine');

/**
 * BaseLodgedBy
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property string $name
 * @property integer $is_enabled
 * @property timestamp $created_at
 * @property timestamp $updated_at
 * 
 * @method integer   getId()         Returns the current record's "id" value
 * @method string    getName()       Returns the current record's "name" value
 * @method integer   getIsEnabled()  Returns the current record's "is_enabled" value
 * @method timestamp getCreatedAt()  Returns the current record's "created_at" value
 * @method timestamp getUpdatedAt()  Returns the current record's "updated_at" value
 * @method LodgedBy  setId()         Sets the current record's "id" value
 * @method LodgedBy  setName()       Sets the current record's "name" value
 * @method LodgedBy  setIsEnabled()  Sets the current record's "is_enabled" value
 * @method LodgedBy  setCreatedAt()  Sets the current record's "created_at" value
 * @method LodgedBy  setUpdatedAt()  Sets the current record's "updated_at" value
 * 
 * @package    cemetery
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseLodgedBy extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('lodged_by');
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
        $this->hasColumn('is_enabled', 'integer', 1, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'default' => '1',
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
        
    }
}