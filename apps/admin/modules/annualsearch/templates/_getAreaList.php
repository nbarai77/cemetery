<div id="annualsearch_area_list">
<?php echo select_tag('annualsearch_ar_area_id', options_for_select($asAreaList , isset($snAreaId) ? $snAreaId : '', 'include_custom='.__('Select Area')),
			array('tabindex'=>3,'onChange' => jq_remote_function(
								array('url'		=> url_for('annualsearch/getSectionListAsPerArea'),
									  'update'	=> 'annualsearch_section_list',
									  'with'	=> "'area_id='+this.value+'&country_id='+$('#annualsearch_country_id').val()+'&cemetery_id='+$('#annualsearch_cem_cemetery_id').val()",
									  'loading' => '$("#IdAjaxLocaderSection").show();',
									  'complete'=> '$("#IdAjaxLocaderSection").hide();'.jq_remote_function(
													array('url'		=> url_for('annualsearch/getRowListAsPerSection'),
														  'update'	=> 'annualsearch_row_list',
														  'with'	=> "'area_id='+$('#annualsearch_ar_area_id').val()+'&country_id='+$('#annualsearch_country_id').val()+'&cemetery_id='+$('#annualsearch_cem_cemetery_id').val()",
														  'loading' => '$("#IdAjaxLocaderRow").show();',
														  'complete'=> '$("#IdAjaxLocaderRow").hide();'.jq_remote_function(
																		array('url'		=> url_for('annualsearch/getPlotListAsPerRow'),
																			  'update'	=> 'annualsearch_plot_list',
																			  'with'	=> "'area_id='+$('#annualsearch_ar_area_id').val()+'&country_id='+$('#annualsearch_country_id').val()+'&cemetery_id='+$('#annualsearch_cem_cemetery_id').val()",
																			  'loading' => '$("#IdAjaxLocaderPlot").show();',
																			  'complete'=> '$("#IdAjaxLocaderPlot").hide();'.jq_remote_function(
																								array('url'		=> url_for('annualsearch/getGraveListAsPerPlot'),
																									  'update'	=> 'annualsearch_grave_list',
																									  'with'	=> "'area_id='+$('#annualsearch_ar_area_id').val()+'&country_id='+$('#annualsearch_country_id').val()+'&cemetery_id='+$('#annualsearch_cem_cemetery_id').val()",
																									  'loading' => '$("#IdAjaxLocaderGrave").show();',
																									  'complete'=> '$("#IdAjaxLocaderGrave").hide();'))
																			))
													))
								))
				)); 

	echo '<span id="IdAjaxLocaderArea" style="display:none;">'.image_tag('admin/ajaxLoader.gif').'</span>';				
?>
</div>
