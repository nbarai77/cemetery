<?php

/**
 * Language form.
 *
 * @package    cemetery
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: LanguageForm.class.php,v 1.1.1.1 2012/03/24 11:56:29 nitin Exp $
 */
class LanguageForm extends BaseLanguageForm
{
  public function configure(){
	  unset($this['id'],$this['created_at'],$this['updated_at']);
  }
  
   /**
     * Function for set widgets for form elements.
     *
     * @access  public
     * @param   array   $asWidgets pass a widgets array.
     *
     */
    public function setWidgets(array $asWidgets){
        BaseLanguageForm::setWidgets(
            array(
                    'language_name' => new sfWidgetFormInputText(array(), array('maxlength' => 255,'tabindex'=> 1)),
                    'culture' => new sfWidgetFormInputText(array(), array('maxlength' => 50,'tabindex'=> 2)),
                    'is_enabled'         => new MyWidgetFormInputCheckbox(array(), array('tabindex' => 3, 'value' => 1)),                    
            )
        );
        $this->widgetSchema->setNameFormat('language[%s]'); 
    }  
  
  
    /**
     * Function for set labels for form elements.
     *
     * @access  public
     * @param   array   $asLabels pass a labels array.
     *
     */
    public function setLabels($asLabels){
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
		
        BaseLanguageForm::setValidators(
            array(
                'language_name'       => new sfValidatorAnd( 
    		        						array(
	                       						new sfValidatorCallback(
                       								array('callback' => array($this, 'checkLanguageNameExist')),
                                        			array('invalid' => __('Language Name already exists'))
                           						),
                   							),
                   							array('required' => true, 'trim' => true),
                   							array('required' => __('Language Name required'))
                 						),  
                 						
                'culture'       => new sfValidatorAnd( 
    		        						array(
	                       						new sfValidatorCallback(
                       								array('callback' => array($this, 'checkCultureExist')),
                                        			array('invalid' => __('Culture already exists'))
                           						),
                   							),
                   							array('required' => true, 'trim' => true),
                   							array('required' => __('Culture required'))
                 						),
                                                                                
                'is_enabled'         => new sfValidatorString(
                                            array('required' => false, 'trim' => true)
                                        ),                   
                                          

            )
        );
    }   
    
    /**
     * Function for check name is exists or not.
     *
     * @access  public
     * @param   object  $oValidator pass sfValidatorCallback.
     * @param   string  $ssValue pass fields value.
     * @return  string
     *  
     */
    public function checkLanguageNameExist($oValidator, $ssValue)
    {
        $snIdGroup = '';
        if(!$this->isNew())
            $snIdGroup = $this->getObject()->getId();

        $oSfGuardGroup = new Language();
        $oResult    = $oSfGuardGroup->checkLanguageNameExist($ssValue, $snIdGroup);
        unset($oSfGuardGroup);
      
        if(count($oResult) > 0)
            throw new sfValidatorError($oValidator, 'invalid');
        else
            return $ssValue;
    }   
    
    /**
     * Function for check culture is exists or not.
     *
     * @access  public
     * @param   object  $oValidator pass sfValidatorCallback.
     * @param   string  $ssValue pass fields value.
     * @return  string
     *  
     */
    public function checkCultureExist($oValidator, $ssValue)
    {
        $snIdGroup = '';
        if(!$this->isNew())
            $snIdGroup = $this->getObject()->getId();

        $oSfGuardGroup = new Language();
        $oResult    = $oSfGuardGroup->checkCultureExist($ssValue, $snIdGroup);
        unset($oSfGuardGroup);
      
        if(count($oResult) > 0)
            throw new sfValidatorError($oValidator, 'invalid');
        else
            return $ssValue;
    } 
    
    
            
    
  
}
