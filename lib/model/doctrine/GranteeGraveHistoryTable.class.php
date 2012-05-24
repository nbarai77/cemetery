<?php


class GranteeGraveHistoryTable extends Doctrine_Table
{
    
    public static function getInstance()
    {
        return Doctrine_Core::getTable('GranteeGraveHistory');
    }
	/**
	 * @todo Execute getGranteeGraveHistory function for get History of grantee grave.
	 *
	 * @return criteria
	 */
	public function getGranteeGraveHistory($amExtraParameters = array(), $amSearch, $ssStatusCondition  = '', $snIdGrave)
    {
        if(!is_array($amExtraParameters)) 
            return false;

		$oQueryArea = Doctrine_Query::create()->select("ar.area_code")
					->from("ArArea ar")
					->Where("ar.id = ag.ar_area_id");
					
		$oQuerySection = Doctrine_Query::create()->select("ars.section_code")
					->from("ArSection ars")
					->Where("ars.id = ag.ar_section_id");	
											
		$oQueryPlot = Doctrine_Query::create()->select("ap.plot_name")
					->from("ArPlot ap")
					->Where("ap.id = ag.ar_plot_id");
					
		$oQueryRow = Doctrine_Query::create()->select("arw.row_name")
					->from("ArRow arw")
					->Where("arw.id = ag.ar_row_id");	

		$oQueryFrom = Doctrine_Query::create()->select(" CONCAT(gtd1.grantee_first_name,' ',gtd1.grantee_surname) as surrender_from_name")
					->from("GranteeDetails gtd1")
					->Where("gtd1.id = ggh.grantee_details_id");

		$oQueryTo = Doctrine_Query::create()->select("CONCAT(gtd2.grantee_first_name,' ',gtd2.grantee_surname) as surrender_from_to")
					->from("GranteeDetails gtd2")
					->Where("gtd2.id = ggh.grantee_details_surrender_id");

        $omCriteria	= Doctrine_Query::create()
					->select('ggh.*, ag.grave_number as grave_number,
					('.$oQueryFrom->getDql().') as surrender_from_name,
					('.$oQueryTo->getDql().') as surrender_from_to,
					('.$oQueryArea->getDql().') as area_name,
					('.$oQuerySection->getDql().') as section_name,
					('.$oQueryRow->getDql().') as row_name,
					('.$oQueryPlot->getDql().') as plot_name,
					')
					->from('GranteeGraveHistory ggh')
					->leftJoin('ggh.ArGrave ag')
					->where('ggh.ar_grave_id = ?',$snIdGrave);

       return common::setCriteria($omCriteria, $amExtraParameters, $ssStatusCondition, $amSearch);

    }
    
    
    /**
	 * @todo Execute getTransferGraveCertificateForPrint function for get History of grantee grave.
	 *
	 * @return criteria
	 */
	public function getTransferGraveCertificateForPrint($snIdGrave)
    {
		$oQueryArea = Doctrine_Query::create()->select("ar.area_code")
					->from("ArArea ar")
					->Where("ar.id = ag.ar_area_id");
					
		$oQuerySection = Doctrine_Query::create()->select("ars.section_code")
					->from("ArSection ars")
					->Where("ars.id = ag.ar_section_id");	
											
		$oQueryPlot = Doctrine_Query::create()->select("ap.plot_name")
					->from("ArPlot ap")
					->Where("ap.id = ag.ar_plot_id");
					
		$oQueryRow = Doctrine_Query::create()->select("arw.row_name")
					->from("ArRow arw")
					->Where("arw.id = ag.ar_row_id");	

		$oQueryFrom = Doctrine_Query::create()->select(" CONCAT(gtd1.grantee_first_name,' ',gtd1.grantee_surname) as surrender_from_name")
					->from("GranteeDetails gtd1")
					->Where("gtd1.id = ggh.grantee_details_id");
					
        $oQueryFromTitle = Doctrine_Query::create()->select(" gtd3.title as transfer_from_title")
					->from("GranteeDetails gtd3")
					->Where("gtd3.id = ggh.grantee_details_id");
					
		$oQueryTo = Doctrine_Query::create()->select("CONCAT(gtd2.grantee_first_name,' ',gtd2.grantee_surname) as surrender_from_to")
					->from("GranteeDetails gtd2")
					->Where("gtd2.id = ggh.grantee_details_surrender_id");
        
        $oQueryToTitle = Doctrine_Query::create()->select(" gtd4.title as transfer_to_title")
					->from("GranteeDetails gtd4")
					->Where("gtd4.id = ggh.grantee_details_surrender_id");															

        $omCriteria	= Doctrine_Query::create()
					->select('ggh.*, ag.grave_number as grave_number, ag.id, gt.date_of_purchase as tenure_from, gt.tenure_expiry_date as tenure_to,
					('.$oQueryFromTitle->getDql().') as transfer_from_title,
					('.$oQueryFrom->getDql().') as transfer_from,
					('.$oQueryToTitle->getDql().') as transfer_to_title,
					('.$oQueryTo->getDql().') as transfer_to,
					('.$oQueryArea->getDql().') as area_name,
					('.$oQuerySection->getDql().') as section_name,
					('.$oQueryRow->getDql().') as row_name,
					('.$oQueryPlot->getDql().') as plot_name,
					')
					->from('GranteeGraveHistory ggh')
					->leftJoin('ggh.ArGrave ag')
					->leftJoin('ag.Grantee gt')
					->where('ggh.ar_grave_id = ?',$snIdGrave)
					->orderBy('ggh.id asc');

        return $omCriteria->fetchArray();
    }
    
    /**
	 * @todo Execute getAllGraveTransferDetailAsCemeteryWise function for get History of grantee grave.
	 *
	 * @return criteria
	 */
    public function getAllGraveTransferDetailAsCemeteryWise($snIdCemetery,$snIdHistoryGrave='',$ssFromDate='',$ssToDate='')
    {
        $ssFromToDateCriteria 	= (($ssFromDate != '' && $ssToDate != '') ? "ggh.created_at >= '".$ssFromDate."' AND ggh.created_at <= '".$ssToDate."' " : (($ssToDate != '') ? "DATE_FORMAT(ggh.created_at, '%Y-%m-%d') = '".$ssToDate."'" : '') );
        
        $oQueryArea = Doctrine_Query::create()->select("ar.area_code")
					->from("ArArea ar")
					->Where("ar.id = ag.ar_area_id");
					
		$oQuerySection = Doctrine_Query::create()->select("ars.section_code")
					->from("ArSection ars")
					->Where("ars.id = ag.ar_section_id");	
											
		$oQueryPlot = Doctrine_Query::create()->select("ap.plot_name")
					->from("ArPlot ap")
					->Where("ap.id = ag.ar_plot_id");
					
		$oQueryRow = Doctrine_Query::create()->select("arw.row_name")
					->from("ArRow arw")
					->Where("arw.id = ag.ar_row_id");	

		$oQueryFrom = Doctrine_Query::create()->select(" CONCAT(gtd1.grantee_first_name,' ',gtd1.grantee_surname) as surrender_from_name")
					->from("GranteeDetails gtd1")
					->Where("gtd1.id = ggh.grantee_details_id");

		$oQueryTo = Doctrine_Query::create()->select("CONCAT(gtd2.grantee_first_name,' ',gtd2.grantee_surname) as surrender_from_to")
					->from("GranteeDetails gtd2")
					->Where("gtd2.id = ggh.grantee_details_surrender_id");

        $omCriteria	= Doctrine_Query::create()
					->select('ggh.*, ag.grave_number as grave_number,cg.*,
					('.$oQueryFrom->getDql().') as surrender_from_name,
					('.$oQueryTo->getDql().') as surrender_from_to,
					('.$oQueryArea->getDql().') as area_name,
					('.$oQuerySection->getDql().') as section_name,
					('.$oQueryRow->getDql().') as row_name,
					('.$oQueryPlot->getDql().') as plot_name,
					')
					->from('GranteeGraveHistory ggh')
                    ->leftJoin('ggh.ArGrave ag')
                    ->leftJoin('ggh.Catalog cg')
                    ->where('ag.cem_cemetery_id = ?',$snIdCemetery);
                    
                    if($snIdHistoryGrave)
                        $omCriteria->where('ggh.id = ?',$snIdHistoryGrave);
                    
					if($ssFromToDateCriteria != '')
                        $omCriteria->andWhere($ssFromToDateCriteria);
       //return $omCriteria->fetchArray();
       //return common::setCriteria($omCriteria, $amExtraParameters, $ssStatusCondition, $amSearch);
       return common::setCriteria($omCriteria);
    }
}
