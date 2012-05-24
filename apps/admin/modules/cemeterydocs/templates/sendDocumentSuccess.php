<?php use_javascript('/sfFormExtraPlugin/js/double_list.js');
use_helper('jQuery');
?>
<div id="wapper">
<?php 
    echo $oSendDocumentForm->renderFormTag(
        url_for($sf_params->get('module').'/sendDocument'), 
        array("name" => $oSendDocumentForm->getName(), "method" => "post" ,'enctype'=>'multipart/form-data')
    );
?>
    <div class="comment_list"></div>
    <h1><?php echo __('Send Cemetery Document'); ?></h1> 
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
							<?php echo $oSendDocumentForm['mail_to']->renderLabel($oSendDocumentForm['mail_to']->renderLabelName()."<span class='redText'>*</span>");?>
							</td>
						
							<td valign="middle" width="80%">
								<?php 
									if($oSendDocumentForm['mail_to']->hasError()):
										echo $oSendDocumentForm['mail_to']->renderError();
									endif;				
									echo $oSendDocumentForm['mail_to']->render(array('class'=>'inputBoxWidth')); 
								?>
							</td>
						</tr> 
						<tr>
							<td valign="middle" align="right" width="20%">
							<?php echo $oSendDocumentForm['mail_subject']->renderLabel($oSendDocumentForm['mail_subject']->renderLabelName()."<span class='redText'>*</span>");?>
							</td>
						
							<td valign="middle" width="80%">
								<?php 
									if($oSendDocumentForm['mail_subject']->hasError()):
										echo $oSendDocumentForm['mail_subject']->renderError();
									endif;				
									echo $oSendDocumentForm['mail_subject']->render(array('class'=>'inputBoxWidth')); 
								?>
							</td>
						</tr>
						<tr>
							<td valign="middle" align="right" width="20%">&nbsp;</td>
							<td valign="middle" width="80%">
								<?php 
									if($oSendDocumentForm['mail_body']->hasError()):
										echo $oSendDocumentForm['mail_body']->renderError();
									endif;				
									echo $oSendDocumentForm['mail_body']->render(array('class'=>'inputBoxWidth')); 
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
													$ssCancelUrl    = $sf_params->get('module').'/listDocuments?'.html_entity_decode($amExtraParameters['ssQuerystr']);
													echo button_to(__('Cancel'),$ssCancelUrl,array('class'=>'delete','title'=>__('Cancel'),'alt'=>__('Cancel'),'tabindex'=>4));
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
            </div>
        </div>
    </div>
    <div class="clearb">&nbsp;</div>
    <div class="clearb">&nbsp;</div>
    <?php
		echo input_hidden_tag('id', $sf_params->get('id'), array('readonly' => 'true'));
        echo $oSendDocumentForm->renderHiddenFields(); 
    ?>
    </form>
</div>
<?php
echo javascript_tag("
	ssTags = document.getElementsByTagName('INPUT');
	document.getElementById(ssTags[0].id).select();
	document.getElementById(ssTags[0].id).focus();
	jQuery(document).ready(function() 
		{
			$('table').find('tr:visible:odd').addClass('odd').end().find('tr:visible:even').addClass('even');
			
		});
");
?>