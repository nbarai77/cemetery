<div id="grantee_cemetery_list">
<?php 
		echo select_tag('grantee_cem_cemetery_id', options_for_select($asCementryList , isset($snCementeryId) ? $snCementeryId : '', 'include_custom='.__('Select Cementery')),
							array('onChange' => "callAjaxForCemetery(this.value,$('#grantee_country_id').val(),$('#grantee_id').val());"
					)); 

		echo '<span id="IdAjaxLocaderCemetery" style="display:none;">'.image_tag('admin/ajaxLoader.gif').'</span>';
?>
</div>
