<div id="gravelog_cemetery_list">
<?php 
		echo select_tag('searchCemId', options_for_select($asCementryList , isset($snCementeryId) ? $snCementeryId : '', 'include_custom='.__('Select Cementery')),
			array('tabindex'=>2, 'onChange' => jq_remote_function(
												array('url'		=> url_for('gravelog/getStaffListAsPerCemetery'),
												  'update'	=> 'gravelog_users_list',
												  'with'	=> "'&cemetery_id='+$('#searchCemId').val()+'&logtype='+$('#logtype').val()",
												  'loading' => '$("#IdAjaxLocaderStaff").show();',
												  'complete'=> '$("#IdAjaxLocaderStaff").hide();'))
				));
			
		echo '<span id="IdAjaxLocaderCemetery" style="display:none;">'.image_tag('admin/ajaxLoader.gif').'</span>';
?>
</div>

