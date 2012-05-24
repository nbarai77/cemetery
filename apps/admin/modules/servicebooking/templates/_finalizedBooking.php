<table width="100%" border="0" cellspacing="0" cellpadding="12" class="sub_table">
	<tr>
		<td valign="middle" align="right" width="20%">
			<?php echo $oFinalizedBookingForm['control_number']->renderLabel($oFinalizedBookingForm['control_number']->renderLabelName()."<span class='redText'>*</span>");?>
		</td>
		<td valign="middle" width="80%"> 
			<?php 
				if($oFinalizedBookingForm['control_number']->hasError()):
					echo $oFinalizedBookingForm['control_number']->renderError();
				endif;
				echo $oFinalizedBookingForm['control_number']->render(array('value' => $ssControlNumber));
			?>
		</td>
	</tr
	><tr>
		<td valign="middle" align="right" width="20%">
			<?php echo $oFinalizedBookingForm['interment_date']->renderLabel($oFinalizedBookingForm['interment_date']->renderLabelName());?>
		</td>
		<td valign="middle" width="80%"> <?php echo $oFinalizedBookingForm['interment_date']->render();?></td>
	</tr>                        
	<tr>
		<td>&nbsp;</td>
		<td valign="middle">
			<div class="actions"  style="margin-left:10px;">
				<ul class="fleft">
					<li class="list1">
						<span>
							<?php 
								echo submit_tag(
									__('Save'), 
									array(
										'class'     => 'delete',
										'name'      => 'submit_button',
										'title'     => __('Save'), 
										'tabindex'  => 3,
										'onclick'   => "jQuery('#is_finalise').val('1');",
										'confirm'  => __('Are you sure?')
									)
								);
							?>
						</span>
					</li>
					<li class="list1">
						<span>
							<?php echo link_to_function(__('Cancel'),"javascript:void(0);",array('class'=>'delete','title'=>__('Cancel'),'alt'=>__('Cancel'),'tabindex'=>4,'class'=> 'nyroModalClose'));?>
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