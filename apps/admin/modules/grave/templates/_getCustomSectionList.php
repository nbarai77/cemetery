<?php
if(!$sf_user->isSuperAdmin()):
	$snCemeteryId = $sf_user->getAttribute('cemeteryid');
	$oCemetery = Doctrine::getTable('CemCemetery')->find($snCemeteryId);
	$snCountryId = $oCemetery->getCountryId();
else:
	$snCemeteryId = "$('#searchCemCemeteryId').val()";
	$snCountryId = "$('#searchCountryId').val()";
endif;
?>
<div id="grave_custom_section_list">
<?php echo select_tag('searchArSectionId', options_for_select($asSectionList , ($sf_user->getAttribute('gr_section') != '') ? $sf_user->getAttribute('gr_section') : '', 'include_custom='.__('Select Section')),
			array('tabindex'=>4,'onChange' => jq_remote_function(
												array('url'		=> url_for('grave/getCustomRowListAsPerSection'),
													  'update'	=> 'grave_custom_row_list',
													  'with'	=> "'section_id='+this.value+'&country_id='+".$snCountryId."+'&cemetery_id='+".$snCemeteryId."+'&area_id='+$('#searchArAreaId').val()",
													  'loading' => '$("#IdAjaxLocaderRow").show();',
													  'complete'=> '$("#IdAjaxLocaderRow").hide();'.jq_remote_function(
																	array('url'		=> url_for('grave/getCustomPlotListAsPerRow'),
																		  'update'	=> 'grave_custom_plot_list',
																		  'with'	=> "'section_id='+$('#searchArSectionId').val()+'&country_id='+".$snCountryId."+'&cemetery_id='+".$snCemeteryId."+'&area_id='+$('#searchArAreaId').val()",
					  													  'loading' => '$("#IdAjaxLocaderPlot").show();',
																		  'complete'=> '$("#IdAjaxLocaderPlot").hide();'))
								))
				)); 
echo '<span id="IdAjaxLocaderSection" style="display:none;">'.image_tag('admin/ajaxLoader.gif').'</span>';
?>
</div>
