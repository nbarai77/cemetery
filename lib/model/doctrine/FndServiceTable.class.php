<?php


class FndServiceTable extends Doctrine_Table
{
    
    public static function getInstance()
    {
        return Doctrine_Core::getTable('FndService');
    }
    public function getServiceList($amExtraParameters = array(), $amSearch, $ssStatusCondition  = '')
    {
        if(!is_array($amExtraParameters)) 
            return false;

        $omCriteria     = Doctrine_Query::create()
                            ->select('sf.*')
                            ->from('FndService sf');

       return common::setCriteria($omCriteria, $amExtraParameters, $ssStatusCondition, $amSearch);

    }     
        
}
