<?php

/**
 * ArArea form.
 *
 * @package    cemetery
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: ArAreaForm.class.php,v 1.1.1.1 2012/03/24 11:56:39 nitin Exp $
 */
sfProjectConfiguration::getActive()->loadHelpers(array('jQuery', 'Url'));
class ArAreaForm extends BaseArAreaForm
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
        BaseArAreaForm::setWidgets(
            array(
                    'area_name' 			=> new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 3)),
                    'area_code' 			=> new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 4)),
                    'area_description' 		=> new sfWidgetFormTextArea(array(), array('tabindex'=> 5)),
                    'area_control_numberr' 	=> new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 6)),
                    'area_user' 			=> new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 7)),
					'area_map_path' 		=> new sfWidgetFormInputFile(array(),array('tabindex'=> 8)),
                    'is_enabled'         	=> new MyWidgetFormInputCheckbox(array(), array('tabindex' => 9, 'value' => 1)),
            	));

		if(sfContext::getInstance()->getUser()->isSuperAdmin())
		{
			$this->widgetSchema['country_id'] = new sfWidgetFormChoice(
													array('choices' => array('' => $asWidgets['country_id']) + $this->asCountryList),
													array('tabindex'=> 1, 'onChange' => "callAjaxRequest(this.value,'".url_for('area/getCementryListAsPerCountry')."','cementery_list');")
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
        $this->widgetSchema->setNameFormat('area[%s]'); 
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
        BaseArAreaForm::setValidators(
	    	array(
                'area_name'				=> new sfValidatorString( 
                       								array('required' => true, 'trim' => true),
                       								array('required' => $amValidators['area_name']['required'])
												),
				'area_code'       		=> new sfValidatorString(
                                            		array('required' => true, 'trim' => true),
													array('required' => $amValidators['area_code']['required'])
                                        		),
				'area_description'       		=> new sfValidatorString(
                                            		array('required' => false, 'trim' => true)
                                        		),
				'area_control_numberr'   => new sfValidatorString(
                                            		array('required' => false, 'trim' => true)
                                        		),
				'area_user'       		=> new sfValidatorString(
                                            		array('required' => false, 'trim' => true)
                                        		),
				'area_map_path'    => new sfValidatorFile(
											array('required'=> false,'trim' => true)
											),
				'is_enabled'       		=> new sfValidatorString(
                                            		array('required' => false, 'trim' => true)
                                        		)
			)
        );
		
		if(sfContext::getInstance()->getUser()->isSuperAdmin())
		{
			$this->validatorSchema['country_id'] =  new sfValidatorChoice(
                                            		array('required' => true, 'choices' => array_keys($this->asCountryList)),
													array('required'=> $amValidators['country_id']['required'])
                                        			);
		}
		else
		{
			$this->validatorSchema['country_id']	= new sfValidatorDoctrineChoice(
														array('model'=>'Country','multiple'=>false,'required'=>false));

			$this->validatorSchema['cem_cemetery_id'] = new sfValidatorString(
        		                                   		array('required' => false, 'trim' => true));
		}
    }
	// over ride parent object named updateObject for set manual values 
	public function updateObject($values = null)
	{
		if(sfContext::getInstance()->getUser()->isSuperAdmin())
		{
			$snCemeteryId = sfContext::getInstance()->getRequest()->getParameter('area_cem_cemetery_id');
			$this->values['cem_cemetery_id'] = $snCemeteryId;
		}
		parent::updateObject($this->values);
	}
}
