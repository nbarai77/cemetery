<?php


/**
 * Base actions for the sfGuardForgotPasswordPlugin sfGuardForgotPassword module.
 * 
 * @package     sfGuardForgotPasswordPlugin
 * @subpackage  sfGuardForgotPassword
 * @author      Your name here
 * @version     SVN: $Id: BasesfGuardForgotPasswordActions.class.php,v 1.1.1.1 2012/03/24 12:16:33 nitin Exp $
 */
abstract class BasesfGuardForgotPasswordActions extends sfActions {
	public function preExecute() {
		if($this->getUser()->isAuthenticated()) {
			$this->redirect('@homepage');
		}
	}

	public function executeIndex($request) {
		$this->form= new sfGuardRequestForgotPasswordForm();

		if($request->isMethod('post')) {
			$this->form->bind($request->getParameter($this->form->getName()));
			if($this->form->isValid()) {
				$this->user= $this->form->user;
				$this->_deleteOldUserForgotPasswordRecords();

				$forgotPassword= new sfGuardForgotPassword();
				$forgotPassword->user_id= $this->form->user->id;
				$forgotPassword->unique_key= md5(rand() + time());
				$forgotPassword->expires_at= new Doctrine_Expression('NOW()');
				$forgotPassword->save();

				$message= Swift_Message :: newInstance()->setFrom(sfConfig :: get('app_sf_guard_plugin_default_from_email', 'admin@noreply.com'))->setTo($this->form->user->email_address)->setSubject('Forgot Password Request for '.
				$this->form->user->username)->setBody($this->getPartial('sfGuardForgotPassword/send_request', array('user' => $this->form->user, 'forgot_password' => $forgotPassword)))->setContentType('text/html');

				$this->getMailer()->send($message);

				$this->getUser()->setFlash('notice', 'Instructions for resetting the password has been sent to your email address. Please check you mail box.');
				$this->redirect('@sf_guard_forgot_password');
			}
		}
	}

	public function executeChange($request) {
		$this->forgotPassword= $this->getRoute()->getObject();
		$this->user= $this->forgotPassword->User;
		$this->form= new sfGuardChangeUserPasswordForm($this->user);

		if($request->isMethod('post')) {
			$this->form->bind($request->getParameter($this->form->getName()));
			if($this->form->isValid()) {
				$this->form->save();

				$this->_deleteOldUserForgotPasswordRecords();

				$message= Swift_Message :: newInstance()->setFrom(sfConfig :: get('app_sf_guard_plugin_default_from_email', 'from@noreply.com'))->setTo($this->user->email_address)->setSubject('New Password for '.
				$this->user->username)->setBody($this->getPartial('sfGuardForgotPassword/new_password', array('user' => $this->user, 'password' => $request['sf_guard_user']['password'])));

				$this->getMailer()->send($message);

				$this->getUser()->setFlash('notice', 'Password updated successfully!');
				$this->redirect('@sf_guard_signin');
			}
		}
	}

	private function _deleteOldUserForgotPasswordRecords() {
		Doctrine_Core :: getTable('sfGuardForgotPassword')->createQuery('p')->delete()->where('p.user_id = ?', $this->user->id)->execute();
	}
}