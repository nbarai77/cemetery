<?php


class CemTaskNotesTable extends Doctrine_Table
{
    
    public static function getInstance()
    {
        return Doctrine_Core::getTable('CemTaskNotes');
    }
	/**
	 * @todo Execute getUserTaskNotes function for get task notes as per user wise.
	 *
	 * @return criteria
	 */
	public function getUserTaskNotes($amExtraParameters = array(), $amSearch, $ssStatusCondition  = '')
    {
        if(!is_array($amExtraParameters)) 
            return false;

		$snUserId = sfContext::getInstance()->getUser()->getAttribute('userid');

        $omCriteria	= Doctrine_Query::create()
					->select('tn.*')
					->from('CemTaskNotes tn')
					->where('tn.user_id = ?', $snUserId);

       return common::setCriteria($omCriteria, $amExtraParameters, $ssStatusCondition, $amSearch);

    }
}
