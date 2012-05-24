<div id="grantee_plot_list">
	<?php echo select_tag('grantee_ar_plot_id', options_for_select($asPlotList , isset($snPlotId) ? $snPlotId : '', 'include_custom='.__('Select Plot')),
				array('tabindex'=>5,'onChange' => jq_remote_function(
							array('url'		=> url_for('grantee/getGraveListAsPerPlot'),
								  'update'	=> 'grantee_grave_list',
								  'with'	=> "'plot_id='+this.value+'&country_id='+$('#grantee_country_id').val()+'&cemetery_id='+$('#grantee_cem_cemetery_id').val()+'&area_id='+$('#grantee_ar_area_id').val()+'&section_id='+$('#grantee_ar_section_id').val()+'&row_id='+$('#grantee_ar_row_id').val()+'&grantee_id='+$('#grantee_id').val()",
								  'loading' => '$("#IdAjaxLocaderGrave").show();',
								  'complete'=> '$("#IdAjaxLocaderGrave").hide();'))
			)); 

	echo '<span id="IdAjaxLocaderPlot" style="display:none;">'.image_tag('admin/ajaxLoader.gif').'</span>';
?>
</div>
