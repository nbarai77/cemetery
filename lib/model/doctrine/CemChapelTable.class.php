<?php


class CemChapelTable extends Doctrine_Table
{
    
    public static function getInstance()
    {
        return Doctrine_Core::getTable('CemChapel');
    }
	/**
	 * @todo Execute getChapelList function for get All chapels of cementries
	 *
	 * @return criteria
	 */
	public function getChapelList($amExtraParameters = array(), $amSearch, $ssStatusCondition  = '')
    {		
		$snCemeteryId = sfContext::getInstance()->getUser()->getAttribute('cemeteryid');
		$bIsadmin = sfContext::getInstance()->getUser()->getAttribute('issuperadmin');		
		
        if(!is_array($amExtraParameters)) 
            return false;

        $omCriteria = Doctrine_Query::create()
						->select('cc.id,cc.name, c.name as country_name, cem.name as cementery_name')
						->from('CemChapel cc')
						->innerJoin('cc.Country c')
						->innerJoin('cc.CemCemetery cem');
							
						if($bIsadmin != 1)
							$omCriteria->where('cem.id = ?', $snCemeteryId);

       return common::setCriteria($omCriteria, $amExtraParameters, $ssStatusCondition, $amSearch);
    }
	/**
	 * @todo Execute getCemChapelTypes function for get Chaple Type list as per cemetery
	 *
	 * @return array $asChapleTypes
	 */
	public static function getCemChapelTypes($amChapelIds = array(), $snCemeteryId = '')
	{
		$bIsAdmin = sfContext::getInstance()->getUser()->getAttribute('issuperadmin');
		$snCemeteryId = ($bIsAdmin != 1) ? sfContext::getInstance()->getUser()->getAttribute('cemeteryid') : $snCemeteryId;
		
		$ssQuery = Doctrine_Query::create()
						->select('cc.id,cc.name')
						->from('CemChapel cc')
						->where(1);
						
						if(count($amChapelIds) > 0)
							$ssQuery->andWhereIn('cc.id', $amChapelIds);
						
						if($snCemeteryId != '')
							$ssQuery->andWhere('cc.cem_cemetery_id = ?', $snCemeteryId);
			
		$amChapel = $ssQuery->fetchArray();

		$asChapleTypes = array();
		if(count($amChapel) > 0)
		{
			foreach($amChapel as $ssKey => $asResult)
				$asChapleTypes[$asResult['id']] = $asResult['name'];
		}
		return $asChapleTypes;
	}
	
	/**
	 * @todo Execute getCemChapelTypes function for get Chaple Type list as per cemetery
	 *
	 * @return array $asChapleTypes
	 */
	public static function getChapleName($amChapelIds = array())
	{
		$ssQuery = Doctrine_Query::create()
						->select('cc.id,cc.name')
						->from('CemChapel cc')
						->where(1);
						
						if(count($amChapelIds) > 0)
							$ssQuery->andWhereIn('cc.id', $amChapelIds);
						

			
		$amChapel = $ssQuery->fetchArray();

		$asChapleTypes = array();
		if(count($amChapel) > 0)
		{
			foreach($amChapel as $ssKey => $asResult)
				$asChapleTypes[] = $asResult['name'];
		}
		return implode(',',$asChapleTypes);
	}	
}
