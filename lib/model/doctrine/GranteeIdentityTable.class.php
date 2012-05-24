<?php


class GranteeIdentityTable extends Doctrine_Table
{
    
    public static function getInstance()
    {
        return Doctrine_Core::getTable('GranteeIdentity');
    }
    /**
	 * @todo Execute getGranteeIdentityList function for get All GranteeIdentityLista
	 *
     * @param array  $amExtraParameters amExtraParameters
     * @param array  $amSearch          amSearch
     * @param string $ssStatusCondition ssStatusCondition
	 * @return criteria
	 */
    public function getGranteeIdentityList($amExtraParameters = array(), $amSearch, $ssStatusCondition  = '')
    {
        if(!is_array($amExtraParameters)) 
            return false;

        $omCriteria     = Doctrine_Query::create()
                            ->select('sf.*')
                            ->from('GranteeIdentity sf');

       return common::setCriteria($omCriteria, $amExtraParameters, $ssStatusCondition, $amSearch);
    }
}