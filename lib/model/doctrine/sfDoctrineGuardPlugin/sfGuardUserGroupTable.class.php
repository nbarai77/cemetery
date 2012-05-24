<?php


class sfGuardUserGroupTable extends PluginsfGuardUserGroupTable
{
    
	public function getGroupByUserId($snIdUser = '')
    {
    	if(!is_numeric($snIdUser)) return false;

    	return  Doctrine_Query::create()
    						->select('P.*, GP.*')
    						->from('sfGuardGroup P')
    						->innerJoin('P.sfGuardUserGroup GP')
    						->where('GP.user_id = ?', $snIdUser)
    						->fetchArray();
    }
}