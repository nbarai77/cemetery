<div id="grave_list">
<?php 
	echo select_tag('grave_ar_grave_id', options_for_select($asGraveList , '', 'include_custom='.__('Select Grave')),
					array('tabindex'=>7,'multiple' => true ));
	
		echo '<span id="IdAjaxLocaderGrave" style="display:none;">'.image_tag('admin/ajaxLoader.gif').'</span>';
?>
</div>
