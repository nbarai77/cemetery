<?php


class sfGuardGroupPermissionTable extends PluginsfGuardGroupPermissionTable
{
    
    public function getPermissionsByGroupId($snIdGroup = '')
    {
    	if(!is_numeric($snIdGroup)) return false;

    	return  Doctrine_Query::create()
    						->select('P.*, GP.*')
    						->from('sfGuardPermission P')
    						->innerJoin('P.sfGuardGroupPermission GP')
    						->where('GP.group_id = ?', $snIdGroup)
    						->fetchArray();
    }
    
    public function getGroupsByPermissionId($snIdPermission = '')
    {
    	if(!is_numeric($snIdPermission)) return false;

    	return  Doctrine_Query::create()
    						->select('P.*, GP.*')
    						->from('sfGuardGroup P')
    						->innerJoin('P.sfGuardGroupPermission GP')
    						->where('GP.permission_id = ?', $snIdPermission)
    						->fetchArray();
    }
}