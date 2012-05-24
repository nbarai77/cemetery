<div id="workorder_row_list">
<?php echo select_tag('workorder_ar_row_id', options_for_select($asRowList , isset($snRowId) ? $snRowId : '', 'include_custom='.__('Select Row')),
		array('tabindex'=>12,'onChange' => jq_remote_function(
							array('url'		=> url_for('workorder/getPlotListAsPerRow'),
								  'update'	=> 'workorder_plot_list',
								  'with'	=> "'row_id='+this.value+'&country_id='+$('#workorder_country_id').val()+'&cemetery_id='+$('#workorder_cem_cemetery_id').val()+'&area_id='+$('#workorder_ar_area_id').val()+'&section_id='+$('#workorder_ar_section_id').val()",
								  'loading' => '$("#IdAjaxLocaderPlot").show();',
								  'complete'=> '$("#IdAjaxLocaderPlot").hide();'.jq_remote_function(
												array('url'		=> url_for('workorder/getGraveListAsPerPlot'),
													  'update'	=> 'workorder_grave_list',
													  'with'	=> "'row_id='+$('#workorder_ar_row_id').val()+'&country_id='+$('#workorder_country_id').val()+'&cemetery_id='+$('#workorder_cem_cemetery_id').val()+'&area_id='+$('#workorder_ar_area_id').val()+'&section_id='+$('#workorder_ar_section_id').val()",
													  'loading' => '$("#IdAjaxLocaderGrave").show();',
													  'complete'=> '$("#IdAjaxLocaderGrave").hide();'))
								  ))
			)); 

	echo '<span id="IdAjaxLocaderRow" style="display:none;">'.image_tag('admin/ajaxLoader.gif').'</span>';			
?>
</div>
