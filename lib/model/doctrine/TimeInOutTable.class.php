<?php


class TimeInOutTable extends Doctrine_Table
{
    
    public static function getInstance()
    {
        return Doctrine_Core::getTable('TimeInOut');
    }
    /**
	 * @todo Execute getAllAwards function for get All Awards list
	 *
	 * @return array $asAwardsResult
	 */
    public function getAllDetail($snIdUser='')
    {
        if(!is_numeric($snIdUser) && $snIdUser == '') return false;
        
        $asTimeInResult = Doctrine_Query::create()
                            ->select('tio.*')
                            ->from('TimeInOut tio')
                            ->where('tio.user_id = ?', $snIdUser);
                            if(sfContext::getInstance()->getUser()->getAttribute('groupid') != sfConfig::get('app_cemrole_manager'))                            
                                $asTimeInResult->Andwhere('tio.task_date  = ?', date('Y-m-d'));                                
        return $asTimeInResult->fetchArray();
    }
    /**
	 * @todo Execute getAllAwards function for get All Awards list
	 *
	 * @return array $asAwardsResult
	 */
    public function getUserWeeklyAllDetail($snIdUser)
    {
       
        return $asTimeInResult = Doctrine_Query::create()
                            ->select('tio.*,dt.*')
                            ->from('TimeInOut tio')
                            ->leftjoin('tio.DayType dt')
                            ->where('tio.user_id = ?', $snIdUser)
                            ->AndWhere('tio.task_date <="'. date('Y-m-d').'"')
                            ->orderBy('tio.id asc')
                            ->limit(7)
                            ->fetchArray();	
    }
}