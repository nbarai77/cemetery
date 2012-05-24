<div id="workorder_section_list">
<?php echo select_tag('workorder_ar_section_id', options_for_select($asSectionList , isset($snSectionId) ? $snSectionId : '', 'include_custom='.__('Select Section')),
			array('tabindex'=>11,'onChange' => jq_remote_function(
								array('url'		=> url_for('workorder/getRowListAsPerSection'),
									  'update'	=> 'workorder_row_list',
									  'with'	=> "'section_id='+this.value+'&country_id='+$('#workorder_country_id').val()+'&cemetery_id='+$('#workorder_cem_cemetery_id').val()+'&area_id='+$('#workorder_ar_area_id').val()",
									  'loading' => '$("#IdAjaxLocaderRow").show();',
									  'complete'=> '$("#IdAjaxLocaderRow").hide();'.jq_remote_function(
													array('url'		=> url_for('workorder/getPlotListAsPerRow'),
														  'update'	=> 'workorder_plot_list',
														  'with'	=> "'section_id='+$('#workorder_ar_section_id').val()+'&country_id='+$('#workorder_country_id').val()+'&cemetery_id='+$('#workorder_cem_cemetery_id').val()+'&area_id='+$('#workorder_ar_area_id').val()",
														  'loading' => '$("#IdAjaxLocaderPlot").show();',
														  'complete'=> '$("#IdAjaxLocaderPlot").hide();'.jq_remote_function(
																		array('url'		=> url_for('workorder/getGraveListAsPerPlot'),
																			  'update'	=> 'workorder_grave_list',
																			  'with'	=> "'country_id='+$('#workorder_country_id').val()+'&cemetery_id='+$('#workorder_cem_cemetery_id').val()+'&section_id='+$('#workorder_ar_section_id').val()+'&area_id='+$('#workorder_ar_area_id').val()",
																			  'loading' => '$("#IdAjaxLocaderGrave").show();',
																			  'complete'=> '$("#IdAjaxLocaderGrave").hide();'
																			 ))
										))
								))
				)); 

	echo '<span id="IdAjaxLocaderSection" style="display:none;">'.image_tag('admin/ajaxLoader.gif').'</span>';				
?>
</div>

