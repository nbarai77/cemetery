<div id="workorder_cemetery_list">
<?php echo select_tag('workorder_cem_cemetery_id', options_for_select($asCementryList , isset($snCementeryId) ? $snCementeryId : '', 'include_custom='.__('Select Cementery')),
			array('tabindex'=>9,'onChange' => jq_remote_function(
					array('url'		=> url_for('workorder/getAreaListAsPerCemetery'),
						  'update'	=> 'workorder_area_list',
						  'with'	=> "'cemetery_id='+this.value+'&country_id='+$('#workorder_country_id').val()",
						  'loading' => '$("#IdAjaxLocaderArea").show();',
						  'complete'=> '$("#IdAjaxLocaderArea").hide();'.jq_remote_function(
							array('url'		=> url_for('workorder/getSectionListAsPerArea'),
								  'update'	=> 'workorder_section_list',
								  'with'	=> "'country_id='+$('#workorder_country_id').val()+'&cemetery_id='+$('#workorder_cem_cemetery_id').val()",
								  'loading' => '$("#IdAjaxLocaderSection").show();',
								  'complete'=> '$("#IdAjaxLocaderSection").hide();'.jq_remote_function(
									array('url'		=> url_for('workorder/getRowListAsPerSection'),
										  'update'	=> 'workorder_row_list',
										  'with'	=> "'country_id='+$('#workorder_country_id').val()+'&cemetery_id='+$('#workorder_cem_cemetery_id').val()",
										  'loading' => '$("#IdAjaxLocaderRow").show();',
										  'complete'=> '$("#IdAjaxLocaderRow").hide();'.jq_remote_function(
											array('url'		=> url_for('workorder/getPlotListAsPerRow'),
												  'update'	=> 'workorder_plot_list',
												  'with'	=> "'country_id='+$('#workorder_country_id').val()+'&cemetery_id='+$('#workorder_cem_cemetery_id').val()",
												  'loading' => '$("#IdAjaxLocaderPlot").show();',
												  'complete'=> '$("#IdAjaxLocaderPlot").hide();'.jq_remote_function(
													array('url'		=> url_for('workorder/getGraveListAsPerPlot'),
														  'update'	=> 'workorder_grave_list',
														  'with'	=> "'country_id='+$('#workorder_country_id').val()+'&cemetery_id='+$('#workorder_cem_cemetery_id').val()",
														  'loading' => '$("#IdAjaxLocaderGrave").show();',
														  'complete'=> '$("#IdAjaxLocaderGrave").hide();'.jq_remote_function(
															array('url'		=> url_for('workorder/getDepartmentListAsPerCemetery'),
															  'update'	=> 'workorder_department_delegation_list',
															  'with'	=> "'&cemetery_id='+$('#workorder_cem_cemetery_id').val()",
															  'loading' => '$("#IdAjaxLocaderDept").show();',
															  'complete'=> '$("#IdAjaxLocaderDept").hide();'.jq_remote_function(
																array('url'		=> url_for('workorder/getStaffListAsPerCemetery'),
																  'update'	=> 'workorder_completed_by_list',
																  'with'	=> "'&cemetery_id='+$('#workorder_cem_cemetery_id').val()",
																  'loading' => '$("#IdAjaxLocaderStaff").show();',
																  'complete'=> '$("#IdAjaxLocaderStaff").hide();'))
															  
															))
													))
											))
									))
							))
					))
				)); 

	echo '<span id="IdAjaxLocaderCemetery" style="display:none;">'.image_tag('admin/ajaxLoader.gif').'</span>';				
?>
</div>
