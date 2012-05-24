<?php


class AwardTable extends Doctrine_Table
{
    
    public static function getInstance()
    {
        return Doctrine_Core::getTable('Award');
    }
    
    /**
	 * @todo Execute getAllAwards function for get All Awards list
	 *
	 * @return array $asAwardsResult
	 */
	public static function getAllAwards()
	{
		$asAwardsResult = Doctrine_Query::create()
                            ->select('ad.*')
                            ->from('Award ad')
                            ->fetchArray();	
        
        $asAwards = array();
		if(count($asAwardsResult) > 0)
		{
			foreach($asAwardsResult as $ssKey => $asResult)
				$asAwards[$asResult['id']] = $asResult['name'];
		}
        return $asAwards;
	}
    
    /**
	 * @todo Execute getAwardsList function for get All Awards detail
	 *
	 * @return criteria
	 */
	public function getAwardsList($amExtraParameters = array(), $amSearch, $ssStatusCondition  = '')
    {		
		if(!is_array($amExtraParameters)) 
            return false;

        $omCriteria = Doctrine_Query::create()
						->select('ad.*')
						->from('Award ad');						

       return common::setCriteria($omCriteria, $amExtraParameters, $ssStatusCondition, $amSearch);
    }
    
    /**
	 * @todo Execute getAwardsList function for get All Awards detail
	 *
	 * @return criteria
	 */
	public function getAwardsListWithPayRate($snIdAward)
    {		
		//if(!is_numeric($snIdAward)) 
            //return false;

        $omCriteria = Doctrine_Query::create()
						->select('ad.*,apr.*')
						->from('Award ad')
                        ->leftJoin('ad.AwardPayRate apr')
                        ->where('ad.id= ?',$snIdAward)
                        ->fetchArray();

        return $omCriteria;
       //return common::setCriteria($omCriteria, $amExtraParameters, $ssStatusCondition, $amSearch);
    }
}