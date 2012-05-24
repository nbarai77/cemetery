<?php


class sfGuardUserPermissionTable extends PluginsfGuardUserPermissionTable
{
    
	public function getPermissionByUserId($snIdUser = '')
    {
    	if(!is_numeric($snIdUser)) return false;

    	return  Doctrine_Query::create()
    						->select('P.*, GP.*')
    						->from('sfGuardPermission P')
    						->innerJoin('P.sfGuardUserPermission GP')
    						->where('GP.user_id = ?', $snIdUser)
    						->fetchArray();
    }
}