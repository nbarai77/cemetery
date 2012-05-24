<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
	<td valign="middle" align="right" >
		<?php //echo __('Grave Position');?>
		<?php echo $oIntermentBookingForm['monuments_grave_position']->renderLabel($oIntermentBookingForm['monuments_grave_position']->renderLabelName());?>
	</td>

	<td valign="middle"  colspan="3">
		<?php /*echo input_tag('service_monuments_grave_position', (isset($omGraveDetails) && !empty($omGraveDetails) ) ? $omGraveDetails->getMonumentsGravePosition() : (isset($ssGravePosition) ? $ssGravePosition : ''),
					array('tabindex'=> 32,'class'=>'inputBoxWidth'));*/?>		
		
		<?php echo $oIntermentBookingForm['monuments_grave_position']->render(array('value' => (isset($omGraveDetails) && !empty($omGraveDetails) ) ? $omGraveDetails->getMonumentsGravePosition() : (isset($ssGravePosition) ? $ssGravePosition : ''),'class'=>'inputBoxWidth')); ?>
	</td>
</tr>							
<tr>
	<td valign="middle" align="right" >		
		<?php echo __('Monument');?>
	</td>	
	<td valign="middle" >
		<?php echo input_tag('service_monument', (isset($omGraveDetails) && !empty($omGraveDetails) ) ? $omGraveDetails->getMonument() : (isset($ssMonuments) ? $ssMonuments : ''),
					array('tabindex'=> 32,'class'=>'inputBoxWidth'));?>
	</td>
	<td valign="middle" align="right">
		<?php echo __('Stone Mason');?>
	</td>	
	<td valign="middle" >
		<?php 
			echo select_tag('service_cem_stonemason_id', options_for_select($amStoneMason , (isset($omGraveDetails) && !empty($omGraveDetails) ) ? $omGraveDetails->getCemStonemasonId() : (isset($snIdStoneMason) ? $snIdStoneMason : ''), 'include_custom='.__('Select Stone Mason')),
					array('tabindex'=>30));
		?>
	</td>
</tr>
<tr>
	<td valign="middle" align="right" >
		<?php echo __('Block/Plot Unit Type');?>
	</td>	
	<td valign="middle" >
		<?php 
			echo select_tag('service_monuments_unit_type', options_for_select($amGraveUnitType , (isset($omGraveDetails) && !empty($omGraveDetails) ) ? $omGraveDetails->getMonumentsUnitType() : (isset($snIdMonumentUnitType) ? $snIdMonumentUnitType : ''), 'include_custom='.__('Select Unit Type')),
					array('tabindex'=>30));
		?>
	</td>
	<td valign="middle" align="right" >
		<?php echo __('Depth');?>
	</td>	
	<td valign="middle" >
		<?php echo input_tag('service_monuments_depth', (isset($omGraveDetails) && !empty($omGraveDetails) ) ? $omGraveDetails->getMonumentsDepth() : (isset($ssGraveDepth) ? $ssGraveDepth : ''),
					array('tabindex'=> 32,'class'=>'inputBoxWidth'));?>
	</td>
</tr>
<tr>
	<td valign="middle" align="right">
		<?php echo __('Length');?>
	</td>	
	<td valign="middle">
		<?php echo input_tag('service_monuments_length', (isset($omGraveDetails) && !empty($omGraveDetails) ) ? $omGraveDetails->getMonumentsLength() : (isset($ssGraveLength) ? $ssGraveLength : ''),
					array('tabindex'=> 32,'class'=>'inputBoxWidth'));?>
	</td>
	<td valign="middle" align="right">
		<?php echo __('Width');?>
	</td>	
	<td valign="middle">
		<?php echo input_tag('service_monuments_width', (isset($omGraveDetails) && !empty($omGraveDetails) ) ? $omGraveDetails->getMonumentsWidth() : (isset($ssGraveWidth) ? $ssGraveWidth : ''),
					array('tabindex'=> 32,'class'=>'inputBoxWidth'));?>
	</td>
</tr>
</table>