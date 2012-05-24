<?php

/**
 * ApplicantDetails form.
 *
 * @package    cemetery
 * @subpackage form
 * @author     Prakash Panchal
 * @version    SVN: $Id: ApplicantDetailsForm.class.php,v 1.1.1.1 2012/03/24 11:56:31 nitin Exp $
 */
sfProjectConfiguration::getActive()->loadHelpers(array('jQuery', 'Url'));
class ApplicantDetailsForm extends BaseIntermentBookingFourForm
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
		unset($this['id']);
		$this->asCountryList = array();
		$this->snDefaultCountryId = 0;
		$omCriteria = Doctrine::getTable('Country')->getCountryList(array(),array());
		$amCountry = $omCriteria->orderBy('sf.name')->fetchArray();
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
        BaseIntermentBookingFourForm::setWidgets(
            array(
				'relationship_to_deceased'       => new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 1)),
                'informant_title'                => new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 2)),                
                'informant_surname'              => new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 2)),
				'informant_first_name'           => new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 3)),
				'informant_middle_name'          => new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 4)),
				'informant_email'                => new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 5)),
				'informant_address'              => new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 6)),
				'informant_suburb_town'          => new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 7)),				

				'informant_state'          		 => new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 8)),
				'informant_postal_code'          => new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 9)),
				'informant_country_id'           => new sfWidgetFormChoice(
													array('choices' => array('' => $asWidgets['informant_country_id']) + $this->asCountryList),
													array('tabindex'=> 10)),
				'informant_telephone_area_code'  => new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 11)),
				'informant_telephone'            => new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 12)),
				'informant_mobile'               => new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 13)),
				'informant_fax_area_code'        => new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 14)),
				'informant_fax'                  => new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 15)),
           	));
		
        $this->widgetSchema->setNameFormat('informant[%s]');
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
        BaseIntermentBookingFourForm::setValidators(
	    	array(
				'relationship_to_deceased'	=> new sfValidatorString( 
                       								array('required' => false, 'trim' => true)),
                'informant_title'	=> new sfValidatorString( 
                       								array('required' => false, 'trim' => true)),                                                    
				'informant_surname'	=> new sfValidatorString( 
                       								array('required' => false, 'trim' => true)),
				'informant_telephone'	=> new sfValidatorString( 
                       								array('required' => false, 'trim' => true)),
				'informant_mobile'	=> new sfValidatorString( 
                       								array('required' => false, 'trim' => true)),                       								
				'informant_first_name'	=> new sfValidatorString( 
                       								array('required' => false, 'trim' => true)),
				'informant_fax'	=> new sfValidatorString( 
                       								array('required' => false, 'trim' => true)),
				'informant_middle_name'	=> new sfValidatorString( 
                       								array('required' => false, 'trim' => true)),
				'informant_email'	=> new sfValidatorString( 
                       								array('required' => false, 'trim' => true)),
				'informant_address'	=> new sfValidatorString( 
                       								array('required' => false, 'trim' => true)),
				'informant_suburb_town'	=> new sfValidatorString( 
                       								array('required' => false, 'trim' => true)),
				'informant_state'	    => new sfValidatorString( 
                       								array('required' => false, 'trim' => true)),                       								
				'informant_postal_code'	=> new sfValidatorString( 
                       								array('required' => false, 'trim' => true)),
				'informant_country_id'	=> new sfValidatorString( 
                       								array('required' => false, 'trim' => true)),
				'informant_telephone_area_code'	=> new sfValidatorString( 
                       								array('required' => false, 'trim' => true)),
				'informant_fax_area_code'	=> new sfValidatorString( 
                       								array('required' => false, 'trim' => true))
				)
        );
    }
	// over ride parent object named updateObject for set manual values 
	public function updateObject($values = null)
	{
		$this->values['interment_booking_id']  		= sfContext::getInstance()->getRequest()->getParameter('id');

		parent::updateObject($this->values);
	}
}
