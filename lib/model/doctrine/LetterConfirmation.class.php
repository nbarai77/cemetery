<?php

/**
 * LetterConfirmation
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    cemetery
 * @subpackage model
 * @author     Prakash Panchal
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class LetterConfirmation extends BaseLetterConfirmation
{
	/**
	 * function saveConfirmationDetails
	 * @todo Function add/update before letter confirmation with generate new token.
	 * @static
	 * @param $amData = Letter confirmation data
	 */
	public static function saveConfirmationDetails($amData, $ssAction='')
	{
		$bFlag = false;
		if($ssAction == 'new')
		{
			$oLetterConfirm = new LetterConfirmation();
			$oLetterConfirm->setIntermentBookingFiveId($amData['interment_booking_five_id']);
			$oLetterConfirm->setMailContentType($amData['mail_content_type']);
			$oLetterConfirm->setToken($amData['token']);
			$oLetterConfirm->save();

			$bFlag = true;
		}
		else
		{
			$oQuery = Doctrine_Query::create()
				->update('LetterConfirmation')
				->set('token','?', $amData['token'])
				->set('confirmed','?', $amData['confirmed'])
				->where('mail_content_type = ?', $amData['mail_content_type'])
				->andWhere('interment_booking_five_id = ?', $amData['interment_booking_five_id'])
				->execute();

			$bFlag = true;
		}
		
		return 	$bFlag;
	}
}
