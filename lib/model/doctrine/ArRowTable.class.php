<?php


class ArRowTable extends Doctrine_Table
{
    
    public static function getInstance()
    {
        return Doctrine_Core::getTable('ArRow');
    }
	/**
	 * @todo Execute getSectionList function for get All Sections of Cementery Area
	 *
	 * @return criteria
	 */
	public function getAreaRowList($amExtraParameters = array(), $amSearch, $ssStatusCondition  = '')
    {
		$cemeteryid = sfContext::getInstance()->getUser()->getAttribute('cemeteryid');
		$isadmin = sfContext::getInstance()->getUser()->getAttribute('issuperadmin');		
        if(!is_array($amExtraParameters)) 
            return false;

		$oQueryArea = Doctrine_Query::create()->select("ar.area_name")
						->from("ArArea ar")
						->Where("ar.id = arr.ar_area_id");

		$oSubquery = Doctrine_Query::create()->select("ars.section_name")
					->from("ArSection ars")
					->Where("ars.id = arr.ar_section_id");

        $omCriteria     = Doctrine_Query::create()
                            ->select('arr.id,arr.row_name,arr.is_enabled, c.name as country_name, cem.name as cemetery_name,
							('.$oQueryArea->getDql().') as area_name,
							('.$oSubquery->getDql().') as section_name
							')
                            ->from('ArRow arr')
                            ->innerJoin('arr.Country c')
                            ->innerJoin('arr.CemCemetery cem');
                            
							if($isadmin != 1) {
								$omCriteria->where('arr.cem_cemetery_id = ?', $cemeteryid);
							}												

       return common::setCriteria($omCriteria, $amExtraParameters, $ssStatusCondition, $amSearch);

    }
	/**
	 * @todo Execute getRowListAsPerSection function for get row list as per country,cemetery,area and section wise
	 *
	 * @return array $asRowList
	 */
	public static function getRowListAsPerSection($snCountryId, $snCemeteryId, $snAreaId, $snSectionId)
	{
		
		
		$snAreaId = ($snAreaId != '') ? 'arr.ar_area_id = '.$snAreaId : 'arr.ar_area_id IS NULL';
		$snSectionId = ($snSectionId != '') ? 'arr.ar_section_id = '.$snSectionId : 'arr.ar_section_id IS NULL';
		
		
		
		$amRowListAsPerSection = Doctrine_Query::create()
									->select('arr.*')
									->from('ArRow arr')
									->where('arr.country_id = ?',$snCountryId)
									->andWhere('arr.cem_cemetery_id = ?',$snCemeteryId)
									->andWhere($snAreaId)
									->andWhere($snSectionId)
									->fetchArray();

		$asRowList = array();
		if(count($amRowListAsPerSection) > 0)
		{
			foreach($amRowListAsPerSection as $ssKey => $asResult)
				$asRowList[$asResult['id']] = $asResult['row_name'];
		}
		return $asRowList;
	}
	
	/**
	 * @todo Execute getRowName function for get Row Name
	 *
	 * @return Row name
	 */
    public static function getRowName($id)
    {
		$o_ar_area = Doctrine::getTable('ArRow')->find($id);
		if($o_ar_area)
			return $o_ar_area->getRowName();
		return '';	
    }	
	/**
	 * @todo Execute getRowIdAsPerCriteria function for get Row id
	 *
	 * @return area name
	 */
    public static function getRowIdAsPerCriteria($snCountryId, $snCemeteryId, $snAreaId, $snSectionId, $ssRowName)
    {
		$snRowId = '';
		
		// FOR CHECK ROW IS EXISTS OR NOT AS PER CRITERIA.
		$ssAreaCriteria = ($snAreaId != '') ? 'rw.ar_area_id = '. $snAreaId : 'rw.ar_area_id IS NULL';		
		$ssSectionCriteria = ($snSectionId != '') ? 'rw.ar_section_id = '. $snSectionId : 'rw.ar_section_id IS NULL';		
		
		$amSection = Doctrine_Query::create()
					->select('rw.id')
					->from('ArRow rw')
					->where('rw.country_id = ?',$snCountryId)
					->andWhere('rw.cem_cemetery_id = ?',$snCemeteryId)
					->andWhere($ssAreaCriteria)
					->andWhere($ssSectionCriteria)
					->andWhere('rw.row_name = ?',$ssRowName)
					->limit(1)
					->fetchArray();

		if(count($amSection) > 0)
			$snRowId = $amSection[0]['id'];
		else
		{
			// BUILD DATA ARRAY FOR ADD NEW SECTION.
			$amBuildData = array(
								'country_id'		=> $snCountryId,
								'cem_cemetery_id'	=> $snCemeteryId,
								'ar_area_id'		=> $snAreaId,
								'ar_section_id'		=> $snSectionId,
								'row_name' 			=> $ssRowName,
								'user_id' 			=> sfContext::getInstance()->getUser()->getAttribute('userid')
								);
			$snRowId = ArRow::saveRow($amBuildData);
		}
		return $snRowId;
    }	
}
