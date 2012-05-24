<?php
/****************************************************************
paypal.php

@package     : Interment Search Plugin
@Description : This class is used for payment thorughPayPal.
@author		 : Prakash Panchal

/****************************************************************/

include ("conf/config.php");

class PayPal 
{
	//these constants you have to obtain from PayPal
	//Step-by-step manual is here: https://cms.paypal.com/us/cgi-bin/?cmd=_render-content&content_ID=developer/e_howto_api_NVPAPIBasics
	const API_USERNAME  = PLUGIN_API_USERNAME;
	const API_PASSWORD  = PLUGIN_API_PASSWORD;
	const API_SIGNATURE = PLUGIN_API_SIGNATURE;

	private $endpoint;
	private $host;
	private $gate;

	function __construct($real = false) {
		$this->endpoint = '/nvp';
		if ($real) {
			$this->host = "api-3t.paypal.com";
			$this->gate = 'https://www.paypal.com/cgi-bin/webscr?';
		} else {
			//sandbox
			$this->host = "api-3t.sandbox.paypal.com";
			$this->gate = 'https://www.sandbox.paypal.com/cgi-bin/webscr?';
		}
	}

	/**
	 * @return string URL of the "success" page
	 */
	private function getReturnTo() {
		return sprintf("%s://%s/".API_RETURN_URL,
		$this->getScheme(), $_SERVER['SERVER_NAME']);
	}

	/**
	 * @return string URL of the "cancel" page
	 */
	private function getReturnToCancel() {
		return sprintf("%s://%s/".API_CANCEL_URL,
		$this->getScheme(), $_SERVER['SERVER_NAME']);
	}

	/**
	 * @return HTTPRequest
	 */
	private function response($data){
		$r = new HTTPRequest($this->host, $this->endpoint, 'POST', true);
		$result = $r->connect($data);
		if ($result<400) return $r;
		return false;
	}

	private function buildQuery($data = array()){
		$data['USER'] = self::API_USERNAME;
		$data['PWD'] = self::API_PASSWORD;
		$data['SIGNATURE'] = self::API_SIGNATURE;
		$data['VERSION'] = '52.0';
		$query = http_build_query($data);
		return $query;
	}

	
	/**
	 * Main payment function
	 * 
	 * If OK, the customer is redirected to PayPal gateway
	 * If error, the error info is returned
	 * 
	 * @param float $amount Amount (2 numbers after decimal point)
	 * @param string $desc Item description
	 * @param string $invoice Invoice number (can be omitted)
	 * @param string $currency 3-letter currency code (USD, GBP, CZK etc.)
	 * 
	 * @return array error info
	 */
	public function doExpressCheckout($amount, $desc, $invoice='', $currency='USD'){
		$data = array(
		'PAYMENTACTION' =>'Sale',
		'AMT' =>$amount,
		'RETURNURL' =>$this->getReturnTo(),
		'CANCELURL'  =>$this->getReturnToCancel(),
		'DESC'=>$desc,
		'NOSHIPPING'=>"1",
		'ALLOWNOTE'=>"1",
		'CURRENCYCODE'=>$currency,
		'METHOD' =>'SetExpressCheckout');

		$data['CUSTOM'] = $invoice;
		//if ($invoice) $data['INVNUM'] = $invoice;

		$query = $this->buildQuery($data);

		$result = $this->response($query);

		if (!$result) return false;
		$response = $result->getContent();
		$return = $this->responseParse($response);

		if ($return['ACK'] == 'Success') {
			header('Location: '.$this->gate.'cmd=_express-checkout&useraction=commit&token='.$return['TOKEN'].'');
			die();
		}
		return($return);
	}

	public function getCheckoutDetails($token){
		$data = array(
		'TOKEN' => $token,
		'METHOD' =>'GetExpressCheckoutDetails');
		$query = $this->buildQuery($data);

		$result = $this->response($query);

		if (!$result) return false;
		$response = $result->getContent();
		$return = $this->responseParse($response);
		return($return);
	}
	public function doPayment(){
		$token = $_GET['token'];
		$payer = $_GET['PayerID'];
		$details = $this->getCheckoutDetails($token);
		if (!$details) return false;
		list($amount,$currency,$invoice) = explode('|',$details['CUSTOM']);
		$data = array(
		'PAYMENTACTION' => 'Sale',
		'PAYERID' => $payer,
		'TOKEN' =>$token,
		'AMT' => $amount,
		'CURRENCYCODE'=>$currency,
		'METHOD' =>'DoExpressCheckoutPayment');
		$query = $this->buildQuery($data);

		$result = $this->response($query);

		if (!$result) return false;
		$response = $result->getContent();
		$return = $this->responseParse($response);

		/*
		 * [AMT] => 10.00
		 * [CURRENCYCODE] => USD
		 * [PAYMENTSTATUS] => Completed
		 * [PENDINGREASON] => None
		 * [REASONCODE] => None
		 */

		return($return);
	}

	private function getScheme() {
		$scheme = 'http';
		if (isset($_SERVER['HTTPS']) and $_SERVER['HTTPS'] == 'on') {
			$scheme .= 's';
		}
		return $scheme;
	}

	private function responseParse($resp){
		$a=explode("&", $resp);
		$out = array();
		foreach ($a as $v){
			$k = strpos($v, '=');
			if ($k) {
				$key = trim(substr($v,0,$k));
				$value = trim(substr($v,$k+1));
				if (!$key) continue;
				$out[$key] = urldecode($value);
			} else {
				$out[] = $v;
			}
		}
		return $out;
	}
}

?>