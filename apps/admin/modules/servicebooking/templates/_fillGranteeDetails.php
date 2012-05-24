<table width="100%" cellpadding="0" cellspacing="0" border="0">
<tr>
	<td valign="middle" align="right" width="20%">
		<?php echo __('Grantee');?>
	</td>
	<td>
		<?php 
			echo select_tag('service_grantee_id', options_for_select($amGranteeDetails , ( isset($snGranteeId) ? $snGranteeId : ''), 'include_custom='.__('Select Grantee')),
						array('tabindex'=>41, 'onChange' => 'showHideGranteeComment();'.jq_remote_function(
															array('url'		=> url_for('servicebooking/fillGranteeRemarks'),
																  'update'	=> 'service_grantee_remarks_list',
																  'with'	=> "'grantee_id='+this.value",
																  'loading' => '$("#IdAjaxLocaderGranteeRemarks1").show();$("#IdAjaxLocaderGranteeRemarks2").show();',
																  'complete'=> '$("#IdAjaxLocaderGranteeRemarks1").hide();$("#IdAjaxLocaderGranteeRemarks2").hide();'))
							));

			echo '<span id="IdAjaxLocaderGrantee" style="display:none;">'.image_tag('admin/ajaxLoader.gif').'</span>';			
		?>
	</td>
	<td valign="middle" align="right" width="20%">
		<?php echo __('Relationship');?>
	</td>
	<td>
		<?php echo input_tag('service_grantee_relationship',isset($ssGranteeRelationShip) ? $ssGranteeRelationShip : '',array('tabindex'=> 42,'class'=>'inputBoxWidth'));?>
	</td>
</tr>
</table>
<?php echo javascript_tag("
	jQuery(document).ready(function()
	{
		showHideGranteeComment();
	});
	function showHideGranteeComment()
	{
		if( $('#service_grantee_id').val() != '')
			$('#grantee_comments').show();
		else
			$('#grantee_comments').hide();
	}
");
?>