<div id="row_area_list">
<?php echo select_tag('row_ar_area_id', options_for_select($asAreaList , isset($snAreaId) ? $snAreaId : '', 'include_custom='.__('Select Area')),
			array('tabindex'=>3,
				  'onChange' => jq_remote_function(
								array('url'		=> url_for('row/getSectionListAsPerArea'),
									  'update'	=> 'row_section_list',
									  'with'	=> "'area_id='+this.value+'&country_id='+$('#row_country_id').val()+'&cemetery_id='+$('#row_cem_cemetery_id').val()",
									  'loading' => '$("#IdAjaxLocaderSection").show();',
									  'complete'=> '$("#IdAjaxLocaderSection").hide();'))
				)); 
	echo '<span id="IdAjaxLocaderArea" style="display:none;">'.image_tag('admin/ajaxLoader.gif').'</span>'; 
?>
</div>
