<?php

/**
 * PurchaseGrave form.
 *
 * @package    cemetery
 * @subpackage form
 * @author     Prakash Panchal
 * @version    SVN: $Id: PurchaseGraveForm.class.php,v 1.1.1.1 2012/03/24 11:56:40 nitin Exp $
 */
class PurchaseGraveForm extends sfForm
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
		// Post Request Data.
		$this->amPostData = sfContext::getInstance()->getRequest()->getParameter('purchasegrave');
		
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
        sfForm::setWidgets(
            array(
                    'grantee_unique_id' => new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 1)),
					'purchase_date' => new sfWidgetFormDateJQueryUI(
										array("change_month"	=> true, 
											  "change_year" 	=> true,
											  "dateFormat"		=> "dd-mm-yy",
											  "showSecond" 		=> false, 
											  'show_button_panel' => false),
										array('tabindex'=> 2,'readonly'=>false)),
					'tenure_expiry_date'	=> new sfWidgetFormDateJQueryUI(
														array("change_month"	=> true, 
															  "change_year" 	=> true,
															  "dateFormat"		=> "dd-mm-yy",
															  "showSecond" 		=> false, 
															  'show_button_panel' => false),
														array('tabindex'=>3,'readonly'=>false)),
					'grantee_identity_id' 	=> new sfWidgetFormDoctrineChoice(array('model' => 'GranteeIdentity', 'add_empty' => $asWidgets['grantee_identity_id']),array('tabindex'=>4)),
					'grantee_identity_number' => new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 5)),
	            )
        );
        $this->widgetSchema->setNameFormat('purchasegrave[%s]'); 
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
        sfForm::setValidators(
            array(                   
                'grantee_unique_id'	=> new sfValidatorString(
										array('required' => true, 'trim' => true),
										array('required' => $amValidators['grantee_unique_id']['required'])
                                       ),
				'purchase_date'			=> new sfValidatorString( 
											array('required' => false, 'trim' => true)),
				'tenure_expiry_date'    => new sfValidatorAnd(array(new sfValidatorDate(), new sfValidatorCallback(
												array('callback'=> array($this,'checkValidDate'),
													  'arguments' => array('ssTenureFrom' => $this->amPostData['purchase_date'],
																		  'ssTenureTo' => $this->amPostData['tenure_expiry_date']
																			)
																		  ),
												array('invalid'=> $amValidators['tenure_expiry_date']['invalid']))
												),															
												array('required' => false, 'trim' => true)
											),
				'grantee_identity_id'		=> new sfValidatorString( 
												array('required' => false, 'trim' => true)),
				'grantee_identity_number'	=> new sfValidatorString( 
												array('required' => false, 'trim' => true)),				
            )
        );
        $this->setDefault('purchase_date', sfConfig::get('app_default_date_formate'));
		$this->setDefault('tenure_expiry_date', sfConfig::get('app_default_date_formate'));
		
    }
	/**
     * Fuction checkValidDate to check date is greater than or equal to current date
     * @param $validator 	= Call Validator
     * @param $snCurrentDate 	= date
	 
	 * return  $snCurrentDate valid date
     */
	public function checkValidDate($validator, $ssTenureFrom, $asArguments) 
	{		
		if( date("Y-m-d", strtotime($asArguments['ssTenureTo'])) <= date("Y-m-d", strtotime($asArguments['ssTenureFrom'])) )
			throw new sfValidatorError($validator, $this->ssInvalidDateMessage);
		else
			return date("d-m-Y",strtotime($asArguments['ssTenureTo']));
	}
}
