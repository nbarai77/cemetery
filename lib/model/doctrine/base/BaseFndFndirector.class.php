<?php
// Connection Component Binding
Doctrine_Manager::getInstance()->bindComponent('FndFndirector', 'doctrine');

/**
 * BaseFndFndirector
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property integer $cem_cemetery_id
 * @property integer $country_id
 * @property string $code
 * @property string $company_name
 * @property string $address
 * @property string $state
 * @property string $town
 * @property string $postal_code
 * @property string $title
 * @property string $first_name
 * @property string $last_name
 * @property string $middle_name
 * @property string $phone
 * @property string $fax_number
 * @property string $fax_area_code
 * @property string $area_code
 * @property string $email
 * @property integer $is_enabled
 * @property CemCemetery $CemCemetery
 * @property Country $Country
 * @property Doctrine_Collection $CemCemeteryFndirector
 * 
 * @method integer             getId()                    Returns the current record's "id" value
 * @method integer             getCemCemeteryId()         Returns the current record's "cem_cemetery_id" value
 * @method integer             getCountryId()             Returns the current record's "country_id" value
 * @method string              getCode()                  Returns the current record's "code" value
 * @method string              getCompanyName()           Returns the current record's "company_name" value
 * @method string              getAddress()               Returns the current record's "address" value
 * @method string              getState()                 Returns the current record's "state" value
 * @method string              getTown()                  Returns the current record's "town" value
 * @method string              getPostalCode()            Returns the current record's "postal_code" value
 * @method string              getTitle()                 Returns the current record's "title" value
 * @method string              getFirstName()             Returns the current record's "first_name" value
 * @method string              getLastName()              Returns the current record's "last_name" value
 * @method string              getMiddleName()            Returns the current record's "middle_name" value
 * @method string              getPhone()                 Returns the current record's "phone" value
 * @method string              getFaxNumber()             Returns the current record's "fax_number" value
 * @method string              getFaxAreaCode()           Returns the current record's "fax_area_code" value
 * @method string              getAreaCode()              Returns the current record's "area_code" value
 * @method string              getEmail()                 Returns the current record's "email" value
 * @method integer             getIsEnabled()             Returns the current record's "is_enabled" value
 * @method CemCemetery         getCemCemetery()           Returns the current record's "CemCemetery" value
 * @method Country             getCountry()               Returns the current record's "Country" value
 * @method Doctrine_Collection getCemCemeteryFndirector() Returns the current record's "CemCemeteryFndirector" collection
 * @method FndFndirector       setId()                    Sets the current record's "id" value
 * @method FndFndirector       setCemCemeteryId()         Sets the current record's "cem_cemetery_id" value
 * @method FndFndirector       setCountryId()             Sets the current record's "country_id" value
 * @method FndFndirector       setCode()                  Sets the current record's "code" value
 * @method FndFndirector       setCompanyName()           Sets the current record's "company_name" value
 * @method FndFndirector       setAddress()               Sets the current record's "address" value
 * @method FndFndirector       setState()                 Sets the current record's "state" value
 * @method FndFndirector       setTown()                  Sets the current record's "town" value
 * @method FndFndirector       setPostalCode()            Sets the current record's "postal_code" value
 * @method FndFndirector       setTitle()                 Sets the current record's "title" value
 * @method FndFndirector       setFirstName()             Sets the current record's "first_name" value
 * @method FndFndirector       setLastName()              Sets the current record's "last_name" value
 * @method FndFndirector       setMiddleName()            Sets the current record's "middle_name" value
 * @method FndFndirector       setPhone()                 Sets the current record's "phone" value
 * @method FndFndirector       setFaxNumber()             Sets the current record's "fax_number" value
 * @method FndFndirector       setFaxAreaCode()           Sets the current record's "fax_area_code" value
 * @method FndFndirector       setAreaCode()              Sets the current record's "area_code" value
 * @method FndFndirector       setEmail()                 Sets the current record's "email" value
 * @method FndFndirector       setIsEnabled()             Sets the current record's "is_enabled" value
 * @method FndFndirector       setCemCemetery()           Sets the current record's "CemCemetery" value
 * @method FndFndirector       setCountry()               Sets the current record's "Country" value
 * @method FndFndirector       setCemCemeteryFndirector() Sets the current record's "CemCemeteryFndirector" collection
 * 
 * @package    cemetery
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseFndFndirector extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('fnd_fndirector');
        $this->hasColumn('id', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => true,
             'autoincrement' => true,
             'length' => 4,
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
        $this->hasColumn('country_id', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             'length' => 4,
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
        $this->hasColumn('company_name', 'string', 255, array(
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
        $this->hasColumn('town', 'string', 255, array(
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
        $this->hasColumn('title', 'string', 255, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => 255,
             ));
        $this->hasColumn('first_name', 'string', 255, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             'length' => 255,
             ));
        $this->hasColumn('last_name', 'string', 255, array(
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
        $this->hasColumn('phone', 'string', 255, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => 255,
             ));
        $this->hasColumn('fax_number', 'string', 255, array(
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
        $this->hasColumn('email', 'string', 255, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
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
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('CemCemetery', array(
             'local' => 'cem_cemetery_id',
             'foreign' => 'id'));

        $this->hasOne('Country', array(
             'local' => 'country_id',
             'foreign' => 'id'));

        $this->hasMany('CemCemeteryFndirector', array(
             'local' => 'id',
             'foreign' => 'fnd_fndirector_id'));
    }
}