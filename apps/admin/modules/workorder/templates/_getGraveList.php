<div id="workorder_grave_list">
<?php 
	echo select_tag('workorder_ar_grave_id', options_for_select($asGraveList , isset($snGraveId) ? $snGraveId : '', 'include_custom='.__('Select Grave')),
	array('tabindex'=>14)); 
	
	echo '<span id="IdAjaxLocaderGrave" style="display:none;">'.image_tag('admin/ajaxLoader.gif').'</span>';
?>
</div>
