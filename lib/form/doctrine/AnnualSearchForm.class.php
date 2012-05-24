<?php

/**
 * AnnualSearch Search form.
 *
 * @package    cemetery
 * @subpackage AnnualSearch Form
 * @author     Prakash Panchal
 * @version    SVN: $Id: AnnualSearchForm.class.php,v 1.1.1.1 2012/03/24 11:56:40 nitin Exp $
 */
sfProjectConfiguration::getActive()->loadHelpers(array('jQuery', 'Url'));
class AnnualSearchForm extends BaseArGraveMaintenanceForm
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
		BaseArGraveMaintenanceForm::setWidgets(
            array(
                    'first_name'    => new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 8)),
                    'surname'    	=> new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 9)),
					'renewal_date'	=> new sfWidgetFormDateJQueryUI(
										array("change_month"	=> true, 
											  "change_year" 	=> true,
											  "dateFormat"		=> "dd-mm-yy",
											  "showSecond"		=> false,
											  "buttonImageOnly" => false,
											  'show_button_panel' => true),
										array('tabindex'=>10,'readonly'=>false)),
            	));

		if(sfContext::getInstance()->getUser()->isSuperAdmin())
		{
			$this->widgetSchema['country_id'] =  new sfWidgetFormChoice(
												array('choices' => array('' => $asWidgets['country_id']) + $this->asCountryList),
												array('tabindex'=>1, 'onChange' => "callAjaxRequest(this.value,'".url_for('annualsearch/getCementryListAsPerCountry')."','annualsearch_cemetery_list');")
												);
			$this->setDefault('country_id', $this->snDefaultCountryId);
		}
		else
		{
			$snCemeteryId = sfContext::getInstance()->getUser()->getAttribute('cemeteryid');			
			$oCemetery = Doctrine::getTable('CemCemetery')->find($snCemeteryId);
			$this->widgetSchema['country_id'] = new sfWidgetFormInputHidden(array(), array('value' => $oCemetery->getCountryId(),'readonly' => 'true'));																						  	
			$this->setDefault('country_id',$oCemetery->getCountryId());
			
			$this->widgetSchema['cem_cemetery_id'] = new sfWidgetFormInputHidden(array(), array('value' => $snCemeteryId,'readonly' => 'true'));
			
			if(sfContext::getInstance()->getUser()->getAttribute('cm') != '') {
				$this->setDefault('cem_cemetery_id',$snCemeteryId);	
			}
		}            	
        $this->widgetSchema->setNameFormat('annualsearch[%s]'); 
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
    }
}
