<?php
/****************************************************
search.class.php

This is the class file for the samples. This file
is used for make third party call through curl.

By: Prakash Panchal
****************************************************/

include ("conf/config.php");

class CommonSearch
{
    private $ssURL = API_ENDPOINT;
    private $ssFormat = RESPONSE_FORMAT;
    private $ssUsername = API_USERNAME;
    private $ssPassword = API_PASSWORD;

    public function getTodayServiceForInterment()
    {
		$ssURL = $this->ssURL.'todayservice';
		return $this->call($ssURL);
    }
	protected function call($ssURL)
	{
		$ch = curl_init($ssURL);
		curl_setopt( $ch, CURLOPT_USERPWD, $this->ssUsername.":".$this->ssPassword );
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_VERBOSE, 1);
        $oResponse = curl_exec($ch);

        return $oResponse;
	}
	
}
