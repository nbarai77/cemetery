<div id="grantee_section_list">
<?php echo select_tag('grantee_ar_section_id', options_for_select($asSectionList , isset($snSectionId) ? $snSectionId : '', 'include_custom='.__('Select Section')),
			array('tabindex'=>4,'onChange' => jq_remote_function(
								array('url'		=> url_for('grantee/getRowListAsPerSection'),
									  'update'	=> 'grantee_row_list',
									  'with'	=> "'section_id='+this.value+'&country_id='+$('#grantee_country_id').val()+'&cemetery_id='+$('#grantee_cem_cemetery_id').val()+'&area_id='+$('#grantee_ar_area_id').val()",
									  'loading' => '$("#IdAjaxLocaderRow").show();',
									  'complete'=> '$("#IdAjaxLocaderRow").hide();'.jq_remote_function(
													array('url'		=> url_for('grantee/getPlotListAsPerRow'),
														  'update'	=> 'grantee_plot_list',
														  'with'	=> "'section_id='+$('#grantee_ar_section_id').val()+'&country_id='+$('#grantee_country_id').val()+'&cemetery_id='+$('#grantee_cem_cemetery_id').val()+'&area_id='+$('#grantee_ar_area_id').val()",
														  'loading' => '$("#IdAjaxLocaderPlot").show();',
														  'complete'=> '$("#IdAjaxLocaderPlot").hide();'.jq_remote_function(
																		array('url'		=> url_for('grantee/getGraveListAsPerPlot'),
																			  'update'	=> 'grantee_grave_list',
																			  'with'	=> "'country_id='+$('#grantee_country_id').val()+'&cemetery_id='+$('#grantee_cem_cemetery_id').val()+'&section_id='+$('#grantee_ar_section_id').val()+'&area_id='+$('#grantee_ar_area_id').val()+'&grantee_id='+$('#grantee_id').val()",
																			  'loading' => '$("#IdAjaxLocaderGrave").show();',
																			  'complete'=> '$("#IdAjaxLocaderGrave").hide();'))
																						))
								))
				)); 

	echo '<span id="IdAjaxLocaderSection" style="display:none;">'.image_tag('admin/ajaxLoader.gif').'</span>';
?>
</div>

