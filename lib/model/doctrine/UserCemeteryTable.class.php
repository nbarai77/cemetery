<?php
class UserCemeteryTable extends Doctrine_Table
{
    public static function getInstance()
    {
        return Doctrine_Core::getTable('UserCemetery');
    }
	/**
	 * @todo Execute getUsersAsPerCemetery function for get users as per cemetery ids
	 *
	 * @return array $amUsers
	 */
	public static function getUsersAsPerCemetery($anCemeteryIds)
	{
		$amCementery = Doctrine_Query::create()
							->select('uc.user_id as user_id')
							->from('UserCemetery uc')
							->whereIn('uc.cem_cemetery_id', $anCemeteryIds)
							->fetchArray();
		$asUser = array();
		if(count($amCementery) > 0) 
		{
			foreach($amCementery as $ssKey => $asResult)
				$asUser[] = $asResult['user_id'];
		}
		
		return $asUser;
	}
	/**
	 * @todo Execute getTitle function for get title
	 *
	 * @return array $oGuard
	 */
	public static function getTitleName($snId = ''){
		$oGuard = Doctrine::getTable('UserCemetery')->findByUserId($snId);
		if(isset($oGuard[0])) {
			return $oGuard[0]->getTitle();
		}else {
			return '';	
		}
	}
	public static function getStaffs()
	{
		$anGroupIds = array(sfConfig::get('app_cemrole_staff'), sfConfig::get('app_cemrole_normaluser'));
		$amCementery = Doctrine_Query::create()
							->select('uc.user_id as user_id')
							->from('UserCemetery uc')
							->whereIn('uc.group_id', $anGroupIds)
							->fetchArray();
		$asUser = array();
		if(count($amCementery) > 0) 
		{
			foreach($amCementery as $ssKey => $asResult)
				$asUser[] = $asResult['user_id'];
		}		
		return $asUser;
	}    	
}