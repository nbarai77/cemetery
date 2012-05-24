<?php

/**
 * IntermentBookingThree form.
 *
 * @package    cemetery
 * @subpackage form
 * @author     Prakash Panchal
 * @version    SVN: $Id: IntermentBookingThreeForm.class.php,v 1.1.1.1 2012/03/24 11:56:35 nitin Exp $
 */
class IntermentBookingThreeForm extends BaseIntermentBookingThreeForm
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
		unset($this['id'],$this['cost']);		
		$this->asCommonDeasesStatus = array('Completed' => 'Completed', 'Pending' => 'Pending', 'NA' => 'NA');
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
        BaseIntermentBookingThreeForm::setWidgets(
            array(
	      	'file_location'                     => new sfWidgetFormInputText(array(), array('tabindex'=> 1)),
			'cemetery_application'              => new sfWidgetFormChoice(array('expanded' => true, 'multiple' => false,'choices' => $this->asCommonDeasesStatus),
																								  array('tabindex'=> 2)),
			'burial_booking_form'               => new sfWidgetFormChoice(array('expanded' => true, 'multiple' => false,'choices' => $this->asCommonDeasesStatus),
																								  array('tabindex'=> 3)),
			'ashes_booking_form'                => new sfWidgetFormChoice(array('expanded' => true, 'multiple' => false,'choices' => $this->asCommonDeasesStatus),
																								  array('tabindex'=> 4)),
			'exhumation_booking_from'           => new sfWidgetFormChoice(array('expanded' => true, 'multiple' => false,'choices' => $this->asCommonDeasesStatus),
																								  array('tabindex'=> 5)),
			'health_order'                      => new sfWidgetFormChoice(array('expanded' => true, 'multiple' => false,'choices' => $this->asCommonDeasesStatus),
																								  array('tabindex'=> 6)),
			'court_order'                       => new sfWidgetFormChoice(array('expanded' => true, 'multiple' => false,'choices' => $this->asCommonDeasesStatus),
																								  array('tabindex'=> 7)),
			'remains_booking_from'              => new sfWidgetFormChoice(array('expanded' => true, 'multiple' => false,'choices' => $this->asCommonDeasesStatus),
																								  array('tabindex'=> 8)),
			'checked_fnd_details'               => new sfWidgetFormChoice(array('expanded' => true, 'multiple' => false,'choices' => $this->asCommonDeasesStatus),
																								  array('tabindex'=> 9)),
			'checked_owner_grave'               => new sfWidgetFormChoice(array('expanded' => true, 'multiple' => false,'choices' => $this->asCommonDeasesStatus),
																								  array('tabindex'=> 10)),
			'living_grave_owner'                => new sfWidgetFormChoice(array('expanded' => true, 'multiple' => false,'choices' => $this->asCommonDeasesStatus),
																								  array('tabindex'=> 11)),
			'deceased_grave_owner'              => new sfWidgetFormChoice(array('expanded' => true, 'multiple' => false,'choices' => $this->asCommonDeasesStatus),
																								  array('tabindex'=> 12)),
			'cecked_chapel_booking'             => new sfWidgetFormChoice(array('expanded' => true, 'multiple' => false,'choices' => $this->asCommonDeasesStatus),
																								  array('tabindex'=> 13)),
			'advised_fd_to_check'               => new sfWidgetFormChoice(array('expanded' => true, 'multiple' => false,'choices' => $this->asCommonDeasesStatus),
																								  array('tabindex'=> 14)),
			'advised_fd_recommended'            => new sfWidgetFormChoice(array('expanded' => true, 'multiple' => false,'choices' => $this->asCommonDeasesStatus),
																								  array('tabindex'=> 15)),
			'advised_fd_coffin_height'          => new sfWidgetFormChoice(array('expanded' => true, 'multiple' => false,'choices' => $this->asCommonDeasesStatus),
																								  array('tabindex'=> 16)),
			'medical_death_certificate'         => new sfWidgetFormChoice(array('expanded' => true, 'multiple' => false,'choices' => $this->asCommonDeasesStatus),
																								  array('tabindex'=> 17)),
			'medical_certificate_spelling'      => new sfWidgetFormChoice(array('expanded' => true, 'multiple' => false,'choices' => $this->asCommonDeasesStatus),
																								  array('tabindex'=> 18)),
			'medical_certificate_infectious'	=> new sfWidgetFormChoice(array('expanded' => true, 'multiple' => false,'choices' => $this->asCommonDeasesStatus),
																								  array('tabindex'=> 19)),
			'request_probe_reopen'              => new sfWidgetFormChoice(array('expanded' => true, 'multiple' => false,'choices' => $this->asCommonDeasesStatus),
																								  array('tabindex'=> 20)),
			'request_triple_depth_reopen'       => new sfWidgetFormChoice(array('expanded' => true, 'multiple' => false,'choices' => $this->asCommonDeasesStatus),
																								  array('tabindex'=> 21)),
			'checked_monumental'                => new sfWidgetFormChoice(array('expanded' => true, 'multiple' => false,'choices' => $this->asCommonDeasesStatus),
																								  array('tabindex'=> 22)),
			'contacted_stonemason'              => new sfWidgetFormChoice(array('expanded' => true, 'multiple' => false,'choices' => $this->asCommonDeasesStatus),
																								  array('tabindex'=> 23)),
			'checked_accessories'               => new sfWidgetFormChoice(array('expanded' => true, 'multiple' => false,'choices' => $this->asCommonDeasesStatus),
																								  array('tabindex'=> 24)),
			'balloons_na'                       => new sfWidgetFormChoice(array('expanded' => true, 'multiple' => false,'choices' => $this->asCommonDeasesStatus),
																								  array('tabindex'=> 25)),
			'burning_drum'                      => new sfWidgetFormChoice(array('expanded' => true, 'multiple' => false,'choices' => $this->asCommonDeasesStatus),
																								  array('tabindex'=> 26)),
			'canopy'                            => new sfWidgetFormChoice(array('expanded' => true, 'multiple' => false,'choices' => $this->asCommonDeasesStatus),
																								  array('tabindex'=> 27)),
			'ceremonial_sand_bucket'            => new sfWidgetFormChoice(array('expanded' => true, 'multiple' => false,'choices' => $this->asCommonDeasesStatus),
																								  array('tabindex'=> 28)),
			'fireworks'                         => new sfWidgetFormChoice(array('expanded' => true, 'multiple' => false,'choices' => $this->asCommonDeasesStatus),
																								  array('tabindex'=> 29)),
			'lowering_device'                   => new sfWidgetFormChoice(array('expanded' => true, 'multiple' => false,'choices' => $this->asCommonDeasesStatus),
																								  array('tabindex'=> 30)),
			'other'                             => new sfWidgetFormTextarea(array(), array('tabindex'=> 31)),
			'checked_returned_signed'           => new sfWidgetFormChoice(array('expanded' => true, 'multiple' => false,'choices' => $this->asCommonDeasesStatus),
																								  array('tabindex'=> 32)),
			'check_coffin_sizes_surcharge'      => new sfWidgetFormChoice(array('expanded' => true, 'multiple' => false,'choices' => $this->asCommonDeasesStatus),
																								  array('tabindex'=> 33)),
			'surcharge_applied'      			=> new sfWidgetFormChoice(array('expanded' => true, 'multiple' => false,'choices' => $this->asCommonDeasesStatus),
																								  array('tabindex'=> 34)),
			'compare_burial_booking'            => new sfWidgetFormChoice(array('expanded' => true, 'multiple' => false,'choices' => $this->asCommonDeasesStatus),
																								  array('tabindex'=> 35)),
			'for_between_burials'               => new sfWidgetFormChoice(array('expanded' => true, 'multiple' => false,'choices' => $this->asCommonDeasesStatus),
																								  array('tabindex'=> 36)),
			'double_check_yellow_date'			=> new sfWidgetFormChoice(array('expanded' => true, 'multiple' => false,'choices' => $this->asCommonDeasesStatus),
																								  array('tabindex'=> 37))
           	));

        $this->widgetSchema->setNameFormat('servicethree[%s]');
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
        BaseIntermentBookingThreeForm::setValidators(
	    	array(                
					'file_location'                     => new sfValidatorString(array('max_length' => 255, 'required' => false)),
					'cemetery_application'              => new sfValidatorChoice(array('choices' => $this->asCommonDeasesStatus, 'required' => false)),
					'burial_booking_form'               => new sfValidatorChoice(array('choices' => $this->asCommonDeasesStatus, 'required' => false)),
					'ashes_booking_form'                => new sfValidatorChoice(array('choices' => $this->asCommonDeasesStatus, 'required' => false)),
					'exhumation_booking_from'           => new sfValidatorChoice(array('choices' => $this->asCommonDeasesStatus, 'required' => false)),
					'remains_booking_from'              => new sfValidatorChoice(array('choices' => $this->asCommonDeasesStatus, 'required' => false)),
					'health_order'                      => new sfValidatorChoice(array('choices' => $this->asCommonDeasesStatus, 'required' => false)),
					'court_order'                       => new sfValidatorChoice(array('choices' => $this->asCommonDeasesStatus, 'required' => false)),
					'checked_fnd_details'               => new sfValidatorChoice(array('choices' => $this->asCommonDeasesStatus, 'required' => false)),
					'checked_owner_grave'               => new sfValidatorChoice(array('choices' => $this->asCommonDeasesStatus, 'required' => false)),
					'living_grave_owner'                => new sfValidatorChoice(array('choices' => $this->asCommonDeasesStatus, 'required' => false)),
					'deceased_grave_owner'              => new sfValidatorChoice(array('choices' => $this->asCommonDeasesStatus, 'required' => false)),
					'cecked_chapel_booking'             => new sfValidatorChoice(array('choices' => $this->asCommonDeasesStatus, 'required' => false)),
					'advised_fd_to_check'               => new sfValidatorChoice(array('choices' => $this->asCommonDeasesStatus, 'required' => false)),
					'advised_fd_recommended'            => new sfValidatorChoice(array('choices' => $this->asCommonDeasesStatus, 'required' => false)),
					'advised_fd_coffin_height'          => new sfValidatorChoice(array('choices' => $this->asCommonDeasesStatus, 'required' => false)),
					'medical_death_certificate'         => new sfValidatorChoice(array('choices' => $this->asCommonDeasesStatus, 'required' => false)),
					'medical_certificate_spelling'      => new sfValidatorChoice(array('choices' => $this->asCommonDeasesStatus, 'required' => false)),
					'medical_certificate_infectious'	=> new sfValidatorChoice(array('choices' => $this->asCommonDeasesStatus, 'required' => false)),
					'request_probe_reopen'              => new sfValidatorChoice(array('choices' => $this->asCommonDeasesStatus, 'required' => false)),
					'request_triple_depth_reopen'       => new sfValidatorChoice(array('choices' => $this->asCommonDeasesStatus, 'required' => false)),
					'checked_monumental'                => new sfValidatorChoice(array('choices' => $this->asCommonDeasesStatus, 'required' => false)),
					'contacted_stonemason'              => new sfValidatorChoice(array('choices' => $this->asCommonDeasesStatus, 'required' => false)),
					'checked_accessories'               => new sfValidatorChoice(array('choices' => $this->asCommonDeasesStatus, 'required' => false)),
					'balloons_na'                       => new sfValidatorChoice(array('choices' => $this->asCommonDeasesStatus, 'required' => false)),
					'burning_drum'                      => new sfValidatorChoice(array('choices' => $this->asCommonDeasesStatus, 'required' => false)),
					'canopy'                            => new sfValidatorChoice(array('choices' => $this->asCommonDeasesStatus, 'required' => false)),
					'ceremonial_sand_bucket'            => new sfValidatorChoice(array('choices' => $this->asCommonDeasesStatus, 'required' => false)),
					'fireworks'                         => new sfValidatorChoice(array('choices' => $this->asCommonDeasesStatus, 'required' => false)),
					'lowering_device'                   => new sfValidatorChoice(array('choices' => $this->asCommonDeasesStatus, 'required' => false)),
					'other'                             => new sfValidatorString(array('required' => false)),
					'checked_returned_signed'           => new sfValidatorChoice(array('choices' => $this->asCommonDeasesStatus, 'required' => false)),
					'check_coffin_sizes_surcharge'      => new sfValidatorChoice(array('choices' => $this->asCommonDeasesStatus, 'required' => false)),
					'surcharge_applied'      			=> new sfValidatorChoice(array('choices' => $this->asCommonDeasesStatus, 'required' => false)),
					'compare_burial_booking'            => new sfValidatorChoice(array('choices' => $this->asCommonDeasesStatus, 'required' => false)),
					'for_between_burials'               => new sfValidatorChoice(array('choices' => $this->asCommonDeasesStatus, 'required' => false)),
					'double_check_yellow_date'			=> new sfValidatorChoice(array('choices' => $this->asCommonDeasesStatus, 'required' => false)),
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
