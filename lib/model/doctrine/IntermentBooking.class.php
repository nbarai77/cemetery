<?php

/**
 * IntermentBooking
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    cemetery
 * @subpackage model
 * @author     Prakash Panchal
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class IntermentBooking extends BaseIntermentBooking
{
	public function setUp()
    { 
        parent::setUp();
        $this->actAs('Timestampable');
    }
	/**
	 * function updateBookingIsFinalised
	 * @todo Function update Interment Booking tables fields
	 * @static
	 * @param $snIdIntermentBooking = Interment Booking Id
	 */
	public static function updateBookingIsFinalised($snIdIntermentBooking, $ssIntermentDate, $snGraveId='',$snGranteeId='')
	{	
		$oQuery = Doctrine_Query::create()
				->update('IntermentBooking')
				->set('is_finalized','?',1)
				->set('interment_date','?', $ssIntermentDate)
				->set('user_id','?', sfContext::getInstance()->getUser()->getAttribute('userid'))
				->where('id = ?', $snIdIntermentBooking)
				->execute();

		// Update Grave status into grave table.
		if($snGraveId != '' && $snGraveId != 0) {
			if($snGranteeId != '' && $snGranteeId != 0) {
				ArGrave::updateGraveTableField('ar_grave_status_id', sfConfig::get('app_grave_status_to_be_investigated'), $snGraveId);
			}else {
				ArGrave::updateGraveTableField('ar_grave_status_id', sfConfig::get('app_grave_status_in_use'), $snGraveId);
			}
		}
	}
	/**
	 * @todo Execute deleteBookingRecords function for delete service booking as per cemetery
	 * related with deleted service booking.
	 *
	 */
	public static function deleteBookingRecords($anCemetery = array())
	{
		if(count($anCemetery) > 0) {
			$amGuardUser= Doctrine_Query::create()
				->delete()
				->from('IntermentBooking ib')
				->whereIn('ib.cem_cemetery_id',$anCemetery)
				->execute();
		}
	}	
	
	/**
	 * function saveIntermentRecord
	 * @todo Function add new interment record
	 * @static
	 * @param $amData = Interment insert data
	 */
	public static function saveIntermentRecord($amData)
	{
		$oInterment = new IntermentBooking();

		$oInterment->setCountryId($amData['country_id']);
		$oInterment->setCemCemeteryId($amData['cem_cemetery_id']);
		$oInterment->setArAreaId( ($amData['ar_area_id'] != '') ? $amData['ar_area_id'] : NULL);
		$oInterment->setArSectionId( ($amData['ar_section_id'] != '') ? $amData['ar_section_id'] : NULL);		
		$oInterment->setArRowId( ($amData['ar_row_id'] != '') ? $amData['ar_row_id'] : NULL);
		$oInterment->setArPlotId( ($amData['ar_plot_id'] != '') ? $amData['ar_plot_id'] : NULL);	
		$oInterment->setArGraveId($amData['ar_grave_id']);
		$oInterment->setDeceasedSurname($amData['deceased_surname']);
		$oInterment->setDeceasedFirstName($amData['deceased_first_name']);
		$oInterment->setIsFinalized(1);
		$oInterment->setIntermentDate($amData['interment_date']);
		$oInterment->setComment1($amData['comment1']);
		$oInterment->setComment2($amData['comment2']);
		$oInterment->setUserId(sfContext::getInstance()->getUser()->getAttribute('userid'));
		$oInterment->setCreatedAt(date('Y-m-d H:i:s'));
		$oInterment->setUpdatedAt(date('Y-m-d H:i:s'));

		$oInterment->save();
		$snIntermentId = $oInterment->getId();
		$snGraveId = $oInterment->getArGraveId();
		unset($oInterment);
		
		// SAVE INTERMENT DETAILS INTO FOUR STEP.
		$oIntermentFour = new IntermentBookingFour();
		$oIntermentFour->setIntermentBookingId($snIntermentId);
		$oIntermentFour->setControlNumber($amData['control_number']);
		$oIntermentFour->setDeceasedUsualAddress($amData['deceased_usual_address']);
		$oIntermentFour->setDeceasedAge($amData['deceased_age']);
		$oIntermentFour->setDeceasedDateOfDeath( $amData['deceased_date_of_death'] );
		
		$oIntermentFour->save();
		
		// UPDATE GRAVE STATUS WHILE ANY INTERMENT USE IT.
		ArGrave::updateGraveTableField('ar_grave_status_id',sfConfig::get('app_grave_status_in_use'),$snGraveId);		
		unset($oIntermentFour);
	}
	
}