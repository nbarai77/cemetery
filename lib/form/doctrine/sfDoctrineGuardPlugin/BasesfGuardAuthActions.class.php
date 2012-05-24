<?php

/*
 * This file is part of the symfony package.
 * (c) 2004-2006 Fabien Potencier <fabien.potencier@symfony-project.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 *
 * @package    symfony
 * @subpackage plugin
 * @author     Fabien Potencier <fabien.potencier@symfony-project.com>
 * @version    SVN: $Id: BasesfGuardAuthActions.class.php 23800 2009-11-11 23:30:50Z Kris.Wallsmith $
 */
sfProjectConfiguration::getActive()->loadHelpers(array('I18N', 'jQuery', 'Partial','Url'));

class BasesfGuardAuthActions extends sfActions
{
  public function executeSignin($request)
  {
	  
    $user = $this->getUser();
    if ($user->isAuthenticated())
    {
      return $this->redirect('@homepage');
    }

    $class = sfConfig::get('app_sf_guard_plugin_signin_form', 'sfGuardFormSignin'); 
    $this->form = new $class();

    if ($request->isMethod('post'))
    {
      $this->form->bind($request->getParameter('signin'));
      if ($this->form->isValid())
      {
		  
        $values = $this->form->getValues(); 
        $this->getUser()->signin($values['user'], array_key_exists('remember', $values) ? $values['remember'] : false);
		
		// SET USERNAME AND ENCODED PASSWORD INTO SESTION FOR LOGIN INTO GROUP OFFICE.		
		if( $this->getUser()->getAttribute('groupid') == sfConfig::get('app_cemrole_manager') || $this->getUser()->getAttribute('groupid') == sfConfig::get('app_cemrole_staffadmin') || $this->getUser()->getAttribute('groupid') == sfConfig::get('app_cemrole_staff') )
		{
			$amReuestForm = $request->getParameter('signin');
			$this->getUser()->setAttribute('code', base64_encode($amReuestForm['password']));
		}
		// END		 
        // always redirect to a URL set in app.yml
        // or to the referer
        // or to the homepage
        $signinUrl = sfConfig::get('app_sf_guard_plugin_success_signin_url', $user->getReferer($request->getReferer()));
		
        //return $this->redirect('' != $signinUrl ? $signinUrl : '@homepage');

        return $this->redirect(url_for('@summary'));
      }
    }else{
      if ($request->isXmlHttpRequest()){
        $this->getResponse()->setHeaderOnly(true);
        $this->getResponse()->setStatusCode(401);

        return sfView::NONE;
      }

      // if we have been forwarded, then the referer is the current URL
      // if not, this is the referer of the current request
      $user->setReferer($this->getContext()->getActionStack()->getSize() > 1 ? $request->getUri() : $request->getReferer());

      $module = sfConfig::get('sf_login_module');
      if ($this->getModuleName() != $module)
      {
        return $this->redirect($module.'/'.sfConfig::get('sf_login_action'));
      }

      $this->getResponse()->setStatusCode(401);
    }
  }

  public function executeSignout($request)
  {
  	$this->getUser()->signOut();
	
	//$signoutUrl = sfConfig::get('app_sf_guard_plugin_success_signout_url', $request->getReferer());	
    //$this->redirect('' != $signoutUrl ? $signoutUrl : '@homepage');
	//$ssLogoutUrl = '' != $signoutUrl ? $signoutUrl : '@homepage';
	
	$ssjQueryPath = sfConfig::get('app_site_url').'sfJqueryReloadedPlugin/js/jquery-1.4.1.min.js';
	$ssGofficeLogoutUrl = sfConfig::get('app_goffice_url').'/logout.php';
	echo "<script type='text/javascript' src='".$ssjQueryPath."'></script>
			<script type='text/javascript'>
				jQuery.ajax({
					type:'POST',
					url:'".$ssGofficeLogoutUrl."'
				});
				document.location.href = '".url_for('@homepage')."';	
			</script>";exit;
  }

  public function executeSecure($request)
  {
    $this->getResponse()->setStatusCode(403);
  }

  public function executePassword($request)
  {
	  
    $this->omForm = new sfChangeUserPasswordForm(); 

    if($request->isMethod('post'))
    { 
          $this->omForm->bind($request->getParameter($this->omForm->getName()));
      
          if($this->omForm->isValid())
          { 
              $omSfGuardUser = Doctrine::getTable('sfGuardUser')->find($this->getUser()->getGuardUser()->getId());
              
              if(isset($omSfGuardUser))
              {
                  if($this->getUser()->getGuardUser()->checkPassword($this->omForm->getValue('password')) > 0)
                  {
						$omSfGuardUser->set('password', $this->omForm->getValue('new_password'));
						$omSfGuardUser->save();
						
						$this->getUser()->setAttribute('code', base64_encode($this->omForm->getValue('new_password')));
						
						$this->getUser()->setFlash('snSuccessMsgKey', 1); 
						
						//////////////////////////////////////////////////////////////////////////////
						//			FOR UPDATE USER PASSWORD INTO CEMETERY GROUP OFFICE DB.			//
						//////////////////////////////////////////////////////////////////////////////
						sfProjectConfiguration::getActive()->loadHelpers(array('Url'));
						$ssjQueryPath = sfConfig::get('app_site_url').'sfJqueryReloadedPlugin/js/jquery-1.4.1.min.js';
						$ssURL = sfConfig::get('app_goffice_url').'/changePwdGoUser.php';

						echo "<script type='text/javascript' src='".$ssjQueryPath."'></script>
							  <script type='text/javascript'>
								var snUserId   = '".base64_encode($this->getUser()->getGuardUser()->getId())."';
								var ssUsername = '".$this->getUser()->getAttribute('username', '', 'sfGuardSecurityUser')."';
								var ssPassword = '".base64_encode($this->omForm->getValue('password'))."';
								var ssNewPassword = '".base64_encode($this->omForm->getValue('new_password'))."';
								jQuery.ajax({
									type:'POST',
									data:{user_id: snUserId, uname: ssUsername, sname: ssPassword, newpwd: ssNewPassword},
									url:'".$ssURL."'
								});
								document.location.href = '".url_for('@sf_guard_change_password')."';							
							</script>";exit;

						//////////////////////////////////
						//			END HERE			//
						//////////////////////////////////
						//$this->redirect("@sf_guard_change_password"); 
                  }
                  else
                        $this->getUser()->setFlash('snErrorMsgKey', 1); 
              }
              else
                $this->redirect("@sf_guard_signin");
          }
    }
  }
}
