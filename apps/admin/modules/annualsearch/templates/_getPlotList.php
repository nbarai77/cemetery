<div id="annualsearch_plot_list">
	<?php echo select_tag('annualsearch_ar_plot_id', options_for_select($asPlotList , isset($snPlotId) ? $snPlotId : '', 'include_custom='.__('Select Plot')),
				array('tabindex'=>6,'onChange' => jq_remote_function(
							array('url'		=> url_for('annualsearch/getGraveListAsPerPlot'),
								  'update'	=> 'annualsearch_grave_list',
								  'with'	=> "'plot_id='+this.value+'&country_id='+$('#annualsearch_country_id').val()+'&cemetery_id='+$('#annualsearch_cem_cemetery_id').val()+'&area_id='+$('#annualsearch_ar_area_id').val()+'&section_id='+$('#annualsearch_ar_section_id').val()+'&row_id='+$('#annualsearch_ar_row_id').val()",
								  'loading' => '$("#IdAjaxLocaderGrave").show();',
								  'complete'=> '$("#IdAjaxLocaderGrave").hide();'))
			)); 

	echo '<span id="IdAjaxLocaderPlot" style="display:none;">'.image_tag('admin/ajaxLoader.gif').'</span>';			
?>
</div>
