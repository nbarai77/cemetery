<?php

/**
 * IntermentBookingDocs form.
 *
 * @package    cemetery
 * @subpackage form
 * @author     Prakash Panchal
 * @version    SVN: $Id: IntermentBookingDocsForm.class.php,v 1.1.1.1 2012/03/24 11:56:37 nitin Exp $
 */
sfProjectConfiguration::getActive()->loadHelpers(array('jQuery', 'Url'));
class IntermentBookingDocsForm extends BaseIntermentBookingDocsForm
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
        BaseIntermentBookingDocsForm::setWidgets(
            array(
                    'file_name' 			=> new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 1)),
					'file_path' 			=> new sfWidgetFormInputFile(array(),array('tabindex'=> 2)),
					'file_description' 		=> new sfWidgetFormTextarea(array(), array('tabindex'=> 3)),
					'expiry_date'			=> new sfWidgetFormDateJQueryUI(
												array("change_month"	=> true, 
													  "change_year" 	=> true,
													  "dateFormat"		=> "dd-mm-yy",
													  "showSecond" 		=> false, 
													  'show_button_panel' => false),
												array('tabindex'=>4,'readonly'=>false))
	            )
        );
		if(!$this->isNew())
		{
			if($this->getObject()->getExpiryDate() != '')
			{
				list($snYear,$snMonth,$snDay) = explode('-',$this->getObject()->getExpiryDate());
				$ssExpiryDate = $snDay.'-'.$snMonth.'-'.$snYear;
				$this->setDefault('expiry_date', $ssExpiryDate);
			}
		}
        $this->widgetSchema->setNameFormat('interment_booking_doc[%s]'); 
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
        BaseIntermentBookingDocsForm::setValidators(
            array(   
                'file_name'				=> new sfValidatorString(
												array('required' => true, 'trim' => true),
												array('required' => $amValidators['file_name']['required'])
		                                       ),				
				'file_path'      		=> new sfValidatorFile(
												array('required' => false, 'trim' => true)
                                            ),
				'file_description'      => new sfValidatorFile(
												array('required' => false, 'trim' => true)
                                            ),
				'expiry_date'			=> new sfValidatorString( 
                       							array('required' => false, 'trim' => true)
											)
            )
        );
		if($this->isNew())
        {
          $this->validatorSchema['file_path'] = new sfValidatorFile(
												array('required'=> true, 'trim' => true, 
													  "mime_types"	=> array('application/pdf',
																			'application/msword',
																			'application/excel',
																			'text/plain', 
																			'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
																			'image/bmp','image/gif','image/jpeg','image/pjpeg','image/png','image/x-bmp','image/x-png'),
													 ),
												array(
													  "required"	=> $amValidators['file_path']['required'],
													  "mime_types"	=> $amValidators['file_path']['mime_types']
													 ));
        }
    }
}
