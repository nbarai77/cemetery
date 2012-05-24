<div id="section_cementery_list">
<?php echo select_tag('section_cem_cemetery_id', options_for_select($asCementryList , isset($snCementeryId) ? $snCementeryId : '', 'include_custom='.__('--- Select Cementery ----')),
			array('tabindex'=>2,
				  'onChange' => jq_remote_function(
								array('url'		=> url_for('section/getAreaListAsPerCemetery'),
									  'update'	=> 'section_area_list',
									  'with'	=> "'cemetery_id='+this.value+'&country_id='+$('#section_country_id').val()",
									  'loading' => '$("#IdAjaxLocaderArea").show();',
									  'complete'=> '$("#IdAjaxLocaderArea").hide();'))
				));
				
		echo '<span id="IdAjaxLocaderCemetery" style="display:none;">'.image_tag('admin/ajaxLoader.gif').'</span>';
?>
</div>
