<div id="reports_cemetery_list">
<?php echo select_tag('reports_cem_cemetery_id', options_for_select($asCementryList , isset($snCementeryId) ? $snCementeryId : '', 'include_custom='.__('Select Cementery')),
			array('tabindex'=>2,'onChange' => jq_remote_function(
								array('url'		=> url_for('report/getAreaListAsPerCemetery'),
									  'update'	=> 'reports_area_list',
									  'with'	=> "'cemetery_id='+this.value+'&country_id='+$('#reports_country_id').val()",
									  'loading' => '$("#IdAjaxLocaderArea").show();',
									  'complete'=> '$("#IdAjaxLocaderArea").hide();'.jq_remote_function(
													array('url'		=> url_for('report/getSectionListAsPerArea'),
														  'update'	=> 'reports_section_list',
														  'with'	=> "'country_id='+$('#reports_country_id').val()+'&cemetery_id='+$('#reports_cem_cemetery_id').val()",
														  'loading' => '$("#IdAjaxLocaderSection").show();',
														  'complete'=> '$("#IdAjaxLocaderSection").hide();'.jq_remote_function(
																	array('url'		=> url_for('report/getRowListAsPerSection'),
																		  'update'	=> 'reports_row_list',
																		  'with'	=> "'country_id='+$('#reports_country_id').val()+'&cemetery_id='+$('#reports_cem_cemetery_id').val()",
																		  'loading' => '$("#IdAjaxLocaderRow").show();',
																		  'complete'=> '$("#IdAjaxLocaderRow").hide();'.jq_remote_function(
																						array('url'		=> url_for('report/getPlotListAsPerRow'),
																							  'update'	=> 'reports_plot_list',
																							  'with'	=> "'country_id='+$('#reports_country_id').val()+'&cemetery_id='+$('#reports_cem_cemetery_id').val()",
																							  'loading' => '$("#IdAjaxLocaderPlot").show();',
																							  'complete'=> '$("#IdAjaxLocaderPlot").hide();'
																						))
																	))
													))
								))
				)); 

	echo '<span id="IdAjaxLocaderCemetery" style="display:none;">'.image_tag('admin/ajaxLoader.gif').'</span>';					
?>
</div>
