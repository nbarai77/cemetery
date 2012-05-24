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

define('API_ENDPOINT', 'http://s004.rookwoodcemetery.com.au:82/api_dev.php/');
//define('API_ENDPOINT', 'http://admin.cemetery.ntn/api_dev.php/');

/*
 # SET Response Format as you want to make api call.
*/

define('RESPONSE_FORMAT','XML');

define('DEFAULT_PAGE',1);

define('DEFAULT_PER_PAGE',10);