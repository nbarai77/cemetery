<div id="service_cementery_list">
<?php echo select_tag('service_cem_cemetery_id', options_for_select($asCementery , isset($snCementeryId) ? $snCementeryId : '', 'include_custom='.__('Select Cementery')),
			array('tabindex'=>24,
				  'onChange' => 'showHideGraveComment();'.jq_remote_function(
					array('url'		=> url_for('servicebooking/getAreaListAsPerCemetery'),
						  'update'	=> 'service_area_list',
						  'with'	=> "'cemetery_id='+this.value+'&country_id='+$('#service_country_id').val()",
						  'loading' => '$("#IdAjaxLocaderArea").show();',
						  'complete'=> '$("#IdAjaxLocaderArea").hide();'.jq_remote_function(
										array('url'		=> url_for('servicebooking/getSectionListAsPerArea'),
											  'update'	=> 'service_section_list',
											  'with'	=> "'country_id='+$('#service_country_id').val()+'&cemetery_id='+$('#service_cem_cemetery_id').val()",
											  'loading' => '$("#IdAjaxLocaderSection").show();',
											  'complete'=> '$("#IdAjaxLocaderSection").hide();'.jq_remote_function(
														array('url'		=> url_for('servicebooking/getRowListAsPerSection'),
															  'update'	=> 'service_row_list',
															  'with'	=> "'country_id='+$('#service_country_id').val()+'&cemetery_id='+$('#service_cem_cemetery_id').val()",
															  'loading' => '$("#IdAjaxLocaderRow").show();',
															  'complete'=> '$("#IdAjaxLocaderRow").hide();'.jq_remote_function(
																			array('url'		=> url_for('servicebooking/getPlotListAsPerRow'),
																				  'update'	=> 'service_plot_list',
																				  'with'	=> "'country_id='+$('#service_country_id').val()+'&cemetery_id='+$('#service_cem_cemetery_id').val()",
																				  'loading' => '$("#IdAjaxLocaderPlot").show();',
																				  'complete'=> '$("#IdAjaxLocaderPlot").hide();'.jq_remote_function(
																								array('url'		=> url_for('servicebooking/getGraveListAsPerPlot'),
																									  'update'	=> 'service_grave_list',
																									  'with'	=> "'country_id='+$('#service_country_id').val()+'&cemetery_id='+$('#service_cem_cemetery_id').val()",
																									  'loading' => '$("#IdAjaxLocaderGrave").show();',
																									  'complete'=> jq_remote_function(
																													array('url'		=> url_for('facilitybooking/getChapelTypeLists'),
																														  'update'	=> 'upd_chapel_type_div',
																														  'with'	=> "'cemetery_id='+$('#service_cem_cemetery_id').val()",
																														  'loading' => '',
																														  'complete'=> jq_remote_function(
																																array('url'		=> url_for('facilitybooking/getRoomTypeLists'),
																																	  'update'	=> 'upd_room_type_div',
																																	  'with'	=> "'cemetery_id='+$('#service_cem_cemetery_id').val()",
																																	  'loading' => '',
																																	  'complete'=> ''))
																													))
																									))
																			))
														))
										))
					))
			)); 

	echo '<span id="IdAjaxLocaderCemetery" style="display:none;">'.image_tag('admin/ajaxLoader.gif').'</span>';
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