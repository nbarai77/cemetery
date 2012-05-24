<?php
/**
* @package    arp
* @subpackage CalendarHelper
* @author     Jaimin Shelat
* @version    
*/
sfProjectConfiguration::getActive()->loadHelpers(array('I18N'));
/**
 * cut of the text length using this function
 * @ use params 
 * @ params $ssTextLenght, gives text
 * @ params $snCharLength=30 , set character length 20 bye default
 */
 
function textLength($ssTextLenght,$snCharLength=20)
{
      return mb_strlen($ssTextLenght) > $snCharLength ? mb_substr($ssTextLenght,0,$snCharLength,'utf-8')."..." : $ssTextLenght;
}

/**
 * date navigation in use to increment by day, month and year
 * @ use params 
 * @ params $ssSourceDate, date ex:= '06.02.2010'
 * @ params $ssParameter, which one is increment(DAY,MONTH,YEAR)
 * @ $ssOffset , with decrement and increment for this parameter
*/
function prepareNavigation($ssSourceDate,$ssParameter,$ssOffset,$ssDateFormat)
{
    $asDate['DAY'] = 0;
    $asDate['MONTH'] = 0;
    $asDate['YEAR'] = 0;    
    $asDate[$ssParameter] = $ssOffset;                  

    return prepareDateFormat($ssDateFormat,$ssSourceDate,$asDate);
}

/**
 * return date format
 * @ use params 
 * @ params $ssSourceDate, date ex:= '06.02.2010'
 */
function prepareDateFormat($ssDateFormat,$ssSourceDate,$asDate=array('DAY' => 0,'MONTH'=> 0,'YEAR' => 0))
{
	//for split the date and generate array
	$ssCurrentDateFormat =  sfConfig::get('app_current_date_format');

	$asDateFormat=split( '([^A-Za-z])', $ssCurrentDateFormat); 
	$asSourceDate=split( '([^0-9])', $ssSourceDate); 	
	$amSourceDate = array_combine($asDateFormat,$asSourceDate);
	$amSourceDate = array_change_key_case($amSourceDate, CASE_UPPER);
	return date($ssDateFormat,mktime(0,0,0,$amSourceDate['M']+$asDate['MONTH'],$amSourceDate['D']+$asDate['DAY'],$amSourceDate['Y']+$asDate['YEAR']));  	
}

?>
