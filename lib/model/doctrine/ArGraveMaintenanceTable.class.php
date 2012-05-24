<?php


class ArGraveMaintenanceTable extends Doctrine_Table
{
    public static function getInstance()
    {
        return Doctrine_Core::getTable('ArGraveMaintenance');
    }
	/**
	 * @todo Execute getGraveMaintenanceList function for get Grave list as per country,cemetery,area,section and plot
	 *
	 * @return criteria
	 */
	public function getGraveMaintenanceList($amExtraParameters = array(), $amSearch, $ssStatusCondition  = '')
    {
	    if(!is_array($amExtraParameters)) 
            return false;

		$cemeteryid = sfContext::getInstance()->getUser()->getAttribute('cemeteryid');
		$isadmin = sfContext::getInstance()->getUser()->getAttribute('issuperadmin');		

		$oQueryArea = Doctrine_Query::create()->select("ar.area_code")
						->from("ArArea ar")
						->Where("ar.id = agm.ar_area_id");

		$oQuerySection = Doctrine_Query::create()->select("ars.section_code")
						->from("ArSection ars")
						->Where("ars.id = agm.ar_section_id");

		$oQueryRow = Doctrine_Query::create()->select("arw.row_name")
						->from("ArRow arw")
						->Where("arw.id = agm.ar_row_id");	

		$oQueryPlot = Doctrine_Query::create()->select("ap.plot_name")
						->from("ArPlot ap")
						->Where("ap.id = agm.ar_plot_id");

		$oQueryGrave = Doctrine_Query::create()->select("ag.grave_number")
						->from("ArGrave ag")
						->Where("ag.id = agm.ar_grave_id");

        $omCriteria     = Doctrine_Query::create()
                            ->select('agm.id,agm.date_paid,agm.amount_paid, agm.renewal_term, agm.renewal_date, 
							agm.interred_surname, agm.interred_name, agm.organization_name,agm.first_name,agm.surname,
							('.$oQueryArea->getDql().') as area_name, 
							('.$oQuerySection->getDql().') as section_name, 
							('.$oQueryRow->getDql().') as row_name, 
							('.$oQueryPlot->getDql().') as plot_name,
							('.$oQueryGrave->getDql().') as grave_number
							')
                            ->from('ArGraveMaintenance agm');
							
						if($isadmin != 1)
							$omCriteria->where('agm.cem_cemetery_id = ?', $cemeteryid);

       return common::setCriteria($omCriteria, $amExtraParameters, $ssStatusCondition, $amSearch);

    }
	/**
	 * @todo Execute getGranteeList function for get searched annual report.
	 *
	 * @return criteria
	 */
	public function getAnnualSearchList($amExtraParameters = array(), $amSearch, $ssStatusCondition  = '')
    {	
		$cemeteryid = sfContext::getInstance()->getUser()->getAttribute('cemeteryid');
		$isadmin = sfContext::getInstance()->getUser()->getAttribute('issuperadmin');	
			
        if(!is_array($amExtraParameters)) 
            return false;

		$oQueryArea = Doctrine_Query::create()->select("ar.area_code")
					->from("ArArea ar")
					->Where("ar.id = agm.ar_area_id");
					
		$oQuerySection = Doctrine_Query::create()->select("ars.section_code")
					->from("ArSection ars")
					->Where("ars.id = agm.ar_section_id");	

		$oQueryPlot = Doctrine_Query::create()->select("ap.plot_name")
					->from("ArPlot ap")
					->Where("ap.id = agm.ar_plot_id");	
					
		$oQueryRow = Doctrine_Query::create()->select("arw.row_name")
					->from("ArRow arw")
					->Where("arw.id = agm.ar_row_id");						
		
		$oQueryGrave = Doctrine_Query::create()->select("ag.grave_number")
					->from("ArGrave ag")
					->Where("ag.id = agm.ar_grave_id");

        $omCriteria	= Doctrine_Query::create()
					->select('agm.id,agm.date_paid, agm.amount_paid, agm.renewal_term, agm.renewal_date, agm.surname, agm.first_name, 
							('.$oQueryArea->getDql().') as area_name, 
							('.$oQuerySection->getDql().') as section_name, 
							('.$oQueryRow->getDql().') as row_name, 
							('.$oQueryPlot->getDql().') as plot_name,
							('.$oQueryGrave->getDql().') as grave_number,
							')
					->from('ArGraveMaintenance agm');
		
					if($isadmin != 1)
						$omCriteria->where('agm.cem_cemetery_id = ?', $cemeteryid);

       return common::setCriteria($omCriteria, $amExtraParameters, $ssStatusCondition, $amSearch);
    }
	/**
	 * @todo Execute getAnnualSearchListCount function for get total of searched annual report.
	 *
	 * @return criteria
	 */
	public function getAnnualSearchListCount($amExtraParameters = array(), $amSearch, $ssStatusCondition  = '')
    {	
		$snCemeteryId = sfContext::getInstance()->getUser()->getAttribute('cemeteryid');
		$bIsAdmin = sfContext::getInstance()->getUser()->getAttribute('issuperadmin');	

        if(!is_array($amExtraParameters))
            return false;
		
		$omCriteria	= Doctrine_Query::create()
			->select('COUNT(agm.id) as num_rows')
			->from('ArGraveMaintenance agm');

			if($bIsAdmin != 1)
				$omCriteria->where('agm.cem_cemetery_id = ?', $snCemeteryId);
	
	   return common::setCriteria($omCriteria, $amExtraParameters, $ssStatusCondition, $amSearch);
	}
	/**
	 * @todo Execute getAnnulaReport function for get annual report as per date range
	 *
	 * @return criteria
	 */
	public function getAnnulaReport($ssFromDate, $ssToDate)
    {	
		$cemeteryid = sfContext::getInstance()->getUser()->getAttribute('cemeteryid');
		$isadmin = sfContext::getInstance()->getUser()->getAttribute('issuperadmin');	

		$oQueryArea = Doctrine_Query::create()->select("ar.area_code")
					->from("ArArea ar")
					->Where("ar.id = agm.ar_area_id");
					
		$oQuerySection = Doctrine_Query::create()->select("ars.section_code")
					->from("ArSection ars")
					->Where("ars.id = agm.ar_section_id");	

		$oQueryPlot = Doctrine_Query::create()->select("ap.plot_name")
					->from("ArPlot ap")
					->Where("ap.id = agm.ar_plot_id");	
					
		$oQueryRow = Doctrine_Query::create()->select("arw.row_name")
					->from("ArRow arw")
					->Where("arw.id = agm.ar_row_id");
		
		$oQueryGrave = Doctrine_Query::create()->select("ag.grave_number")
					->from("ArGrave ag")
					->Where("ag.id = agm.ar_grave_id");

        $omCriteria	= Doctrine_Query::create()
					->select('agm.id,agm.date_paid, agm.renewal_term, agm.renewal_date, CONCAT(agm.interred_surname," ",agm.interred_name) as interred, agm.notes,							  
							('.$oQueryArea->getDql().') as area_name, 
							('.$oQuerySection->getDql().') as section_name, 
							('.$oQueryRow->getDql().') as row_name, 
							('.$oQueryPlot->getDql().') as plot_name,
							('.$oQueryGrave->getDql().') as grave_number
							')
					->from('ArGraveMaintenance agm')
					->where("agm.renewal_date >= '".$ssFromDate."' AND agm.renewal_date <= '".$ssToDate."' ");

					if($isadmin != 1)
						$omCriteria->andWhere('agm.cem_cemetery_id = ?', $cemeteryid);

		return $omCriteria;
    }
	/**
	 * @todo Execute getAnnulaReportCount function for get total count of annual report.
	 *
	 * @return criteria
	 */
	public function getAnnulaReportCount($ssFromDate, $ssToDate)
    {	
		$snCemeteryId = sfContext::getInstance()->getUser()->getAttribute('cemeteryid');
		$bIsAdmin = sfContext::getInstance()->getUser()->getAttribute('issuperadmin');	
		
		 $omCriteria	= Doctrine_Query::create()
						->select('COUNT(agm.id) as num_rows')
						->from('ArGraveMaintenance agm')
						->where("agm.renewal_date >= '".$ssFromDate."' AND agm.renewal_date <= '".$ssToDate."' ");

		if($bIsAdmin != 1)
			$omCriteria->andWhere('agm.cem_cemetery_id = ?', $snCemeteryId);

		return $omCriteria;
	}
	/**
	 * @todo Execute getOnsiteGravesLocation function for get onsite work graves.
	 *
	 * @return criteria
	 */
	public function getOnsiteGravesLocation($ssOnsiteWorkDate)
    {
		$cemeteryid = sfContext::getInstance()->getUser()->getAttribute('cemeteryid');
		$isadmin = sfContext::getInstance()->getUser()->getAttribute('issuperadmin');	

		$oQueryArea = Doctrine_Query::create()->select("ar.area_code")
					->from("ArArea ar")
					->Where("ar.id = agm.ar_area_id");
					
		$oQuerySection = Doctrine_Query::create()->select("ars.section_code")
					->from("ArSection ars")
					->Where("ars.id = agm.ar_section_id");	

		$oQueryPlot = Doctrine_Query::create()->select("ap.plot_name")
					->from("ArPlot ap")
					->Where("ap.id = agm.ar_plot_id");	
					
		$oQueryRow = Doctrine_Query::create()->select("arw.row_name")
					->from("ArRow arw")
					->Where("arw.id = agm.ar_row_id");

        $omCriteria	= Doctrine_Query::create()
					->select('agm.id,agm.date_paid,agm.amount_paid, agm.renewal_term, agm.renewal_date, 
							agm.interred_surname, agm.interred_name, agm.organization_name,agm.first_name,agm.surname,
							('.$oQueryArea->getDql().') as area_name, 
							('.$oQuerySection->getDql().') as section_name, 
							('.$oQueryRow->getDql().') as row_name, 
							('.$oQueryPlot->getDql().') as plot_name,
							cem.name as cemetery_name, grv.grave_number as grave_number, grv.latitude as latitude, grv.longitude as longitude
							')
					->from('ArGraveMaintenance agm')
					->innerJoin('agm.CemCemetery cem')
					->innerJoin('agm.ArGrave grv')
					->where("agm.onsite_work_date = '".$ssOnsiteWorkDate."' ");

					if($isadmin != 1)
						$omCriteria->andWhere('agm.cem_cemetery_id = ?', $cemeteryid);

		return $omCriteria->fetchArray();
	}
}
