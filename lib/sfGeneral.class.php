<?php
/**
 * General class
 * 
 * @package    Common Functions 
 * @author     Arpita Rana
 * @copyright  Copyright @ 2008, Fiare OY
 * @version    $Id: sfGeneral.class.php,v 1.1.1.1 2012/03/24 11:55:30 nitin Exp $
 */
sfProjectConfiguration::getActive()->loadHelpers(array('I18N'));
class sfGeneral
{	
	/**
	 * function sendMail
	 * @todo Execute sendMail Function.Function use to send a mail
	 *
	 * @param string $ssSender = Sender Email address.
	 * @param string $ssReceiver = Receiver Email address.
	 * @param string $ssSubject = Mail Subject.
	 * @param string $ssMailBody = Mail Body
	 * @return boolean
	 */
	public static function sendMail($ssMailTo, $ssMailFrom , $ssMailSubject , $ssMailBody,$ssSentMail = false,$ssMailCc = array())
	{
		if ($ssMailTo != '' && $ssMailFrom != '' && $ssMailSubject != '' && $ssMailBody != '')
		{
			
			$oMail = sfContext::getInstance()->getMailer()->compose();
			$oMail->setSubject($ssMailSubject);
			$oMail->setTo($ssMailTo);
			$oMail->setBcc(sfConfig::get('app_bcc_email'));
			$oMail->setFrom($ssMailFrom);
			$oMail->setBody($ssMailBody, 'text/html');

			if(count($ssMailCc) > 0)
				$oMail->setCc($ssMailCc);
			
			sfContext::getInstance()->getMailer()->send($oMail);
		    return true;
		}		
		return false;	
	}
	/**
	 * function checkEmail
	 * @todo Check Email pattern is valid or not.
	 * @params $ssEmail string
	 * @return boolean
	 * @access static
	 */
	public static function checkEmail($ssEmailAddress)
	{
		$pattern = "^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$";
		$bFlag = eregi($pattern, $ssEmailAddress);
		if($bFlag)
			return true;
		else
			return false;
	}
	/**
	 * function checkEmail
	 * @todo Check Email pattern is valid or not.
	 * @params $ssEmail string
	 * @return boolean
	 * @access static
	 */
	public static function checkWebsiteUrl($ssSiteName)
	{
		$bFlag = preg_match("%(((ht|f)tp(s?))\://)?(www.|[a-zA-Z].)[a-zA-Z0-9\-\.]+\.(com|edu|gov|mil|net|org|biz|info|name|museum|us|ca|uk|in|fi)(\:[0-9]+)*(/($|[a-zA-Z0-9\.\,\;\?\'\\\+&amp;\%\$#\=~_\-]+))*%",$ssSiteName);
		
		if($bFlag)
			return true;
		else
			return false;
	}
   /**
	* function generateRandomNumber()
	* @todo generate unique random numbers
	* @param int $snLength
	* @return mixed $smPossible define possible characters	
	* @return mixed $smRandomString	
	*/	
	public static function generateRandomNumber($snLength,$smPossible)
	{
		$smRandomString = "";	 		// start with a blank password						
		$snCounter = 0; 				// set up a counter
				
		while ($snCounter < $snLength) 	// add random characters to password until length is reached
		{ 		
			$smChar = substr($smPossible, mt_rand(0, strlen($smPossible)-1), 1);    // pick a random character from the possible ones	
			$smRandomString .= $smChar;
		   	$snCounter++;
		}		
		
		return $smRandomString;	
	}
	 /**
	  * function setDateTimeFormat
	  * @todo Execute setDateTimeFormat function return Date with spacific format.
	  *
	  * @param date $ssDate Date on which format to be apply.
	  * @param date $ssDateFormat Date Format	
	  * @return date
	  */
	 static public function setDateTimeFormat($ssDate,$ssDateFormat='d.m.Y H:i:s')
	 {
	 	if ($ssDate != '')
	 		return date($ssDateFormat,strtotime($ssDate));
 		
	 	return false;
	 }
	 
	/**
	* function listingImageMimeType
	* @todo define image mime type to display images only
	* @static		
	* @return Array $amMimeTypes
	*/		
	public static function listingImageMimeType()
	{
		return $amMimeTypes = array('gif','jpeg','png','bmp','jpg');		
	}	
	/**
	  * function ssDirPath
	  * @todo create directory if not existed
	  * @param string $ssPath directory path
	  */
	 static public function createDirectory($ssDirPath)
	 {
			if(!is_dir($ssDirPath))
				@mkdir($ssDirPath);
	 }
	/**
	  * function ssFilePath
	  * @todo remove file if existed
	  * @param string $ssPath file path
	  */
	 static public function removeFile($ssFilePath)
	 {
		if(file_exists($ssFilePath))
			unlink($ssFilePath);
	 }
	/**
	  * function generateThumbNail
	  * @todo create thumbnails
	  * @param string $ssWidth define width
	  * @param string $ssHeight define height
	  * @param string $ssLoadPath path from where image load
	  * @param string $ssThumbGeneratePath thumbnail generate path
	  * @param string $ssFileName file name
	  * @param string $ssFileType type of the file
	  */
	 static public function generateThumbNail($ssWidth,$ssHeight,$ssLoadPath,$ssThumbGeneratePath,$ssFileName,$ssFileType)
	 {
		$omThumbnail = new sfThumbnail($ssWidth,$ssHeight,true,true); 
		$omThumbnail->loadFile($ssLoadPath.'/'.$ssFileName); 
		$omThumbnail->save($ssThumbGeneratePath.'/'.$ssFileName,$ssFileType);		
	 }
	/**
	* function downloadFile
	* @todo download file
	* @static		
	* @param string $ssFilePath file path
	*/		
	static function downloadFile($ssFilePath)
	{								
		$ssFileInfo = pathinfo($ssFilePath);	
		header('Content-Type: application/download');
		header("Content-transfer-encoding: binary");
		header('Content-Disposition: inline;filename='.$ssFileInfo['basename']);
		header("Pragma: no-cache");
		header('Cache-Control: maxage=0');
		readfile(sfConfig::get('sf_upload_dir').'/'.$ssFilePath);
		exit();
	}
	/**
	* function showXML
	* @todo download file
	* @param string $asResponse array
	*/	
	public static function showXML($asResponse)
	{
		$oXml = new xmlParser();
		$xmlResponse = $oXml->array_to_xml($asResponse);
		header ("Content-Type:text/xml; charset=utf-8");

		return $xmlResponse;
	}
	/**
	 * Function OnScheduleMailContent  Replace  Mail Content
	 * @param $asContent = array of old content
	 * @param $asDynamicContent = array of dynamic content
	 */
	static public function replaceMailContent($asContent,$asDynamicContent)
	{
		if(count($asContent) > 0)
		{	
			foreach($asDynamicContent as $key=>$value)
			{
				$asContent = str_replace($key, $value, $asContent);
			}
			return $asContent;
		}
		
		return false;
	}
		/**
	 * function removeSession
	 * @todo Remove session variables
	 * @property-write
	 * @static
	 */		 
	public static function removeSession()
	{
		if(sfContext::getInstance()->getUser()->hasAttribute('projectDetails'))
			sfContext::getInstance()->getUser()->getAttributeHolder()->remove('projectDetails');					
	}
	/**
	 * Function getStringBetween get Between String
	 * @param $ssString = string
	 * @param $smStart = starting char
	 * @param $smEnd = ending char
	 * return string
	 */
	static public function getStringBetween($ssString,$smStart,$smEnd)
	{
		$snPos = strpos($ssString,$smStart);
		if ($snPos == 0) return null;
		$snPos += strlen($smStart);
		$snLen = strpos($ssString,$smEnd,$snPos) - $snPos;
		
		return array($snPos+$snLen,substr($ssString,$snPos,$snLen));
	}
	
	/**
	 * Function getAllStringBetween get Between String
	 * @param $ssString = string
	 * @param $smStart = starting char
	 * @param $smEnd = ending char
	 * return string
	 */
	static public function getAllStringBetween($ssString,$smStart,$smEnd)
	{
		//Returns an array of all values which are between two tags in a set of data
		$asStrings = array();
		$snStartPos = 0;
		$snI = 0;
		while($snStartPos < strlen($ssString) && $amMatched = self::getStringBetween(substr($ssString,$snStartPos),$smStart,$smEnd))
		{
			if ($amMatched == null || $amMatched[1] == null || $amMatched[1] == '') break;
			$snStartPos = $amMatched[0]+$snStartPos+1;
			array_push($asStrings,$amMatched[1]);
			$snI++;
		}
		return $asStrings;
	}
    
	/**
	 * Function getValueOfStaticVariables get Value of Variable
	 * @param $ssType = switch case type
	 * @param $amResultSet = results in array
	 * return mix value
	 */
	static public function getValueOfStaticVariables($ssType,$amResultSet)
	{		
		
		switch($ssType)
		{
			case 'SERVICE_TYPE':
									return $amResultSet[0]['service_type'];
									break;

			case 'DATE_NOTIFIED':
									$ssDateNotified = ($amResultSet[0]['date_notified'] != '') ? $amResultSet[0]['date_notified'] : '0000-00-00';
									list($snYear,$snMonth,$snDay) = explode('-', $ssDateNotified);

									return $snDay.'-'.$snMonth.'-'.$snYear;
									break;

			case 'FUNERAL_DIRECTOR':
									 return $amResultSet[0]['funeral_director'];
									 break;

			case 'CONSULTANT':
									return $amResultSet[0]['consultant'];
									break;

			case 'SERVICE_DATE':
									$ssServiceDate = ($amResultSet[0]['service_date'] != '') ? $amResultSet[0]['service_date'] : '0000-00-00';
									list($snYear,$snMonth,$snDay) = explode('-', $ssServiceDate);

									return $snDay.'-'.$snMonth.'-'.$snYear;
									break;

			case 'SERVICE_DATE_TIME_FROM':
											return $ssServiceDate = ($amResultSet[0]['service_booking_time_from'] != '') ? $amResultSet[0]['service_booking_time_from'] : '00:00:00';
											break;

			case 'SERVICE_DATE_TIME_TO':
											return $ssServiceDate = ($amResultSet[0]['service_booking_time_to'] != '') ? $amResultSet[0]['service_booking_time_to'] : '00:00:00';
											break;
											
			case 'SERVICE_DATE_DAY':
										return $ssServiceDate = ($amResultSet[0]['date1_day'] != '') ? $amResultSet[0]['date1_day'] : '';
										break;

			case 'SERVICE_DATE2':
									$ssServiceDate = ($amResultSet[0]['service_date2'] != '') ? $amResultSet[0]['service_date2'] : '0000-00-00';
									list($snYear,$snMonth,$snDay) = explode('-', $ssServiceDate);

									return $snDay.'-'.$snMonth.'-'.$snYear;
									break;

			case 'SERVICE_DATE2_TIME_FROM':
											return $ssServiceDate = ($amResultSet[0]['service_booking2_time_from'] != '') ? $amResultSet[0]['service_booking2_time_from'] : '00:00:00';
											break;
									
			case 'SERVICE_DATE2_TIME_TO':
											return $ssServiceDate = ($amResultSet[0]['service_booking2_time_to'] != '') ? $amResultSet[0]['service_booking2_time_to'] : '00:00:00';
											break;

			case 'SERVICE_DATE2_DAY':
										return $ssServiceDate = ($amResultSet[0]['date2_day'] != '') ? $amResultSet[0]['date2_day'] : '';
										break;

			case 'SERVICE_DATE3':
									$ssServiceDate = ($amResultSet[0]['service_date3'] != '') ? $amResultSet[0]['service_date3'] : '0000-00-00';
									list($snYear,$snMonth,$snDay) = explode('-', $ssServiceDate);

									return $snDay.'-'.$snMonth.'-'.$snYear;									
									break;

			case 'SERVICE_DATE3_TIME_FROM':
											return $ssServiceDate = ($amResultSet[0]['service_booking3_time_from'] != '') ? $amResultSet[0]['service_booking3_time_from'] : '00:00:00';
											break;

			case 'SERVICE_DATE3_TIME_TO':
											return $ssServiceDate = ($amResultSet[0]['service_booking3_time_to'] != '') ? $amResultSet[0]['service_booking3_time_to'] : '00:00:00';
											break;

			case 'SERVICE_DATE3_DAY':
										return $ssServiceDate = ($amResultSet[0]['date3_day'] != '') ? $amResultSet[0]['date2_day'] : '';
										break;

			case 'DECEASED_OTHER_NAME':
										return trim($amResultSet[0]['deceased_title'].'&nbsp;'.$amResultSet[0]['deceased_other_name']);
										break;

			case 'DECEASED_GENDER':
									return $amResultSet[0]['deceased_gender'];
									break;

			case 'COFFIN_TYPE':
									return $amResultSet[0]['coffin_type'];
									break;

			case 'UNIT_TYPE':
									return $amResultSet[0]['other_unit_type'];
									break;

			case 'COFFIN_LENGTH':
									return $amResultSet[0]['IntermentBookingTwo'][0]['coffin_length'];
									break;

			case 'COFFIN_WIDTH':
									return $amResultSet[0]['IntermentBookingTwo'][0]['coffin_width'];
									break;

			case 'COFFIN_HEIGHT':
									return $amResultSet[0]['IntermentBookingTwo'][0]['coffin_height'];
									break;

			case 'COFFIN_SURCHARGE':									
									 return ($amResultSet[0]['IntermentBookingTwo'][0]['coffin_surcharge']) ? __('Yes') : __('No');
									 break;

			case 'DEATH_CERTIFICATE':
									  return ($amResultSet[0]['IntermentBookingTwo'][0]['death_certificate']) ? __('Yes') : __('No');
									  break;

			case 'INFECTIOUS_DISEASE':
										return $amResultSet[0]['infectious_disease'];
										break;

			case 'OWN_CLERGY':
									return ($amResultSet[0]['IntermentBookingTwo'][0]['own_clergy']) ? __('Yes') : __('No');
									break;

			case 'CLERGE_NAME':
									return $amResultSet[0]['IntermentBookingTwo'][0]['clergy_name'];
									break;

			case 'CHAPEL_TYPE':
									return $amResultSet[0]['chapel_types'];
									break;

			case 'CHAPEL_TIME_FROM':
									 $ssChapelFrom = ($amResultSet[0]['IntermentBookingTwo'][0]['chapel_time_from'] != '') ? $amResultSet[0]['IntermentBookingTwo'][0]['chapel_time_from'] : '0000-00-00 00:00:00';
									 list($ssDate,$ssTime) = explode(' ', $ssChapelFrom);									 
									 list($snYear,$snMonth,$snDay) = explode('-', $ssDate);

									 return $snDay.'-'.$snMonth.'-'.$snYear.'&nbsp;'.$ssTime;
									 break;

			case 'CHAPEL_TIME_TO':
									 $ssChapelTo = ($amResultSet[0]['IntermentBookingTwo'][0]['chapel_time_to'] != '') ? $amResultSet[0]['IntermentBookingTwo'][0]['chapel_time_to'] : '0000-00-00 00:00:00';
									 list($ssDate,$ssTime) = explode(' ', $ssChapelTo);									 
									 list($snYear,$snMonth,$snDay) = explode('-', $ssDate);

									 return $snDay.'-'.$snMonth.'-'.$snYear.'&nbsp;'.$ssTime;
									 break;

			case 'ROOM_TYPE':
								return $amResultSet[0]['room_types'];										
								break;

			case 'ROOM_TIME_FROM':
									 $ssRoomFrom = ($amResultSet[0]['IntermentBookingTwo'][0]['room_time_from'] != '') ? $amResultSet[0]['IntermentBookingTwo'][0]['room_time_from'] : '0000-00-00 00:00:00';
									 list($ssDate,$ssTime) = explode(' ', $ssRoomFrom);									 
									 list($snYear,$snMonth,$snDay) = explode('-', $ssDate);

									 return $snDay.'-'.$snMonth.'-'.$snYear.'&nbsp;'.$ssTime;
									 break;

			case 'ROOM_TIME_TO':
									 $ssRoomTo = ($amResultSet[0]['IntermentBookingTwo'][0]['room_time_to'] != '') ? $amResultSet[0]['IntermentBookingTwo'][0]['room_time_to'] : '0000-00-00 00:00:00';
									 list($ssDate,$ssTime) = explode(' ', $ssRoomTo);
									 list($snYear,$snMonth,$snDay) = explode('-', $ssDate);

									 return $snDay.'-'.$snMonth.'-'.$snYear.'&nbsp;'.$ssTime;
									 break;

			case 'BURNING_DRUM':
									return $amResultSet[0]['IntermentBookingTwo'][0]['burning_drum'];
									break;

			case 'FIREWORKS':
									return $amResultSet[0]['IntermentBookingTwo'][0]['fireworks'];
									break;

			case 'CEREMONIAL_SAND':
									return $amResultSet[0]['IntermentBookingTwo'][0]['ceremonial_sand'];
									break;

			case 'CANOPY':
									return $amResultSet[0]['IntermentBookingTwo'][0]['canopy'];
									break;

			case 'LOWRING_DEVICE':
									return $amResultSet[0]['IntermentBookingTwo'][0]['lowering_device'];
									break;

			case 'BALLONS':
									return $amResultSet[0]['IntermentBookingTwo'][0]['balloons'];
									break;

			case 'CHAPEL_MULTIMEDIA':
										return $amResultSet[0]['IntermentBookingTwo'][0]['chapel_multimedia'];
										break;

			case 'COST':
									return $amResultSet[0]['IntermentBookingTwo'][0]['cost'];
									break;

			case 'RECEIPT_NUMBER':
									return $amResultSet[0]['IntermentBookingTwo'][0]['receipt_number'];
									break;

			case 'SPECIAL_INSRUCTION':
										return $amResultSet[0]['IntermentBookingTwo'][0]['special_instruction'];
										break;

			case 'NOTES':
									return $amResultSet[0]['IntermentBookingTwo'][0]['notes'];
									break;

			case 'COUNTRY':
									return $amResultSet[0]['country_name'];
									break;

			case 'CEMETERY':
									return $amResultSet[0]['cemetery_name'];
									break;

			case 'AREA_CODE':
									return ($amResultSet[0]['area_code'] != '') ? $amResultSet[0]['area_code'] : __('N/A');
									break;

			case 'SECTION_CODE':	
									return ($amResultSet[0]['section_code'] != '') ? $amResultSet[0]['section_code'] : __('N/A');
									break;

			case 'ROW':
									return ($amResultSet[0]['row_name'] != '') ? $amResultSet[0]['row_name'] : __('N/A');
									break;

			case 'PLOT':
									return ($amResultSet[0]['plot_name'] != '') ? $amResultSet[0]['plot_name'] : __('N/A');
									break;

			case 'GRAVE_NUMBER':
									return ($amResultSet[0]['grave_number'] != '') ? $amResultSet[0]['grave_number'] : __('N/A');
									break;

			case 'GRAVE_LENGTH':
									return $amResultSet[0]['grave_length'];
									break;

			case 'GRAVE_WIDTH':
									return $amResultSet[0]['grave_width'];
									break;

			case 'GRAVE_HEIGHT':
									return $amResultSet[0]['grave_depth'];
									break;

			case 'GRAVE_UNIT_TYPE':
									return $amResultSet[0]['grave_unit_type'];
									break;

			case 'GRAVE_STATUS':
									return $amResultSet[0]['grave_status'];
									break;

			case 'GRAVE_COMMENT1':
									return $amResultSet[0]['grave_comment1'];
									break;

			case 'GRAVE_COMMENT2':
									return $amResultSet[0]['grave_comment2'];
									break;

			case 'GRANTEE_ADDRESS':
									$ssGranteeAddress = ($amResultSet[0]['grantee_address'] != '') ? $amResultSet[0]['grantee_address'] : __('N/A');
									
									return $ssGranteeAddress;																	
									break;
									
			case 'GRANTEE_STATE':
									$ssGranteeState = ($amResultSet[0]['grantee_state'] != '') ? $amResultSet[0]['grantee_state'] : __('N/A');
									
									return $ssGranteeState;																	
									break;
									
			case 'GRANTEE_TOWN':
									$ssGranteeTown = ($amResultSet[0]['grantee_town'] != '') ? $amResultSet[0]['grantee_town'] : __('N/A');
									
									return $ssGranteeTown;																	
									break;
									
			case 'GRANTEE_POSTAL_CODE':
									$ssGranteeTown = ($amResultSet[0]['grantee_postal_code'] != '') ? $amResultSet[0]['grantee_postal_code'] : __('N/A');
									
									return $ssGranteeTown;																	
									break;
									
									

			case 'GRANTEE_SUBURB_STATE_POSTCODE':
			
													$ssTown = ($amResultSet[0]['grantee_town'] != '') ? $amResultSet[0]['grantee_town'].' ' : '';
													$ssState = ($amResultSet[0]['grantee_state'] != '') ? $amResultSet[0]['grantee_state'].' ' : '';
													
													$smPostalAddress = (trim($ssTown.$ssState.$amResultSet[0]['grantee_postal_code']) != '') ? 
																		$ssTown.$ssState.$amResultSet[0]['grantee_postal_code'] : 
																		__('N/A');
					
													return $smPostalAddress;
													break;

			case 'GRANTEE_REMARKS1':
									  return $amResultSet[0]['grantee_comment1'];
									  break;

			case 'GRANTEE_REMARKS2':
									  return $amResultSet[0]['grantee_comment2'];
									  break;

			case 'MONUMENT_POSITION':
									  return $amResultSet[0]['grantee_comment1'];
									  break;

			case 'MONUMENT':
									  return $amResultSet[0]['monument'];
									  break;

			case 'MONUMENT_STONEMESON':
										return $amResultSet[0]['monument_stonemason'];
										break;

			case 'MONUMENT_UNIT_TYPE':
										return $amResultSet[0]['monument_unit_type_name'];
										break;

			case 'MONUMENT_DEPTH':
										return $amResultSet[0]['monuments_depth'];
										break;

			case 'MONUMENT_LENGTH':
										return $amResultSet[0]['monuments_length'];
										break;

			case 'MONUMENT_WIDTH':
										return $amResultSet[0]['monuments_width'];
										break;

			case 'INTERMENT_COMMENT1':
										return $amResultSet[0]['comment1'];
										break;

			case 'INTERMENT_COMMENT2':
										return $amResultSet[0]['comment2'];
										break;

			case 'CONTROL_NUMBER':
										return $amResultSet[0]['IntermentBookingFour'][0]['control_number'];
										break;

			case 'INTERMENT_DATE':
										$ssDOID = ($amResultSet[0]['interment_date'] != '') ? $amResultSet[0]['interment_date'] : '0000-00-00';
										list($snYear,$snMonth,$snDay) = explode('-', $ssDOID);
	
										return $snDay.'-'.$snMonth.'-'.$snYear;
										break;

			case 'DATE_OF_DEATH':
										$ssDOD = ($amResultSet[0]['IntermentBookingFour'][0]['deceased_date_of_death'] != '') ? $amResultSet[0]['IntermentBookingFour'][0]['deceased_date_of_death'] : '0000-00-00';
										list($snYear,$snMonth,$snDay) = explode('-', $ssDOD);
	
										return $snDay.'-'.$snMonth.'-'.$snYear;
										break;

			case 'DATE_OF_BIRTH':
										$ssDOB = ($amResultSet[0]['IntermentBookingFour'][0]['deceased_date_of_birth'] != '') ? $amResultSet[0]['IntermentBookingFour'][0]['deceased_date_of_birth'] : '0000-00-00';
										list($snYear,$snMonth,$snDay) = explode('-', $ssDOB);
	
										return $snDay.'-'.$snMonth.'-'.$snYear;
										break;

			case 'PLACE_OF_DEATH':
										return $amResultSet[0]['IntermentBookingFour'][0]['deceased_place_of_death'];
										break;

			case 'PLACE_OF_BIRTH':
										return $amResultSet[0]['IntermentBookingFour'][0]['deceased_place_of_birth'];
										break;

			case 'COUNTRY_OF_DEATH':
										return $amResultSet[0]['deceased_death_country'];								
									 	break;

			case 'COUNTRY_OF_BIRTH':
										return $amResultSet[0]['deceased_birth_country'];
									 	break;

			case 'DECEASED_AGE':
										return $amResultSet[0]['IntermentBookingFour'][0]['deceased_age'];
										break;

			case 'DECEASED_FINAGEUOM':
										return $amResultSet[0]['IntermentBookingFour'][0]['finageuom'];
										break;

			case 'DECEASED_USUAL_ADDRESS':
											return $amResultSet[0]['IntermentBookingFour'][0]['deceased_usual_address'];
											break;

			case 'DECEASED_SUBURB_STATE_POSTCODE':
													$ssTown = ($amResultSet[0]['IntermentBookingFour'][0]['deceased_suburb_town'] != '') ? 
																$amResultSet[0]['IntermentBookingFour'][0]['deceased_suburb_town'].' ' : 
																'';
													$ssState = ($amResultSet[0]['IntermentBookingFour'][0]['deceased_state'] != '') ? 
																$amResultSet[0]['IntermentBookingFour'][0]['deceased_state'] : 
																'';
													
													$smDeceasedPostalAddress = (trim($ssTown.$ssState.$amResultSet[0]['IntermentBookingFour'][0]['deceased_postal_code']) != '') ? 
																		$ssTown.$ssState.$amResultSet[0]['IntermentBookingFour'][0]['deceased_postal_code'] : 
																		__('N/A');
					
													return $smDeceasedPostalAddress;
													break;

			case 'DECEASED_COUNTRY':
										return $amResultSet[0]['deceased_country'];
										break;

			case 'DECEASED_MARTIAL_STAUS':
											return $amResultSet[0]['IntermentBookingFour'][0]['deceased_marital_status'];
											break;

			case 'DECEASED_PARTNER_NAME':
											return trim($amResultSet[0]['IntermentBookingFour'][0]['deceased_partner_surname'].'&nbsp;'.$amResultSet[0]['IntermentBookingFour'][0]['deceased_partner_name']);
											break;

			case 'DECEASED_FATHER_NAME':
											return trim($amResultSet[0]['IntermentBookingFour'][0]['deceased_father_surname'].'&nbsp;'.$amResultSet[0]['IntermentBookingFour'][0]['deceased_father_name']);
											break;

			case 'DECEASED_MOTHER_NAME':
										  return trim($amResultSet[0]['IntermentBookingFour'][0]['deceased_mother_maiden_surname'].'&nbsp;'.$amResultSet[0]['IntermentBookingFour'][0]['deceased_mother_name']);
										  break;

			case 'DECEASED_CHILDREN':
										  return $amResultSet[0]['IntermentBookingFour'][0]['deceased_children1'];
										  break;

			case 'CULTURAL_CALENDAR_TYPE':
											return $amResultSet[0]['IntermentBookingFour'][0]['cul_calender_type'];
											break;

			case 'CULTURAL_DATE_OF_DEATH':
											return $amResultSet[0]['IntermentBookingFour'][0]['cul_date_of_death'];
											break;

			case 'CULTURAL_DATE_OF_INTERMENT':
												return $amResultSet[0]['IntermentBookingFour'][0]['cul_date_of_interment'];
												break;

			case 'CULTURAL_DIED_AFTER_DESK':
												return ($amResultSet[0]['IntermentBookingFour'][0]['cul_died_after_dust']) ? __('Yes') : __('No');
												break;

			case 'CULTURAL_TIME_OF_DEATH':
											return $amResultSet[0]['IntermentBookingFour'][0]['cul_time_of_death'];
											break;

			case 'CULTURAL_DATE_OF_BIRTH':
											return $amResultSet[0]['IntermentBookingFour'][0]['cul_date_of_birth'];
											break;

			case 'CULTURAL_STATUS':
									return $amResultSet[0]['IntermentBookingFour'][0]['cul_status'];
									break;

			case 'CULTURAL_REMAINS_POSITION':
												return $amResultSet[0]['IntermentBookingFour'][0]['cul_remains_position'];
												break;

			case 'APPLICANT_RELATIONSHIP_WITH_DECEASED':
															return $amResultSet[0]['IntermentBookingFour'][0]['relationship_to_deceased'];
															break;            
            
           
           case 'APPLICANT_SALUTATION':                                       
                                    $ssApplicantTitle = (($amResultSet[0]['IntermentBookingFour'][0]['informant_title'] != '') ? trim($amResultSet[0]['IntermentBookingFour'][0]['informant_title']) :'');
                                    return $ssApplicantTitle;
                                    break;
            
            case 'APPLICANT_NAME':                                       
                                    $ssApplicantFirstName = (($amResultSet[0]['IntermentBookingFour'][0]['informant_first_name'] != '') ? trim($amResultSet[0]['IntermentBookingFour'][0]['informant_first_name']) :'');
                                    return $ssApplicantFirstName;
                                    break;
                                  
            case 'APPLICANT_SURNAME':  
                                    $ssApplicantSurName = (($amResultSet[0]['IntermentBookingFour'][0]['informant_surname'] != '') ? trim($amResultSet[0]['IntermentBookingFour'][0]['informant_surname']) :'');
                                    return $ssApplicantSurName;
                                    break;
                                    
            case 'APPLICANT_MIDDLENAME':  
                                    $ssApplicantMiddleName = (($amResultSet[0]['IntermentBookingFour'][0]['informant_middle_name'] != '') ? trim($amResultSet[0]['IntermentBookingFour'][0]['informant_middle_name']) :'');
                                    return $ssApplicantMiddleName;
                                    break;

			case 'APPLICANT_EMAIL':
									return $amResultSet[0]['IntermentBookingFour'][0]['informant_email'];
									break;

			case 'APPLICANT_ADDRESS':
										return $amResultSet[0]['IntermentBookingFour'][0]['informant_address'];
										break;

			case 'APPLICANT_SUBURB_STATE_POSTCODE':
													$ssTown = ($amResultSet[0]['IntermentBookingFour'][0]['informant_suburb_town'] != '') ? 
																$amResultSet[0]['IntermentBookingFour'][0]['informant_suburb_town'].' ' : 
																'';
													$ssState = ($amResultSet[0]['IntermentBookingFour'][0]['informant_state'] != '') ? 
																$amResultSet[0]['IntermentBookingFour'][0]['informant_state'].' ' : 
																'';
													
													$smApplicantPostalAddress = (trim($ssTown.$ssState.$amResultSet[0]['IntermentBookingFour'][0]['informant_postal_code']) != '') ? 
																		$ssTown.$ssState.$amResultSet[0]['IntermentBookingFour'][0]['informant_postal_code'] : 
																		__('N/A');
					
													return $smApplicantPostalAddress;
													break;
			case 'APPLICANT_COUNTRY':
										return $amResultSet[0]['applicant_country'];
										break;

			case 'APPLICANT_TELEPHONE_AREA_CODE':
													return $amResultSet[0]['IntermentBookingFour'][0]['informant_telephone_area_code'];
													break;

			case 'APPLICANT_TELEPHONE':
										return $amResultSet[0]['IntermentBookingFour'][0]['informant_telephone'];
										break;

			case 'APPLICANT_MOBILE':
									 return $amResultSet[0]['IntermentBookingFour'][0]['informant_mobile'];
									 break;

			case 'APPLICANT_FAX_AREA_CODE':
											return $amResultSet[0]['IntermentBookingFour'][0]['informant_fax_area_code'];
											break;

			case 'APPLICANT_FAX':
									return $amResultSet[0]['IntermentBookingFour'][0]['informant_fax'];
									break;

			case 'TODAY_DATE':
									return date('d-m-Y');
									break;															

			case 'STAFF_NAME':
									$ssTitle 		= sfContext::getInstance()->getUser()->getAttribute('title');
									$ssFirstName 	= sfContext::getInstance()->getUser()->getAttribute('firstname', '', 'sfGuardSecurityUser');
									$ssLastName 	= sfContext::getInstance()->getUser()->getAttribute('lastname', '', 'sfGuardSecurityUser');
									
									$ssStaffName = trim($ssTitle.'&nbsp;'.$ssFirstName.'&nbsp;'.$ssLastName);
									//$amResultSet[0]['staff_name']; Taken By Name
									return $ssStaffName;
									break;
            // Variable used in Grave Transfer Certificate
            case 'FROM_GRANTEE_TITLE':
                                    $snCount = count($amResultSet);
                                    return $amResultSet[$snCount-1]['transfer_from_title'];
                                    break;
            case 'FROM_GRANTEE_NAME':
                                    $snCount = count($amResultSet);
                                    return $amResultSet[$snCount-1]['transfer_from'];
                                    break;
            case 'TO_GRANTEE_TITLE':
                                    $snCount = count($amResultSet);
                                    return $amResultSet[$snCount-1]['transfer_to_title'];
                                    break;
            case 'TO_GRANTEE_NAME':
                                    $snCount = count($amResultSet);
                                    return $amResultSet[$snCount-1]['transfer_to'];
                                    break;
            case 'TRANSFER_GRAVE_HISTORY':
									$ssString = '';
                                    $ssString = '<table cellspacing="0" cellpadding="0" border="0">';
                                    $ssString .= '<tr><th><strong>Transfer From</strong></th>';
                                    $ssString .= '<th><strong>Transfer To</strong></th>';
                                    $ssString .= '<th><strong>Date of transaction</strong></th></tr>';
									
                                    foreach($amResultSet as $amResult)
									{
                                        $ssString .= '<tr><td>'.$amResult['transfer_from_title'].'&nbsp;'.$amResult['transfer_from'].'</td>';
                                        $ssString .= '<td>'.$amResult['transfer_to_title'].'&nbsp;'.$amResult['transfer_to'].'</td>';
                                        $ssString .= '<td>'.$amResult['surrender_date'].'</td></tr>';
                                    }
									$ssString .= '</table>';
                                    return $ssString;
                                    break;
            // Over                                    
            case 'TRANSFER_DATE':
                                    $ssDOD = ($amResultSet[0]['surrender_date'] != '') ? $amResultSet[0]['surrender_date'] : '0000-00-00';
                                    list($snYear,$snMonth,$snDay) = explode('-', $ssDOD);
	                                return $snDay.'-'.$snMonth.'-'.$snYear;
                                    break;
            // Variable used in Grave Transfer and Right of Burial Certificate
            case 'TENURE_FROM':
                                    $ssDOD = ($amResultSet[0]['tenure_from'] != '') ? $amResultSet[0]['tenure_from'] : '0000-00-00';
                                    list($snYear,$snMonth,$snDay) = explode('-', $ssDOD);
                                    return $snDay.'-'.$snMonth.'-'.$snYear;
                                    break;
            case 'TENURE_TO':
                                    $ssDOD = ($amResultSet[0]['tenure_to'] != '') ? $amResultSet[0]['tenure_to'] : '0000-00-00';
                                    list($snYear,$snMonth,$snDay) = explode('-', $ssDOD);
                                    return $snDay.'-'.$snMonth.'-'.$snYear;
                                    break;
            // Over
            case 'DATE_ISSUED':
									return date('d-m-Y');
									break;
            case 'GRANTEE_TITLE':
                                    return $amResultSet[0]['grantee_title'];
                                    break;
            case 'GRANTEE_NAME':
                                    return ($amResultSet[0]['grantee_name'] != '') ? $amResultSet[0]['grantee_name'] : __('N/A');
                                    break;                                    
            
			case 'GRANTEE_SALUTATION':                                
                                    if(isset($amResultSet[0]['Grantee']))
                                    {
                                    $asTitle = array();
                                    foreach($amResultSet[0]['Grantee'] as $snKey => $asDataSet)
                                        $asTitle[] = ($asDataSet['GranteeDetails']['title'] != '') ? $asDataSet['GranteeDetails']['title'] : '';
									
									return $asTitle;
                                    }
                                    else                                        
                                        return $asTitle = ($amResultSet[0]['grantee_title'] != '') ? $amResultSet[0]['grantee_title'] : '';
									break;
									                           
            
            case 'GRANTEE_FIRSTNAME':									
                                    if(isset($amResultSet[0]['Grantee']))
                                    {
                                    $asFirstName = array();
                                    foreach($amResultSet[0]['Grantee'] as $snKey => $asDataSet)
                                        $asFirstName[] = ($asDataSet['GranteeDetails']['grantee_first_name'] != '') ? $asDataSet['GranteeDetails']['grantee_first_name'] : '';
									
									return $asFirstName;
                                    }
                                    else
                                         return $asFirstName = ($amResultSet[0]['grantee_first_name'] != '') ? $amResultSet[0]['grantee_first_name'] : '';
									break;
                                    
            case 'GRANTEE_MIDDLENAME':									
                                    if(isset($amResultSet[0]['Grantee']))
                                    {
                                    $asMiddleName = array();
                                    foreach($amResultSet[0]['Grantee'] as $snKey => $asDataSet)
                                        $asMiddleName[] =  ($asDataSet['GranteeDetails']['grantee_middle_name'] != '') ? $asDataSet['GranteeDetails']['grantee_middle_name'] : '';
                                        
									return $asMiddleName;
                                    }
                                    else
                                        return $asMiddleName = ($amResultSet[0]['grantee_middle_name'] != '') ? $amResultSet[0]['grantee_middle_name'] : '';
                                    
									break;
                                    
            case 'GRANTEE_SURNAME':
									
                                    if(isset($amResultSet[0]['Grantee']))
                                    {
                                    $asSurName = array();
                                    foreach($amResultSet[0]['Grantee'] as $snKey => $asDataSet)
                                        $asSurName[] = ($asDataSet['GranteeDetails']['grantee_surname'] != '') ? $asDataSet['GranteeDetails']['grantee_surname'] : '';
                                        
									return $asSurName;
                                    }
                                    else                                    
                                        return $asSurName = ($amResultSet[0]['grantee_surname'] != '') ? $amResultSet[0]['grantee_surname'] : 'ssss';
									break;
            
            case 'ADDRESS':
									$asAddress = array();
                                    foreach($amResultSet[0]['Grantee'] as $snKey => $asDataSet)
                                        $asAddress[] = ($asDataSet['GranteeDetails']['grantee_address'] != '') ? $asDataSet['GranteeDetails']['grantee_address'] : '';
                                    
                                    return $asAddress;
									break;
            
            case 'TOWN':			
									$asTown = array();
                                    foreach($amResultSet[0]['Grantee'] as $snKey => $asDataSet)
                                        $asTown[]  = ($asDataSet['GranteeDetails']['town'] != '') ? $asDataSet['GranteeDetails']['town'] : '';
                                    
									return $asTown;
									break;
                                    
            case 'STATE':
									$asState = array();
                                    foreach($amResultSet[0]['Grantee'] as $snKey => $asDataSet)
                                        $asState[] =($asDataSet['GranteeDetails']['state'] != '') ? $asDataSet['GranteeDetails']['state'] : '';
                                    
									return $asState;
									break;
            
            case 'POSTALCODE':      
                                    $asPostalCode = array();
                                    foreach($amResultSet[0]['Grantee'] as $snKey => $asDataSet)
                                        $asPostalCode[] = ($asDataSet['GranteeDetails']['postal_code'] != '') ? $asDataSet['GranteeDetails']['postal_code'] : '';                                        
                                    
									return $asPostalCode;
									break;
				
				
			case 'SELECTED_DATE':									
									return $amResultSet;
									break;
														
			case 'TIME':									
									$asTime = array();
                                    foreach($amResultSet as $snKey => $asDataSet)
                                        $asTime[] = ($asDataSet['service_booking_time_from'] != '') ? strftime("%H:%M",strtotime($asDataSet['service_booking_time_from'])) .'-'. strftime("%H:%M",strtotime($asDataSet['service_booking_time_to']) ) : '';
									
									return $asTime;
									break;
									
			case 'NAME':									
									$asName = array();
                                    foreach($amResultSet as $snKey => $asDataSet)
                                        $asName[] = ($asDataSet['deceased_surname'] != '') ? $asDataSet['deceased_surname'] : '';
									
									return $asName;
									break;
									
			case 'SURNAME':									
									$asSurname = array();
                                    foreach($amResultSet as $snKey => $asDataSet)
                                        $asSurname[] = ($asDataSet['deceased_first_name'] != '') ? $asDataSet['deceased_first_name'] : '';
									
									return $asSurname;
									break;
									
			case 'INTERMENT_AREA_NAME':									
									$asIntermentArea = array();
                                    foreach($amResultSet as $snKey => $asDataSet)
                                        $asIntermentArea[] = ($asDataSet['area_name'] != '') ? $asDataSet['area_name'] : __('N/A');
									
									return $asIntermentArea;
									break;
									
			case 'INTERMENT_SECTION_NAME':									
									$asIntermentSection = array();
                                    foreach($amResultSet as $snKey => $asDataSet)
                                        $asIntermentSection[] = ($asDataSet['section_name'] != '') ? $asDataSet['section_name'] : __('N/A');
									
									return $asIntermentSection;
									break;
									
			case 'INTERMENT_GRAVE_NUMBER':									
									$asIntermentGraveNumber = array();
                                    foreach($amResultSet as $snKey => $asDataSet)
                                        $asIntermentGraveNumber[] = ($asDataSet['grave_number'] != '') ? $asDataSet['grave_number'] : __('N/A');
									
									return $asIntermentGraveNumber;
									break;
									
									
                                    
			case 'SHOW_GRAVE_GRANTEES':	
										$ssString = '';
										$ssString = '<table cellspacing="0" cellpadding="0" border="0">';
										//$ssString .= "<tr><th><strong>&nbsp;Grantee's Address</strong></th></tr>";
										foreach($amResultSet[0]['Grantee'] as $snKey => $asDataSet)
										{											
											$ssGranteeName = ($asDataSet['GranteeDetails']['title'] != '') 
																? $asDataSet['GranteeDetails']['title'].'&nbsp;'.$asDataSet['GranteeDetails']['grantee_name']
																: $asDataSet['GranteeDetails']['grantee_name'];											
                                            
                                            $ssAddress = ($asDataSet['GranteeDetails']['grantee_address'] != '') ? $asDataSet['GranteeDetails']['grantee_address'].' ' : '';
                                            $ssTown = ($asDataSet['GranteeDetails']['town'] != '') ? $asDataSet['GranteeDetails']['town'].' ' : '';
											$ssState = ($asDataSet['GranteeDetails']['state'] != '') ? $asDataSet['GranteeDetails']['state'].' ' : '';
                                            $ssPostalCode = ($asDataSet['GranteeDetails']['postal_code'] != '') ? $asDataSet['GranteeDetails']['postal_code'] : '';
                                            
											$smPostalAddress = (trim($ssAddress.$ssTown.$ssState.$ssPostalCode) != '') ? 
																		$ssAddress.$ssTown.$ssState.$ssPostalCode : 
																		__('N/A');
					
													
											$ssString .= '<tr><td>&nbsp;'.$ssGranteeName.", ".$smPostalAddress.'</td></tr>';
										}
										$ssString .= '</table>';
                                   		return $ssString;
										break;

            case 'DECEASED_SALUTATION':
                                    return $amResultSet[0]['deceased_title'];
                                    break;
            case 'DECEASED_FIRSTNAME':
                                    return $amResultSet[0]['deceased_title'];
                                    break;
            
            case 'DECEASED_MIDDLENAME':
                                    return $amResultSet[0]['deceased_middle_name'];
                                    break;
                                    
            case 'DECEASED_SURNAME':
                                    return $amResultSet[0]['deceased_surname'];
                                    break;
                                    
            case 'DECEASED_OTHER_SALUTATION':
                                    return $amResultSet[0]['deceased_title'];
                                    break;
                                    
            case 'DECEASED_OTHER_FIRSTNAME':
                                    return $amResultSet[0]['deceased_other_first_name'];
                                    break;
            
            case 'DECEASED_OTHER_MIDDLENAME':
                                    return $amResultSet[0]['deceased_other_middle_name'];
                                    break;
                                    
            case 'DECEASED_OTHER_SURNAME':
                                    return $amResultSet[0]['deceased_surname'];
                                    break;
                                    
            // Variable used in Burial Certificate
            case 'DECEASED_TITLE':
                                    return $amResultSet[0]['deceased_title'];
                                    break;
            case 'DECEASED_NAME':
                                    return $amResultSet[0]['deceased_name'];
                                    break;
            case 'DATE_OF_BURIAL':
                                    $ssDOD = ($amResultSet[0]['interment_date'] != '') ? $amResultSet[0]['interment_date'] : '0000-00-00';
                                    list($snYear,$snMonth,$snDay) = explode('-', $ssDOD);
                                    return $snDay.'-'.$snMonth.'-'.$snYear;
                                    break;        
            // Over                            		
            case 'AREA_NAME':
                                    return ($amResultSet[0]['area_name'] != '') ? $amResultSet[0]['area_name'] : __('N/A');
                                    break;
            case 'SECTION_NAME':
                                    return ($amResultSet[0]['section_name'] != '') ? $amResultSet[0]['section_name'] : __('N/A');
                                    break;    
            case 'ROW_NAME':
                                    return ($amResultSet[0]['row_name'] != '') ? $amResultSet[0]['row_name'] : __('N/A');
                                    break;
            case 'BLOCK_PLOT_NAME':
                                    return ($amResultSet[0]['plot_name'] != '') ? $amResultSet[0]['plot_name'] : __('N/A');
                                    break;
		}
	}
    
    /**
	 * Function getAndSetWHMSDetail get Value of Variable
	 * @param $ssAction     switch case type
	 * @param $asPostFields results in array
	 * return  array
	 */
    public static function getAndSetWHMSDetail($ssAction, $asPostFields = array())
    {
        $url = "http://bruntech.net.au/clients/includes/api.php"; # URL to WHMCS API file goes here
        $username = "nitinbarai"; # Admin username goes here
        $password = "nitinbarai"; # Admin password goes here
        //$postfields = array();
        $asPostFields["username"] = $username;
        $asPostFields["password"] = md5($password);
        $asPostFields["accesskey"] = "bruntech123";
        $asPostFields["action"] = $ssAction;
        $asPostFields["responsetype"] = "xml";
         
        $query_string = "";
        foreach ($asPostFields AS $k=>$v) $query_string .= "$k=".urlencode($v)."&";
         
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $query_string);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $xml = curl_exec($ch);
        if (curl_error($ch) || !$xml) $xml = '<whmcsapi><result>error</result>'.
        '<message>Connection Error</message><curlerror>'.
        curl_errno($ch).' - '.curl_error($ch).'</curlerror></whmcsapi>';
        curl_close($ch);
         
        $arr = sfGeneral::whmcsapixmlparser($xml); # Parse XML
        return $arr;
    }
    
    /**
	 * Function whmcsapixmlparser get Value of Variable
	 * @param $rawxml     switch case type	
	 * return  string as params
	 */
    public static function whmcsapixmlparser($rawxml)
    {
        $xml_parser = xml_parser_create();
        xml_parse_into_struct($xml_parser, $rawxml, $vals, $index);
        xml_parser_free($xml_parser);
        $params = array();
        $level = array();
        $alreadyused = array();
        $x=0;
        foreach ($vals as $xml_elem) {
          if ($xml_elem['type'] == 'open') {
             if (in_array($xml_elem['tag'],$alreadyused)) {
                $x++;
                $xml_elem['tag'] = $xml_elem['tag'].$x;
             }
             $level[$xml_elem['level']] = $xml_elem['tag'];
             $alreadyused[] = $xml_elem['tag'];
          }
          if ($xml_elem['type'] == 'complete') {
           $start_level = 1;
           $php_stmt = '$params';
           while($start_level < $xml_elem['level']) {
             $php_stmt .= '[$level['.$start_level.']]';
             $start_level++;
           }
           $php_stmt .= '[$xml_elem[\'tag\']] = $xml_elem[\'value\'];';
           @eval($php_stmt);
          }
        }
        return($params);
    }
    
    /**
	 * Function getPDFContentReport report for given content
	 * @param  $ssContent content
	 * return  PDF report for given content
	 */
    public static function getPDFContentReport($ssContent)
    {
        // pdf object
        $oPDF = new sfTCPDF();       
        // set document information
        $oPDF->SetCreator(PDF_CREATOR);
        $oPDF->SetAuthor('Cemetery');
        $oPDF->SetTitle('Payment Details');
        $oPDF->SetSubject('Payment Details');
        $oPDF->SetKeywords('Grantee, Grave');
                    
        // set header and footer fonts
        $oPDF->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $oPDF->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
        
        // set default monospaced font
        $oPDF->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        
        //////////////////////////////////////////////////
        // 		REPLACE STATIC VARIABLES WITH VALUE		//
        //////////////////////////////////////////////////
        $oPDF->AddPage();
        $oPDF->writeHTML($ssContent);
        
        
        $ssFileName = 'paymentdetail.pdf';			
        // Close and output PDF document
        // This method has several options, check the source code documentation for more information.
        $oPDF->Output($ssFileName, 'I');			
        // Stop symfony process
        throw new sfStopException();
    }

    /**
	 * Function diff_between_time give difference b/w two time
	 * @param  $snFirstTime content
     * @param  $snSecondTime content
	 * return  $snTotalHrs time
	 */
    public static function diff_between_time($snFirstTime, $snSecondTime)
    {
        $snTime = strtotime($snFirstTime) - strtotime($snSecondTime);
        $snHours = floor($snTime/3600);
        $snMinutes= round($snTime/60);
        if($snHours != 0)
        {                
            if($snMinutes > 60)
            {
                $snTotalMin = ($snMinutes - ($snHours * 60));
                $snTotalHrs = ((strlen($snHours) == 1)?'0'.$snHours:$snHours).':'.((strlen($snTotalMin) == 1)?'0'.$snTotalMin:$snTotalMin).':00';
            }
            else
                $snTotalHrs = $snHours.':00:00';
        }
        else
            if(strlen($snMinutes) == 1)
                $snTotalHrs = '00:0'.round($snTime/60).':00';
            else
                $snTotalHrs = '00:'.round($snTime/60).':00';
                
        return $snTotalHrs;
    }
    
    /**
	 * Function sum_the_time give sum of two time
	 * @param  $time1 content
     * @param  $time2 content
	 * return  $snTotalHrs time
	 */
    public static function sum_the_time($time1, $time2) 
    {
        $times = array($time1, $time2);
        $seconds = 0;
        foreach ($times as $time)
        {
            list($hour,$minute,$second) = explode(':', $time);
            $seconds += $hour*3600;
            $seconds += $minute*60;
            $seconds += $second;
        }
        $hours = floor($seconds/3600);
        $seconds -= $hours*3600;
        $minutes  = floor($seconds/60);
        $seconds -= $minutes*60;
        // return "{$hours}:{$minutes}:{$seconds}";
        return sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds); // Thanks to Patrick
    }
    
    /**
	 * Function dateDifference give sum of two time
	 * @param  $startDate start date
     * @param  $endDate end date
	 * return  $Year difference between two date
	 */
    public static function dateDifference($startDate, $endDate)
    {
        $startDate = strtotime($startDate);
        $endDate = strtotime($endDate);
        if ($startDate === false || $startDate < 0 || $endDate === false || $endDate < 0 || $startDate > $endDate)
            return false;
           
        $years = date('Y', $endDate) - date('Y', $startDate);
       
        $endMonth = date('m', $endDate);
        $startMonth = date('m', $startDate);
       
        // Calculate months
        $months = $endMonth - $startMonth;
        if ($months <= 0)  {
            $months += 12;
            //$years--;
            
        }
        if ($years < 0)
            return false;
       
        // Calculate the days
        $offsets = array();
        if ($years > 0)
            $offsets[] = $years . (($years == 1) ? ' year' : ' years');
        /*if ($months > 0)
            $offsets[] = $months . (($months == 1) ? ' month' : ' months');*/
        $offsets = count($offsets) > 0 ? '+' . implode(' ', $offsets) : 'now';

        $days = $endDate - strtotime($offsets, $startDate);
        $days = date('z', $days);   
                   
        //return array($years, $months, $days);
        return array($years);        
    } 
}
?>