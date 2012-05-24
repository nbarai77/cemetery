<?php


class GraveLogsTable extends Doctrine_Table
{   
    public static function getInstance()
    {
        return Doctrine_Core::getTable('GraveLogs');
    }
    
    public function getGraveLogsList($amExtraParameters = array(), $amSearch, $ssStatusCondition  = '')
    {
		$snCemeteryId = sfContext::getInstance()->getUser()->getAttribute('cemeteryid');
		
        if(!is_array($amExtraParameters)) 
            return false;

        $omCriteria     = Doctrine_Query::create()
                            ->select('grl.*')
                            ->from('GraveLogs grl');

       return common::setCriteria($omCriteria, $amExtraParameters, $ssStatusCondition, $amSearch);

    }
	public function getGraveLogsForPDF($snSearchCemId, $snSearchUserId = '', $ssSearchOperationDate = '')
    {
		$snCemeteryId = ( !sfContext::getInstance()->getUser()->isSuperAdmin() ) ? sfContext::getInstance()->getUser()->getAttribute('cemeteryid') : $snSearchCemId;
		
		$oQueryName = Doctrine_Query::create()->select('CONCAT(sf.first_name," ",sf.last_name) as username')
						->from('sfGuardUser sf')
						->Where("sf.id = grl.user_id");

		$omCriteria = Doctrine_Query::create()
					->select('grl.*, ('.$oQueryName->getDql().') as username')
					->from('GraveLogs grl')
					->where('grl.cem_id = ?', $snCemeteryId);

					if($snSearchUserId != '')
						$omCriteria->andWhere('grl.user_id = ?', $snSearchUserId);
					
					if($ssSearchOperationDate != '')
						$omCriteria->andWhere('DATE_FORMAT(grl.operation_date, "%d-%m-%Y") = ?', $ssSearchOperationDate);
		
		return $omCriteria->orderBy('grl.operation_date desc')->fetchArray();
	}
}
