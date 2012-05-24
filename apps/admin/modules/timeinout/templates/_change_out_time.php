<?php
use_javascript('/sfFormExtraPlugin/js/double_list.js');
use_javascript('jquery-ui-timepicker-addon.js');
use_stylesheet('jquery-ui-timepicker-addon.css');
echo '<div id="div_time_out_'.$snTimeInOutId.'">';
$ssInputTagId = 'time_out_'.$snTimeInOutId;
$ssUpdateDivId = 'div_upd_time_out_'.$snTimeInOutId;
echo link_to_function($snTime,"showHidDiv('".$snTimeInOutId."');",
		array('title' => __('Click here to change total time'),'style' => 'color: #258ECA;' ) );
echo '</div>';

echo '<div id="div_time_out_tag_'.$snTimeInOutId.'" style="display:none;">';
	echo '<span class="fleft">'.input_tag($ssInputTagId, $snTime,array('style' => 'width:80px;') ).'&nbsp;&nbsp;</span>';
	echo '<span class="fleft">'.button_to_function(__('Change'),"changeTransDate('".$ssInputTagId."','".$snTimeInOutId."','".$ssUpdateDivId."');",
													array('title' => __('Change'), 'style' => 'height:27px;padding-top:3px;' )).'</span>';
echo '</div>';


//$ssImageName = url_for('images/jquery/calendar.gif').'/calendar.gif';		// LIVE
$ssImageName = '/'.sfConfig::get('app_cal_image_path');							// LATEST

$ssDatePickerId = '#'.$ssInputTagId;
echo javascript_tag("
	jQuery(document).ready(function() 
	{
		var params = {
            changeMonth : false,
				changeYear : false,
				numberOfMonths : 1,
				dateFormat: 'yy-mm-dd',
				showButtonPanel : true,
				showOn: 'button',
				buttonImage: '".$ssImageName."',
				buttonImageOnly: true,
				showSecond: false,
				timeFormat: 'hh:mm',
		 };
		$('".$ssDatePickerId."').timepicker(params);
	});
	function showHidDiv(snTimeInOutId)
	{
		$('#div_time_out_'+snTimeInOutId).hide();
		$('#div_time_out_tag_'+snTimeInOutId).show();
	}
	function changeTransDate(ssInputTagId, snTimeInOutId)
	{
		".		
		jq_remote_function(array('url'		=> url_for('timeinout/changeTimeOut'),
                                 'script' => true,
								  'with'	=> "'out_time='+$('#'+ssInputTagId).val()+'&id_time_out='+snTimeInOutId+'&id_user=".$snUserId."'",
								  'success' => "$('#div_upd_time_out_'+snTimeInOutId).html(data);",
								  'loading' => '$("#IdAjaxLocaderPlot").show();',
								  'complete'=> '$("#IdAjaxLocaderPlot").hide();'))
		."
	}
");
?>
