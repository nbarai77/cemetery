<?php


class GranteeLogsTable extends Doctrine_Table
{
    
    public static function getInstance()
    {
        return Doctrine_Core::getTable('GranteeLogs');
    }
	
	public function getGranteeLogsList($amExtraParameters = array(), $amSearch, $ssStatusCondition  = '')
    {
		$snCemeteryId = sfContext::getInstance()->getUser()->getAttribute('cemeteryid');
		
        if(!is_array($amExtraParameters)) 
            return false;

        $omCriteria     = Doctrine_Query::create()
                            ->select('gtl.*')
                            ->from('GranteeLogs gtl');

       return common::setCriteria($omCriteria, $amExtraParameters, $ssStatusCondition, $amSearch);

    } 
	public function getGranteeLogsForPDF($snSearchCemId, $snSearchUserId = '', $ssSearchOperationDate = '')
    {
		$snCemeteryId = ( !sfContext::getInstance()->getUser()->isSuperAdmin() ) ? sfContext::getInstance()->getUser()->getAttribute('cemeteryid') : $snSearchCemId;
		
		$oQueryName = Doctrine_Query::create()->select('CONCAT(sf.first_name," ",sf.last_name) as username')
						->from('sfGuardUser sf')
						->Where("sf.id = gtl.user_id");

		$omCriteria = Doctrine_Query::create()
					->select('gtl.*, ('.$oQueryName->getDql().') as username ')
					->from('GranteeLogs gtl')
					->where('gtl.cem_id = ?', $snCemeteryId);

					if($snSearchUserId != '')
						$omCriteria->andWhere('gtl.user_id = ?', $snSearchUserId);
					
					if($ssSearchOperationDate != '')
						$omCriteria->andWhere('DATE_FORMAT(gtl.operation_date, "%d-%m-%Y") = ?', $ssSearchOperationDate);
		
		return $omCriteria->orderBy('gtl.operation_date desc')->fetchArray();
	}
}