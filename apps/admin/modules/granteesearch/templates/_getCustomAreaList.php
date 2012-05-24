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
<div id="grantee_custom_area_list">
<?php echo select_tag('searchArAreaId', options_for_select($asAreaList , isset($snAreaId) ? $snAreaId : '', 'include_custom='.__('Select Area')),
			array('tabindex'=>3,'onChange' => jq_remote_function(
								array('url'		=> url_for('granteesearch/getCustomSectionListAsPerArea'),
									  'update'	=> 'grantee_custom_section_list',
									  'with'	=> "'area_id='+this.value+'&country_id='+".$snCountryId."+'&cemetery_id='+".$snCemeteryId." ",
									  'loading' => '$("#IdAjaxLocaderSection").show();',
									  'complete'=> '$("#IdAjaxLocaderSection").hide();'.jq_remote_function(
																	array('url'		=> url_for('granteesearch/getCustomRowListAsPerSection'),
																		  'update'	=> 'grantee_custom_row_list',
																		  'with'	=> "'area_id='+$('#searchArAreaId').val()+'&country_id='+".$snCountryId."+'&cemetery_id='+".$snCemeteryId."",
																		  'loading' => '$("#IdAjaxLocaderRow").show();',
																		  'complete'=> '$("#IdAjaxLocaderRow").hide();'.jq_remote_function(
																						array('url'		=> url_for('granteesearch/getCustomPlotListAsPerRow'),
																							  'update'	=> 'grantee_custom_plot_list',
																							  'with'	=> "'area_id='+$('#searchArAreaId').val()+'&country_id='+".$snCountryId."+'&cemetery_id='+".$snCemeteryId."",
																							  'loading' => '$("#IdAjaxLocaderPlot").show();',
																							  'complete'=> '$("#IdAjaxLocaderPlot").hide();'.jq_remote_function(
																												array('url'		=> url_for('granteesearch/getCustomGraveListAsPerPlot'),
																													  'update'	=> 'grantee_custom_grave_list',
																													  'with'	=> "'area_id='+$('#searchArAreaId').val()+'&country_id='+".$snCountryId."+'&cemetery_id='+".$snCemeteryId."",
																													  'loading' => '$("#IdAjaxLocaderGrave").show();',
																													  'complete'=> '$("#IdAjaxLocaderGrave").hide();'))
																							))
																	))
								))
				)); 
echo '<span id="IdAjaxLocaderArea" style="display:none;">'.image_tag('admin/ajaxLoader.gif').'</span>';				
?>
</div>
