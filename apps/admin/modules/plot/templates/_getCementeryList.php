<div id="plot_cemetery_list">
<?php echo select_tag('plot_cem_cemetery_id', options_for_select($asCementryList , isset($snCementeryId) ? $snCementeryId : '', 'include_custom='.__('Select Cementery')),
			array('tabindex'=>2, 
				  'onChange' => jq_remote_function(
								array('url'		=> url_for('plot/getAreaListAsPerCemetery'),
									  'update'	=> 'plot_area_list',
									  'with'	=> "'cemetery_id='+this.value+'&country_id='+$('#plot_country_id').val()",
									  'loading' => '$("#IdAjaxLocaderArea").show();',
									  'complete'=> '$("#IdAjaxLocaderArea").hide();'.jq_remote_function(
												array('url'		=> url_for('plot/getSectionListAsPerArea'),
													  'update'	=> 'plot_section_list',
													  'with'	=> "'country_id='+$('#plot_country_id').val()+'&cemetery_id='+$('#plot_cem_cemetery_id').val()",
													  'loading' => '$("#IdAjaxLocaderSection").show();',
													  'complete'=> '$("#IdAjaxLocaderSection").hide();'.jq_remote_function(
																	array('url'		=> url_for('plot/getRowListAsPerSection'),
																		  'update'	=> 'plot_row_list',
																		  'with'	=> "'country_id='+$('#plot_country_id').val()+'&cemetery_id='+$('#plot_cem_cemetery_id').val()",
																		  'loading' => '$("#IdAjaxLocaderRow").show();',
																		  'complete'=> '$("#IdAjaxLocaderRow").hide();'))
												))
								))		
				)
		); 
	echo '<span id="IdAjaxLocaderCemetery" style="display:none;">'.image_tag('admin/ajaxLoader.gif').'</span>';
?>
</div>
