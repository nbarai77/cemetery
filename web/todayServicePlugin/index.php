<?php 
/****************************************************
 * index.php
 *
 * @package    : Today Service Plugin
 * @subpackage : view
 * @author     : Prakash Panchal
 * @version    : 1.0

****************************************************/


include_once("class/search.class.php");
include_once("class/xmlParser.class.php");

$oCommonSearch  = new CommonSearch();
$oResponse  = $oCommonSearch->getTodayServiceForInterment();
 
$oXml = new xmlParser();
$amResponse = $oXml->xml2array($oResponse); 

?>
<div style="font-size: 14px;font-weight: normal;font-family: Helvetica,Arial, Sans-Serif;">
	<span style="font-size:9pt;color: #888888;text-shadow: 1px 1px 0 rgba(255, 255, 255, 0.8);"><?php echo date('l dS F, Y');?></span>
	 <?php 
	 	if(count($amResponse['interments']['response']['data']) > 0) :

			$amResultSet = $amResponse['interments']['response']['data']['row'];
			if(!isset($amResultSet[0]))
				$amResultSet = array(0 => $amResultSet);
		 
			 foreach($amResultSet as $amDataSet):?>
			 
				<p style="text-align: center;"><span style="color: #3675BC;"><?php echo date("h:i a.", strtotime($amDataSet['service_time'])).'&nbsp;'.$amDataSet['name'];?></span><br>
				<span style="color: #3675BC;">(<?php echo $amDataSet['section_code']?>)</span></p>
			  
	   <?php endforeach;
		else:
			echo '<p style="text-align: center;"><span style="color: #3675BC;">No Services Available</span></p>';
		endif;?>
</div>