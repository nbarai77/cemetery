<div id="gravemaintenance_section_list">
<?php echo select_tag('gravemaintenance_ar_section_id', options_for_select($asSectionList , isset($snSectionId) ? $snSectionId : '', 'include_custom='.__('Select Section')),
			array('tabindex'=>4,'onChange' => jq_remote_function(
								array('url'		=> url_for('gravemaintenance/getRowListAsPerSection'),
									  'update'	=> 'gravemaintenance_row_list',
									  'with'	=> "'section_id='+this.value+'&country_id='+$('#gravemaintenance_country_id').val()+'&cemetery_id='+$('#gravemaintenance_cem_cemetery_id').val()+'&area_id='+$('#gravemaintenance_ar_area_id').val()",
									  'loading' => '$("#IdAjaxLocaderRow").show();',
									  'complete'=> '$("#IdAjaxLocaderRow").hide();'.jq_remote_function(
													array('url'		=> url_for('gravemaintenance/getPlotListAsPerRow'),
														  'update'	=> 'gravemaintenance_plot_list',
														  'with'	=> "'section_id='+$('#gravemaintenance_ar_section_id').val()+'&country_id='+$('#gravemaintenance_country_id').val()+'&cemetery_id='+$('#gravemaintenance_cem_cemetery_id').val()+'&area_id='+$('#gravemaintenance_ar_area_id').val()",
														  'loading' => '$("#IdAjaxLocaderPlot").show();',
														  'complete'=> '$("#IdAjaxLocaderPlot").hide();'.jq_remote_function(
																		array('url'		=> url_for('gravemaintenance/getGraveListAsPerPlot'),
																			  'update'	=> 'gravemaintenance_grave_list',
																			  'with'	=> "'country_id='+$('#gravemaintenance_country_id').val()+'&cemetery_id='+$('#gravemaintenance_cem_cemetery_id').val()+'&section_id='+$('#gravemaintenance_ar_section_id').val()+'&area_id='+$('#gravemaintenance_ar_area_id').val()",
																			  'loading' => '$("#IdAjaxLocaderGrave").show();',
																			  'complete'=> '$("#IdAjaxLocaderGrave").hide();'
																			 ))
										))
								))
				)); 

	echo '<span id="IdAjaxLocaderSection" style="display:none;">'.image_tag('admin/ajaxLoader.gif').'</span>';				
?>
</div>

