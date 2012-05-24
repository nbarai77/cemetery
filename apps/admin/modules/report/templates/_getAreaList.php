<div id="reports_area_list">
<?php echo select_tag('reports_ar_area_id', options_for_select($asAreaList , isset($snAreaId) ? $snAreaId : '', 'include_custom='.__('Select Area')),
			array('tabindex'=>3,'onChange' => jq_remote_function(
								array('url'		=> url_for('report/getSectionListAsPerArea'),
									  'update'	=> 'reports_section_list',
									  'with'	=> "'area_id='+this.value+'&country_id='+$('#reports_country_id').val()+'&cemetery_id='+$('#reports_cem_cemetery_id').val()",
									  'loading' => '$("#IdAjaxLocaderSection").show();',
									  'complete'=> '$("#IdAjaxLocaderSection").hide();'.jq_remote_function(
													array('url'		=> url_for('report/getRowListAsPerSection'),
														  'update'	=> 'reports_row_list',
														  'with'	=> "'area_id='+$('#reports_ar_area_id').val()+'&country_id='+$('#reports_country_id').val()+'&cemetery_id='+$('#reports_cem_cemetery_id').val()",
														  'loading' => '$("#IdAjaxLocaderRow").show();',
														  'complete'=> '$("#IdAjaxLocaderRow").hide();'.jq_remote_function(
																		array('url'		=> url_for('report/getPlotListAsPerRow'),
																			  'update'	=> 'reports_plot_list',
																			  'with'	=> "'area_id='+$('#reports_ar_area_id').val()+'&country_id='+$('#reports_country_id').val()+'&cemetery_id='+$('#reports_cem_cemetery_id').val()",
																			  'loading' => '$("#IdAjaxLocaderPlot").show();',
																			  'complete'=> '$("#IdAjaxLocaderPlot").hide();'
																			))
													))
								))
				));

	echo '<span id="IdAjaxLocaderArea" style="display:none;">'.image_tag('admin/ajaxLoader.gif').'</span>';	
?>
</div>
