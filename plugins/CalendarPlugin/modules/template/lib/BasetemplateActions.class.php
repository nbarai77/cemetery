<?php

/**
 * Base actions for the CalendarPlugin template module.
 * 
 * @package     CalendarPlugin
 * @subpackage  template
 * @author      Jaimin Shelat
 */

sfProjectConfiguration::getActive()->loadHelpers(array('I18N'));
abstract class BasetemplateActions extends sfActions
{
    public function executeIndex()
    {        
        $this->ssMonthWeek = date('Y-m-d');

    }


   /**
    * newTemplate action
    *
    * Update newTemplate use
    * @access public
    * @param  object $oRequest A request object
    *     
    */
    public function executeNewTemplate(sfWebRequest $oRequest)
    {
  
/*
        $ssSuccessKey = 4; // Success message key for add
        if($snIdEquMedia)
        {
            //$this->forward404Unless($oEquMedia = Doctrine::getTable('equMedia')->find($snIdEquMedia));
            $this->oCalTemplateForm = new calTemplateForm($oEquMedia);
            $ssSuccessKey = 2; // Success message key for add
        }
        else*/

        // Set Default value
        $snEquipmentId = $oRequest->getParameter('equ_equipment_id', '');        
        $this->oCalTemplateForm = new calTemplateForm();
      
        $this->getConfigurationFields($this->oCalTemplateForm,$snEquipmentId);
          
        if($oRequest->isMethod('post'))
        {
            $this->oCalTemplateForm->bind($oRequest->getParameter($this->oCalTemplateForm->getName()));            
            if($this->oCalTemplateForm->isValid())
            {
                $asFormParam = $oRequest->getParameter($this->oCalTemplateForm->getName());
                $ssCreateParam = $this->prepareJsonData($asFormParam);    
                $this->oCalTemplateForm->getObject()->setParamSet($ssCreateParam);
                
                $this->oCalTemplateForm->save();

                $this->getUser()->setFlash('ssSuccessMsgKey', __('Insert new template successfully'));   
                //unset($this->oCalTemplateForm, $oRequest);             
                
            }
            
        }        
    }

    /**
     *  prepareJsonData
     *
     * Function for prepare jeson data for new widget
     * @access private
     * @param  array $asFormData request parameter
     *     
     */
    private function  prepareJsonData($asFormData)
    {   
        if(is_array($asFormData))
        {
            $asNewTemplateData = array();
            
            $ssNightJob = (isset($asFormData['night_job']) ? __('yes') : __('no'));
            $ssWeekEnd = (isset($asFormData['week_end']) ? __('yes') : __('no'));

            $asNewTemplateData = array('start_time'=> $asFormData['start_time'], 'end_time'=>$asFormData['end_time'], 'duration'=>$asFormData['duration'],'night_job'=>$ssNightJob,'weekend'=>$ssWeekEnd);
            return json_encode($asNewTemplateData);
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
    private function getConfigurationFields($oForm,$snEquipmentId)
    {
        $oForm->setWidgets(array());

        $oForm->setDefaults(array('equ_equipment_id' => $snEquipmentId,
                                  'start_time' => '00:00',
                                  'end_time' => '00:00',
                                  'duration' => '00:30',
                                )
                            );

        $oForm->setLabels(array(
                                'name'          => __('Name'),
                                'description'   => __('Description'),
                                'start_time'    => __('Start Time') ,
                                'end_time'    => __('End Time') ,
                                'duration'    => __('Duration') ,
                                'night_job'    => __('Night Job') ,
                                'week_end'    => __('Weekend') ,
                                ));

        $oForm->setValidators(array(
                                    'name'         => array(
                                                            'required'        => __('Name required'),
                                                            'invalid_unique'  => __('Name already exists'),
                                                    ),
                                    'description'  => array(
                                                            'required'        => __('Description required'),
                                                    ),                                    
                                ));
    }


}
