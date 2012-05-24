<?php

/**
 * Award form.
 *
 * @package    cemetery
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class AwardForm extends BaseAwardForm
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
		//$this->useFields(array('name','description'));
        unset($this['id']);
        /*$this->disableLocalCSRFProtection();
        
        $this->widgetSchema['name'] = new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 1));
        $this->widgetSchema['description'] = new sfWidgetFormTextArea(array(), array('tabindex'=> 1));
        $subForm = new sfForm();
        
        for ($i = 0; $i <= 2; $i++)
        {
            $snIdAward = sfContext::getInstance()->getRequest()->getParameter('id','');
            if($snIdAward != '')
            {
                $asAwardDetail = Doctrine::getTable('Award')->getAwardsListWithPayRate($snIdAward);                
                foreach($asAwardDetail[0]['AwardPayRate'] as $snKey=>$asVal)
                {
                    $oAwardPayRate = Doctrine::getTable('AwardPayRate')->find($asVal['id']);                    
                    $form = new AwardPayRateForm($oAwardPayRate);
                    $subForm->embedForm($i, $form);
                }
            }
            else
            {
                $oAwdPayRate = new AwardPayRate();
                $oAwdPayRate->Award = $this->getObject();
                $form = new AwardPayRateForm($oAwdPayRate);
                $subForm->embedForm($i, $form);
            }
        }
        
        $this->embedForm('awardpayrate', $subForm);
        $this->widgetSchema->setNameFormat('award[%s]'); 
        $this->validatorSchema->setOption('allow_extra_fields', true);
		$this->validatorSchema->setOption('filter_extra_fields', false);*/
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
        BaseAwardForm::setWidgets(
            array(
                    'name' 			=> new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 1)),
                    'description' 	=> new sfWidgetFormTextArea(array(), array('tabindex'=> 1)),
            	));
		
        $this->widgetSchema->setNameFormat('award[%s]'); 
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
        BaseAwardForm::setValidators(
	    	array(
                'name'				=> new sfValidatorString( 
                       								array('required' => true, 'trim' => true),
                       								array('required' => $amValidators['name']['required'])
												),
				'description'       		=> new sfValidatorString(
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
