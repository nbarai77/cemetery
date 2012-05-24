<table width="100%" cellpadding="0" cellspacing="0" border="0">
<tr id="grantee_comments">
	<td valign="middle" align="right" width="20%">
		<?php echo __('Remarks 1');?>
	</td>
	<td>
		<?php 
			echo textarea_tag('service_grantee_remarks_1', ( isset($omGranteeDetails) && !empty($omGranteeDetails) ) ? $omGranteeDetails->getremarks_1() : ( isset($ssGranteeRemarks1) ? $ssGranteeRemarks1 : ''),array('size' => '5x2', 'tabindex'=> 43));
			echo '<span id="IdAjaxLocaderGranteeRemarks1" style="display:none;">'.image_tag('admin/ajaxLoader.gif').'</span>';
		?>
	</td>
	<td valign="middle" align="right" width="20%">
		<?php echo __('Remarks 2');?>
	</td>
	<td>
		<?php 
			echo textarea_tag('service_grantee_remarks_2', (isset($omGranteeDetails) && !empty($omGranteeDetails) ) ? $omGranteeDetails->getremarks_2() : (isset($ssGranteeRemarks2) ? $ssGranteeRemarks2 : ''),array('size' => '5x2', 'tabindex'=> 44));
			echo '<span id="IdAjaxLocaderGranteeRemarks2" style="display:none;">'.image_tag('admin/ajaxLoader.gif').'</span>';
		?>
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