<?php
if(!$sf_user->isSuperAdmin()):
	$snCemeteryId = $sf_user->getAttribute('cemeteryid');
	$oCemetery = Doctrine::getTable('CemCemetery')->find($snCemeteryId);
	$snCountryId = $oCemetery->getCountryId();
else:	
	$snCountryId = "$('#searchCountryId').val()";
	$snCemeteryId = "$('#searchCemCemeteryId').val()";
endif;
?>
<div id="grantee_custom_section_list">
<?php echo select_tag('searchArSectionId', options_for_select($asSectionList , isset($snSectionId) ? $snSectionId : '', 'include_custom='.__('Select Section')),
			array('tabindex'=>4,'onChange' => jq_remote_function(
								array('url'		=> url_for('granteesearch/getCustomRowListAsPerSection'),
									  'update'	=> 'grantee_custom_row_list',
									  'with'	=> "'section_id='+this.value+'&country_id='+".$snCountryId."+'&cemetery_id='+".$snCemeteryId."+'&area_id='+$('#searchArAreaId').val()",
									  'loading' => '$("#IdAjaxLocaderRow").show();',
									  'complete'=> '$("#IdAjaxLocaderRow").hide();'.jq_remote_function(
									  				array('url'		=> url_for('granteesearch/getCustomPlotListAsPerRow'),
													      'update'	=> 'grantee_custom_plot_list',
													      'with'	=> "'section_id='+$('#searchArSectionId').val()+'&country_id='+".$snCountryId."+'&cemetery_id='+".$snCemeteryId."+'&area_id='+$('#searchArAreaId').val()",
														  'loading' => '$("#IdAjaxLocaderPlot").show();',
														  'complete'=> '$("#IdAjaxLocaderPlot").hide();'.jq_remote_function(
																		array('url'		=> url_for('granteesearch/getCustomGraveListAsPerPlot'),
																			  'update'	=> 'grantee_custom_grave_list',
																			  'with'	=> "'section_id='+$('#searchArSectionId').val()+'&country_id='+".$snCountryId."+'&cemetery_id='+".$snCemeteryId."+'&area_id='+$('#searchArAreaId').val()",
																			  'loading' => '$("#IdAjaxLocaderGrave").show();',
																			  'complete'=> '$("#IdAjaxLocaderGrave").hide();'))
																		))
								))
				)); 
echo '<span id="IdAjaxLocaderSection" style="display:none;">'.image_tag('admin/ajaxLoader.gif').'</span>';
?>
</div>
