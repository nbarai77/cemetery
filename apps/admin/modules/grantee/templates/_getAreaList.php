<div id="grantee_area_list">
<?php echo select_tag('grantee_ar_area_id', options_for_select($asAreaList , isset($snAreaId) ? $snAreaId : '', 'include_custom='.__('Select Area')),
			array('tabindex'=>3,'onChange' => jq_remote_function(
								array('url'		=> url_for('grantee/getSectionListAsPerArea'),
									  'update'	=> 'grantee_section_list',
									  'with'	=> "'area_id='+this.value+'&country_id='+$('#grantee_country_id').val()+'&cemetery_id='+$('#grantee_cem_cemetery_id').val()",
									  'loading' => '$("#IdAjaxLocaderSection").show();',
									  'complete'=> '$("#IdAjaxLocaderSection").hide();'.jq_remote_function(
																	array('url'		=> url_for('grantee/getRowListAsPerSection'),
																		  'update'	=> 'grantee_row_list',
																		  'with'	=> "'area_id='+$('#grantee_ar_area_id').val()+'&country_id='+$('#grantee_country_id').val()+'&cemetery_id='+$('#grantee_cem_cemetery_id').val()",
																		  'loading' => '$("#IdAjaxLocaderRow").show();',
																		  'complete'=> '$("#IdAjaxLocaderRow").hide();'.jq_remote_function(
																						array('url'		=> url_for('grantee/getPlotListAsPerRow'),
																							  'update'	=> 'grantee_plot_list',
																							  'with'	=> "'area_id='+$('#grantee_ar_area_id').val()+'&country_id='+$('#grantee_country_id').val()+'&cemetery_id='+$('#grantee_cem_cemetery_id').val()",
																							  'loading' => '$("#IdAjaxLocaderPlot").show();',
																							  'complete'=> '$("#IdAjaxLocaderPlot").hide();'.jq_remote_function(
																												array('url'		=> url_for('grantee/getGraveListAsPerPlot'),
																													  'update'	=> 'grantee_grave_list',
																													  'with'	=> "'country_id='+$('#grantee_country_id').val()+'&cemetery_id='+$('#grantee_cem_cemetery_id').val()+'&area_id='+$('#grantee_ar_area_id').val()+'&grantee_id='+$('#grantee_id').val()",
																													  'loading' => '$("#IdAjaxLocaderGrave").show();',
																													  'complete'=> '$("#IdAjaxLocaderGrave").hide();'))
																							))
																	))
								))
				)); 
				
	echo '<span id="IdAjaxLocaderArea" style="display:none;">'.image_tag('admin/ajaxLoader.gif').'</span>';
?>
</div>
