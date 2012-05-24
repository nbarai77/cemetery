<?php use_helper('JavascriptBase'); ?>
<script type = "text/javascript"/>
$(function()
{
	$("ul.select").click(function(event,element)
	{	      
		$("ul.select").removeClass("current");		
		$("ul.select").addClass("select");
		$(this).addClass("current");
	});	
});
</script>
<!--  start Pagetop................................................................................................. START -->
<?php if(!$sf_user->isAuthenticated()):?>
<div id="page-top-outer">    
	<!-- Start: page-top -->
	<div id="page-top">            

		<!-- start logo -->
		<div id="logo">
			<?php echo link_to(image_tag('logo.png',array('height' => '53', 'width' => '332')),url_for('@homepage'),array('title' => __('Home') ));?>
		</div>
		<div class="clear"></div>
	</div>
	<!-- End: page-top -->
</div>
<div class="clearb"></div>
<?php else:?>
<div id="page-top-outer">    
	<!-- Start: page-top -->
	<div id="page-top">            

		<!-- start logo -->
		<div id="logo">
			<?php echo link_to(image_tag('logo.png',array('height' => '53', 'width' => '332')),url_for('@homepage'),array('title' => __('Home') ));?>
		</div>
		<!-- end logo -->		
		<!--  start top-search -->
		<div id="top-right">
			<div class="none">
				<div class="fleft">
					<p class="username"><?php echo __('Hi');?>,
							<span>
								<em>
									<?php
										//$sn_title = ($sf_user->getAttribute('title')) ? $sf_user->getAttribute('title') : __("Mr");
										echo $sf_user->getAttribute('firstname', '', 'sfGuardSecurityUser');
									?>
								</em>
							</span>
					</p>
				</div>
                <div class="fleft helpMenuT">
					<p class="username">
							<?php echo link_to_function(__('Help'),"javascript:void(0);",
										array("title"=>__("Help")));?>
					</p>
                   
                    <div id="helpMenu">
                    <ul>
                        <li>
                        <?php echo link_to(__('Help Page'),"http://www.ocmsystems.com.au/help/",
                                            array("title"=>__("Help Page"),"target"=>"_blank"));?>
                        </li>
                        |
                        <li>
                        <?php echo link_to(__('Community Forum'),"http://www.ocmsystems.com.au/forum/",
                                            array("title"=>__("Community Forum"),"target"=>"_blank"));?>
                        </li>
                        |
                        <li><?php echo link_to(__('Support'),"http://www.ocmsystems.com.au",
                                            array("title"=>__("Support"),"target"=>"_blank"));?></li>
                    </ul>
                    </div>
				</div>
                
				<div class="fleft">
					<p class="username">
							<?php echo link_to(__('Change password'),"@sf_guard_change_password",
										array("title"=>__("Change password")));?>
					</p>
				</div>
				<div class="fleft">
					<p class="username">
						<?php echo link_to(__('Logout'),"@sf_guard_signout",
										array("title"=>__("Logout"), 'name' => "logout",'id' => "logout" )); ?>
					</p>
				</div>
				<div class="fleft">
					<?php
						echo include_component('language', 'language');
					?> 
				</div>
			</div>
			
			<div class="clearb">&nbsp;</div>
			<div class="fright">
				<h1>
					<?php if(sfContext::getInstance()->getUser()->getAttribute('issuperadmin') == 1): ?>
						<?php echo __('Welcome to ').'<span>'.__('Interments').'</span>';?> 
					<?php else: ?>	
						<?php echo __("Welcome to").' <span>'.CemCemeteryTable::getCemeteryName(sfContext::getInstance()->getUser()->getAttribute('cemeteryid')).'</span>'; ?> 
					<?php endif; ?>	
				</h1>
			</div>
		</div>
		<!--  end top-search -->
		<div class="clear"></div>
	</div>
	<!-- End: page-top -->
</div>
<div class="clearb"></div>

<!--  start nav-outer-repeat................................................................................................. START -->
<div class="nav-outer-repeat"> 
	<!--  start nav-outer -->
	<div class="nav-outer"> 
		<!--  start nav -->
		<div class="nav">
			<div class="table">
			<?php echo include_partial('global/site_menu');?>
			</div>
		</div>
	</div>
	<div class="clear"></div>
<!--  start nav-outer -->
</div>
<!--  start nav-outer-repeat................................................... END -->	
<?php endif;?>

