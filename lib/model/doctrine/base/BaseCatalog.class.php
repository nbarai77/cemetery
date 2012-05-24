<?php
// Connection Component Binding
Doctrine_Manager::getInstance()->bindComponent('Catalog', 'doctrine');

/**
 * BaseCatalog
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property float $cost_price
 * @property float $special_cost_price
 * @property timestamp $created_at
 * @property timestamp $updated_at
 * @property Doctrine_Collection $Grantee
 * @property Doctrine_Collection $GranteeGraveHistory
 * @property Doctrine_Collection $IntermentBooking
 * 
 * @method integer             getId()                  Returns the current record's "id" value
 * @method string              getName()                Returns the current record's "name" value
 * @method string              getDescription()         Returns the current record's "description" value
 * @method float               getCostPrice()           Returns the current record's "cost_price" value
 * @method float               getSpecialCostPrice()    Returns the current record's "special_cost_price" value
 * @method timestamp           getCreatedAt()           Returns the current record's "created_at" value
 * @method timestamp           getUpdatedAt()           Returns the current record's "updated_at" value
 * @method Doctrine_Collection getGrantee()             Returns the current record's "Grantee" collection
 * @method Doctrine_Collection getGranteeGraveHistory() Returns the current record's "GranteeGraveHistory" collection
 * @method Doctrine_Collection getIntermentBooking()    Returns the current record's "IntermentBooking" collection
 * @method Catalog             setId()                  Sets the current record's "id" value
 * @method Catalog             setName()                Sets the current record's "name" value
 * @method Catalog             setDescription()         Sets the current record's "description" value
 * @method Catalog             setCostPrice()           Sets the current record's "cost_price" value
 * @method Catalog             setSpecialCostPrice()    Sets the current record's "special_cost_price" value
 * @method Catalog             setCreatedAt()           Sets the current record's "created_at" value
 * @method Catalog             setUpdatedAt()           Sets the current record's "updated_at" value
 * @method Catalog             setGrantee()             Sets the current record's "Grantee" collection
 * @method Catalog             setGranteeGraveHistory() Sets the current record's "GranteeGraveHistory" collection
 * @method Catalog             setIntermentBooking()    Sets the current record's "IntermentBooking" collection
 * 
 * @package    cemetery
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseCatalog extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('catalog');
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
        $this->hasColumn('description', 'string', 255, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             'length' => 255,
             ));
        $this->hasColumn('cost_price', 'float', 10, array(
             'type' => 'float',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             'length' => 10,
             ));
        $this->hasColumn('special_cost_price', 'float', 10, array(
             'type' => 'float',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             'length' => 10,
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
        $this->hasMany('Grantee', array(
             'local' => 'id',
             'foreign' => 'catalog_id'));

        $this->hasMany('GranteeGraveHistory', array(
             'local' => 'id',
             'foreign' => 'catalog_id'));

        $this->hasMany('IntermentBooking', array(
             'local' => 'id',
             'foreign' => 'catalog_id'));
    }
}