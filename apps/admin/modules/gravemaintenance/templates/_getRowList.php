<div id="gravemaintenance_row_list">
<?php echo select_tag('gravemaintenance_ar_row_id', options_for_select($asRowList , isset($snRowId) ? $snRowId : '', 'include_custom='.__('Select Row')),
		array('tabindex'=>5,'onChange' => jq_remote_function(
							array('url'		=> url_for('gravemaintenance/getPlotListAsPerRow'),
								  'update'	=> 'gravemaintenance_plot_list',
								  'with'	=> "'row_id='+this.value+'&country_id='+$('#gravemaintenance_country_id').val()+'&cemetery_id='+$('#gravemaintenance_cem_cemetery_id').val()+'&area_id='+$('#gravemaintenance_ar_area_id').val()+'&section_id='+$('#gravemaintenance_ar_section_id').val()",
								  'loading' => '$("#IdAjaxLocaderPlot").show();',
								  'complete'=> '$("#IdAjaxLocaderPlot").hide();'.jq_remote_function(
													array('url'		=> url_for('gravemaintenance/getGraveListAsPerPlot'),
														  'update'	=> 'gravemaintenance_grave_list',
														  'with'	=> "'row_id='+$('#gravemaintenance_ar_row_id').val()+'&country_id='+$('#gravemaintenance_country_id').val()+'&cemetery_id='+$('#gravemaintenance_cem_cemetery_id').val()+'&area_id='+$('#gravemaintenance_ar_area_id').val()+'&section_id='+$('#gravemaintenance_ar_section_id').val()",
														  'loading' => '$("#IdAjaxLocaderGrave").show();',
														  'complete'=> '$("#IdAjaxLocaderGrave").hide();'))
								  ))
			)); 

	echo '<span id="IdAjaxLocaderRow" style="display:none;">'.image_tag('admin/ajaxLoader.gif').'</span>';			
?>
</div>
