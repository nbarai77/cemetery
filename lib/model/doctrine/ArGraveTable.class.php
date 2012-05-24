<?php

class ArGraveTable extends Doctrine_Table
{
    public static function getInstance()
    {
        return Doctrine_Core::getTable('ArGrave');
    }
	/**
	 * @todo Execute getGraveList function for get Grave list as per country,cemetery,area,section and plot
	 *
	 * @return criteria
	 */
	public function getGraveList($amExtraParameters = array(), $amSearch, $ssStatusCondition  = '', $searchResult = '')
    {
		
		$cemeteryid = sfContext::getInstance()->getUser()->getAttribute('cemeteryid');
		$isadmin = sfContext::getInstance()->getUser()->getAttribute('issuperadmin');		
        if(!is_array($amExtraParameters)) 
            return false;

		$oQueryArea = Doctrine_Query::create()->select("ar.area_code")
						->from("ArArea ar")
						->Where("ar.id = ag.ar_area_id");

		$oQuerySection = Doctrine_Query::create()->select("ars.section_code")
						->from("ArSection ars")
						->Where("ars.id = ag.ar_section_id");

		$oQueryRow = Doctrine_Query::create()->select("arw.row_name")
						->from("ArRow arw")
						->Where("arw.id = ag.ar_row_id");	

		$oQueryPlot = Doctrine_Query::create()->select("ap.plot_name")
						->from("ArPlot ap")
						->Where("ap.id = ag.ar_plot_id");

        $omCriteria     = Doctrine_Query::create()
                            ->select('gt.id, ag.id,ag.grave_number,ag.grave_image1, ag.grave_image2,ag.is_enabled,
							ag.country_id, ag.cem_cemetery_id, ag.ar_area_id, ag.ar_section_id, ag.ar_row_id, ag.ar_plot_id,
							ag.latitude, ag.longitude, c.name as country_name,cem.name as cemetery_name,cem.latitude as latcem, cem.longitude as longcem, 
							ags.grave_status as grave_status,
							('.$oQueryArea->getDql().') as area_name, 
							('.$oQuerySection->getDql().') as section_name, 
							('.$oQueryRow->getDql().') as row_name, 
							('.$oQueryPlot->getDql().') as plot_name')
                            ->from('ArGrave ag')
							->leftJoin('ag.Grantee gt')
							->leftJoin('ag.ArGraveStatus ags')
							->leftJoin('ag.Country c')							
							->leftJoin('ag.CemCemetery cem');

							if($searchResult != true) 
							{
								if($isadmin != 1)
									$omCriteria->where('ag.cem_cemetery_id = ?', $cemeteryid);
							}

       return common::setCriteria($omCriteria, $amExtraParameters, $ssStatusCondition, $amSearch);
    }
	/**
	 * @todo Execute getGraveListCount function for get total grave list count
	 *
	 * @return criteria
	 */
	public function getGraveListCount($amExtraParameters = array(), $amSearch, $ssStatusCondition  = '', $searchResult = '')
    {
		$cemeteryid = sfContext::getInstance()->getUser()->getAttribute('cemeteryid');
		$isadmin = sfContext::getInstance()->getUser()->getAttribute('issuperadmin');		
        if(!is_array($amExtraParameters)) 
            return false;
			
        $omCriteria     = Doctrine_Query::create()
                            ->select('COUNT(ag.id) as num_rows')
                            ->from('ArGrave ag');

							if($searchResult != true) 
							{
								if($isadmin != 1)
									$omCriteria->where('ag.cem_cemetery_id = ?', $cemeteryid);
							}

       return common::setCriteria($omCriteria, $amExtraParameters, $ssStatusCondition, $amSearch);
	}
    
    
	/**
	 * @todo Execute getGraveListPerSearch function for get Grave list as per country,cemetery,area,section and plot
	 *
	 * @return criteria
	 */
	public function getGraveListPerSearch($amExtraParameters = array(), $amSearch, $ssStatusCondition  = '', $searchResult = '')
    {
		$cemeteryid = sfContext::getInstance()->getUser()->getAttribute('cemeteryid');
		$isadmin = sfContext::getInstance()->getUser()->getAttribute('issuperadmin');		
        if(!is_array($amExtraParameters)) 
            return false;


		$oQueryArea = Doctrine_Query::create()->select("ar.area_code")
					->from("ArArea ar")
					->Where("ar.id = ag.ar_area_id");
					
		$oQuerySection = Doctrine_Query::create()->select("ars.section_code")
					->from("ArSection ars")
					->Where("ars.id = ag.ar_section_id");
						
		$oQueryRow = Doctrine_Query::create()->select("arr.row_name")
					->from("ArRow arr")
					->Where("arr.id = ag.ar_row_id");
											
		$oQueryPlot = Doctrine_Query::create()->select("ap.plot_name")
					->from("ArPlot ap")
					->Where("ap.id = ag.ar_plot_id");				

        $omCriteria     = Doctrine_Query::create()
                            ->select('ag.grave_number, ag.cem_cemetery_id, gt.id as gid, gt.grantee_details_id as grantee_details_id,  
									ags.grave_status as grave_status,
									('.$oQueryArea->getDql().') as area_name, 
									('.$oQuerySection->getDql().') as section_name, 
									('.$oQueryRow->getDql().') as row_name, 
									('.$oQueryPlot->getDql().') as plot_name,
							')
                            ->from('ArGrave ag')
							->leftJoin('ag.ArGraveStatus ags')
//							->innerJoin('ag.Country c')
//							->innerJoin('ag.CemCemetery cem')
							->leftJoin('ag.Grantee gt');

       return common::setCriteria($omCriteria, $amExtraParameters, $ssStatusCondition, $amSearch);
    }
	/**
	 * @todo Execute getGraveListPerSearch function for get Grave list as per country,cemetery,area,section and plot
	 *
	 * @return criteria
	 */
	public function getGraveListPerSearchCount($amExtraParameters = array(), $amSearch, $ssStatusCondition  = '', $searchResult = '')
    {
        if(!is_array($amExtraParameters)) 
            return false;
		
		$omCriteria     = Doctrine_Query::create()
                            ->select('COUNT(ag.id)')
                            ->from('ArGrave ag');

       return common::setCriteria($omCriteria, $amExtraParameters, $ssStatusCondition, $amSearch);		
    }
	
	/**
	 * @todo Execute getGraveListAsPerCriteria function for get grave list as per country,cemetery,area,section,row and plot wise
	 *
	 * @return array $asRowList
	 */
	public static function getGraveListAsPerCriteria($snCountryId, $snCemeteryId, $snAreaId, $snSectionId, $snRowId, $snPlotId, $ssMode='', $snGranteeId = '')
	{
		
		$snAreaId = ($snAreaId != '') ? 'ag.ar_area_id = '.$snAreaId : 'ag.ar_area_id IS NULL';
		$snSectionId = ($snSectionId != '') ? 'ag.ar_section_id = '.$snSectionId : 'ag.ar_section_id IS NULL';		
		$snRowId = ($snRowId != '') ? 'ag.ar_row_id = '.$snRowId : 'ag.ar_row_id IS NULL';		
		$snPlotId = ($snPlotId != '') ? 'ag.ar_plot_id = '.$snPlotId : 'ag.ar_plot_id IS NULL';		
		

		
		$ssQuery = Doctrine_Query::create()
					->select('ag.*')
					->from('ArGrave ag')
					->where('ag.country_id = ?',$snCountryId)
					->andWhere('ag.cem_cemetery_id = ?',$snCemeteryId)
					->andWhere($snAreaId)
					->andWhere($snSectionId)
					->andWhere($snRowId)
					->andWhere($snPlotId);

		if($ssMode == '' && $snGranteeId != '')
			$ssQuery->andWhere('ag.id NOT IN (SELECT gt.ar_grave_id FROM grantee gt WHERE gt.grantee_details_id = '.$snGranteeId.') ');
		
		$ssQuery->OrderBy('ag.grave_number asc');
		
		
		$amGraveListAsPerSection = $ssQuery->fetchArray();
		$asGraveList = array();
		if(count($amGraveListAsPerSection) > 0)
		{
			foreach($amGraveListAsPerSection as $ssKey => $asResult)
				$asGraveList[$asResult['id']] = $asResult['grave_number'];
		}
		return $asGraveList;
	}
	
	/**
	 * @todo Execute getGraveNumber function for get GraveNumber
	 *
	 * @return GraveNumber
	 */
    public static function getGraveNumber($id)
    {
		$o_ar_area = Doctrine::getTable('ArGrave')->find($id);
		if($o_ar_area)
			return $o_ar_area->getGraveNumber();
		return '';	
    }
	/**
	 * @todo Execute getGraveIdAsPerCriteria function for get Grave id
	 *
	 * @return area name
	 */
    public static function getGraveIdAsPerCriteria($snCountryId, $snCemeteryId, $snAreaId, $snSectionId, $snRowId, $snPlotId, $ssGraveNumber, $ssGraveComm1 = '', $ssGraveComm2 = '')
    {
		$snGraveId = '';
		
		// FOR CHECK GRAVE IS EXISTS OR NOT AS PER CRITERIA.
		$ssAreaCriteria = ($snAreaId != '') ? 'grv.ar_area_id = '.$snAreaId : 'grv.ar_area_id IS NULL';
		$ssSectionCriteria = ($snAreaId != '') ? 'grv.ar_section_id = '.$snSectionId : 'grv.ar_section_id IS NULL';	
		$ssRowCriteria = ($snRowId != '') ? 'grv.ar_row_id = '.$snRowId : 'grv.ar_row_id IS NULL';
		$ssPlotCriteria = ($snPlotId != '') ? 'grv.ar_plot_id = '.$snPlotId : 'grv.ar_plot_id IS NULL';		
		
		$amGrave = Doctrine_Query::create()
					->select('grv.id')
					->from('ArGrave grv')
					->where('grv.country_id = ?',$snCountryId)
					->andWhere('grv.cem_cemetery_id = ?',$snCemeteryId)
					->andWhere($ssAreaCriteria)
					->andWhere($ssSectionCriteria)
					->andWhere($ssRowCriteria)
					->andWhere($ssPlotCriteria)
					->andWhere('grv.grave_number = ?',$ssGraveNumber)
					->limit(1)
					->fetchArray();

		if(count($amGrave) > 0)
			$snGraveId = $amGrave[0]['id'];
		else
		{
			// BUILD DATA ARRAY FOR ADD NEW GRAVE.
			$amBuildData = array(
								'country_id'			=> $snCountryId,
								'cem_cemetery_id'		=> $snCemeteryId,
								'ar_area_id'			=> $snAreaId,
								'ar_section_id'			=> $snSectionId,
								'ar_row_id'				=> $snRowId,
								'ar_plot_id'			=> $snPlotId,
								'grave_number' 			=> $ssGraveNumber,
								'ar_grave_status_id'	=> sfConfig::get('app_grave_status_vacant'),
								'user_id' 				=> sfContext::getInstance()->getUser()->getAttribute('userid'),
								'comment1' 				=> $ssGraveComm1,
								'comment2' 				=> $ssGraveComm2,
								);
			$snGraveId = ArGrave::saveGrave($amBuildData);
		}
		return $snGraveId;
    }
	/**
	 * @todo Execute getAllGranteeAsPerGrave function for get grantee as per grave.
	 *
	 * @return array $amCementeryArea
	 */
	public function getAllGranteeAsPerGrave($snGraveId)
	{
		$amGranteeGraves	= Doctrine_Query::create()
								->select('ag.id, ag.grave_number, ags.grave_status as grave_status, arr.area_name as area_name,
										  sec.section_name as section_name, rw.row_name as row_name, ap.plot_name as plot_name,
										  gt.id, gt.date_of_purchase, gt.tenure_expiry_date, gd.title, CONCAT(gd.grantee_first_name," ",gd.grantee_surname) as grantee_name,gd.grantee_first_name,gd.grantee_middle_name,gd.grantee_surname,gd.grantee_address,gd.state,gd.town,gd.postal_code
										')					
								->from('ArGrave ag')
								->leftJoin('ag.ArArea arr')
								->leftJoin('ag.ArSection sec')
								->leftJoin('ag.ArRow rw')
								->leftJoin('ag.ArPlot ap')
								->leftJoin('ag.ArGraveStatus ags')
								->leftJoin('ag.Grantee gt')
								->leftJoin('gt.GranteeDetails gd')					
								->where('ag.id = ? ', $snGraveId)
								->fetchArray();

		return $amGranteeGraves;
	}
    
    //=======================================================//
	// 					FOR get count GRAVE/PLOT as section wise REPORT
	//=======================================================//
    /**
	 * @todo Execute getCountGraveStatusWise function FOR get count GRAVE/PLOT as section wise REPORT.
	 *
	 * @return criteria
	 */
    public function getCountGraveStatusWise($snCountryId,$snCemeteryId,$snAreaId,$snSectionId,$snStatusId)
    {
        return $snTotalCount =  Doctrine_Query::create()                                
								->from("ArGrave ag")								
								->Where('ag.country_id = ?', $snCountryId)
								->andWhere('ag.cem_cemetery_id = ?', $snCemeteryId)
								->andWhere('ag.ar_area_id = ?', $snAreaId)
                                ->andWhere('ag.ar_section_id = ?', $snSectionId)
                                ->andWhere('ag.ar_grave_status_id = ?', $snStatusId)
                                ->count();        
    }
    //=======================================================//
	// 					FOR GRAVE/PLOT REPORT
	//=======================================================//
    /**
	 * @todo Execute getGravePlotReports function for display grave details.
	 *
	 * @return criteria
	 */
    public function getGravePlotReports($snCountryId='', $snCemeteryId='', $snAreaId='', $ssFromDate = '', $ssToDate = '', $bByAreaSection = false, $bByAreaTotal = false)
    {     
		$ssFromTotDateCriteria 	= ($ssFromDate != '' && $ssToDate != '') ? "ag.updated_at >= '".$ssFromDate."' AND ag.updated_at <= '".$ssToDate."' " : '';
		
		///////////////////////////////////////////////////////
		// For get total count of grave as per grave status  //
		///////////////////////////////////////////////////////
		if($snAreaId == '')
		{
			$omCriteria = Doctrine_Query::create()->select("ags.id, ag.id, COUNT(ag.id), ags.grave_status, cem.name as cemetery_name, c.name as country_name")						
							->from("ArGraveStatus ags")
							->leftJoin('ags.ArGrave ag')
							->leftJoin('ag.CemCemetery cem')
							->leftJoin('cem.Country c')
							->groupBy('ags.id')							
							->where('ag.country_id = ?', $snCountryId)
							->andWhere('ag.cem_cemetery_id = ?', $snCemeteryId);
	
			if($ssFromTotDateCriteria != '')
				$omCriteria->andWhere($ssFromTotDateCriteria);
		}
		else		
		{           
			$omCriteria =  Doctrine_Query::create()
								->select('ag.id, ag.ar_area_id, ag.ar_section_id, ar.id, ar.area_name, sec.id, sec.section_name')
								->from("ArGrave ag")
								->leftJoin('ag.ArArea ar')
								->leftJoin('ag.ArSection sec')								    
								->Where('ag.country_id = ?', $snCountryId)
								->andWhere('ag.cem_cemetery_id = ?', $snCemeteryId)
								->andWhere('ag.ar_area_id = ?', $snAreaId);
                               

           if($bByAreaSection && !$bByAreaTotal)
			{
				$omCriteria->andWhere('ag.ar_section_id IS NOT NULL')
							->groupBy('ag.ar_section_id');
			}	

			if($bByAreaTotal && !$bByAreaSection)
				$omCriteria->groupBy('ag.ar_area_id');                                
		}
		return ( $snAreaId == '' || ($bByAreaTotal && !$bByAreaSection) ) ? $omCriteria->fetchArray() : $omCriteria; 	
    }
}