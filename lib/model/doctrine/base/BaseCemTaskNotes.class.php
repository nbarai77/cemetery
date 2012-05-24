<?php
// Connection Component Binding
Doctrine_Manager::getInstance()->bindComponent('CemTaskNotes', 'doctrine');

/**
 * BaseCemTaskNotes
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property integer $user_id
 * @property string $task_title
 * @property string $task_description
 * @property date $entry_date
 * @property date $due_date
 * @property timestamp $created_at
 * @property timestamp $updated_at
 * 
 * @method integer      getId()               Returns the current record's "id" value
 * @method integer      getUserId()           Returns the current record's "user_id" value
 * @method string       getTaskTitle()        Returns the current record's "task_title" value
 * @method string       getTaskDescription()  Returns the current record's "task_description" value
 * @method date         getEntryDate()        Returns the current record's "entry_date" value
 * @method date         getDueDate()          Returns the current record's "due_date" value
 * @method timestamp    getCreatedAt()        Returns the current record's "created_at" value
 * @method timestamp    getUpdatedAt()        Returns the current record's "updated_at" value
 * @method CemTaskNotes setId()               Sets the current record's "id" value
 * @method CemTaskNotes setUserId()           Sets the current record's "user_id" value
 * @method CemTaskNotes setTaskTitle()        Sets the current record's "task_title" value
 * @method CemTaskNotes setTaskDescription()  Sets the current record's "task_description" value
 * @method CemTaskNotes setEntryDate()        Sets the current record's "entry_date" value
 * @method CemTaskNotes setDueDate()          Sets the current record's "due_date" value
 * @method CemTaskNotes setCreatedAt()        Sets the current record's "created_at" value
 * @method CemTaskNotes setUpdatedAt()        Sets the current record's "updated_at" value
 * @property  $
 * 
 * @package    cemetery
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseCemTaskNotes extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('cem_task_notes');
        $this->hasColumn('id', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => true,
             'autoincrement' => true,
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
        $this->hasColumn('task_title', 'string', 255, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             'length' => 255,
             ));
        $this->hasColumn('task_description', 'string', null, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             'length' => '',
             ));
        $this->hasColumn('entry_date', 'date', 25, array(
             'type' => 'date',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => 25,
             ));
        $this->hasColumn('due_date', 'date', 25, array(
             'type' => 'date',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
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
        $this->hasMany('SfGuardUser', array(
             'local' => 'user_id',
             'foreign' => 'id'));
    }
}