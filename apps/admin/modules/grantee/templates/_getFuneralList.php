<div id="grantee_funeral_list">
<?php 
	echo select_tag('grantee_fnd_fndirector_id', options_for_select($asFuneralList , isset($snFuneralId) ? $snFuneralId : '', 'include_custom='.__('Select Funeral Director')),
			array('tabindex'=>8)
			); 
	echo '<span id="IdAjaxLocaderFnd" style="display:none;">'.image_tag('admin/ajaxLoader.gif').'</span>';			
?>
</div>
