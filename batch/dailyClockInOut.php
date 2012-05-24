<?php
    set_time_limit(0); // Maximum execution time.
    ini_set('memory_limit','128M');
    
    require_once(dirname(__FILE__).'/../config/ProjectConfiguration.class.php');
    
	$configuration = ProjectConfiguration::getApplicationConfiguration('admin', 'dev', true);
	sfContext::createInstance($configuration);
	
	// get the application instance
	sfContext::getInstance();

	$o_DataReceiveStaff = Doctrine::getTable('UserCemetery')->getStaffs();
    
	foreach($o_DataReceiveStaff as $key => $value) 
    {        
		$TimeInOut = new TimeInOut();
		$TimeInOut->setUserId($value);
		$TimeInOut->setTaskDate(date('Y-m-d'));
		$TimeInOut->setDayTypeId(1);        
		if (date("l", mktime(0,0,0,date('m'),date('d'),date('Y'))) == 'Sunday') {
			$TimeInOut->setDayTypeId(3);
		}
		$TimeInOut->setTimeIn('00:00:00');
		$TimeInOut->setTimeOut('00:00:00');
		$TimeInOut->setTotalHrs('00:00:00');
		$TimeInOut->setStatus('OUT');
		$TimeInOut->save();
	}
	exit('end');