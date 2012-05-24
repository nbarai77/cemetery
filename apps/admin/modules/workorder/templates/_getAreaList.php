<div id="workorder_area_list">
<?php echo select_tag('workorder_ar_area_id', options_for_select($asAreaList , isset($snAreaId) ? $snAreaId : '', 'include_custom='.__('Select Area')),
			array('tabindex'=>10,'onChange' => jq_remote_function(
								array('url'		=> url_for('workorder/getSectionListAsPerArea'),
									  'update'	=> 'workorder_section_list',
									  'with'	=> "'area_id='+this.value+'&country_id='+$('#workorder_country_id').val()+'&cemetery_id='+$('#workorder_cem_cemetery_id').val()",
									  'loading' => '$("#IdAjaxLocaderSection").show();',
									  'complete'=> '$("#IdAjaxLocaderSection").hide();'.jq_remote_function(
													array('url'		=> url_for('workorder/getRowListAsPerSection'),
														  'update'	=> 'workorder_row_list',
														  'with'	=> "'area_id='+$('#workorder_ar_area_id').val()+'&country_id='+$('#workorder_country_id').val()+'&cemetery_id='+$('#workorder_cem_cemetery_id').val()",
														  'loading' => '$("#IdAjaxLocaderRow").show();',
														  'complete'=> '$("#IdAjaxLocaderRow").hide();'.jq_remote_function(
																		array('url'		=> url_for('workorder/getPlotListAsPerRow'),
																			  'update'	=> 'workorder_plot_list',
																			  'with'	=> "'area_id='+$('#workorder_ar_area_id').val()+'&country_id='+$('#workorder_country_id').val()+'&cemetery_id='+$('#workorder_cem_cemetery_id').val()",
																			  'loading' => '$("#IdAjaxLocaderPlot").show();',
																			  'complete'=> '$("#IdAjaxLocaderPlot").hide();'.jq_remote_function(
																							array('url'		=> url_for('workorder/getGraveListAsPerPlot'),
																								  'update'	=> 'workorder_grave_list',
																								  'with'	=> "'area_id='+$('#workorder_ar_area_id').val()+'&country_id='+$('#workorder_country_id').val()+'&cemetery_id='+$('#workorder_cem_cemetery_id').val()",
																								  'loading' => '$("#IdAjaxLocaderGrave").show();',
																								  'complete'=> '$("#IdAjaxLocaderGrave").hide();'))
																			))
													))
								))
				)); 

	echo '<span id="IdAjaxLocaderArea" style="display:none;">'.image_tag('admin/ajaxLoader.gif').'</span>';					
?>
</div>
