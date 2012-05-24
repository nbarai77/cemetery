<?php

/**
 * Grantee form.
 *
 * @package    cemetery
 * @subpackage form
 * @author     Prakash Panchal
 * @version    SVN: $Id: GranteeForm.class.php,v 1.1.1.1 2012/03/24 11:56:24 nitin Exp $
 */
sfProjectConfiguration::getActive()->loadHelpers(array('jQuery', 'Url'));
class GranteeForm extends BaseGranteeForm
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
		
		// Post Request Data.
		$this->amPostData = sfContext::getInstance()->getRequest()->getParameter('grantee');
		
		$this->ssInvalidDateMessage = '';
		$this->snCemeteryId = (sfContext::getInstance()->getUser()->isSuperAdmin()) ? sfContext::getInstance()->getRequest()->getParameter('cemetery_id','') : sfContext::getInstance()->getUser()->getAttribute('cemeteryid');
		$this->amCementery = Doctrine::getTable('CemCemetery')->getAllCemeteries('', $this->snCemeteryId);
		$this->amCementeryList = array();
		if(count($this->amCementery) > 0)
		{
			foreach($this->amCementery as $ssKey => $asResult)
				$this->amCementeryList[$asResult['id']] = $asResult['name'];
		}
        
        $this->amCatalog = Doctrine::getTable('Catalog')->getCatalogList()->fetchArray();        
		$this->amCatalogList = array();
		if(count($this->amCatalog) > 0)
		{
			foreach($this->amCatalog as $ssKey => $asResult)
				$this->amCatalogList[$asResult['id']] = $asResult['name'];
		}
        $this->ssPaymentStatus = array(1=>'Credit',2=>'Waiting',3=>'Pending');
		$this->snGranteeId = sfContext::getInstance()->getRequest()->getParameter('grantee_id');
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
        BaseGranteeForm::setWidgets(
            array(
                    //'ar_grave_status_id' 	=> new sfWidgetFormDoctrineChoice(array('model' => 'ArGraveStatus', 'add_empty' => $asWidgets['ar_grave_status_id']),array('tabindex'=>7)),
                    'grantee_identity_id' 	=> new sfWidgetFormDoctrineChoice(array('model' => 'GranteeIdentity', 'add_empty' => $asWidgets['grantee_identity_id']),array('tabindex'=>9)),
					'grantee_identity_number' => new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 10)),
                    'receipt_number' 		=> new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 11)),
                    'control_number' 		=> new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 12)),
                    'invoice_number' 		=> new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 13)),

					'date_of_purchase'		=> new sfWidgetFormDateJQueryUI(
														array("change_month"	=> true, 
															  "change_year" 	=> true,
															  "dateFormat"		=> "dd-mm-yy",
															  "showSecond" 		=> false, 
															  'show_button_panel' => false),
														array('tabindex'=>14,'readonly'=>false)),
					'tenure_expiry_date'	=> new sfWidgetFormDateJQueryUI(
														array("change_month"	=> true, 
															  "change_year" 	=> true,
															  "dateFormat"		=> "dd-mm-yy",
															  "showSecond" 		=> false, 
															  'show_button_panel' => false),
														array('tabindex'=>15,'readonly'=>false)),
                    'cost' 					=> new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 16)),
                    
                    'catalog_id' => new sfWidgetFormChoice(
														array('choices' => array('' => $asWidgets['catalog_id']) + $this->amCatalogList),
														array('tabindex'=>1)),
                    'payment_id' => new sfWidgetFormChoice(
														array('choices' => array('' => $asWidgets['payment_id']) + $this->ssPaymentStatus),
														array('tabindex'=>1)), 
            	));

		$this->widgetSchema['country_id'] = new sfWidgetFormInputHidden(array(), array('value' => (count($this->amCementery)?$this->amCementery[0]['country_id']:''),'readonly' => 'true'));
		
		if(sfContext::getInstance()->getUser()->isSuperAdmin())
		{
			$this->widgetSchema['cem_cemetery_id'] = new sfWidgetFormChoice(
														array('choices' => array('' => $asWidgets['cem_cemetery_id']) + $this->amCementeryList),
														array('tabindex'=>1, 
															  'onChange' => jq_remote_function(
																array('url'		=> url_for('grantee/getAreaListAsPerCemetery'),
																	  'update'	=> 'grantee_area_list',
																	  'with'	=> "'cemetery_id='+this.value+'&country_id='+$('#grantee_country_id').val()",
																	  'loading' => '$("#IdAjaxLocaderArea").show();',
																	  'complete'=> '$("#IdAjaxLocaderArea").hide();'.jq_remote_function(
																					array('url'		=> url_for('grantee/getSectionListAsPerArea'),
																						  'update'	=> 'grantee_section_list',
																						  'with'	=> "'country_id='+$('#grantee_country_id').val()+'&cemetery_id='+$('#grantee_cem_cemetery_id').val()",
																						  'loading' => '$("#IdAjaxLocaderSection").show();',
																						  'complete'=> '$("#IdAjaxLocaderSection").hide();'.jq_remote_function(
																									array('url'		=> url_for('grantee/getRowListAsPerSection'),
																										  'update'	=> 'grantee_row_list',
																										  'with'	=> "'country_id='+$('#grantee_country_id').val()+'&cemetery_id='+$('#grantee_cem_cemetery_id').val()",
																										  'loading' => '$("#IdAjaxLocaderRow").show();',
																										  'complete'=> '$("#IdAjaxLocaderRow").hide();'.jq_remote_function(
																														array('url'		=> url_for('grantee/getPlotListAsPerRow'),
																															  'update'	=> 'grantee_plot_list',
																															  'with'	=> "'country_id='+$('#grantee_country_id').val()+'&cemetery_id='+$('#grantee_cem_cemetery_id').val()",
																															  'loading' => '$("#IdAjaxLocaderPlot").show();',
																															  'complete'=> '$("#IdAjaxLocaderPlot").hide();'.jq_remote_function(
																																	array('url'		=> url_for('grantee/getGraveListAsPerPlot'),
																																		  'update'	=> 'grantee_grave_list',
																																		  'with'	=> "'plot_id='+$('#grantee_ar_plot_id').val()+'&country_id='+$('#grantee_country_id').val()+'&cemetery_id='+$('#grantee_cem_cemetery_id').val()+'&area_id='+$('#grantee_ar_area_id').val()+'&section_id='+$('#grantee_ar_section_id').val()+'&row_id='+$('#grantee_ar_row_id').val()+'&grantee_id='+$('#grantee_id').val()",
																																		  'loading' => '$("#IdAjaxLocaderGrave").show();',
																																		  'complete'=> '$("#IdAjaxLocaderGrave").hide();'))
																															))
																									))
																					))
																	))
													  ));
		}
		else
		{
			$snCemeteryId = sfContext::getInstance()->getUser()->getAttribute('cemeteryid');
			$this->widgetSchema['cem_cemetery_id'] = new sfWidgetFormInputHidden(array(), array('value' => $snCemeteryId,'readonly' => 'true'));			
			//$this->setDefault('cem_cemetery_id',$snCemeteryId);
		}		
		$this->setDefault('country_id', (count($this->amCementery)?$this->amCementery[0]['country_id']:''));
		
		if($this->isNew())
		{
			$this->setDefault('date_of_purchase', sfConfig::get('app_default_date_formate'));
			$this->setDefault('tenure_expiry_date', sfConfig::get('app_default_date_formate'));
		}
		else{
        
			if($this->getObject()->getDateOfPurchase() == '0000-00-00')
                $this->setDefault('date_of_purchase', sfConfig::get('app_default_date_formate'));
            else
                $this->setDefault('date_of_purchase', date('d-m-Y',strtotime($this->getObject()->getDateOfPurchase())));
             
            if($this->getObject()->getDateOfPurchase() == '0000-00-00')
                $this->setDefault('tenure_expiry_date', sfConfig::get('app_default_date_formate'));
            else
                $this->setDefault('tenure_expiry_date', date('d-m-Y',strtotime($this->getObject()->getTenureExpiryDate())));
		}
        $this->widgetSchema->setNameFormat('grantee[%s]'); 
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
		$this->ssInvalidDateMessage = $amValidators['tenure_expiry_date']['invalid'];
        BaseGranteeForm::setValidators(
	    	array(
                /*'ar_grave_status_id'		=> new sfValidatorString( 
                       								array('required' => false, 'trim' => true)
												),*/
                'grantee_identity_id'		=> new sfValidatorString( 
                       								array('required' => false, 'trim' => true),
                       								array('required' => $amValidators['grantee_identity_id']['required'])
												),
				'grantee_identity_number' 	=> new sfValidatorString(
                                            		array('required' => false, 'trim' => true)
                                        		),
				'receipt_number'       		=> new sfValidatorString(
                                            		array('required' => false, 'trim' => true)
                                        		),
				'control_number'       		=> new sfValidatorString(
                                            		array('required' => false, 'trim' => true)
                                        		),
				'invoice_number'       		=> new sfValidatorString(
                                            		array('required' => false, 'trim' => true)
                                        		),
				'date_of_purchase'       	=> new sfValidatorString(
                                            		array('required' => false, 'trim' => true)
                                        		),
				'tenure_expiry_date'       	=> new sfValidatorAnd(array(new sfValidatorDate(), new sfValidatorCallback(
														array('callback'=> array($this,'checkValidDate'),
															  'arguments' => array('ssTenureFrom' => $this->amPostData['date_of_purchase'],
																				  'ssTenureTo' => $this->amPostData['tenure_expiry_date']
															  						)
																				  ),
														array('invalid'=> $amValidators['tenure_expiry_date']['invalid']))
														),															
														array('required' => false, 'trim' => true)
												),
				'cost'       				=> new sfValidatorString(
                                            		array('required' => false, 'trim' => true)
                                        		),
                'catalog_id'  =>              new sfValidatorString( 
												array('required' => false, 'trim' => true)),
                'payment_id'  =>              new sfValidatorString( 
												array('required' => false, 'trim' => true)),
			)
        );
		
		$this->validatorSchema['country_id']	= new sfValidatorDoctrineChoice(
													array('model'=>'Country','multiple'=>false,'required'=>false));

		if(sfContext::getInstance()->getUser()->isSuperAdmin())
		{
			$this->validatorSchema['cem_cemetery_id'] = new sfValidatorChoice(
															array('required' => true, 'choices' => array_keys($this->amCementeryList)),
															array('required'=> $amValidators['cem_cemetery_id']['required'])
														);
		}
		else
		{
			$this->validatorSchema['cem_cemetery_id'] =	new sfValidatorString(
															array('required' => false, 'trim' => true));
		}
    }
	// over ride parent object named updateObject for set manual values 
	public function updateObject($values = null)
	{		
        if($this->values['grantee_identity_id'] == '')
            unset($this->values['grantee_identity_id']);
        if($this->values['catalog_id'] == '')
            unset($this->values['catalog_id']);
        if($this->values['payment_id'] == '')
            unset($this->values['payment_id']);
        
		$this->values['grantee_details_id'] = sfContext::getInstance()->getRequest()->getParameter('grantee_id');
		$this->values['ar_area_id']  		= (sfContext::getInstance()->getRequest()->getParameter('grantee_ar_area_id') != '') 
												? sfContext::getInstance()->getRequest()->getParameter('grantee_ar_area_id') 
												: NULL;
		$this->values['ar_section_id']  	= (sfContext::getInstance()->getRequest()->getParameter('grantee_ar_section_id') != '') 
												? sfContext::getInstance()->getRequest()->getParameter('grantee_ar_section_id') 
												: NULL;
		$this->values['ar_row_id']  		= (sfContext::getInstance()->getRequest()->getParameter('grantee_ar_row_id') != '') 
												? sfContext::getInstance()->getRequest()->getParameter('grantee_ar_row_id') 
												: NULL;
		$this->values['ar_plot_id']  		= (sfContext::getInstance()->getRequest()->getParameter('grantee_ar_plot_id')) 
												? sfContext::getInstance()->getRequest()->getParameter('grantee_ar_plot_id') : NULL;
		$this->values['ar_grave_id']  		= (sfContext::getInstance()->getRequest()->getParameter('grantee_ar_grave_id') != '') 
												? sfContext::getInstance()->getRequest()->getParameter('grantee_ar_grave_id') 
												: NULL;
		$this->values['user_id'] 			= sfContext::getInstance()->getUser()->getAttribute('userid');
		
		$this->values['tenure_expiry_date'] = ($this->values['tenure_expiry_date'] != '') ? date('Y-m-d',strtotime($this->values['tenure_expiry_date'])) : '';
		
		parent::updateObject($this->values);
	}
	/**
     * Fuction checkValidDate to check date is greater than or equal to current date
     * @param $validator 	= Call Validator
     * @param $snCurrentDate 	= date
	 
	 * return  $snCurrentDate valid date
     */
	public function checkValidDate($validator, $ssTenureFrom, $asArguments) 
	{		
		if( date("Y-m-d", strtotime($asArguments['ssTenureTo'])) <= date("Y-m-d", strtotime($asArguments['ssTenureFrom'])) && $asArguments['ssTenureFrom'] != sfConfig::get('app_default_date_formate'))
			throw new sfValidatorError($validator, $this->ssInvalidDateMessage);
		else
			return date("d-m-Y",strtotime($asArguments['ssTenureTo']));
	}
}
