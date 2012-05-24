<div id="grave_section_list">
<?php echo select_tag('grave_ar_section_id', options_for_select($asSectionList , isset($snSectionId) ? $snSectionId : '', 'include_custom='.__('Select Section')),
			array('tabindex'=>4,'onChange' => jq_remote_function(
								array('url'		=> url_for('grave/getRowListAsPerSection?render_partial=getRowListLink'),
									  'update'	=> 'grave_row_list',
									  'with'	=> "'section_id='+this.value+'&country_id='+$('#grave_country_id').val()+'&cemetery_id='+$('#grave_cem_cemetery_id').val()+'&area_id='+$('#grave_ar_area_id').val()",
									  'loading' => '$("#IdAjaxLocaderSection").show();',
									  'complete'=> '$("#IdAjaxLocaderSection").hide();'.jq_remote_function(
													array('url'		=> url_for('grave/getPlotListAsPerRow?render_partial=getPlotListLink'),
														  'update'	=> 'grave_plot_list',
														  'with'	=> "'section_id='+$('#grave_ar_section_id').val()+'&country_id='+$('#grave_country_id').val()+'&cemetery_id='+$('#grave_cem_cemetery_id').val()+'&area_id='+$('#grave_ar_area_id').val()",
														  'loading' => '$("#IdAjaxLocaderPlot").show();',
														  'complete'=> '$("#IdAjaxLocaderPlot").hide();'.jq_remote_function(
																		array('url'		=> url_for('grave/getGraveListAsPerPlot?render_partial=getGraveListLink'),
																			  'update'	=> 'grave_list',
																			  'with'	=> "'section_id='+$('#grave_ar_section_id').val()+'&country_id='+$('#grave_country_id').val()+'&cemetery_id='+$('#grave_cem_cemetery_id').val()+'&area_id='+$('#grave_ar_area_id').val()",
																			  'loading' => '$("#IdAjaxLocaderGrave").show();',
																			  'complete'=> '$("#IdAjaxLocaderGrave").hide();'))
														  
														  ))
								))
				)); 
	echo '<span id="IdAjaxLocaderSection" style="display:none;">'.image_tag('admin/ajaxLoader.gif').'</span>';				
	?>
</div>
