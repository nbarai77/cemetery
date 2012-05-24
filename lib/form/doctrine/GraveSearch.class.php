<?php

/**
 * ArGrave form.
 *
 * @package    cemetery
 * @subpackage form
 * @author     nitin barai
 * @version    SVN: $Id: GraveSearch.class.php,v 1.1.1.1 2012/03/24 11:56:36 nitin Exp $
 */
sfProjectConfiguration::getActive()->loadHelpers(array('jQuery', 'Url'));
class GraveSearchForm extends BaseArGraveForm
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
		if(!sfContext::getInstance()->getUser()->isSuperAdmin())
			$this->amCementeryList = Doctrine::getTable('CemCemetery')->getAllCemeteriesByUserRole();

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
        BaseArGraveForm::setWidgets(
            array(
                    'cem_stonemason_id' => new sfWidgetFormDoctrineChoice(array('model' => 'CemStonemason', 'add_empty' => $asWidgets['cem_stonemason_id']),array('tabindex'=>2)),
                    'grave_number' 		=> new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 7)),
                    'ar_grave_status_id' => new sfWidgetFormDoctrineChoice(array('model' => 'ArGraveStatus', 'add_empty' => $asWidgets['ar_grave_status_id']),array('tabindex'=>8))
            	));



		if(sfContext::getInstance()->getUser()->isSuperAdmin())
		{
			$this->widgetSchema['country_id'] =  new sfWidgetFormChoice(
													array('choices' => array('' => $asWidgets['country_id']) + $this->asCountryList),
													array('tabindex'=>1, 'onChange' => "callAjaxRequest(this.value,'".url_for('gravesearch/getCementryListAsPerCountry')."','grave_cemetery_list');")
												);
			$this->setDefault('country_id',$this->snDefaultCountryId);
		}
		else{
			$snCemeteryId = sfContext::getInstance()->getUser()->getAttribute('cemeteryid');
			$oCemetery = Doctrine::getTable('CemCemetery')->find($snCemeteryId);
			$this->widgetSchema['country_id'] = new sfWidgetFormInputHidden(array(), array('value' => $oCemetery->getCountryId(),'readonly' => 'true'));
			$this->setDefault('country_id',$oCemetery->getCountryId());
			
			$this->widgetSchema['cem_cemetery_id'] = new sfWidgetFormInputHidden(array(), array('value' => $snCemeteryId,'readonly' => 'true'));
			
			if(sfContext::getInstance()->getUser()->getAttribute('cm') != '') {
				$this->setDefault('cem_cemetery_id',$snCemeteryId);	
			}
			
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
        BaseArGraveForm::setValidators(
	    	array(
                'cem_stonemason_id'		=> new sfValidatorString( 
                       								array('required' => true, 'trim' => true),
                       								array('required' => $amValidators['cem_stonemason_id']['required'])
												),
				'grave_number'       	=> new sfValidatorString(
                                            		array('required' => true, 'trim' => true),
													array('required'=> $amValidators['grave_number']['required'])
                                        		),
				'length'       			=> new sfValidatorString(
                                            		array('required' => false, 'trim' => true)
                                        		),
				'ar_grave_status_id'    => new sfValidatorString(
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
                                            		array('required' => true, 'trim' => true),
													array('required'=> $amValidators['unit_type_id']['required'])
                                        		),
				'is_enabled'       		=> new sfValidatorString(
                                            		array('required' => false, 'trim' => true)
                                        		)
			)
        );
		
		$this->validatorSchema['country_id'] = new sfValidatorChoice(
												array('required' => false, 'choices' => array_keys($this->asCountryList))
												);		
		
    }
	// over ride parent object named updateObject for set manual values 
	public function updateObject($values = null)
	{
		if(sfContext::getInstance()->getUser()->isSuperAdmin())
			$this->values['cem_cemetery_id'] = sfContext::getInstance()->getRequest()->getParameter('grave_cem_cemetery_id');

		$this->values['ar_area_id']  		= sfContext::getInstance()->getRequest()->getParameter('grave_ar_area_id');
		$this->values['ar_section_id']  	= sfContext::getInstance()->getRequest()->getParameter('grave_ar_section_id');
		$this->values['ar_row_id']  		= sfContext::getInstance()->getRequest()->getParameter('grave_ar_row_id');
		$this->values['ar_plot_id']  		= sfContext::getInstance()->getRequest()->getParameter('grave_ar_plot_id');
		
		parent::updateObject($this->values);
	}
}
