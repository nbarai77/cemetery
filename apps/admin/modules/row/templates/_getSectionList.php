<div id="row_section_list">
<?php 
		echo select_tag('row_ar_section_id', options_for_select($asSectionList , isset($snSectionId) ? $snSectionId : '', 'include_custom='.__('Select Section')),
			array('tabindex'=>4)); 
		
		echo '<span id="IdAjaxLocaderSection" style="display:none;">'.image_tag('admin/ajaxLoader.gif').'</span>'; 	
?>
</div>
