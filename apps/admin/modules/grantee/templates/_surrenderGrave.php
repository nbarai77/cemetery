<table width="100%" border="0" cellspacing="0" cellpadding="12" class="sub_table">
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
		<td valign="middle" align="right" width="20%">
			<?php echo $oSurrenderdGraveForm['transfer_date']->renderLabel();?>
		</td>
		<td valign="middle" width="80%">
			<?php echo $oSurrenderdGraveForm['transfer_date']->render(array('class'=>'inputBoxWidth')); ?>
		</td>
	</tr>
	<?php /*<tr>
		<td valign="middle" align="right" width="20%">
			<?php echo $oSurrenderdGraveForm['transfer_cost']->renderLabel($oSurrenderdGraveForm['transfer_cost']->renderLabelName()."&nbsp;&nbsp;$");?>
		</td>
		<td valign="middle" width="80%">
			<?php echo $oSurrenderdGraveForm['transfer_cost']->render(array('class'=>'inputBoxWidth')); ?>
		</td>
	</tr> */ ?>
    <tr>
		<td valign="middle" align="right" width="20%">
			<?php echo $oSurrenderdGraveForm['catalog_id']->renderLabel($oSurrenderdGraveForm['catalog_id']->renderLabelName());?>
		</td>
		<td valign="middle" width="80%">
			<?php echo $oSurrenderdGraveForm['catalog_id']->render(array('class'=>'inputBoxWidth')); ?>
		</td>
	</tr>    
    <tr>
		<td valign="middle" align="right" width="20%">
			<?php echo $oSurrenderdGraveForm['payment_id']->renderLabel($oSurrenderdGraveForm['payment_id']->renderLabelName());?>
		</td>
		<td valign="middle" width="80%">
			<?php echo $oSurrenderdGraveForm['payment_id']->render(array('class'=>'inputBoxWidth')); ?>
		</td>
	</tr> 
	<tr>
		<td valign="middle" align="right" width="20%">
			<?php echo $oSurrenderdGraveForm['grantee_identity_id']->renderLabel();?>
		</td>
		<td valign="middle" width="80%">
			<?php echo $oSurrenderdGraveForm['grantee_identity_id']->render(array('class'=>'inputBoxWidth')); ?>
		</td>
	</tr>
	<tr>
		<td valign="middle" align="right" width="20%">
			<?php echo $oSurrenderdGraveForm['grantee_identity_number']->renderLabel();?>
		</td>
		<td valign="middle" width="80%">
			<?php echo $oSurrenderdGraveForm['grantee_identity_number']->render(array('class'=>'inputBoxWidth')); ?>
		</td>
	</tr>
	<tr>
		<td valign="middle" align="right" width="20%">
			<?php echo $oSurrenderdGraveForm['receipt_number']->renderLabel();?>
		</td>
		<td valign="middle" width="80%">
			<?php echo $oSurrenderdGraveForm['receipt_number']->render(array('class'=>'inputBoxWidth')); ?>
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
										'tabindex'  => 7,
										'onclick'   => "jQuery('#tab').val('');"
									)
								);
							?>
						</span>
					</li>
					<li class="list1">
						<span>
							<?php  
							
							if($snGraveId != '') {
								$ssCancelUrl = 'grave/showGrantees/?grave_id='.$snGraveId;
							}else {
								$ssCancelUrl    = $sf_params->get('module').'/index?grantee_id='.$snIdGranteeDetailId.'&'.html_entity_decode($amExtraParameters['ssQuerystr']);
							}
								echo button_to(__('Cancel'),$ssCancelUrl,array('class'=>'delete','title'=>__('Cancel'),'alt'=>__('Cancel'),'tabindex'=>8));
							?>
						</span>
					</li>
				</ul>
			</div>
		</td>
	</tr>
</table>
<?php
    echo javascript_tag("
        jQuery(document).ready(function() 
            {
				$('table').find('tr:visible:odd').addClass('even').end().find('tr:visible:even').addClass('odd');
                
            });
    ");
?>