<?php


class CemCemeteryDocsTable extends Doctrine_Table
{
    
    public static function getInstance()
    {
        return Doctrine_Core::getTable('CemCemeteryDocs');
    }
    /**
	 * @todo Execute getBookingDocs function for get Booking Docs as per Booking ID
	 *
	 * @return criteria
	 */
	public function getCemeteryDocs($amExtraParameters = array(), $amSearch, $ssStatusCondition  = '')
    {
        if(!is_array($amExtraParameters)) 
            return false;

		$snCemeteryId = sfContext::getInstance()->getUser()->getAttribute('cemeteryid');

        $omCriteria	= Doctrine_Query::create()
					->select('cd.*')
					->from('CemCemeteryDocs cd')
					->where('cd.cem_cemetery_id = ?', $snCemeteryId);

       return common::setCriteria($omCriteria, $amExtraParameters, $ssStatusCondition, $amSearch);
    }
	/**
	 * @todo Execute getCemeteryDocsAsPerIds function for get cemetery docs paths as per docs ids.
	 *
	 * @return criteria
	 */
	public function getCemeteryDocsAsPerIds($anDocsIds)
    {
		$amDocsInfo = Doctrine_Query::create()
							->select('cd.id, cd.doc_path')
							->from("CemCemeteryDocs cd")
							->whereIn("cd.id",$anDocsIds)
							->fetchArray();
		return $amDocsInfo;
    }
}
