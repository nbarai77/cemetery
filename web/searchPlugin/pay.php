<?php
/****************************************************************
paypal.php

@package     : Interment Search Plugin
@Description : Pay with PayPal
@author		 : Prakash Panchal

/****************************************************************/

include ("conf/config.php");

require_once('class/paypal.php'); //when needed
require_once('class/httprequest.php'); //when needed

//Use this form for production server 
//$r = new PayPal(true);

//Use this form for sandbox tests
$oPayPal = new PayPal();

$oResponse = $oPayPal->doExpressCheckout(AMT, DESCRIPTION, base64_decode($_REQUEST['id']));

//An error occured. The auxiliary information is in the $ret array
print_r($oResponse);

?>