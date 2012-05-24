<?php


class ArPlotTable extends Doctrine_Table
{
    
    public static function getInstance()
    {
        return Doctrine_Core::getTable('ArPlot');
    }
	/**
	 * @todo Execute getPlotList function for get All Plot of Cementery Section Area
	 *
	 * @return criteria
	 */
	public function getPlotList($amExtraParameters = array(), $amSearch, $ssStatusCondition  = '')
    {
		$cemeteryid = sfContext::getInstance()->getUser()->getAttribute('cemeteryid');
		$isadmin = sfContext::getInstance()->getUser()->getAttribute('issuperadmin');		
        if(!is_array($amExtraParameters)) 
            return false;


		$oQueryArea = Doctrine_Query::create()->select("ar.area_name")
						->from("ArArea ar")
						->Where("ar.id = ap.ar_area_id");

		$oQuerySection = Doctrine_Query::create()->select("ars.section_name")
						->from("ArSection ars")
						->Where("ars.id = ap.ar_section_id");

		$oQueryRow = Doctrine_Query::create()->select("arw.row_name")
						->from("ArRow arw")
						->Where("arw.id = ap.ar_row_id");

        $omCriteria     = Doctrine_Query::create()
                            ->select('ap.id,ap.plot_name,ap.is_enabled, c.name as country_name, cem.name as cemetery_name,
							('.$oQueryArea->getDql().') as area_name, 
							('.$oQuerySection->getDql().') as section_name, 
							('.$oQueryRow->getDql().') as row_name 
							')
                            ->from('ArPlot ap')
                            ->innerJoin('ap.Country c')
                            ->innerJoin('ap.CemCemetery cem');
                            
							if($isadmin != 1)
								$omCriteria->where('ap.cem_cemetery_id = ?', $cemeteryid);

       return common::setCriteria($omCriteria, $amExtraParameters, $ssStatusCondition, $amSearch);

    }
	/**
	 * @todo Execute getPlotListAsPerArea function for get plot list as per country,cemetery,area,section and row wise
	 *
	 * @return array $asRowList
	 */
	public static function getPlotListAsPerArea($snCountryId, $snCemeteryId, $snAreaId, $snSectionId, $snRowId)
	{

		
		$snAreaId = ($snAreaId != '') ? 'ap.ar_area_id = '.$snAreaId : 'ap.ar_area_id IS NULL';
		$snSectionId = ($snSectionId != '') ? 'ap.ar_section_id = '.$snSectionId : 'ap.ar_section_id IS NULL';		
		$snRowId = ($snRowId != '') ? 'ap.ar_row_id = '.$snRowId : 'ap.ar_row_id IS NULL';
		
		
		

		$amPlotListAsPerSection = Doctrine_Query::create()
									->select('ap.*')
									->from('ArPlot ap')
									->where('ap.country_id = ?',$snCountryId)
									->andWhere('ap.cem_cemetery_id = ?',$snCemeteryId)
									->andWhere($snAreaId)
									->andWhere($snSectionId)
									->andWhere($snRowId)
									->fetchArray();

		$asPlotList = array();
		if(count($amPlotListAsPerSection) > 0)
		{
			foreach($amPlotListAsPerSection as $ssKey => $asResult)
				$asPlotList[$asResult['id']] = $asResult['plot_name'];
		}
		return $asPlotList;
	}
	
	/**
	 * @todo Execute getPlotName function for get Plot Name
	 *
	 * @return Plot name
	 */
    public static function getPlotName($id)
    {
		$o_ar_area = Doctrine::getTable('ArPlot')->find($id);
		if($o_ar_area)
			return $o_ar_area->getPlotName();
		return '';	
    }	
	/**
	 * @todo Execute getPlotIdAsPerCriteria function for get Plot id
	 *
	 * @return area name
	 */
    public static function getPlotIdAsPerCriteria($snCountryId, $snCemeteryId, $snAreaId, $snSectionId, $snRowId, $ssPlotName)
    {
		$snPlotId = '';
		
		// FOR CHECK PLOT IS EXISTS OR NOT AS PER CRITERIA.
		$ssAreaCriteria = ($snAreaId != '') ? 'pt.ar_area_id = '. $snAreaId : 'pt.ar_area_id IS NULL';
		$ssSectionCriteria = ($snAreaId != '') ? 'pt.ar_section_id = '. $snAreaId : 'pt.ar_section_id IS NULL';	
		$ssRowCriteria = ($snRowId != '') ? 'pt.ar_row_id = '. $snRowId : 'pt.ar_row_id IS NULL';		
		
		$amPlot = Doctrine_Query::create()
					->select('pt.id')
					->from('ArPlot pt')
					->where('pt.country_id = ?',$snCountryId)
					->andWhere('pt.cem_cemetery_id = ?',$snCemeteryId)
					->andWhere($ssAreaCriteria)
					->andWhere($ssSectionCriteria)
					->andWhere($ssRowCriteria)
					->andWhere('pt.plot_name = ?',$ssPlotName)
					->limit(1)
					->fetchArray();

		if(count($amPlot) > 0)
			$snPlotId = $amPlot[0]['id'];
		else
		{
			// BUILD DATA ARRAY FOR ADD NEW PLOT.
			$amBuildData = array(
								'country_id'		=> $snCountryId,
								'cem_cemetery_id'	=> $snCemeteryId,
								'ar_area_id'		=> $snAreaId,
								'ar_section_id'		=> $snSectionId,
								'ar_row_id'			=> $snRowId,
								'plot_name' 		=> $ssPlotName,
								'user_id' 			=> sfContext::getInstance()->getUser()->getAttribute('userid')
								);
			$snPlotId = ArPlot::savePlot($amBuildData);
		}
		return $snPlotId;
    }	
}
