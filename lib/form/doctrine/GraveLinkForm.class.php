<?php

/**
 * GraveLink form.
 *
 * @package    cemetery
 * @subpackage form
 * @author     Prakash Panchal
 * @version    SVN: $Id: GraveLinkForm.class.php,v 1.1.1.1 2012/03/24 11:56:26 nitin Exp $
 */
class GraveLinkForm extends BaseGraveLinkForm
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
        BaseGraveLinkForm::setWidgets(array());

		if(sfContext::getInstance()->getUser()->isSuperAdmin())
		{
			$this->widgetSchema['country_id'] =  new sfWidgetFormChoice(
													array('choices' => array('' => $asWidgets['country_id']) + $this->asCountryList),
													array('tabindex'=>1, 'onChange' => "callAjaxRequest(this.value,'".url_for('grave/getCementryListAsPerCountry')."','grave_cemetery_list');")
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
        BaseGraveLinkForm::setValidators(array());
		
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

		$this->values['ar_area_id']  		= (sfContext::getInstance()->getRequest()->getParameter('grave_ar_area_id') != '') 
		                                        ? sfContext::getInstance()->getRequest()->getParameter('grave_ar_area_id') 
		                                        : NULL;
		$this->values['ar_section_id']  	= (sfContext::getInstance()->getRequest()->getParameter('grave_ar_section_id') != '') 
		                                        ? sfContext::getInstance()->getRequest()->getParameter('grave_ar_section_id') 
		                                        : NULL;
		$this->values['ar_row_id']  		= (sfContext::getInstance()->getRequest()->getParameter('grave_ar_row_id') != '') 
		                                        ? sfContext::getInstance()->getRequest()->getParameter('grave_ar_row_id') 
		                                        : NULL;
		$this->values['ar_plot_id']  		= (sfContext::getInstance()->getRequest()->getParameter('grave_ar_plot_id') != '') 
		                                        ? sfContext::getInstance()->getRequest()->getParameter('grave_ar_plot_id') 
		                                        : NULL;

	    $anGraveId = sfContext::getInstance()->getRequest()->getParameter('grave_ar_grave_id');
	    $ssGraveId = implode(',', $anGraveId);

        if(!$this->isNew())
        {
            $ssGraveId = $this->getObject()->getGraveId().','.$ssGraveId;
        }
        $this->values['grave_id'] = $ssGraveId;

		parent::updateObject($this->values);
	}
}
