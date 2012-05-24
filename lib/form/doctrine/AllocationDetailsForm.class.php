<?php

/**
 * Allocation form.
 *
 * @package    cemetery
 * @subpackage form
 * @author     Prakash Panchal
 * @version    SVN: $Id: AllocationDetailsForm.class.php,v 1.1.1.1 2012/03/24 11:56:26 nitin Exp $
 */
sfProjectConfiguration::getActive()->loadHelpers(array('jQuery', 'Url'));
class AllocationDetailsForm extends BaseIntermentBookingForm
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
		
		$this->amStoneMasonList = Doctrine::getTable('sfGuardUser')->getStoneMasonByUserRole();
		
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
		
		$this->amPostData = sfContext::getInstance()->getRequest()->getParameter('service');
		$this->ssInvalidDateMessage = '';
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
        BaseIntermentBookingForm::setWidgets(
            array(
				'grave_size'           			 => new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 35)),
				'grave_length'           		 => new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 36)),
				'grave_width'           		 => new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 37)),
				'grave_depth'           		 => new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 38)),
				'grave_unit_type'           	 => new sfWidgetFormDoctrineChoice(array('model' => 'UnitType', 'add_empty' => $asWidgets['unit_type_id']), array('tabindex'=>39)),
								
				'monuments_grave_position'       => new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 46)),
				'monument'                       => new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 47)),
				'cem_stonemason_id'              => new sfWidgetFormChoice(array('choices' => array('' => $asWidgets['cem_stonemason_id']) + $this->amStoneMasonList),array('tabindex'=>48)),
				'monuments_unit_type'            => new sfWidgetFormDoctrineChoice(array('model' => 'UnitType', 'add_empty' => $asWidgets['unit_type_id']), array('tabindex'=>49)),
				'monuments_depth'                => new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 50)),
				'monuments_length'               => new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 51)),
				'monuments_width'                => new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 52)),
				'comment1'                       => new sfWidgetFormTextarea(array(), array('maxlength' => 255,'tabindex'=> 53)),
				'comment2'                       => new sfWidgetFormTextarea(array(), array('maxlength' => 255,'tabindex'=> 54))
           	));

		if(sfContext::getInstance()->getUser()->isSuperAdmin())
		{
			$this->widgetSchema['country_id'] =  new sfWidgetFormChoice(
													array('choices' => array('' => $asWidgets['country_id']) + $this->asCountryList),
													array('tabindex'=>23, 'onChange' => "callAjaxRequest(this.value,'".url_for('servicebooking/getCementryListAsPerCountry')."','service_cementery_list');")
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

        $this->widgetSchema->setNameFormat('service[%s]');
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
        BaseIntermentBookingForm::setValidators(
	    	array(
                'grave_size'	=> new sfValidatorString(
                       								array('required' => false, 'trim' => true)),
                'grave_length'	=> new sfValidatorString( 
                       								array('required' => false, 'trim' => true)),
                'grave_width'	=> new sfValidatorString( 
                       								array('required' => false, 'trim' => true)),
                'grave_depth'	=> new sfValidatorString( 
                       								array('required' => false, 'trim' => true)),
                'grave_unit_type'	=> new sfValidatorString( 
                       								array('required' => false, 'trim' => true)),
													
                'monuments_grave_position'	=> new sfValidatorString( 
                       								array('required' => false, 'trim' => true)),
                'monument'	=> new sfValidatorString( 
                       								array('required' => false, 'trim' => true)),
                'cem_stonemason_id'	=> new sfValidatorString( 
                       								array('required' => false, 'trim' => true)),
                'monuments_unit_type'	=> new sfValidatorString( 
                       								array('required' => false, 'trim' => true)),
                'monuments_depth'	=> new sfValidatorString( 
                       								array('required' => false, 'trim' => true)),
                'monuments_length'	=> new sfValidatorString( 
                       								array('required' => false, 'trim' => true)),
                'monuments_width'	=> new sfValidatorString(
                       								array('required' => false, 'trim' => true)),
                'comment1'	=> new sfValidatorString(
                       								array('required' => false, 'trim' => true)),
                'comment2'	=> new sfValidatorString(
                       								array('required' => false, 'trim' => true))                       								                       								
			)
        );
		
		if(sfContext::getInstance()->getUser()->isSuperAdmin())
		{
			$this->validatorSchema['country_id'] = new sfValidatorChoice(
                                            		array('required' => false, 'choices' => array_keys($this->asCountryList))
                                        			);
		}
		else
		{
			$this->validatorSchema['country_id']	= new sfValidatorChoice(
                                            			array('required' => false, 'choices' => array_keys($this->asCountryList))
                                        				);

			$this->validatorSchema['cem_cemetery_id'] =	new sfValidatorString(
															array('required' => false, 'trim' => true));
		}
		
    }
	// over ride parent object named updateObject for set manual values 
	public function updateObject($values = null)
	{
		if(sfContext::getInstance()->getUser()->isSuperAdmin())
			$this->values['cem_cemetery_id'] = (sfContext::getInstance()->getRequest()->getParameter('service_cem_cemetery_id') != '') ? sfContext::getInstance()->getRequest()->getParameter('service_cem_cemetery_id'): NULL;
		else
		{
			$snCemeteryId = (sfContext::getInstance()->getUser()->getAttribute('cemeteryid')) ? sfContext::getInstance()->getUser()->getAttribute('cemeteryid') : 0;
			$this->values['cem_cemetery_id'] = $snCemeteryId;
		}
			
		$this->values['ar_area_id']  		= (sfContext::getInstance()->getRequest()->getParameter('service_ar_area_id') != '') ? sfContext::getInstance()->getRequest()->getParameter('service_ar_area_id'): NULL;
		$this->values['ar_section_id']  	= (sfContext::getInstance()->getRequest()->getParameter('service_ar_section_id') != '') ? sfContext::getInstance()->getRequest()->getParameter('service_ar_section_id') : NULL;
		$this->values['ar_row_id']  		= (sfContext::getInstance()->getRequest()->getParameter('service_ar_row_id') != '') ? sfContext::getInstance()->getRequest()->getParameter('service_ar_row_id') : NULL;
		$this->values['ar_plot_id']  		= (sfContext::getInstance()->getRequest()->getParameter('service_ar_plot_id') != '') ? sfContext::getInstance()->getRequest()->getParameter('service_ar_plot_id') : NULL;
		$this->values['ar_grave_id']  		= (sfContext::getInstance()->getRequest()->getParameter('service_ar_grave_id') != '') ? sfContext::getInstance()->getRequest()->getParameter('service_ar_grave_id') : NULL;
		
		$this->values['grantee_id']  			= sfContext::getInstance()->getRequest()->getParameter('service_grantee_id',0);
		$this->values['grantee_relationship']  	= sfContext::getInstance()->getRequest()->getParameter('service_grantee_relationship','');
		
		$this->values['grave_length']  		= sfContext::getInstance()->getRequest()->getParameter('service_grave_length',0);
		$this->values['grave_width']  		= sfContext::getInstance()->getRequest()->getParameter('service_grave_width',0);
		$this->values['grave_depth']  		= sfContext::getInstance()->getRequest()->getParameter('service_grave_depth',0);
		$this->values['grave_unit_type']  	= sfContext::getInstance()->getRequest()->getParameter('service_grave_unit_type',0);
		
		$this->values['user_id'] 			= sfContext::getInstance()->getUser()->getAttribute('userid');
		
		parent::updateObject($this->values);
	}
}
