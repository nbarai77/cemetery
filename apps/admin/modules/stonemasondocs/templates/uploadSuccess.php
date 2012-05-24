<?php use_javascript('/sfFormExtraPlugin/js/double_list.js');
use_helper('jQuery');
?>
<div id="wapper">
<?php 
    echo $oStonemasonDocForm->renderFormTag(
        url_for($sf_params->get('module').'/'.$sf_params->get('action').(!$oStonemasonDocForm->getObject()->isNew() ? '?id='.$oStonemasonDocForm->getObject()->getId().'&'.html_entity_decode($amExtraParameters['ssQuerystr']) : '')), 
        array("name" => $oStonemasonDocForm->getName(), "method" => "post" ,'enctype'=>'multipart/form-data')
    );
?>
    <div class="comment_list"></div>
    <h1><?php echo __('Upload Document'); ?></h1> 
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
								<?php echo $oStonemasonDocForm['doc_name']->renderLabel($oStonemasonDocForm['doc_name']->renderLabelName()."<span class='redText'>*</span>");?>
								</td>
							
								<td valign="middle" width="80%">
									<?php 
										if($oStonemasonDocForm['doc_name']->hasError()):
											echo $oStonemasonDocForm['doc_name']->renderError();
										endif;
										echo $oStonemasonDocForm['doc_name']->render(array('class'=>'inputBoxWidth')); 
									?>
								</td>
							</tr>
							<tr>
								<td valign="middle" align="right" width="20%">
								<?php echo $oStonemasonDocForm['doc_description']->renderLabel($oStonemasonDocForm['doc_description']->renderLabelName());?>
								</td>
							
								<td valign="middle" width="80%">
									<?php 
										if($oStonemasonDocForm['doc_description']->hasError()):
											echo $oStonemasonDocForm['doc_description']->renderError();
										endif;
										echo $oStonemasonDocForm['doc_description']->render(array('class'=>'inputBoxWidth')); 
									?>
								</td>
							</tr> 	
							<tr>
								<td valign="middle" align="right" width="20%">
								<?php echo $oStonemasonDocForm['doc_path']->renderLabel($oStonemasonDocForm['doc_path']->renderLabelName()."<span class='redText'>*</span>");?>
								</td>
							
								<td valign="middle" width="80%">
									<?php 
										if($oStonemasonDocForm['doc_path']->hasError()):
											echo $oStonemasonDocForm['doc_path']->renderError();
										endif;
										echo $oStonemasonDocForm['doc_path']->render(array('class'=>'inputBoxWidth')); 
									?>
								</td>
							</tr> 
							<tr>
								<td valign="middle" align="right" width="20%">
								<?php echo $oStonemasonDocForm['expiry_date']->renderLabel($oStonemasonDocForm['expiry_date']->renderLabelName());?>
								</td>
							
								<td valign="middle" width="80%">
									<?php 
										if($oStonemasonDocForm['expiry_date']->hasError()):
											echo $oStonemasonDocForm['expiry_date']->renderError();
										endif;
										echo $oStonemasonDocForm['expiry_date']->render(); 
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
															__('Upload'), 
															array(
																'class'     => 'delete',
																'name'      => 'submit_button',
																'title'     => __('Upload'), 
																'tabindex'  => 5,
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
														echo button_to(__('Cancel'),$ssCancelUrl,array('class'=>'delete','title'=>__('Cancel'),'alt'=>__('Cancel'),'tabindex'=>6));
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
		echo input_hidden_tag('type', $sf_params->get('type'), array('readonly' => 'true'));
        echo $oStonemasonDocForm->renderHiddenFields(); 
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
			$('table').find('tr:visible:odd').addClass('even').end().find('tr:visible:even').addClass('odd');
			
		});
");
?>