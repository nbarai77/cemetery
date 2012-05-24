<div id="reports_section_list">
<?php echo select_tag('reports_ar_section_id', options_for_select($asSectionList , isset($snSectionId) ? $snSectionId : '', 'include_custom='.__('Select Section')),
			array('tabindex'=>4,'onChange' => jq_remote_function(
								array('url'		=> url_for('report/getRowListAsPerSection'),
									  'update'	=> 'reports_row_list',
									  'with'	=> "'section_id='+this.value+'&country_id='+$('#reports_country_id').val()+'&cemetery_id='+$('#reports_cem_cemetery_id').val()+'&area_id='+$('#reports_ar_area_id').val()",
									  'loading' => '$("#IdAjaxLocaderRow").show();',
									  'complete'=> '$("#IdAjaxLocaderRow").hide();'.jq_remote_function(
													array('url'		=> url_for('report/getPlotListAsPerRow'),
														  'update'	=> 'reports_plot_list',
														  'with'	=> "'section_id='+$('#reports_ar_section_id').val()+'&country_id='+$('#reports_country_id').val()+'&cemetery_id='+$('#reports_cem_cemetery_id').val()+'&area_id='+$('#reports_ar_area_id').val()",
														  'loading' => '$("#IdAjaxLocaderPlot").show();',
														  'complete'=> '$("#IdAjaxLocaderPlot").hide();'
													))
								))
				));

	echo '<span id="IdAjaxLocaderSection" style="display:none;">'.image_tag('admin/ajaxLoader.gif').'</span>';					
?>
</div>
