<?php

/**
 * timeinout actions.
 *
 * @package    cemetery
 * @subpackage timeinout
 * @author     Arpita Rana
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
sfProjectConfiguration::getActive()->loadHelpers(array('I18N'));
class timeinoutActions extends sfActions
{
    /**
     * preExecutes  action
     *
     * @access public
     * @param sfRequest $request A request object
     */
    public function preExecute()
    {
        sfContext::getInstance()->getResponse()->addCacheControlHttpHeader('no-store, no-cache, must-revalidate, post-check=0, pre-check=0');

        // Declaration of messages.
        $this->amSuccessMsg = array(
                                    1 => __('Status changes successfully'),
                                    2 => __('Record has been updated successfully'),
                                    3 => __('Record has been deleted successfully'),
                                    4 => __('Record has been inserted successfully'),
                                );

        $this->amErrorMsg = array(1 => __('Please select at least one'),);
        $this->ssFormName = 'frm_list_award';
        $omRequest        = sfContext::getInstance()->getRequest();

        // Set default values
        $this->amExtraParameters = array();
        $this->amExtraParameters['snPaging']        = $this->snPaging       = $omRequest->getParameter('paging',sfConfig::get('app_default_paging_records'));
        $this->amExtraParameters['snPage']          = $this->snPage         = $omRequest->getParameter('page', sfConfig::get('app_default_page', 1));
        $this->amExtraParameters['ssSearchName']   	= $this->ssSearchName  	= trim($omRequest->getParameter('searchName',''));
        $this->amExtraParameters['ssSortBy']        = $this->ssSortBy       = $omRequest->getParameter('sortby','id');
        $this->amExtraParameters['ssSortMode']      = $this->ssSortMode     = $omRequest->getParameter('sortmode','desc');

        $this->ssSortQuerystr = $this->ssQuerystr = 'page='.$this->snPage.'&paging='.$this->snPaging;

        if($this->getRequestParameter('searchName') != '' )        // Search parameters
        {
            $this->ssQuerystr    .= '&searchName='.$omRequest->getParameter('searchName');
            $this->ssSortQuerystr.= '&searchName='.$omRequest->getParameter('searchName');
        }

        if($this->getRequestParameter('sortby') != '' )        // Sorting parameters
            $this->ssQuerystr .= '&sortby='.$this->getRequestParameter('sortby').'&sortmode='.$this->getRequestParameter('sortmode');

        $this->amExtraParameters['ssQuerystr']     = $this->ssQuerystr;
        $this->amExtraParameters['ssSortQuerystr'] = $this->ssSortQuerystr;
    }

   /**
    * Executes index action
    *
    * @access public
    * @param sfRequest $request A request object
    */
    public function executeIndex(sfWebRequest $request)
    {
        //set search combobox field
        $this->amSearch = array(
								'name' => array(
												'caption'	=> __('Name'),
												'id'		=> 'Name',
												'type'		=> 'text',																								
											)
							);

        $omCommon = new common();

        if($request->getParameter('admin_act') == "delete" && $request->getParameter('id'))            
        {
            $omCommon->DeleteRecordsComposite('Award', $request->getParameter('id'),'id');
            $this->getUser()->setFlash('snSuccessMsgKey', 3);      
        }

        // Get cms page list for listing.
        $oAwardPageListQuery = Doctrine::getTable('Award')->getAwardsList($this->amExtraParameters, $this->amSearch);

        // Set pager and get results
        $oPager               = new sfMyPager();
        $this->oAwardList  = $oPager->getResults('Award', $this->snPaging,$oAwardPageListQuery,$this->snPage);
        $this->amAwardList = $this->oAwardList->getResults(Doctrine::HYDRATE_ARRAY);

        unset($oPager);

        // Total number of records
        $this->snPageTotaloAwardPages = $this->oAwardList->getNbResults();

        if($request->getParameter('request_type') == 'ajax_request')
            $this->setTemplate('listAwardUpdate');
    }
    
   /**
    * update action
    *
    * Update cms pages   
    * @access public
    * @param  object $oRequest A request object
    *     
    */
    public function executeAddedit(sfWebRequest $oRequest)
    {
		$snIdAward = $oRequest->getParameter('id', '');
        $ssSuccessKey   = 4; // Success message key for add        
		
		$this->asCementery = array();
        if($snIdAward)
        {
            $this->forward404Unless($oAward = Doctrine::getTable('Award')->find($snIdAward));            
            $this->oAwardForm = new AwardForm($oAward);			
            $ssSuccessKey = 2; // Success message key for edit			
			// For get Award Pay List
			$this->asAwardPayList = Doctrine::getTable('AwardPayRate')->getAllAwardPayList($snIdAward);
        }
        else
            $this->oAwardForm = new AwardForm();                     
        
        $amAwardHrsRequestParameter = $oRequest->getParameter('award_overtime_hrs');
        $amAwardPayRateRequestParameter = $oRequest->getParameter('award_overtime_rate');
        $this->getConfigurationFields($this->oAwardForm);
        
		$amAwardRequestParameter = $oRequest->getParameter($this->oAwardForm->getName());
        
        if($oRequest->isMethod('post'))
        {   
            /*foreach($amAwardRequestParameter['awardpayrate'] as $snKey=>$asValue)
                $amAwardRequestParameter['awardpayrate'][$snKey]['overtime_hrs'] = $asValue['overtime_hrs'].':00:00';*/
            
            $this->oAwardForm->bind($amAwardRequestParameter);           
            if($this->oAwardForm->isValid())
            {
				// Save Records                
				$snIdAward = $this->oAwardForm->save();
                if(count($amAwardPayRateRequestParameter) > 0)
                {   
                    if(isset($this->asAwardPayList) && count($this->asAwardPayList) > 0)
                    {
                        
                        foreach($this->asAwardPayList as $snKey=>$asValue)
                        {
                            if($amAwardPayRateRequestParameter[$snKey] != '' && $amAwardHrsRequestParameter[$snKey] != '')
                            {
                                $oAwardPayRate = new AwardPayRate();
                                $oAwardPayRate->updateAwardPayDetail($asValue['id'],$amAwardHrsRequestParameter[$snKey],$amAwardPayRateRequestParameter[$snKey]);
                            }
                        }                        
                    }
                    else
                    {
                        foreach($amAwardPayRateRequestParameter as $snKey=>$ssVal)
                        {
                            if($amAwardPayRateRequestParameter[$snKey] != '' && $amAwardHrsRequestParameter[$snKey] != '')
                            {
                                $oAwardPayRate = new AwardPayRate();
                                $oAwardPayRate->saveAwardPayDetail($snIdAward,$amAwardHrsRequestParameter[$snKey],$amAwardPayRateRequestParameter[$snKey]);
                            }
                        }
                    }
                }                
				$this->getUser()->setFlash('snSuccessMsgKey', $ssSuccessKey);   //Set messages for add and update records
				$this->redirect('timeinout/index?'.$this->amExtraParameters['ssQuerystr']);
            }
			else
			{
				if(!$bSelectCemetery)
					$this->getUser()->setFlash('ssErrorCemeter',__('Please select cemetery'));
			}
        }
    }
    
    /**
     * Clockinout action
     *
     * User ClockIn ClockOUt time inserted.  
     * @access public
     * @param  object $oRequest A request object
     *     
     */
    public function executeClockinout(sfWebRequest $oRequest)
    {	
		$snIdUser = (($oRequest->getParameter('staff_id') != '') ? $oRequest->getParameter('staff_id') : $this->getUser()->getAttribute('userid'));
        
        $this->asStaffUser = Doctrine::getTable('sfGuardUser')->getCemeteryStaffList($this->getUser()->getAttribute('cemeteryid'),'',true);
       
        if($oRequest->isMethod('post'))
        {
            // Function getAllDetail() is checked User's today's entry if today's entry update record else entry 
            $asTimeInOutDetail = Doctrine::getTable('TimeInOut')->getAllDetail($snIdUser);
            
            if($this->getUser()->getAttribute('groupid') != sfConfig::get('app_cemrole_manager'))
            {
                $snTotalHrs = '';
                $snCurrentTime = date('H:i:s');
                $snCurrentDate = date('Y-m-d');
                $oTimeInOut = new TimeInOut();
                $ssStatus = (($oRequest->getParameter('timein') == 'Clock In')?'IN':'OUT');
              
                if(count($asTimeInOutDetail) > 0)
                {
                    if($ssStatus == 'OUT')
                    {
                        $snTotalHrs = sfGeneral::diff_between_time($snCurrentTime,$asTimeInOutDetail[0]['time_in']);
                                
                        if($asTimeInOutDetail[0]['total_hrs'] != '')
                            $snTotalHrs = sfGeneral::sum_the_time($snTotalHrs,$asTimeInOutDetail[0]['total_hrs']);
                        
                        $oTimeInOut->updateTimeInOutDetail($snCurrentTime,$snTotalHrs,$ssStatus,$snIdUser);
                    }                
                    else
                        $oTimeInOut->updateTimeInOutDetail($snCurrentTime,'',$ssStatus,$snIdUser);
                }
                else
                {               
                    $oTimeInOut->saveTimeInOutDetail($this->getUser()->getAttribute('userid'),$snCurrentDate,$snCurrentTime,$ssStatus);                   
                }
                $this->redirect('timeinout/clockinout');
            }            
        }
        $this->asUserWeeklyDetail = Doctrine::getTable('TimeInOut')->getUserWeeklyAllDetail($snIdUser);
        $this->asUserWeeklyDetails = $this->getUserWeeklyDetail($snIdUser);
        
        $this->asTimeInOutDetail = Doctrine::getTable('TimeInOut')->getAllDetail($snIdUser);        
        $this->snStaffId = $oRequest->getParameter('staff_id','');        
	}
    
    /**
     * ChangeTimeOut action
     *
     * Manager is changed TOTAL time from listing.  
     * @access public
     * @param  object $oRequest A request object
     *     
     */
    public function executeChangeTimeOut(sfWebRequest $oRequest)
    {	
		$snTimeOutId = $oRequest->getParameter('id_time_out');

		$snTimeOut = trim($oRequest->getParameter('out_time',''));		
		// UPDATE OUT TIME INTO TIME_IN_OUT TABLE.        
        common::UpdateCompositeField('TimeInOut', 'total_hrs', $snTimeOut, 'id', $snTimeOutId);		
					
		$oResultTimeInOut = Doctrine::getTable('TimeInOut')->find($snTimeOutId);
        
        // Query for update total of total hrs.
        $this->asUserWeeklyDetail = Doctrine::getTable('TimeInOut')->getUserWeeklyAllDetail($oRequest->getParameter('id_user'));
        $snOverTime = sfConfig::get('app_default_time');
        $snSumOverTime = sfConfig::get('app_default_time');
        $snRegularTime = sfConfig::get('app_regular_time');
        
        $snTotalTime = sfConfig::get('app_default_time');   
        foreach($this->asUserWeeklyDetail as $snKey=>$asValue)
        {            
            $snTotalTime = sfGeneral::sum_the_time($snTotalTime,$asValue['total_hrs']);
            
            if(strtotime($asValue['total_hrs']) > strtotime($snRegularTime))
            { 
                $snOverTimes = sfGeneral::diff_between_time($asValue['total_hrs'],$snRegularTime);                                
                $snSumOverTime = sfGeneral::sum_the_time($snSumOverTime,$snOverTimes);                                
            }            
        }
        
        if(strtotime($oResultTimeInOut->getTotalHrs()) > strtotime($snRegularTime))
            $snOverTime = sfGeneral::diff_between_time($oResultTimeInOut->getTotalHrs(),$snRegularTime); 
            
        echo '<script type="text/javascript">
        document.getElementById("totalHrs").innerHTML = "'.date('H:i',strtotime($snTotalTime)).'";
        document.getElementById("overTime_'.$snTimeOutId.'").innerHTML = "'.date('H:i',strtotime($snOverTime)).'";
        document.getElementById("totalOvertimeHrs").innerHTML = "'.date('H:i',strtotime($snSumOverTime)).'";
        </script>';
        
		return $this->renderPartial('change_out_time', array( 'snTime' => date('H:i',strtotime($oResultTimeInOut->getTotalHrs())),
                                                              'snTimeInOutId' => $oResultTimeInOut->getId(),
                                                              'snUserId' => $oRequest->getParameter('id_user')) 
                                                            );                                    
	}
	
    /**
     * ExportTimeSheet action
     *
     * Here export Time sheet with Payment Detail.  
     * @access public
     * @param  object $oRequest A request object
     *     
     */
    public function executeExportTimeSheet(sfWebRequest $oRequest)
    {
        $ssFilename = "export.csv"; 
        $this->getResponse()->setHttpHeader('Content-Disposition', 'attachment; filename=' . basename($ssFilename));
		$this->getResponse()->setContentType('text/csv;charset=ISO-8859-2');
        
        $ssContents="";
        $asUserWeekDetail = $this->getUserWeeklyDetail($oRequest->getParameter('id_user'),$ssFlag = true);
        
        if(count($asUserWeekDetail) > 0)
        {
            foreach($asUserWeekDetail as $snKey=>$asValue)
            {                
                if($snKey == 4)
                {
                    foreach($asValue as $snKeys=>$ssVal)
                    {
                        if($snKeys == 0 || $snKeys == count($asValue) - 1)
                            $ssContents .= $ssVal.",";
                        else                        
                            $ssContents .= $ssVal['total_hrs'].",";                        
                    }
                }
                elseif($snKey == 5)
                {
                    foreach($asValue as $snKeys=>$ssVal)
                    {
                        if($snKeys == 0 || $snKeys == count($asValue) - 1)
                            $ssContents .= $ssVal.",";
                        else                        
                            $ssContents .= $ssVal['overtime'].",";                        
                    }
                }
                else
                {
                    foreach($asValue as $snKeys=>$ssVal)
                    {
                        $ssContents .= $ssVal.",";
                    }
                }
                $ssContents .= "\n";                              
            }
        }        
        $this->getResponse()->setContent($ssContents);        
	 	$this->getResponse()->sendHttpHeaders();
        
		return sfView::NONE;
    }
    
    /**
     * getUserWeeklyDetail
     *
     * Function for getting user's weekly detail.
     * @access private
     * @param  int     $snIdUser userid
     * @param  boolean $ssFlag   flag 
     *  
     * @return array $asUserWeekDetail
     */
    private function getUserWeeklyDetail($snIdUser,$ssFlag ='')
    {
        $this->asUserWeeklyDetail = Doctrine::getTable('TimeInOut')->getUserWeeklyAllDetail($snIdUser);
        $asUserWeekDetail = array();
        if(count($this->asUserWeeklyDetail) > 0)
        {
            $snTotalTime = sfConfig::get('app_default_time');
            $snSumOverTime = sfConfig::get('app_default_time');
            $snRegularTime = sfConfig::get('app_regular_time');
            
            $asUserWeekDetail[0][0] = '';
            $asUserWeekDetail[1][0] = __('Activity');
            $asUserWeekDetail[2][0] = __('IN');
            $asUserWeekDetail[3][0] = __('OUT');
            $asUserWeekDetail[4][0] = __('TOTAL');
            $asUserWeekDetail[5][0] = __('OVERTIME');
            
            $snTotalWeekPayment = 0;
            $snTotalPayment = 0;
            if($ssFlag)
                $asUserWeekDetail[6][0] = __('Payment');
            
            
            foreach($this->asUserWeeklyDetail as $snKey=>$asValue)
            {            
                $snOverTimeProduct = 0;
                
                $asUserWeekDetail[0][$snKey + 1] = date("D", strtotime($asValue['task_date'])); 
                
                $asUserWeekDetail[1][$snKey + 1] = $asValue['DayType']['name']; 
                $asTime = explode(' ',$asValue['created_at']);
                $snTimeIn = ((sfContext::getInstance()->getUser()->getAttribute('groupid') != sfConfig::get('app_cemrole_manager'))?date('H:i',strtotime($asValue['time_in'])):date('H:i',strtotime($asTime[1])));
                $asUserWeekDetail[2][$snKey + 1] = $snTimeIn;
                $asUserWeekDetail[3][$snKey + 1] = date('H:i',strtotime($asValue['time_out']));
                $asUserWeekDetail[4][$snKey + 1] = array('total_hrs'=>date('H:i',strtotime($asValue['total_hrs'])),'id'=>$asValue['id']);
                                
                $snTotalTime = sfGeneral::sum_the_time($snTotalTime,$asValue['total_hrs']);
                if(strtotime($asValue['total_hrs']) > strtotime($snRegularTime))
                {
                    $snOverTime = sfGeneral::diff_between_time($asValue['total_hrs'],$snRegularTime);
                    $snSumOverTime = sfGeneral::sum_the_time($snSumOverTime,$snOverTime);
                    if($ssFlag)
                    {   
                        // $snUserTotalTimeMinutes get minutes of a given time $snRegularTime.
                        $snUserTotalTimeMinutes = $this->getTimeMinutes($snRegularTime);
                        // $snRegularRateOfOneMinute get pay rate of one minute.
                        $snRegularRateOfOneMinute =  (sfConfig::get('app_regular_pay_rate') / 60);
                        $snRegularTimeProduct = ($snUserTotalTimeMinutes * $snRegularRateOfOneMinute);                        
                    }
                }
                else
                {
                    $snOverTime = sfConfig::get('app_default_time');
                    if($ssFlag)
                    {   
                        $snUserTotalTimeMinutes = $this->getTimeMinutes($asValue['total_hrs']);
                        $snRegularRateOfOneMinute =  (sfConfig::get('app_regular_pay_rate') / 60);
                        $snRegularTimeProduct = ($snUserTotalTimeMinutes * $snRegularRateOfOneMinute);
                        $snTotalPayment = number_format($snRegularTimeProduct,2);                        
                    }
                }
            
                if($ssFlag && strtotime($asValue['total_hrs']) > strtotime($snRegularTime))
                {
                    $oUserDetail = Doctrine::getTable('UserCemetery')->findOneByUserId($snIdUser);
                    
                    // For get Award Pay List
                    $this->asAwardPayList = Doctrine::getTable('AwardPayRate')->getAllAwardPayList($oUserDetail->getAwardId());
                    
                    $ssCheckOverTimeFlag = true;
                    // foreach for compare overtime 
                    foreach($this->asAwardPayList as $snKey=>$asAwardPay)
                    {                        
                        // Here calculate over time payment as user assign from $this->asAwardPayList
                        if(strtotime($snOverTime) >= strtotime($asAwardPay['overtime_hrs']))
                        {  
                            $snUserTotalOverTimeMinutes = $this->getTimeMinutes($snOverTime);                            
                            // Database's Overtime  as template wise enter
                            $asAwardOverTime = explode(':',$asAwardPay['overtime_hrs']);
                            $snAwardHrs = (($asAwardOverTime[0] != '00')?((substr($asAwardOverTime[0],0,1) == 0)?substr($asAwardOverTime[0],1):$asAwardOverTime[0]):'');
                            $snOverTimeTotalMinutes = ($snAwardHrs * 60);
                            
                            $snOverTimeRateOfOneMinute =  ($asAwardPay['overtime_pay_rate'] / $snOverTimeTotalMinutes);
                            $snOverTimeProduct = ($snUserTotalOverTimeMinutes * $snOverTimeRateOfOneMinute);
                            $ssCheckOverTimeFlag = false;                         
                        }
                    }
                    // This is the case when overtime is not included in one of the case of overtime Hrs. that time first less overtime's rate is assigned.
                    if($ssCheckOverTimeFlag == true && (strtotime($snOverTime) < strtotime($this->asAwardPayList[0]['overtime_hrs'])))
                    {
                        $snUserTotalOverTimeMinutes = $this->getTimeMinutes($snOverTime);                            
                        // Database's Overtime  as template wise enter
                        $asAwardOverTime = explode(':',$this->asAwardPayList[0]['overtime_hrs']);
                        $snAwardHrs = (($asAwardOverTime[0] != '00')?((substr($asAwardOverTime[0],0,1) == 0)?substr($asAwardOverTime[0],1):$asAwardOverTime[0]):'');
                        $snOverTimeTotalMinutes = ($snAwardHrs * 60);
                            
                        $snOverTimeRateOfOneMinute =  ($this->asAwardPayList[0]['overtime_pay_rate'] / $snOverTimeTotalMinutes);
                        $snOverTimeProduct = ($snUserTotalOverTimeMinutes * $snOverTimeRateOfOneMinute);
                    }
                    $snTotalPayment = (number_format($snRegularTimeProduct,2) + number_format($snOverTimeProduct,2));                    
                }
                
                $asUserWeekDetail[5][] = array('overtime'=>((isset($snOverTime))?date('H:i',strtotime($snOverTime)):date('H:i',strtotime(sfConfig::get('app_default_time')))),'id'=>$asValue['id']);
                if($ssFlag)
                {
                    $asUserWeekDetail[6][] = $snTotalPayment;
                    $snTotalWeekPayment += $snTotalPayment;
                }
            }
            $anTotalTime = explode(':',$snTotalTime);
            $anSumOverTime = explode(':',$snSumOverTime);
            $asUserWeekDetail[0]['total'] = __('Total');
            $asUserWeekDetail[4][count($asUserWeekDetail[4])] = $anTotalTime[0].':'.$anTotalTime[1];
            $asUserWeekDetail[5][count($asUserWeekDetail[5])] = $anSumOverTime[0].':'.$anSumOverTime[1];
            $asUserWeekDetail[3][count($asUserWeekDetail[5])] = '';
            $asUserWeekDetail[2][count($asUserWeekDetail[5])] = '';
            $asUserWeekDetail[1][count($asUserWeekDetail[5])] = '';
            if($ssFlag)
                $asUserWeekDetail[6][count($asUserWeekDetail[5])] = $snTotalWeekPayment;
        }
        return $asUserWeekDetail;
    }
    
    
    /**
     * getTimeMinutes
     *
     * Function for getting total minutes of given time
     * @access private
     * @param  time $snTime Time
     *  
     * @return $snUserTimeMinutes
     */
    private function getTimeMinutes($snTime)
    {
        $anTotalHrs = explode(':',$snTime);
        $snMinuteTime = 00;
        
        if($anTotalHrs[1] > 1 && $anTotalHrs[1] <=15)
            $snMinuteTime = (($anTotalHrs[1] <= 8)?'01':15);                        
        elseif($anTotalHrs[1] > 15 && $anTotalHrs[1] <=30)
            $snMinuteTime = (($anTotalHrs[1] <= 22)?15:30);
        elseif($anTotalHrs[1] > 30 && $anTotalHrs[1] <=45)
            $snMinuteTime = (($anTotalHrs[1] <= 37)?30:45);
        elseif($anTotalHrs[1] > 45 && $anTotalHrs[1] <=60)
            $snMinuteTime = (($anTotalHrs[1] <= 52)?45:60);
        
        $snTime = substr_replace($snTime,$snMinuteTime,3,-3);
        
        $asOverTime = explode(':',$snTime);
        $snHrs = (($asOverTime[0] != '00')?((substr($asOverTime[0],0,1) == 0)?substr($asOverTime[0],1):$asOverTime[0]):'');
        $snMinutes = (($asOverTime[1] != '00')?((substr($asOverTime[1],0,1) == 0)?substr($asOverTime[1],1):$asOverTime[1]):'');
        
        $snUserTimeMinutes = 0;
        if($snHrs != '')
            $snUserTimeMinutes = ($snHrs * 60);            
        if($snMinutes != '')
            $snUserTimeMinutes = $snUserTimeMinutes + $snMinutes;
                    
        return $snUserTimeMinutes;
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
        $oForm->setWidgets(
			array(					
				 )
		);

        $oForm->setLabels(
            array(				
                'name'             => __('Name'),
                'description'      => __('Description'),
            )
        );

        $oForm->setValidators(
            array(
	                'name'              => array(
														'required'  => __('Please enter name')
													),
				)
        );
    }
}