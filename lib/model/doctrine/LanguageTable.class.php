<?php


class LanguageTable extends Doctrine_Table
{
    
    public static function getInstance()
    {
        return Doctrine_Core::getTable('Language');
    }
	/**
	 * @todo Execute getAllLanguages function for get all active coutries
	 *
	 * @return array $omCriteria
	 */    
    public function getLanguageList($amExtraParameters = array(), $amSearch, $ssStatusCondition  = '')
    {
        if(!is_array($amExtraParameters)) 
            return false;

        $omCriteria     = Doctrine_Query::create()
                            ->select('lg.*')
                            ->from('Language lg')
                            ->where('lg.culture != ?', 'en');

       return common::setCriteria($omCriteria, $amExtraParameters, $ssStatusCondition, $amSearch);

    }    
    
	/**
	 * @todo Execute getAllLanguages function for get All Languages list
	 *
	 * @return array $amLanguages
	 */
	public static function getAllLanguages()
	{
		$ssQuery = Doctrine_Query::create()
						->select('lg.culture,lg.language_name')
						->from('Language lg');
						
			
		$amLanguages = $ssQuery->fetchArray();

		$asLanguages = array();
		if(count($amLanguages) > 0)
		{
			foreach($amLanguages as $ssKey => $asResult)
				$asLanguages[$asResult['culture']] = $asResult['language_name'];
		}
		return $asLanguages;
	}    
    
    
}
