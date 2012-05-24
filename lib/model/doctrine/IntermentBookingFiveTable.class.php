<?php


class IntermentBookingFiveTable extends Doctrine_Table
{
    
    public static function getInstance()
    {
        return Doctrine_Core::getTable('IntermentBookingFive');
    }
    
    /**
	 * @todo Execute getMailContents function for get all Mail Content list
	 *
	 * @return array Criteria
	 */
    public function getIntermentBookingDetailLetterwise($snIntermentBookingId)
    {
        $omCriteria	= Doctrine_Query::create()
						->select('ibf.*,mc.id,mc.subject,mc.content,mc.content_type')
						->from('IntermentBookingFive ibf')
                        ->leftjoin('ibf.MailContent mc')
                        ->where('ibf.interment_booking_id = ?', $snIntermentBookingId);						

       return $omCriteria->fetchArray();
    }
    
}