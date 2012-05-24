<?php
/****************************************************
ppreturn.class.php

@package     : Interment Search Plugin
@Description : This file is used for make payment
@author		 : Prakash Panchal

****************************************************/


require_once('class/paypal.php'); //when needed
require_once('class/httprequest.php'); //when needed

//Use this form for production server 
//$oResponse = new PayPal(true);

//Use this form for sandbox tests
$oPayPal = new PayPal();
$amPayPalResponse = $oPayPal->getCheckoutDetails($_GET['token']);

echo "<pre>";
print_r($amCheckoutDetails);
exit;

$amPayPalFinalResponse = $oPayPal->doPayment();

if($amPayPalFinalResponse['ACK'] == 'Success') 
{
	/////////////////////////////////////////////////////////////////////////////////////
	// 		GET GRAVE DETAILS AS PER INTERMENT ID
	/////////////////////////////////////////////////////////////////////////////////////
	/*
	include_once("conf/config.php");
	include_once("class/search.class.php");
	include_once("class/xmlParser.class.php");

	$oCommonSearch 	= new CommonSearch();
	$oResponse 	= $oCommonSearch->getGraveInfo($amPayPalResponse['CUSTOM']);
		
	$oXml = new xmlParser();
	$amAPIResponse = $oXml->xml2array($oResponse);	
	$asValues = $amAPIResponse['interments']['response']['row'];
	
	$ssName = (!empty($asValues['title'])) ? $asValues['title'].' '.$asValues['name'] : $asValues['name'];
	
	$ssCemeteryName = $asValues['cem_name'];
	$ssArea = ( !empty($asValues['area_code']) ) ? $asValues['area_code'] : 'N/A';
	$ssSection = ( !empty($asValues['section_code']) ) ? $asValues['section_code'] : 'N/A';
	$ssRow = ( !empty($asValues['row_name']) ) ? $asValues['row_name'] : 'N/A';
	$ssPlot = ( !empty($asValues['plot_name']) ) ? $asValues['plot_name'] : 'N/A';
	$ssGrave = $asValues['grave_number'];

	$ssImagePath = SITE_URL.UPLOAD_DIR.'/'.GRAVE_THUMB_DIR.'/';
	$ssGraveImage = (!empty($asValues['grave_image1'])) ? $ssImagePath.$asValues['grave_image1'] : ( ( !empty($asValues['grave_image2']) ) ? $ssImagePath.$asValues['grave_image2'] : 'images/noimage.jpeg');

	$ssMessage = '<table width="50%" cellpadding="5" cellspacing="0" border="0">';
	$ssMessage .= '<tr><td colspan="3"><strong style="font-family: Arial, Helvetica, sans-serif; font-size:16px;"><u>Grave Details</u></strong></td></tr>';
	$ssMessage .= '<tr><td><b>Cemetery</b></td><td width="1%"><strong>:</strong></td><td>'.$ssCemeteryName.'</td></tr>';
	$ssMessage .= '<tr><td><b>Area</b></td><td width="1%"><strong>:</strong></td><td>'.$ssArea.'</td></tr>';
	$ssMessage .= '<tr><td><b>Section</b></td><td width="1%"><strong>:</strong></td><td>'.$ssSection.'</td></tr>';
	$ssMessage .= '<tr><td><b>Row</b></td><td width="1%"><strong>:</strong></td><td>'.$ssRow.'</td></tr>';
	$ssMessage .= '<tr><td><b>Plot</b></td><td width="1%"><strong>:</strong></td><td>'.$ssPlot.'</td></tr>';
	$ssMessage .= '<tr><td><b>Grave</b></td><td width="1%"><strong>:</strong></td><td>'.$ssGrave.'</td></tr>';
	$ssMessage .= '<tr><td><b>Grave Image</b></td><td width="1%"><strong>:</strong></td><td><img src="'.$ssGraveImage.'" alt="No Image"/></td></tr>';
	$ssMessage .= '</table>';
	
	//echo $ssMessage;

	$ssTo = 'prakash.virtueinfo@gmail.com';	//$amPayPalResponse['EMAIL'];
	$ssSubject = "Test mail";
	$ssFrom = "admin@cemetery.com";
	$ssHeader = "From:" . $ssFrom;
	mail($ssTo,$ssSubject,html_entity_decode($ssMessage),$ssHeader);
	//echo "Mail Sent.";
	*/
	header('Location: http://admin.cemetery.ntn/searchPlugin/index.php?ack='.$amPayPalFinalResponse['ACK']);
}else {
	print_r($amPayPalFinalResponse);
}
die();
?>