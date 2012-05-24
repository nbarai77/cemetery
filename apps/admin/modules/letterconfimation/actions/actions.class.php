<?php

/**
 * letterconfimation actions.
 *
 * @package    cemetery
 * @subpackage letterconfimation
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php,v 1.1.1.1 2012/03/24 12:19:39 nitin Exp $
 */
sfProjectConfiguration::getActive()->loadHelpers(array('I18N'));
class letterconfimationActions extends sfActions
{
	 /**
     * preExecutes  action
     *
     * @access public
     * @param sfRequest $request A request object
     */
    public function preExecute()
    {
		$this->getUser()->setAttribute('from_interments',false);
        sfContext::getInstance()->getResponse()->addCacheControlHttpHeader('no-store, no-cache, must-revalidate, post-check=0, pre-check=0');

        // Declaration of messages.
        $this->amSuccessMsg = array(
                                    1 => __('Status changes successfully'),
                                    2 => __('Record has been updated successfully'),
                                    3 => __('Record has been deleted successfully'),
                                    4 => __('Record has been inserted successfully'),
									5 => __('Record has been finalized successfully'),
									6 => __('Document has been successfully uploaded'),
									7 => __('Document has been successfully download'),
									8 => __('Document has been successfully updated'),
									9 => __('Letters has been sent successfully with attachment'),
                                );

		$this->amErrorMsg   = array(
									1 => __('Select atleast one'), 
									2 => __('Some information was missing'),
									3 => __('This page is in a restricted area'),
									4 => __('Letters sending failed!'),
									5 => __('No letters select to send mail. Please select letters from Booking.')
									);
        $omRequest        = sfContext::getInstance()->getRequest();

    }
	/**
	* Executes index action
	*
	* @param sfRequest $request A request object
	*/
	public function executeIndex(sfWebRequest $oRequest)
	{
		$this->snBookingFiveId = trim($oRequest->getParameter('id',''));
		$this->ssContentType = trim($oRequest->getParameter('content_type',''));
		$this->ssToken = trim($oRequest->getParameter('token',''));
		$this->bInvalidOrExpireLink = false;

		$amExistsRecord = Doctrine::getTable('LetterConfirmation')->checkForLetterExists($this->snBookingFiveId, base64_decode($this->ssContentType));
		
		if(count($amExistsRecord) > 0 && $amExistsRecord[0]['token'] == $this->ssToken && $amExistsRecord[0]['confirmed'] == 0 )
		{
			$this->bInvalidOrExpireLink = true;
			$this->oLetterConfirmationForm = new LetterConfirmationForm();
			$this->getConfigurationFields($this->oLetterConfirmationForm);
			
			if($oRequest->isMethod('post'))
			{
				$amFormRequest = $oRequest->getParameter($this->oLetterConfirmationForm->getName());
				$this->oLetterConfirmationForm->bind($amFormRequest);

				if($this->oLetterConfirmationForm->isValid())
				{
					$amSaveData = array(
										'interment_booking_five_id'	=> $this->snBookingFiveId,
										'mail_content_type'			=> base64_decode($this->ssContentType),
										'token'						=> '',
										'confirmed'					=> $amFormRequest['confirmed']
										);

					LetterConfirmation::saveConfirmationDetails($amSaveData,'update');
					$this->getUser()->setFlash('snSuccessMsgKey', 1);
				}
			}
		}
	}
	 /**
     * getConfigurationFields
     *
     * Function for prepare configuration fields for form
     * @access private
     * @param  object $oForm form object
     *     
     */
	private function getConfigurationFields($oForm)
    {
		$oForm->setWidgets(array());
		
		 $oForm->setLabels(array('confirmed'	=> __('Letter Attachment Confirmation') ));
		$oForm->setValidators(array());				
	}
}
