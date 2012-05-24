<?php 
echo '<div id="div_tranfer_date_lnk_'.$snHistoryId.'">';
$ssInputTagId = 'transfer_date_'.$snHistoryId;
$ssUpdateDivId = 'div_upd_transfer_date_'.$snHistoryId;
echo link_to_function($ssTransferDate,"showHidDiv('".$snHistoryId."');",
		array('title' => __('Click here to change transfer date'),'style' => 'color: #258ECA;' ) );
echo '</div>';

echo '<div id="div_tranfer_date_tag_'.$snHistoryId.'" style="display:none;">';
	echo '<span class="fleft">'.input_tag($ssInputTagId, $ssTransferDate,array('style' => 'width:80px;') ).'&nbsp;&nbsp;</span>';
	echo '<span class="fleft">'.button_to_function(__('Change'),"changeTransDate('".$ssInputTagId."','".$snHistoryId."','".$ssUpdateDivId."');",
													array('title' => __('Change'), 'style' => 'height:27px;padding-top:3px;' )).'</span>';
echo '</div>';


//$ssImageName = url_for('images/jquery/calendar.gif').'/calendar.gif';		// LIVE
$ssImageName = sfConfig::get('app_cal_image_path');							// LATEST

$ssDatePickerId = '#'.$ssInputTagId;
echo javascript_tag("
	jQuery(document).ready(function() 
	{
		var params = {
			changeMonth : true,
			changeYear : true,
			numberOfMonths : 1,
			dateFormat: 'dd-mm-yy',
			showButtonPanel : true,
			showOn: 'button',
			buttonImage: '".$ssImageName."',
			buttonImageOnly: true,
			showSecond: false,
		 };
		$('".$ssDatePickerId."').datepicker(params);
	});
	function showHidDiv(snHistoryId)
	{
		$('#div_tranfer_date_lnk_'+snHistoryId).hide();
		$('#div_tranfer_date_tag_'+snHistoryId).show();
	}
	function changeTransDate(ssInputTagId, snHistoryId)
	{
		".		
		jq_remote_function(array('url'		=> url_for('grantee/changeTransferDate'),
								  'with'	=> "'transf_date='+$('#'+ssInputTagId).val()+'&id_history='+snHistoryId",
								  'success' => "$('#div_upd_transfer_date_'+snHistoryId).html(data);",
								  'loading' => '$("#IdAjaxLocaderPlot").show();',
								  'complete'=> '$("#IdAjaxLocaderPlot").hide();'))
		."
	}
");
?>
