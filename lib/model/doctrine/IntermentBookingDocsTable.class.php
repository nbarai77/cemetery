<?php


class IntermentBookingDocsTable extends Doctrine_Table
{
    
    public static function getInstance()
    {
        return Doctrine_Core::getTable('IntermentBookingDocs');
    }
	/**
	 * @todo Execute getBookingDocs function for get Booking Docs as per Booking ID
	 *
	 * @return criteria
	 */
	public function getBookingDocs($amExtraParameters = array(), $amSearch, $ssStatusCondition  = '', $snBookingId)
    {
        if(!is_array($amExtraParameters)) 
            return false;

        $omCriteria	= Doctrine_Query::create()
					->select('ibd.*')
					->from('IntermentBookingDocs ibd')
					->where('ibd.interment_booking_id = ?', $snBookingId);

       return common::setCriteria($omCriteria, $amExtraParameters, $ssStatusCondition, $amSearch);
    }
	/**
	 * @todo Execute getBookingDocsAsPerIds function for get booking docs paths as per docs ids.
	 *
	 * @return criteria
	 */
	public function getBookingDocsAsPerIds($anDocsIds)
    {
		$amDocsInfo = Doctrine_Query::create()
							->select('ibd.id, ibd.file_path')
							->from("IntermentBookingDocs ibd")
							->whereIn("ibd.id",$anDocsIds)
							->fetchArray();
		return $amDocsInfo;
    }
}