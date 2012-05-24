<?php
// Connection Component Binding
Doctrine_Manager::getInstance()->bindComponent('CemStonemasonDocs', 'doctrine');

/**
 * BaseCemStonemasonDocs
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property integer $user_id
 * @property integer $cem_cemetery_id
 * @property string $doc_name
 * @property string $doc_description
 * @property string $doc_path
 * @property date $expiry_date
 * @property timestamp $created_at
 * @property timestamp $updated_at
 * @property CemCemetery $CemCemetery
 * 
 * @method integer           getId()              Returns the current record's "id" value
 * @method integer           getUserId()          Returns the current record's "user_id" value
 * @method integer           getCemCemeteryId()   Returns the current record's "cem_cemetery_id" value
 * @method string            getDocName()         Returns the current record's "doc_name" value
 * @method string            getDocDescription()  Returns the current record's "doc_description" value
 * @method string            getDocPath()         Returns the current record's "doc_path" value
 * @method date              getExpiryDate()      Returns the current record's "expiry_date" value
 * @method timestamp         getCreatedAt()       Returns the current record's "created_at" value
 * @method timestamp         getUpdatedAt()       Returns the current record's "updated_at" value
 * @method CemCemetery       getCemCemetery()     Returns the current record's "CemCemetery" value
 * @method CemStonemasonDocs setId()              Sets the current record's "id" value
 * @method CemStonemasonDocs setUserId()          Sets the current record's "user_id" value
 * @method CemStonemasonDocs setCemCemeteryId()   Sets the current record's "cem_cemetery_id" value
 * @method CemStonemasonDocs setDocName()         Sets the current record's "doc_name" value
 * @method CemStonemasonDocs setDocDescription()  Sets the current record's "doc_description" value
 * @method CemStonemasonDocs setDocPath()         Sets the current record's "doc_path" value
 * @method CemStonemasonDocs setExpiryDate()      Sets the current record's "expiry_date" value
 * @method CemStonemasonDocs setCreatedAt()       Sets the current record's "created_at" value
 * @method CemStonemasonDocs setUpdatedAt()       Sets the current record's "updated_at" value
 * @method CemStonemasonDocs setCemCemetery()     Sets the current record's "CemCemetery" value
 * 
 * @package    cemetery
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseCemStonemasonDocs extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('cem_stonemason_docs');
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
        $this->hasColumn('cem_cemetery_id', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             'length' => 4,
             ));
        $this->hasColumn('doc_name', 'string', 255, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             'length' => 255,
             ));
        $this->hasColumn('doc_description', 'string', null, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => '',
             ));
        $this->hasColumn('doc_path', 'string', 255, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             'length' => 255,
             ));
        $this->hasColumn('expiry_date', 'date', 25, array(
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
             'notnull' => false,
             'autoincrement' => false,
             'length' => 25,
             ));
        $this->hasColumn('updated_at', 'timestamp', 25, array(
             'type' => 'timestamp',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => 25,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('CemCemetery', array(
             'local' => 'cem_cemetery_id',
             'foreign' => 'id'));
    }
}