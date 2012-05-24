<?php
// Connection Component Binding
Doctrine_Manager::getInstance()->bindComponent('UserCemetery', 'doctrine');

/**
 * BaseUserCemetery
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property integer $user_id
 * @property integer $group_id
 * @property integer $cem_cemetery_id
 * @property integer $award_id
 * @property string $title
 * @property string $middle_name
 * @property string $organisation
 * @property string $code
 * @property string $address
 * @property string $state
 * @property string $phone
 * @property string $suburb
 * @property string $postal_code
 * @property string $fax
 * @property string $fax_area_code
 * @property string $area_code
 * @property string $user_code
 * @property timestamp $created_at
 * @property timestamp $updated_at
 * @property CemCemetery $CemCemetery
 * 
 * @method integer      getId()              Returns the current record's "id" value
 * @method integer      getUserId()          Returns the current record's "user_id" value
 * @method integer      getGroupId()         Returns the current record's "group_id" value
 * @method integer      getCemCemeteryId()   Returns the current record's "cem_cemetery_id" value
 * @method integer      getAwardId()         Returns the current record's "award_id" value
 * @method string       getTitle()           Returns the current record's "title" value
 * @method string       getMiddleName()      Returns the current record's "middle_name" value
 * @method string       getOrganisation()    Returns the current record's "organisation" value
 * @method string       getCode()            Returns the current record's "code" value
 * @method string       getAddress()         Returns the current record's "address" value
 * @method string       getState()           Returns the current record's "state" value
 * @method string       getPhone()           Returns the current record's "phone" value
 * @method string       getSuburb()          Returns the current record's "suburb" value
 * @method string       getPostalCode()      Returns the current record's "postal_code" value
 * @method string       getFax()             Returns the current record's "fax" value
 * @method string       getFaxAreaCode()     Returns the current record's "fax_area_code" value
 * @method string       getAreaCode()        Returns the current record's "area_code" value
 * @method string       getUserCode()        Returns the current record's "user_code" value
 * @method timestamp    getCreatedAt()       Returns the current record's "created_at" value
 * @method timestamp    getUpdatedAt()       Returns the current record's "updated_at" value
 * @method CemCemetery  getCemCemetery()     Returns the current record's "CemCemetery" value
 * @method UserCemetery setId()              Sets the current record's "id" value
 * @method UserCemetery setUserId()          Sets the current record's "user_id" value
 * @method UserCemetery setGroupId()         Sets the current record's "group_id" value
 * @method UserCemetery setCemCemeteryId()   Sets the current record's "cem_cemetery_id" value
 * @method UserCemetery setAwardId()         Sets the current record's "award_id" value
 * @method UserCemetery setTitle()           Sets the current record's "title" value
 * @method UserCemetery setMiddleName()      Sets the current record's "middle_name" value
 * @method UserCemetery setOrganisation()    Sets the current record's "organisation" value
 * @method UserCemetery setCode()            Sets the current record's "code" value
 * @method UserCemetery setAddress()         Sets the current record's "address" value
 * @method UserCemetery setState()           Sets the current record's "state" value
 * @method UserCemetery setPhone()           Sets the current record's "phone" value
 * @method UserCemetery setSuburb()          Sets the current record's "suburb" value
 * @method UserCemetery setPostalCode()      Sets the current record's "postal_code" value
 * @method UserCemetery setFax()             Sets the current record's "fax" value
 * @method UserCemetery setFaxAreaCode()     Sets the current record's "fax_area_code" value
 * @method UserCemetery setAreaCode()        Sets the current record's "area_code" value
 * @method UserCemetery setUserCode()        Sets the current record's "user_code" value
 * @method UserCemetery setCreatedAt()       Sets the current record's "created_at" value
 * @method UserCemetery setUpdatedAt()       Sets the current record's "updated_at" value
 * @method UserCemetery setCemCemetery()     Sets the current record's "CemCemetery" value
 * 
 * @package    cemetery
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseUserCemetery extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('user_cemetery');
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
        $this->hasColumn('group_id', 'integer', 8, array(
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
             'default' => '0',
             'notnull' => false,
             'autoincrement' => false,
             'length' => 4,
             ));
        $this->hasColumn('award_id', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => 4,
             ));
        $this->hasColumn('title', 'string', 255, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => 255,
             ));
        $this->hasColumn('middle_name', 'string', 255, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => 255,
             ));
        $this->hasColumn('organisation', 'string', 255, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => 255,
             ));
        $this->hasColumn('code', 'string', 255, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => 255,
             ));
        $this->hasColumn('address', 'string', null, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => '',
             ));
        $this->hasColumn('state', 'string', 255, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => 255,
             ));
        $this->hasColumn('phone', 'string', 255, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => 255,
             ));
        $this->hasColumn('suburb', 'string', 255, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => 255,
             ));
        $this->hasColumn('postal_code', 'string', 255, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => 255,
             ));
        $this->hasColumn('fax', 'string', 255, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => 255,
             ));
        $this->hasColumn('fax_area_code', 'string', 255, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => 255,
             ));
        $this->hasColumn('area_code', 'string', 255, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => 255,
             ));
        $this->hasColumn('user_code', 'string', 255, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => 255,
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
        $this->hasOne('CemCemetery', array(
             'local' => 'cem_cemetery_id',
             'foreign' => 'id'));
    }
}