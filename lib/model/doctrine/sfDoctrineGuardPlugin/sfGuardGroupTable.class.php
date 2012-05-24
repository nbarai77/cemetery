<?php


class sfGuardGroupTable extends PluginsfGuardGroupTable
{
    
    public function getsfGuardGroupList($amExtraParameters = array(), $amSearch, $ssStatusCondition  = '')
    {
        if(!is_array($amExtraParameters)) 
            return false;

        $omCriteria     = Doctrine_Query::create()
                            ->select('sf.*')
                            ->from('sfGuardGroup sf');

       return common::setCriteria($omCriteria, $amExtraParameters, $ssStatusCondition, $amSearch);

    }
    
	/**
	 * @todo Execute getAllGroups function for get All groups list
	 *
	 * @return array $asGroup
	 */
	public static function getAllGroups($snIdCountry = '')
	{
		$ssQuery = Doctrine_Query::create()
						->select('grp.*')
						->from('sfGuardGroup grp');
		$amGroups = $ssQuery->fetchArray();

		$asGroup = array();
		if(count($amGroups) > 0)
		{
			foreach($amGroups as $ssKey => $asResult)
				$asGroup[$asResult['id']] = $asResult['name'];
		}
		return $asGroup;
	}    
	
	/**
	 * @todo Execute getAllGroupsByUserRole function for get All groups list
	 *
	 * @return array $asGroup
	 */
	public static function getAllGroupsByUserRole()
	{
		
		$isadmin = sfContext::getInstance()->getUser()->getAttribute('issuperadmin');
		$groupid = sfContext::getInstance()->getUser()->getAttribute('groupid');
		
		
		$ssQuery = Doctrine_Query::create()
						->select('grp.*')
						->from('sfGuardGroup grp');
						if($isadmin != 1) {
							$ssQuery->where('grp.id = 3 or grp.id = 4 or grp.id = 5 or grp.id = 6 or grp.id = 7');
						}else {
							$ssQuery->andWhere('grp.id != 1');
						}
						
		$amGroups = $ssQuery->fetchArray();

		$asGroup = array();
		if(count($amGroups) > 0)
		{
			foreach($amGroups as $ssKey => $asResult)
				$asGroup[$asResult['id']] = $asResult['name'];
		}
		return $asGroup;
	} 	
	/**
	 * @todo Execute getAllGroups function for get All groups list
	 *
	 * @return array $asGroup
	 */
	public static function getGroupName($snIdGrp = '')
	{
		$oGuard = Doctrine::getTable('sfGuardGroup')->find($snIdGrp);
		
		return $oGuard->getName();
	}   	
    
}
