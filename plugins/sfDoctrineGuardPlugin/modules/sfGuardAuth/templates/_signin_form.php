<?php use_helper('I18N','JavascriptBase') ?>

<!--  start login-inner -->
<div id="login-inner">
	<form action="<?php echo url_for('@sf_guard_signin') ?>" method="post" name="<?php echo $form->getName(); ?>">
		<table border="0" cellpadding="0" cellspacing="0">
		<tr>
			<th><?php echo __('Username');?>: </th>
			<td>
				<?php 
					if($form['username']->hasError()):
						echo $form['username']->renderError();
					endif;
					echo $form['username']->render(array('value' => 'Username','class' => 'login-inp','onFocus' => "if($('#signin_username').val() == 'Username') { $('#signin_username').val(''); }",'onBlur' => "if($('#signin_username').val() == 'Username' || $('#signin_username').val() == '') { $('#signin_username').val('Username'); }")); 
				?>
			</td>
		</tr>
		<tr>
			<th><?php echo __('Password');?>: </th>
			<td>
				<?php 
					if($form['password']->hasError()):
						echo $form['password']->renderError();
					endif;
					echo $form['password']->render(array('value' => 'Password','class' => 'login-inp','onFocus' => "if($('#signin_password').val() == 'Password') { $('#signin_password').val(''); }",'onBlur' => "if($('#signin_password').val() == 'Password' || $('#signin_password').val() == '') { $('#signin_password').val('Password'); }")); 
				?>
			</td>
		</tr>
		<tr>
			<td valign="top" colspan="2">&nbsp;</td>
		</tr>
		<tr>
			<th></th>
			<td>
				<?php echo submit_tag(__('Login'), array('class'=>'submit-login', 'value' => __('Login'),'name'=>'login','title'=>__('Login')));?>
			</td>
		</tr>
		</table>
	 	<?php echo $form->renderHiddenFields();?>
	 </form>
	
</div>
<div class="clearb">&nbsp;</div>
<div class="clearb">&nbsp;</div>
<div class="clearb">&nbsp;</div>
<div class="fleft">
	<?php echo link_to(__('Forgot your password ?'), url_for('@sf_guard_forgot_password'), 
							array('value' => __('Forgot your password?'), 
								  'class' => 'login_link PL', 
								  'name'=>'forgotpassword', 
								  'title'=> __('Forgot your password ?'))); ?>
</div>

<div class="fleft">
<?php echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' ?>
	<?php echo link_to(__('Timesheet ?'), 'http://interments.info/live/clockinout/login.php', 
							array('value' => __('Timesheet'), 
								  'class' => 'login_link PL', 
								  'name'=>'timesheet', 
								  'title'=> __('Timesheet'))); ?>
</div>
<div class="fright">
	<?php echo link_to(__('New Subscription ?'), url_for('user/subscription'), 
							array('value' => __('Subscription'), 
								  'class' => 'login_link PR', 
								  'name'  => 'forgotpassword', 
								  'title'=> __('New Subscription ?')));?>
</div>
<!--  end login-inner -->
			


