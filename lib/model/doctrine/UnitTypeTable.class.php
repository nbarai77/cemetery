<?php


class UnitTypeTable extends Doctrine_Table
{
    
    public static function getInstance()
    {
        return Doctrine_Core::getTable('UnitType');
    }
    public function getUnitTypeList($amExtraParameters = array(), $amSearch, $ssStatusCondition  = '')
    {
        if(!is_array($amExtraParameters)) 
            return false;

        $omCriteria     = Doctrine_Query::create()
                            ->select('sf.*')
                            ->from('UnitType sf');

       return common::setCriteria($omCriteria, $amExtraParameters, $ssStatusCondition, $amSearch);

    }
	/**
	 * @todo Execute getGraveUnitTypes function for get all grave status
	 *
	 * @return array $asGraveUnitType
	 */
	public function getGraveUnitTypes()
	{
		$amGraveUnitType	= Doctrine_Query::create()
							->select('ut.*')
							->from('UnitType ut')
							->where('ut.is_enabled = 1')
							->fetchArray();

		$asGraveUnitType = array();
		if(count($amGraveUnitType) > 0)
		{
			foreach($amGraveUnitType as $ssKey => $asResult)
				$asGraveUnitType[$asResult['id']] = $asResult['name'];
		}
		return $asGraveUnitType;
	}
    
}
