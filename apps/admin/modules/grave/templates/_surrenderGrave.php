<table width="100%" border="0" cellspacing="12" cellpadding="0" class="sub_table">
	<tr>
		<td valign="middle" align="right" width="20%">
		<?php echo $oSurrenderdGraveForm['grantee_unique_id']->renderLabel($oSurrenderdGraveForm['grantee_unique_id']->renderLabelName()."<span class='redText'>*</span>");?>
		</td>
	
		<td valign="middle" width="80%">
			<?php 
				if($oSurrenderdGraveForm['grantee_unique_id']->hasError()):
					echo $oSurrenderdGraveForm['grantee_unique_id']->renderError();
				endif;
				if($sf_user->hasFlash('ssErrorGranteeNotExists') && $sf_user->getFlash('ssErrorGranteeNotExists') != ''):
					echo '<ul class="error_list"><li>'.$sf_user->getFlash('ssErrorGranteeNotExists').'</li></ul>';
					$sf_user->setFlash('ssErrorGranteeNotExists','');
				endif;
				if($sf_user->hasFlash('ssErrorSameGrantee') && $sf_user->getFlash('ssErrorSameGrantee') != ''):
					echo '<ul class="error_list"><li>'.$sf_user->getFlash('ssErrorSameGrantee').'</li></ul>';
					$sf_user->setFlash('ssErrorSameGrantee','');
				endif;
				echo $oSurrenderdGraveForm['grantee_unique_id']->render(array('class'=>'inputBoxWidth')); 
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
								$ssCancelUrl    = $sf_params->get('module').'/index?grantee_id='.$snIdGranteeDetailId.'&'.html_entity_decode($amExtraParameters['ssQuerystr']);
								echo button_to(__('Cancel'),$ssCancelUrl,array('class'=>'delete','title'=>__('Cancel'),'alt'=>__('Cancel'),'tabindex'=>3));
							?>
						</span>
					</li>
				</ul>
			</div>
		</td>
	</tr>
</table>