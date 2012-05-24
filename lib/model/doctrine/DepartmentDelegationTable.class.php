<?php

class DepartmentDelegationTable extends Doctrine_Table
{
    public static function getInstance()
    {
        return Doctrine_Core::getTable('DepartmentDelegation');
    }
	/**
	 * @todo Execute getDepartmentList function for get Department delegation.
	 *
	 * @return criteria
	 */
	public function getDepartmentList($amExtraParameters = array(), $amSearch, $ssStatusCondition  = '')
    {
        if(!is_array($amExtraParameters)) 
            return false;

		$snCemId = sfContext::getInstance()->getUser()->getAttribute('cemeteryid');
		$bIsAdmin = sfContext::getInstance()->getUser()->getAttribute('issuperadmin');		
		
        $omCriteria = Doctrine_Query::create()
						->select('dd.*,cem.name as cemetery')
						->from('DepartmentDelegation dd')
						->innerJoin('dd.CemCemetery cem');

						if($bIsAdmin != 1)
							$omCriteria->where('dd.cem_cemetery_id = ?', $snCemId);

       return common::setCriteria($omCriteria, $amExtraParameters, $ssStatusCondition, $amSearch);

    }
	/**
	 * @todo Execute getAllDepartment function for get all active departments
	 *
	 * @return array $asCountries
	 */
	public static function getAllDepartment($snCemeteryId = '')
	{
		$snCemeteryId = ($snCemeteryId != '') ? $snCemeteryId : sfContext::getInstance()->getUser()->getAttribute('cemeteryid');
		
		$omDepatments = Doctrine_Query::create()
						->select('dd.id,dd.name')
						->from('DepartmentDelegation dd')
						->where('dd.is_enabled = 1');
						
		$omDepatments->where('dd.cem_cemetery_id = ?', $snCemeteryId);
		
		$amDepartments = $omDepatments->fetchArray();

		$asDepartments = array();
		if(count($amDepartments) > 0)
		{
			foreach($amDepartments as $asDataSet)
				$asDepartments[$asDataSet['id']] = $asDataSet['name'];
		}
		
		return $asDepartments;
	}
}