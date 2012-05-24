<?php

/**
 * SurrenderdGrave form.
 *
 * @package    cemetery
 * @subpackage form
 * @author     Prakash Panchal
 * @version    SVN: $Id: SurrenderdGraveForm.class.php,v 1.1.1.1 2012/03/24 11:56:28 nitin Exp $
 */
sfProjectConfiguration::getActive()->loadHelpers(array('jQuery', 'Url'));
class SurrenderdGraveForm extends sfForm
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
		$this->snGranteeId = sfContext::getInstance()->getRequest()->getParameter('grantee_id','');
		$asPostData = sfContext::getInstance()->getRequest()->getParameter('surrendergrave');
        
        $this->amCatalog = Doctrine::getTable('Catalog')->getCatalogList()->fetchArray();        
		$this->amCatalogList = array();
		if(count($this->amCatalog) > 0)
		{
			foreach($this->amCatalog as $ssKey => $asResult)
				$this->amCatalogList[$asResult['id']] = $asResult['name'];
		}
        $this->ssPaymentStatus = array(1=>'Credit',2=>'Waiting',3=>'Pending');
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
					'transfer_date' => new sfWidgetFormDateJQueryUI(
										array("change_month"	=> true, 
											  "change_year" 	=> true,
											  "dateFormat"		=> "dd-mm-yy",
											  "showSecond" 		=> true, 
											  "timeFormat" 		=> 'hh:mm:ss',
											  'show_button_panel' => true),
										array('tabindex'=> 2,'readonly'=>false)),
					//'transfer_cost' => new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 3)),
                    'catalog_id' => new sfWidgetFormChoice(
														array('choices' => array('' => $asWidgets['catalog_id']) + $this->amCatalogList),
														array('tabindex'=>1)),
                    'payment_id' => new sfWidgetFormChoice(
														array('choices' => array('' => $asWidgets['payment_id']) + $this->ssPaymentStatus),
														array('tabindex'=>1)), 
					'grantee_identity_id' 	=> new sfWidgetFormDoctrineChoice(array('model' => 'GranteeIdentity', 'add_empty' => $asWidgets['grantee_identity_id']),array('tabindex'=>4)),
					'grantee_identity_number' => new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 5)),
					'receipt_number' => new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 6)),
	            )
        );        
        $this->setDefault('transfer_date', sfConfig::get('app_default_date_formate'));
        $this->widgetSchema->setNameFormat('surrendergrave[%s]'); 
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
        sfForm::setValidators(
            array(                   
                'grantee_unique_id'			=> new sfValidatorString(
												array('required' => true, 'trim' => true),
												array('required' => $amValidators['grantee_unique_id']['required'])
                                     		  ),
				'transfer_date'				=> new sfValidatorString( 
												array('required' => false, 'trim' => true)),
				//'transfer_cost'				=> new sfValidatorString(array('required' => false, 'trim' => true)),
                'catalog_id'  =>              new sfValidatorString( 
												array('required' => false, 'trim' => true)),
                'payment_id'  =>              new sfValidatorString( 
												array('required' => false, 'trim' => true)),
				'receipt_number'			=> new sfValidatorString( 
												array('required' => false, 'trim' => true)),
				'grantee_identity_id'		=> new sfValidatorString( 
												array('required' => false, 'trim' => true)),
				'grantee_identity_number'	=> new sfValidatorString( 
												array('required' => false, 'trim' => true))
            )
        );
    } 
}
