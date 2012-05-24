<?php
/**
 * sfMyPager class.
 *
 * @package    cemetery
 * @subpackage lib  
 * @author     Prakash Panchal
 * 
 */
class sfMyPager 
{
    public $oRequest;
    public $oPager;

    /**
     * Execute getResults function 
     *
     * 'This function will set the query as per paging criteria'
     * @access public 
     * @param String    $ssTableName 
     * @param Integer   $snPagesize 
     * @param Object    $oQuery 
     * @param Integer   $snCurrentPage
     * 
     */
    public function getResults($ssTableName, $snPagesize, $oQuery, $snCurrentPage,$oCountQuery = '')
    {
        $this->oPager = new sfExtendedDoctrinePager($ssTableName, $snPagesize);
        ($oCountQuery != '') ? $this->oPager->setCountQuery($oCountQuery) : $this->oPager->setCountQuery($oQuery);
        $this->oPager->setQuery($oQuery);
        $this->oPager->setPage($snCurrentPage, sfConfig::get('app_page'));
        $this->oPager->init();
        
        return $this->oPager;
    }
}

class sfExtendedDoctrinePager extends sfDoctrinePager
{
    public $oCountQuery = '';
    
    public function setCountQuery($oCountQuery)
    {
        $this->oCountQuery = $oCountQuery;
    }

    public function getCountQuery()
    {
        $query = $this->oCountQuery;
        $query->offset(0)->limit(0);

        return $query;
    }
}

