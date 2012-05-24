<?php

class IntermentBookingTable extends Doctrine_Table
{
    public static function getInstance()
    {
        return Doctrine_Core::getTable('IntermentBooking');
    }
	/**
	 * @todo Execute getGranteeList function for get All Grantee
	 *
	 * @return criteria
	 */
	public function getServiceBookingList($amExtraParameters = array(), $amSearch = array(), $ssStatusCondition  = '', $bInterment = false, $ssFlag = '',$snBookingId='',$ssFromDate='',$ssToDate='')
    {
        $ssFromToDateCriteria 	= (($ssFromDate != '' && $ssToDate != '') ? "ib.created_at >= '".$ssFromDate."' AND ib.created_at <= '".$ssToDate."' " : (($ssToDate != '') ? "DATE_FORMAT(ib.created_at, '%Y-%m-%d') = '".$ssToDate."'" : '') );
		
        if(!is_array($amExtraParameters)) 
            return false;

		$bIsAdmin = sfContext::getInstance()->getUser()->getAttribute('issuperadmin');
		$snCemeteryId = sfContext::getInstance()->getUser()->getAttribute('cemeteryid');

		// For Get Cemetery
		$oCemQuery = Doctrine_Query::create()->select("cem.name")
					->from("CemCemetery cem")
					->Where("cem.id = ib.cem_cemetery_id");

		$oQueryArea = Doctrine_Query::create()->select("ar.area_code")
					->from("ArArea ar")
					->Where("ar.id = ib.ar_area_id");
					
		$oQuerySection = Doctrine_Query::create()->select("ars.section_code")
					->from("ArSection ars")
					->Where("ars.id = ib.ar_section_id");	
					
		$oQueryRow = Doctrine_Query::create()->select("arw.row_name")
					->from("ArRow arw")
					->Where("arw.id = ib.ar_row_id");
											
		$oQueryPlot = Doctrine_Query::create()->select("ap.plot_name")
					->from("ArPlot ap")
					->Where("ap.id = ib.ar_plot_id");
					
		$oQueryGrave = Doctrine_Query::create()->select("ag.grave_number")
					->from("ArGrave ag")
					->Where("ag.id = ib.ar_grave_id");
										
		// For Get Service Type Name
		$oServiceType = Doctrine_Query::create()->select("st.name as service_type_name")
					->from("ServiceType st")
					->Where("st.id = ib.service_type_id");

		// For Get Funeral Directory Name
		$oFnd = Doctrine_Query::create()->select("uc.organisation")
					->from("UserCemetery uc")
					->Where("uc.user_id = ib.fnd_fndirector_id");

		// For Get Taken By User Name
		$oSubquery3 = Doctrine_Query::create()->select("CONCAT(sgu.first_name,' ',sgu.last_name) as taken_by_name")
					->from("sfGuardUser sgu")
					->Where("sgu.id = ib.taken_by");

		$snFinalized = ($bInterment) ? 1 : 0;

		Doctrine::getTable('IntermentBooking')->setAttribute(Doctrine_Core::ATTR_QUERY_LIMIT, Doctrine_Core::LIMIT_ROWS);

        $ssFields = (($ssFlag == true)?'ct.name as catalog_name, ct.cost_price as cost_price, ct.special_cost_price as special_cost_price, ':'');
        $omCriteria	= Doctrine_Query::create()
					->select('ib.deceased_first_name, ib.deceased_surname,ib.interment_date, ib.deceased_other_surname, 
						ib.service_date, ib.service_booking_time_from, ib.service_booking_time_to, ib.consultant,ib.created_at,
						ibf.control_number as control_number, is_private as is_private,ib.catalog_id,ib.payment_id,'.$ssFields.'
						('.$oServiceType->getDql().') as service_type_name,
						('.$oFnd->getDql().') as fnd_name,
						('.$oCemQuery->getDql().') as cemetery_name,
						('.$oQueryArea->getDql().') as area_name,
						('.$oQuerySection->getDql().') as section_name,
						('.$oQueryRow->getDql().') as row_name, 
						('.$oQueryPlot->getDql().') as plot_name,
						('.$oQueryGrave->getDql().') as grave_number,ag1.id as id_grave,						
						('.$oSubquery3->getDql().') as taken_by_name')
						->from('IntermentBooking ib')
						->leftJoin('ib.ArGrave ag1')
						->leftJoin('ib.IntermentBookingFour ibf')
                        ->where('ib.is_finalized = ?',$snFinalized);
                        
                        if($ssFlag == true)
                            $omCriteria->leftJoin('ib.Catalog ct');
                        
                        if($snBookingId != '')
                            $omCriteria->Andwhere('ib.id = ?',$snBookingId);

                        if($ssFromToDateCriteria != '')
                            $omCriteria->andWhere($ssFromToDateCriteria);
                            
                        
        if(!$bIsAdmin)
			$omCriteria->andWhere('ib.cem_cemetery_id = ?', $snCemeteryId);
        
        return common::setCriteria($omCriteria, $amExtraParameters, $ssStatusCondition, $amSearch);
    }
    /**
	 * @todo Execute getGranteeList function for get Total Count of Interment/Booking
	 *
	 * @return criteria
	 */
	public function getServiceBookingListCount($amExtraParameters = array(), $amSearch, $ssStatusCondition  = '', $bInterment = false)
    {
		if(!is_array($amExtraParameters)) 
            return false;

		$bIsAdmin = sfContext::getInstance()->getUser()->getAttribute('issuperadmin');
		$snCemeteryId = sfContext::getInstance()->getUser()->getAttribute('cemeteryid');
		
		$snFinalized = ($bInterment) ? 1 : 0;

        $omCriteria	= Doctrine_Query::create()->select('COUNT(ib.id) as num_rows')
						->from('IntermentBooking ib')
						->leftJoin('ib.IntermentBookingFour ibf')
						->where('ib.is_finalized = ?',$snFinalized);

		if(!$bIsAdmin)
			$omCriteria->andWhere('ib.cem_cemetery_id = ?', $snCemeteryId);

       return common::setCriteria($omCriteria, $amExtraParameters, $ssStatusCondition, $amSearch);
	}
	
	/**
	 * @todo Execute getIntermentListForSearch function for search interments
	 *
	 * @return criteria
	 */
	public function getIntermentListForSearch($amExtraParameters = array(), $amSearch, $ssStatusCondition  = '')
    {
		$cemeteryid = sfContext::getInstance()->getUser()->getAttribute('cemeteryid');
		$isadmin = sfContext::getInstance()->getUser()->getAttribute('issuperadmin');		
		
        if(!is_array($amExtraParameters)) 
            return false;

		$oQueryArea = Doctrine_Query::create()->select("ar.area_code")
					->from("ArArea ar")
					->Where("ar.id = ib.ar_area_id");
					
		$oQuerySection = Doctrine_Query::create()->select("ars.section_code")
					->from("ArSection ars")
					->Where("ars.id = ib.ar_section_id");	
					
		$oQueryRow = Doctrine_Query::create()->select("arw.row_name")
					->from("ArRow arw")
					->Where("arw.id = ib.ar_row_id");
											
		$oQueryPlot = Doctrine_Query::create()->select("ap.plot_name")
					->from("ArPlot ap")
					->Where("ap.id = ib.ar_plot_id");	
					
		$oQueryGrave = Doctrine_Query::create()->select("ag.grave_number")
					->from("ArGrave ag")
					->Where("ag.id = ib.ar_grave_id");

		// For Get Service type name
		$oQueryServiceType = Doctrine_Query::create()->select("st.name")
						->from("ServiceType st")
						->Where("st.id = ib.service_type_id");
						
		Doctrine::getTable('IntermentBooking')->setAttribute(Doctrine_Core::ATTR_QUERY_LIMIT, Doctrine_Core::LIMIT_ROWS);
		
        $omCriteria	= Doctrine_Query::create()
					->select('ib.deceased_first_name,ib.deceased_surname,ib.interment_date,ib.deceased_other_surname,
							ibf.deceased_date_of_birth as date_of_birth, ibf.deceased_date_of_death as date_of_death,ibf.control_number as control_number,
							('.$oQueryArea->getDql().') as area_name,
							('.$oQuerySection->getDql().') as section_name,
							('.$oQueryRow->getDql().') as row_name, 
							('.$oQueryPlot->getDql().') as plot_name,
							ag1.id as id_grave, ag1.grave_number as grave_number,
							('.$oQueryServiceType->getDql().') as service_type
						')
						->from('IntermentBooking ib')
						->leftJoin('ib.ArGrave ag1')
						->leftJoin('ib.IntermentBookingFour ibf')
						->Where('ib.is_finalized = ?', '1')
						->orderBy('ib.interment_date asc');

       return common::setCriteria($omCriteria, $amExtraParameters, $ssStatusCondition, $amSearch);
    }
	/**
	 * @todo Execute getIntermentSearchCount function for get total count of searched interments
	 *
	 * @return criteria
	 */
	public function getIntermentSearchCount($amExtraParameters = array(), $amSearch, $ssStatusCondition  = '')
    {
		$omCriteria	= Doctrine_Query::create()
					->select('COUNT(ib.id) as num_rows')
						->from('IntermentBooking ib')
						->leftJoin('ib.IntermentBookingFour ibf')
						->Where('ib.is_finalized = ?', '1');

       return common::setCriteria($omCriteria, $amExtraParameters, $ssStatusCondition, $amSearch);
	}
	
	/**
	 * @todo Execute getTodaySummary function for search interments,ashes,Exhumations,chapel and room summary
	 *
	 * @return criteria
	 */
	public function getTodaySummary($ssServiceDate, $snServiceType='', $ssFacility='')
    {
		$snCemeteryId = sfContext::getInstance()->getUser()->getAttribute('cemeteryid');
		$bIsSuperAdmin = sfContext::getInstance()->getUser()->getAttribute('issuperadmin');		
		
		// For Get Funeral Directory Name
		$oQueryFnd = Doctrine_Query::create()->select("uc.organisation")
					->from("UserCemetery uc")
					->Where("uc.user_id = ib.fnd_fndirector_id");
		
		$oQueryArea = Doctrine_Query::create()->select("ar.area_code")
					->from("ArArea ar")
					->Where("ar.id = ib.ar_area_id");
					
		$oQuerySection = Doctrine_Query::create()->select("ars.section_code")
					->from("ArSection ars")
					->Where("ars.id = ib.ar_section_id");	
					
		$oQueryRow = Doctrine_Query::create()->select("arw.row_name")
					->from("ArRow arw")
					->Where("arw.id = ib.ar_row_id");
											
		$oQueryPlot = Doctrine_Query::create()->select("ap.plot_name")
					->from("ArPlot ap")
					->Where("ap.id = ib.ar_plot_id");	
					
		$oQueryGrave = Doctrine_Query::create()->select("ag.grave_number")
					->from("ArGrave ag")
					->Where("ag.id = ib.ar_grave_id");

		$oChapelQuery = Doctrine_Query::create()->select("GROUP_CONCAT(c.name separator ', ')")
						->from("CemChapel c")
						->where("FIND_IN_SET(c.id, i2.cem_chapel_ids)");

		$oRoomQuery = Doctrine_Query::create()->select("GROUP_CONCAT(c2.name separator ', ')")
						->from("CemRoom as c2")
						->where("(FIND_IN_SET(c2.id, i2.cem_room_ids))");

		Doctrine::getTable('IntermentBooking')->setAttribute(Doctrine_Core::ATTR_QUERY_LIMIT, Doctrine_Core::LIMIT_ROWS);
		
        $omCriteria	= Doctrine_Query::create()
						->select('ib.is_finalized, ib.service_date, ib.service_booking_time_from, ib.service_booking_time_to, ib.deceased_title, ib.deceased_surname, ib.deceased_first_name,
								ibto.chapel_time_from as chapel_time_from, ibto.chapel_time_to as chapel_time_to, ibto.room_time_from as room_time_from, ibto.room_time_to as room_time_to,
								ibfo.informant_surname as informant_surname, ibfo.informant_first_name as informant_first_name,ibto.cem_chapel_ids as chaple,ibto.cem_room_ids as room,
								('.$oQueryFnd->getDql().') as fnd_name, 
								('.$oQueryArea->getDql().') as area_name,
								('.$oQuerySection->getDql().') as section_name,
								('.$oQueryRow->getDql().') as row_name, 
								('.$oQueryPlot->getDql().') as plot_name,
								('.$oQueryGrave->getDql().') as grave_number,
								('.$oChapelQuery->getDql().') as chapel_types,
							    ('.$oRoomQuery->getDql().') as room_types
								')
						->from('IntermentBooking ib')
						->leftJoin('ib.IntermentBookingTwo ibto')
						->leftJoin('ib.IntermentBookingFour ibfo')
						->where(1);
						
					
					if($bIsSuperAdmin != 1)
						$omCriteria->andWhere('ib.cem_cemetery_id = ?', $snCemeteryId);
						
					if($snServiceType != '')
						$omCriteria->andWhere('ib.service_type_id = ?', $snServiceType)->andWhere('ib.service_date = "'.$ssServiceDate.'" ');
					
					if($ssFacility == 'chapel')
						$omCriteria->andWhere('DATE_FORMAT(ibto.chapel_time_from, "%Y-%m-%d") = ?', $ssServiceDate);

					if($ssFacility == 'room')
						$omCriteria->andWhere('DATE_FORMAT(ibto.room_time_from, "%Y-%m-%d") = ?', $ssServiceDate);

       return $omCriteria->orderBy('ib.service_booking_time_from asc');
	}
	
	/**
	 * @todo Execute getReports function for get interment report as per cemetery, area, section, row and plot.
	 *
	 * @return criteria
	 */
	public function getReports($snCountryId='', $snCemeteryId='', $snAreaId='', $snSectionId='', $snRowId='', $snPlotId='', $ssFromIntDate='', $ssToIntDate='')
    {
		/////////////////////////////////////
		// For get total number of grave.  //
		/////////////////////////////////////
		
		$snCountryId1 = ($snCountryId != '') ? 'ag1.country_id = '.$snCountryId : 'ag1.country_id IS NULL';
		$snCemeteryId1 = ($snCemeteryId != '') ? 'ag1.cem_cemetery_id = '.$snCemeteryId : 'ag1.cem_cemetery_id IS NULL';
		$snAreaId1 = ($snAreaId != '') ? 'ag1.ar_area_id = '.$snAreaId : 'ag1.ar_area_id IS NULL';
		$snSectionId1 = ($snSectionId != '') ? 'ag1.ar_section_id = '.$snSectionId : 'ag1.ar_section_id IS NULL';		
		$snRowId1 = ($snRowId != '') ? 'ag1.ar_row_id = '.$snRowId : 'ag1.ar_row_id IS NULL';
		$snPlotId1 = ($snPlotId != '') ? 'ag1.ar_plot_id = '.$snPlotId : 'ag1.ar_plot_id IS NULL';
		
		$ssFromToIntDateCriteria 	= ($ssFromIntDate != '' && $ssToIntDate != '') ? "ib.interment_date >= '".$ssFromIntDate."' AND ib.interment_date <= '".$ssToIntDate."' " : 1;
		
		$oTotalGrave = Doctrine_Query::create()->select("COUNT(ag1.id)")
						->from("ArGrave ag1")
						->where('ag1.ar_grave_status_id != "'.sfConfig::get('app_grave_status_vacant').'"');
						
						if($ssFromToIntDateCriteria != '' && $snCountryId == '' && $snCemeteryId == '' && $snAreaId == '' && $snSectionId == '' && $snRowId == '' && $snPlotId == '')
							$oTotalGrave->andWhere($ssFromToIntDateCriteria);
						else
						{
							$oTotalGrave->andWhere($snCountryId1.'')
										->andWhere($snCemeteryId1.'')
										->andWhere($snAreaId1.'')
										->andWhere($snSectionId1.'')
										->andWhere($snRowId1.'')
										->andWhere($snPlotId1.'');
						}

		$snCountryId2 = ($snCountryId != '') ? 'ag.country_id = '.$snCountryId : 'ag.country_id IS NULL';
		$snCemeteryId2 = ($snCemeteryId != '') ? 'ag.cem_cemetery_id = '.$snCemeteryId : 'ag.cem_cemetery_id IS NULL';
		$snAreaId2 = ($snAreaId != '') ? 'ag.ar_area_id = '.$snAreaId : 'ag.ar_area_id IS NULL';
		$snSectionId2 = ($snSectionId != '') ? 'ag.ar_section_id = '.$snSectionId : 'ag.ar_section_id IS NULL';
		$snRowId2 = ($snRowId != '') ? 'ag.ar_row_id = '.$snRowId : 'ag.ar_row_id IS NULL';		
		$snPlotId2 = ($snPlotId != '') ? 'ag.ar_plot_id = '.$snPlotId : 'ag.ar_plot_id IS NULL';
		
		//////////////////////////////////////////////
		// For get total number of occupied grave.  //
		//////////////////////////////////////////////
		$oOccupiedGrave = Doctrine_Query::create()->select("COUNT(ag.id)")
						->from("ArGrave ag")
						->where("ag.id = ib.ar_grave_id");
						
						if($ssFromToIntDateCriteria != '' && $snCountryId == '' && $snCemeteryId == '' && $snAreaId == '' && $snSectionId == '' && $snRowId == '' && $snPlotId == '')
							$oOccupiedGrave->andWhere($ssFromToIntDateCriteria);
						else
						{
							$oOccupiedGrave->andWhere($snCountryId2.'')
											->andWhere($snCemeteryId2.'')
											->andWhere($snAreaId2.'')
											->andWhere($snSectionId2.'')
											->andWhere($snRowId2.'')
											->andWhere($snPlotId2.'');
						}
		
		////////////////////////////////////////////
		// For get total number of vacant grave.  //
		////////////////////////////////////////////
		
		$snCountryId3 = ($snCountryId != '') ? 'ag2.country_id = '.$snCountryId : 'ag2.country_id IS NULL';
		$snCemeteryId3 = ($snCemeteryId != '') ? 'ag2.cem_cemetery_id = '.$snCemeteryId : 'ag2.cem_cemetery_id IS NULL';
		$snAreaId3 = ($snAreaId != '') ? 'ag2.ar_area_id = '.$snAreaId : 'ag2.ar_area_id IS NULL';
		$snSectionId3 = ($snSectionId != '') ? 'ag2.ar_section_id = '.$snSectionId : 'ag2.ar_section_id IS NULL';
		$snRowId3 = ($snRowId != '') ? 'ag2.ar_row_id = '.$snRowId : 'ag2.ar_row_id IS NULL';		
		$snPlotId3 = ($snPlotId != '') ? 'ag2.ar_plot_id = '.$snPlotId : 'ag2.ar_plot_id IS NULL';
		
		$oVacantGraves = Doctrine_Query::create()->select("COUNT(ag2.id)")
						->from("ArGrave ag2")
						->where('ag2.ar_grave_status_id = "'.sfConfig::get('app_grave_status_vacant').'"');
						
						if($ssFromToIntDateCriteria != '' && $snCountryId == '' && $snCemeteryId == '' && $snAreaId == '' && $snSectionId == '' && $snRowId == '' && $snPlotId == '')
							$oVacantGraves->andWhere($ssFromToIntDateCriteria);
						else
						{
							$oVacantGraves->andWhere($snCountryId3)
											->andWhere($snCemeteryId3)
											->andWhere($snAreaId3)
											->andWhere($snSectionId3)
											->andWhere($snRowId3)
											->andWhere($snPlotId3);
						}
		//////////////////////////////////////////
		// For get cemetery and burial report.	//
		//////////////////////////////////////////
		$snCountryId3 = ($snCountryId != '') ? 'ib.country_id = '.$snCountryId : 'ib.country_id IS NULL';
		$snCemeteryId3 = ($snCemeteryId != '') ? 'ib.cem_cemetery_id = '.$snCemeteryId : 'ib.cem_cemetery_id IS NULL';
		$snAreaId3 = ($snAreaId != '') ? 'ib.ar_area_id = '.$snAreaId : 'ib.ar_area_id IS NULL';
		$snSectionId3 = ($snSectionId != '') ? 'ib.ar_section_id = '.$snSectionId : 'ib.ar_section_id IS NULL';
		$snRowId3 = ($snRowId != '') ? 'ib.ar_row_id = '.$snRowId : 'ib.ar_row_id IS NULL';		
		$snPlotId3 = ($snPlotId != '') ? 'ib.ar_plot_id = '.$snPlotId : 'ib.ar_plot_id IS NULL';
		
		$omCriteria	= Doctrine_Query::create()
						->select('ib.id, ib.ar_grave_id,COUNT(ib.id) as total_interments,
								('.$oOccupiedGrave->getDql().') as total_occupied_grave,
								('.$oTotalGrave->getDql().') as total_grave
								')
						->from('IntermentBooking ib')
						->where('ib.is_finalized = 1')						
						->groupBy('ib.ar_grave_id');

						if($ssFromToIntDateCriteria != '' && $snCountryId == '' && $snCemeteryId == '' && $snAreaId == '' && $snSectionId == '' && $snRowId == '' && $snPlotId == '')
							$omCriteria->andWhere($ssFromToIntDateCriteria);
						else
						{
							$omCriteria->andWhere($snCountryId3)
										->andWhere($snCemeteryId3)
										->andWhere($snAreaId3)
										->andWhere($snSectionId3)
										->andWhere($snRowId3)
										->andWhere($snPlotId3)
										->andWhere($ssFromToIntDateCriteria);
						}

		$amReport = $omCriteria->fetchArray();

		$snTotalInterments = $snTotalOccupiedGrave = $snTotalEmptyGrave = $snTotalGrave = $snTotalVacantGrave = 0;
		$asFinalReport = array();
		if(count($amReport) > 0)
		{
			foreach($amReport as $asDataSet)
			{
				$snTotalInterments += $asDataSet['total_interments'];
				$snTotalOccupiedGrave += $asDataSet['total_occupied_grave'];
				$snTotalGrave = $asDataSet['total_grave'];
			}
		}
		$snTotalEmptyGrave = $snTotalGrave - $snTotalOccupiedGrave;
		$asFinalReport = array('total_interments'		=> $snTotalInterments,
							   'total_occupied_grave'	=> $snTotalOccupiedGrave,
							   'total_empty_grave'		=> ($snTotalEmptyGrave > 0) ? $snTotalEmptyGrave : 0,
							   'total_vacant_grave'		=> $oVacantGraves->count()
							  );	

		return $asFinalReport;
	}
	/**
	 * @todo Execute getGraveIntReports function for get how many interments in one grave.
	 *
	 * @return criteria
	 */
	public function getIntermentDetailsAsPerReport($snCountryId='', $snCemeteryId='', $snAreaId='', $snSectionId='', $snRowId='', $snPlotId='',$ssFromIntDate='',$ssToIntDate='')
    {	
		$snCountryCriteria = ($snCountryId != '') ? 'ib.country_id = '.$snCountryId : 'ib.country_id IS NULL';
		$snCemeteryCriteria = ($snCemeteryId != '') ? 'ib.cem_cemetery_id = '.$snCemeteryId : 'ib.cem_cemetery_id IS NULL';		
		$snAreaCriteria = ($snAreaId != '' && $snAreaId != 'NULL') ? 'ib.ar_area_id = '.$snAreaId : 'ib.ar_area_id IS NULL';
		$snSectionCriteria = ($snSectionId != '' && $snSectionId != 'NULL') ? 'ib.ar_section_id = '.$snSectionId : 'ib.ar_section_id IS NULL';		
		$snRowCriteria = ($snRowId != '' && $snRowId != 'NULL') ? 'ib.ar_row_id = '.$snRowId : 'ib.ar_row_id IS NULL';		
		$snPlotCriteria = ($snPlotId != '' && $snPlotId != 'NULL') ? 'ib.ar_plot_id = '.$snPlotId : 'ib.ar_plot_id IS NULL';						

		
		$ssFromToIntDateCriteria 	= ($ssFromIntDate != '' && $ssToIntDate != '') ? "ib.interment_date >= '".$ssFromIntDate."' AND ib.interment_date <= '".$ssToIntDate."' " : 1;
		
		$cemeteryid = sfContext::getInstance()->getUser()->getAttribute('cemeteryid');
		$isadmin = sfContext::getInstance()->getUser()->getAttribute('issuperadmin');		
		
		// For Get Cemetery
		$oCemQuery = Doctrine_Query::create()->select("cem.name")
					->from("CemCemetery cem")
					->Where("cem.id = ib.cem_cemetery_id");

		$oQueryArea = Doctrine_Query::create()->select("ar.area_code")
					->from("ArArea ar")
					->Where("ar.id = ib.ar_area_id");
					
		$oQuerySection = Doctrine_Query::create()->select("ars.section_code")
					->from("ArSection ars")
					->Where("ars.id = ib.ar_section_id");	
					
		$oQueryRow = Doctrine_Query::create()->select("arw.row_name")
					->from("ArRow arw")
					->Where("arw.id = ib.ar_row_id");
											
		$oQueryPlot = Doctrine_Query::create()->select("ap.plot_name")
					->from("ArPlot ap")
					->Where("ap.id = ib.ar_plot_id");	
		
		$oQueryGrave = Doctrine_Query::create()->select("ag.grave_number")
					->from("ArGrave ag")
					->Where("ag.id = ib.ar_grave_id");
		
		// For Get Control number
		$oControlNumber = Doctrine_Query::create()->select("ibf.control_number")
						->from("IntermentBookingFour ibf")
						->Where("ibf.interment_booking_id = ib.id")
						->limit(1);

		// For Get Funeral Directory Name
		$oQueryFnd = Doctrine_Query::create()->select("uc.organisation")
						->from("UserCemetery uc")
						->Where("uc.user_id = ib.fnd_fndirector_id");

        $omCriteria	= Doctrine_Query::create()
					->select('ib.deceased_first_name,ib.deceased_surname,ib.interment_date,ib.deceased_other_surname,
						('.$oCemQuery->getDql().') as cemetery_name,
						('.$oQueryArea->getDql().') as area_name,
						('.$oQuerySection->getDql().') as section_name,
						('.$oQueryRow->getDql().') as row_name, 
						('.$oQueryPlot->getDql().') as plot_name,
						('.$oQueryGrave->getDql().') as grave_number,
						('.$oControlNumber->getDql().') as control_number,
						('.$oQueryFnd->getDql().') as fnd_name
					')
					->from('IntermentBooking ib')
					->where('ib.is_finalized = 1');
				
					if($ssFromToIntDateCriteria != '' && $snCountryId == '' && $snCemeteryId == '' && $snAreaId == '' && $snSectionId == '' && $snRowId == '' && $snPlotId == '')
						$omCriteria->andWhere($ssFromToIntDateCriteria);
					else
					{
						$omCriteria->andWhere($snCountryCriteria)
									->andWhere($snCemeteryCriteria)
									->andWhere($snAreaCriteria)
									->andWhere($snSectionCriteria)
									->andWhere($snRowCriteria)
									->andWhere($snPlotCriteria)
									->andWhere($ssFromToIntDateCriteria);
					}

					if($isadmin != 1)
						$omCriteria->andWhere('ib.cem_cemetery_id = ?', $cemeteryid);

       	return $omCriteria;
    }
	/**
	 * @todo Execute getIntermentDetailsAsPerReportCount function for get total count of interment report.
	 *
	 * @return criteria
	 */
	public function getIntermentDetailsAsPerReportCount($snCountryId='', $snCemeteryId='', $snAreaId='', $snSectionId='', $snRowId='', $snPlotId='',$ssFromIntDate='',$ssToIntDate='')
    {
		$snCountryCriteria = ($snCountryId != '') ? 'ib.country_id = '.$snCountryId : 'ib.country_id IS NULL';
		$snCemeteryCriteria = ($snCemeteryId != '') ? 'ib.cem_cemetery_id = '.$snCemeteryId : 'ib.cem_cemetery_id IS NULL';		
		$snAreaCriteria = ($snAreaId != '' && $snAreaId != 'NULL') ? 'ib.ar_area_id = '.$snAreaId : 'ib.ar_area_id IS NULL';
		$snSectionCriteria = ($snSectionId != '' && $snSectionId != 'NULL') ? 'ib.ar_section_id = '.$snSectionId : 'ib.ar_section_id IS NULL';		
		$snRowCriteria = ($snRowId != '' && $snRowId != 'NULL') ? 'ib.ar_row_id = '.$snRowId : 'ib.ar_row_id IS NULL';		
		$snPlotCriteria = ($snPlotId != '' && $snPlotId != 'NULL') ? 'ib.ar_plot_id = '.$snPlotId : 'ib.ar_plot_id IS NULL';						
		
		$ssFromToIntDateCriteria 	= ($ssFromIntDate != '' && $ssToIntDate != '') ? "ib.interment_date >= '".$ssFromIntDate."' AND ib.interment_date <= '".$ssToIntDate."' " : 1;
		
		$cemeteryid = sfContext::getInstance()->getUser()->getAttribute('cemeteryid');
		$isadmin = sfContext::getInstance()->getUser()->getAttribute('issuperadmin');
		
		$omCriteria	= Doctrine_Query::create()
					->select('COUNT(ib.id) as num_rows')
					->from('IntermentBooking ib')
					->where('ib.is_finalized = 1');

					if($ssFromToIntDateCriteria != '' && $snCountryId == '' && $snCemeteryId == '' && $snAreaId == '' && $snSectionId == '' && $snRowId == '' && $snPlotId == '')
						$omCriteria->andWhere($ssFromToIntDateCriteria);
					else
					{
						$omCriteria->andWhere($snCountryCriteria)
									->andWhere($snCemeteryCriteria)
									->andWhere($snAreaCriteria)
									->andWhere($snSectionCriteria)
									->andWhere($snRowCriteria)
									->andWhere($snPlotCriteria)
									->andWhere($ssFromToIntDateCriteria);
					}

					if($isadmin != 1)
						$omCriteria->andWhere('ib.cem_cemetery_id = ?', $cemeteryid);

       	return $omCriteria;
	}

	//=======================================================//
	// 					FOR API USE
	//=======================================================//
    /**
	 * @todo Execute getGraveIntReports function for get how many interments in one grave.
	 *
	 * @return criteria
	 */
	public function searchInterment($amExtraParameters = array(), $amSearch, $ssStatusCondition  = '')
    {
    	if(!is_array($amExtraParameters)) 
            return false;

		$oQueryCountry = Doctrine_Query::create()->select("c.name")
						->from("Country c")
						->Where("c.id = ib.country_id");
					
		$oQueryCemetery = Doctrine_Query::create()->select("cem.name")
						->from("CemCemetery cem")
						->Where("cem.id = ib.cem_cemetery_id");

        $oQueryArea = Doctrine_Query::create()->select("ar.area_code")
					->from("ArArea ar")
					->Where("ar.id = ib.ar_area_id");
					
		$oQuerySection = Doctrine_Query::create()->select("ars.section_code")
					->from("ArSection ars")
					->Where("ars.id = ib.ar_section_id");	
					
		$oQueryRow = Doctrine_Query::create()->select("arw.row_name")
					->from("ArRow arw")
					->Where("arw.id = ib.ar_row_id");
											
		$oQueryPlot = Doctrine_Query::create()->select("ap.plot_name")
					->from("ArPlot ap")
					->Where("ap.id = ib.ar_plot_id");	
					
		$oQueryGrave = Doctrine_Query::create()->select("ag.grave_number")
					->from("ArGrave ag")
					->Where("ag.id = ib.ar_grave_id");

        $omCriteria	= Doctrine_Query::create()
					->select('ib.deceased_first_name,ib.deceased_surname,ib.deceased_other_surname, DATE_FORMAT(ib.interment_date, "%d-%m-%Y") as interment_date,ib.deceased_other_surname,
						('.$oQueryCountry->getDql().') as country_name,
						('.$oQueryCemetery->getDql().') as cemetery_name,
						('.$oQueryArea->getDql().') as area_name,
						('.$oQuerySection->getDql().') as section_name,
						('.$oQueryRow->getDql().') as row_name, 
						('.$oQueryPlot->getDql().') as plot_name,
						('.$oQueryGrave->getDql().') as grave_number
						')
					->from('IntermentBooking ib')
//					->leftJoin('ib.IntermentBookingTwo ibo')					
//					->leftJoin('ib.IntermentBookingThree ibt')
//					->leftJoin('ib.IntermentBookingFour ibf')
					->Where('ib.is_finalized = ?', '1');

		return common::setCriteria($omCriteria, $amExtraParameters, $ssStatusCondition, $amSearch);
    }
	
	//=======================================================//
	// 					FOR PRINT BOOKING FORM
	//=======================================================//
    /**
	 * @todo Execute getGraveIntReports function for get how many interments in one grave.
	 *
	 * @return criteria
	 */
	public function getBookingDetailsForPrint($snIntermentBookingId)
    {

		// For Get Service type name
		$oQueryServiceType = Doctrine_Query::create()->select("st.name")
						->from("ServiceType st")
						->Where("st.id = ib.service_type_id");

		// For Get Confirmed user name
		$oQueryConfirmed = Doctrine_Query::create()->select("CONCAT(sguc.first_name,' ',sguc.last_name) as taken_by")
					->from("sfGuardUser sguc")
					->Where("sguc.id = ib.taken_by");
					
		// For Get Funeral Directory Name
		$oFnd = Doctrine_Query::create()->select("uc.organisation")
					->from("UserCemetery uc")
					->Where("uc.user_id = ib.fnd_fndirector_id");

		// For Get Unit type name
		$oQueryUnitType = Doctrine_Query::create()->select("ut.name")
						->from("UnitType ut")
						->Where("ut.id = ib.grave_unit_type");

		// For Get Grave Status name
		$oQueryGraveStatus = Doctrine_Query::create()->select("ags.grave_status")
							->from("ArGraveStatus ags")
							->Where("ags.id = ib.ar_grave_status");

		// For Get Grantee name
		$oQueryGrantee = Doctrine_Query::create()->select("CONCAT(gd.grantee_first_name,' ',gd.grantee_surname) as grantee_id")
						->from("GranteeDetails gd")
						->Where("gd.id = ib.grantee_id");

		// For Get Stone Mason name
		$oQueryStonemason = Doctrine_Query::create()->select("sgus.organisation")
					->from("UserCemetery sgus")
					->Where("sgus.user_id = ib.cem_stonemason_id");
					
		// For Get Block/Plot Unit type name
		$oQueryBlockUnitType = Doctrine_Query::create()->select("but.name")
								->from("UnitType but")
								->Where("but.id = ib.monuments_unit_type");

		//-----------------
		// For Get Cofin Type Name
		$oQueryCofinType = Doctrine_Query::create()->select("ct.name")
							->from("CoffinType ct")
							->Where("ct.id = ibo.coffin_type_id");

		// For Get Cofin Unit Type Name
		$oQueryConfinUnitType = Doctrine_Query::create()->select("utype.name")
								->from("UnitType utype")
								->Where("utype.id = ibo.unit_type_id");

		// For Get Infectious Disease name
		$oQueryDecease = Doctrine_Query::create()->select("des.name")
								->from("Disease des")
								->Where("des.id = ibo.disease_id");

		// For get Country of death
		$oQueryCod = Doctrine_Query::create()->select("cod.name")
						->from("Country cod")
						->Where("cod.id = ibf.deceased_country_id_of_death");

		// For get Country of birth
		$oQueryCob = Doctrine_Query::create()->select("cob.name")
						->from("Country cob")
						->Where("cob.id = ibf.deceased_country_id_of_birth");
						
		// For get Deceased country
		$oQueryDeceasedCountry = Doctrine_Query::create()->select("cdec.name")
								->from("Country cdec")
								->Where("cdec.id = ibf.deceased_country_id");
						
		// For get Informant country
		$oQueryInformantCountry = Doctrine_Query::create()->select("infc.name")
								->from("Country infc")
								->Where("infc.id = ibf.informant_country_id");
						
		//-------------------						
		$oQueryCountry = Doctrine_Query::create()->select("c.name")
						->from("Country c")
						->Where("c.id = ib.country_id");
					
		$oQueryCemetery = Doctrine_Query::create()->select("cem.name")
						->from("CemCemetery cem")
						->Where("cem.id = ib.cem_cemetery_id");

        $oQueryArea = Doctrine_Query::create()->select("ar.area_code")
					->from("ArArea ar")
					->Where("ar.id = ib.ar_area_id");
					
		$oQuerySection = Doctrine_Query::create()->select("ars.section_code")
					->from("ArSection ars")
					->Where("ars.id = ib.ar_section_id");	
					
		$oQueryRow = Doctrine_Query::create()->select("arw.row_name")
					->from("ArRow arw")
					->Where("arw.id = ib.ar_row_id");
											
		$oQueryPlot = Doctrine_Query::create()->select("ap.plot_name")
					->from("ArPlot ap")
					->Where("ap.id = ib.ar_plot_id");	
					
		$oQueryGrave = Doctrine_Query::create()->select("ag.grave_number")
					->from("ArGrave ag")
					->Where("ag.id = ib.ar_grave_id");

        $amResults	= Doctrine_Query::create()
						->select('ib.*,ibo.*,ibt.*,ibf.*,ibfv.*,
							('.$oQueryCountry->getDql().') as country_name,
							('.$oQueryCemetery->getDql().') as cemetery_name,
							('.$oQueryArea->getDql().') as area_name,
							('.$oQuerySection->getDql().') as section_name,
							('.$oQueryRow->getDql().') as row_name, 
							('.$oQueryPlot->getDql().') as plot_name,
							('.$oQueryGrave->getDql().') as grave_number,
							
							('.$oQueryServiceType->getDql().') as service_type_id,
							('.$oQueryConfirmed->getDql().') as confirmed,
							('.$oFnd->getDql().') as fnd_fndirector_id,
							('.$oQueryUnitType->getDql().') as grave_unit_type,
							('.$oQueryGraveStatus->getDql().') as ar_grave_status, 
							('.$oQueryGrantee->getDql().') as grantee_id,
							('.$oQueryStonemason->getDql().') as cem_stonemason_id,
							('.$oQueryBlockUnitType->getDql().') as monuments_unit_type,
							
							('.$oQueryCofinType->getDql().') as coffin_type_id,
							('.$oQueryConfinUnitType->getDql().') as unit_type_id,
							('.$oQueryDecease->getDql().') as disease_id,
							('.$oQueryCod->getDql().') as deceased_country_id_of_death,
							('.$oQueryCob->getDql().') as deceased_country_id_of_birth,
							('.$oQueryDeceasedCountry->getDql().') as deceased_country_id,
							('.$oQueryInformantCountry->getDql().') as informant_country_id,
							')
						->from('IntermentBooking ib')
						->leftJoin('ib.IntermentBookingTwo ibo')					
						->leftJoin('ib.IntermentBookingThree ibt')
						->leftJoin('ib.IntermentBookingFour ibf')
						->leftJoin('ib.IntermentBookingFive ibfv')
						->where('ib.id = ?', $snIntermentBookingId)
						->fetchArray();

		return $amResults;
    }
	//======================================================================//
	// 					FOR USE IN DEASEASE SEARCH API PLUGIN
	//======================================================================//
    /**
	 * @todo Execute searchIntermentInfo function for get how many interments in one grave.
	 *
	 * @return criteria
	 */
	public function searchIntermentInfo($amExtraParameters = array(), $amSearch, $ssStatusCondition  = '', $snSearchYearFrom, $snSearchYearTo)
    {
    	if(!is_array($amExtraParameters)) 
            return false;

        $omCriteria	= Doctrine_Query::create()
					->select('ib.id, CONCAT(ib.deceased_surname," ",ib.deceased_first_name) as name, DATE_FORMAT(ib.interment_date, "%d-%m-%Y") as interment_date,
							  cem.name as cem_name, CONCAT(cem.address,", ",cem.suburb_town) as cem_address, cem.phone as cem_phone, cem.fax as cem_fax,
							  cem.email as cem_email, cem.url as cem_url, arr.area_code as area_code, sec.section_code as section_code, row.row_name as row_name, 
							  plot.plot_name as plot_name, grv.grave_number as grave_number, grv.grave_image1 as grave_image1, grv.grave_image2 as grave_image2, 
							  grv.latitude as latitude, grv.longitude as longitude, DATE_FORMAT(ibf.deceased_date_of_birth, "%d-%m-%Y") as deceased_date_of_birth, 
							  cem.cemetery_map_path as cemetery_map_path, arr.area_map_path as area_map_path, sec.section_map_path as section_map_path,
							  row.row_map_path as row_map_path, plot.plot_map_path as plot_map_path,
						')
					->from('IntermentBooking ib')
					->leftJoin('ib.IntermentBookingFour ibf')
					->leftJoin('ib.CemCemetery cem')
					->leftJoin('ib.ArArea arr')
					->leftJoin('ib.ArSection sec')
					->leftJoin('ib.ArRow row')
					->leftJoin('ib.ArPlot plot')
					->leftJoin('ib.ArGrave grv')
					->Where('ib.is_finalized = ?', '1')
					->andWhere('ib.is_private = ?', '0');

					if($snSearchYearFrom != '')
						$omCriteria->andWhere('EXTRACT(YEAR FROM ib.interment_date) >= ?', $snSearchYearFrom);
					if($snSearchYearTo != '')
						$omCriteria->andWhere('EXTRACT(YEAR FROM ib.interment_date) <= ?', $snSearchYearTo);

		return common::setCriteria($omCriteria, $amExtraParameters, $ssStatusCondition, $amSearch);
    }

	//========================================================================================//
	// 					FOR USE IN API FOR DEASEASE SEARCH PLUGIN AS PER ID
	//========================================================================================//
    /**
	 * @todo Execute searchIntermentInfo function for get how many interments in one grave.
	 *
	 * @return criteria
	 */
	public function getIntermentInfoAsPerId($snIdInterment)
    {
        $omCriteria	= Doctrine_Query::create()
					->select('ib.id, ib.deceased_title as title, CONCAT(ib.deceased_surname," ",ib.deceased_first_name) as name, DATE_FORMAT(ib.interment_date, "%d-%m-%Y") as interment_date,
							  cem.name as cem_name, CONCAT(cem.address,", ",cem.suburb_town) as cem_address, cem.phone as cem_phone, cem.fax as cem_fax,cem.latitude as cem_latitude, cem.longitude as cem_longitude,
							  cem.email as cem_email, cem.url as cem_url, arr.area_code as area_code, arr.area_name as area_name, sec.section_code as section_code, sec.section_name as section_name,row.row_name as row_name, 
							  plot.plot_name as plot_name, grv.grave_number as grave_number, grv.grave_image1 as grave_image1, grv.grave_image2 as grave_image2, 
							  grv.latitude as latitude, grv.longitude as longitude, DATE_FORMAT(ibf.deceased_date_of_birth, "%d-%m-%Y") as deceased_date_of_birth, 
							  cem.cemetery_map_path as cemetery_map_path, arr.area_map_path as area_map_path, sec.section_map_path as section_map_path,
							  row.row_map_path as row_map_path, plot.plot_map_path as plot_map_path
						')
					->from('IntermentBooking ib')
					->leftJoin('ib.IntermentBookingFour ibf')
					->leftJoin('ib.CemCemetery cem')
					->leftJoin('ib.ArArea arr')
					->leftJoin('ib.ArSection sec')
					->leftJoin('ib.ArRow row')
					->leftJoin('ib.ArPlot plot')
					->leftJoin('ib.ArGrave grv')
					->Where('ib.is_finalized = ?', '1')
					->andWhere('ib.is_private = ?', '0')
					->andWhere('ib.id = ?', $snIdInterment);

		return $omCriteria->fetchArray();
    }
	//=======================================================//
	// 					FOR GET TODAY SERVICE API
	//=======================================================//
    /**
	 * @todo Execute getTodayServiceForInterment function for get how many interments in one grave.
	 *
	 * @return criteria
	 */
	public function getTodayServiceForInterment()
    {
		$amResult	= Doctrine_Query::create()
						->select('ib.id, CONCAT(ib.deceased_first_name," ",ib.deceased_surname) as name, DATE_FORMAT(ib.service_date, "%d-%m-%Y") as service_date,
								  ib.service_booking_time_from as service_time, sec.section_name as section_code
								')
						->from('IntermentBooking ib')
						->leftJoin('ib.ArSection sec')
						->Where('ib.service_type_id = 1')
						->andWhere('ib.service_date = DATE_FORMAT( NOW() , "%Y-%m-%d" )')
						->orderBy('service_time')
						->fetchArray();

		return $amResult;
	}
    /**
	 * @todo Execute getOccupanyReport function for get Occupancy report.
	 *
	 * @return criteria
	 */
	public function getOccupanyReport($snCemeteryId = '')
    {
		$snSessionCemeteryId = sfContext::getInstance()->getUser()->getAttribute('cemeteryid');
		$bIsAdmin = sfContext::getInstance()->getUser()->getAttribute('issuperadmin');
		
		$ssCemeteryCriteria = ($bIsAdmin != 1) ? 'ag.cem_cemetery_id = '.sfContext::getInstance()->getUser()->getAttribute('cemeteryid') : ( ($snCemeteryId  != '' && $snCemeteryId  > 0) ? 'ag.cem_cemetery_id = '.$snCemeteryId : 1 );
		
		$oTotalGrave = Doctrine_Query::create()->select("COUNT(ag.id)")
						->from("ArGrave ag")
						->where($ssCemeteryCriteria);
		
		$ssCemCriteria = ($bIsAdmin != 1) ? 'ib.cem_cemetery_id = '.sfContext::getInstance()->getUser()->getAttribute('cemeteryid') : ( ($snCemeteryId  != '' && $snCemeteryId  > 0) ? 'ib.cem_cemetery_id = '.$snCemeteryId : 1 );
		$omCriteria =  Doctrine_Query::create()
                            ->select('ib.ar_grave_id, COUNT(ib.id) as tot_interments, ('.$oTotalGrave->getDql().') as tot_grave,')
                            ->from('IntermentBooking ib')
                            ->where('ib.ar_grave_id != ?','')
                            ->andWhere('ib.is_finalized = ?',1)
							->andWhere($ssCemCriteria);                            

        $amResultSet = $omCriteria->groupBy('ib.ar_grave_id')->fetchArray();

		return $amResultSet;
	}
	//=======================================================//
	// 					FOR PRINT LETTERS
	//=======================================================//
    /**
	 * @todo Execute getLetterPrintStatusForBooking function for print status for booking/interments.
	 *
	 * @return criteria
	 */
	public function getLetterPrintStatusForBooking($snIntermentBookingId)
    {
		// For Get Staff Name
		$oStaffQuery = Doctrine_Query::create()->select("CONCAT(sgu.first_name,' ',sgu.last_name) as staff_name")
					->from("sfGuardUser sgu")
					->Where("sgu.id = ib.taken_by");
		
		// For Get Service type name
		$oQueryServiceType = Doctrine_Query::create()->select("st.name")
							->from("ServiceType st")
							->Where("st.id = ib.service_type_id");

		// For Get Funeral Directory Name
		$oFndQuery = Doctrine_Query::create()->select("uc.organisation")
					->from("UserCemetery uc")
					->Where("uc.user_id = ib.fnd_fndirector_id");
		
		// For Get Coffin Type
		$oCoffinTypeQuery = Doctrine_Query::create()->select("cof.name")
							->from("CoffinType cof")
							->Where("cof.id = ib2.coffin_type_id");
		
		// For Get Unit Type (Other Details)
		$oOtherUnitTypeQuery = Doctrine_Query::create()->select("out.name")
								->from("UnitType out")
								->Where("out.id = ib2.unit_type_id");
		
		// For Get Infectious Disease
		$oDiseaseQuery = Doctrine_Query::create()->select("des.name")
								->from("disease des")
								->Where("des.id = ib2.disease_id");

		// For Get Chapel Type
		$oChapelQuery = Doctrine_Query::create()->select("GROUP_CONCAT(c4.name separator ', ')")
						->from("CemChapel c4")
						->where("FIND_IN_SET(c4.id, i2.cem_chapel_ids)");
		
		// For Get Room Type
		$oRoomQuery = Doctrine_Query::create()->select("GROUP_CONCAT(c5.name separator ', ')")
						->from("CemRoom as c5")
						->where("(FIND_IN_SET(c5.id, i2.cem_room_ids))");
		
		// For Get Grave Unit Type
		$oGraveUnitTypeQuery = Doctrine_Query::create()->select("agu.name")
								->from("UnitType agu")
								->Where("agu.id = ag.unit_type_id");

		// For Get Grave Status name
		$oGraveStatusQuery = Doctrine_Query::create()->select("ags.grave_status")
							->from("ArGraveStatus ags")
							->Where("ags.id = ag.ar_grave_status_id");

		// For Get Stone Mason name
		$oStonemasonQuery = Doctrine_Query::create()->select("sgus.organisation")
					->from("UserCemetery sgus")
					->Where("sgus.user_id = ib.cem_stonemason_id");

		// For Get Monument Unit Type
		$oMonumnetUnitTypeQuery = Doctrine_Query::create()->select("monu.name")
								->from("UnitType monu")
								->Where("monu.id = ib.monuments_unit_type");
		
		// For Get Deceased Death of Country
		$oDeathCountry = Doctrine_Query::create()->select("dc.name")
						->from("Country dc")
						->Where("dc.id = ib4.deceased_country_id_of_death");
		
		// For Get Deceased Birth of Country		
		$oBirthCountry = Doctrine_Query::create()->select("bc.name")
						->from("Country bc")
						->Where("bc.id = ib4.deceased_country_id_of_birth");

		// For Get Deceased Country		
		$oDeceasedCountry = Doctrine_Query::create()->select("decc.name")
						->from("Country decc")
						->Where("decc.id = ib4.deceased_country_id");

		// For Get Applicant Country		
		$oApplicantCountry = Doctrine_Query::create()->select("appc.name")
						->from("Country appc")
						->Where("appc.id = ib4.informant_country_id");
						
		$amResultSet =  Doctrine_Query::create()
                            ->select('ib.*, CONCAT(ib.deceased_first_name," ",ib.deceased_surname) as deceased_name,
									 CONCAT(ib.deceased_other_first_name," ",ib.deceased_other_surname) as deceased_other_name,
									 ibfv.*, ib2.*, ib4.*,									  
									 cont.name as country_name, cem.name as cemetery_name, ara.area_code as area_code, sec.section_name as section_code,
									 arr.row_name as row_name, plt.plot_name as plot_name, ag.grave_number as grave_number,
									 ag.length as grave_length, ag.width as grave_width, ag.height as grave_height, ag.comment1 as grave_comment1,
									 ag.comment2 as grave_comment2,
									 gtd.title as grantee_title, CONCAT(gtd.grantee_surname," ",gtd.grantee_first_name) as grantee_name,
									 gtd.grantee_address as grantee_address, gtd.state as grantee_state, gtd.town as grantee_town, gtd.postal_code as grantee_postal_code,
									 gtd.remarks_1 as grantee_comment1, gtd.remarks_2 as grantee_comment2,
									 ('.$oStaffQuery->getDql().') as staff_name,
									 ('.$oQueryServiceType->getDql().') as service_type,
									 ('.$oFndQuery->getDql().') as funeral_director,
									 ('.$oCoffinTypeQuery->getDql().') as coffin_type,
									 ('.$oOtherUnitTypeQuery->getDql().') as other_unit_type,
									 ('.$oDiseaseQuery->getDql().') as infectious_disease,
									 ('.$oChapelQuery->getDql().') as chapel_types,
								  	 ('.$oRoomQuery->getDql().') as room_types,
									 ('.$oGraveUnitTypeQuery->getDql().') as grave_unit_type,
									 ('.$oGraveStatusQuery->getDql().') as grave_status,
									 ('.$oStonemasonQuery->getDql().') as monument_stonemason,
									 ('.$oMonumnetUnitTypeQuery->getDql().') as monument_unit_type_name,
									 ('.$oDeathCountry->getDql().') as deceased_death_country,
									 ('.$oBirthCountry->getDql().') as deceased_birth_country,
									 ('.$oDeceasedCountry->getDql().') as deceased_country,
									 ('.$oApplicantCountry->getDql().') as applicant_country,
									 ')
                            ->from('IntermentBooking ib')
							->leftJoin('ib.IntermentBookingTwo ib2')
							->leftJoin('ib.IntermentBookingFour ib4')
							->leftJoin('ib.IntermentBookingFive ibfv')
							->leftJoin('ib.ArGrave ag')
							->leftJoin('ag.Country cont')
							->leftJoin('ag.CemCemetery cem')
							->leftJoin('ag.ArArea ara')
							->leftJoin('ag.ArSection sec')
							->leftJoin('ag.ArRow arr')
							->leftJoin('ag.ArPlot plt')
							->leftJoin('ag.Grantee gt')
							->leftJoin('gt.GranteeDetails gtd')							
							->andWhere('ib.id = ?', $snIntermentBookingId)
							->fetchArray();

		return $amResultSet;
	}
	//=======================================================//
	// 					FOR Display Grave Info
	//=======================================================//
    /**
	 * @todo Execute displayInfoAsPerGrave function for display grave details, grantees details, interments details.
	 *
	 * @return criteria
	 */
	public function displayInfoAsPerGrave($snIdGrave)
    {
		$amResultSet =  Doctrine_Query::create()
                            ->select('ag.grave_number, ag.latitude, ag.longitude,ag.id as grave_id,
									 count.name, cem.name, cem.latitude, cem.longitude, ara.area_name, ara.area_code, sec.section_name, sec.section_code,
									 arr.row_name, plt.plot_name, gt.id, gt.grantee_identity_number, gti.name, gtd.title,gtd.id as grantee_id,
									 gtd.grantee_surname, gtd.grantee_first_name, gtd.grantee_middle_name, gt.date_of_purchase, ib.id as interment_id,
									 ib.deceased_title, ib.deceased_surname, ib.deceased_first_name, ib.deceased_middle_name, 
									 ib.interment_date, ibf.control_number, ibf.deceased_date_of_birth, ibf.deceased_date_of_death, st.name
									 ')
                            ->from('ArGrave ag')
							->leftJoin('ag.Country count')
							->leftJoin('ag.CemCemetery cem')
							->leftJoin('ag.ArArea ara')
							->leftJoin('ag.ArSection sec')
							->leftJoin('ag.ArRow arr')
							->leftJoin('ag.ArPlot plt')
							->leftJoin('ag.Grantee gt')
							->leftJoin('gt.GranteeDetails gtd')
							->leftJoin('gt.GranteeIdentity gti')
							->leftJoin('ag.IntermentBooking ib')
							->leftJoin('ib.IntermentBookingFour ibf')
							->leftJoin('ib.ServiceType st')
							->andWhere('ag.id = ?', $snIdGrave)
							->fetchArray();

		return $amResultSet;
	}
	
	//=======================================================//
	// 					FOR Display Burial Info
	//=======================================================//
    /**
	 * @todo Execute getBurialDetailsForPrintAsPerId function for display burial details.
	 *
	 * @return criteria
	 */
	public function getBurialDetailsForPrintAsPerId($snIdInterment)
    {
		$amResultSet =  Doctrine_Query::create()
                            ->select('
                                    ib.deceased_title as deceased_title, ib.deceased_surname, ib.deceased_first_name, ib.deceased_middle_name,
                                    CONCAT(ib.deceased_first_name," ",ib.deceased_surname) as deceased_name, ib.interment_date as interment_date, ibf.control_number, 
                                    ibf.deceased_date_of_birth, ibf.deceased_date_of_death, cem.name, ag.grave_number as grave_number, ara.area_name as area_name, 
                                    sec.section_name as section_name, arr.row_name as row_name, plt.plot_name as plot_name, ag.id, ag.grave_number as grave_number, 
									')
                            ->from('IntermentBooking ib')
                            ->leftJoin('ib.IntermentBookingFour ibf')
							->leftJoin('ib.ArGrave ag')
							->leftJoin('ag.CemCemetery cem')
							->leftJoin('ag.ArArea ara')
							->leftJoin('ag.ArSection sec')
							->leftJoin('ag.ArRow arr')
							->leftJoin('ag.ArPlot plt')
							->andWhere('ib.id = ?', $snIdInterment)
							->fetchArray();

		return $amResultSet;
	}
	
	//=======================================================//
	// 					FOR Get Service Report
	//=======================================================//
    /**
	 * @todo Execute getServiceReport function for service report details.
	 *
	 * @return criteria
	 */
	public function getServiceReport($snCountryId='', $snCemeteryId='', $snAreaId='', $ssFromDate = '', $ssToDate = '', $bByAreaSection = false, $bByAreaTotal = false)
    {
		$ssFromTotDateCriteria 	= ($ssFromDate != '' && $ssToDate != '') ? "ib.interment_date >= '".$ssFromDate."' AND ib.interment_date <= '".$ssToDate."' " : '';
		
		// For Get Total Chapel
		$oChapelQuery = Doctrine_Query::create()->select("COUNT(ib1.id)")
						->from("IntermentBooking ib1")
						->leftJoin("ib1.IntermentBookingTwo ibt1")
						->Where("ibt1.cem_chapel_ids IS NOT NULL")
						->andWhere('ib1.country_id = '.$snCountryId)
						->andWhere('ib1.cem_cemetery_id = '.$snCemeteryId);
		
		// For Get Total Room
		$oRoomQuery = Doctrine_Query::create()->select("COUNT(ib2.id)")
						->from("IntermentBooking ib2")
						->leftJoin("ib2.IntermentBookingTwo ibt2")
						->Where("ibt2.cem_room_ids IS NOT NULL")
						->andWhere('ib2.country_id = '.$snCountryId)
						->andWhere('ib2.cem_cemetery_id = '.$snCemeteryId);

        if($ssFromTotDateCriteria != ''){
		    $oChapelQuery->andWhere("ib1.interment_date >= '".$ssFromDate."' AND ib1.interment_date <= '".$ssToDate."' ");
		    $oRoomQuery->andWhere("ib2.interment_date >= '".$ssFromDate."' AND ib2.interment_date <= '".$ssToDate."' ");
        }
		
        if($snAreaId == ''){
            $omCriteria =  Doctrine_Query::create()
                            ->select('st.id, ib.id, COUNT(ib.id), cem.name as cemetery_name, c.name as country_name,
                                ('.$oChapelQuery->getDql().') as chapel,
                                ('.$oRoomQuery->getDql().') as room
                            ')
							->from("IntermentBooking ib")
							->leftJoin("ib.ServiceType st")
							->leftJoin('ib.CemCemetery cem')
							->leftJoin('cem.Country c')
							->where('ib.country_id = ?', $snCountryId)
							->andWhere('ib.cem_cemetery_id = ?', $snCemeteryId)
							->groupBy('ib.service_type_id');
        }else{
            $omCriteria =  Doctrine_Query::create()
								->select('ib.id, ib.ar_area_id, ib.ar_section_id, ar.id, ar.area_name, sec.id, sec.section_name')
								->from("IntermentBooking ib")
								->leftJoin('ib.ArArea ar')
								->leftJoin('ib.ArSection sec')								    
								->Where('ib.country_id = ?', $snCountryId)
								->andWhere('ib.cem_cemetery_id = ?', $snCemeteryId)
								->andWhere('ib.ar_area_id = ?', $snAreaId);
            
            if($bByAreaSection && !$bByAreaTotal){
				$omCriteria->andWhere('ib.ar_section_id IS NOT NULL')
							->groupBy('ib.ar_section_id');
			}	

			if($bByAreaTotal && !$bByAreaSection)
				$omCriteria->groupBy('ib.ar_area_id');                                
        }
        
        if($ssFromTotDateCriteria != '')
		    $omCriteria->andWhere($ssFromTotDateCriteria);
        
        return ( $snAreaId == '' || ($bByAreaTotal && !$bByAreaSection) ) ? $omCriteria->fetchArray() : $omCriteria; 
	}
	
	//=======================================================//
	// 		FOR get count SERVICE REPORT as section wise     //
	//=======================================================//
    /**
	 * @todo Execute getCountServiceWise function FOR get count SERVICE REPORT.
	 *
	 * @return criteria
	 */
    public function getCountServiceWise($snCountryId, $snCemeteryId, $snAreaId, $snSectionId = '', $snServiceTypeId = '', $ssService = '')
    {
        $snTotalCount = Doctrine_Query::create()                                
						->from("IntermentBooking ib")								
						->Where('ib.country_id = ?', $snCountryId)
						->andWhere('ib.cem_cemetery_id = ?', $snCemeteryId)
						->andWhere('ib.ar_area_id = ?', $snAreaId)
                        ->andWhere('ib.ar_section_id = ?', $snSectionId);
        
        if($snServiceTypeId)
            $snTotalCount->andWhere("ib.service_type_id = ?", $snServiceTypeId);
        if($ssService){
            $snTotalCount->leftJoin("ib.IntermentBookingTwo ibt");
            if($ssService == 'chapel')
                $snTotalCount->Where("ibt.cem_chapel_ids IS NOT NULL");
            if($ssService == 'room')
                $snTotalCount->Where("ibt.cem_room_ids IS NOT NULL");
        }
                                
        return $snTotalCount->count();        
    }
}

