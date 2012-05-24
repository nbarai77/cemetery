<?php


class FacilityBookingTable extends Doctrine_Table
{
    
    public static function getInstance()
    {
        return Doctrine_Core::getTable('FacilityBooking');
    }
	/**
	 * @todo Execute getStoneMasonList function for get stone mason list
	 *
	 * @return criteria
	 */
	public function getFacilityBookingList($amExtraParameters = array(), $amSearch, $ssStatusCondition  = '')
    {
		$cemeteryid = sfContext::getInstance()->getUser()->getAttribute('cemeteryid');
		$isadmin = sfContext::getInstance()->getUser()->getAttribute('issuperadmin');		
        if(!is_array($amExtraParameters)) 
            return false;

        $omCriteria     = Doctrine_Query::create()
                            ->select('fb.id,fb.title,fb.surname,fb.first_name,fb.suburb_town,fb.email,fb.telephone,fb.receipt_number,fb.chapel,fb.room,fb.total,fb.is_finalized')
                            ->from('FacilityBooking fb');
							if($isadmin != 1) {
								$omCriteria->where('fb.cem_cemetery_id = ?', $cemeteryid);
							}					                            

       return common::setCriteria($omCriteria, $amExtraParameters, $ssStatusCondition, $amSearch);

    }
	
	/**
	 * @todo Execute getFacilityBookingInfo function for get Chapel/Room Booking details.
	 *
	 * @return criteria
	 */
	public function getFacilityBookingInfo($ssServiceDate, $ssFacility = '')
    {
		$oChapelQuery = Doctrine_Query::create()->select("GROUP_CONCAT(c.name separator ', ')")
						->from("CemChapel c")
						->where("FIND_IN_SET(c.id, f.cem_chapel_ids)");

		$oRoomQuery = Doctrine_Query::create()->select("GROUP_CONCAT(c2.name separator ', ')")
						->from("CemRoom as c2")
						->where("(FIND_IN_SET(c2.id, f.cem_room_ids))");

		 $omCriteria	= Doctrine_Query::create()
						->select('fb.id,fb.title as deceased_title, fb.surname as deceased_surname,fb.first_name as deceased_first_name, 
								  fb.chapel_time_from, fb.chapel_time_to, fb.room_time_from, fb.room_time_to,
								  ('.$oChapelQuery->getDql().') as chapel_types,
								  ('.$oRoomQuery->getDql().') as room_types
								')
						->from('FacilityBooking fb')
						->where(1);
						
					if($ssFacility == 'chapel')
						$omCriteria->andWhere('DATE_FORMAT(fb.chapel_time_from, "%Y-%m-%d") = ?', $ssServiceDate);

					if($ssFacility == 'room')
						$omCriteria->andWhere('DATE_FORMAT(fb.room_time_from, "%Y-%m-%d") = ?', $ssServiceDate);

		return $omCriteria->fetchArray();
	}
}
