<div id="plot_row_list">
<?php 
	echo select_tag('plot_ar_row_id', options_for_select($asRowList , isset($snRowId) ? $snRowId : '', 'include_custom='.__('Select Row')),
				array('tabindex'=>5));
				
	echo '<span id="IdAjaxLocaderRow" style="display:none;">'.image_tag('admin/ajaxLoader.gif').'</span>';
?>
</div>
