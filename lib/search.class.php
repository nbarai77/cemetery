<?php

class CommonSearch
{
    private $ssURL = 'http://interments.info/live/cemetery_live/web/api_dev.php/';
    private $ssFormat = 'xml';
    private $ssUsername = '';
    private $ssPassword = '';


    public function setLogin( $ssUsername='intermen', $ssPassword='1c3m3t3ry2' )
    {
        $this->ssUsername = $ssUsername;
        $this->ssPassword = $ssPassword;
    }
    public function searchInterments($amSearchParams)
    {
		$ssURL = $this->ssURL."searchinterment/index?surname=".$amSearchParams['surname']."&name=".$amSearchParams['name']."&interment_date=".$amSearchParams['interment_date']."&page=".$amSearchParams['page'];

		return $this->call($ssURL);
    }
	protected function call($ssURL)
	{
		$ch = curl_init($ssURL);
		curl_setopt( $ch, CURLOPT_USERPWD, $this->ssUsername.":".$this->ssPassword );
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION,1);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 1);
		curl_setopt($ch, CURLOPT_VERBOSE, 1);
        $oResponse = curl_exec( $ch );
		
//		echo "<pre>";print_r($oResponse);exit;
        return $oResponse;
	}
	
}
