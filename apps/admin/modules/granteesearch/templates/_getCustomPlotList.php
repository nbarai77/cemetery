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
<div id="grantee_custom_plot_list">
	<?php echo select_tag('searchArPlotId', options_for_select($asPlotList , isset($snPlotId) ? $snPlotId : '', 'include_custom='.__('Select Plot')),
				array('tabindex'=>6,'onChange' => jq_remote_function(
							array('url'		=> url_for('granteesearch/getCustomGraveListAsPerPlot'),
								  'update'	=> 'grantee_custom_grave_list',
								  'with'	=> "'plot_id='+this.value+'&country_id='+".$snCountryId."+'&cemetery_id='+".$snCemeteryId."+'&area_id='+$('#searchArAreaId').val()+'&section_id='+$('#searchArSectionId').val()+'&row_id='+$('#searchArRowId').val()",
								  'loading' => '$("#IdAjaxLocaderGrave").show();',
								  'complete'=> '$("#IdAjaxLocaderGrave").hide();'))
			)); 
echo '<span id="IdAjaxLocaderPlot" style="display:none;">'.image_tag('admin/ajaxLoader.gif').'</span>';	
?>
</div>
