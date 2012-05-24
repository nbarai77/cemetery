<?php


class LetterConfirmationTable extends Doctrine_Table
{
    
    public static function getInstance()
    {
        return Doctrine_Core::getTable('LetterConfirmation');
    }
	 /**
	 * @todo Execute checkForLetterExists function for check letter confirmation is exists or not.
	 *
	 * @return criteria
	 */
	public function checkForLetterExists($snBookingFiveId, $ssContentType)
    {
		$amLettersRecords = Doctrine_Query::create()
								->select('lc.*')
								->from('LetterConfirmation lc')
								->Where('lc.interment_booking_five_id = ?', $snBookingFiveId)
								->andWhere('lc.mail_content_type = ?', $ssContentType)
								->fetchArray();

		return $amLettersRecords;
	}
}