<?php

class aMemberdb
{
    private $oCon;
    private $oDb;

	function __construct() 
	{
		$this->oCon = mysql_connect('interments.info','intermen_live','live!@#');
		$this->oDb  = mysql_select_db('intermen_cemmembers',$this->oCon);
	}
	
    public static function registration($amData = array())
    {
		if(count($amData) > 0)
		{
			$ssFields = $ssValues = '';
			
			foreach($amData as $ssFeildName => $ssFieldValue)
			{
				$ssFields .= $ssFeildName.',';
				$ssValues .= "'".$ssFieldValue."'".',';
			}
			
			//////////////////////////////////////
			// Insert into aMember user tables	//
			//////////////////////////////////////
			$oCon = mysql_connect('interments.info','intermen_live','live!@#');
			$oDb  = mysql_select_db('intermen_cemmembers',$oCon);
			
			$ssQuery = 'INSERT INTO am_user('.trim($ssFields,',').') VALUES ('.trim($ssValues,',').');';
			
			
			if (!mysql_query($ssQuery))
			{
				die('Error: ' . mysql_error());
				exit;
			}
		}
    }
}
