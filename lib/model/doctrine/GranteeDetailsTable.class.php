<?php


class GranteeDetailsTable extends Doctrine_Table
{
    public static function getInstance()
    {
        return Doctrine_Core::getTable('GranteeDetails');
    }
	/**
	 * @todo Execute getGranteeDetailsList function for get All Grantee
	 *
	 * @return criteria
	 */
	public function getGranteeDetailsList($amExtraParameters = array(), $amSearch, $ssStatusCondition  = '')
    {
        if(!is_array($amExtraParameters)) 
            return false;

		$cemeteryid = sfContext::getInstance()->getUser()->getAttribute('cemeteryid');
		$isadmin = sfContext::getInstance()->getUser()->getAttribute('issuperadmin');

        $omCriteria	= Doctrine_Query::create()
					->select('gd.id, gd.title,gd.grantee_first_name,gd.grantee_surname,gd.cem_id,gd.grantee_unique_id,cm.name as name, gt.grantee_details_id as grantee_id')
					->from('GranteeDetails gd')					
					->leftJoin('gd.CemCemetery cm')
					->leftJoin('gd.Grantee gt');
					
					if($isadmin != 1)
						$omCriteria->where('gd.cem_id = ?', $cemeteryid);

       return common::setCriteria($omCriteria, $amExtraParameters, $ssStatusCondition, $amSearch);
    }
	/**
	 * @todo Execute getGranteeDetailsListCount function for get Total count of Grantee
	 *
	 * @return criteria
	 */
	public function getGranteeDetailsListCount($amExtraParameters = array(), $amSearch, $ssStatusCondition  = '')
    {
        if(!is_array($amExtraParameters)) 
            return false;

		$snCemeteryId = sfContext::getInstance()->getUser()->getAttribute('cemeteryid');
		$bIsAdmin = sfContext::getInstance()->getUser()->getAttribute('issuperadmin');

        $omCriteria	= Doctrine_Query::create()
					->select('COUNT(gd.id)')
					->from('GranteeDetails gd')
					->leftJoin('gd.Grantee gt');
					
					if($bIsAdmin != 1)
						$omCriteria->where('gd.cem_id = ?', $snCemeteryId);

       return common::setCriteria($omCriteria, $amExtraParameters, $ssStatusCondition, $amSearch);
    }
	/**
	 * @todo Execute getGranteeDetailsListCount function for get Total count of Grantee
	 *
	 * @return criteria
	 */
	public function getGranteesAsPerGrave($snIdGrave)
    {
	
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

		$oQueryGraveHistory = Doctrine_Query::create()->select("count(ggh.id) as is_transferd_grave")
							->from("GranteeGraveHistory ggh")
							->Where("ggh.ar_grave_id = gt.ar_grave_id")
							->andWhere('ggh.grantee_details_surrender_id = gd.id')
							->orderBy('ggh.id desc')
							->limit(1);
							
        $omCriteria	= Doctrine_Query::create()
					->select('gd.id,gd.title,gd.grantee_first_name,gd.grantee_surname,gd.grantee_unique_id,
							gt.id as grantee_id, gt.grantee_identity_number as grantee_identity_number, gti.name as grantee_identity_name, 
							c.name as country_name,cem.name as cemetery_name, 
							('.$oQueryArea->getDql().') as area_name,
							('.$oQuerySection->getDql().') as section_name,
							('.$oQueryRow->getDql().') as row_name,
							('.$oQueryPlot->getDql().') as plot_name,
							ag.id as grave_id, ag.grave_number as grave_number,
							('.$oQueryGraveHistory->getDql().') as is_transferd_grave
							')
					->from('GranteeDetails gd')
					->innerJoin('gd.Grantee gt')
					->leftJoin('gt.GranteeIdentity gti')
					->leftJoin('gt.Country c')
					->leftJoin('gt.CemCemetery cem')
					->leftJoin('gt.ArGrave ag')
					->Where('gt.ar_grave_id = ?', $snIdGrave);
					
		return $omCriteria->fetchArray();
	}
}
