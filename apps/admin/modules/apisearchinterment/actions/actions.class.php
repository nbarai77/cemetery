<?php

/**
 * apisearchinterment actions.
 *
 * @package    cemetery
 * @subpackage apisearchinterment
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php,v 1.1.1.1 2012/03/24 12:16:57 nitin Exp $
 */
class apisearchintermentActions extends sfActions
{
	/**
	* Executes index action
	*
	* @param sfRequest $request A request object
	*/
	public function executeIndex(sfWebRequest $oRequest)
	{
		$amRequestParams = array('surname' 			=> $oRequest->getParameter('surname',''),
								 'name' 			=> $oRequest->getParameter('name',''),
								 'interment_date' 	=> $oRequest->getParameter('interment_date',''),
								 'page'				=> $oRequest->getParameter('page','1')
								);
	
		$oCommonSearch 	= new CommonSearch($amRequestParams);
		$oCommonSearch->setLogin();
		$oResponse 	= $oCommonSearch->searchInterments($amRequestParams);
		
		$oXml = new xmlParser();
		$amResponse = $oXml->xml2array($oResponse);
		
		echo "<pre>";print_R($amResponse);exit;
	}
}
