<?php

/**
 * ArGrave form.
 *
 * @package    cemetery
 * @subpackage form
 * @author     Prakash Panchal
 * @version    SVN: $Id: ImportGraveForm.class.php,v 1.1.1.1 2012/03/24 11:56:27 nitin Exp $
 */
sfProjectConfiguration::getActive()->loadHelpers(array('jQuery', 'Url'));
class ImportGraveForm extends BaseArGraveForm
{
	/**
     * Function for ovrwrite parent class method.
     *
     * This function is access by admin user.
     * 
     * @access  public
     */
    public function setup()
    {
    }
	/**
     * Function for ovrwrite parent class method.
     *
     * This function is access by admin user.
     * 
     * @access  public
     */
	public function configure()
	{
		unset($this['id']);
			
		$this->asCountryList = array();
		$omCriteria = Doctrine::getTable('Country')->getCountryList(array(),array());
		$amCountry = $omCriteria->orderBy('sf.name')->fetchArray();
		$this->snDefaultCountryId = 0;
		if(count($amCountry) > 0)
		{
			foreach($amCountry as $asDataSet)
			{
				$this->asCountryList[$asDataSet['id']] = $asDataSet['name'];
				if($asDataSet['name'] == sfConfig::get('app_default_country'))
					$this->snDefaultCountryId = $asDataSet['id'];
			}
		}
		
		$this->amPostData = sfContext::getInstance()->getRequest()->getParameter('grave');
		$this->ssInvalidRangeMessage = '';
	}
	/**
     * Function for set widgets for form elements.
     *
     * @access  public
     * @param   array   $asWidgets pass a widgets array.
     *
     */
    public function setWidgets(array $asWidgets)
    {	
        BaseArGraveForm::setWidgets(
            array(
                    'grave_number_start'	=> new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 7)),
                    'grave_number_end'		=> new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 8)),
					'ar_grave_status_id' => new sfWidgetFormDoctrineChoice(array('model' => 'ArGraveStatus', 'add_empty' => $asWidgets['ar_grave_status_id']),array('tabindex'=>9)),
					'grantee_unique_id'		=> new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 10)),
                    'length' 				=> new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 11)),
                    'width' 				=> new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 12)),
                    'height' 				=> new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 13)),
                    'unit_type_id' 			=> new sfWidgetFormDoctrineChoice(array('model' => 'UnitType', 'add_empty' => $asWidgets['unit_type_id']),array('tabindex'=>14)),
                    'details'    			=> new sfWidgetFormTextArea(array(), array('tabindex'=> 15)),
                    'is_enabled'         	=> new MyWidgetFormInputCheckbox(array(), array('tabindex' => 16, 'value' => 1)),
            	));

		if(sfContext::getInstance()->getUser()->isSuperAdmin())
		{
			$this->widgetSchema['country_id'] = new sfWidgetFormChoice(
													array('choices' => array('' => $asWidgets['country_id']) + $this->asCountryList),
													array('tabindex'=>1, 'onChange' => "callAjaxRequest(this.value,'".url_for('grave/getCementryListAsPerCountry')."','grave_cemetery_list');")
												);
			if($this->isNew())
				$this->setDefault('country_id', $this->snDefaultCountryId);
		}
		else
		{
			$snCemeteryId = sfContext::getInstance()->getUser()->getAttribute('cemeteryid');			
			$oCemetery = Doctrine::getTable('CemCemetery')->find($snCemeteryId);
			$this->widgetSchema['country_id'] = new sfWidgetFormInputHidden(array(), array('value' => $oCemetery->getCountryId(),'readonly' => 'true'));
			$this->widgetSchema['cem_cemetery_id'] = new sfWidgetFormInputHidden(array(), array('value' => $snCemeteryId,'readonly' => 'true'));			
			$this->setDefault('cem_cemetery_id',$snCemeteryId);
			
			$this->setDefault('country_id',$oCemetery->getCountryId());
		}

        $this->widgetSchema->setNameFormat('grave[%s]'); 
    }  
  
  
    /**
     * Function for set labels for form elements.
     *
     * @access  public
     * @param   array   $asLabels pass a labels array.
     *
     */
    public function setLabels($asLabels)
    {
        $this->widgetSchema->setLabels($asLabels);
    }
    /**
     * Function for set validators for form elements.
     *
     * @access  public
     * @param   array   $amValidators pass a validators array.
     *
     */
    public function setValidators(array $amValidators)
    {
		$this->ssInvalidRangeMessage = $amValidators['grave_number_end']['invalid'];
        BaseArGraveForm::setValidators(
	    	array(
				'grave_number_start'       	=> new sfValidatorString(
                                            		array('required' => true, 'trim' => true),
													array('required'=> $amValidators['grave_number_start']['required'])
                                        		),
				'ar_grave_status_id'	=> new sfValidatorString( 
                       								array('required' => true, 'trim' => true),
													array('required'=> $amValidators['ar_grave_status_id']['required'])
												),
				'grantee_unique_id'     => new sfValidatorString(
                                            		array('required' => false, 'trim' => true)
                                        		),
				'length'       			=> new sfValidatorString(
                                            		array('required' => false, 'trim' => true)
                                        		),
				'width'       			=> new sfValidatorString(
                                            		array('required' => false, 'trim' => true)
                                        		),
				'height'       			=> new sfValidatorString(
                                            		array('required' => false, 'trim' => true)
                                        		),
				'details'       		=> new sfValidatorString(
                                            		array('required' => false, 'trim' => true)
                                        		),
				'unit_type_id'       	=> new sfValidatorString(
                                            		array('required' => false, 'trim' => true)
                                        		),
				'is_enabled'       		=> new sfValidatorString(
                                            		array('required' => false, 'trim' => true)
                                        		)
			)
        );
		
		if(sfContext::getInstance()->getUser()->isSuperAdmin())
		{
			$this->validatorSchema['country_id'] = new sfValidatorChoice(
                                            		array('required' => true, 'choices' => array_keys($this->asCountryList)),
													array('required'=> $amValidators['country_id']['required'])
                                        			);
		}
		else
		{
			$this->validatorSchema['country_id']	= new sfValidatorDoctrineChoice(
														array('model'=>'Country','multiple'=>false,'required'=>false));

			$this->validatorSchema['cem_cemetery_id'] =	new sfValidatorString(
        		                                   		array('required' => false, 'trim' => true));
		}
		
		$this->validatorSchema['grave_number_end'] = new sfValidatorAnd(array(new sfValidatorCallback(
														array('callback'=> array($this,'checkValidRange'),
															  'arguments' => array('snStartingRage' => $this->amPostData['grave_number_start'])),
														array('invalid'=> $amValidators['grave_number_end']['invalid']))
														),															
														array('required' => true, 'trim' => true),
														array('required' => $amValidators['grave_number_end']['required'])
													);
    }
	/**
     * Fuction checkValidDate to check date is greater than or equal to current date
     * @param $validator 	= Call Validator
     * @param $snCurrentDate 	= date
	 
	 * return  $snCurrentDate valid date
     */
	public function checkValidRange($validator, $snEndingRange, $asArguments) 
	{
		if($snEndingRange <= $asArguments['snStartingRage'])
			throw new sfValidatorError($validator, $this->ssInvalidRangeMessage);
		else
			return $snEndingRange;
	}
}
