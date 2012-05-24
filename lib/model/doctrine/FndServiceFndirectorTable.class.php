<?php


class FndServiceFndirectorTable extends Doctrine_Table
{
    
    public static function getInstance()
    {
        return Doctrine_Core::getTable('FndServiceFndirector');
    }
    
	public function getGroupByFuneralId($snIdFuneral = '')
    {
    	if(!is_numeric($snIdFuneral)) return false;
   						
    	return  Doctrine_Query::create()
    						->select('P.*, GP.*')
    						->from('FndService P')
    						->innerJoin('P.FndServiceFndirector GP')
    						->where('GP.fnd_fndirector_id = ?', $snIdFuneral)
    						->fetchArray();    						
    						
    						
    }	    
    
}
