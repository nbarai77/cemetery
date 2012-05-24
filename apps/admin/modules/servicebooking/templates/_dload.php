<table width="100%" border="0" cellspacing="12" cellpadding="0" class="sub_table">
	<tr>
		<td valign="middle" align="right" width="20%">
			<?php //echo $oSurrenderdGraveForm['new_grantee_id']->renderLabel($oSurrenderdGraveForm['new_grantee_id']->renderLabelName()."<span class='redText'>*</span>");?>
		</td>
	
		<td valign="middle" width="80%">
			<?php 
				/*if($oSurrenderdGraveForm['new_grantee_id']->hasError()):
					echo $oSurrenderdGraveForm['new_grantee_id']->renderError();
				endif;
				echo $oSurrenderdGraveForm['new_grantee_id']->render(array('class'=>'inputBoxWidth')); */
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
									__('Assign'), 
									array(
										'class'     => 'delete',
										'name'      => 'submit_button',
										'title'     => __('Save'), 
										'tabindex'  => 2,
										'onclick'   => "jQuery('#tab').val('');"
									)
								);
							?>
						</span>
					</li>
					<li class="list1">
						<span>
							<?php  
								$ssCancelUrl    = $sf_params->get('module').'/index');
								echo button_to(__('Cancel'),$ssCancelUrl,array('class'=>'delete','title'=>__('Cancel'),'alt'=>__('Cancel'),'tabindex'=>3));
							?>
						</span>
					</li>
				</ul>
			</div>
		</td>
	</tr>
</table>
