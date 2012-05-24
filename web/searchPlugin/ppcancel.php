<?php
/**********************************************************************************
ppreturn.class.php

@package     : Interment Search Plugin
@Description : This file is used for catch cancel request from paypal
@author		 : Prakash Panchal

**********************************************************************************/
include ("conf/config.php");

require_once('class/paypal.php'); //when needed
require_once('class/httprequest.php'); //when needed

//Use this form for production server 
//$oResponse = new PayPal(true);

//Use this form for sandbox tests
$oPayPal = new PayPal();
$amPayPalResponse = $oPayPal->getCheckoutDetails($_GET['token']);
$amPayPalFinalResponse = $oPayPal->doPayment();
header('Location: http://admin.cemetery.ntn/searchPlugin/index.php?ack='.$amPayPalFinalResponse['ACK']);
die();
?>