<?php

/**
 * ArSection form.
 *
 * @package    cemetery
 * @subpackage form
 * @author     Prakash Panchal
 * @version    SVN: $Id: ArSectionForm.class.php,v 1.1.1.1 2012/03/24 11:56:26 nitin Exp $
 */
sfProjectConfiguration::getActive()->loadHelpers(array('jQuery', 'Url'));
class WhmsClientForm extends sfForm
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
		
			
		$this->asCountryList = array();
		//$omCriteria = Doctrine::getTable('Country')->getCountryList(array(),array());
		//amCountry = $omCriteria->orderBy('sf.name')->fetchArray();
        $asClientName = sfGeneral::getAndSetWHMSDetail('getclients');
        //"<pre>";print_R($asClientName['WHMCSAPI']['CLIENTS']);
		$this->snDefaultCountryId = 0;
		if(count($asClientName['WHMCSAPI']['CLIENTS']) > 0)
		{
			foreach($asClientName['WHMCSAPI']['CLIENTS'] as $ssColumn=>$asDataSet)
			{
				if($asDataSet['FIRSTNAME'] != '')
                    $this->asClientList[$asDataSet['ID']] = $asDataSet['FIRSTNAME']." ".((isset($asDataSet['LASTNAME']) && $asDataSet['LASTNAME'] != '')?$asDataSet['LASTNAME']:'');				
			}
		}
        $this->widgetSchema['clients'] = new sfWidgetFormChoice(
													array('choices' => array('' => 'Select client') + $this->asClientList),
													array('tabindex'=>1)
                                                    
												);
                                                
        $this->widgetSchema['description'] = new sfWidgetFormTextArea(array(), array('tabindex'=> 1));
        $this->widgetSchema['amount'] = new sfWidgetFormInputText(array(), array('tabindex'=> 1));
        $this->widgetSchema['recur'] = new sfWidgetFormInputText(array(), array('tabindex'=> 1));
        $this->widgetSchema['recurcycle'] = new sfWidgetFormInputText(array(), array('tabindex'=> 1));
        $this->widgetSchema['recurfor'] = new sfWidgetFormInputText(array(), array('tabindex'=> 1));
        $this->widgetSchema['invoiceaction'] = new sfWidgetFormInputText(array(), array('tabindex'=> 1));
        
        $this->widgetSchema['duedate']	= new sfWidgetFormDateJQueryUI(
										array("change_month"	=> true, 
											  "change_year" 	=> true,
											  "dateFormat"		=> "dd-mm-yy",
											  "showSecond" 		=> false, 
											  'show_button_panel' => false),
										array('tabindex'=>2,'readonly'=>false));
         
        $this->widgetSchema->setNameFormat('whms[%s]');    
	}
}