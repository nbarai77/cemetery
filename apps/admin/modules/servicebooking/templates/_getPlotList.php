<div id="service_plot_list">
	<?php echo select_tag('service_ar_plot_id', options_for_select($asPlotList , isset($snPlotId) ? $snPlotId : '', 'include_custom='.__('Select Plot')),
				array('tabindex'=>28,'onChange' => 'showHideGraveComment();'.jq_remote_function(
							array('url'		=> url_for('servicebooking/getGraveListAsPerPlot'),
								  'update'	=> 'service_grave_list',
								  'with'	=> "'plot_id='+this.value+'&country_id='+$('#service_country_id').val()+'&cemetery_id='+$('#service_cem_cemetery_id').val()+'&area_id='+$('#service_ar_area_id').val()+'&section_id='+$('#service_ar_section_id').val()+'&row_id='+$('#service_ar_row_id').val()",
								  'loading' => '$("#IdAjaxLocaderGrave").show();',
								  'complete'=> '$("#IdAjaxLocaderGrave").hide();'))
			)); 

	echo '<span id="IdAjaxLocaderPlot" style="display:none;">'.image_tag('admin/ajaxLoader.gif').'</span>';				
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