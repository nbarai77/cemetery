<div id="plot_area_list">
<?php echo select_tag('plot_ar_area_id', options_for_select($asAreaList , isset($snAreaId) ? $snAreaId : '', 'include_custom='.__('Select Area')),
			array('tabindex'=>3,'onChange' => jq_remote_function(
								array('url'		=> url_for('plot/getSectionListAsPerArea'),
									  'update'	=> 'plot_section_list',
									  'with'	=> "'area_id='+this.value+'&country_id='+$('#plot_country_id').val()+'&cemetery_id='+$('#plot_cem_cemetery_id').val()",
									  'loading' => '$("#IdAjaxLocaderSection").show();',
									  'complete'=> '$("#IdAjaxLocaderSection").hide();'.jq_remote_function(
																	array('url'		=> url_for('plot/getRowListAsPerSection'),
																		  'update'	=> 'plot_row_list',
																		  'with'	=> "'area_id='+$('#plot_ar_area_id').val()+'&country_id='+$('#plot_country_id').val()+'&cemetery_id='+$('#plot_cem_cemetery_id').val()",
																		  'loading' => '$("#IdAjaxLocaderRow").show();',
																		  'complete'=> '$("#IdAjaxLocaderRow").hide();'
																	))
								))
				)); 
	echo '<span id="IdAjaxLocaderArea" style="display:none;">'.image_tag('admin/ajaxLoader.gif').'</span>';
?>
</div>
