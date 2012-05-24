<?php


class WorkflowTable extends Doctrine_Table
{
    
    public static function getInstance()
    {
        return Doctrine_Core::getTable('Workflow');
    }
	/**
	 * @todo Execute getGraveMaintenanceList function for get Grave list as per country,cemetery,area,section and plot
	 *
	 * @return criteria
	 */
	public function getWorkOrderList($amExtraParameters = array(), $amSearch, $ssStatusCondition  = '')
    {
	    if(!is_array($amExtraParameters)) 
            return false;

		$cemeteryid = sfContext::getInstance()->getUser()->getAttribute('cemeteryid');
		$isadmin = sfContext::getInstance()->getUser()->getAttribute('issuperadmin');		

		$oQueryArea = Doctrine_Query::create()->select("ar.area_code")
						->from("ArArea ar")
						->Where("ar.id = wf.ar_area_id");

		$oQuerySection = Doctrine_Query::create()->select("ars.section_code")
						->from("ArSection ars")
						->Where("ars.id = wf.ar_section_id");

		$oQueryRow = Doctrine_Query::create()->select("arw.row_name")
						->from("ArRow arw")
						->Where("arw.id = wf.ar_row_id");	

		$oQueryPlot = Doctrine_Query::create()->select("ap.plot_name")
						->from("ArPlot ap")
						->Where("ap.id = wf.ar_plot_id");

		$oQueryGrave = Doctrine_Query::create()->select("ag.grave_number")
						->from("ArGrave ag")
						->Where("ag.id = wf.ar_grave_id");

		$oQueryDepartment = Doctrine_Query::create()->select("dd.name")
							->from("DepartmentDelegation dd")
							->Where("dd.id = wf.department_delegation");
		
		// For get Staff Name
		$oQueryName = Doctrine_Query::create()->select('CONCAT(uc.title," ",sf.first_name," ",sf.last_name) as completed_by')
						->from('sfGuardUser sf')
						->Where("sf.id = uc.user_id");

		$oQueryStaff = Doctrine_Query::create()->select('('.$oQueryName->getDql().') as completed_by')
						->from('UserCemetery uc')
						->andWhere('uc.user_id = wf.completed_by');

        $omCriteria     = Doctrine_Query::create()
                            ->select('wf.id,wf.work_date,wf.completion_date, wf.surname, CONCAT(wf.title," ",wf.name) as name,
							('.$oQueryArea->getDql().') as area_name, 
							('.$oQuerySection->getDql().') as section_name, 
							('.$oQueryRow->getDql().') as row_name, 
							('.$oQueryPlot->getDql().') as plot_name,
							('.$oQueryGrave->getDql().') as grave_number,
							('.$oQueryDepartment->getDql().') as department_name,
							('.$oQueryStaff->getDql().') as completed_by,
							')
                            ->from('Workflow wf');
							
						if($isadmin != 1)
							$omCriteria->where('wf.cem_cemetery_id = ?', $cemeteryid);

       return common::setCriteria($omCriteria, $amExtraParameters, $ssStatusCondition, $amSearch);
    }
	
	/**
	 * @todo Execute getWorkFlowDetail function for get Grave detail as per its id.
	 *
	 * @return criteria
	 */
    public function getWorkFlowDetail($snIdWorkFlow)
    {
        return $asWorkFlowDetail = Doctrine_Query::create()->select("wf.*")
						->from("Workflow wf")
						->Where("wf.id = ?", $snIdWorkFlow)
                        ->execute();
    }
}