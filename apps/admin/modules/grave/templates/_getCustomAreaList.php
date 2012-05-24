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
<div id="grave_custom_area_list">
<?php echo select_tag('searchArAreaId', options_for_select($asAreaList , ($sf_user->getAttribute('gr_area') != '') ? $sf_user->getAttribute('gr_area') : '', 'include_custom='.__('Select Area')),
			array('tabindex'=>3,'onChange' => jq_remote_function(
								array('url'		=> url_for('grave/getCustomSectionListAsPerArea'),
									  'update'	=> 'grave_custom_section_list',
									  'with'	=> "'area_id='+this.value+'&country_id='+".$snCountryId."+'&cemetery_id='+".$snCemeteryId." ",
									  'loading' => '$("#IdAjaxLocaderSection").show();',
									  'complete'=> '$("#IdAjaxLocaderSection").hide();'.jq_remote_function(
																	array('url'		=> url_for('grave/getCustomRowListAsPerSection'),
																		  'update'	=> 'grave_custom_row_list',
																		  'with'	=> "'area_id='+$('#searchArAreaId').val()+'&country_id='+".$snCountryId."+'&cemetery_id='+".$snCemeteryId." ",
																		  'loading' => '$("#IdAjaxLocaderRow").show();',
																		  'complete'=> '$("#IdAjaxLocaderRow").hide();'.jq_remote_function(
																						array('url'		=> url_for('grave/getCustomPlotListAsPerRow'),
																							  'update'	=> 'grave_custom_plot_list',
																							  'with'	=> "'area_id='+$('#searchArAreaId').val()+'&country_id='+".$snCountryId."+'&cemetery_id='+".$snCemeteryId." ",
																							  'loading' => '$("#IdAjaxLocaderPlot").show();',
																							  'complete'=> '$("#IdAjaxLocaderPlot").hide();'))
																	))
								))
				)); 
echo '<span id="IdAjaxLocaderArea" style="display:none;">'.image_tag('admin/ajaxLoader.gif').'</span>';
?>
</div>
