<?php

class MailContentTable extends Doctrine_Table
{
    
    public static function getInstance()
    {
        return Doctrine_Core::getTable('MailContent');
    }
	/**
	 * @todo Execute getMailContents function for get all Mail Content list
	 *
	 * @return array Criteria
	 */
    public function getMailContents($amExtraParameters = array(), $amSearch, $ssStatusCondition  = '', $snCemeteryId = '', $ssType)
    {
        if(!is_array($amExtraParameters)) 
            return false;

		$bIsAdmin = sfContext::getInstance()->getUser()->getAttribute('issuperadmin');
		$snCemeteryId = ($bIsAdmin) ? $snCemeteryId : sfContext::getInstance()->getUser()->getAttribute('cemeteryid');
		
        $omCriteria	= Doctrine_Query::create()
						->select('mc.id,mc.subject,mc.content')
						->from('MailContent mc')
						->where('mc.cem_cemetery_id = ?', $snCemeteryId)
						->andWhere('mc.type = ?', $ssType);

       return common::setCriteria($omCriteria, $amExtraParameters, $ssStatusCondition, $amSearch);

    }
    
    /**
	 * @todo Execute getMailContents function for get all Mail Content list
	 *
	 * @return array Criteria
	 */
    public function getMailContentsDetail($snCemeteryId = '', $ssType)
    {
        
		$bIsAdmin = sfContext::getInstance()->getUser()->getAttribute('issuperadmin');
		$snCemeteryId = ($bIsAdmin) ? $snCemeteryId : sfContext::getInstance()->getUser()->getAttribute('cemeteryid');
		
        $omCriteria	= Doctrine_Query::create()
						->select('mc.id,mc.subject,mc.content')
						->from('MailContent mc')                        
						->where('mc.cem_cemetery_id = ?', $snCemeteryId)
						->andWhere('mc.type = ?', $ssType);

       return $omCriteria->fetchArray();
    }
    
    /**
	 * @todo Execute getMailContentAsPerType function for get mail content as per content type
	 *
	 * @return criteria
	 */
	public function getMailContentAsPerType($ssContentType, $snCemeteryId='')
    {
		$omCriteria =  Doctrine_Query::create()
                            ->select('mc.*')
                            ->from('MailContent mc')
							->andWhere('mc.content_type = ?', $ssContentType);
							
						if($snCemeteryId != '')
							$omCriteria->andWhere('mc.cem_cemetery_id = ?', $snCemeteryId);
		
		return $omCriteria->fetchArray();
	}
	/**
	 * @todo Execute getDefaultMailContents function for get mail content as per content type
	 *
	 * @return criteria
	 */
	public function getDefaultMailContents($snCountryId = '',$snCemeteryId = '')	
    {
		// Check Mail Content is exists for cemetery or not
		$snCntMailContent =  Doctrine_Query::create()
                            ->select('mc.*')
                            ->from('MailContent mc')
							->andWhere('mc.country_id = ?', $snCountryId)
							->andWhere('mc.cem_cemetery_id = ?', $snCemeteryId)
							->count();

		if($snCntMailContent == 0)
		{
			$amMailContent = Doctrine_Query::create()
                            ->select('mc.*')
                            ->from('MailContent mc')
							->andWhere('mc.country_id IS NULL')
							->andWhere('mc.cem_cemetery_id IS NULL')
							->fetchArray();	

			MailContent::insertMailContentAsPerCemetery($snCountryId, $snCemeteryId, $amMailContent);
		}				
	}
	
}
