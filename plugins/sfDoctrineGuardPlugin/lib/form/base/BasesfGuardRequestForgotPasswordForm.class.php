<?php

/**
 * BasesfGuardRequestForgotPasswordForm for requesting a forgot password email
 *
 * @package    sfDoctrineGuardPlugin
 * @subpackage form
 * @author     Jonathan H. Wage <jonwage@gmail.com>
 * @version    SVN: $Id: BasesfGuardRequestForgotPasswordForm.class.php,v 1.1.1.1 2012/03/24 12:16:36 nitin Exp $
 */
class BasesfGuardRequestForgotPasswordForm extends BaseForm
{
  	public function setup()
  	{
	    $this->widgetSchema['email_address'] = new sfWidgetFormInput();
		$this->validatorSchema['email_address'] = new sfValidatorAnd( 
	    		        						array(
		                       						new sfValidatorCallback(
	                       								array('callback' => array($this, 'checkEmailAddressExist')),
	                                        			array('invalid' => 'Invalid e-mail address')
	                           						),
	                   							),
	                   							array('required' => true, 'trim' => true),
	                   							array('required' => 'Email required')
	                 						);
	
		$this->widgetSchema->setNameFormat('forgot_password[%s]');
  	}

    /**
 * Function for check email address is exists or not.
 *
 * @access  public
 * @param   object  $oValidator pass sfValidatorCallback.
 * @param   string  $ssValue pass fields value.
 * @return  string
 * 	
 */
  	public function checkEmailAddressExist($oValidator, $ssValue)
  	{
      	$values = $this->getValues();

      	$this->user = Doctrine_Core::getTable('sfGuardUser')
										->createQuery('u')
										->where('u.email_address = ?', $ssValue)
										->fetchOne();

		if(!$this->user)
        	throw new sfValidatorError($oValidator, 'invalid');
        else
            return $ssValue;
  }
}