<?php use_javascript('/sfFormExtraPlugin/js/double_list.js');
use_helper('jQuery');
?>
<div id="wapper">
<?php 
    echo $oCemeteryDocForm->renderFormTag(
        url_for($sf_params->get('module').'/'.$sf_params->get('action').(!$oCemeteryDocForm->getObject()->isNew() ? '?id='.$oCemeteryDocForm->getObject()->getId().'&'.html_entity_decode($amExtraParameters['ssQuerystr']) : '')), 
        array("name" => $oCemeteryDocForm->getName(), "method" => "post" ,'enctype'=>'multipart/form-data')
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
								<?php echo $oCemeteryDocForm['doc_name']->renderLabel($oCemeteryDocForm['doc_name']->renderLabelName()."<span class='redText'>*</span>");?>
								</td>
							
								<td valign="middle" width="80%">
									<?php 
										if($oCemeteryDocForm['doc_name']->hasError()):
											echo $oCemeteryDocForm['doc_name']->renderError();
										endif;
										echo $oCemeteryDocForm['doc_name']->render(array('class'=>'inputBoxWidth')); 
									?>
								</td>
							</tr>
							<tr>
								<td valign="middle" align="right" width="20%">
								<?php echo $oCemeteryDocForm['doc_description']->renderLabel($oCemeteryDocForm['doc_description']->renderLabelName());?>
								</td>
							
								<td valign="middle" width="80%">
									<?php 
										if($oCemeteryDocForm['doc_description']->hasError()):
											echo $oCemeteryDocForm['doc_description']->renderError();
										endif;
										echo $oCemeteryDocForm['doc_description']->render(array('class'=>'inputBoxWidth')); 
									?>
								</td>
							</tr> 	
							<tr>
								<td valign="middle" align="right" width="20%">								
								<?php $ssIsMandatory = ($oCemeteryDocForm->getObject()->isNew()) ? "<span class='redText'>*</span>" : '';
									echo $oCemeteryDocForm['doc_path']->renderLabel($oCemeteryDocForm['doc_path']->renderLabelName().$ssIsMandatory);?>
								</td>
							
								<td valign="middle" width="80%">
									<?php 
										if($oCemeteryDocForm['doc_path']->hasError()):
											echo $oCemeteryDocForm['doc_path']->renderError();
										endif;
										echo $oCemeteryDocForm['doc_path']->render(array('class'=>'inputBoxWidth')); 
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
                <div class="clearb">&nbsp;</div>
            </div>
        </div>
    </div>
    <div class="clearb">&nbsp;</div>
    <div class="clearb">&nbsp;</div>
    <?php
		echo input_hidden_tag('id', $sf_params->get('id'), array('readonly' => 'true'));
		echo input_hidden_tag('type', $sf_params->get('type'), array('readonly' => 'true'));
        echo $oCemeteryDocForm->renderHiddenFields(); 
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
