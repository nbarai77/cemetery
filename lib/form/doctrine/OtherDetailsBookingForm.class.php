<?php

/**
 * OtherDetailsBooking form.
 *
 * @package    cemetery
 * @subpackage form
 * @author     Prakash Panchal
 * @version    SVN: $Id: OtherDetailsBookingForm.class.php,v 1.1.1.1 2012/03/24 11:56:34 nitin Exp $
 */
sfProjectConfiguration::getActive()->loadHelpers(array('jQuery', 'Url'));
class OtherDetailsBookingForm extends BaseIntermentBookingTwoForm
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
        BaseIntermentBookingTwoForm::setWidgets(
            array(
				'coffin_type_id'                 => new sfWidgetFormDoctrineChoice(array('model' => 'CoffinType', 'add_empty' => $asWidgets['coffin_type_id']), array('tabindex'=>1)),
				'unit_type_id'                   => new sfWidgetFormDoctrineChoice(array('model' => 'UnitType', 'add_empty' => $asWidgets['unit_type_id']), array('tabindex'=>2)),
				'coffin_length'                  => new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 3)),
				'coffin_width'                   => new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 4)),
				'coffin_height'                  => new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 5)),
				'coffin_surcharge'               => new MyWidgetFormInputCheckbox(array(), array('tabindex' => 6,'value' => 1)),
				'death_certificate'              => new MyWidgetFormInputCheckbox(array(), array('tabindex' => 7,'value' => 1)),
				'disease_id'                     => new sfWidgetFormDoctrineChoice(array('model' => 'Disease', 'add_empty' => $asWidgets['disease_id']), array('tabindex'=>8)),
				'own_clergy'                     => new MyWidgetFormInputCheckbox(array(), array('tabindex' => 9,'value' => 1)),
				'clergy_name'                    => new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 10)),
				'chapel'                         => new sfWidgetFormChoice(array('expanded' => true, 'multiple' => false,'choices' => $this->asCommonStatus ), 
																  array('tabindex'=> 11)),
				'chapel_time_from'               => new sfWidgetFormDateJQueryUI(
														array("change_month"	=> true, 
															  "change_year" 	=> true,
															  "dateFormat"		=> "dd-mm-yy",
															  "showSecond" 		=> true, 
															  "timeFormat" 		=> 'hh:mm:ss',
															  'show_button_panel' => true),
														array('tabindex'=>12,'readonly'=>false)),
				'chapel_time_to'                 => new sfWidgetFormDateJQueryUI(
														array("change_month"	=> true, 
															  "change_year" 	=> true,
															  "dateFormat"		=> "dd-mm-yy",
															  "showSecond" 		=> true, 
															  "timeFormat" 		=> 'hh:mm:ss',
															  'show_button_panel' => true),
														array('tabindex'=>13,'readonly'=>false)),
				'room'                       => new sfWidgetFormChoice(array('expanded' => true, 'multiple' => false,'choices' => $this->asCommonStatus ), 
																  array('tabindex'=> 14)),
				'room_time_from'                  => new sfWidgetFormDateJQueryUI(
														array("change_month"	=> true, 
															  "change_year" 	=> true,
															  "dateFormat"		=> "dd-mm-yy",
															  "showSecond" 		=> true, 
															  "timeFormat" 		=> 'hh:mm:ss',
															  'show_button_panel' => true),
														array('tabindex'=>15,'readonly'=>false)),
				'room_time_to'                    => new sfWidgetFormDateJQueryUI(
														array("change_month"	=> true, 
															  "change_year" 	=> true,
															  "dateFormat"		=> "dd-mm-yy",
															  "showSecond" 		=> true, 
															  "timeFormat" 		=> 'hh:mm:ss',
															  'show_button_panel' => true),
														array('tabindex'=>16,'readonly'=>false)),
				'burning_drum'                   => new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 17)),
				'fireworks'                      => new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 18)),
				
				'ceremonial_sand'                => new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 19)),
				'canopy'                 		 => new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 20)),
				'lowering_device'                => new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 21)),
				'balloons'                 		 => new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 21)),
				'chapel_multimedia'              => new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 23)),
				'cost'                 			 => new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 24)),
				
				'receipt_number'                 => new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 25)),
				'special_instruction'            => new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 26)),
				'notes'                			 => new sfWidgetFormTextarea(array(), array('tabindex'=> 27)),
           	));
		if(!sfContext::getInstance()->getUser()->isSuperAdmin())
		{
			$this->widgetSchema['chapel_grouplist']	= new sfWidgetFormChoice(
															array('multiple' => true,'choices' => $this->amAllChapelTypes, 'default' => array_keys($this->amChapleAssociated) ),
															array('tabindex'=> 17)
													);
			
			$this->widgetSchema['room_grouplist']	= new sfWidgetFormChoice(
															array('multiple' => true, 'choices' => $this->amAllRoomTypes, 'default' => array_keys($this->amRoomAssociated) ),
															array('tabindex'=> 22)
														);
		}												
		if(!$this->isNew())
		{
			$ssChapelFromTime = ($this->getObject()->getChapelTimeFrom() != '' && $this->getObject()->getChapelTimeFrom() != '00-00-0000 00:00:00') ? date('d-m-Y H:i:s',strtotime( $this->getObject()->getChapelTimeFrom() )) : '00-00-0000 00:00:00';
			$ssChapelToTime = ($this->getObject()->getChapelTimeTo() != '' && $this->getObject()->getChapelTimeTo() != '00-00-0000 00:00:00') ? date('d-m-Y H:i:s',strtotime( $this->getObject()->getChapelTimeTo() )) : '00-00-0000 00:00:00';
			$ssRoomFromTime = ($this->getObject()->getRoomTimeFrom() != '' && $this->getObject()->getRoomTimeFrom() != '00-00-0000 00:00:00') ? date('d-m-Y H:i:s',strtotime( $this->getObject()->getRoomTimeFrom() )) : '00-00-0000 00:00:00';
			$ssRoomToTime = ($this->getObject()->getRoomTimeTo() != '' && $this->getObject()->getRoomTimeTo() != '00-00-0000 00:00:00') ? date('d-m-Y H:i:s',strtotime( $this->getObject()->getRoomTimeTo() )): '00-00-0000 00:00:00';
			
			$this->setDefault('chapel_time_from', $ssChapelFromTime);
			$this->setDefault('chapel_time_to', $ssChapelToTime);
			$this->setDefault('room_time_from', $ssRoomFromTime);
			$this->setDefault('room_time_to', $ssRoomToTime);
		}
		$this->setDefault('coffin_surcharge',0);
		$this->setDefault('own_clergy',0);
		$this->setDefault('death_certificate',0);

        $this->widgetSchema->setNameFormat('servicetwo[%s]');
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
		$this->ssInvalidDateMessage = $amValidators['booking_date_past']['invalid'];
        BaseIntermentBookingTwoForm::setValidators(
	    	array(
                'coffin_type_id'	=> new sfValidatorDoctrineChoice(array('model'=>'CoffinType','multiple'=>false,'required'=>false)),
				'unit_type_id'	=> new sfValidatorDoctrineChoice(array('model'=>'UnitType','multiple'=>false,'required'=>false)),
				'disease_id'	=> new sfValidatorDoctrineChoice(array('model'=>'Disease','multiple'=>false,'required'=>false)),
				'coffin_length'	=> new sfValidatorString( 
                       								array('required' => false, 'trim' => true)),
				'coffin_width'	=> new sfValidatorString( 
                       								array('required' => false, 'trim' => true)),
				'coffin_height'	=> new sfValidatorString( 
                       								array('required' => false, 'trim' => true)),
				'coffin_surcharge'	=> new sfValidatorString( 
                       								array('required' => false, 'trim' => true)),
				'death_certificate'	=> new sfValidatorString( 
                       								array('required' => false, 'trim' => true)),
				'own_clergy'	=> new sfValidatorString( 
                       								array('required' => false, 'trim' => true)),
				'clergy_name'	=> new sfValidatorString( 
                       								array('required' => false, 'trim' => true)),
				'chapel'	=> new sfValidatorString( 
                       								array('required' => false, 'trim' => true)),
				'chapel_grouplist' 			=> new sfValidatorChoice(
													array('multiple' => true, 'choices' => array_keys($this->amAllChapelTypes), 'required' => false)
												),
				'chapel_time_from'	=> new sfValidatorString(
                                            		array('required' => false, 'trim' => true)
                                        		),
				'chapel_time_to'	=> new sfValidatorString(
                                            		array('required' => false, 'trim' => true)
                                        		),
				'room'	=> new sfValidatorString( 
                       								array('required' => false, 'trim' => true)),
				'room_grouplist' 			=> new sfValidatorChoice(
													array('multiple' => true, 'choices' => array_keys($this->amAllRoomTypes), 'required' => false)
												),
				'room_time_from'	=> new sfValidatorString(
                                            		array('required' => false, 'trim' => true)
                                        		),
				'room_time_to'	=> new sfValidatorString(
                                            		array('required' => false, 'trim' => true)
                                        		),
				'cost'	=> new sfValidatorString( 
                       								array('required' => false, 'trim' => true)),
				'burning_drum'	=> new sfValidatorString( 
                       								array('required' => false, 'trim' => true)),
				'fireworks'	=> new sfValidatorString( 
                       								array('required' => false, 'trim' => true)),
				'receipt_number'	=> new sfValidatorString( 
                       								array('required' => false, 'trim' => true)),
				'invoice_number'	=> new sfValidatorString( 
                       								array('required' => false, 'trim' => true)),													
				'control_number'	=> new sfValidatorString( 
                       								array('required' => false, 'trim' => true)),
				'notes'	=> new sfValidatorString( 
                       								array('required' => false, 'trim' => true)),
				'special_instruction'	=> new sfValidatorString( 
                       								array('required' => false, 'trim' => true)),

				'ceremonial_sand'	=> new sfValidatorString( 
                       								array('required' => false, 'trim' => true)),
				'canopy'	=> new sfValidatorString( 
                       								array('required' => false, 'trim' => true)),
				'lowering_device'	=> new sfValidatorString( 
                       								array('required' => false, 'trim' => true)),
				'balloons'	=> new sfValidatorString( 
                       								array('required' => false, 'trim' => true)),
				'chapel_multimedia'	=> new sfValidatorString( 
                       								array('required' => false, 'trim' => true)),
				)
        );
		
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
																		array('invalid'=> $amValidators['booking_invalid_date']['invalid']))
																		),															
																		array('required' => false, 'trim' => true)
																);
			
			$this->validatorSchema['chapel_time_to'] = new sfValidatorAnd(array(new sfValidatorDate(), new sfValidatorCallback(
																		array('callback'=> array($this,'checkValidDate'),
																			  'arguments' => array('ssCurrentDate' => $this->amPostData['chapel_time_to'])),
																		array('invalid'=> $amValidators['booking_invalid_date']['invalid']))
																		),															
																		array('required' => false, 'trim' => true)
																);
			
			$this->validatorSchema['room_time_from'] = new sfValidatorAnd(array(new sfValidatorDate(), new sfValidatorCallback(
																		array('callback'=> array($this,'checkValidDate'),
																			  'arguments' => array('ssCurrentDate' => $this->amPostData['room_time_from'])),
																		array('invalid'=> $amValidators['booking_invalid_date']['invalid']))
																		),															
																		array('required' => false, 'trim' => true)
																);
			
			$this->validatorSchema['room_time_to'] = new sfValidatorAnd(array(new sfValidatorDate(), new sfValidatorCallback(
																		array('callback'=> array($this,'checkValidDate'),
																			  'arguments' => array('ssCurrentDate' => $this->amPostData['room_time_to'])),
																		array('invalid'=> $amValidators['booking_invalid_date']['invalid']))
																		),															
																		array('required' => false, 'trim' => true)
																);
		}
		
    }
	// over ride parent object named updateObject for set manual values 
	public function updateObject($values = null)
	{
		$this->values['interment_booking_id']  		= sfContext::getInstance()->getRequest()->getParameter('id');

		if(sfContext::getInstance()->getUser()->isSuperAdmin())
		{
			$amPostChapelTypes 	= sfContext::getInstance()->getRequest()->getParameter('chapel_grouplist');
			$amPostRoomTypes 	= sfContext::getInstance()->getRequest()->getParameter('room_grouplist');

			// SET CHAPEL TYPE IDS.		
			if($this->amPostData['chapel'] == 'YES' && count($amPostChapelTypes) > 0)
				$this->values['cem_chapel_ids'] = implode(',',$amPostChapelTypes);

			// SET ROOM TYPE IDS.
			if($this->amPostData['room'] == 'YES' && count($amPostRoomTypes) > 0 )
				$this->values['cem_room_ids'] = implode(',',$amPostRoomTypes);
		}
		else
		{
			if($this->amPostData['chapel'] == 'YES' && isset($this->amPostData['chapel_grouplist']) )
				$this->values['cem_chapel_ids'] = implode(',',$this->amPostData['chapel_grouplist']);
	
			if($this->amPostData['room'] == 'YES' && isset($this->amPostData['room_grouplist']) )
				$this->values['cem_room_ids'] = implode(',',$this->amPostData['room_grouplist']);
		}
		parent::updateObject($this->values);
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
