<?php


class CemStonemasonTable extends Doctrine_Table
{
    
    public static function getInstance()
    {
        return Doctrine_Core::getTable('CemStonemason');
    }
	/**
	 * @todo Execute getStoneMasonList function for get stone mason list
	 *
	 * @return criteria
	 */
	public function getStoneMasonList($amExtraParameters = array(), $amSearch, $ssStatusCondition  = '')
    {
		$cemeteryid = sfContext::getInstance()->getUser()->getAttribute('cemeteryid');
		$isadmin = sfContext::getInstance()->getUser()->getAttribute('issuperadmin');		
        if(!is_array($amExtraParameters)) 
            return false;

        $omCriteria     = Doctrine_Query::create()
                            ->select('cs.id, cs.company_name, cs.is_enabled, c.name as country_name, cem.name as cementery_name')
                            ->from('CemStonemason cs')
							->innerJoin('cs.Country c')
							->innerJoin('cs.CemCemetery cem');
							if($isadmin != 1) {
								$omCriteria->where('cs.cem_cemetery_id = ?', $cemeteryid);
							}							

       return common::setCriteria($omCriteria, $amExtraParameters, $ssStatusCondition, $amSearch);

    }
	/**
	 * @todo Execute getStoneMasonListByUserRole function for get All Stone Mason list
	 *
	 * @return array $asFnd
	 */
	public static function getStoneMasonListByUserRole()
	{
		$cemeteryid = sfContext::getInstance()->getUser()->getAttribute('cemeteryid');
		$isadmin = sfContext::getInstance()->getUser()->getAttribute('issuperadmin');
		
        /*$omCriteria     = Doctrine_Query::create()
                            ->select('cs.*,cem.name')
                            ->from('CemStonemason cs')
                            ->innerJoin('cs.CemCemetery cem');
							if($isadmin != 1) {
								$omCriteria->where('cs.cem_cemetery_id = ?', $cemeteryid);
							}	*/

							
        $omCriteria     = Doctrine_Query::create()
                            ->select('uc.*')
                            ->from('UserCemetery uc')
                            ->where('uc.group_id = 6');
							if($isadmin != 1) {
								$omCriteria->andWhere('uc.cem_cemetery_id = ?',$cemeteryid);
							}								
							
							
			
		$amStoneMason = $omCriteria->fetchArray();

		$asStoneMason = array();
		if(count($amStoneMason) > 0)
		{
			foreach($amStoneMason as $ssKey => $asResult)
				$asStoneMason[$asResult['id']] = $asResult['organisation'];
		}
		return $asStoneMason;
	}
}
