<div id="section_area_list">
<?php 
	echo select_tag('section_ar_area_id', options_for_select($asAreaList , isset($snAreaId) ? $snAreaId : '', 'include_custom='.__('--- Select Area ----')),
			array('tabindex'=>3));
			
	echo '<span id="IdAjaxLocaderArea" style="display:none;">'.image_tag('admin/ajaxLoader.gif').'</span>'; 
?>
</div>
