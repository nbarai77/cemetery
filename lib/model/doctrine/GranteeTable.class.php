<?php


class GranteeTable extends Doctrine_Table
{
    public static function getInstance()
    {
        return Doctrine_Core::getTable('Grantee');
    }
	/**
	 * @todo Execute getGranteeList function for get All Grantee
	 *
	 * @return criteria
	 */
	public function getGranteeList($amExtraParameters = array(), $amSearch, $ssStatusCondition  = '', $snGranteeId = '')
    {
        if(!is_array($amExtraParameters)) 
            return false;

		$oQueryArea = Doctrine_Query::create()->select("ar.area_code")
					->from("ArArea ar")
					->Where("ar.id = gt.ar_area_id");
					
		$oQuerySection = Doctrine_Query::create()->select("ars.section_code")
					->from("ArSection ars")
					->Where("ars.id = gt.ar_section_id");	
											
		$oQueryPlot = Doctrine_Query::create()->select("ap.plot_name")
					->from("ArPlot ap")
					->Where("ap.id = gt.ar_plot_id");
					
		$oQueryRow = Doctrine_Query::create()->select("arw.row_name")
					->from("ArRow arw")
					->Where("arw.id = gt.ar_row_id");									

		$oSubquery = Doctrine_Query::create()->select("ag.grave_number")
					->from("ArGrave ag")
					->Where("ag.id = gt.ar_grave_id");

		$oQueryGraveHistory = Doctrine_Query::create()->select("count(ggh.id) as is_transferd_grave")
							->from("GranteeGraveHistory ggh")
							->Where("ggh.ar_grave_id = gt.ar_grave_id")
							->andWhere('ggh.grantee_details_surrender_id = gtd.id')
							->orderBy('ggh.id desc')
							->limit(1);
					
        $omCriteria	= Doctrine_Query::create()
					->select('gt.id, gt.grantee_details_id, gt.ar_grave_id, gt.date_of_purchase, gt.tenure_expiry_date, gtd.grantee_surname, gtd.grantee_first_name, 
							gtd.grantee_middle_name, gtd.cem_id, gti.name as grantee_identity_name,gt.grantee_identity_number as grantee_identity_number, 
							('.$oQueryArea->getDql().') as area_name,
							('.$oQuerySection->getDql().') as section_name,
							('.$oQueryRow->getDql().') as row_name,
							('.$oQueryPlot->getDql().') as plot_name,
							('.$oSubquery->getDql().') as grave_number,
							('.$oQueryGraveHistory->getDql().') as is_transferd_grave,
							')
							->from('Grantee gt')
					->innerJoin('gt.GranteeDetails gtd')
					->leftJoin('gt.GranteeIdentity gti');
		
		if($snGranteeId != '') 
			$omCriteria->where('gt.grantee_details_id = ?', $snGranteeId);

       return common::setCriteria($omCriteria, $amExtraParameters, $ssStatusCondition, $amSearch);

    }
    
	/**
	 * @todo Execute getGranteeList function for get All Grantee
	 *
	 * @return criteria
	 */
	public function getGranteeListAll($amExtraParameters = array(), $amSearch = array(), $ssStatusCondition  = '', $snGranteeId = '',$ssFlag = '',$ssFromDate='',$ssToDate='')
    {
        $snIdCemetery = sfContext::getInstance()->getUser()->getAttribute('cemeteryid');
        $ssFromToDateCriteria 	= (($ssFromDate != '' && $ssToDate != '') ? "gt.created_at >= '".$ssFromDate."' AND gt.created_at <= '".$ssToDate."' " : (($ssToDate != '') ? "DATE_FORMAT(gt.created_at, '%Y-%m-%d') = '".$ssToDate."'" : '') );
        
        if(!is_array($amExtraParameters)) 
            return false;

		$oQueryArea = Doctrine_Query::create()->select("ar.area_code")
					->from("ArArea ar")
					->Where("ar.id = gt.ar_area_id");
					
		$oQuerySection = Doctrine_Query::create()->select("ars.section_code")
					->from("ArSection ars")
					->Where("ars.id = gt.ar_section_id");	
											
		$oQueryPlot = Doctrine_Query::create()->select("ap.plot_name")
					->from("ArPlot ap")
					->Where("ap.id = gt.ar_plot_id");
					
		$oQueryRow = Doctrine_Query::create()->select("arw.row_name")
					->from("ArRow arw")
					->Where("arw.id = gt.ar_row_id");									

		$oSubquery = Doctrine_Query::create()->select("ag.grave_number")
					->from("ArGrave ag")
					->Where("ag.id = gt.ar_grave_id");


		$oQueryGraveHistory = Doctrine_Query::create()->select("count(ggh.id) as is_transferd_grave")
							->from("GranteeGraveHistory ggh")
							->Where("ggh.ar_grave_id = gt.ar_grave_id")
							->andWhere('ggh.grantee_details_surrender_id = gtd.id')
							->orderBy('ggh.id desc')
							->limit(1);
					
        $omCriteria	= Doctrine_Query::create()
					->select('gt.*, ct.name as catalog_name, ct.cost_price as cost_price, ct.special_cost_price as special_cost_price, gtd.grantee_surname as grantee_surname, gtd.grantee_first_name as grantee_first_name, 
							gtd.grantee_middle_name, gtd.cem_id, gti.name as grantee_identity_name,gt.grantee_identity_number as grantee_identity_number, 
							('.$oQueryArea->getDql().') as area_name,
							('.$oQuerySection->getDql().') as section_name,
							('.$oQueryRow->getDql().') as row_name,
							('.$oQueryPlot->getDql().') as plot_name,
							('.$oSubquery->getDql().') as grave_number,
							('.$oQueryGraveHistory->getDql().') as is_transferd_grave,
							')
							->from('Grantee gt')
					->leftJoin('gt.Catalog ct')
					->innerJoin('gt.GranteeDetails gtd')
					->leftJoin('gt.GranteeIdentity gti')
                    ->where('gt.cem_cemetery_id = ?',$snIdCemetery);
		if($ssFlag == true)
            $omCriteria->andwhere('gt.id = ?', $snGranteeId);
		elseif($snGranteeId != '') 
			$omCriteria->andwhere('gt.grantee_details_id = ?', $snGranteeId);
            
        if($ssFromToDateCriteria != '')
            $omCriteria->andWhere($ssFromToDateCriteria);
       return common::setCriteria($omCriteria, $amExtraParameters, $ssStatusCondition, $amSearch);

    }


	/**
	 * @todo Execute getGranteeListForSearch function for get All Grantee
	 *
	 * @return criteria
	 */
	public function getGranteeListForSearch($amExtraParameters = array(), $amSearch, $ssStatusCondition  = '')
    {	
		$cemeteryid = sfContext::getInstance()->getUser()->getAttribute('cemeteryid');
		$isadmin = sfContext::getInstance()->getUser()->getAttribute('issuperadmin');		
        if(!is_array($amExtraParameters)) 
            return false;

		$oQueryArea = Doctrine_Query::create()->select("ar.area_code")
					->from("ArArea ar")
					->Where("ar.id = gt.ar_area_id");
					
		$oQuerySection = Doctrine_Query::create()->select("ars.section_code")
					->from("ArSection ars")
					->Where("ars.id = gt.ar_section_id");	

		$oQueryPlot = Doctrine_Query::create()->select("ap.plot_name")
					->from("ArPlot ap")
					->Where("ap.id = gt.ar_plot_id");	
					
		$oQueryRow = Doctrine_Query::create()->select("arw.row_name")
					->from("ArRow arw")
					->Where("arw.id = gt.ar_row_id");


        $omCriteria	= Doctrine_Query::create()
					->select('gt.grantee_details_id as grantee_id,gt.date_of_purchase, gt.grantee_identity_number, gti.name as grantee_identity_name,
							ag1.grave_number as grave_number, gtd.title as title, gtd.grantee_surname as grantee_surname, 
							gtd.grantee_first_name as grantee_first_name, gtd.grantee_middle_name as grantee_middle_name, 
							('.$oQueryArea->getDql().') as area_name, 
							('.$oQuerySection->getDql().') as section_name, 
							('.$oQueryRow->getDql().') as row_name, 
							('.$oQueryPlot->getDql().') as plot_name')
					->from('Grantee gt')
					->innerJoin('gt.GranteeDetails gtd')
					->leftJoin('gt.GranteeIdentity gti')
					->innerJoin('gt.ArGrave ag1');

		return common::setCriteria($omCriteria, $amExtraParameters, $ssStatusCondition, $amSearch);

    }
	/**
	 * @todo Execute getGranteeListForSearchCount function for get All Grantee
	 *
	 * @return criteria
	 */
	public function getGranteeListForSearchCount($amExtraParameters = array(), $amSearch, $ssStatusCondition  = '')
    {	
        if(!is_array($amExtraParameters)) 
            return false;
			
	    $omCriteria	= Doctrine_Query::create()
					->select('COUNTY(gt.id) as num_rows')
					->from('Grantee gt')
					->leftJoin('gt.GranteeDetails gtd')
					->leftJoin('gt.ArGrave ag1');

		return common::setCriteria($omCriteria, $amExtraParameters, $ssStatusCondition, $amSearch);
	}
	/**
	 * @todo Execute getGranteeAsPerId function for get grantee as per not in Id
	 *
	 * @return array $amCementeryArea
	 */
	public function getGranteeAsPerId($snGranteeId,$snIdCemetery)
	{
		$amGrantees	= Doctrine_Query::create()
					->select('gd.id,gd.grantee_first_name')
					->from('GranteeDetails gd')
					->where('gd.id != ? ', $snGranteeId)
					->andWhere('gd.cem_id = ?',$snIdCemetery)
					->fetchArray();

		return $amGrantees;
	}
    
	/**
	 * @todo Execute getGranteeAsPerId function for get grantee as per not in Id
	 *
	 * @return array $amCementeryArea
	 */
	public function getGranteeDetailsAsPerGrave($snIdGrave)
	{
		$amGranteeDetails	= Doctrine_Query::create()
							->select("gd.id, gt.id, gt.grantee_details_id as grantee_details_id, 
									if(gd.title != '',CONCAT(gd.title,' ',gd.grantee_first_name,' ',gd.grantee_surname),CONCAT(gd.grantee_first_name,' ',gd.grantee_surname)) as grantee_name")
							->from('GranteeDetails gd')
							->leftJoin('gd.Grantee gt')
							->where('gt.ar_grave_id = ?', $snIdGrave)
							->fetchArray();

		$asGranteeList = array();
		if(count($amGranteeDetails) > 0)
		{
			foreach($amGranteeDetails as $asDataSet)
				$asGranteeList[$asDataSet['grantee_details_id']] = $asDataSet['grantee_name'];
		}
		return $asGranteeList;
	}
	/**
	 * @todo Execute getGranteeGraveDetailsAsPerId function for get grantee as per Id
	 *
	 * @return array $amCementeryArea
	 */
	public function getGranteeGraveDetailsAsPerId($snGranteeId)
	{
	    $oQueryArea = Doctrine_Query::create()->select("ara.area_name")
					->from("ArArea ara")
					->Where("ara.id = gt.ar_area_id");		
					
		$oQuerySection = Doctrine_Query::create()->select("ars.section_name")
					->from("ArSection ars")
					->Where("ars.id = gt.ar_section_id");

        $oQueryRow = Doctrine_Query::create()->select("arr.row_name")
					->from("ArRow arr")
					->Where("arr.id = gt.ar_row_id");
					
        $oQueryPlot = Doctrine_Query::create()->select("arp.plot_name")
					->from("ArPlot arp")
					->Where("arp.id = gt.ar_plot_id");				
										
		$oGraveQuery = Doctrine_Query::create()->select("ag.grave_number")
					->from("ArGrave ag")
					->Where("ag.id = gt.ar_grave_id");
					
		$amGrantees	= Doctrine_Query::create()
					->select('gd.id, gd.title as grantee_title, CONCAT(gd.grantee_first_name," ",gd.grantee_surname) as grantee_name, gt.date_of_purchase as date_of_purchase, gt.date_of_purchase as tenure_from, gt.tenure_expiry_date as tenure_to,
					    ('.$oQueryArea->getDql().') as area_name,
						('.$oQuerySection->getDql().') as section_name,
						('.$oQueryRow->getDql().') as row_name,
						('.$oQueryPlot->getDql().') as plot_name,
						('.$oGraveQuery->getDql().') as grave_number,
					')
					->from('GranteeDetails gd')
					->innerJoin('gd.Grantee gt')
					->where('gd.id = ? ', $snGranteeId)
					->fetchArray();

		return $amGrantees;
	}
	/**
	 * @todo Execute getTransferGraveDetailsAsPerGrantee function for get grantee as per Id
	 *
	 * @return array $amCementeryArea
	 */
	public function getTransferGraveDetailsAsPerGrantee($snGranteeId)
	{
		$oQuerySurrenderdName = Doctrine_Query::create()->select("CONCAT(gd1.grantee_first_name,' ',gd1.grantee_surname) as to_grantee_name")
								->from("GranteeDetails gd1")
								->Where("gd1.id = ggh.grantee_details_surrender_id");
								
        $oQueryGranteeTitle = Doctrine_Query::create()->select("gd2.title as to_grantee_title")
								->from("GranteeDetails gd2")
								->Where("gd2.id = ggh.grantee_details_surrender_id");
					
		$amGrantees	= Doctrine_Query::create()
					->select('ggh.*, ag.grave_number as grave_number, ags.section_name as section_name, aga.area_name as area_name, agr.row_name as row_name, 
					         agp.plot_name as plot_name, gd.title as from_grantee_title, gt.date_of_purchase as tenure_from, gt.tenure_expiry_date as tenure_to,
							 CONCAT(gd.grantee_first_name," ",gd.grantee_surname) as from_grantee_name,
							 ('.$oQuerySurrenderdName->getDql().') as to_grantee_name,
							 ('.$oQueryGranteeTitle->getDql().') as to_grantee_title
							')
					->from('GranteeGraveHistory ggh')
					->leftJoin('ggh.GranteeDetails gd')
					->leftJoin('ggh.ArGrave ag')
					->leftJoin('ag.ArSection ags')
					->leftJoin('ag.ArArea aga')
					->leftJoin('ag.ArRow agr')
					->leftJoin('ag.ArPlot agp')
					->leftJoin('gd.Grantee gt')
					->where('ggh.grantee_details_surrender_id = ? ', $snGranteeId)
					->orderBy('ggh.id desc')
					->limit(1)
					->fetchArray();

		return $amGrantees;
	}
	/**
	 * @todo Execute getListAllGravesOwnedByGrantee function for get grantee as per Id
	 *
	 * @return array $amCementeryArea
	 */
	public function getListAllGravesOwnedByGrantee($snGranteeId)
	{
		$amGrantees	= Doctrine_Query::create()
					->select('gt.id, gt.date_of_purchase as date_of_purchase, gd.title as title, CONCAT(gd.grantee_first_name," ",gd.grantee_surname) as grantee_name,						  
							  ag.grave_number as grave_number, ags.section_code as section_name
							')
					->from('Grantee gt')
					->leftJoin('gt.GranteeDetails gd')					
					->leftJoin('gt.ArGrave ag')
					->leftJoin('gt.ArSection ags')
					->where('gt.grantee_details_id = ? ', $snGranteeId)
					->fetchArray();

		return $amGrantees;
	}
}
