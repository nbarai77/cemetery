<?php

/**
 * CemTaskNotes form.
 *
 * @package    cemetery
 * @subpackage form
 * @author     Prakash Panchal
 * @version    SVN: $Id: CemTaskNotesForm.class.php,v 1.1.1.1 2012/03/24 11:56:33 nitin Exp $
 */
class CemTaskNotesForm extends BaseCemTaskNotesForm
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
		$this->snUserId = sfContext::getInstance()->getUser()->getAttribute('userid');
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
		$this->asPostData = sfContext::getInstance()->getRequest()->getParameter('tasknotes');
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
        BaseCemTaskNotesForm::setWidgets(
            array(
					'user_id' 				=>  new sfWidgetFormInputHidden(array(), array('value' => $this->snUserId,'readonly' => 'true')),
                    'task_title'    	=> new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 1)),
                    'task_description' 		=> new sfWidgetFormTextarea(array(), array('tabindex'=> 2)),
					'entry_date'			=> new sfWidgetFormDateJQueryUI(
														array("change_month"	=> true, 
															  "change_year" 	=> true,
															  "dateFormat"		=> "dd-mm-yy",
															  "showSecond" 		=> false, 
															  'show_button_panel' => true),
														array('tabindex'=>3,'readonly'=>false)),
					'due_date'			=> new sfWidgetFormDateJQueryUI(
														array("change_month"	=> true, 
															  "change_year" 	=> true,
															  "dateFormat"		=> "dd-mm-yy",
															  "showSecond" 		=> false, 
															  'show_button_panel' => true),
														array('tabindex'=>4,'readonly'=>false)),

														
            	));
           	
		$this->setDefault('user_id',$this->snUserId);
		
		if($this->isNew())
		{
			$this->setDefault('entry_date', sfConfig::get('app_default_date_formate'));
            $this->setDefault('due_date', sfConfig::get('app_default_date_formate'));
		}
        else
        {
            if($this->getObject()->getEntryDate() != '' && $this->getObject()->getEntryDate() != '0000-00-00')
                $this->setDefault('entry_date', date('d-m-Y',strtotime($this->getObject()->getEntryDate())));
            else
                $this->setDefault('entry_date', sfConfig::get('app_default_date_formate'));
            if($this->getObject()->getDueDate() != '' && $this->getObject()->getDueDate() != '0000-00-00')
                $this->setDefault('due_date', date('d-m-Y',strtotime($this->getObject()->getDueDate())));
            else
                $this->setDefault('due_date', sfConfig::get('app_default_date_formate'));
        }
        $this->widgetSchema->setNameFormat('tasknotes[%s]'); 
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
		$this->ssInvalidDateMessage = $amValidators['due_date']['invalid'];
        BaseCemTaskNotesForm::setValidators(
	    	array(
				'user_id' 				=> new sfValidatorString(
                                            		array('required' => false, 'trim' => true)
                                        		),
				'task_title'    		=> new sfValidatorString(
                                            		array('required' => true, 'trim' => true),
													array('required'=> $amValidators['task_title']['required'])
                                        		),
				'task_description' 		=> new sfValidatorString(
                                            		array('required' => true, 'trim' => true),
													array('required'=> $amValidators['task_description']['required'])
                                        		),
				'entry_date'			=> new sfValidatorString(
                                            		array('required' => false, 'trim' => true)
                                        		)
			)
        );
		$this->validatorSchema['due_date'] = new sfValidatorAnd(array(new sfValidatorDate(), new sfValidatorCallback(
															array('callback'=> array($this,'checkValidDate')),
															array('invalid'=> $amValidators['due_date']['invalid']))
															),															
															array('required' => false, 'trim' => true)
														);
    }
	/**
     * Fuction checkValidDate to check date is greater than or equal current date
     * @param $validator 	= Call Validator
     * @param $ssDueDate 	= date
	 
	 * return  $ssDueDate valid date
     */
	public function checkValidDate($validator, $ssDueDate) 
	{
		if(strtotime($ssDueDate) < strtotime($this->asPostData['entry_date']) )
			throw new sfValidatorError($validator, $this->ssInvalidDateMessage);
		else 
			return $ssDueDate;
	}
}