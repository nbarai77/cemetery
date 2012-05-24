<?php


class FndFndirectorTable extends Doctrine_Table
{
    
    public static function getInstance()
    {
        return Doctrine_Core::getTable('FndFndirector');
    }
	/**
	 * @todo Execute getFndFndirectorList function for get All Funeral director list
	 *
	 * @return array $amCementeries
	 */
	
    public function getFndFndirectorList($amExtraParameters = array(), $amSearch, $ssStatusCondition  = '')
    {
		$cemeteryid = sfContext::getInstance()->getUser()->getAttribute('cemeteryid');
		$isadmin = sfContext::getInstance()->getUser()->getAttribute('issuperadmin');		
        if(!is_array($amExtraParameters)) 
            return false;

        $omCriteria     = Doctrine_Query::create()
                            ->select('fnd.*,cem.name')
                            ->from('FndFndirector fnd')
                            ->innerJoin('fnd.CemCemetery cem');
							if($isadmin != 1) {
								$omCriteria->where('fnd.cem_cemetery_id = ?', $cemeteryid);
							}					                            

       return common::setCriteria($omCriteria, $amExtraParameters, $ssStatusCondition, $amSearch);

    } 
	/**
	 * @todo Execute getFndFndirectorListByUserRole function for get All Funeral Director list
	 *
	 * @return array $asFnd
	 */
	public static function getFndFndirectorListByUserRole()
	{
		$userid = sfContext::getInstance()->getUser()->getAttribute('userid');
		$isadmin = sfContext::getInstance()->getUser()->getAttribute('issuperadmin');
		$cemeteryid = sfContext::getInstance()->getUser()->getAttribute('cemeteryid');
		
        $omCriteria     = Doctrine_Query::create()
                            ->select('uc.*')
                            ->from('UserCemetery uc')
                            ->where('uc.group_id = 5');
							if($isadmin != 1) {
								$omCriteria->andWhere('uc.cem_cemetery_id = ?',$cemeteryid);
											
							}	
			
		$amFnd = $omCriteria->fetchArray();

		$asFnd = array();
		if(count($amFnd) > 0)
		{
			foreach($amFnd as $ssKey => $asResult)
				$asFnd[$asResult['user_id']] = $asResult['organisation'];
		}
		return $asFnd;
	}        
      
	/**
	 * @todo Execute getFuneralListAsPerCemetery function for get Funeral Directors List as per cemetery
	 * @params int 	 $snCountryId
	 * @params int 	 $snCountryId
	 * @return array $asFuneralDirectorList
	 */
	public static function getFuneralListAsPerCemetery($snCemeteryId)
	{
		$oQueryUser = Doctrine_Query::create()->select("su.first_name")
						->from("sfGuardUser su")
						->Where("su.id = uc.user_id");		
							
		$amFuneralDirector = Doctrine_Query::create()
							->select('uc.*, ('.$oQueryUser->getDql().') as first_name')
                            ->from('UserCemetery uc')
							->where('uc.cem_cemetery_id = ?',$snCemeteryId)
							->andWhere('uc.group_id = 5')
							->fetchArray();							

		$asFuneralDirectorList = array();
		if(count($amFuneralDirector) > 0)
		{
			foreach($amFuneralDirector as $ssKey => $asResult)
			{
				$ssFndName = ($asResult['title'] != '') ? $asResult['title'].' '.$asResult['first_name'] : $asResult['first_name'];
				$asFuneralDirectorList[$asResult['user_id']] = $ssFndName;
			}
		}
		return $asFuneralDirectorList;
	}
}
