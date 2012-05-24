<?php

/**
 * CemCemeteryDocs form.
 *
 * @package    cemetery
 * @subpackage form
 * @author     Prakash Panchal
 * @version    SVN: $Id: CemCemeteryDocsForm.class.php,v 1.1.1.1 2012/03/24 11:56:24 nitin Exp $
 */
sfProjectConfiguration::getActive()->loadHelpers(array('jQuery', 'Url'));
class CemCemeteryDocsForm extends BaseCemCemeteryDocsForm
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
        BaseCemCemeteryDocsForm::setWidgets(
            array(
                    'doc_name' 			=> new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 1)),
                    'doc_description' 	=> new sfWidgetFormTextarea(array(), array('tabindex'=> 2)),
					'doc_path' 			=> new sfWidgetFormInputFile(array(),array('tabindex'=> 2))
	            )
        );
		
		$snCemeteryId = sfContext::getInstance()->getUser()->getAttribute('cemeteryid');
		$this->widgetSchema['cem_cemetery_id'] = new sfWidgetFormInputHidden(array(), array('value' => $snCemeteryId,'readonly' => 'true'));
		$this->setDefault('cem_cemetery_id',$snCemeteryId);
        
        $this->widgetSchema->setNameFormat('cemetery_docs[%s]'); 
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
        BaseCemCemeteryDocsForm::setValidators(
            array( 
            	'cem_cemetery_id'		=> new sfValidatorString(
                                            		array('required' => false, 'trim' => true)
                                        		),  
                'doc_name'				=> new sfValidatorString(
												array('required' => true, 'trim' => true),
												array('required' => $amValidators['doc_name']['required'])
		                                       ),
				'doc_description'		=> new sfValidatorString(
                                            		array('required' => false, 'trim' => true)
                                        		),
                'doc_path'      		 => new sfValidatorFile(
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
