<?php


class ArGraveStatusTable extends Doctrine_Table
{
    
    public static function getInstance()
    {
        return Doctrine_Core::getTable('ArGraveStatus');
    }
	/**
	 * @todo Execute getGraveStatus function for get all grave status
	 *
	 * @return array $asGraveStatus
	 */
	public function getGraveStatus()
	{
		$amGraveStatus	= Doctrine_Query::create()
							->select('gs.*')
							->from('ArGraveStatus gs')
							->fetchArray();

		$asGraveStatus = array();
		if(count($amGraveStatus) > 0)
		{
			foreach($amGraveStatus as $ssKey => $asResult)
				$asGraveStatus[$asResult['id']] = $asResult['grave_status'];
		}
		return $asGraveStatus;
	}
}