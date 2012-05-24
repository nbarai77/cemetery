<?php

/**
 * GranteeSearch form.
 *
 * @package    cemetery
 * @subpackage GranteeSearch
 * @author     Prakash Panchal
 * @version    SVN: $Id: ReportForm.class.php,v 1.1.1.1 2012/03/24 11:56:30 nitin Exp $
 */
sfProjectConfiguration::getActive()->loadHelpers(array('jQuery', 'Url'));
class ReportForm extends BaseArGraveForm
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
		if(sfContext::getInstance()->getUser()->isSuperAdmin())
		{
			$this->widgetSchema['country_id'] =  new sfWidgetFormChoice(
													array('choices' => array('' => $asWidgets['country_id']) + $this->asCountryList),
													array('tabindex'=>1, 'onChange' => "callAjaxRequest(this.value,'".url_for('report/getCementryListAsPerCountry')."','reports_cemetery_list');")
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
		$this->widgetSchema['from_date'] 	= new sfWidgetFormDateJQueryUI(
													array("change_month"	=> true, 
														  "change_year" 	=> true,
														  "dateFormat"		=> "dd-mm-yy",
														  "showSecond" 		=> false, 
														  'show_button_panel' => false),
													array('tabindex'=>1,'readonly'=>false));
		
		$this->widgetSchema['to_date'] 		= new sfWidgetFormDateJQueryUI(
													array("change_month"	=> true, 
														  "change_year" 	=> true,
														  "dateFormat"		=> "dd-mm-yy",
														  "showSecond" 		=> false, 
														  'show_button_panel' => false),
													array('tabindex'=>2,'readonly'=>false));
		
        $this->widgetSchema->setNameFormat('reports[%s]'); 
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
