<?php


class AwardPayRateTable extends Doctrine_Table
{
    
    public static function getInstance()
    {
        return Doctrine_Core::getTable('AwardPayRate');
    }
    
    /**
	 * @todo Execute getAllAwardPayList function for get All Pay rate awardwise.
	 *
	 * @return array
	 */
    public static function getAllAwardPayList($snIdAward)
    {
        return $amAwardPayRate = Doctrine_Query::create()
                                ->select('apr.*')
                                ->from('AwardPayRate apr')
                                ->where('apr.id_award = ?',$snIdAward)
                                ->orderBy('apr.overtime_hrs asc')
                                ->fetchArray();
    }
}