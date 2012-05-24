<?php

/**
 * Catalog form.
 *
 * @package    cemetery
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class CatalogForm extends BaseCatalogForm
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
        BaseCatalogForm::setWidgets(
            array(
                    'name' 			=> new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 1)),
                    'description' 	=> new sfWidgetFormTextArea(array(), array('tabindex'=> 1)),
                    'cost_price' 	=> new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 1)),
                    'special_cost_price' 	=> new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 1)),
            	));

		
        $this->widgetSchema->setNameFormat('catalog[%s]'); 
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
        BaseCatalogForm::setValidators(
	    	array(
                'name'				=> new sfValidatorString( 
                       								array('required' => true, 'trim' => true),
                       								array('required' => $amValidators['name']['required'])
												),
				'description'       		=> new sfValidatorString(
                                            		array('required' => false, 'trim' => true)
                                        		),
                'cost_price'       		=> new sfValidatorString(
                                            		array('required' => false, 'trim' => true)
                                        		),
                'special_cost_price'       		=> new sfValidatorString(
                                            		array('required' => false, 'trim' => true)
                                        		)
			)
        );
    }
	// over ride parent object named updateObject for set manual values 
	public function updateObject($values = null)
	{
		parent::updateObject($this->values);
	}
}
