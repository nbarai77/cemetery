<div id="grave_custom_cemetery_list">
	
<?php echo select_tag('searchCemCemeteryId', options_for_select($asCementryList , ($sf_user->getAttribute('gr_cemetery') != '') ? $sf_user->getAttribute('gr_cemetery') : '', 'include_custom='.__('Select Cementery')),
			array('tabindex'=>2, 
				  'onChange' => jq_remote_function(
								array('url'		=> url_for('grave/getCustomAreaListAsPerCemetery'),
									  'update'	=> 'grave_custom_area_list',
									  'with'	=> "'cemetery_id='+this.value+'&country_id='+$('#searchCountryId').val()",
									  'loading' => '$("#IdAjaxLocaderArea").show();',
									  'complete'=> '$("#IdAjaxLocaderArea").hide();'.jq_remote_function(
												array('url'		=> url_for('grave/getCustomSectionListAsPerArea'),
													  'update'	=> 'grave_custom_section_list',
													  'with'	=> "'country_id='+$('#searchCountryId').val()+'&cemetery_id='+$('#searchCemCemeteryId').val()",
													  'loading' => '$("#IdAjaxLocaderSection").show();',
													  'complete'=> '$("#IdAjaxLocaderSection").hide();'.jq_remote_function(
																array('url'		=> url_for('grave/getCustomRowListAsPerSection'),
																	  'update'	=> 'grave_custom_row_list',
																	  'with'	=> "'country_id='+$('#searchCountryId').val()+'&cemetery_id='+$('#searchCemCemeteryId').val()",
																	  'loading' => '$("#IdAjaxLocaderRow").show();',
																	  'complete'=> '$("#IdAjaxLocaderRow").hide();'.jq_remote_function(
																					array('url'		=> url_for('grave/getCustomPlotListAsPerRow'),
																						  'update'	=> 'grave_custom_plot_list',
																						  'with'	=> "'country_id='+$('#searchCountryId').val()+'&cemetery_id='+$('#searchCemCemeteryId').val()",
																						  'loading' => '$("#IdAjaxLocaderPlot").show();',
																						  'complete'=> '$("#IdAjaxLocaderPlot").hide();'))
																))
												))
								))		
				)
		); 
echo '<span id="IdAjaxLocaderCemetery" style="display:none;">'.image_tag('admin/ajaxLoader.gif').'</span>';
?>
</div>
