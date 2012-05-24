<?php

/**
 * ArPlot form.
 *
 * @package    cemetery
 * @subpackage form
 * @author     Prakash Panchal
 * @version    SVN: $Id: ArPlotForm.class.php,v 1.1.1.1 2012/03/24 11:56:41 nitin Exp $
 */
sfProjectConfiguration::getActive()->loadHelpers(array('jQuery', 'Url'));
class ArPlotForm extends BaseArPlotForm
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
        BaseArPlotForm::setWidgets(
            array(
                    'plot_name' 	=> new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 6)),
                    'plot_user' 	=> new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 7)),
                    'length' 		=> new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 8)),
                    'width' 		=> new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 9)),
                    'depth' 		=> new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 10)),
					'plot_map_path' 	=> new sfWidgetFormInputFile(array(),array('tabindex'=> 11)),
                    'is_enabled'         => new MyWidgetFormInputCheckbox(array(), array('tabindex' => 12, 'value' => 1)),
            	));

		if(sfContext::getInstance()->getUser()->isSuperAdmin())
		{
			$this->widgetSchema['country_id'] = new sfWidgetFormChoice(
													array('choices' => array('' => $asWidgets['country_id']) + $this->asCountryList),
													array('tabindex'=>1, 'onChange' => "callAjaxRequest(this.value,'".url_for('plot/getCementryListAsPerCountry')."','plot_cemetery_list');")
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
        $this->widgetSchema->setNameFormat('plot[%s]'); 
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
        BaseArPlotForm::setValidators(
	    	array(
                'plot_name'				=> new sfValidatorString( 
                       								array('required' => true, 'trim' => true),
                       								array('required' => $amValidators['plot_name']['required'])
												),
				'plot_user'       		=> new sfValidatorString(
                                            		array('required' => false, 'trim' => true)
                                        		),
				'length'       			=> new sfValidatorString(
                                            		array('required' => false, 'trim' => true)
                                        		),
				'width'       			=> new sfValidatorString(
                                            		array('required' => false, 'trim' => true)
                                        		),
				'depth'       			=> new sfValidatorString(
                                            		array('required' => false, 'trim' => true)
                                        		),
				'plot_map_path'   	=> new sfValidatorFile(
												array('required'=> false,'trim' => true)
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
    }
	// over ride parent object named updateObject for set manual values 
	public function updateObject($values = null)
	{
		if(sfContext::getInstance()->getUser()->isSuperAdmin())
			$this->values['cem_cemetery_id'] = sfContext::getInstance()->getRequest()->getParameter('plot_cem_cemetery_id');

		$this->values['ar_area_id']  	= (sfContext::getInstance()->getRequest()->getParameter('plot_ar_area_id') != '') ? sfContext::getInstance()->getRequest()->getParameter('plot_ar_area_id') : NULL;
		$this->values['ar_section_id']  = (sfContext::getInstance()->getRequest()->getParameter('plot_ar_section_id') != '') ? sfContext::getInstance()->getRequest()->getParameter('plot_ar_section_id') : NULL;
		$this->values['ar_row_id']  	= (sfContext::getInstance()->getRequest()->getParameter('plot_ar_row_id') != '') ? sfContext::getInstance()->getRequest()->getParameter('plot_ar_row_id') : NULL;
		
		parent::updateObject($this->values);
	}
}
