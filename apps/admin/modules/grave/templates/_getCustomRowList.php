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
<div id="grave_custom_row_list">
<?php echo select_tag('searchArRowId', options_for_select($asRowList , ($sf_user->getAttribute('gr_row') != '') ? $sf_user->getAttribute('gr_row') : '', 'include_custom='.__('Select Row')),
		array('tabindex'=> 5,'onChange' => jq_remote_function(
							array('url'		=> url_for('grave/getCustomPlotListAsPerRow'),
								  'update'	=> 'grave_custom_plot_list',
								  'with'	=> "'row_id='+this.value+'&country_id='+".$snCountryId."+'&cemetery_id='+".$snCemeteryId."+'&area_id='+$('#searchArAreaId').val()+'&section_id='+$('#searchArSectionId').val()",
								  'loading' => '$("#IdAjaxLocaderPlot").show();',
								  'complete'=> '$("#IdAjaxLocaderPlot").hide();'))
			)); 
echo '<span id="IdAjaxLocaderRow" style="display:none;">'.image_tag('admin/ajaxLoader.gif').'</span>';
?>
</div>
