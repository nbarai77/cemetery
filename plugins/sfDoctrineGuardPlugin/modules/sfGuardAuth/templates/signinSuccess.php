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
        
			<?php if($sf_user->getFlash('ssSuccessRegisteration') != ''):?>
						<div class='succ-msg'><span><?php echo $sf_user->getFlash('ssSuccessRegisteration'); ?> </span></div>
			<?php endif;
					 echo get_partial('sfGuardAuth/signin_form', array('form' => $form)); ?>
            
        </div>
 	<!--  end loginbox -->    
</div>