<?php


class CemStonemasonDocsTable extends Doctrine_Table
{
    
    public static function getInstance()
    {
        return Doctrine_Core::getTable('CemStonemasonDocs');
    }
	/**
	 * @todo Execute getStonemasonDocs function for get Stonemason Docs as per Cemetery and Stonemason wise.
	 *
	 * @return criteria
	 */
	public function getStonemasonDocs($amExtraParameters = array(), $amSearch, $ssStatusCondition  = '', $snStoneMasonId='')
    {
        if(!is_array($amExtraParameters)) 
            return false;

		$snCemeteryId = sfContext::getInstance()->getUser()->getAttribute('cemeteryid');

        $omCriteria	= Doctrine_Query::create()
					->select('csd.*')
					->from('CemStonemasonDocs csd')
					->where('csd.cem_cemetery_id = ?', $snCemeteryId)
					->andWhere('csd.user_id = ?', $snStoneMasonId);

       return common::setCriteria($omCriteria, $amExtraParameters, $ssStatusCondition, $amSearch);
    }
	/**
	 * @todo Execute getStonemasonDocsAsPerIds function for get stonemason docs paths as per docs ids.
	 *
	 * @return criteria
	 */
	public function getStonemasonDocsAsPerIds($anDocsIds)
    {
		$amDocsInfo = Doctrine_Query::create()
							->select('csd.id, csd.doc_path')
							->from("CemStonemasonDocs csd")
							->whereIn("csd.id",$anDocsIds)
							->fetchArray();
		return $amDocsInfo;
    }
}