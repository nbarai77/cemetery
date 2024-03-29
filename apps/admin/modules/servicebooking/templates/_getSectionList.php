<div id="service_section_list">
<?php echo select_tag('service_ar_section_id', options_for_select($asSectionList , isset($snSectionId) ? $snSectionId : '', 'include_custom='.__('Select Section')),
			array('tabindex'=>26,'onChange' => 'showHideGraveComment();'.jq_remote_function(
								array('url'		=> url_for('servicebooking/getRowListAsPerSection'),
									  'update'	=> 'service_row_list',
									  'with'	=> "'section_id='+this.value+'&country_id='+$('#service_country_id').val()+'&cemetery_id='+$('#service_cem_cemetery_id').val()+'&area_id='+$('#service_ar_area_id').val()",
									  'loading' => '$("#IdAjaxLocaderRow").show();',
									  'complete'=> '$("#IdAjaxLocaderRow").hide();'.jq_remote_function(
													array('url'		=> url_for('servicebooking/getPlotListAsPerRow'),
														  'update'	=> 'service_plot_list',
														  'with'	=> "'section_id='+$('#service_ar_section_id').val()+'&country_id='+$('#service_country_id').val()+'&cemetery_id='+$('#service_cem_cemetery_id').val()+'&area_id='+$('#service_ar_area_id').val()",
														  'loading' => '$("#IdAjaxLocaderPlot").show();',
														  'complete'=> '$("#IdAjaxLocaderPlot").hide();'.jq_remote_function(
																		array('url'		=> url_for('servicebooking/getGraveListAsPerPlot'),
																			  'update'	=> 'service_grave_list',
																			  'with'	=> "'section_id='+$('#service_ar_section_id').val()+'&country_id='+$('#service_country_id').val()+'&cemetery_id='+$('#service_cem_cemetery_id').val()+'&area_id='+$('#service_ar_area_id').val()",
																			  'loading' => '$("#IdAjaxLocaderGrave").show();',
																			  'complete'=> '$("#IdAjaxLocaderGrave").hide();'))
													))
								))
				)); 
				
	echo '<span id="IdAjaxLocaderSection" style="display:none;">'.image_tag('admin/ajaxLoader.gif').'</span>';
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