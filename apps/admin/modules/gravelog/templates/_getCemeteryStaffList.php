<div id="gravelog_users_list">
<?php 
	echo select_tag('searchUserId', options_for_select($asCemStaffList , isset($snCompletedBy) ? $snCompletedBy : '', 'include_custom='.__('Select User')),
		array('tabindex'=>17)); 
		
	echo '<span id="IdAjaxLocaderStaff" style="display:none;">'.image_tag('admin/ajaxLoader.gif').'</span>';
?>
</div>
