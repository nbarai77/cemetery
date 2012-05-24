<?php

/**
 * IntermentBookingTwo form.
 *
 * @package    cemetery
 * @subpackage form
 * @author     Prakash Panchal
 * @version    SVN: $Id: IntermentBookingTwoForm.class.php,v 1.1.1.1 2012/03/24 11:56:23 nitin Exp $
 */
sfProjectConfiguration::getActive()->loadHelpers(array('jQuery', 'Url'));
class IntermentBookingTwoForm extends BaseIntermentBookingTwoForm
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
		 // Disable the secret key
        $this->disableLocalCSRFProtection();
			
		$this->asCommonStatus = array('NO'=>'No','YES'=>'Yes');
		$this->asDeceasedGender = array('Male'=>'Male','Female'=>'Female');
		
		$this->amPostData = sfContext::getInstance()->getRequest()->getParameter('servicetwo');
		$this->ssInvalidDateMessage = '';
		
		$this->amAllChapelTypes = $this->amAllRoomTypes = $this->amChapleAssociated = $this->amRoomAssociated = array();		
		if(!sfContext::getInstance()->getUser()->isSuperAdmin())
		{
			// GET ALL CHAPEL TYPES		
			$this->amAllChapelTypes = Doctrine::getTable('CemChapel')->getCemChapelTypes();
			// GET ALL ROOM TYPES
			$this->amAllRoomTypes = Doctrine::getTable('CemRoom')->getCemRoomTypes();
			
			// GET OLD SELECTED CHAPLE AND ROOM TYPE TO EDIT THE RECORDS
			if(!$this->isNew())
			{
				$amCemChapelIds = ($this->getObject()->getCemChapelIds() != '') ? explode(',',$this->getObject()->getCemChapelIds()) : '';
				$amCemRoomIds = ($this->getObject()->getCemRoomIds() != '') ? explode(',',$this->getObject()->getCemRoomIds()) : '';

				$this->amChapleAssociated = Doctrine::getTable('CemChapel')->getCemChapelTypes($amCemChapelIds);
				$this->amRoomAssociated = Doctrine::getTable('CemRoom')->getCemRoomTypes($amCemRoomIds);
			}
		}
		
		$this->setWidgets(array(
		  		'coffin_type_id'                 => new sfWidgetFormDoctrineChoice(array('model' => 'CoffinType', 'add_empty' => __('Select Type')), array('tabindex'=>24)),
				'unit_type_id'                   => new sfWidgetFormDoctrineChoice(array('model' => 'UnitType', 'add_empty' => __('Select Unit Type')), array('tabindex'=>25)),
				'coffin_length'                  => new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 26)),
				'coffin_width'                   => new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 27)),
				'coffin_height'                  => new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 28)),
				'coffin_surcharge'               => new MyWidgetFormInputCheckbox(array(), array('tabindex' => 29,'value' => 1)),
				'death_certificate'              => new MyWidgetFormInputCheckbox(array(), array('tabindex' => 30,'value' => 1)),
				'disease_id'                     => new sfWidgetFormDoctrineChoice(array('model' => 'Disease', 'add_empty' => __('Select Infectious Disease')), array('tabindex'=>31)),
				'own_clergy'                     => new MyWidgetFormInputCheckbox(array(), array('tabindex' => 32,'value' => 1)),
				'clergy_name'                    => new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 33)),
				'chapel'                         => new sfWidgetFormChoice(array('expanded' => true, 'multiple' => false,'choices' => $this->asCommonStatus ), 
																  array('tabindex'=> 34)),
				'chapel_time_from'               => new sfWidgetFormDateJQueryUI(
														array("change_month"	=> true, 
															  "change_year" 	=> true,
															  "dateFormat"		=> "dd-mm-yy",
															  "showSecond" 		=> true, 
															  "timeFormat" 		=> 'hh:mm:ss',
															  'show_button_panel' => true),
														array('tabindex'=>36,'readonly'=>false)),
				'chapel_time_to'                 => new sfWidgetFormDateJQueryUI(
														array("change_month"	=> true, 
															  "change_year" 	=> true,
															  "dateFormat"		=> "dd-mm-yy",
															  "showSecond" 		=> true, 
															  "timeFormat" 		=> 'hh:mm:ss',
															  'show_button_panel' => true),
														array('tabindex'=>37,'readonly'=>false)),
				'room'                       => new sfWidgetFormChoice(array('expanded' => true, 'multiple' => false,'choices' => $this->asCommonStatus ), 
																  array('tabindex'=> 38)),
				'room_time_from'                  => new sfWidgetFormDateJQueryUI(
														array("change_month"	=> true, 
															  "change_year" 	=> true,
															  "dateFormat"		=> "dd-mm-yy",
															  "showSecond" 		=> true, 
															  "timeFormat" 		=> 'hh:mm:ss',
															  'show_button_panel' => true),
														array('tabindex'=>40,'readonly'=>false)),
				'room_time_to'                    => new sfWidgetFormDateJQueryUI(
														array("change_month"	=> true, 
															  "change_year" 	=> true,
															  "dateFormat"		=> "dd-mm-yy",
															  "showSecond" 		=> true, 
															  "timeFormat" 		=> 'hh:mm:ss',
															  'show_button_panel' => true),
														array('tabindex'=>41,'readonly'=>false)),
				'burning_drum'                   => new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 42)),
				'fireworks'                      => new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 43)),
				
				'ceremonial_sand'                => new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 44)),
				'canopy'                 		 => new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 45)),
				'lowering_device'                => new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 46)),
				'balloons'                 		 => new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 47)),
				'chapel_multimedia'              => new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 48)),
				'cost'                 			 => new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 49)),
				
				'receipt_number'                 => new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 50)),
				'special_instruction'            => new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 51)),
				'notes'                			 => new sfWidgetFormTextarea(array(), array('tabindex'=> 52)),
		));
		
		if(!sfContext::getInstance()->getUser()->isSuperAdmin())
		{
			$this->widgetSchema['chapel_grouplist']	= new sfWidgetFormChoice(
															array('multiple' => true,'choices' => $this->amAllChapelTypes, 'default' => array_keys($this->amChapleAssociated) ),
															array('tabindex'=> 35)
													);
			
			$this->widgetSchema['room_grouplist']	= new sfWidgetFormChoice(
															array('multiple' => true, 'choices' => $this->amAllRoomTypes, 'default' => array_keys($this->amRoomAssociated) ),
															array('tabindex'=> 39)
														);
		}												
		if($this->isNew())
		{
			$this->setDefault('coffin_surcharge',0);
			$this->setDefault('own_clergy',0);
			$this->setDefault('death_certificate',0);
		}
		else
		{
			$this->setDefault('coffin_surcharge', $this->getObject()->getCoffinSurcharge());
			$this->setDefault('own_clergy', $this->getObject()->getOwnClergy());
			$this->setDefault('death_certificate', $this->getObject()->getDeathCertificate());
			
			$this->setDefault('chapel_grouplist', array_keys($this->amChapleAssociated));
			$this->setDefault('room_grouplist', array_keys($this->amRoomAssociated));
		}
		
				// set labels
		$this->widgetSchema->setLabels(array(
			'disease_id'                     => __('Infectious Disease'),
			'unit_type_id'                   => __('Select Unit Type'),
			'coffin_type_id'                 => __('Select Type'),
			'death_certificate'              => __('Death Certificate'),
			'own_clergy'                     => __('Own Clergy'),
			'clergy_name'                    => __('Clergy Name'),
			'coffin_surcharge'               => __('Coffin Surcharge'),
			'burning_drum'                   => __('Burning Drum'),
			'fireworks'                      => __('Fireworks'),
			'coffin_length'                  => __('Length'),
			'coffin_width'                   => __('Width'),
			'coffin_height'                  => __('Height'),
			'chapel'                         => __('Chapel'),
			'chapel_time_from'               => __('From'),
			'chapel_time_to'                 => __('To'),
			'room'                           => __('Room'),
			'room_time_from'                 => __('From'),
			'room_time_to'                   => __('To'),
			'special_instruction'            => __('Special Instruction'),
			'invoice_number'                 => __('Invoice Number'),
			'receipt_number'                 => __('Receipt Number')
		));
		
		$this->setValidators(array(
			'coffin_type_id'		=> new sfValidatorDoctrineChoice(array('model'=>'CoffinType','multiple'=>false,'required'=>false)),
			'unit_type_id'			=> new sfValidatorDoctrineChoice(array('model'=>'UnitType','multiple'=>false,'required'=>false)),
			'disease_id'			=> new sfValidatorDoctrineChoice(array('model'=>'Disease','multiple'=>false,'required'=>false)),
			'coffin_length'			=> new sfValidatorString( 
											array('required' => false, 'trim' => true)),
			'coffin_width'			=> new sfValidatorString( 
											array('required' => false, 'trim' => true)),
			'coffin_height'			=> new sfValidatorString( 
											array('required' => false, 'trim' => true)),
			'coffin_surcharge'		=> new sfValidatorString( 
											array('required' => false, 'trim' => true)),
			'death_certificate'		=> new sfValidatorString( 
											array('required' => false, 'trim' => true)),
			'own_clergy'			=> new sfValidatorString( 
											array('required' => false, 'trim' => true)),
			'clergy_name'			=> new sfValidatorString( 
											array('required' => false, 'trim' => true)),
			'chapel'				=> new sfValidatorString( 
											array('required' => false, 'trim' => true)),
			'chapel_grouplist' 		=> new sfValidatorChoice(
											array('multiple' => true, 'choices' => array_keys($this->amAllChapelTypes), 'required' => false)
										),
			'chapel_time_from'		=> new sfValidatorString(
											array('required' => false, 'trim' => true)
										),
			'chapel_time_to'		=> new sfValidatorString(
											array('required' => false, 'trim' => true)
										),
			'room'					=> new sfValidatorString( 
											array('required' => false, 'trim' => true)),
			'room_grouplist' 		=> new sfValidatorChoice(
											array('multiple' => true, 'choices' => array_keys($this->amAllRoomTypes), 'required' => false)
										),
			'room_time_from'		=> new sfValidatorString(
											array('required' => false, 'trim' => true)
										),
			'room_time_to'			=> new sfValidatorString(
											array('required' => false, 'trim' => true)
										),
			'cost'					=> new sfValidatorString( 
											array('required' => false, 'trim' => true)),
			'burning_drum'			=> new sfValidatorString( 
											array('required' => false, 'trim' => true)),
			'fireworks'				=> new sfValidatorString( 
											array('required' => false, 'trim' => true)),
			'receipt_number'		=> new sfValidatorString( 
											array('required' => false, 'trim' => true)),
			'invoice_number'		=> new sfValidatorString( 
											array('required' => false, 'trim' => true)),													
			'control_number'		=> new sfValidatorString( 
											array('required' => false, 'trim' => true)),
			'notes'					=> new sfValidatorString( 
											array('required' => false, 'trim' => true)),
			'special_instruction'	=> new sfValidatorString( 
											array('required' => false, 'trim' => true)),			
			'ceremonial_sand'		=> new sfValidatorString( 
											array('required' => false, 'trim' => true)),
			'canopy'				=> new sfValidatorString( 
											array('required' => false, 'trim' => true)),
			'lowering_device'		=> new sfValidatorString( 
											array('required' => false, 'trim' => true)),
			'balloons'				=> new sfValidatorString( 
											array('required' => false, 'trim' => true)),
			'chapel_multimedia'		=> new sfValidatorString( 
											array('required' => false, 'trim' => true))
	    ));
		
		if(!sfContext::getInstance()->getUser()->isSuperAdmin())
		{
			$this->validatorSchema['chapel_grouplist'] =  new sfValidatorChoice(
																array('multiple' => true, 'choices' => array_keys($this->amAllChapelTypes), 'required' => false)
															);
															
			$this->validatorSchema['room_grouplist'] = new sfValidatorChoice(
															array('multiple' => true, 'choices' => array_keys($this->amAllRoomTypes), 'required' => false)
														);
		}														
		if($this->isNew())
		{
			$this->validatorSchema['chapel_time_from'] = new sfValidatorAnd(array(new sfValidatorDate(), new sfValidatorCallback(
																		array('callback'=> array($this,'checkValidDate'),
																			  'arguments' => array('ssCurrentDate' => $this->amPostData['chapel_time_from'])),
																		array('invalid'=> __('Please select valid date')))
																		),															
																		array('required' => false, 'trim' => true)
																);
			
			$this->validatorSchema['chapel_time_to'] = new sfValidatorAnd(array(new sfValidatorDate(), new sfValidatorCallback(
																		array('callback'=> array($this,'checkValidDate'),
																			  'arguments' => array('ssCurrentDate' => $this->amPostData['chapel_time_to'])),
																		array('invalid'=> __('Please select valid date')))
																		),															
																		array('required' => false, 'trim' => true)
																);
			
			$this->validatorSchema['room_time_from'] = new sfValidatorAnd(array(new sfValidatorDate(), new sfValidatorCallback(
																		array('callback'=> array($this,'checkValidDate'),
																			  'arguments' => array('ssCurrentDate' => $this->amPostData['room_time_from'])),
																		array('invalid'=> __('Please select valid date')))
																		),															
																		array('required' => false, 'trim' => true)
																);
			
			$this->validatorSchema['room_time_to'] = new sfValidatorAnd(array(new sfValidatorDate(), new sfValidatorCallback(
																		array('callback'=> array($this,'checkValidDate'),
																			  'arguments' => array('ssCurrentDate' => $this->amPostData['room_time_to'])),
																		array('invalid'=> __('Please select valid date')))
																		),															
																		array('required' => false, 'trim' => true)
																);
		}
	}
	/**
     * Fuction checkValidDate to check date is greater than or equal to current date
     * @param $validator 	= Call Validator
     * @param $snCurrentDate 	= date
	 
	 * return  $snCurrentDate valid date
     */
	public function checkValidDate($validator, $snCurrentDate, $asArguments) 
	{
		if(date("Y-m-d",strtotime($snCurrentDate)) < date('Y-m-d'))
			throw new sfValidatorError($validator, $this->ssInvalidDateMessage);
		else
			return date("Y-m-d H:i:s",strtotime($asArguments['ssCurrentDate']));
	}
}
