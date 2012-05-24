<?php

/**
 * FacilityBooking form.
 *
 * @package    cemetery
 * @subpackage form
 * @author     Prakash Panchal
 * @version    SVN: $Id: ImportDataForm.class.php,v 1.1.1.1 2012/03/24 11:56:40 nitin Exp $
 */
sfProjectConfiguration::getActive()->loadHelpers(array('jQuery', 'Url')); 
class ImportDataForm extends sfForm
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
		// Get cemetery List as per user role
		if(sfContext::getInstance()->getUser()->isSuperAdmin())
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
		$this->disableLocalCSRFProtection();
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
         sfForm::setWidgets(
            array(
                    'import_file' => new sfWidgetFormInputFile(array(),array('tabindex'=>3) )
	            )
        ); 	
           	
		if(sfContext::getInstance()->getUser()->isSuperAdmin())
		{
			$this->widgetSchema['country_id'] = new sfWidgetFormChoice(
													array('choices' => array('' => $asWidgets['country_id']) + $this->asCountryList),
													array('tabindex'=>1, 'onChange' => "callAjaxRequest(this.value,'".url_for('importcemetery/getCementryListAsPerCountry')."','importcemetery_cementery_list');")
												);
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
        $this->widgetSchema->setNameFormat('importdata[%s]'); 
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
		$this->validatorSchema['import_file']  = new sfValidatorFile(array (
													'required' => true,															
//													'mime_types' => array ('application/vnd.ms-excel', 'application/ms-excel', 'application/msexcel','application/csv')
												),array('required' => $amValidators['import_file']['required'],
//													 'mime_types' => $amValidators['import_file']['invalid']
												));
										
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

			$this->validatorSchema['cem_cemetery_id'] = new sfValidatorString(
															array('required' => false, 'trim' => true)
														);
		}   		
    }
	/**
     * Fuction checkValidDate to check date is greater than or equal current date
     * @param $validator 	= Call Validator
     * @param $snCurrentDate 	= date
	 
	 * return  $snCurrentDate valid date
     */
	public function checkValidDate($validator, $snCurrentDate) 
	{	
		if(date("Y-m-d",strtotime($snCurrentDate)) < date('Y-m-d'))
			throw new sfValidatorError($validator, $this->ssInvalidDateMessage);
		else 
			return $snCurrentDate;
	}
}
