<div id="interment_section_list">
<?php echo select_tag('interment_ar_section_id', options_for_select($asSectionList , isset($snSectionId) ? $snSectionId : '', 'include_custom='.__('Select Section')),
			array('tabindex'=>4,'onChange' => jq_remote_function(
								array('url'		=> url_for('intermentsearch/getRowListAsPerSection'),
									  'update'	=> 'interment_row_list',
									  'with'	=> "'section_id='+this.value+'&country_id='+$('#interment_country_id').val()+'&cemetery_id='+$('#interment_cem_cemetery_id').val()+'&area_id='+$('#interment_ar_area_id').val()",
									  'loading' => '$("#IdAjaxLocaderRow").show();',
									  'complete'=> '$("#IdAjaxLocaderRow").hide();'.jq_remote_function(
													array('url'		=> url_for('intermentsearch/getPlotListAsPerRow'),
														  'update'	=> 'interment_plot_list',
														  'with'	=> "'section_id='+$('#interment_ar_section_id').val()+'&country_id='+$('#interment_country_id').val()+'&cemetery_id='+$('#interment_cem_cemetery_id').val()+'&area_id='+$('#interment_ar_area_id').val()",
														  'loading' => '$("#IdAjaxLocaderPlot").show();',
														  'complete'=> '$("#IdAjaxLocaderPlot").hide();'.jq_remote_function(
																		array('url'		=> url_for('intermentsearch/getGraveListAsPerPlot'),
																			  'update'	=> 'interment_grave_list',
																			  'with'	=> "'section_id='+$('#interment_ar_section_id').val()+'&country_id='+$('#interment_country_id').val()+'&cemetery_id='+$('#interment_cem_cemetery_id').val()+'&area_id='+$('#interment_ar_area_id').val()",
																			  'loading' => '$("#IdAjaxLocaderGrave").show();',
																			  'complete'=> '$("#IdAjaxLocaderGrave").hide();'))
													))
								))
				)); 

	echo '<span id="IdAjaxLocaderSection" style="display:none;">'.image_tag('admin/ajaxLoader.gif').'</span>';				
?>
</div>
