<?php

/**
 * todayserviceplugin actions.
 *
 * @package    cemetery
 * @subpackage todayserviceplugin
 * @author     Prakash Panchal
 * @version    SVN: $Id: actions.class.php,v 1.1.1.1 2012/03/24 12:16:49 nitin Exp $
 */
sfProjectConfiguration::getActive()->loadHelpers(array('I18N'));
class todayserviceActions extends sfActions
{   
	/**
	* Executes index action
	*
	* @param sfRequest $request A request object
	*/
	public function executeIndex(sfWebRequest $request)
	{
		// Get cms page list for listing.
		$amTodayServices = Doctrine::getTable('IntermentBooking')->getTodayServiceForInterment();	

		$asTodayServices = array();
		$snI = 0;
		if(count($amTodayServices) > 0)
		{
			foreach($amTodayServices as $asDataSet)
			{
				$asTodayServices[$snI]['id'] 			= $asDataSet['id'];
				$asTodayServices[$snI]['name'] 			= $asDataSet['name'];
				$asTodayServices[$snI]['service_date'] 	= $asDataSet['service_date'];
				$asTodayServices[$snI]['service_time'] 	= $asDataSet['service_time'];
				$asTodayServices[$snI]['section_code'] 	= $asDataSet['section_code'];
				$snI++;
			}
		}
        $amResponse = array('data' => $asTodayServices);

		$ssXmlResponse = sfGeneral::showXML($amResponse);
		echo $ssXmlResponse;exit;
	}
	/**
	* Executes Test action
	*
	* @param sfRequest $request A request object
	*/
	public function executeTest(sfWebRequest $request)
	{
		$snUserId = $request->getParameter('userid');
		
		$amResponse = array('user_id' => $snUserId);

		$ssXmlResponse = sfGeneral::showXML($amResponse);
		echo $ssXmlResponse;exit;
	}

}
