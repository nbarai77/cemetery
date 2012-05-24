<?php
// Connection Component Binding
Doctrine_Manager::getInstance()->bindComponent('IntermentBookingThree', 'doctrine');

/**
 * BaseIntermentBookingThree
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property integer $interment_booking_id
 * @property string $file_location
 * @property enum $cemetery_application
 * @property enum $burial_booking_form
 * @property enum $ashes_booking_form
 * @property enum $exhumation_booking_from
 * @property enum $remains_booking_from
 * @property enum $health_order
 * @property enum $court_order
 * @property enum $checked_fnd_details
 * @property enum $checked_owner_grave
 * @property enum $living_grave_owner
 * @property enum $deceased_grave_owner
 * @property enum $cecked_chapel_booking
 * @property enum $advised_fd_to_check
 * @property enum $advised_fd_recommended
 * @property enum $advised_fd_coffin_height
 * @property enum $medical_death_certificate
 * @property enum $medical_certificate_spelling
 * @property enum $medical_certificate_infectious
 * @property enum $request_probe_reopen
 * @property enum $request_triple_depth_reopen
 * @property enum $checked_monumental
 * @property enum $contacted_stonemason
 * @property enum $checked_accessories
 * @property enum $balloons_na
 * @property enum $burning_drum
 * @property enum $canopy
 * @property enum $ceremonial_sand_bucket
 * @property enum $fireworks
 * @property enum $lowering_device
 * @property enum $checked_returned_signed
 * @property enum $check_coffin_sizes_surcharge
 * @property enum $surcharge_applied
 * @property enum $compare_burial_booking
 * @property enum $for_between_burials
 * @property enum $double_check_yellow_date
 * @property string $other
 * @property timestamp $created_at
 * @property timestamp $updated_at
 * @property IntermentBooking $IntermentBooking
 * 
 * @method integer               getId()                             Returns the current record's "id" value
 * @method integer               getIntermentBookingId()             Returns the current record's "interment_booking_id" value
 * @method string                getFileLocation()                   Returns the current record's "file_location" value
 * @method enum                  getCemeteryApplication()            Returns the current record's "cemetery_application" value
 * @method enum                  getBurialBookingForm()              Returns the current record's "burial_booking_form" value
 * @method enum                  getAshesBookingForm()               Returns the current record's "ashes_booking_form" value
 * @method enum                  getExhumationBookingFrom()          Returns the current record's "exhumation_booking_from" value
 * @method enum                  getRemainsBookingFrom()             Returns the current record's "remains_booking_from" value
 * @method enum                  getHealthOrder()                    Returns the current record's "health_order" value
 * @method enum                  getCourtOrder()                     Returns the current record's "court_order" value
 * @method enum                  getCheckedFndDetails()              Returns the current record's "checked_fnd_details" value
 * @method enum                  getCheckedOwnerGrave()              Returns the current record's "checked_owner_grave" value
 * @method enum                  getLivingGraveOwner()               Returns the current record's "living_grave_owner" value
 * @method enum                  getDeceasedGraveOwner()             Returns the current record's "deceased_grave_owner" value
 * @method enum                  getCeckedChapelBooking()            Returns the current record's "cecked_chapel_booking" value
 * @method enum                  getAdvisedFdToCheck()               Returns the current record's "advised_fd_to_check" value
 * @method enum                  getAdvisedFdRecommended()           Returns the current record's "advised_fd_recommended" value
 * @method enum                  getAdvisedFdCoffinHeight()          Returns the current record's "advised_fd_coffin_height" value
 * @method enum                  getMedicalDeathCertificate()        Returns the current record's "medical_death_certificate" value
 * @method enum                  getMedicalCertificateSpelling()     Returns the current record's "medical_certificate_spelling" value
 * @method enum                  getMedicalCertificateInfectious()   Returns the current record's "medical_certificate_infectious" value
 * @method enum                  getRequestProbeReopen()             Returns the current record's "request_probe_reopen" value
 * @method enum                  getRequestTripleDepthReopen()       Returns the current record's "request_triple_depth_reopen" value
 * @method enum                  getCheckedMonumental()              Returns the current record's "checked_monumental" value
 * @method enum                  getContactedStonemason()            Returns the current record's "contacted_stonemason" value
 * @method enum                  getCheckedAccessories()             Returns the current record's "checked_accessories" value
 * @method enum                  getBalloonsNa()                     Returns the current record's "balloons_na" value
 * @method enum                  getBurningDrum()                    Returns the current record's "burning_drum" value
 * @method enum                  getCanopy()                         Returns the current record's "canopy" value
 * @method enum                  getCeremonialSandBucket()           Returns the current record's "ceremonial_sand_bucket" value
 * @method enum                  getFireworks()                      Returns the current record's "fireworks" value
 * @method enum                  getLoweringDevice()                 Returns the current record's "lowering_device" value
 * @method enum                  getCheckedReturnedSigned()          Returns the current record's "checked_returned_signed" value
 * @method enum                  getCheckCoffinSizesSurcharge()      Returns the current record's "check_coffin_sizes_surcharge" value
 * @method enum                  getSurchargeApplied()               Returns the current record's "surcharge_applied" value
 * @method enum                  getCompareBurialBooking()           Returns the current record's "compare_burial_booking" value
 * @method enum                  getForBetweenBurials()              Returns the current record's "for_between_burials" value
 * @method enum                  getDoubleCheckYellowDate()          Returns the current record's "double_check_yellow_date" value
 * @method string                getOther()                          Returns the current record's "other" value
 * @method timestamp             getCreatedAt()                      Returns the current record's "created_at" value
 * @method timestamp             getUpdatedAt()                      Returns the current record's "updated_at" value
 * @method IntermentBooking      getIntermentBooking()               Returns the current record's "IntermentBooking" value
 * @method IntermentBookingThree setId()                             Sets the current record's "id" value
 * @method IntermentBookingThree setIntermentBookingId()             Sets the current record's "interment_booking_id" value
 * @method IntermentBookingThree setFileLocation()                   Sets the current record's "file_location" value
 * @method IntermentBookingThree setCemeteryApplication()            Sets the current record's "cemetery_application" value
 * @method IntermentBookingThree setBurialBookingForm()              Sets the current record's "burial_booking_form" value
 * @method IntermentBookingThree setAshesBookingForm()               Sets the current record's "ashes_booking_form" value
 * @method IntermentBookingThree setExhumationBookingFrom()          Sets the current record's "exhumation_booking_from" value
 * @method IntermentBookingThree setRemainsBookingFrom()             Sets the current record's "remains_booking_from" value
 * @method IntermentBookingThree setHealthOrder()                    Sets the current record's "health_order" value
 * @method IntermentBookingThree setCourtOrder()                     Sets the current record's "court_order" value
 * @method IntermentBookingThree setCheckedFndDetails()              Sets the current record's "checked_fnd_details" value
 * @method IntermentBookingThree setCheckedOwnerGrave()              Sets the current record's "checked_owner_grave" value
 * @method IntermentBookingThree setLivingGraveOwner()               Sets the current record's "living_grave_owner" value
 * @method IntermentBookingThree setDeceasedGraveOwner()             Sets the current record's "deceased_grave_owner" value
 * @method IntermentBookingThree setCeckedChapelBooking()            Sets the current record's "cecked_chapel_booking" value
 * @method IntermentBookingThree setAdvisedFdToCheck()               Sets the current record's "advised_fd_to_check" value
 * @method IntermentBookingThree setAdvisedFdRecommended()           Sets the current record's "advised_fd_recommended" value
 * @method IntermentBookingThree setAdvisedFdCoffinHeight()          Sets the current record's "advised_fd_coffin_height" value
 * @method IntermentBookingThree setMedicalDeathCertificate()        Sets the current record's "medical_death_certificate" value
 * @method IntermentBookingThree setMedicalCertificateSpelling()     Sets the current record's "medical_certificate_spelling" value
 * @method IntermentBookingThree setMedicalCertificateInfectious()   Sets the current record's "medical_certificate_infectious" value
 * @method IntermentBookingThree setRequestProbeReopen()             Sets the current record's "request_probe_reopen" value
 * @method IntermentBookingThree setRequestTripleDepthReopen()       Sets the current record's "request_triple_depth_reopen" value
 * @method IntermentBookingThree setCheckedMonumental()              Sets the current record's "checked_monumental" value
 * @method IntermentBookingThree setContactedStonemason()            Sets the current record's "contacted_stonemason" value
 * @method IntermentBookingThree setCheckedAccessories()             Sets the current record's "checked_accessories" value
 * @method IntermentBookingThree setBalloonsNa()                     Sets the current record's "balloons_na" value
 * @method IntermentBookingThree setBurningDrum()                    Sets the current record's "burning_drum" value
 * @method IntermentBookingThree setCanopy()                         Sets the current record's "canopy" value
 * @method IntermentBookingThree setCeremonialSandBucket()           Sets the current record's "ceremonial_sand_bucket" value
 * @method IntermentBookingThree setFireworks()                      Sets the current record's "fireworks" value
 * @method IntermentBookingThree setLoweringDevice()                 Sets the current record's "lowering_device" value
 * @method IntermentBookingThree setCheckedReturnedSigned()          Sets the current record's "checked_returned_signed" value
 * @method IntermentBookingThree setCheckCoffinSizesSurcharge()      Sets the current record's "check_coffin_sizes_surcharge" value
 * @method IntermentBookingThree setSurchargeApplied()               Sets the current record's "surcharge_applied" value
 * @method IntermentBookingThree setCompareBurialBooking()           Sets the current record's "compare_burial_booking" value
 * @method IntermentBookingThree setForBetweenBurials()              Sets the current record's "for_between_burials" value
 * @method IntermentBookingThree setDoubleCheckYellowDate()          Sets the current record's "double_check_yellow_date" value
 * @method IntermentBookingThree setOther()                          Sets the current record's "other" value
 * @method IntermentBookingThree setCreatedAt()                      Sets the current record's "created_at" value
 * @method IntermentBookingThree setUpdatedAt()                      Sets the current record's "updated_at" value
 * @method IntermentBookingThree setIntermentBooking()               Sets the current record's "IntermentBooking" value
 * 
 * @package    cemetery
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseIntermentBookingThree extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('interment_booking_three');
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
        $this->hasColumn('file_location', 'string', 255, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => 255,
             ));
        $this->hasColumn('cemetery_application', 'enum', 9, array(
             'type' => 'enum',
             'fixed' => 0,
             'unsigned' => false,
             'values' => 
             array(
              0 => 'Completed',
              1 => 'Pending',
              2 => 'NA',
             ),
             'primary' => false,
             'default' => 'NA',
             'notnull' => true,
             'autoincrement' => false,
             'length' => 9,
             ));
        $this->hasColumn('burial_booking_form', 'enum', 9, array(
             'type' => 'enum',
             'fixed' => 0,
             'unsigned' => false,
             'values' => 
             array(
              0 => 'Completed',
              1 => 'Pending',
              2 => 'NA',
             ),
             'primary' => false,
             'default' => 'NA',
             'notnull' => true,
             'autoincrement' => false,
             'length' => 9,
             ));
        $this->hasColumn('ashes_booking_form', 'enum', 9, array(
             'type' => 'enum',
             'fixed' => 0,
             'unsigned' => false,
             'values' => 
             array(
              0 => 'Completed',
              1 => 'Pending',
              2 => 'NA',
             ),
             'primary' => false,
             'default' => 'NA',
             'notnull' => true,
             'autoincrement' => false,
             'length' => 9,
             ));
        $this->hasColumn('exhumation_booking_from', 'enum', 9, array(
             'type' => 'enum',
             'fixed' => 0,
             'unsigned' => false,
             'values' => 
             array(
              0 => 'Completed',
              1 => 'Pending',
              2 => 'NA',
             ),
             'primary' => false,
             'default' => 'NA',
             'notnull' => true,
             'autoincrement' => false,
             'length' => 9,
             ));
        $this->hasColumn('remains_booking_from', 'enum', 9, array(
             'type' => 'enum',
             'fixed' => 0,
             'unsigned' => false,
             'values' => 
             array(
              0 => 'Completed',
              1 => 'Pending',
              2 => 'NA',
             ),
             'primary' => false,
             'default' => 'NA',
             'notnull' => true,
             'autoincrement' => false,
             'length' => 9,
             ));
        $this->hasColumn('health_order', 'enum', 9, array(
             'type' => 'enum',
             'fixed' => 0,
             'unsigned' => false,
             'values' => 
             array(
              0 => 'Completed',
              1 => 'Pending',
              2 => 'NA',
             ),
             'primary' => false,
             'default' => 'NA',
             'notnull' => true,
             'autoincrement' => false,
             'length' => 9,
             ));
        $this->hasColumn('court_order', 'enum', 9, array(
             'type' => 'enum',
             'fixed' => 0,
             'unsigned' => false,
             'values' => 
             array(
              0 => 'Completed',
              1 => 'Pending',
              2 => 'NA',
             ),
             'primary' => false,
             'default' => 'NA',
             'notnull' => true,
             'autoincrement' => false,
             'length' => 9,
             ));
        $this->hasColumn('checked_fnd_details', 'enum', 9, array(
             'type' => 'enum',
             'fixed' => 0,
             'unsigned' => false,
             'values' => 
             array(
              0 => 'Completed',
              1 => 'Pending',
              2 => 'NA',
             ),
             'primary' => false,
             'default' => 'NA',
             'notnull' => true,
             'autoincrement' => false,
             'length' => 9,
             ));
        $this->hasColumn('checked_owner_grave', 'enum', 9, array(
             'type' => 'enum',
             'fixed' => 0,
             'unsigned' => false,
             'values' => 
             array(
              0 => 'Completed',
              1 => 'Pending',
              2 => 'NA',
             ),
             'primary' => false,
             'default' => 'NA',
             'notnull' => true,
             'autoincrement' => false,
             'length' => 9,
             ));
        $this->hasColumn('living_grave_owner', 'enum', 9, array(
             'type' => 'enum',
             'fixed' => 0,
             'unsigned' => false,
             'values' => 
             array(
              0 => 'Completed',
              1 => 'Pending',
              2 => 'NA',
             ),
             'primary' => false,
             'default' => 'NA',
             'notnull' => true,
             'autoincrement' => false,
             'length' => 9,
             ));
        $this->hasColumn('deceased_grave_owner', 'enum', 9, array(
             'type' => 'enum',
             'fixed' => 0,
             'unsigned' => false,
             'values' => 
             array(
              0 => 'Completed',
              1 => 'Pending',
              2 => 'NA',
             ),
             'primary' => false,
             'default' => 'NA',
             'notnull' => true,
             'autoincrement' => false,
             'length' => 9,
             ));
        $this->hasColumn('cecked_chapel_booking', 'enum', 9, array(
             'type' => 'enum',
             'fixed' => 0,
             'unsigned' => false,
             'values' => 
             array(
              0 => 'Completed',
              1 => 'Pending',
              2 => 'NA',
             ),
             'primary' => false,
             'default' => 'NA',
             'notnull' => true,
             'autoincrement' => false,
             'length' => 9,
             ));
        $this->hasColumn('advised_fd_to_check', 'enum', 9, array(
             'type' => 'enum',
             'fixed' => 0,
             'unsigned' => false,
             'values' => 
             array(
              0 => 'Completed',
              1 => 'Pending',
              2 => 'NA',
             ),
             'primary' => false,
             'default' => 'NA',
             'notnull' => true,
             'autoincrement' => false,
             'length' => 9,
             ));
        $this->hasColumn('advised_fd_recommended', 'enum', 9, array(
             'type' => 'enum',
             'fixed' => 0,
             'unsigned' => false,
             'values' => 
             array(
              0 => 'Completed',
              1 => 'Pending',
              2 => 'NA',
             ),
             'primary' => false,
             'default' => 'NA',
             'notnull' => true,
             'autoincrement' => false,
             'length' => 9,
             ));
        $this->hasColumn('advised_fd_coffin_height', 'enum', 9, array(
             'type' => 'enum',
             'fixed' => 0,
             'unsigned' => false,
             'values' => 
             array(
              0 => 'Completed',
              1 => 'Pending',
              2 => 'NA',
             ),
             'primary' => false,
             'default' => 'NA',
             'notnull' => true,
             'autoincrement' => false,
             'length' => 9,
             ));
        $this->hasColumn('medical_death_certificate', 'enum', 9, array(
             'type' => 'enum',
             'fixed' => 0,
             'unsigned' => false,
             'values' => 
             array(
              0 => 'Completed',
              1 => 'Pending',
              2 => 'NA',
             ),
             'primary' => false,
             'default' => 'NA',
             'notnull' => true,
             'autoincrement' => false,
             'length' => 9,
             ));
        $this->hasColumn('medical_certificate_spelling', 'enum', 9, array(
             'type' => 'enum',
             'fixed' => 0,
             'unsigned' => false,
             'values' => 
             array(
              0 => 'Completed',
              1 => 'Pending',
              2 => 'NA',
             ),
             'primary' => false,
             'default' => 'NA',
             'notnull' => true,
             'autoincrement' => false,
             'length' => 9,
             ));
        $this->hasColumn('medical_certificate_infectious', 'enum', 9, array(
             'type' => 'enum',
             'fixed' => 0,
             'unsigned' => false,
             'values' => 
             array(
              0 => 'Completed',
              1 => 'Pending',
              2 => 'NA',
             ),
             'primary' => false,
             'default' => 'NA',
             'notnull' => true,
             'autoincrement' => false,
             'length' => 9,
             ));
        $this->hasColumn('request_probe_reopen', 'enum', 9, array(
             'type' => 'enum',
             'fixed' => 0,
             'unsigned' => false,
             'values' => 
             array(
              0 => 'Completed',
              1 => 'Pending',
              2 => 'NA',
             ),
             'primary' => false,
             'default' => 'NA',
             'notnull' => true,
             'autoincrement' => false,
             'length' => 9,
             ));
        $this->hasColumn('request_triple_depth_reopen', 'enum', 9, array(
             'type' => 'enum',
             'fixed' => 0,
             'unsigned' => false,
             'values' => 
             array(
              0 => 'Completed',
              1 => 'Pending',
              2 => 'NA',
             ),
             'primary' => false,
             'default' => 'NA',
             'notnull' => true,
             'autoincrement' => false,
             'length' => 9,
             ));
        $this->hasColumn('checked_monumental', 'enum', 9, array(
             'type' => 'enum',
             'fixed' => 0,
             'unsigned' => false,
             'values' => 
             array(
              0 => 'Completed',
              1 => 'Pending',
              2 => 'NA',
             ),
             'primary' => false,
             'default' => 'NA',
             'notnull' => true,
             'autoincrement' => false,
             'length' => 9,
             ));
        $this->hasColumn('contacted_stonemason', 'enum', 9, array(
             'type' => 'enum',
             'fixed' => 0,
             'unsigned' => false,
             'values' => 
             array(
              0 => 'Completed',
              1 => 'Pending',
              2 => 'NA',
             ),
             'primary' => false,
             'default' => 'NA',
             'notnull' => true,
             'autoincrement' => false,
             'length' => 9,
             ));
        $this->hasColumn('checked_accessories', 'enum', 9, array(
             'type' => 'enum',
             'fixed' => 0,
             'unsigned' => false,
             'values' => 
             array(
              0 => 'Completed',
              1 => 'Pending',
              2 => 'NA',
             ),
             'primary' => false,
             'default' => 'NA',
             'notnull' => true,
             'autoincrement' => false,
             'length' => 9,
             ));
        $this->hasColumn('balloons_na', 'enum', 9, array(
             'type' => 'enum',
             'fixed' => 0,
             'unsigned' => false,
             'values' => 
             array(
              0 => 'Completed',
              1 => 'Pending',
              2 => 'NA',
             ),
             'primary' => false,
             'default' => 'NA',
             'notnull' => true,
             'autoincrement' => false,
             'length' => 9,
             ));
        $this->hasColumn('burning_drum', 'enum', 9, array(
             'type' => 'enum',
             'fixed' => 0,
             'unsigned' => false,
             'values' => 
             array(
              0 => 'Completed',
              1 => 'Pending',
              2 => 'NA',
             ),
             'primary' => false,
             'default' => 'NA',
             'notnull' => true,
             'autoincrement' => false,
             'length' => 9,
             ));
        $this->hasColumn('canopy', 'enum', 9, array(
             'type' => 'enum',
             'fixed' => 0,
             'unsigned' => false,
             'values' => 
             array(
              0 => 'Completed',
              1 => 'Pending',
              2 => 'NA',
             ),
             'primary' => false,
             'default' => 'NA',
             'notnull' => true,
             'autoincrement' => false,
             'length' => 9,
             ));
        $this->hasColumn('ceremonial_sand_bucket', 'enum', 9, array(
             'type' => 'enum',
             'fixed' => 0,
             'unsigned' => false,
             'values' => 
             array(
              0 => 'Completed',
              1 => 'Pending',
              2 => 'NA',
             ),
             'primary' => false,
             'default' => 'NA',
             'notnull' => true,
             'autoincrement' => false,
             'length' => 9,
             ));
        $this->hasColumn('fireworks', 'enum', 9, array(
             'type' => 'enum',
             'fixed' => 0,
             'unsigned' => false,
             'values' => 
             array(
              0 => 'Completed',
              1 => 'Pending',
              2 => 'NA',
             ),
             'primary' => false,
             'default' => 'NA',
             'notnull' => true,
             'autoincrement' => false,
             'length' => 9,
             ));
        $this->hasColumn('lowering_device', 'enum', 9, array(
             'type' => 'enum',
             'fixed' => 0,
             'unsigned' => false,
             'values' => 
             array(
              0 => 'Completed',
              1 => 'Pending',
              2 => 'NA',
             ),
             'primary' => false,
             'default' => 'NA',
             'notnull' => true,
             'autoincrement' => false,
             'length' => 9,
             ));
        $this->hasColumn('checked_returned_signed', 'enum', 9, array(
             'type' => 'enum',
             'fixed' => 0,
             'unsigned' => false,
             'values' => 
             array(
              0 => 'Completed',
              1 => 'Pending',
              2 => 'NA',
             ),
             'primary' => false,
             'default' => 'NA',
             'notnull' => true,
             'autoincrement' => false,
             'length' => 9,
             ));
        $this->hasColumn('check_coffin_sizes_surcharge', 'enum', 9, array(
             'type' => 'enum',
             'fixed' => 0,
             'unsigned' => false,
             'values' => 
             array(
              0 => 'Completed',
              1 => 'Pending',
              2 => 'NA',
             ),
             'primary' => false,
             'default' => 'NA',
             'notnull' => true,
             'autoincrement' => false,
             'length' => 9,
             ));
        $this->hasColumn('surcharge_applied', 'enum', 9, array(
             'type' => 'enum',
             'fixed' => 0,
             'unsigned' => false,
             'values' => 
             array(
              0 => 'Completed',
              1 => 'Pending',
              2 => 'NA',
             ),
             'primary' => false,
             'default' => 'NA',
             'notnull' => true,
             'autoincrement' => false,
             'length' => 9,
             ));
        $this->hasColumn('compare_burial_booking', 'enum', 9, array(
             'type' => 'enum',
             'fixed' => 0,
             'unsigned' => false,
             'values' => 
             array(
              0 => 'Completed',
              1 => 'Pending',
              2 => 'NA',
             ),
             'primary' => false,
             'default' => 'NA',
             'notnull' => true,
             'autoincrement' => false,
             'length' => 9,
             ));
        $this->hasColumn('for_between_burials', 'enum', 9, array(
             'type' => 'enum',
             'fixed' => 0,
             'unsigned' => false,
             'values' => 
             array(
              0 => 'Completed',
              1 => 'Pending',
              2 => 'NA',
             ),
             'primary' => false,
             'default' => 'NA',
             'notnull' => true,
             'autoincrement' => false,
             'length' => 9,
             ));
        $this->hasColumn('double_check_yellow_date', 'enum', 9, array(
             'type' => 'enum',
             'fixed' => 0,
             'unsigned' => false,
             'values' => 
             array(
              0 => 'Completed',
              1 => 'Pending',
              2 => 'NA',
             ),
             'primary' => false,
             'default' => 'NA',
             'notnull' => true,
             'autoincrement' => false,
             'length' => 9,
             ));
        $this->hasColumn('other', 'string', null, array(
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
        $this->hasOne('IntermentBooking', array(
             'local' => 'interment_booking_id',
             'foreign' => 'id'));
    }
}