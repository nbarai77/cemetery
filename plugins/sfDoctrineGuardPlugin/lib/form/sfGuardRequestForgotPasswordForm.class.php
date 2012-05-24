<?php

/**
 * BasesfGuardRequestForgotPasswordForm for requesting a forgot password email
 *
 * @package    sfDoctrineGuardPlugin
 * @subpackage form
 * @author     Jonathan H. Wage <jonwage@gmail.com>
 * @version    SVN: $Id: sfGuardRequestForgotPasswordForm.class.php,v 1.1.1.1 2012/03/24 12:16:35 nitin Exp $
 */
class sfGuardRequestForgotPasswordForm extends BasesfGuardRequestForgotPasswordForm
{
  /**
   * @see sfForm
   */
  public function configure()
  {
        // Disable the secret key
        $this->disableLocalCSRFProtection();
  }
}