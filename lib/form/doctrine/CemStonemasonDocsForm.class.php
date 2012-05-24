<?php

/**
 * CemStonemasonDocs form.
 *
 * @package    cemetery
 * @subpackage form
 * @author     Prakash Panchal
 * @version    SVN: $Id: CemStonemasonDocsForm.class.php,v 1.1.1.1 2012/03/24 11:56:30 nitin Exp $
 */
class CemStonemasonDocsForm extends BaseCemStonemasonDocsForm
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
		unset($this['id'],$this['cem_cemetery_id'],$this['user_id']);
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
        BaseCemStonemasonDocsForm::setWidgets(
            array(
                    'doc_name' 			=> new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 1)),
                    'doc_description' 	=> new sfWidgetFormTextarea(array(), array('tabindex'=> 2)),
					'doc_path' 			=> new sfWidgetFormInputFile(array(),array('tabindex'=> 3)),
					'expiry_date'		=> new sfWidgetFormDateJQueryUI(
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
        $this->widgetSchema->setNameFormat('stonemason_docs[%s]'); 
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
        BaseCemStonemasonDocsForm::setValidators(
            array( 

                'doc_name'				=> new sfValidatorString(
												array('required' => true, 'trim' => true),
												array('required' => $amValidators['doc_name']['required'])
		                                    ),
				'doc_description'		=> new sfValidatorString(
												array('required' => false, 'trim' => true)
                                        	),
                'doc_path'      		=> new sfValidatorFile(
												array('required' => false, 'trim' => true)
                                            ),
				'expiry_date'			=> new sfValidatorString( 
                       							array('required' => false, 'trim' => true)
											)
            )
        );
        if($this->isNew())
        {
          $this->validatorSchema['doc_path'] = new sfValidatorFile(
                                                array('required'=> true, 'trim' => true),
                                                array("required"    => $amValidators['doc_path']['required'])
                                            );
        }
    }
}
