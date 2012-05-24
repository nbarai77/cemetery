<div id="interment_area_list">
<?php echo select_tag('interment_ar_area_id', options_for_select($asAreaList , isset($snAreaId) ? $snAreaId : '', 'include_custom='.__('Select Area')),
			array('tabindex'=>3,'onChange' => jq_remote_function(
								array('url'		=> url_for('intermentsearch/getSectionListAsPerArea'),
									  'update'	=> 'interment_section_list',
									  'with'	=> "'area_id='+this.value+'&country_id='+$('#interment_country_id').val()+'&cemetery_id='+$('#interment_cem_cemetery_id').val()",
									  'loading' => '$("#IdAjaxLocaderSection").show();',
									  'complete'=> '$("#IdAjaxLocaderSection").hide();'.jq_remote_function(
													array('url'		=> url_for('intermentsearch/getRowListAsPerSection'),
														  'update'	=> 'interment_row_list',
														  'with'	=> "'area_id='+$('#interment_ar_area_id').val()+'&country_id='+$('#interment_country_id').val()+'&cemetery_id='+$('#interment_cem_cemetery_id').val()",
														  'loading' => '$("#IdAjaxLocaderRow").show();',
														  'complete'=> '$("#IdAjaxLocaderRow").hide();'.jq_remote_function(
																		array('url'		=> url_for('intermentsearch/getPlotListAsPerRow'),
																			  'update'	=> 'interment_plot_list',
																			  'with'	=> "'area_id='+$('#interment_ar_area_id').val()+'&country_id='+$('#interment_country_id').val()+'&cemetery_id='+$('#interment_cem_cemetery_id').val()",
																			  'loading' => '$("#IdAjaxLocaderPlot").show();',
																			  'complete'=> '$("#IdAjaxLocaderPlot").hide();'.jq_remote_function(
																							array('url'		=> url_for('intermentsearch/getGraveListAsPerPlot'),
																								  'update'	=> 'interment_grave_list',
																								  'with'	=> "'area_id='+$('#interment_ar_area_id').val()+'&country_id='+$('#interment_country_id').val()+'&cemetery_id='+$('#interment_cem_cemetery_id').val()",
																								  'loading' => '$("#IdAjaxLocaderGrave").show();',
																								  'complete'=> '$("#IdAjaxLocaderGrave").hide();'))
																							))
																	))
								))
				)); 

	echo '<span id="IdAjaxLocaderArea" style="display:none;">'.image_tag('admin/ajaxLoader.gif').'</span>';				
?>
</div>
