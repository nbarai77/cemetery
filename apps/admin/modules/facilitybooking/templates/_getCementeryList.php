<div id="facilitybooking_cementery_list">
<?php 
		echo select_tag('facilitybooking_cem_cemetery_id', options_for_select($asCementryList , isset($snCementeryId) ? $snCementeryId : '', 'include_custom='.__('Select Cementery')),
			array('tabindex'=>2,
				  'onChange' => jq_remote_function(
								array('url'		=> url_for('facilitybooking/getChapelTypeLists'),
									  'update'	=> 'upd_chapel_type_div',
									  'with'	=> "'cemetery_id='+$('#facilitybooking_cem_cemetery_id').val()",
									  'loading' => '$("#IdAjaxLocaderArea").show();',
									  'complete'=> jq_remote_function(
													array('url'		=> url_for('facilitybooking/getRoomTypeLists'),
														  'update'	=> 'upd_room_type_div',
														  'with'	=> "'cemetery_id='+$('#facilitybooking_cem_cemetery_id').val()",
														  'loading' => '$("#IdAjaxLocaderArea").show();',
														  'complete'=> '$("#IdAjaxLocaderArea").hide();'))
								))
				));
			
		echo '<span id="IdAjaxLocaderCemetery" style="display:none;">'.image_tag('admin/ajaxLoader.gif').'</span>';
?>
</div>
