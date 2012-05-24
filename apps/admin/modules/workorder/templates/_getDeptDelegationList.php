<div id="workorder_department_delegation_list">
<?php 
	echo select_tag('workorder_department_delegation', options_for_select($asDeptList , isset($snDeptId) ? $snDeptId : '', 'include_custom='.__('Select Department Delegation')),
		array('tabindex'=>15)); 

	echo '<span id="IdAjaxLocaderDept" style="display:none;">'.image_tag('admin/ajaxLoader.gif').'</span>';
?>
</div>
