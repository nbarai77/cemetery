<?php  use_javascript('/sfFormExtraPlugin/js/double_list.js');?>
<div id="wapper">
<?php 
    echo $oSendLettersForm->renderFormTag(
        url_for($sf_params->get('module').'/'.$sf_params->get('action').'?'.html_entity_decode($amExtraParameters['ssQuerystr'])), 
        array("name" => $oSendLettersForm->getName(), "method" => "post" ,'enctype'=>'multipart/form-data')
    );
    echo input_hidden_tag('id_letter',$sf_params->get('id_letter'));
?>

    <div class="comment_list"></div>
    <h1><?php echo __('Send Letters');?></h1>
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
                		<table width="100%" border="0" cellspacing="0" cellpadding="15" class="sub_table">
							<tr>
                            	<td valign="middle" align="right" width="20%">
                                	<?php echo $oSendLettersForm['mail_to']->renderLabel($oSendLettersForm['mail_to']->renderLabelName()."<span class='redText'>*</span>");?>
                        		</td>
	
                            	<td valign="middle" width="80%">
                                	<?php 
                                	    if($oSendLettersForm['mail_to']->hasError()):
                                    	    echo $oSendLettersForm['mail_to']->renderError();
                                        endif;
									    echo $oSendLettersForm['mail_to']->render(array('value' => $ssFwdOrReply, 'style'=>'width:600px;')); 
								    ?>
                                </td>
                    		</tr>
							<tr>
                            	<td valign="middle" align="right" width="20%">
                                	<?php echo $oSendLettersForm['mail_subject']->renderLabel($oSendLettersForm['mail_subject']->renderLabelName()."<span class='redText'>*</span>");?>
                        		</td>
	
                            	<td valign="middle" width="80%">
                                	<?php 
                                	    if($oSendLettersForm['mail_subject']->hasError()):
                                    	    echo $oSendLettersForm['mail_subject']->renderError();
                                        endif;
									    echo $oSendLettersForm['mail_subject']->render(array('style'=>'width:600px;')); 
								    ?>
                                </td>
                    		</tr>
							<tr>
                            	<td valign="middle" align="right" width="20%">  
									<?php echo $oSendLettersForm['mail_body']->renderLabel($oSendLettersForm['mail_body']->renderLabelName()."<span class='redText'>*</span>");?>                        		</td>
	
                            	<td valign="middle" width="80%">
                                	<?php 
                                	    if($oSendLettersForm['mail_body']->hasError()):
                                    	    echo $oSendLettersForm['mail_body']->renderError();
                                        endif;
									    echo $oSendLettersForm['mail_body']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>
                    		</tr>	
							<tr>
                            	<td valign="middle" align="right" width="20%">  
									<?php echo $oSendLettersForm['attachment']->renderLabel($oSendLettersForm['attachment']->renderLabelName());?>                        		
								</td>
                            	<td valign="middle" width="80%">
                                	<?php 
                                	    if($oSendLettersForm['attachment']->hasError()):
                                    	    echo $oSendLettersForm['attachment']->renderError();
                                        endif;
									    echo $oSendLettersForm['attachment']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>
                    		</tr>						
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
                                                		echo button_to(__('Cancel'),$ssCancelUrl,array('onClick' => "window.close();",'class'=>'delete','title'=>__('Cancel'),'alt'=>__('Cancel'),'tabindex'=>5));
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
        echo input_hidden_tag('id', $snBookingId, array('readonly' => 'true'));
        echo input_hidden_tag('tab', ($sf_params->get('tab') ? $sf_params->get('tab') :'info'), array('readonly' => 'true'));
		echo input_hidden_tag('attchment', '', array('readonly' => 'true'));
		echo input_hidden_tag('ssFwdOrReply', $ssFwdOrReply, array('readonly' => 'true'));
		echo input_hidden_tag('content_type', $ssContentType, array('readonly' => 'true'));

        echo $oSendLettersForm->renderHiddenFields(); 
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
