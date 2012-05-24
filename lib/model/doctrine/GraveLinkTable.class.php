<?php


class GraveLinkTable extends Doctrine_Table
{
    public static function getInstance()
    {
        return Doctrine_Core::getTable('GraveLink');
    }
    
    /**
	 * @todo Execute getGraveLinkList function for get Grave link list as per country,cemetery,area,section and plot
	 *
	 * @return criteria
	 */
	public function getGraveLinkList($amExtraParameters = array(), $ssStatusCondition  = '', $searchResult = '')
    {
        $oGraveNoQuery = Doctrine_Query::create()
                        ->select("GROUP_CONCAT(ag.grave_number separator ', ')")
						->from("ArGrave ag")
						->where("FIND_IN_SET(a.id, g.grave_id)");
                        
        $oQueryArea = Doctrine_Query::create()->select("ar.area_code")
					->from("ArArea ar")
					->Where("ar.id = g.ar_area_id");
					
		$oQuerySection = Doctrine_Query::create()->select("ars.section_code")
					->from("ArSection ars")
					->Where("ars.id = g.ar_section_id");	
											
		$oQueryPlot = Doctrine_Query::create()->select("ap.plot_name")
					->from("ArPlot ap")
					->Where("ap.id = g.ar_plot_id");
					
		$oQueryRow = Doctrine_Query::create()->select("arw.row_name")
					->from("ArRow arw")
					->Where("arw.id = g.ar_row_id");
						
		$cemeteryid = sfContext::getInstance()->getUser()->getAttribute('cemeteryid');
		$isadmin = sfContext::getInstance()->getUser()->getAttribute('issuperadmin');		
        if(!is_array($amExtraParameters)) 
            return false;

        $omCriteria     = Doctrine_Query::create()
                            ->select('g.*,g.id, ('.$oGraveNoQuery->getDql().') as grave_id,
                            ('.$oQueryArea->getDql().') as area_name,
                            ('.$oQuerySection->getDql().') as section_name,
                            ('.$oQueryRow->getDql().') as row_name,
                            ('.$oQueryPlot->getDql().') as plot_name')                            
                            ->from('GraveLink g');
                            
		return common::setCriteria($omCriteria, $amExtraParameters, $ssStatusCondition);
    }   
    
    /**
	 * @todo Execute getGraveLinkListCount function for get total grave link list count
	 *
	 * @return criteria
	 */
	public function getGraveLinkListCount($amExtraParameters = array(), $ssStatusCondition  = '', $searchResult = '')
    {
		$cemeteryid = sfContext::getInstance()->getUser()->getAttribute('cemeteryid');
		$isadmin = sfContext::getInstance()->getUser()->getAttribute('issuperadmin');		
        if(!is_array($amExtraParameters)) 
            return false;
			
        $omCriteria     = Doctrine_Query::create()
                            ->select('COUNT(g.id) as num_rows')
                            ->from('GraveLink g');

       return common::setCriteria($omCriteria, $amExtraParameters, $ssStatusCondition);
	} 
	
	/**
	 * @todo Execute getLinkedGraveInfo function for get linked grave info
	 *
	 * @return array $amGrave
	 */
	public function getLinkedGraveInfo($snGraveId)
	{
		$amGrave = Doctrine_Query::create()
					->select('gl.grave_id')
					->from('GraveLink gl')
					->where("FIND_IN_SET(".$snGraveId.", g.grave_id)")
					->limit(1)
					->orderBy('gl.id desc')
					->fetchArray();

		return $amGrave;
	}
}
