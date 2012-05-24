<div id="plot_section_list">
<?php echo select_tag('plot_ar_section_id', options_for_select($asSectionList , isset($snSectionId) ? $snSectionId : '', 'include_custom='.__('Select Section')),
			array('tabindex'=>4,'onChange' => jq_remote_function(
								array('url'		=> url_for('plot/getRowListAsPerSection'),
									  'update'	=> 'plot_row_list',
									  'with'	=> "'section_id='+this.value+'&country_id='+$('#plot_country_id').val()+'&cemetery_id='+$('#plot_cem_cemetery_id').val()+'&area_id='+$('#plot_ar_area_id').val()",
									  'loading' => '$("#IdAjaxLocaderRow").show();',
									  'complete'=> '$("#IdAjaxLocaderRow").hide();'))
				)); 

	echo '<span id="IdAjaxLocaderSection" style="display:none;">'.image_tag('admin/ajaxLoader.gif').'</span>';
?>
</div>
