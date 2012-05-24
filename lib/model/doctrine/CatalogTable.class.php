<?php


class CatalogTable extends Doctrine_Table
{
    
    public static function getInstance()
    {
        return Doctrine_Core::getTable('Catalog');
    }
    /**
	 * @todo Execute getCatalogList function for get All Catalog detail
	 *
	 * @return criteria
	 */
	public function getCatalogList($amExtraParameters = array(), $amSearch='', $ssStatusCondition  = '')
    {		
		if(!is_array($amExtraParameters)) 
            return false;

        $omCriteria = Doctrine_Query::create()
						->select('ct.*')
						->from('Catalog ct');						

       return common::setCriteria($omCriteria, $amExtraParameters, $ssStatusCondition, $amSearch);
    }
}