<?php
/****************************************************
config.php

This is the configuration file for the samples.This file
defines the parameters needed to make an API call.

By: Prakash Panchal
****************************************************/

/**
# API user: The user that is identified as making the call.
*/


define('API_USERNAME', 'intermen');
//

/**
# API_password: The password associated with the API user
*/

define('API_PASSWORD', '1c3m3t3ry2');

/**
# Endpoint: this is the server URL which you have to connect for submitting your API request.
*/

define('API_ENDPOINT', 'http://interments.info/live/cemetery_live/web/api_dev.php/');
//define('API_ENDPOINT', 'http://admin.cemetery.ntn/api_dev.php/');

/*
 # SET Response Format as you want to make api call.
*/

define('RESPONSE_FORMAT','XML');

define('DEFAULT_PAGE',1);

define('DEFAULT_PER_PAGE',10);


// Define Other Static Variables.

define('SITE_URL','http://interments.info/live/cemetery_live/web/');	//Local http://admin.cemetery.ntn/

define('UPLOAD_DIR','uploads');

define('MAP_PATH_DIR','mapPaths');

define('CEMETER_MAP_PATH','cemetery');

define('AREA_MAP_PATH','area');

define('SECTION_MAP_PATH','section');

define('ROW_MAP_PATH','row');

define('PLOT_MAP_PATH','plot');

define('GRAVE_THUMB_DIR','grave/thumbnail');


// Define PayPal Variables

// THROUGH API AUTO REDIRECT.
define('PLUGIN_API_USERNAME','prakash_seller_1306228886_biz_api1.gmail.com');
define('PLUGIN_API_PASSWORD','1306228905');
define('PLUGIN_API_SIGNATURE','An5ns1Kso7MWUdW4ErQKJJJ4qi4-AeXCU6jk57gQBZjwkS.GgxaUuow8');

define('API_RETURN_URL','searchPlugin/ppreturn.php');			// LIVE: live/cemetery_live/web/searchPlugin/ppreturn.php
define('API_CANCEL_URL','searchPlugin/ppcancel.php');			// LIVE: live/cemetery_live/web/searchPlugin/ppcancel.php

define('AMT','5');
define('DESCRIPTION','Access to show grave details');


// EXPRESS CHECKOUT
/*
define('PAYPAL_URL','https://www.sandbox.paypal.com/cgi-bin/webscr');		// SANDBOX URL: https://www.sandbox.paypal.com/cgi-bin/webscr

define('MERCHANT_ID','prakash_seller_1306228886_biz@gmail.com');		// SANDBOX MERCHANT ID: prakash.virtueinfo_1302763980_biz@gmail.com

define('RETURN_URL','http://interments.info/live/cemetery_live/web/searchPlugin/index.php');

define('CANCEL_URL','http://interments.info/live/cemetery_live/web/searchPlugin/login.php');

define('NOTIFY_URL','http://interments.info/live/cemetery_live/web/searchPlugin/login.php');

define('AMT','5');
*/