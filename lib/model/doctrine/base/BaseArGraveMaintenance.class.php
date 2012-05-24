<?php
// Connection Component Binding
Doctrine_Manager::getInstance()->bindComponent('ArGraveMaintenance', 'doctrine');

/**
 * BaseArGraveMaintenance
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property integer $country_id
 * @property integer $cem_cemetery_id
 * @property integer $ar_area_id
 * @property integer $ar_section_id
 * @property integer $ar_row_id
 * @property integer $ar_plot_id
 * @property integer $ar_grave_id
 * @property date $date_paid
 * @property date $onsite_work_date
 * @property string $amount_paid
 * @property string $receipt
 * @property enum $renewal_term
 * @property date $renewal_date
 * @property string $interred_name
 * @property string $interred_surname
 * @property string $title
 * @property string $organization_name
 * @property string $first_name
 * @property string $surname
 * @property string $address
 * @property string $subrub
 * @property string $state
 * @property string $postal_code
 * @property integer $user_country
 * @property string $email
 * @property string $area_code
 * @property string $number
 * @property string $notes
 * @property timestamp $created_at
 * @property timestamp $updated_at
 * @property Country $Country
 * @property CemCemetery $CemCemetery
 * @property ArArea $ArArea
 * @property ArSection $ArSection
 * @property ArRow $ArRow
 * @property ArPlot $ArPlot
 * @property ArGrave $ArGrave
 * 
 * @method integer            getId()                Returns the current record's "id" value
 * @method integer            getCountryId()         Returns the current record's "country_id" value
 * @method integer            getCemCemeteryId()     Returns the current record's "cem_cemetery_id" value
 * @method integer            getArAreaId()          Returns the current record's "ar_area_id" value
 * @method integer            getArSectionId()       Returns the current record's "ar_section_id" value
 * @method integer            getArRowId()           Returns the current record's "ar_row_id" value
 * @method integer            getArPlotId()          Returns the current record's "ar_plot_id" value
 * @method integer            getArGraveId()         Returns the current record's "ar_grave_id" value
 * @method date               getDatePaid()          Returns the current record's "date_paid" value
 * @method date               getOnsiteWorkDate()    Returns the current record's "onsite_work_date" value
 * @method string             getAmountPaid()        Returns the current record's "amount_paid" value
 * @method string             getReceipt()           Returns the current record's "receipt" value
 * @method enum               getRenewalTerm()       Returns the current record's "renewal_term" value
 * @method date               getRenewalDate()       Returns the current record's "renewal_date" value
 * @method string             getInterredName()      Returns the current record's "interred_name" value
 * @method string             getInterredSurname()   Returns the current record's "interred_surname" value
 * @method string             getTitle()             Returns the current record's "title" value
 * @method string             getOrganizationName()  Returns the current record's "organization_name" value
 * @method string             getFirstName()         Returns the current record's "first_name" value
 * @method string             getSurname()           Returns the current record's "surname" value
 * @method string             getAddress()           Returns the current record's "address" value
 * @method string             getSubrub()            Returns the current record's "subrub" value
 * @method string             getState()             Returns the current record's "state" value
 * @method string             getPostalCode()        Returns the current record's "postal_code" value
 * @method integer            getUserCountry()       Returns the current record's "user_country" value
 * @method string             getEmail()             Returns the current record's "email" value
 * @method string             getAreaCode()          Returns the current record's "area_code" value
 * @method string             getNumber()            Returns the current record's "number" value
 * @method string             getNotes()             Returns the current record's "notes" value
 * @method timestamp          getCreatedAt()         Returns the current record's "created_at" value
 * @method timestamp          getUpdatedAt()         Returns the current record's "updated_at" value
 * @method Country            getCountry()           Returns the current record's "Country" value
 * @method CemCemetery        getCemCemetery()       Returns the current record's "CemCemetery" value
 * @method ArArea             getArArea()            Returns the current record's "ArArea" value
 * @method ArSection          getArSection()         Returns the current record's "ArSection" value
 * @method ArRow              getArRow()             Returns the current record's "ArRow" value
 * @method ArPlot             getArPlot()            Returns the current record's "ArPlot" value
 * @method ArGrave            getArGrave()           Returns the current record's "ArGrave" value
 * @method ArGraveMaintenance setId()                Sets the current record's "id" value
 * @method ArGraveMaintenance setCountryId()         Sets the current record's "country_id" value
 * @method ArGraveMaintenance setCemCemeteryId()     Sets the current record's "cem_cemetery_id" value
 * @method ArGraveMaintenance setArAreaId()          Sets the current record's "ar_area_id" value
 * @method ArGraveMaintenance setArSectionId()       Sets the current record's "ar_section_id" value
 * @method ArGraveMaintenance setArRowId()           Sets the current record's "ar_row_id" value
 * @method ArGraveMaintenance setArPlotId()          Sets the current record's "ar_plot_id" value
 * @method ArGraveMaintenance setArGraveId()         Sets the current record's "ar_grave_id" value
 * @method ArGraveMaintenance setDatePaid()          Sets the current record's "date_paid" value
 * @method ArGraveMaintenance setOnsiteWorkDate()    Sets the current record's "onsite_work_date" value
 * @method ArGraveMaintenance setAmountPaid()        Sets the current record's "amount_paid" value
 * @method ArGraveMaintenance setReceipt()           Sets the current record's "receipt" value
 * @method ArGraveMaintenance setRenewalTerm()       Sets the current record's "renewal_term" value
 * @method ArGraveMaintenance setRenewalDate()       Sets the current record's "renewal_date" value
 * @method ArGraveMaintenance setInterredName()      Sets the current record's "interred_name" value
 * @method ArGraveMaintenance setInterredSurname()   Sets the current record's "interred_surname" value
 * @method ArGraveMaintenance setTitle()             Sets the current record's "title" value
 * @method ArGraveMaintenance setOrganizationName()  Sets the current record's "organization_name" value
 * @method ArGraveMaintenance setFirstName()         Sets the current record's "first_name" value
 * @method ArGraveMaintenance setSurname()           Sets the current record's "surname" value
 * @method ArGraveMaintenance setAddress()           Sets the current record's "address" value
 * @method ArGraveMaintenance setSubrub()            Sets the current record's "subrub" value
 * @method ArGraveMaintenance setState()             Sets the current record's "state" value
 * @method ArGraveMaintenance setPostalCode()        Sets the current record's "postal_code" value
 * @method ArGraveMaintenance setUserCountry()       Sets the current record's "user_country" value
 * @method ArGraveMaintenance setEmail()             Sets the current record's "email" value
 * @method ArGraveMaintenance setAreaCode()          Sets the current record's "area_code" value
 * @method ArGraveMaintenance setNumber()            Sets the current record's "number" value
 * @method ArGraveMaintenance setNotes()             Sets the current record's "notes" value
 * @method ArGraveMaintenance setCreatedAt()         Sets the current record's "created_at" value
 * @method ArGraveMaintenance setUpdatedAt()         Sets the current record's "updated_at" value
 * @method ArGraveMaintenance setCountry()           Sets the current record's "Country" value
 * @method ArGraveMaintenance setCemCemetery()       Sets the current record's "CemCemetery" value
 * @method ArGraveMaintenance setArArea()            Sets the current record's "ArArea" value
 * @method ArGraveMaintenance setArSection()         Sets the current record's "ArSection" value
 * @method ArGraveMaintenance setArRow()             Sets the current record's "ArRow" value
 * @method ArGraveMaintenance setArPlot()            Sets the current record's "ArPlot" value
 * @method ArGraveMaintenance setArGrave()           Sets the current record's "ArGrave" value
 * 
 * @package    cemetery
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseArGraveMaintenance extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('ar_grave_maintenance');
        $this->hasColumn('id', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => true,
             'autoincrement' => true,
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
        $this->hasColumn('cem_cemetery_id', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             'length' => 4,
             ));
        $this->hasColumn('ar_area_id', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => 4,
             ));
        $this->hasColumn('ar_section_id', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => 4,
             ));
        $this->hasColumn('ar_row_id', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => 4,
             ));
        $this->hasColumn('ar_plot_id', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => 4,
             ));
        $this->hasColumn('ar_grave_id', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             'length' => 4,
             ));
        $this->hasColumn('date_paid', 'date', 25, array(
             'type' => 'date',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => 25,
             ));
        $this->hasColumn('onsite_work_date', 'date', 25, array(
             'type' => 'date',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => 25,
             ));
        $this->hasColumn('amount_paid', 'string', 255, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => 255,
             ));
        $this->hasColumn('receipt', 'string', 255, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => 255,
             ));
        $this->hasColumn('renewal_term', 'enum', 9, array(
             'type' => 'enum',
             'fixed' => 0,
             'unsigned' => false,
             'values' => 
             array(
              0 => '6 Months',
              1 => '1 Year',
              2 => '5 Years',
              3 => '10 Years',
              4 => 'Perpetual',
             ),
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             'length' => 9,
             ));
        $this->hasColumn('renewal_date', 'date', 25, array(
             'type' => 'date',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => 25,
             ));
        $this->hasColumn('interred_name', 'string', 255, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => 255,
             ));
        $this->hasColumn('interred_surname', 'string', 255, array(
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
        $this->hasColumn('organization_name', 'string', 255, array(
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
        $this->hasColumn('surname', 'string', 255, array(
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
        $this->hasColumn('subrub', 'string', 255, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => 255,
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
        $this->hasColumn('postal_code', 'string', 255, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => 255,
             ));
        $this->hasColumn('user_country', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => 4,
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
        $this->hasColumn('area_code', 'string', 255, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => 255,
             ));
        $this->hasColumn('number', 'string', 255, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => 255,
             ));
        $this->hasColumn('notes', 'string', null, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => '',
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
        $this->hasOne('Country', array(
             'local' => 'country_id',
             'foreign' => 'id'));

        $this->hasOne('CemCemetery', array(
             'local' => 'cem_cemetery_id',
             'foreign' => 'id'));

        $this->hasOne('ArArea', array(
             'local' => 'ar_area_id',
             'foreign' => 'id'));

        $this->hasOne('ArSection', array(
             'local' => 'ar_section_id',
             'foreign' => 'id'));

        $this->hasOne('ArRow', array(
             'local' => 'ar_row_id',
             'foreign' => 'id'));

        $this->hasOne('ArPlot', array(
             'local' => 'ar_plot_id',
             'foreign' => 'id'));

        $this->hasOne('ArGrave', array(
             'local' => 'ar_grave_id',
             'foreign' => 'id'));
    }
}