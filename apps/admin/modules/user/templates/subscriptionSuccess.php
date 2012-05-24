<?php  use_javascript('/sfFormExtraPlugin/js/double_list.js');?>
<div id="wapper">
<?php 
    echo $oCemSubscriptionForm->renderFormTag(
        url_for($sf_params->get('module').'/'.$sf_params->get('action').(!$oCemSubscriptionForm->getObject()->isNew() ? '?id='.$oCemSubscriptionForm->getObject()->getId().'&'.html_entity_decode($amExtraParameters['ssQuerystr']) : '')), 
        array("name" => $oCemSubscriptionForm->getName(), "method" => "post" ,'enctype'=>'multipart/form-data')
    );
?>
    <div class="comment_list"></div>
    <h1><?php echo __('Cemetery Subscription');?></h1>
    <div id="message">
        <div id="success_msgs">
            <?php echo include_partial('global/notification_msg', array('amSuccessMsg' => $amSuccessMsg,'amErrorMsg' => $amErrorMsg));?>
        </div>
    </div>
    <div class="clearb">&nbsp;</div>
    <div id="main">
        <div class="maintablebg">
            <div class="main_cont">
                <div class="left_part">
            		<div id="info">
                		<table width="100%" border="0" cellspacing="0" cellpadding="0" class="sub_table">
							<tr>
								<td colspan="2" align="center">
									<span style="color: #258ECA;font-size:18px;font-weight:normal;"><?php echo __('Cemetery Details');?></span>
								</td>
								<td colspan="2" align="center">
									<span style="color: #258ECA;font-size:18px;font-weight:normal;"><?php echo __('User Details');?></span>
								</td>
							</tr>
                    		<tr>
                            	<td valign="middle" align="right">
                                	<?php echo $oCemSubscriptionForm['country_id']->renderLabel($oCemSubscriptionForm['country_id']->renderLabelName()."<span class='redText'>*</span>");?>
                        		</td>
	
                            	<td valign="middle">
                                	<?php 
                                	    if($oCemSubscriptionForm['country_id']->hasError()):
                                    	    echo $oCemSubscriptionForm['country_id']->renderError();
                                        endif;
									    echo $oCemSubscriptionForm['country_id']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>
								<td valign="middle" align="right">
                                	<?php echo $oCemSubscriptionForm['user_subscription']['title']->renderLabel($oCemSubscriptionForm['user_subscription']['title']->renderLabelName());?>
                        		</td>
	
                            	<td valign="middle">
                                	<?php 
                                	    if($oCemSubscriptionForm['user_subscription']['title']->hasError()):
                                    	    echo $oCemSubscriptionForm['user_subscription']['title']->renderError();
                                        endif;
									    echo $oCemSubscriptionForm['user_subscription']['title']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>
                    		</tr>
							<tr>
                            	<td valign="middle" align="right">
                                	<?php echo $oCemSubscriptionForm['name']->renderLabel($oCemSubscriptionForm['name']->renderLabelName()."<span class='redText'>*</span>");?>
                        		</td>
	
                            	<td valign="middle">
                                	<?php 
                                	    if($oCemSubscriptionForm['name']->hasError()):
                                    	    echo $oCemSubscriptionForm['name']->renderError();
                                        endif;
									    echo $oCemSubscriptionForm['name']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>
								<td valign="middle" align="right">
                                	<?php echo $oCemSubscriptionForm['user_subscription']['last_name']->renderLabel($oCemSubscriptionForm['user_subscription']['last_name']->renderLabelName()."<span class='redText'>*</span>");?>
                        		</td>
	
                            	<td valign="middle">
                                	<?php 
                                	    if($oCemSubscriptionForm['user_subscription']['last_name']->hasError()):
                                    	    echo $oCemSubscriptionForm['user_subscription']['last_name']->renderError();
                                        endif;
									    echo $oCemSubscriptionForm['user_subscription']['last_name']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>
                    		</tr>
                    		<tr>
                            	<td valign="middle" align="right">
                                	<?php echo $oCemSubscriptionForm['description']->renderLabel($oCemSubscriptionForm['description']->renderLabelName());?>
                        		</td>
	
                            	<td valign="middle">
                                	<?php 
                                	    if($oCemSubscriptionForm['description']->hasError()):
                                    	    echo $oCemSubscriptionForm['description']->renderError();
                                        endif;
									    echo $oCemSubscriptionForm['description']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>
								<td valign="middle" align="right">
                                	<?php echo $oCemSubscriptionForm['user_subscription']['first_name']->renderLabel($oCemSubscriptionForm['user_subscription']['first_name']->renderLabelName()."<span class='redText'>*</span>");?>
                        		</td>
	
                            	<td valign="middle">
                                	<?php 
                                	    if($oCemSubscriptionForm['user_subscription']['first_name']->hasError()):
                                    	    echo $oCemSubscriptionForm['user_subscription']['first_name']->renderError();
                                        endif;
									    echo $oCemSubscriptionForm['user_subscription']['first_name']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>
                    		</tr>
                    		<tr>
                            	<td valign="middle" align="right">
                                	<?php echo $oCemSubscriptionForm['url']->renderLabel($oCemSubscriptionForm['url']->renderLabelName());?>
                        		</td>
	
                            	<td valign="middle">
                                	<?php 
                                	    if($oCemSubscriptionForm['url']->hasError()):
                                    	    echo $oCemSubscriptionForm['url']->renderError();
                                        endif;
									    echo $oCemSubscriptionForm['url']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>
								<td valign="middle" align="right">
                                	<?php echo $oCemSubscriptionForm['user_subscription']['middle_name']->renderLabel($oCemSubscriptionForm['user_subscription']['middle_name']->renderLabelName());?>
                        		</td>
	
                            	<td valign="middle">
                                	<?php 
                                	    if($oCemSubscriptionForm['user_subscription']['middle_name']->hasError()):
                                    	    echo $oCemSubscriptionForm['user_subscription']['middle_name']->renderError();
                                        endif;
									    echo $oCemSubscriptionForm['user_subscription']['middle_name']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>
                    		</tr>
                    		<tr>
                            	<td valign="middle" align="right">
                                	<?php echo $oCemSubscriptionForm['address']->renderLabel($oCemSubscriptionForm['address']->renderLabelName());?>
                        		</td>
	
                            	<td valign="middle">
                                	<?php 
                                	    if($oCemSubscriptionForm['address']->hasError()):
                                    	    echo $oCemSubscriptionForm['address']->renderError();
                                        endif;
									    echo $oCemSubscriptionForm['address']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>
								<td valign="middle" align="right">
                                	<?php echo $oCemSubscriptionForm['user_subscription']['email_address']->renderLabel($oCemSubscriptionForm['user_subscription']['email_address']->renderLabelName()."<span class='redText'>*</span>");?>
                        		</td>
	
                            	<td valign="middle">
                                	<?php 
                                	    if($oCemSubscriptionForm['user_subscription']['email_address']->hasError()):
                                    	    echo $oCemSubscriptionForm['user_subscription']['email_address']->renderError();
                                        endif;
									    echo $oCemSubscriptionForm['user_subscription']['email_address']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>
                    		</tr>
                    		<tr>
                            	<td valign="middle" align="right">
                                	<?php echo $oCemSubscriptionForm['suburb_town']->renderLabel($oCemSubscriptionForm['suburb_town']->renderLabelName());?>
                        		</td>
	
                            	<td valign="middle">
                                	<?php 
                                	    if($oCemSubscriptionForm['suburb_town']->hasError()):
                                    	    echo $oCemSubscriptionForm['suburb_town']->renderError();
                                        endif;
									    echo $oCemSubscriptionForm['suburb_town']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>
								<td valign="middle" align="right">
                                	<?php echo $oCemSubscriptionForm['user_subscription']['username']->renderLabel($oCemSubscriptionForm['user_subscription']['username']->renderLabelName()."<span class='redText'>*</span>");?>
                        		</td>
	
                            	<td valign="middle">
                                	<?php 
                                	    if($oCemSubscriptionForm['user_subscription']['username']->hasError()):
                                    	    echo $oCemSubscriptionForm['user_subscription']['username']->renderError();
                                        endif;
									    echo $oCemSubscriptionForm['user_subscription']['username']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>
                    		</tr>
                    		<tr>
                            	<td valign="middle" align="right">
                                	<?php echo $oCemSubscriptionForm['state']->renderLabel($oCemSubscriptionForm['state']->renderLabelName());?>
                        		</td>
	
                            	<td valign="middle">
                                	<?php 
                                	    if($oCemSubscriptionForm['state']->hasError()):
                                    	    echo $oCemSubscriptionForm['state']->renderError();
                                        endif;
									    echo $oCemSubscriptionForm['state']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>
								<td valign="middle" align="right">
                                	<?php echo $oCemSubscriptionForm['user_subscription']['password']->renderLabel($oCemSubscriptionForm['user_subscription']['password']->renderLabelName()."<span class='redText'>*</span>");?>
                        		</td>
	
                            	<td valign="middle">
                                	<?php 
                                	    if($oCemSubscriptionForm['user_subscription']['password']->hasError()):
                                    	    echo $oCemSubscriptionForm['user_subscription']['password']->renderError();
                                        endif;
									    echo $oCemSubscriptionForm['user_subscription']['password']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>
                    		</tr>
                    		<tr>
                            	<td valign="middle" align="right">
                                	<?php echo $oCemSubscriptionForm['postcode']->renderLabel($oCemSubscriptionForm['postcode']->renderLabelName());?>
                        		</td>
	
                            	<td valign="middle">
                                	<?php 
                                	    if($oCemSubscriptionForm['postcode']->hasError()):
                                    	    echo $oCemSubscriptionForm['postcode']->renderError();
                                        endif;
									    echo $oCemSubscriptionForm['postcode']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>
								<td valign="middle" align="right">
                                	<?php echo $oCemSubscriptionForm['user_subscription']['password_again']->renderLabel($oCemSubscriptionForm['user_subscription']['password_again']->renderLabelName()."<span class='redText'>*</span>");?>
                        		</td>
	
                            	<td valign="middle">
                                	<?php 
                                	    if($oCemSubscriptionForm['user_subscription']['password_again']->hasError()):
                                    	    echo $oCemSubscriptionForm['user_subscription']['password_again']->renderError();
                                        endif;
									    echo $oCemSubscriptionForm['user_subscription']['password_again']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>
                    		</tr>
							<tr>
                            	<td valign="middle" align="right">
                                	<?php echo $oCemSubscriptionForm['area_code']->renderLabel($oCemSubscriptionForm['area_code']->renderLabelName());?>
                        		</td>
	
                            	<td valign="middle">
                                	<?php 
                                	    if($oCemSubscriptionForm['area_code']->hasError()):
                                    	    echo $oCemSubscriptionForm['area_code']->renderError();
                                        endif;
									    echo $oCemSubscriptionForm['area_code']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>
								<td valign="middle" align="right">
                                	<?php echo $oCemSubscriptionForm['user_subscription']['organisation']->renderLabel($oCemSubscriptionForm['user_subscription']['organisation']->renderLabelName()."<span class='redText'>*</span>");?>
                        		</td>
	
                            	<td valign="middle">
                                	<?php 
                                	    if($oCemSubscriptionForm['user_subscription']['organisation']->hasError()):
                                    	    echo $oCemSubscriptionForm['user_subscription']['organisation']->renderError();
                                        endif;
									    echo $oCemSubscriptionForm['user_subscription']['organisation']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>
                    		</tr>
                    		<tr>
                            	<td valign="middle" align="right">
                                	<?php echo $oCemSubscriptionForm['phone']->renderLabel($oCemSubscriptionForm['phone']->renderLabelName());?>
                        		</td>
	
                            	<td valign="middle">
                                	<?php 
                                	    if($oCemSubscriptionForm['phone']->hasError()):
                                    	    echo $oCemSubscriptionForm['phone']->renderError();
                                        endif;
									    echo $oCemSubscriptionForm['phone']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>
								<td valign="middle" align="right">
                                	<?php echo $oCemSubscriptionForm['user_subscription']['code']->renderLabel($oCemSubscriptionForm['user_subscription']['code']->renderLabelName());?>
                        		</td>
	
                            	<td valign="middle">
                                	<?php 
                                	    if($oCemSubscriptionForm['user_subscription']['code']->hasError()):
                                    	    echo $oCemSubscriptionForm['user_subscription']['code']->renderError();
                                        endif;
									    echo $oCemSubscriptionForm['user_subscription']['code']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>
                    		</tr>
							<tr>
                            	<td valign="middle" align="right">
                                	<?php echo $oCemSubscriptionForm['fax_area_code']->renderLabel($oCemSubscriptionForm['fax_area_code']->renderLabelName());?>
                        		</td>
	
                            	<td valign="middle">
                                	<?php 
                                	    if($oCemSubscriptionForm['fax_area_code']->hasError()):
                                    	    echo $oCemSubscriptionForm['fax_area_code']->renderError();
                                        endif;
									    echo $oCemSubscriptionForm['fax_area_code']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>
								<td valign="middle" align="right">
                                	<?php echo $oCemSubscriptionForm['user_subscription']['address']->renderLabel($oCemSubscriptionForm['user_subscription']['address']->renderLabelName());?>
                        		</td>
	
                            	<td valign="middle">
                                	<?php 
                                	    if($oCemSubscriptionForm['user_subscription']['address']->hasError()):
                                    	    echo $oCemSubscriptionForm['user_subscription']['address']->renderError();
                                        endif;
									    echo $oCemSubscriptionForm['user_subscription']['address']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>
                    		</tr>
                    		<tr>
                            	<td valign="middle" align="right">
                                	<?php echo $oCemSubscriptionForm['fax']->renderLabel($oCemSubscriptionForm['fax']->renderLabelName());?>
                        		</td>
	
                            	<td valign="middle">
                                	<?php 
                                	    if($oCemSubscriptionForm['fax']->hasError()):
                                    	    echo $oCemSubscriptionForm['fax']->renderError();
                                        endif;
									    echo $oCemSubscriptionForm['fax']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>
								<td valign="middle" align="right">
                                	<?php echo $oCemSubscriptionForm['user_subscription']['state']->renderLabel($oCemSubscriptionForm['user_subscription']['state']->renderLabelName());?>
                        		</td>
	
                            	<td valign="middle">
                                	<?php 
                                	    if($oCemSubscriptionForm['user_subscription']['state']->hasError()):
                                    	    echo $oCemSubscriptionForm['user_subscription']['state']->renderError();
                                        endif;
									    echo $oCemSubscriptionForm['user_subscription']['state']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>
                    		</tr>
                    		<tr>
                            	<td valign="middle" align="right">
                                	<?php echo $oCemSubscriptionForm['email']->renderLabel($oCemSubscriptionForm['email']->renderLabelName());?>
                        		</td>
	
                            	<td valign="middle">
                                	<?php 
                                	    if($oCemSubscriptionForm['email']->hasError()):
                                    	    echo $oCemSubscriptionForm['email']->renderError();
                                        endif;
									    echo $oCemSubscriptionForm['email']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>
								<td valign="middle" align="right">
                                	<?php echo $oCemSubscriptionForm['user_subscription']['postal_code']->renderLabel($oCemSubscriptionForm['user_subscription']['postal_code']->renderLabelName());?>
                        		</td>
	
                            	<td valign="middle">
                                	<?php 
                                	    if($oCemSubscriptionForm['user_subscription']['postal_code']->hasError()):
                                    	    echo $oCemSubscriptionForm['user_subscription']['postal_code']->renderError();
                                        endif;
									    echo $oCemSubscriptionForm['user_subscription']['postal_code']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>
                    		</tr>
							<tr>
                            	<td valign="middle" align="right">
                                	<?php echo $oCemSubscriptionForm['cemetery_map_path']->renderLabel($oCemSubscriptionForm['cemetery_map_path']->renderLabelName());?>
                        		</td>
	
                            	<td valign="middle">
                                	<?php 
                                	    if($oCemSubscriptionForm['cemetery_map_path']->hasError()):
                                    	    echo $oCemSubscriptionForm['cemetery_map_path']->renderError();
                                        endif;
									    echo $oCemSubscriptionForm['cemetery_map_path']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>
								<td valign="middle" align="right">
                                	<?php echo $oCemSubscriptionForm['user_subscription']['area_code']->renderLabel($oCemSubscriptionForm['user_subscription']['area_code']->renderLabelName());?>
                        		</td>
	
                            	<td valign="middle">
                                	<?php 
                                	    if($oCemSubscriptionForm['user_subscription']['area_code']->hasError()):
                                    	    echo $oCemSubscriptionForm['user_subscription']['area_code']->renderError();
                                        endif;
									    echo $oCemSubscriptionForm['user_subscription']['area_code']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>
                    		</tr>
	                        <tr>
								<td valign="middle">
									<?php echo $oCemSubscriptionForm['is_enabled']->renderLabel($oCemSubscriptionForm['is_enabled']->renderLabelName());?>
								</td>
								<td valign="middle"> <?php echo $oCemSubscriptionForm['is_enabled']->render();?> </td>
								<td valign="middle" align="right">
                                	<?php echo $oCemSubscriptionForm['user_subscription']['phone']->renderLabel($oCemSubscriptionForm['user_subscription']['phone']->renderLabelName());?>
                        		</td>
	
                            	<td valign="middle">
                                	<?php 
                                	    if($oCemSubscriptionForm['user_subscription']['phone']->hasError()):
                                    	    echo $oCemSubscriptionForm['user_subscription']['phone']->renderError();
                                        endif;
									    echo $oCemSubscriptionForm['user_subscription']['phone']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>
	                        </tr>
							<tr>
								<td valign="middle">&nbsp;</td>
								<td valign="middle">&nbsp;</td>
								<td valign="middle" align="right">
                                	<?php echo $oCemSubscriptionForm['user_subscription']['fax_area_code']->renderLabel($oCemSubscriptionForm['user_subscription']['fax_area_code']->renderLabelName());?>
                        		</td>
	
                            	<td valign="middle">
                                	<?php 
                                	    if($oCemSubscriptionForm['user_subscription']['fax_area_code']->hasError()):
                                    	    echo $oCemSubscriptionForm['user_subscription']['fax_area_code']->renderError();
                                        endif;
									    echo $oCemSubscriptionForm['user_subscription']['fax_area_code']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>
	                        </tr>
							<tr>
								<td valign="middle">&nbsp;</td>
								<td valign="middle">&nbsp;</td>
								<td valign="middle" align="right">
                                	<?php echo $oCemSubscriptionForm['user_subscription']['fax']->renderLabel($oCemSubscriptionForm['user_subscription']['fax']->renderLabelName());?>
                        		</td>
	
                            	<td valign="middle">
                                	<?php 
                                	    if($oCemSubscriptionForm['user_subscription']['fax']->hasError()):
                                    	    echo $oCemSubscriptionForm['user_subscription']['fax']->renderError();
                                        endif;
									    echo $oCemSubscriptionForm['user_subscription']['fax']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>
	                        </tr>
                    		<tr>
                            	<td>&nbsp;</td>
								<td>
									<div class="actions">
                                		<ul class="fright">
                                        	<li class="list1">
                                        		<span>
	                                                <?php 
	                                                    echo submit_tag(
	                                                        __('subscribe'), 
	                                                        array(
	                                                            'class'     => 'delete',
	                                                            'name'      => 'submit_button',
	                                                            'title'     => __('Save'), 
	                                                            'tabindex'  => 34,
	                                                            'onclick'   => "jQuery('#tab').val('');"
	                                                        )
	                                                    );
	                                                ?>
                                        		</span>
                                        	</li>
										</ul>
                                	</div>
								</td>
								<td>
									<div class="actions">
                                		<ul class="fleft">
                                        	<li class="list1">
                                        		<span>
													<?php echo link_to(__('Cancle'),'/',array('class'=>'None','title'=>__('Cancle')));?>
                                        		</span>
                                        	</li>
										</ul>
                                	</div>
								</td>
								<td>&nbsp;
                                	
                        		</td>                        		
                        	</tr>
                		</table>
            		</div>

                </div>
                <div class="clearb"></div>
            </div>
        </div>
    </div>
    <div class="clearb">&nbsp;</div>
    <div class="clearb">&nbsp;</div>
    <?php
        echo input_hidden_tag('id', $sf_params->get('id'), array('readonly' => 'true'));
        echo input_hidden_tag('tab', ($sf_params->get('tab') ? $sf_params->get('tab') :'info'), array('readonly' => 'true'));
        echo $oCemSubscriptionForm->renderHiddenFields(); 
    ?>
    </form>
</div>
<?php 
    echo javascript_tag('
        ssTags = document.getElementsByTagName("select");
//        document.getElementById(ssTags[0].id).select();
        document.getElementById(ssTags[1].id).focus();'
    );
    
    echo javascript_tag("
        jQuery(document).ready(function() 
            {
                tabSelection('".(($sf_params->get('tab')) ? $sf_params->get('tab') : 'info')."','active');
            });
        function tabSelection(id, ssClassName)
        { 
            var asTabs      = new Array('user_info','user_permission');
            var asUpdateDiv = new Array('info','permission'); 
            
            for(var i=0;i<asTabs.length;i++)
            {
	            jQuery('#' + asTabs[i] ).removeClass(ssClassName);
            }
            
            jQuery('#user_' + id).addClass(ssClassName);
            
            for(var i=0;i<asUpdateDiv.length;i++)
            {
                jQuery('#' + asUpdateDiv[i] ).attr('style','display:none');
            }

            jQuery('#' + id).attr('style','display:block');
        }
    ");
?>

<?php
    echo javascript_tag("
        jQuery(document).ready(function() 
            {
				$('table').find('tr:visible:odd').addClass('even').end().find('tr:visible:even').addClass('odd');
                
            });
    ");
?>
