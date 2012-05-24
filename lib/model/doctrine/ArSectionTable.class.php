<?php

class ArSectionTable extends Doctrine_Table
{
    
    public static function getInstance()
    {
        return Doctrine_Core::getTable('ArSection');
    }
	/**
	 * @todo Execute getSectionList function for get All Sections of Cementery Area
	 *
	 * @return criteria
	 */
	public function getSectionList($amExtraParameters = array(), $amSearch, $ssStatusCondition  = '')
    {
		$cemeteryid = sfContext::getInstance()->getUser()->getAttribute('cemeteryid');
		$isadmin = sfContext::getInstance()->getUser()->getAttribute('issuperadmin');
				
        if(!is_array($amExtraParameters)) 
            return false;

		$oSubquery = Doctrine_Query::create()->select("ar.area_code")
					->from("ArArea ar")
					->Where("ar.id = ars.ar_area_id");

        $omCriteria     = Doctrine_Query::create()
                            ->select('ars.id,ars.section_name, ars.section_code, ars.is_enabled, c.name as country_name, cem.name as cemetery_name,
							('.$oSubquery->getDql().') as area_code')
                            ->from('ArSection ars')
                            ->innerJoin('ars.Country c')
                            ->innerJoin('ars.CemCemetery cem');
                            
							if($isadmin != 1)
								$omCriteria->where('ars.cem_cemetery_id = ?', $cemeteryid);

       return common::setCriteria($omCriteria, $amExtraParameters, $ssStatusCondition, $amSearch);

    }
	/**
	 * @todo Execute getSectionListAsPerArea function for get all active section of cementries area
	 *
	 * @return array $amCementeryAreaSections
	 */
	public static function getSectionListAsPerArea($snCountryId, $snCemeteryId, $snAreaId)
	{
		$snAreaId = ($snAreaId != '') ? 'ars.ar_area_id = '.$snAreaId : 'ars.ar_area_id IS NULL';

		$amCementeryAreaSections = Doctrine_Query::create()
									->select('ars.*')
									->from('ArSection ars')
									->where('ars.country_id = ?',$snCountryId)
									->andWhere('ars.cem_cemetery_id = ?',$snCemeteryId)
									->andWhere($snAreaId)
									->fetchArray();
									
		$asSections = array();
		if(count($amCementeryAreaSections) > 0)
		{
			foreach($amCementeryAreaSections as $ssKey => $asResult)
				$asSections[$asResult['id']] = $asResult['section_name'];
		}
		return $asSections;
	}
	/**
	 * @todo Execute getSectionName function for get Section Name
	 *
	 * @return area name
	 */
    public static function getSectionName($id)
    {
		$o_ar_area = Doctrine::getTable('ArSection')->find($id);
		if($o_ar_area)
			return $o_ar_area->getSectionName();
		return '';	
    }
	/**
	 * @todo Execute getSectionIdAsPerCriteria function for get Section id
	 *
	 * @return area name
	 */
    public static function getSectionIdAsPerCriteria($snCountryId, $snCemeteryId, $snAreaId, $ssSectionCode)
    {
		$snSectionId = '';
		
		// FOR CHECK SECTION IS EXISTS OR NOT AS PER CRITERIA.
		$ssAreaCriteria = ($snAreaId != '') ? 'sc.ar_area_id = '. $snAreaId : 'sc.ar_area_id IS NULL';		
		$amSection = Doctrine_Query::create()
					->select('sc.id')
					->from('ArSection sc')
					->where('sc.country_id = ?',$snCountryId)
					->andWhere('sc.cem_cemetery_id = ?',$snCemeteryId)
					->andWhere($ssAreaCriteria)
					->andWhere('sc.section_code = ?',$ssSectionCode)
					->limit(1)
					->fetchArray();

		if(count($amSection) > 0)
			$snSectionId = $amSection[0]['id'];
		else
		{
			// BUILD DATA ARRAY FOR ADD NEW SECTION.
			$amBuildData = array(
								'country_id'		=> $snCountryId,
								'cem_cemetery_id'	=> $snCemeteryId,
								'ar_area_id'		=> $snAreaId,
								'section_code' 		=> $ssSectionCode,
								'section_name' 		=> $ssSectionCode,
								'user_id' 			=> sfContext::getInstance()->getUser()->getAttribute('userid')
								);
			$snSectionId = ArSection::saveSection($amBuildData);
		}
		return $snSectionId;
    }
}
