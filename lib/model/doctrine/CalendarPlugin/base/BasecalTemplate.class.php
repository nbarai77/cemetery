<?php
// Connection Component Binding
Doctrine_Manager::getInstance()->bindComponent('calTemplate', 'doctrine');

/**
 * BasecalTemplate
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $cal_template_id
 * @property integer $equ_equipment_id
 * @property string $name
 * @property clob $description
 * @property clob $param_set
 * @property Doctrine_Collection $calSchedular
 * 
 * @method integer             getCalTemplateId()    Returns the current record's "cal_template_id" value
 * @method integer             getEquEquipmentId()   Returns the current record's "equ_equipment_id" value
 * @method string              getName()             Returns the current record's "name" value
 * @method clob                getDescription()      Returns the current record's "description" value
 * @method clob                getParamSet()         Returns the current record's "param_set" value
 * @method Doctrine_Collection getCalSchedular()     Returns the current record's "calSchedular" collection
 * @method calTemplate         setCalTemplateId()    Sets the current record's "cal_template_id" value
 * @method calTemplate         setEquEquipmentId()   Sets the current record's "equ_equipment_id" value
 * @method calTemplate         setName()             Sets the current record's "name" value
 * @method calTemplate         setDescription()      Sets the current record's "description" value
 * @method calTemplate         setParamSet()         Sets the current record's "param_set" value
 * @method calTemplate         setCalSchedular()     Sets the current record's "calSchedular" collection
 * 
 * @package    cemetery
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BasecalTemplate extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('cal_template');
        $this->hasColumn('cal_template_id', 'integer', 4, array(
             'type' => 'integer',
             'primary' => true,
             'autoincrement' => true,
             'length' => 4,
             ));
        $this->hasColumn('equ_equipment_id', 'integer', 4, array(
             'type' => 'integer',
             'notnull' => true,
             'length' => 4,
             ));
        $this->hasColumn('name', 'string', 100, array(
             'type' => 'string',
             'unique' => true,
             'notnull' => true,
             'length' => 100,
             ));
        $this->hasColumn('description', 'clob', 65532, array(
             'type' => 'clob',
             'length' => 65532,
             ));
        $this->hasColumn('param_set', 'clob', 65532, array(
             'type' => 'clob',
             'notnull' => true,
             'length' => 65532,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasMany('calSchedular', array(
             'local' => 'cal_template_id',
             'foreign' => 'cal_template_id'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $this->actAs($timestampable0);
    }
}