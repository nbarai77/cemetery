<div id="grantee_custom_cemetery_list">
<?php echo select_tag('searchCemCemeteryId', options_for_select($asCementryList , isset($snCementeryId) ? $snCementeryId : '', 'include_custom='.__('Select Cementery')),
			array('tabindex'=>2,'onChange' => jq_remote_function(
								array('url'		=> url_for('granteesearch/getCustomAreaListAsPerCemetery'),
									  'update'	=> 'grantee_custom_area_list',
									  'with'	=> "'cemetery_id='+this.value+'&country_id='+$('#searchCountryId').val()",
									  'loading' => '$("#IdAjaxLocaderArea").show();',
									  'complete'=> '$("#IdAjaxLocaderArea").hide();'.jq_remote_function(
													array('url'		=> url_for('granteesearch/getCustomSectionListAsPerArea'),
														  'update'	=> 'grantee_custom_section_list',
														  'with'	=> "'country_id='+$('#searchCountryId').val()+'&cemetery_id='+$('#searchCemCemeteryId').val()",
														  'loading' => '$("#IdAjaxLocaderSection").show();',
														  'complete'=> '$("#IdAjaxLocaderSection").hide();'.jq_remote_function(
																	array('url'		=> url_for('granteesearch/getCustomRowListAsPerSection'),
																		  'update'	=> 'grantee_custom_row_list',
																		  'with'	=> "'country_id='+$('#searchCountryId').val()+'&cemetery_id='+$('#searchCemCemeteryId').val()",
																		  'loading' => '$("#IdAjaxLocaderRow").show();',
																		  'complete'=> '$("#IdAjaxLocaderRow").hide();'.jq_remote_function(
																						array('url'		=> url_for('granteesearch/getCustomPlotListAsPerRow'),
																							  'update'	=> 'grantee_custom_plot_list',
																							  'with'	=> "'country_id='+$('#searchCountryId').val()+'&cemetery_id='+$('#searchCemCemeteryId').val()",
																							  'loading' => '$("#IdAjaxLocaderPlot").show();',
																							  'complete'=> '$("#IdAjaxLocaderPlot").hide();'.jq_remote_function(
																											array('url'		=> url_for('granteesearch/getCustomGraveListAsPerPlot'),
																												  'update'	=> 'grantee_custom_grave_list',
																												  'with'	=> "'country_id='+$('#searchCountryId').val()+'&cemetery_id='+$('#searchCemCemeteryId').val()",
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
