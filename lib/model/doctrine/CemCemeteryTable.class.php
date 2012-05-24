<?php


class CemCemeteryTable extends Doctrine_Table
{
    
    public static function getInstance()
    {
        return Doctrine_Core::getTable('CemCemetery');
    }
	/**
	 * @todo Execute getAllCemeteries function for get All Cementeries list
	 *
	 * @return array $amCementeries
	 */
	public static function getAllCemeteries($snIdCountry = '', $snCemeteryId = '')
	{
		$ssQuery = Doctrine_Query::create()
						->select('cem.id,cem.country_id,cem.name')
						->from('CemCemetery cem');
						
					if($snIdCountry != '') {
						$ssQuery->where('cem.country_id = ?',$snIdCountry);
					}else {
						$ssQuery->where('cem.country_id > ?',0);	
					}
						
					if($snCemeteryId != '')
						$ssQuery->where('cem.id = ?',$snCemeteryId);
		
		$amCementeries = $ssQuery->orderBy('cem.name')->fetchArray();

		$asCementery = array();
		if(count($amCementeries) > 0)
		{
			foreach($amCementeries as $ssKey => $asResult)
				$asCementery[$asResult['id']] = $asResult['name'];
		}
		return (($snCemeteryId != '') ? $amCementeries : $asCementery);
	}
	
    public function getCemCemeteryList($amExtraParameters = array(), $amSearch, $ssStatusCondition  = '')
    {
        if(!is_array($amExtraParameters)) 
            return false;

		$userid = sfContext::getInstance()->getUser()->getAttribute('userid');
		$isadmin = sfContext::getInstance()->getUser()->getAttribute('issuperadmin');
		
		Doctrine::getTable('CemCemetery')->setAttribute(Doctrine_Core::ATTR_QUERY_LIMIT, Doctrine_Core::LIMIT_ROWS);
		
        $omCriteria     = Doctrine_Query::create()
                            ->select('cem.id, cem.name,cem.url,cem.is_enabled,c.name')
                            ->from('CemCemetery cem')
							->orderBy('cem.name')
                            ->innerJoin('cem.Country c');
							if($isadmin != 1) {
								$omCriteria->leftJoin('cem.UserCemetery uc');
								$omCriteria->where('uc.user_id = ?',$userid);
							}                            

       return common::setCriteria($omCriteria, $amExtraParameters, $ssStatusCondition, $amSearch);

    }   
    
	/**
	 * @todo Execute getAllCemeteriesByUserRole function for get All Cementeries list
	 *
	 * @return array $amCementeries
	 */
	public static function getAllCemeteriesByUserRole()
	{
		$userid = sfContext::getInstance()->getUser()->getAttribute('userid');
		$isadmin = sfContext::getInstance()->getUser()->getAttribute('issuperadmin');
		
		$ssQuery = Doctrine_Query::create()
						->select('cem.id,cem.country_id,cem.name')
						->from('CemCemetery cem')
						->orderBy('cem.name');
						
						if($isadmin != 1) {
							$ssQuery->leftJoin('cem.UserCemetery uc');
							$ssQuery->where('uc.user_id = ?',$userid);
						}
			
		$amCementeries = $ssQuery->fetchArray();

		$asCementery = array();
		if(count($amCementeries) > 0)
		{
			foreach($amCementeries as $ssKey => $asResult)
				$asCementery[$asResult['id']] = $asResult['name'];
		}
		return $asCementery;
	}
	/**
	 * @todo Execute getCemeteryName function
	 *
	 * @return array $amCementeries
	 */
	public static function getCemeteryName($snCemeteryId = '') 
	{
		$amCemetery = Doctrine_Query::create()
						->select('cem.name')
						->from('CemCemetery cem')
						->where('cem.id = ?',$snCemeteryId)
						->fetchArray();
						
		return (count($amCemetery) > 0) ? $amCemetery[0]['name'] : 'Interments';
	}
      	
	
}
