<?php

/**
 * ArGrave form.
 *
 * @package    cemetery
 * @subpackage form
 * @author     Prakash Panchal
 * @version    SVN: $Id: ArGraveForm.class.php,v 1.1.1.1 2012/03/24 11:56:42 nitin Exp $
 */
sfProjectConfiguration::getActive()->loadHelpers(array('jQuery', 'Url'));
class ArGraveForm extends BaseArGraveForm
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
		
		$this->amStoneMasonList = Doctrine::getTable('sfGuardUser')->getStoneMasonByUserRole();
		
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
                    'grave_number' 		=> new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 8)),
					'ar_grave_status_id' => new sfWidgetFormDoctrineChoice(array('model' => 'ArGraveStatus', 'add_empty' => $asWidgets['ar_grave_status_id']),array('tabindex'=>9)),					
					'grave_image1' 		=> new sfWidgetFormInputFile(array(),array('tabindex'=> 11)),
					'grave_image2' 		=> new sfWidgetFormInputFile(array(),array('tabindex'=> 12)),
                    'length' 			=> new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 13)),
                    'width' 			=> new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 14)),
                    'height' 			=> new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 15)),
                    'unit_type_id' 		=> new sfWidgetFormDoctrineChoice(array('model' => 'UnitType', 'add_empty' => $asWidgets['unit_type_id']),array('tabindex'=>16)),
                    'cem_stonemason_id' => new sfWidgetFormChoice(array('choices' => array('' => $asWidgets['cem_stonemason_id']) + $this->amStoneMasonList),array('tabindex'=>17)),
                    'details'    		=> new sfWidgetFormTextArea(array(), array('tabindex'=> 18)),
					'latitude'                		=> new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 19)),
					'longitude'                		=> new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 20)),
                    'is_enabled'         			=> new MyWidgetFormInputCheckbox(array(), array('tabindex' => 21, 'value' => 1)),
					'monuments_grave_position'       => new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 22)),
					'monument'                       => new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 23)),
					'monuments_unit_type'            => new sfWidgetFormDoctrineChoice(array('model' => 'UnitType', 'add_empty' => $asWidgets['unit_type_id']), array('tabindex'=>24)),
					'monuments_depth'                => new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 25)),
					'monuments_length'               => new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 26)),
					'monuments_width'                => new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 27)),
					'comment1'                		 => new sfWidgetFormTextarea(array(), array('tabindex'=> 28)),
					'comment2'                		 => new sfWidgetFormTextarea(array(), array('tabindex'=> 29))
            	));

		if($this->isNew())
		{
			$this->widgetSchema['grantee_unique_id'] = new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 10));
		}
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
        BaseArGraveForm::setValidators(
	    	array(
				'ar_grave_status_id'	=> new sfValidatorString( 
                       								array('required' => true, 'trim' => true),
													array('required'=> $amValidators['ar_grave_status_id']['required'])
												),
                'grantee_unique_id'		=> new sfValidatorString( 
                       								array('required' => false, 'trim' => true)
												),
                'cem_stonemason_id'		=> new sfValidatorString( 
                       								array('required' => false, 'trim' => true)
												),												
				'grave_number'       	=> new sfValidatorString(
                                            		array('required' => true, 'trim' => true),
													array('required'=> $amValidators['grave_number']['required'])
                                        		),
				'grave_image1'    		=> new sfValidatorFile(
											array('required'=> false,'trim' => true, "mime_types" => 
												array('image/bmp','image/gif','image/jpeg','image/pjpeg','image/png','image/x-bmp','image/x-png')),
											array("mime_types"	=> $amValidators['grave_image1']['mime_types'])
											),
				'grave_image2'    		=> new sfValidatorFile(
											array('required'=> false, 'trim' => true, "mime_types"	=> 
												array('image/bmp','image/gif','image/jpeg','image/pjpeg','image/png','image/x-bmp','image/x-png')),
											array("mime_types"	=> $amValidators['grave_image2']['mime_types'])
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
                                        		),
				'monuments_grave_position'	=> new sfValidatorString( 
                       								array('required' => false, 'trim' => true)),
                'monument'					=> new sfValidatorString( 
                       								array('required' => false, 'trim' => true)),
                'monuments_unit_type'		=> new sfValidatorString( 
                       								array('required' => false, 'trim' => true)),
                'monuments_depth'			=> new sfValidatorString( 
                       								array('required' => false, 'trim' => true)),
                'monuments_length'			=> new sfValidatorString( 
                       								array('required' => false, 'trim' => true)),
                'monuments_width'			=> new sfValidatorString(
                       								array('required' => false, 'trim' => true)),
				'latitude'					=> new sfValidatorString( 
                       								array('required' => false, 'trim' => true)),
				'longitude'					=> new sfValidatorString( 
                       								array('required' => false, 'trim' => true)),
				'comment1'					=> new sfValidatorString( 
                       								array('required' => false, 'trim' => true)),
				'comment2'					=> new sfValidatorString( 
                       								array('required' => false, 'trim' => true))
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
    }
	// over ride parent object named updateObject for set manual values 
	public function updateObject($values = null)
	{
		if(sfContext::getInstance()->getUser()->isSuperAdmin())
			$this->values['cem_cemetery_id'] = sfContext::getInstance()->getRequest()->getParameter('grave_cem_cemetery_id');

		$this->values['ar_area_id']  		= (sfContext::getInstance()->getRequest()->getParameter('grave_ar_area_id') != '') ? sfContext::getInstance()->getRequest()->getParameter('grave_ar_area_id') : NULL;
		$this->values['ar_section_id']  	= (sfContext::getInstance()->getRequest()->getParameter('grave_ar_section_id') != '') ? sfContext::getInstance()->getRequest()->getParameter('grave_ar_section_id') : NULL;
		$this->values['ar_row_id']  		= (sfContext::getInstance()->getRequest()->getParameter('grave_ar_row_id') != '') ? sfContext::getInstance()->getRequest()->getParameter('grave_ar_row_id') : NULL;
		$this->values['ar_plot_id']  		= (sfContext::getInstance()->getRequest()->getParameter('grave_ar_plot_id') != '') ? sfContext::getInstance()->getRequest()->getParameter('grave_ar_plot_id') : NULL;
		
		$this->values['user_id'] 			= sfContext::getInstance()->getUser()->getAttribute('userid');
		parent::updateObject($this->values);
	}
}
