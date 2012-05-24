<?php


class CemRoomTable extends Doctrine_Table
{
    
    public static function getInstance()
    {
        return Doctrine_Core::getTable('CemRoom');
    }
	/**
	 * @todo Execute getRoomList function for get All rooms of cementries
	 *
	 * @return criteria
	 */
	public function getRoomList($amExtraParameters = array(), $amSearch, $ssStatusCondition  = '')
    {		
		$snCemeteryId = sfContext::getInstance()->getUser()->getAttribute('cemeteryid');
		$bIsadmin = sfContext::getInstance()->getUser()->getAttribute('issuperadmin');		
		
        if(!is_array($amExtraParameters)) 
            return false;

        $omCriteria = Doctrine_Query::create()
						->select('cr.id,cr.name, c.name as country_name, cem.name as cementery_name')
						->from('CemRoom cr')
						->innerJoin('cr.Country c')
						->innerJoin('cr.CemCemetery cem');
							
						if($bIsadmin != 1)
							$omCriteria->where('cr.cem_cemetery_id = ?', $snCemeteryId);

       return common::setCriteria($omCriteria, $amExtraParameters, $ssStatusCondition, $amSearch);
    }
	/**
	 * @todo Execute getCemRoomTypes function for get Room Type list as per cemetery
	 *
	 * @return array $asRoomTypes
	 */
	public static function getCemRoomTypes($amCemRoomIds = array(), $snCemeteryId = '')
	{
		$bIsAdmin = sfContext::getInstance()->getUser()->getAttribute('issuperadmin');
		$snCemeteryId = ($bIsAdmin != 1) ? sfContext::getInstance()->getUser()->getAttribute('cemeteryid') : $snCemeteryId;
		
		$ssQuery = Doctrine_Query::create()
						->select('cr.id,cr.name')
						->from('CemRoom cr')
						->where(1);
						
						if(count($amCemRoomIds) > 0)
							$ssQuery->andWhereIn('cr.id', $amCemRoomIds);
						
						if($snCemeteryId != '')
							$ssQuery->andWhere('cr.cem_cemetery_id = ?', $snCemeteryId);
		
		$amRooms = $ssQuery->fetchArray();

		$asRoomTypes = array();
		if(count($amRooms) > 0)
		{
			foreach($amRooms as $ssKey => $asResult)
				$asRoomTypes[$asResult['id']] = $asResult['name'];
		}
		return $asRoomTypes;
	}
	
	/**
	 * @todo Execute getCemChapelTypes function for get Chaple Type list as per cemetery
	 *
	 * @return array $asChapleTypes
	 */
	public static function getRoomName($amChapelIds = array())
	{
		$ssQuery = Doctrine_Query::create()
						->select('cc.id,cc.name')
						->from('CemRoom cc')
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
