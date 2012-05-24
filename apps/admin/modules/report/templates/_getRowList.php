<div id="reports_row_list">
<?php echo select_tag('reports_ar_row_id', options_for_select($asRowList , isset($snRowId) ? $snRowId : '', 'include_custom='.__('Select Row')),
		array('tabindex'=>5,'onChange' => jq_remote_function(
							array('url'		=> url_for('report/getPlotListAsPerRow'),
								  'update'	=> 'reports_plot_list',
								  'with'	=> "'row_id='+this.value+'&country_id='+$('#reports_country_id').val()+'&cemetery_id='+$('#reports_cem_cemetery_id').val()+'&area_id='+$('#reports_ar_area_id').val()+'&section_id='+$('#reports_ar_section_id').val()",
								  'loading' => '$("#IdAjaxLocaderPlot").show();',
								  'complete'=> '$("#IdAjaxLocaderPlot").hide();'
								  ))
			));

	echo '<span id="IdAjaxLocaderRow" style="display:none;">'.image_tag('admin/ajaxLoader.gif').'</span>';				
?>
</div>
