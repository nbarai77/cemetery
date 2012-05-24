<div id="custom_cementery_list">
<?php 
		echo select_tag('customcemetery_cem_cemetery_id', options_for_select($asCementryList , isset($snCementeryId) ? $snCementeryId : '', 'include_custom='.__('Select Cementery')),
			array('tabindex'=>2));
			
		echo '<span id="IdAjaxLocaderCemetery" style="display:none;">'.image_tag('admin/ajaxLoader.gif').'</span>';
?>
</div>
