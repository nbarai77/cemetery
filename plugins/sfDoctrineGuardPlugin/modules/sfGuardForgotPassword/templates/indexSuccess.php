<?php use_helper('I18N', 'jQuery') ?>

<form action="<?php echo url_for('@sf_guard_forgot_password') ?>" method="post" name="<?php echo $form->getName(); ?>">
<!-- Start: login-holder -->
<div id="login-holder">

	<!-- start logo 
	<div id="logo-login">
		<a href="index.html"><img src="images/logo.png" height="53" width="332" alt="" /></a>
	</div>
	<!-- end logo -->
	<div style="margin: 100px 0 0 15px;"></div>
	<div class="clearb"></div>
	<!--  start loginbox ................................................................................. -->
        <div id="loginbox">
        	<div id="login-inner">			
				<table border="0" cellpadding="0" cellspacing="0" width="100%">
					<tr>
						<td valign="top" colspan="2">&nbsp;</td>
					</tr>
					<tr>
						<td valign="top" colspan="2">&nbsp;</td>
					</tr>
					<tr>
						<th width="51%"><?php echo __('Email address') ?>: </th>
						<td width="49%">
							<?php 
                                    if($form['email_address']->hasError()):
                                        echo $form['email_address']->renderError();
                                    endif;
                                    echo $form['email_address']->render(array('class' => 'login-inp','maxlength'=>'35')); 
                                ?>						</td>
					</tr>
					<tr>
						<td valign="top" colspan="2">&nbsp;</td>
					</tr>
					<tr>
						<th></th>
						<td>
							<?php echo submit_tag(__('Request', null, 'sf_guard'), 
										array('class'=>'submit-request fleft', 'name' => 'change', 'title' => __('Request', null, 'sf_guard'))); 
								  
								  echo button_to(__('Cancel'),'@homepage',array('class'=>'submit-cancel','title'=>__('Cancel'),'alt'=>__('Cancel')));
	
							?>
						</td>						
					</tr>
					</table>
			</div>
        </div>
 	<!--  end loginbox -->    
</div>