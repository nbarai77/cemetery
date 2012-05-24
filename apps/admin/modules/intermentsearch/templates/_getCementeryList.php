<div id="interment_cemetery_list">
<?php echo select_tag('interment_cem_cemetery_id', options_for_select($asCementryList , isset($snCementeryId) ? $snCementeryId : '', 'include_custom='.__('Select Cementery')),
			array('tabindex'=>2,'onChange' => jq_remote_function(
								array('url'		=> url_for('intermentsearch/getAreaListAsPerCemetery'),
									  'update'	=> 'interment_area_list',
									  'with'	=> "'cemetery_id='+this.value+'&country_id='+$('#interment_country_id').val()",
									  'loading' => '$("#IdAjaxLocaderArea").show();',
									  'complete'=> '$("#IdAjaxLocaderArea").hide();'.jq_remote_function(
													array('url'		=> url_for('intermentsearch/getSectionListAsPerArea'),
														  'update'	=> 'interment_section_list',
														  'with'	=> "'country_id='+$('#interment_country_id').val()+'&cemetery_id='+$('#interment_cem_cemetery_id').val()",
														  'loading' => '$("#IdAjaxLocaderSection").show();',
														  'complete'=> '$("#IdAjaxLocaderSection").hide();'.jq_remote_function(
																	array('url'		=> url_for('intermentsearch/getRowListAsPerSection'),
																		  'update'	=> 'interment_row_list',
																		  'with'	=> "'country_id='+$('#interment_country_id').val()+'&cemetery_id='+$('#interment_cem_cemetery_id').val()",
																		  'loading' => '$("#IdAjaxLocaderRow").show();',
																		  'complete'=> '$("#IdAjaxLocaderRow").hide();'.jq_remote_function(
																						array('url'		=> url_for('intermentsearch/getPlotListAsPerRow'),
																							  'update'	=> 'interment_plot_list',
																							  'with'	=> "'country_id='+$('#interment_country_id').val()+'&cemetery_id='+$('#interment_cem_cemetery_id').val()",
																							  'loading' => '$("#IdAjaxLocaderPlot").show();',
																							  'complete'=> '$("#IdAjaxLocaderPlot").hide();'.jq_remote_function(
																											array('url'		=> url_for('intermentsearch/getGraveListAsPerPlot'),
																												  'update'	=> 'interment_grave_list',
																												  'with'	=> "'country_id='+$('#interment_country_id').val()+'&cemetery_id='+$('#interment_cem_cemetery_id').val()",
																												  'loading' => '$("#IdAjaxLocaderGrave").show();',
																												  'complete'=> '$("#IdAjaxLocaderGrave").hide();'))
																						))
																	))
													))
								))
				)); 
				
	echo '<span id="IdAjaxLocaderCemetery" style="display:none;">'.image_tag('admin/ajaxLoader.gif').'</span>';
?>
</div>
