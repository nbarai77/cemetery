<?php
// Connection Component Binding
Doctrine_Manager::getInstance()->bindComponent('GranteeLogs', 'doctrine');

/**
 * BaseGranteeLogs
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property integer $user_id
 * @property integer $cem_id
 * @property string $old_grantee
 * @property string $new_grantee
 * @property string $country_name
 * @property string $cem_name
 * @property string $area_name
 * @property string $section_name
 * @property string $row_name
 * @property string $plot_name
 * @property string $grave_number
 * @property string $operation
 * @property timestamp $operation_date
 * 
 * @method integer     getId()             Returns the current record's "id" value
 * @method integer     getUserId()         Returns the current record's "user_id" value
 * @method integer     getCemId()          Returns the current record's "cem_id" value
 * @method string      getOldGrantee()     Returns the current record's "old_grantee" value
 * @method string      getNewGrantee()     Returns the current record's "new_grantee" value
 * @method string      getCountryName()    Returns the current record's "country_name" value
 * @method string      getCemName()        Returns the current record's "cem_name" value
 * @method string      getAreaName()       Returns the current record's "area_name" value
 * @method string      getSectionName()    Returns the current record's "section_name" value
 * @method string      getRowName()        Returns the current record's "row_name" value
 * @method string      getPlotName()       Returns the current record's "plot_name" value
 * @method string      getGraveNumber()    Returns the current record's "grave_number" value
 * @method string      getOperation()      Returns the current record's "operation" value
 * @method timestamp   getOperationDate()  Returns the current record's "operation_date" value
 * @method GranteeLogs setId()             Sets the current record's "id" value
 * @method GranteeLogs setUserId()         Sets the current record's "user_id" value
 * @method GranteeLogs setCemId()          Sets the current record's "cem_id" value
 * @method GranteeLogs setOldGrantee()     Sets the current record's "old_grantee" value
 * @method GranteeLogs setNewGrantee()     Sets the current record's "new_grantee" value
 * @method GranteeLogs setCountryName()    Sets the current record's "country_name" value
 * @method GranteeLogs setCemName()        Sets the current record's "cem_name" value
 * @method GranteeLogs setAreaName()       Sets the current record's "area_name" value
 * @method GranteeLogs setSectionName()    Sets the current record's "section_name" value
 * @method GranteeLogs setRowName()        Sets the current record's "row_name" value
 * @method GranteeLogs setPlotName()       Sets the current record's "plot_name" value
 * @method GranteeLogs setGraveNumber()    Sets the current record's "grave_number" value
 * @method GranteeLogs setOperation()      Sets the current record's "operation" value
 * @method GranteeLogs setOperationDate()  Sets the current record's "operation_date" value
 * 
 * @package    cemetery
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseGranteeLogs extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('grantee_logs');
        $this->hasColumn('id', 'integer', 8, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => true,
             'autoincrement' => true,
             'length' => 8,
             ));
        $this->hasColumn('user_id', 'integer', 8, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => 8,
             ));
        $this->hasColumn('cem_id', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => 4,
             ));
        $this->hasColumn('old_grantee', 'string', 255, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => 255,
             ));
        $this->hasColumn('new_grantee', 'string', 255, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => 255,
             ));
        $this->hasColumn('country_name', 'string', 255, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => 255,
             ));
        $this->hasColumn('cem_name', 'string', 255, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => 255,
             ));
        $this->hasColumn('area_name', 'string', 255, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => 255,
             ));
        $this->hasColumn('section_name', 'string', 255, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => 255,
             ));
        $this->hasColumn('row_name', 'string', 255, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => 255,
             ));
        $this->hasColumn('plot_name', 'string', 255, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => 255,
             ));
        $this->hasColumn('grave_number', 'string', 255, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => 255,
             ));
        $this->hasColumn('operation', 'string', 255, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => 255,
             ));
        $this->hasColumn('operation_date', 'timestamp', 25, array(
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
        
    }
}