<?php  use_javascript('/sfFormExtraPlugin/js/double_list.js');?>
<div id="wapper">
<?php 
    echo $oCemMailForm->renderFormTag(
        url_for($sf_params->get('module').'/'.$sf_params->get('action').(!$oCemMailForm->getObject()->isNew() ? '?id='.$oCemMailForm->getObject()->getId().'&'.html_entity_decode($amExtraParameters['ssQuerystr']) : '')), 
        array("name" => $oCemMailForm->getName(), "method" => "post" ,'enctype'=>'multipart/form-data')
    );
?>
    <div class="comment_list"></div>
    <h1><?php echo $oCemMailForm->getObject()->isNew() ?  __('Compose Mail') : __('Send Mail');?></h1>
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
                            	<td valign="middle" align="right" width="20%">
                                	<?php echo $oCemMailForm['mail_to']->renderLabel($oCemMailForm['mail_to']->renderLabelName()."<span class='redText'>*</span>");?>
                        		</td>
	
                            	<td valign="middle" width="80%">
                                	<?php 
                                	    if($oCemMailForm['mail_to']->hasError()):
                                    	    echo $oCemMailForm['mail_to']->renderError();
                                        endif;
									    echo $oCemMailForm['mail_to']->render(array('value' => $ssFwdOrReply, 'style'=>'width:600px;')); 
								    ?>
                                </td>
                    		</tr>
							<tr>
                            	<td valign="middle" align="right" width="20%">
                                	<?php echo $oCemMailForm['mail_subject']->renderLabel($oCemMailForm['mail_subject']->renderLabelName()."<span class='redText'>*</span>");?>
                        		</td>
	
                            	<td valign="middle" width="80%">
                                	<?php 
                                	    if($oCemMailForm['mail_subject']->hasError()):
                                    	    echo $oCemMailForm['mail_subject']->renderError();
                                        endif;
									    echo $oCemMailForm['mail_subject']->render(array('style'=>'width:600px;')); 
								    ?>
                                </td>
                    		</tr>
							<tr>
                            	<td valign="middle" align="right" width="20%">                               	
                        		</td>
	
                            	<td valign="middle" width="80%">
                                	<?php 
                                	    if($oCemMailForm['mail_body']->hasError()):
                                    	    echo $oCemMailForm['mail_body']->renderError();
                                        endif;
									    echo $oCemMailForm['mail_body']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>
                    		</tr>
							<!--<tr>
                            	<td valign="middle" align="right" width="20%">
                                	<?php //echo $oCemMailForm['attached_file_name']->renderLabel($oCemMailForm['attached_file_name']->renderLabelName()."<span class='redText'>*</span>");?>
                        		</td>
	
                            	<td valign="middle" width="80%">
									<div class="fleft">
                                	<?php /*
                                	    if($oCemMailForm['attached_file_name']->hasError()):
                                    	    echo $oCemMailForm['attached_file_name']->renderError();
                                        endif;
									    echo $oCemMailForm['attached_file_name']->render(array('class'=>'inputBoxWidth')); 
										*/
								    ?>
									</div>
									<div class="fleft" style="margin-left:10px;">
										<div class="actions">
										<ul class="fleft">
                                        	<li class="list1">
                                        		<span>
													<?php /*
														echo submit_tag(
															__('Add'), 
															array(
																'class'     => 'delete',
																'name'      => 'submit_button',
																'title'     => __('Add'), 
																'tabindex'  => 4,
																'onclick'   => "jQuery('#attchment').val('1');"
															)
														);*/
													?>
												</span>
                                       		</li>
											<li style="vertical-align:middle;">
												<strong><?php //echo __('(max 2 M)');?></strong>
											</li>
										</ul>
										</div>
									</div>
                                </td>
                    		</tr>-->
                    		<tr>
                            	<td>&nbsp;</td>
                        		<td valign="middle">
                                	<div class="actions">
                                		<ul class="fleft">
                                        	<li class="list1">
                                        		<span>
	                                                <?php 
	                                                    echo submit_tag(
	                                                        __('Send'), 
	                                                        array(
	                                                            'class'     => 'delete',
	                                                            'name'      => 'submit_button',
	                                                            'title'     => __('Send'), 
	                                                            'tabindex'  => 4,
	                                                            'onclick'   => "jQuery('#tab').val('');"
	                                                        )
	                                                    );
	                                                ?>
                                        		</span>
                                        	</li>
                                			<li class="list1">
                                        		<span>
                                        			<?php  
                                        			    $ssCancelUrl    = $sf_params->get('module').'/index?'.html_entity_decode($amExtraParameters['ssQuerystr']);
                                                		echo button_to(__('Cancel'),$ssCancelUrl,array('class'=>'delete','title'=>__('Cancel'),'alt'=>__('Cancel'),'tabindex'=>5));
                                                    ?>
                                    			</span>
                                    		</li>
                            			</ul>
                                	</div>
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
		echo input_hidden_tag('attchment', '', array('readonly' => 'true'));
		echo input_hidden_tag('ssFwdOrReply', $ssFwdOrReply, array('readonly' => 'true'));		
        echo $oCemMailForm->renderHiddenFields(); 
    ?>
    </form>
</div>
<?php 
    echo javascript_tag('
        ssTags = document.getElementsByTagName("INPUT");
        document.getElementById(ssTags[0].id).select();
        document.getElementById(ssTags[0].id).focus();'
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
echo javascript_tag("
	jQuery(document).ready(function() 
		{
			$('table').find('tr:visible:odd').addClass('odd').end().find('tr:visible:even').addClass('even');
			
		});
");
?>
