<?php


class CemWorktypeStonemasonTable extends Doctrine_Table
{
    
    public static function getInstance()
    {
        return Doctrine_Core::getTable('CemWorktypeStonemason');
    }
    
    public function getCemWorktypeStonemasonList($amExtraParameters = array(), $amSearch, $ssStatusCondition  = '')
    {
        if(!is_array($amExtraParameters)) 
            return false;

        $omCriteria     = Doctrine_Query::create()
                            ->select('sf.*')
                            ->from('CemWorktypeStonemason sf');

       return common::setCriteria($omCriteria, $amExtraParameters, $ssStatusCondition, $amSearch);

    }     
    
}
