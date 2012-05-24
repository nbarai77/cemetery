<div id="grave_details">
	<div class="fleft" style="padding-right:0px;">
		<?php echo input_tag('service_grave_length', (isset($omGraveDetails) && !empty($omGraveDetails) ) ? $omGraveDetails->getLength() : (isset($amGraveDetailsParams['ssGraveLength']) ? $amGraveDetailsParams['ssGraveLength'] : ''),array('tabindex'=> 35,'style' => 'width:100px;','onFocus' => "if($('#service_grave_length').val() == 'Length') { $('#service_grave_length').val(''); }",'onBlur' => "if($('#service_grave_length').val() == 'Length' || $('#service_grave_length').val() == '') { $('#service_grave_length').val('Length'); }"));?>
	</div>
	<div class="fleft">
		<?php echo input_tag('service_grave_width', (isset($omGraveDetails) && !empty($omGraveDetails) ) ? $omGraveDetails->getWidth() : (isset($amGraveDetailsParams['ssGraveWidth']) ? $amGraveDetailsParams['ssGraveWidth'] : ''),array('tabindex'=> 36,'style' => 'width:100px;','onFocus' => "if($('#service_grave_width').val() == 'Width') { $('#service_grave_width').val(''); }",'onBlur' => "if($('#service_grave_width').val() == 'Width' || $('#service_grave_width').val() == '') { $('#service_grave_width').val('Width'); }"));?>
	</div>
	<div class="fleft">
	<?php echo input_tag('service_grave_depth', (isset($omGraveDetails) && !empty($omGraveDetails) ) ? $omGraveDetails->getHeight() : (isset($amGraveDetailsParams['ssGraveHeight']) ? $amGraveDetailsParams['ssGraveHeight'] : ''),array('tabindex'=> 37,'style' => 'width:100px;','onFocus' => "if($('#service_grave_depth').val() == 'Height') { $('#service_grave_depth').val(''); }",'onBlur' => "if($('#service_grave_depth').val() == 'Height' || $('#service_grave_depth').val() == '') { $('#service_grave_depth').val('Height'); }"));?>
	</div>
	<div class="fleft">
		<?php 
			echo select_tag('service_grave_unit_type', options_for_select($amGraveUnitType , (isset($omGraveDetails) && !empty($omGraveDetails) ) ? $omGraveDetails->getUnitTypeId() : (isset($amGraveDetailsParams['snIdGraveUnitType']) ? $amGraveDetailsParams['snIdGraveUnitType'] : ''), 'include_custom='.__('Select Unit Type')),array('tabindex'=>38, 'class'=>'down'));?>
	</div>
	<div class="fleft" style="padding:7px 7px;">
		<?php echo __('Grave Status');?> :
	</div>
	<div class="fleft" style="padding:7px 7px;">
		<?php echo (isset($omGraveDetails) && !empty($omGraveDetails) ) ? $omGraveDetails->getArGraveStatus() : (isset($amGraveDetailsParams['ssGraveStatus']) ? $amGraveDetailsParams['ssGraveStatus'] : '');?>
	</div>		
</div>
<div class="clearb"></div>
<div id="grave_comments" style="display:none;">
	<div class="fleft">
		<?php 
			echo textarea_tag('service_grave_comment1', (isset($omGraveDetails) && !empty($omGraveDetails) ) ? $omGraveDetails->getComment1() : (isset($amGraveDetailsParams['ssGraveComment1']) ? $amGraveDetailsParams['ssGraveComment1'] : ''),array('size' => '5x2','tabindex'=> 39, 'onFocus' => "if($('#service_grave_comment1').val() == 'Comment1') { $('#service_grave_comment1').val(''); }", 'onBlur' => "if($('#service_grave_comment1').val() == 'Comment1' || $('#service_grave_comment1').val() == '') { $('#service_grave_comment1').val('Comment1'); }"));
		?>
	</div>
	<div class="fleft">
		<?php 
			echo textarea_tag('service_grave_comment2', (isset($omGraveDetails) && !empty($omGraveDetails) ) ? $omGraveDetails->getComment2() : (isset($amGraveDetailsParams['ssGraveComment2']) ? $amGraveDetailsParams['ssGraveComment2'] : ''),array('size' => '5x2', 'tabindex'=> 40, 'onFocus' => "if($('#service_grave_comment2').val() == 'Comment2') { $('#service_grave_comment2').val(''); }", 'onBlur' => "if($('#service_grave_comment2').val() == 'Comment2' || $('#service_grave_comment2').val() == '') { $('#service_grave_comment2').val('Comment2'); }"));
		?>
	</div>
</div>
<?php
echo '<span id="IdAjaxLocaderGraveSize" style="display:none;">'.image_tag('admin/ajaxLoader.gif').'</span>';

$ssGravePossition 		= (isset($omGraveDetails) && !empty($omGraveDetails) ) ? $omGraveDetails->getMonumentsGravePosition() : '';
$snIdMonumentUnitType 	= (isset($omGraveDetails) && !empty($omGraveDetails) ) ? $omGraveDetails->getMonumentsUnitType() : '';
$ssMonuments			= (isset($omGraveDetails) && !empty($omGraveDetails) ) ? $omGraveDetails->getMonument() : '';
$snIdStoneMason 		= (isset($omGraveDetails) && !empty($omGraveDetails) ) ? $omGraveDetails->getCemStonemasonId() : '';
$ssGraveDepth 			= (isset($omGraveDetails) && !empty($omGraveDetails) ) ? $omGraveDetails->getMonumentsDepth() : '';
$ssGraveLength 			= (isset($omGraveDetails) && !empty($omGraveDetails) ) ? $omGraveDetails->getMonumentsWidth() : '';
$ssGraveWidth			= (isset($omGraveDetails) && !empty($omGraveDetails) ) ? $omGraveDetails->getMonumentsLength() : '';

echo javascript_tag("
	if($('#service_grave_length').val() == 'Length' || $('#service_grave_length').val() == '')			
		jQuery('#service_grave_length').val('Length');

	if($('#service_grave_width').val() == 'Width' || $('#service_grave_width').val() == '')
		jQuery('#service_grave_width').val('Width');

	if($('#service_grave_depth').val() == 'Height' || $('#service_grave_depth').val() == '')
		jQuery('#service_grave_depth').val('Height');
	
	jQuery(document).ready(function()
	{
		if($('#service_grave_comment1').val() == 'Comment1' || $('#service_grave_comment1').val() == '')
			jQuery('#service_grave_comment1').val('Comment1');
		
		if($('#service_grave_comment2').val() == 'Comment2' || $('#service_grave_comment2').val() == '')
			jQuery('#service_grave_comment2').val('Comment2');
			
		showHideGraveComment();
	});
	function showHideGraveComment()
	{
		if( $('#service_ar_grave_id').val() != '')
			$('#grave_comments').show();
		else
			$('#grave_comments').hide();
	}
		
	// Set Monuments values.	
	$('#service_monuments_grave_position').val('".$ssGravePossition."');
	$('#service_monuments_unit_type').val('".$snIdMonumentUnitType."');
	$('#service_monument').val('".$ssMonuments."');
	$('#service_cem_stonemason_id').val('".$snIdStoneMason."');
	$('#service_monuments_depth').val('".$ssGraveDepth."');
	$('#service_monuments_length').val('".$ssGraveLength."');
	$('#service_monuments_width').val('".$ssGraveWidth."');
");
