<div id="grantee_custom_grave_list">
	<?php 
		echo select_tag('searchArGraveId', options_for_select($asGraveList , isset($snGraveId) ? $snGraveId : '', 'include_custom='.__('Select Grave')),array('tabindex'=>7)); 
		echo '<span id="IdAjaxLocaderGrave" style="display:none;">'.image_tag('admin/ajaxLoader.gif').'</span>';	
	?>
</div>
