<?php

class CemMailTable extends Doctrine_Table
{
    public static function getInstance()
    {
        return Doctrine_Core::getTable('CemMail');
    }
	/**
	 * @todo Execute getMails function for get Mails as per Mail Type.
	 *
	 * @return criteria
	 */
	public function getMails($amExtraParameters = array(), $amSearch, $ssStatusCondition  = '', $ssMailType)
    {
        if(!is_array($amExtraParameters)) 
            return false;

		$snCemeteryId = sfContext::getInstance()->getUser()->getAttribute('cemeteryid');
		$bIsAdmin = sfContext::getInstance()->getUser()->getAttribute('issuperadmin');
		
		$snUserId = sfContext::getInstance()->getUser()->getAttribute('userid');

   		// For Get From Email address
		$oFromEmail = Doctrine_Query::create()->select("sgu.email_address")
					->from("sfGuardUser sgu")
					->Where("sgu.id = cmu.from_user_id");
					
		// For Get To Email address
		$oToEmail = Doctrine_Query::create()->select("sgu1.email_address")
					->from("sfGuardUser sgu1")
					->Where("sgu1.id = cmu.to_user_id");

		$omCriteria	= Doctrine_Query::create()
					->select('cm.mail_subject, cem.mail_body, cm.mail_status, cm.created_at, 
							cmu.id, cmu.read_unread_status, cmu.to_email, cmu.mail_send_status,
							cmu.delete_status,cmu.from_user_id, cmu.to_user_id, 
							('.$oFromEmail->getDql().') as from_email,
							('.$oToEmail->getDql().') as to_email_address,
							')
					->from('CemMailUsers cmu')
					->innerJoin('cmu.CemMail cm');
		
					if($ssMailType == 'inbox')
					{
						$omCriteria->where('cmu.to_user_id = ?',$snUserId)
									->andWhere('cmu.from_user_id != ?',$snUserId)
									->andWhere('cmu.sent_status = 0')
									->andWhere('cmu.delete_status = 0');
					}
					if($ssMailType == 'sent')
					{
						$omCriteria->where('cmu.from_user_id = ?', $snUserId)
									->andWhere('cmu.to_user_id != ?', $snUserId)
									->andWhere('cmu.sent_status = 1')
									->andWhere('cmu.delete_status = 0');
									
					}
					if($ssMailType == 'trash')
					{
						$omCriteria->where('(cmu.to_user_id = '.$snUserId.' AND cmu.from_user_id != '.$snUserId.' AND cmu.sent_status = 0) OR (cmu.from_user_id = '.$snUserId.' AND cmu.to_user_id != '.$snUserId.' AND cmu.sent_status = 1)')
									->andWhere('cmu.delete_status = 1');
					}

		return common::setCriteria($omCriteria, $amExtraParameters, $ssStatusCondition, $amSearch);
    }
	/**
	 * @todo Execute getMails function for get Mails as per Mail Type.
	 *
	 * @return criteria
	 */
	public function getMailsDeails($snMailId)
    {
		$snUserId = sfContext::getInstance()->getUser()->getAttribute('userid');

   		// For Get From Email address
		$oFromEmail = Doctrine_Query::create()->select("sgu.email_address")
					->from("sfGuardUser sgu")
					->Where("sgu.id = cmu.from_user_id");

   		// For Get To Email address
		$oToEmail = Doctrine_Query::create()->select("sgu1.email_address")
					->from("sfGuardUser sgu1")
					->Where("sgu1.id = cmu.to_user_id");

		$amMailsDetails	= Doctrine_Query::create()
						->select('cmu.id, cmu.to_email, cm.mail_subject, cem.mail_body, cm.mail_status, cm.created_at, cm.mail_body,
								('.$oFromEmail->getDql().') as from_email_address,
								('.$oToEmail->getDql().') as to_email_address,
								')
						->from('CemMailUsers cmu')
						->innerJoin('cmu.CemMail cm')
						->where('cmu.cem_mail_id = ?',$snMailId)
						->andWhere('(cmu.from_user_id = '.$snUserId.' AND cmu.to_user_id != '.$snUserId.') OR (cmu.from_user_id != '.$snUserId.' AND cmu.to_user_id = '.$snUserId.')')
						->fetchArray();
						
		$asMailDetail = array();
		$ssToEmailAddress = '';
		if(count($amMailsDetails) > 0)
		{
			foreach($amMailsDetails as $asDataSet)
			{
				$ssToEmailAddress .= $asDataSet['to_email_address'].', ';

				$asMailDetail['from_email'] = $asDataSet['from_email_address'];
				$asMailDetail['to_email'] = trim($ssToEmailAddress,', ');
				$asMailDetail['other_to_email'] = $asDataSet['to_email'];
				$asMailDetail['mail_subject'] = $asDataSet['CemMail']['mail_subject'];
				$asMailDetail['mail_body'] = $asDataSet['CemMail']['mail_body'];
				$asMailDetail['sent_date'] = $asDataSet['CemMail']['created_at'];
			}
		}

		return $asMailDetail;
	}
}