<div id="interment_row_list">
<?php echo select_tag('interment_ar_row_id', options_for_select($asRowList , isset($snRowId) ? $snRowId : '', 'include_custom='.__('Select Row')),
		array('tabindex'=>5,'onChange' => jq_remote_function(
							array('url'		=> url_for('intermentsearch/getPlotListAsPerRow'),
								  'update'	=> 'interment_plot_list',
								  'with'	=> "'row_id='+this.value+'&country_id='+$('#interment_country_id').val()+'&cemetery_id='+$('#interment_cem_cemetery_id').val()+'&area_id='+$('#interment_ar_area_id').val()+'&section_id='+$('#interment_ar_section_id').val()",
								  'loading' => '$("#IdAjaxLocaderPlot").show();',
								  'complete'=> '$("#IdAjaxLocaderPlot").hide();'.jq_remote_function(
												array('url'		=> url_for('intermentsearch/getGraveListAsPerPlot'),
													  'update'	=> 'interment_grave_list',
													  'with'	=> "'row_id='+$('#interment_ar_row_id').val()+'&country_id='+$('#interment_country_id').val()+'&cemetery_id='+$('#interment_cem_cemetery_id').val()+'&area_id='+$('#interment_ar_area_id').val()+'&section_id='+$('#interment_ar_section_id').val()",
													  'loading' => '$("#IdAjaxLocaderGrave").show();',
													  'complete'=> '$("#IdAjaxLocaderGrave").hide();'))
								  ))
			)); 

	echo '<span id="IdAjaxLocaderRow" style="display:none;">'.image_tag('admin/ajaxLoader.gif').'</span>';			
?>
</div>
