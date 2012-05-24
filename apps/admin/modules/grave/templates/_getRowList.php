<div id="grave_row_list">
<?php echo select_tag('grave_ar_row_id', options_for_select($asRowList , isset($snRowId) ? $snRowId : '', 'include_custom='.__('Select Row')),
		array('tabindex'=> 5,'onChange' => jq_remote_function(
							array('url'		=> url_for('grave/getPlotListAsPerRow'),
								  'update'	=> 'grave_plot_list',
								  'with'	=> "'row_id='+this.value+'&country_id='+$('#grave_country_id').val()+'&cemetery_id='+$('#grave_cem_cemetery_id').val()+'&area_id='+$('#grave_ar_area_id').val()+'&section_id='+$('#grave_ar_section_id').val()",
								  'loading' => '$("#IdAjaxLocaderPlot").show();',
								  'complete'=> '$("#IdAjaxLocaderPlot").hide();'))
			)); 

	echo '<span id="IdAjaxLocaderRow" style="display:none;">'.image_tag('admin/ajaxLoader.gif').'</span>';			
?>
</div>
