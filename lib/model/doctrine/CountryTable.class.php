<?php


class CountryTable extends Doctrine_Table
{
    
    public static function getInstance()
    {
        return Doctrine_Core::getTable('Country');
    }
    
    public function getCountryList($amExtraParameters = array(), $amSearch, $ssStatusCondition  = '')
    {
        if(!is_array($amExtraParameters)) 
            return false;

        $omCriteria     = Doctrine_Query::create()
                            ->select('sf.*')
                            ->from('Country sf');

       return common::setCriteria($omCriteria, $amExtraParameters, $ssStatusCondition, $amSearch);

    }
	/**
	 * @todo Execute getAllCountries function for get all active coutries
	 *
	 * @return array $asCountries
	 */
	public static function getAllCountries()
	{
		$asCountries = Doctrine_Query::create()
						->select('c.*')
						->from('Country c')
						->where('c.is_enabled = 1')
						->fetchArray();

		return $asCountries;
	}

	/**
	 * @todo Execute getAllCountries function for get all active coutries
	 *
	 * @return array $asCountries
	 */
	public static function getAllCountriesIdWise()
	{
		$asCountries = Doctrine_Query::create()
						->select('c.*')
						->from('Country c')
						->where('c.is_enabled = 1')
						->orderBy('c.name')
						->fetchArray();

		$asCountriesArr = array();
		if(count($asCountries) > 0)
		{
			foreach($asCountries as $ssKey => $asResult)
				$asCountriesArr[$asResult['id']] = $asResult['name'];
		}
		return $asCountriesArr;
	}	
	
    
}
