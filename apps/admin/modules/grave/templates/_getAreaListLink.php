<div id="grave_area_list">
<?php echo select_tag('grave_ar_area_id', options_for_select($asAreaList , isset($snAreaId) ? $snAreaId : '', 'include_custom='.__('Select Area')),
			array('tabindex'=>3,'onChange' => jq_remote_function(
								array('url'		=> url_for('grave/getSectionListAsPerArea?render_partial=getSectionListLink'),
									  'update'	=> 'grave_section_list',
									  'with'	=> "'area_id='+this.value+'&country_id='+$('#grave_country_id').val()+'&cemetery_id='+$('#grave_cem_cemetery_id').val()",
									  'loading' => '$("#IdAjaxLocaderSection").show();',
									  'complete'=> '$("#IdAjaxLocaderSection").hide();'.jq_remote_function(
													array('url'		=> url_for('grave/getRowListAsPerSection?render_partial=getRowListLink'),
														  'update'	=> 'grave_row_list',
														  'with'	=> "'area_id='+$('#grave_ar_area_id').val()+'&country_id='+$('#grave_country_id').val()+'&cemetery_id='+$('#grave_cem_cemetery_id').val()",
														  'loading' => '$("#IdAjaxLocaderRow").show();',
														  'complete'=> '$("#IdAjaxLocaderRow").hide();'.jq_remote_function(
																		array('url'		=> url_for('grave/getPlotListAsPerRow?render_partial=getPlotListLink'),
																			  'update'	=> 'grave_plot_list',
																			  'with'	=> "'area_id='+$('#grave_ar_area_id').val()+'&country_id='+$('#grave_country_id').val()+'&cemetery_id='+$('#grave_cem_cemetery_id').val()",
																			  'loading' => '$("#IdAjaxLocaderPlot").show();',
																			  'complete'=> '$("#IdAjaxLocaderPlot").hide();'.jq_remote_function(
																							array('url'		=> url_for('grave/getGraveListAsPerPlot?render_partial=getGraveListLink'),
																								  'update'	=> 'grave_list',
																								  'with'	=> "'area_id='+$('#grave_ar_area_id').val()+'&country_id='+$('#grave_country_id').val()+'&cemetery_id='+$('#grave_cem_cemetery_id').val()",
																								  'loading' => '$("#IdAjaxLocaderGrave").show();',
																								  'complete'=> '$("#IdAjaxLocaderGrave").hide();'))
																		))
													))
								))
				)); 

	echo '<span id="IdAjaxLocaderArea" style="display:none;">'.image_tag('admin/ajaxLoader.gif').'</span>';
?>
</div>
