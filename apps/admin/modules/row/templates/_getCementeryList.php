<div id="row_cemetery_list">
<?php echo select_tag('row_cem_cemetery_id', options_for_select($asCementryList , isset($snCementeryId) ? $snCementeryId : '', 'include_custom='.__('Select Cementery')),
			array('tabindex'=>2,'onChange' => jq_remote_function(
								array('url'		=> url_for('row/getAreaListAsPerCemetery'),
									  'update'	=> 'row_area_list',
									  'with'	=> "'cemetery_id='+this.value+'&country_id='+$('#row_country_id').val()",
									  'loading' => '$("#IdAjaxLocaderArea").show();',
									  'complete'=> '$("#IdAjaxLocaderArea").hide();'.jq_remote_function(
													array('url'		=> url_for('row/getSectionListAsPerArea'),
														  'update'	=> 'row_section_list',
														  'with'	=> "'country_id='+$('#row_country_id').val()+'&cemetery_id='+$('#row_cem_cemetery_id').val()",
														  'loading' => '$("#IdAjaxLocaderSection").show();',
														  'complete'=> '$("#IdAjaxLocaderSection").hide();'
													))
								))
				)); 
	echo '<span id="IdAjaxLocaderCemetery" style="display:none;">'.image_tag('admin/ajaxLoader.gif').'</span>';
?>
</div>

