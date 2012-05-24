<?php

/**
 * CemCemetery
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    cemetery
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class CemCemetery extends BaseCemCemetery
{
	public function setUp()
    { 
        parent::setUp();
        $this->actAs('Timestampable');
    }
    /**
     * Function for check name exists or not.
     *
     * @access  public
     * @param   string  $smName name.
     * @param   integer $snIdGroup Optional - group id.
     * @return  mixed   object|boolean  object of record set, or
     *                  false if parameter is null
     */
    public function checkCemeteryNameExist($smName, $snIdGroup = '')
    {
        if($smName == '') return false;

        $oQuery = Doctrine_Query::create()
                                ->select('sf.name')
                                ->from('CemCemetery sf')
                                ->where('sf.name = ?', $smName);
                            
        if($snIdGroup)
            $oQuery->andwhere('sf.id != ?', $snIdGroup);

        return $oQuery->execute();
    }
	/**
	 * function updateMapPathName
	 * @todo Function update cemetery tables fields
	 * @static
	 * @param $snIdCemetery = Cemetery ID
	 * @param string $ssFieldName = Field name
	 * @param string $ssFieldValue = Field value
	 */
	public static function updateMapPathName($snIdCemetery,$ssFieldName,$ssFieldValue)
	{
		$oQuery = Doctrine_Query::create()
					->update('CemCemetery')
					->set($ssFieldName,'?',$ssFieldValue)							
					->where('id = ?', $snIdCemetery)
					->execute();
	}		
}
