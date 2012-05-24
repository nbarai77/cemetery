<?php

/**
 * AwardPayRate form.
 *
 * @package    cemetery
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class AwardPayRateForm extends BaseAwardPayRateForm
{
    public function configure()
    {
        //$this->useFields(array('overtime_hrs'));
        unset($this['id_award']);
        $asAllOvertime = array();
        $asAllPayRate = array();
        for($snI = 1; $snI <= 24; $snI++)
        {
            $asAllOvertime[$snI] =  $snI;
        }
        for($snJ = 1; $snJ <= 100; $snJ++)
        {
            $asAllPayRate[$snJ] = $snJ;
        }
        
        $this->widgetSchema['overtime_hrs'] = new sfWidgetFormChoice(array('choices' => array(""=>__('Select Overtime Hrs.'))+$asAllOvertime),array('tabindex'=>1));
			
		/*$this->validatorSchema['overtime_hrs'] = new sfValidatorDoctrineChoice(
										array('model'=>'AwardPayRate','multiple'=>false,'required'=>false),
										array('required'=>__("Please select category name"),'invalid'=>__("Please select category name")));
          */                              
        /*$this->widgetSchema['overtime_pay_rate_one'] = new sfWidgetFormChoice(array('choices' => array(""=>__('Select Pay Rate'))+$asAllPayRate),array('tabindex'=>1));
			
		$this->validatorSchema['overtime_pay_rate_one'] = new sfValidatorDoctrineChoice(
										array('model'=>'AwardPayRate','multiple'=>false,'required'=>false),
										array('required'=>__("Please select category name"),'invalid'=>__("Please select category name")));
                                        
        $this->widgetSchema['overtime_hrs_two'] = new sfWidgetFormChoice(array('choices' => array(""=>__('Select Overtime Hrs.'))+$asAllOvertime),array('tabindex'=>1));
			
		$this->validatorSchema['overtime_hrs_two'] = new sfValidatorDoctrineChoice(
										array('model'=>'AwardPayRate','multiple'=>false,'required'=>false),
										array('required'=>__("Please select category name"),'invalid'=>__("Please select category name")));
                                        
        $this->widgetSchema['overtime_pay_rate_two'] = new sfWidgetFormChoice(array('choices' => array(""=>__('Select Pay Rate'))+$asAllPayRate),array('tabindex'=>1));
			
		$this->validatorSchema['overtime_pay_rate_two'] = new sfValidatorDoctrineChoice(
										array('model'=>'AwardPayRate','multiple'=>false,'required'=>false),
										array('required'=>__("Please select category name"),'invalid'=>__("Please select category name")));
     
        $this->widgetSchema['overtime_hrs_three'] = new sfWidgetFormChoice(array('choices' => array(""=>__('Select Overtime Hrs.'))+$asAllOvertime),array('tabindex'=>1));
			
		$this->validatorSchema['overtime_hrs_three'] = new sfValidatorDoctrineChoice(
										array('model'=>'AwardPayRate','multiple'=>false,'required'=>false),
										array('required'=>__("Please select category name"),'invalid'=>__("Please select category name")));*/
                                        
        $this->widgetSchema['overtime_pay_rate'] = new sfWidgetFormChoice(array('choices' => array(""=>__('Select Pay Rate'))+$asAllPayRate),array('tabindex'=>1));
			
		/*$this->validatorSchema['overtime_pay_rate'] = new sfValidatorDoctrineChoice(
										array('model'=>'AwardPayRate','multiple'=>false,'required'=>false),
										array('required'=>__("Please select category name"),'invalid'=>__("Please select category name")));
      */
      $this->widgetSchema->setNameFormat('awardpayrate[%s]');
      $this->validatorSchema->setOption('allow_extra_fields', true);
      $this->validatorSchema->setOption('filter_extra_fields', false);
    }
}