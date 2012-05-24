<div id="workorder_plot_list">
<?php echo select_tag('workorder_ar_plot_id', options_for_select($asPlotList , isset($snPlotId) ? $snPlotId : '', 'include_custom='.__('Select Plot')),
			array('tabindex'=>13,'onChange' => jq_remote_function(
						array('url'		=> url_for('workorder/getGraveListAsPerPlot'),
							  'update'	=> 'workorder_grave_list',
							  'with'	=> "'plot_id='+this.value+'&country_id='+$('#workorder_country_id').val()+'&cemetery_id='+$('#workorder_cem_cemetery_id').val()+'&area_id='+$('#workorder_ar_area_id').val()+'&section_id='+$('#workorder_ar_section_id').val()+'&row_id='+$('#workorder_ar_row_id').val()",
							  'loading' => '$("#IdAjaxLocaderGrave").show();',
							  'complete'=> '$("#IdAjaxLocaderGrave").hide();'))
		)); 

	echo '<span id="IdAjaxLocaderPlot" style="display:none;">'.image_tag('admin/ajaxLoader.gif').'</span>';		
?>
</div>
