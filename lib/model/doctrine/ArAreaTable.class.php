<?php


class ArAreaTable extends Doctrine_Table
{
    
    public static function getInstance()
    {
        return Doctrine_Core::getTable('ArArea');
    }	
	/**
	 * @todo Execute getArAreaList function for get All Area of cementries
	 *
	 * @return criteria
	 */
	public function getArAreaList($amExtraParameters = array(), $amSearch, $ssStatusCondition  = '')
    {
		
		$cemeteryid = sfContext::getInstance()->getUser()->getAttribute('cemeteryid');
		$isadmin = sfContext::getInstance()->getUser()->getAttribute('issuperadmin');		
		
        if(!is_array($amExtraParameters)) 
            return false;

        $omCriteria     = Doctrine_Query::create()
                            ->select('ar.id,ar.area_name,ar.is_enabled, ar.area_code, c.name as country_name, cem.name as cementery_name')
                            ->from('ArArea ar')
							->innerJoin('ar.Country c')
							->innerJoin('ar.CemCemetery cem');
							if($isadmin != 1) {
								$omCriteria->where('cem.id = ?', $cemeteryid);
							}
							

       return common::setCriteria($omCriteria, $amExtraParameters, $ssStatusCondition, $amSearch);

    }
	/**
	 * @todo Execute getAreaListAsPerCemetery function for get all active area as per cementries
	 *
	 * @return array $amCementeryArea
	 */
	public static function getAreaListAsPerCemetery($snCountryId, $snCemeteryId)
	{
		$amCementeryArea = Doctrine_Query::create()
							->select('ar.*')
							->from('ArArea ar')
							->where('ar.country_id = ?',$snCountryId)
							->andWhere('ar.cem_cemetery_id = ?',$snCemeteryId)
							->fetchArray();

		$asArea = array();
		if(count($amCementeryArea) > 0)
		{
			foreach($amCementeryArea as $ssKey => $asResult)
				$asArea[$asResult['id']] = $asResult['area_code'];
		}
		return $asArea;
	}
	/**
	 * @todo Execute getAreaName function for get Area Name
	 *
	 * @return area name
	 */
    public static function getAreaName($id)
    {
		$o_ar_area = Doctrine::getTable('ArArea')->find($id);
		if($o_ar_area)
			return $o_ar_area->getAreaName();
		return '';	
    }
	
	/**
	 * @todo Execute getAreaIdAsPerCriteria function for get Area id
	 *
	 * @return area name
	 */
    public static function getAreaIdAsPerCriteria($snCountryId, $snCemeteryId, $ssAreaCode)
    {
		$snAreaId = '';
		
		// FOR CHECK AREA IS EXISTS OR NOT AS PER CRITERIA.
		$amArea = Doctrine_Query::create()
					->select('ar.id')
					->from('ArArea ar')
					->where('ar.country_id = ?',$snCountryId)
					->andWhere('ar.cem_cemetery_id = ?',$snCemeteryId)
					->andWhere('ar.area_code = ?',$ssAreaCode)
					->limit(1)
					->fetchArray();

		if(count($amArea) > 0)
			$snAreaId = $amArea[0]['id'];
		else
		{
			// BUILD DATA ARRAY FOR ADD NEW AREA.
			$amBuildData = array(
								'country_id'		=> $snCountryId,
								'cem_cemetery_id'	=> $snCemeteryId,
								'area_code' 		=> $ssAreaCode,
								'area_name' 		=> $ssAreaCode,
								'user_id' 			=> sfContext::getInstance()->getUser()->getAttribute('userid')
								);
			$snAreaId = ArArea::saveArea($amBuildData);					
		}
		return $snAreaId;
    }	
	
}
