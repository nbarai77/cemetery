<?php


class IntermentBookingLogsTable extends Doctrine_Table
{
    
    public static function getInstance()
    {
        return Doctrine_Core::getTable('IntermentBookingLogs');
    }
	//=======================================================//
	// 					FOR BOOKING/INTERMENT LOG
	//=======================================================//
	
	public function getBookingLogsList($amExtraParameters = array(), $amSearch, $ssStatusCondition  = '')
    {
		$snCemeteryId = sfContext::getInstance()->getUser()->getAttribute('cemeteryid');
		
        if(!is_array($amExtraParameters)) 
            return false;

        $omCriteria     = Doctrine_Query::create()
                            ->select('ibl.*')
                            ->from('IntermentBookingLogs ibl');

       return common::setCriteria($omCriteria, $amExtraParameters, $ssStatusCondition, $amSearch);

    } 
	public function getBookingLogsForPDF($snSearchCemId, $snSearchUserId = '', $ssSearchOperationDate = '')
    {
		$snCemeteryId = ( !sfContext::getInstance()->getUser()->isSuperAdmin() ) ? sfContext::getInstance()->getUser()->getAttribute('cemeteryid') : $snSearchCemId;
		
		$oQueryName = Doctrine_Query::create()->select('CONCAT(sf.first_name," ",sf.last_name) as username')
						->from('sfGuardUser sf')
						->Where("sf.id = ibl.user_id");

		$omCriteria = Doctrine_Query::create()
					->select('ibl.*, ('.$oQueryName->getDql().') as username ')
					->from('IntermentBookingLogs ibl')
					->where('ibl.cem_id = ?', $snCemeteryId);

					if($snSearchUserId != '')
						$omCriteria->andWhere('ibl.user_id = ?', $snSearchUserId);
					
					if($ssSearchOperationDate != '')
						$omCriteria->andWhere('DATE_FORMAT(ibl.operation_date, "%d-%m-%Y") = ?', $ssSearchOperationDate);
		
		return $omCriteria->orderBy('ibl.operation_date desc')->fetchArray();
	}
}