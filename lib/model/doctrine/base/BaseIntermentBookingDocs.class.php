<?php
// Connection Component Binding
Doctrine_Manager::getInstance()->bindComponent('IntermentBookingDocs', 'doctrine');

/**
 * BaseIntermentBookingDocs
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property integer $interment_booking_id
 * @property string $file_name
 * @property string $file_path
 * @property string $file_description
 * @property date $expiry_date
 * @property timestamp $created_at
 * @property timestamp $updated_at
 * @property IntermentBooking $IntermentBooking
 * 
 * @method integer              getId()                   Returns the current record's "id" value
 * @method integer              getIntermentBookingId()   Returns the current record's "interment_booking_id" value
 * @method string               getFileName()             Returns the current record's "file_name" value
 * @method string               getFilePath()             Returns the current record's "file_path" value
 * @method string               getFileDescription()      Returns the current record's "file_description" value
 * @method date                 getExpiryDate()           Returns the current record's "expiry_date" value
 * @method timestamp            getCreatedAt()            Returns the current record's "created_at" value
 * @method timestamp            getUpdatedAt()            Returns the current record's "updated_at" value
 * @method IntermentBooking     getIntermentBooking()     Returns the current record's "IntermentBooking" value
 * @method IntermentBookingDocs setId()                   Sets the current record's "id" value
 * @method IntermentBookingDocs setIntermentBookingId()   Sets the current record's "interment_booking_id" value
 * @method IntermentBookingDocs setFileName()             Sets the current record's "file_name" value
 * @method IntermentBookingDocs setFilePath()             Sets the current record's "file_path" value
 * @method IntermentBookingDocs setFileDescription()      Sets the current record's "file_description" value
 * @method IntermentBookingDocs setExpiryDate()           Sets the current record's "expiry_date" value
 * @method IntermentBookingDocs setCreatedAt()            Sets the current record's "created_at" value
 * @method IntermentBookingDocs setUpdatedAt()            Sets the current record's "updated_at" value
 * @method IntermentBookingDocs setIntermentBooking()     Sets the current record's "IntermentBooking" value
 * 
 * @package    cemetery
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseIntermentBookingDocs extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('interment_booking_docs');
        $this->hasColumn('id', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => true,
             'autoincrement' => true,
             'length' => 4,
             ));
        $this->hasColumn('interment_booking_id', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             'length' => 4,
             ));
        $this->hasColumn('file_name', 'string', 255, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             'length' => 255,
             ));
        $this->hasColumn('file_path', 'string', 255, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             'length' => 255,
             ));
        $this->hasColumn('file_description', 'string', null, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => '',
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
        $this->hasOne('IntermentBooking', array(
             'local' => 'interment_booking_id',
             'foreign' => 'id'));
    }
}