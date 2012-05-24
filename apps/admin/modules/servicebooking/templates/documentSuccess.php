<?php use_javascript('/sfFormExtraPlugin/js/double_list.js');
use_helper('jQuery');
?>
<div id="wapper">
<?php 
    echo $oBookingDocForm->renderFormTag(
        url_for($sf_params->get('module').'/'.$sf_params->get('action').(!$oBookingDocForm->getObject()->isNew() ? '?id='.$oBookingDocForm->getObject()->getId().'&'.html_entity_decode($amExtraParameters['ssQuerystr']) : '')), 
        array("name" => $oBookingDocForm->getName(), "method" => "post" ,'enctype'=>'multipart/form-data')
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
								<?php echo $oBookingDocForm['file_name']->renderLabel($oBookingDocForm['file_name']->renderLabelName()."<span class='redText'>*</span>");?>
								</td>
							
								<td valign="middle" width="80%">
									<?php 
										if($oBookingDocForm['file_name']->hasError()):
											echo $oBookingDocForm['file_name']->renderError();
										endif;
										echo $oBookingDocForm['file_name']->render(array('class'=>'inputBoxWidth')); 
									?>
								</td>
							</tr>
							<tr>
								<td valign="middle" align="right" width="20%">
								<?php $ssIsMandatory = ($oBookingDocForm->getObject()->isNew()) ? "<span class='redText'>*</span>" : '';
									echo $oBookingDocForm['file_path']->renderLabel($oBookingDocForm['file_path']->renderLabelName().$ssIsMandatory);?>
								</td>
							
								<td valign="middle" width="80%">
									<?php 
										if($oBookingDocForm['file_path']->hasError()):
											echo $oBookingDocForm['file_path']->renderError();
										endif;
										echo $oBookingDocForm['file_path']->render(array('class'=>'inputBoxWidth')); 
									?>
								</td>
							</tr> 
							<tr>
								<td valign="middle" align="right" width="20%">
								<?php echo $oBookingDocForm['file_description']->renderLabel($oBookingDocForm['file_description']->renderLabelName());?>
								</td>
							
								<td valign="middle" width="80%">
									<?php 
										if($oBookingDocForm['file_description']->hasError()):
											echo $oBookingDocForm['file_description']->renderError();
										endif;
										echo $oBookingDocForm['file_description']->render(array('class'=>'inputBoxWidth')); 
									?>
								</td>
							</tr>
							<tr>
								<td valign="middle" align="right" width="20%">
								<?php echo $oBookingDocForm['expiry_date']->renderLabel($oBookingDocForm['expiry_date']->renderLabelName());?>
								</td>
							
								<td valign="middle" width="80%">
									<?php 
										if($oBookingDocForm['expiry_date']->hasError()):
											echo $oBookingDocForm['expiry_date']->renderError();
										endif;
										echo $oBookingDocForm['expiry_date']->render(array('class'=>'inputBoxWidth')); 
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
														$ssCancelUrl    = $sf_params->get('module').'/index?'.html_entity_decode($amExtraParameters['ssQuerystr']);
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
		echo input_hidden_tag('booking_id', $snBookingId, array('readonly' => 'true'));
		echo input_hidden_tag('type', $sf_params->get('type'), array('readonly' => 'true'));
        echo $oBookingDocForm->renderHiddenFields(); 
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