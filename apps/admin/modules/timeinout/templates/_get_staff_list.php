<div id="staff_list">
<?php 
	echo select_tag('staff_id', options_for_select($asStaffUserList , isset($snStaffId) ? $snStaffId : '', 'include_custom='.__('Select Staff')),
						array('tabindex'=>2)
					);
?>
</div>