<div id="service_grave_list">
	<?php echo select_tag('service_ar_grave_id', options_for_select($asGraveList , isset($snGraveId) ? $snGraveId : '', 'include_custom='.__('Select Grave')),	
				array('tabindex'=> 29,'onChange' => 'showHideGraveComment();'.jq_remote_function(
										array('url'		=> url_for('servicebooking/fillGranteeInfoAsPerGrave'),
											  'update'	=> 'service_grantee_list',
			  								  'with'	=> "'grave_id='+this.value+'&country_id='+$('#service_country_id').val()+'&cemetery_id='+$('#service_cem_cemetery_id').val()+'&area_id='+$('#service_ar_area_id').val()+'&section_id='+$('#service_ar_section_id').val()+'&row_id='+$('#service_ar_row_id').val()+'&plot_id='+$('#service_ar_plot_id').val()",
											  'loading' => '$("#IdAjaxLocaderGrantee").show();',
											  'complete'=> '$("#IdAjaxLocaderGrantee").hide();'.jq_remote_function(
															array('url'		=> url_for('servicebooking/fillGraveSizeInfo'),
																  'update'	=> 'service_grave_size_info',
																  'with'	=> "'grave_id='+$('#service_ar_grave_id').val()",
																  'loading' => '$("#IdAjaxLocaderGraveSize").show();',
																  'complete'=> '$("#IdAjaxLocaderGraveSize").hide();'
															))
											  ))
	)); 

	echo '<span id="IdAjaxLocaderGrave" style="display:none;">'.image_tag('admin/ajaxLoader.gif').'</span>';	
?>
</div>
<?php
echo javascript_tag("
jQuery(document).ready(function()
	{
		if($('#service_grave_comment1').val() == 'Comment1' || $('#service_grave_comment1').val() == '')
			jQuery('#service_grave_comment1').val('Comment1');
		
		if($('#service_grave_comment2').val() == 'Comment2' || $('#service_grave_comment2').val() == '')
			jQuery('#service_grave_comment2').val('Comment2');
			
		showHideGraveComment();
	});
");
?>
