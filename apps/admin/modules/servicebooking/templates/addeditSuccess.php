<?php  use_javascript('/sfFormExtraPlugin/js/double_list.js');
use_javascript('jquery-ui-timepicker-addon.js');
use_stylesheet('jquery-ui-timepicker-addon.css');
use_javascript('nyroModal/jquery.nyroModal.custom.js');
use_stylesheet('nyroModal/nyroModal');

$ssAction = ($sf_user->getAttribute('interments') == 1) ? 'interment' : 'index';
$ssName = $ssSuname = $smControlNumber = '';
if(!$oIntermentBookingForm->getObject()->isNew()):
	$ssName		= $oIntermentBookingForm->getObject()->getDeceasedTitle().'&nbsp;'.$oIntermentBookingForm->getObject()->getDeceasedFirstName().'&nbsp;'.$oIntermentBookingForm->getObject()->getDeceasedMiddleName();
	$ssSuname	= $oIntermentBookingForm->getObject()->getDeceasedSurname();
	$smControlNumber = $oIntermentBookingFourForm->getObject()->getControlNumber();
endif;

$ssNameHeading = trim($ssName).'&nbsp;'.trim($ssSuname);
$ssInnerHeading =($sf_user->getAttribute('interments') == 1) ? __('Interment Details') :  __('Booking Details');

if($sf_params->get('back') == true)
	$ssCancelUrl = 'intermentsearch/search?back=true';
else
	$ssCancelUrl = $sf_params->get('module').'/'.$ssAction.'?'.html_entity_decode($amExtraParameters['ssQuerystr']);

?>

<div id="wapper">
<?php 

echo $oIntermentBookingForm->renderFormTag(
url_for($sf_params->get('module').'/'.$sf_params->get('action').(!$oIntermentBookingForm->getObject()->isNew() ? '?id='.$oIntermentBookingForm->getObject()->getId().'&'.html_entity_decode($amExtraParameters['ssQuerystr']) : '')), 
array("name" => $oIntermentBookingForm->getName(), "method" => "post" ,'enctype'=>'multipart/form-data')
);
?>
<div class="comment_list"></div>
<h1><?php echo $ssNameHeading;?></h1>
<h1 style="padding-left:20%;"><?php echo __('Interment Date:').'&nbsp;'.$ssIntermentDate;?></h1>
<h1 style="padding-left:25%;"><?php echo __('Control Number:').'&nbsp;'.$smControlNumber;?></h1>
<div id="message">
<div id="success_msgs">
	<?php echo include_partial('global/notification_msg', array('amSuccessMsg' => $amSuccessMsg,'amErrorMsg' => $amErrorMsg));?>
</div>
</div>
<div class="clearb"></div>    
<ul class="tab_content">
<li id="booking_step1" class="active">
	<?php 
		echo link_to_function(
			__('Booking Details'), 
			'tabSelection("step1", "active");$("#service_service_type_id").focus();', 
			array('title' => __('Booking Details'))
		); 
	?>
</li>
<li id="booking_step2">
	<?php
		$ssFocusId = ($sf_user->isSuperAdmin()) ? 'service_country_id' : 'service_ar_area_id';
		echo link_to_function(
			__('Allocation Details'), 
			'tabSelection("step2", "active");$("#'.$ssFocusId.'").focus();', 
			array('title' => __('Allocation Details'))
		); 
	?>
</li>
<li id="booking_step3">
	<?php
		echo link_to_function(
			__('Final Booking Checklist'), 
			'tabSelection("step3", "active");$("#servicethree_file_location").focus();', 
			array('title' => __('Final Booking Checklist'))
		); 
	?>
</li>
<li id="booking_step4">
	<?php
		echo link_to_function(
			__('Deceased Details'), 
			'tabSelection("step4", "active");$("#servicefour_control_number").focus();', 
			array('title' => __('Deceased Details'))
		); 
	?>
</li>
<li id="booking_step5">
	<?php
		echo link_to_function(
			__('Applicant Details'), 
			'tabSelection("step5", "active");$("#informant_relationship_to_deceased").focus();', 
			array('title' => __('Applicant Details'))
		); 
	?>
</li>
<li id="booking_step6">
	<?php
		echo link_to_function(
			__('Letters & Mailout'), 
			'tabSelection("step6", "active");$("#new_grave_inscription").focus();', 
			array('title' => __('Letters & Mailout'))
		); 
	?>
</li>
</ul>
<div id="main">
<div class="maintablebg">
	<div class="main_cont">
		<div class="left_part" style="width:100%">
			<div id="step1">
				<?php
					echo $oIntermentBookingForm->renderFormTag(
						url_for($sf_params->get('module').'/'.$sf_params->get('action').(!$oIntermentBookingForm->getObject()->isNew() ? '?id='.$oIntermentBookingForm->getObject()->getId().'&tab=step1&'.html_entity_decode($amExtraParameters['ssQuerystr']) : '?tab=step1')), 
						array("name" => $oIntermentBookingForm->getName(), "method" => "post" ,'enctype'=>'multipart/form-data')
					);
				?>
				<table width="100%" border="0" cellspacing="0" cellpadding="0" class="sub_table">
					<tr class="odd">
						<td valign="middle" align="right"  colspan="4">									
							<b><?php echo $ssInnerHeading;?></b>
						</td>
					</tr>

					<tr class="even">
						<td valign="middle" align="right" >
							<?php echo $oIntermentBookingForm['service_type_id']->renderLabel($oIntermentBookingForm['service_type_id']->renderLabelName());?>
						</td>
						<td valign="middle">
							<?php 
								if($oIntermentBookingForm['service_type_id']->hasError()):
									echo $oIntermentBookingForm['service_type_id']->renderError();
								endif;
								echo $oIntermentBookingForm['service_type_id']->render(array('class'=>'inputBoxWidth')); 
							?>
						</td>
						<?php if($sf_user->getAttribute('groupid') != sfConfig::get('app_cemrole_funeraldirector')):?>
						<td valign="middle" align="right">
							<?php echo $oIntermentBookingForm['confirmed']->renderLabel($oIntermentBookingForm['confirmed']->renderLabelName());?>
						</td>
						<td valign="middle" align="left">
							<?php 
								if($oIntermentBookingForm['confirmed']->hasError()):
									echo $oIntermentBookingForm['confirmed']->renderError();
								endif;
								echo $oIntermentBookingForm['confirmed']->render(); 
							?>
						</td>
						<?php elseif(!$oIntermentBookingForm->getObject()->isNew()):?>
						<td valign="middle" align="right">
							<?php echo __('Confirmed');?>
						</td>
						<td valign="middle" align="left">
							<?php $ssConfirmed = ($oIntermentBookingForm->getObject()->getConfirmed() == 1) ? __('Yes') : __('No');?>
							&nbsp;&nbsp;&nbsp;<strong><?php echo $ssConfirmed;?></strong>
						</td>
						<?php endif;?>
					</tr>
                    <tr class="even">
						<td valign="middle" align="right" >
							<?php echo __('Select Catalog');//echo $oIntermentBookingForm['catalog_id']->renderLabel($oIntermentBookingForm['catalog_id ']->renderLabelName());?>
						</td>
						<td valign="middle">
							<?php 
								if($oIntermentBookingForm['catalog_id']->hasError()):
									echo $oIntermentBookingForm['catalog_id']->renderError();
								endif;
								echo $oIntermentBookingForm['catalog_id']->render(array('class'=>'inputBoxWidth')); 
							?>
						</td>
						<?php //if($sf_user->getAttribute('groupid') != sfConfig::get('app_cemrole_funeraldirector')):?>
						<td valign="middle" align="right">
							<?php echo $oIntermentBookingForm['payment_id']->renderLabel($oIntermentBookingForm['payment_id']->renderLabelName());?>
						</td>
						<td valign="middle" align="left">
							<?php 
								if($oIntermentBookingForm['payment_id']->hasError()):
									echo $oIntermentBookingForm['payment_id']->renderError();
								endif;
								echo $oIntermentBookingForm['payment_id']->render(); 
							?>
						</td>
						<?php /*elseif(!$oIntermentBookingForm->getObject()->isNew()):?>
						<td valign="middle" align="right">
							<?php echo __('Confirmed');?>
						</td>
						<td valign="middle" align="left">
							<?php $ssConfirmed = ($oIntermentBookingForm->getObject()->getConfirmed() == 1) ? __('Yes') : __('No');?>
							&nbsp;&nbsp;&nbsp;<strong><?php echo $ssConfirmed;?></strong>
						</td>
						<?php endif;*/?>
					</tr>
					<tr class="odd">
						<td valign="middle" align="right" >
							<?php echo $oIntermentBookingForm['date_notified']->renderLabel($oIntermentBookingForm['date_notified']->renderLabelName());?>
						</td>	
						<td valign="middle" width="25%">
							<?php 
								if($oIntermentBookingForm['date_notified']->hasError()):
									echo $oIntermentBookingForm['date_notified']->renderError();
								endif;
								echo $oIntermentBookingForm['date_notified']->render(array('class'=>'inputBoxWidth')); 
							?>
						</td>
						<td valign="middle" align="right">
							<?php echo __('Taken By');?>
						</td>	
						<td valign="middle">
							&nbsp;&nbsp;&nbsp;
							<?php if($oIntermentBookingForm->getObject()->isNew()):?>
							<strong>
								<?php echo $sf_user->getAttribute('firstname','','sfGuardSecurityUser').'&nbsp;'.$sf_user->getAttribute('lastname','','sfGuardSecurityUser');?>
							</strong>
							<?php else:?>
							<strong>
								<?php echo $ssTakenBy;?>
							</strong>
							<?php endif;?>
						</td>
					</tr>
					<tr class="even">
						<td valign="middle" align="right" >
							<?php echo $oIntermentBookingForm['fnd_fndirector_id']->renderLabel($oIntermentBookingForm['fnd_fndirector_id']->renderLabelName());?>
						</td>	
						<td valign="middle" >
							<?php 
								if($oIntermentBookingForm['fnd_fndirector_id']->hasError()):
									echo $oIntermentBookingForm['fnd_fndirector_id']->renderError();
								endif;
								echo $oIntermentBookingForm['fnd_fndirector_id']->render(array('class'=>'inputBoxWidth')); 
							?>
						</td>
						<td valign="middle" align="right" >
							<?php echo $oIntermentBookingForm['consultant']->renderLabel($oIntermentBookingForm['consultant']->renderLabelName());?>
						</td>	
						<td valign="middle" >
							<?php 
								if($oIntermentBookingForm['consultant']->hasError()):
									echo $oIntermentBookingForm['consultant']->renderError();
								endif;
								echo $oIntermentBookingForm['consultant']->render(array('class'=>'inputBoxWidth')); 
							?>
						</td>
					</tr>
					<tr class="odd">
						<td valign="middle" align="right" >
							<?php echo $oIntermentBookingForm['service_date']->renderLabel($oIntermentBookingForm['service_date']->renderLabelName());?>
						</td>	
						<td valign="middle" width="30%">
							<?php 
								if($oIntermentBookingForm['service_date']->hasError()):
									echo $oIntermentBookingForm['service_date']->renderError();
								endif;
								echo $oIntermentBookingForm['service_date']->render();
								echo $oIntermentBookingForm['date1_day']->render();
							?>
						</td>
						<td valign="middle" align="left" colspan="2">
							<div class="fleft" style="padding:6px 10px; width:70px;">
								<?php echo $oIntermentBookingForm['service_booking_time_from']->renderLabel($oIntermentBookingForm['service_booking_time_from']->renderLabelName());?>
							</div>
							<div class="fleft">
								<?php 
									if($oIntermentBookingForm['service_booking_time_from']->hasError()):
										echo $oIntermentBookingForm['service_booking_time_from']->renderError();
									endif;
									echo $oIntermentBookingForm['service_booking_time_from']->render();
								?>
							</div>
							<div class="fleft" style="padding:6px 10px; width:70px;">
								<?php echo $oIntermentBookingForm['service_booking_time_to']->renderLabel($oIntermentBookingForm['service_booking_time_to']->renderLabelName());?>
							</div>
							<div class="fleft">
								<?php 
									if($oIntermentBookingForm['service_booking_time_to']->hasError()):
										echo $oIntermentBookingForm['service_booking_time_to']->renderError();
									endif;
									echo $oIntermentBookingForm['service_booking_time_to']->render(); 
								?>
							</div>
						</td>							
					</tr>
					<tr class="even">
						<td valign="middle" align="right" >
							<?php echo $oIntermentBookingForm['service_date2']->renderLabel($oIntermentBookingForm['service_date2']->renderLabelName());?>
						</td>	
						<td valign="middle">
							<?php 
								if($oIntermentBookingForm['service_date2']->hasError()):
									echo $oIntermentBookingForm['service_date2']->renderError();
								endif;
								echo $oIntermentBookingForm['service_date2']->render();
								echo $oIntermentBookingForm['date2_day']->render();
							?>
						</td>
						<td valign="middle" align="left" colspan="2">
							<div class="fleft" style="padding:6px 10px; width:70px;">
								<?php echo $oIntermentBookingForm['service_booking2_time_from']->renderLabel($oIntermentBookingForm['service_booking2_time_from']->renderLabelName());?>
							</div>
							<div class="fleft">
								<?php 
									if($oIntermentBookingForm['service_booking2_time_from']->hasError()):
										echo $oIntermentBookingForm['service_booking2_time_from']->renderError();
									endif;
									echo $oIntermentBookingForm['service_booking2_time_from']->render();
								?>
							</div>
							<div class="fleft" style="padding:6px 10px; width:70px;">
								<?php echo $oIntermentBookingForm['service_booking2_time_to']->renderLabel($oIntermentBookingForm['service_booking2_time_to']->renderLabelName());?>
							</div>
							<div class="fleft">
								<?php 
									if($oIntermentBookingForm['service_booking2_time_to']->hasError()):
										echo $oIntermentBookingForm['service_booking2_time_to']->renderError();
									endif;
									echo $oIntermentBookingForm['service_booking2_time_to']->render(); 
								?>
							</div>
						</td>
					</tr>
					<tr class="odd">
						<td valign="middle" align="right" >
							<?php echo $oIntermentBookingForm['service_date3']->renderLabel($oIntermentBookingForm['service_date3']->renderLabelName());?>
						</td>	
						<td valign="middle">
							<?php 
								if($oIntermentBookingForm['service_date3']->hasError()):
									echo $oIntermentBookingForm['service_date3']->renderError();
								endif;
								echo $oIntermentBookingForm['service_date3']->render();
								echo $oIntermentBookingForm['date3_day']->render();
							?>
						</td>
						<td valign="middle" align="left" colspan="2">
							<div class="fleft" style="padding:6px 10px; width:70px;">
								<?php echo $oIntermentBookingForm['service_booking3_time_from']->renderLabel($oIntermentBookingForm['service_booking3_time_from']->renderLabelName());?>
							</div>
							<div class="fleft">
								<?php 
									if($oIntermentBookingForm['service_booking3_time_from']->hasError()):
										echo $oIntermentBookingForm['service_booking3_time_from']->renderError();
									endif;
									echo $oIntermentBookingForm['service_booking3_time_from']->render();
								?>
							</div>
							<div class="fleft" style="padding:6px 10px; width:70px;">
								<?php echo $oIntermentBookingForm['service_booking3_time_to']->renderLabel($oIntermentBookingForm['service_booking3_time_to']->renderLabelName());?>
							</div>
							<div class="fleft">
								<?php 
									if($oIntermentBookingForm['service_booking3_time_to']->hasError()):
										echo $oIntermentBookingForm['service_booking3_time_to']->renderError();
									endif;
									echo $oIntermentBookingForm['service_booking3_time_to']->render(); 
								?>
							</div>
						</td>
					</tr>
					<tr class="even">
						<td valign="middle" align="right">
							<?php echo $oIntermentBookingForm['deceased_title']->renderLabel($oIntermentBookingForm['deceased_title']->renderLabelName());?>
						</td>	
						<td valign="middle" colspan="3">
							<?php 
								if($oIntermentBookingForm['deceased_title']->hasError()):
									echo $oIntermentBookingForm['deceased_title']->renderError();
								endif;
								echo $oIntermentBookingForm['deceased_title']->render(array('class'=>'inputBoxWidth'));
							?>
						</td>
					</tr>
					
					<tr class="odd">
						<td valign="middle" align="right" >
							<?php echo $oIntermentBookingForm['deceased_surname']->renderLabel($oIntermentBookingForm['deceased_surname']->renderLabelName()."<span class='redText'>*</span>");?>
						</td>	
						<td valign="middle" >
							<?php 
								if($oIntermentBookingForm['deceased_surname']->hasError()):
									echo $oIntermentBookingForm['deceased_surname']->renderError();
								endif;
								echo $oIntermentBookingForm['deceased_surname']->render(array('class'=>'inputBoxWidth')); 
							?>
						</td>
						<td valign="middle" align="right" >
							<?php echo $oIntermentBookingForm['deceased_other_surname']->renderLabel($oIntermentBookingForm['deceased_other_surname']->renderLabelName());?>
						</td>	
						<td valign="middle" >
							<?php 
								if($oIntermentBookingForm['deceased_other_surname']->hasError()):
									echo $oIntermentBookingForm['deceased_other_surname']->renderError();
								endif;
								echo $oIntermentBookingForm['deceased_other_surname']->render(array('class'=>'inputBoxWidth')); 
							?>
						</td>
					</tr>
					<tr class="even">
						<td valign="middle" align="right" >
							<?php echo $oIntermentBookingForm['deceased_first_name']->renderLabel($oIntermentBookingForm['deceased_first_name']->renderLabelName()."<span class='redText'>*</span>");?>
						</td>	
						<td valign="middle" >
							<?php 
								if($oIntermentBookingForm['deceased_first_name']->hasError()):
									echo $oIntermentBookingForm['deceased_first_name']->renderError();
								endif;
								echo $oIntermentBookingForm['deceased_first_name']->render(array('class'=>'inputBoxWidth')); 
							?>
						</td>
						<td valign="middle" align="right" >
							<?php echo $oIntermentBookingForm['deceased_other_first_name']->renderLabel($oIntermentBookingForm['deceased_other_first_name']->renderLabelName());?>
						</td>	
						<td valign="middle" >
							<?php 
								if($oIntermentBookingForm['deceased_other_first_name']->hasError()):
									echo $oIntermentBookingForm['deceased_other_first_name']->renderError();
								endif;
								echo $oIntermentBookingForm['deceased_other_first_name']->render(array('class'=>'inputBoxWidth')); 
							?>
						</td>
					</tr>
					<tr class="odd">
						<td valign="middle" align="right" >
							<?php echo $oIntermentBookingForm['deceased_middle_name']->renderLabel($oIntermentBookingForm['deceased_middle_name']->renderLabelName());?>
						</td>	
						<td valign="middle" >
							<?php 
								if($oIntermentBookingForm['deceased_middle_name']->hasError()):
									echo $oIntermentBookingForm['deceased_middle_name']->renderError();
								endif;
								echo $oIntermentBookingForm['deceased_middle_name']->render(array('class'=>'inputBoxWidth')); 
							?>
						</td>
						<td valign="middle" align="right" >
							<?php echo $oIntermentBookingForm['deceased_other_middle_name']->renderLabel($oIntermentBookingForm['deceased_other_middle_name']->renderLabelName());?>
						</td>	
						<td valign="middle" >
							<?php 
								if($oIntermentBookingForm['deceased_other_middle_name']->hasError()):
									echo $oIntermentBookingForm['deceased_other_middle_name']->renderError();
								endif;
								echo $oIntermentBookingForm['deceased_other_middle_name']->render(array('class'=>'inputBoxWidth')); 
							?>
						</td>
					</tr>
					<tr class="even">
						<td valign="middle" align="right">
							<?php echo $oIntermentBookingForm['deceased_gender']->renderLabel($oIntermentBookingForm['deceased_gender']->renderLabelName());?>
						</td>	
						<td valign="middle"  colspan="3">
							<?php 
								if($oIntermentBookingForm['deceased_gender']->hasError()):
									echo $oIntermentBookingForm['deceased_gender']->renderError();
								endif;
								echo $oIntermentBookingForm['deceased_gender']->render(array('class'=>'RadioBox')); 
							?>
						</td>								
					</tr>
					<tr class="odd">
						<td colspan="4" align="left">
							<b><?php echo __('Other Details');?></b>
						</td>
					</tr>
					<tr class="even">
						<td valign="middle" align="right" width="15%">
							<?php echo $oIntermentBookingForm['other_details']['coffin_type_id']->renderLabel($oIntermentBookingForm['other_details']['coffin_type_id']->renderLabelName());?>
						</td>	
						<td valign="middle" >
							<?php 
								if($oIntermentBookingForm['other_details']['coffin_type_id']->hasError()):
									echo $oIntermentBookingForm['other_details']['coffin_type_id']->renderError();
								endif;
								echo $oIntermentBookingForm['other_details']['coffin_type_id']->render(array('class'=>'inputBoxWidth')); 
							?>
						</td>
						<td valign="middle" align="right" >
							<?php echo $oIntermentBookingForm['other_details']['unit_type_id']->renderLabel($oIntermentBookingForm['other_details']['unit_type_id']->renderLabelName());?>
						</td>	
						<td valign="middle" >
							<?php 
								if($oIntermentBookingForm['other_details']['unit_type_id']->hasError()):
									echo $oIntermentBookingForm['other_details']['unit_type_id']->renderError();
								endif;
								echo $oIntermentBookingForm['other_details']['unit_type_id']->render(array('class'=>'inputBoxWidth')); 
							?>
						</td>
					</tr>
					<tr class="odd">
						<td valign="middle" align="right" >
							<?php echo $oIntermentBookingForm['other_details']['coffin_length']->renderLabel($oIntermentBookingForm['other_details']['coffin_length']->renderLabelName());?>
						</td>	
						<td valign="middle" >
							<?php 
								if($oIntermentBookingForm['other_details']['coffin_length']->hasError()):
									echo $oIntermentBookingForm['other_details']['coffin_length']->renderError();
								endif;
								echo $oIntermentBookingForm['other_details']['coffin_length']->render(array('class'=>'inputBoxWidth')); 
							?>
						</td>
						<td valign="middle" align="right" >
							<?php echo $oIntermentBookingForm['other_details']['coffin_width']->renderLabel($oIntermentBookingForm['other_details']['coffin_width']->renderLabelName());?>
						</td>	
						<td valign="middle" >
							<?php 
								if($oIntermentBookingForm['other_details']['coffin_width']->hasError()):
									echo $oIntermentBookingForm['other_details']['coffin_width']->renderError();
								endif;
								echo $oIntermentBookingForm['other_details']['coffin_width']->render(array('class'=>'inputBoxWidth')); 
							?>
						</td>
					</tr>
					<tr class="even">
						<td valign="middle" align="right" >
							<?php echo $oIntermentBookingForm['other_details']['coffin_height']->renderLabel($oIntermentBookingForm['other_details']['coffin_height']->renderLabelName());?>
						</td>	
						<td valign="middle" >
							<?php 
								if($oIntermentBookingForm['other_details']['coffin_height']->hasError()):
									echo $oIntermentBookingForm['other_details']['coffin_height']->renderError();
								endif;
								echo $oIntermentBookingForm['other_details']['coffin_height']->render(array('class'=>'inputBoxWidth')); 
							?>
						</td>
						<td valign="middle" align="right" >
							<?php echo $oIntermentBookingForm['other_details']['coffin_surcharge']->renderLabel($oIntermentBookingForm['other_details']['coffin_surcharge']->renderLabelName());?>
						</td>	
						<td valign="middle" >
							<?php 
								if($oIntermentBookingForm['other_details']['coffin_surcharge']->hasError()):
									echo $oIntermentBookingForm['other_details']['coffin_surcharge']->renderError();
								endif;
								echo $oIntermentBookingForm['other_details']['coffin_surcharge']->render(array('class'=>'RadioBox')); 
							?>
						</td>
					</tr>
					<tr class="odd">
						<td valign="middle" align="right" >
							<?php echo $oIntermentBookingForm['other_details']['death_certificate']->renderLabel($oIntermentBookingForm['other_details']['death_certificate']->renderLabelName());?>
						</td>	
						<td valign="middle" >
							<?php 
								if($oIntermentBookingForm['other_details']['death_certificate']->hasError()):
									echo $oIntermentBookingForm['other_details']['death_certificate']->renderError();
								endif;
								echo $oIntermentBookingForm['other_details']['death_certificate']->render(array('class'=>'RadioBox')); 
							?>
						</td>
						<td valign="middle" align="right" >
							<?php echo $oIntermentBookingForm['other_details']['disease_id']->renderLabel($oIntermentBookingForm['other_details']['disease_id']->renderLabelName());?>
						</td>	
						<td valign="middle" >
							<?php 
								if($oIntermentBookingForm['other_details']['disease_id']->hasError()):
									echo $oIntermentBookingForm['other_details']['disease_id']->renderError();
								endif;
								echo $oIntermentBookingForm['other_details']['disease_id']->render(array('class'=>'inputBoxWidth')); 
							?>
						</td>
					</tr>
					<tr class="even">
						<td valign="middle" align="right" >
							<?php echo $oIntermentBookingForm['other_details']['own_clergy']->renderLabel($oIntermentBookingForm['other_details']['own_clergy']->renderLabelName());?>
						</td>	
						<td valign="middle" >
							<?php 
								if($oIntermentBookingForm['other_details']['own_clergy']->hasError()):
									echo $oIntermentBookingForm['other_details']['own_clergy']->renderError();
								endif;
								echo $oIntermentBookingForm['other_details']['own_clergy']->render(array('class'=>'RadioBox')); 
							?>
						</td>
						<td valign="middle" align="right" >
							<?php echo $oIntermentBookingForm['other_details']['clergy_name']->renderLabel($oIntermentBookingForm['other_details']['clergy_name']->renderLabelName());?>
						</td>	
						<td valign="middle" >
							<?php 
								if($oIntermentBookingForm['other_details']['clergy_name']->hasError()):
									echo $oIntermentBookingForm['other_details']['clergy_name']->renderError();
								endif;
								echo $oIntermentBookingForm['other_details']['clergy_name']->render(array('class'=>'inputBoxWidth')); 
							?>
						</td>
					</tr>
					<tr class="odd">
						<td valign="middle" align="right" >
							<?php echo $oIntermentBookingForm['other_details']['chapel']->renderLabel($oIntermentBookingForm['other_details']['chapel']->renderLabelName() );?>
						</td>

						<td valign="middle" align="middle" colspan="3">
							<?php 
								if($oIntermentBookingForm['other_details']['chapel']->hasError()):
									echo $oIntermentBookingForm['other_details']['chapel']->renderError();
								endif;
								echo $oIntermentBookingForm['other_details']['chapel']->render(array('class'=>'RadioBox')); 
							?>
						</td>
					</tr>
					<tr id="chapeldiv" style="display:none;" class="odd">
						<td>&nbsp;</td>
						<td colspan="3" align="left">
							<div>											
								<?php 
									if($sf_user->isSuperAdmin()):
										include_partial('facilitybooking/getChapelTypes', array('amChapelUnAssociated' => $amChapelUnAssociated, 
																								'amChapelAssociated' => $amChapelAssociated)); 
									else:
										echo '<div class="fleft">';
											if($oIntermentBookingForm['other_details']['chapel_grouplist']->hasError()):
												echo $oIntermentBookingForm['other_details']['chapel_grouplist']->renderError();
											endif;
											echo __('Select Chapel');
											echo $oIntermentBookingForm['other_details']['chapel_grouplist']->render();
										echo '</div>';
									endif;
								?>
								<div class="pad_10" style="width:50px; float:left;">
									<?php echo $oIntermentBookingForm['other_details']['chapel_time_from']->renderLabel($oIntermentBookingForm['other_details']['chapel_time_from']->renderLabelName() );?>
								</div>
								<div class="fleft">
									<?php 
										if($oIntermentBookingForm['other_details']['chapel_time_from']->hasError()):
											echo $oIntermentBookingForm['other_details']['chapel_time_from']->renderError();
										endif;
										echo $oIntermentBookingForm['other_details']['chapel_time_from']->render(); ?>
								</div>
								<div class="pad_10 padL5" style="width:15px; float:left;">
									<?php echo $oIntermentBookingForm['other_details']['chapel_time_to']->renderLabel($oIntermentBookingForm['other_details']['chapel_time_to']->renderLabelName() );?>
								</div>
								<div>
									<?php 
										if($oIntermentBookingForm['other_details']['chapel_time_to']->hasError()):
											echo $oIntermentBookingForm['other_details']['chapel_time_to']->renderError();
										endif;
										echo $oIntermentBookingForm['other_details']['chapel_time_to']->render(); ?>
								</div>										
							</div>
						</td>
					</tr>							
					<tr class="even">
						<td valign="middle" align="right" >
							<?php echo $oIntermentBookingForm['other_details']['room']->renderLabel($oIntermentBookingForm['other_details']['room']->renderLabelName() );?>
						</td>

						<td valign="middle" colspan="3">
							<?php 
								if($oIntermentBookingForm['other_details']['room']->hasError()):
									echo $oIntermentBookingForm['other_details']['room']->renderError();
								endif;
								echo $oIntermentBookingForm['other_details']['room']->render(array('class'=>'RadioBox')); 
							?>
						</td>								
					</tr>
					<tr id="roomydiv" style="display:none;" class="even">
						<td>&nbsp;</td>
						<td valign="middle" colspan="3">
							<div>
								<?php 
									if($sf_user->isSuperAdmin()):
										include_partial('facilitybooking/getRoomTypes', array('amRoomUnAssociated' => $amRoomUnAssociated, 
																							  'amRoomAssociated' => $amRoomAssociated)); 
									else:
										echo '<div class="fleft">';
											if($oIntermentBookingForm['other_details']['room_grouplist']->hasError()):
												echo $oIntermentBookingForm['other_details']['room_grouplist']->renderError();
											endif;											 
											echo __('Select Rooms');
											echo $oIntermentBookingForm['other_details']['room_grouplist']->render();
										echo '</div>';
									endif;
								?>								
								<div class="fleft pad_10" style="width:32px; float:left; padding:0 0 0 18px;">
									<?php echo $oIntermentBookingForm['other_details']['room_time_from']->renderLabel($oIntermentBookingForm['other_details']['room_time_from']->renderLabelName() );?>
								</div>
								<div class="fleft">
									<?php 
										if($oIntermentBookingForm['other_details']['room_time_from']->hasError()):
											echo $oIntermentBookingForm['other_details']['room_time_from']->renderError();
										endif;
										echo $oIntermentBookingForm['other_details']['room_time_from']->render(); ?>
								</div>
								<div class="fleft pad_10 padL5" style="width:15px; float:left;">
									<?php echo $oIntermentBookingForm['other_details']['room_time_to']->renderLabel($oIntermentBookingForm['other_details']['room_time_to']->renderLabelName() );?>
								</div>
								<div class="fleft">
									<?php 
										if($oIntermentBookingForm['other_details']['room_time_to']->hasError()):
											echo $oIntermentBookingForm['other_details']['room_time_to']->renderError();
										endif;
										echo $oIntermentBookingForm['other_details']['room_time_to']->render(); ?>
								</div>										
							</div>
						</td>
					</tr>
					<tr class="odd">
						<td valign="middle" align="right" >
							<?php echo $oIntermentBookingForm['other_details']['burning_drum']->renderLabel($oIntermentBookingForm['other_details']['burning_drum']->renderLabelName() );?>
						</td>

						<td valign="middle"  colspan="3">
							<?php 
								if($oIntermentBookingForm['other_details']['burning_drum']->hasError()):
									echo $oIntermentBookingForm['other_details']['burning_drum']->renderError();
								endif;
								echo $oIntermentBookingForm['other_details']['burning_drum']->render(array('class'=>'inputBoxWidth')); 
							?>
						</td>
					</tr>
					<tr class="even">
						<td valign="middle" align="right" >
							<?php echo $oIntermentBookingForm['other_details']['fireworks']->renderLabel($oIntermentBookingForm['other_details']['fireworks']->renderLabelName() );?>
						</td>

						<td valign="middle"  colspan="3">
							<?php 
								if($oIntermentBookingForm['other_details']['fireworks']->hasError()):
									echo $oIntermentBookingForm['other_details']['fireworks']->renderError();
								endif;
								echo $oIntermentBookingForm['other_details']['fireworks']->render(array('class'=>'inputBoxWidth')); 
							?>
						</td>
					</tr>
					<tr class="odd">
						<td valign="middle" align="right" >
							<?php echo $oIntermentBookingForm['other_details']['ceremonial_sand']->renderLabel($oIntermentBookingForm['other_details']['ceremonial_sand']->renderLabelName() );?>
						</td>

						<td valign="middle"  colspan="3">
							<?php 
								if($oIntermentBookingForm['other_details']['ceremonial_sand']->hasError()):
									echo $oIntermentBookingForm['other_details']['ceremonial_sand']->renderError();
								endif;
								echo $oIntermentBookingForm['other_details']['ceremonial_sand']->render(array('class'=>'inputBoxWidth')); 
							?>
						</td>
					</tr>
					<tr class="even">
						<td valign="middle" align="right" >
							<?php echo $oIntermentBookingForm['other_details']['canopy']->renderLabel($oIntermentBookingForm['other_details']['canopy']->renderLabelName() );?>
						</td>

						<td valign="middle"  colspan="3">
							<?php 
								if($oIntermentBookingForm['other_details']['canopy']->hasError()):
									echo $oIntermentBookingForm['other_details']['canopy']->renderError();
								endif;
								echo $oIntermentBookingForm['other_details']['canopy']->render(array('class'=>'inputBoxWidth')); 
							?>
						</td>
					</tr>
					<tr class="odd">
						<td valign="middle" align="right" >
							<?php echo $oIntermentBookingForm['other_details']['lowering_device']->renderLabel($oIntermentBookingForm['other_details']['lowering_device']->renderLabelName() );?>
						</td>

						<td valign="middle"  colspan="3">
							<?php 
								if($oIntermentBookingForm['other_details']['lowering_device']->hasError()):
									echo $oIntermentBookingForm['other_details']['lowering_device']->renderError();
								endif;
								echo $oIntermentBookingForm['other_details']['lowering_device']->render(array('class'=>'inputBoxWidth')); 
							?>
						</td>
					</tr>
					<tr class="even">
						<td valign="middle" align="right" >
							<?php echo $oIntermentBookingForm['other_details']['balloons']->renderLabel($oIntermentBookingForm['other_details']['balloons']->renderLabelName() );?>
						</td>

						<td valign="middle"  colspan="3">
							<?php 
								if($oIntermentBookingForm['other_details']['balloons']->hasError()):
									echo $oIntermentBookingForm['other_details']['balloons']->renderError();
								endif;
								echo $oIntermentBookingForm['other_details']['balloons']->render(array('class'=>'inputBoxWidth')); 
							?>
						</td>
					</tr>
					<tr class="odd">
						<td valign="middle" align="right" >
							<?php echo $oIntermentBookingForm['other_details']['chapel_multimedia']->renderLabel($oIntermentBookingForm['other_details']['chapel_multimedia']->renderLabelName() );?>
						</td>

						<td valign="middle"  colspan="3">
							<?php 
								if($oIntermentBookingForm['other_details']['chapel_multimedia']->hasError()):
									echo $oIntermentBookingForm['other_details']['chapel_multimedia']->renderError();
								endif;
								echo $oIntermentBookingForm['other_details']['chapel_multimedia']->render(array('class'=>'inputBoxWidth')); 
							?>
						</td>
					</tr>
					<tr class="even">
						<td valign="middle" align="right" >
							<?php echo $oIntermentBookingForm['other_details']['cost']->renderLabel($oIntermentBookingForm['other_details']['cost']->renderLabelName().'&nbsp;&nbsp;$');?>
						</td>

						<td valign="middle"  colspan="3">
							
							<?php 
								if($oIntermentBookingForm['other_details']['cost']->hasError()):
									echo $oIntermentBookingForm['other_details']['cost']->renderError();
								endif;
								echo $oIntermentBookingForm['other_details']['cost']->render(array('class'=>'inputBoxWidth')); 
							?>
						</td>
					</tr>
					<tr class="odd">
						<td valign="middle" align="right" >
							<?php echo $oIntermentBookingForm['other_details']['receipt_number']->renderLabel($oIntermentBookingForm['other_details']['receipt_number']->renderLabelName() );?>
						</td>

						<td valign="middle"  colspan="3">
							<?php 
								if($oIntermentBookingForm['other_details']['receipt_number']->hasError()):
									echo $oIntermentBookingForm['other_details']['receipt_number']->renderError();
								endif;
								echo $oIntermentBookingForm['other_details']['receipt_number']->render(array('class'=>'inputBoxWidth')); 
							?>
						</td>
					</tr>
					<tr class="even">
						<td valign="middle" align="right" >
							<?php echo $oIntermentBookingForm['other_details']['special_instruction']->renderLabel($oIntermentBookingForm['other_details']['special_instruction']->renderLabelName() );?>
						</td>

						<td valign="middle"  colspan="3">
							<?php 
								if($oIntermentBookingForm['other_details']['special_instruction']->hasError()):
									echo $oIntermentBookingForm['other_details']['special_instruction']->renderError();
								endif;
								echo $oIntermentBookingForm['other_details']['special_instruction']->render(array('class'=>'inputBoxWidth')); 
							?>
						</td>
					</tr>							
					<tr class="odd">
						<td valign="middle" align="right" >
							<?php echo $oIntermentBookingForm['other_details']['notes']->renderLabel($oIntermentBookingForm['other_details']['notes']->renderLabelName() );?>
						</td>

						<td valign="middle"  colspan="3">
							<?php 
								if($oIntermentBookingForm['other_details']['notes']->hasError()):
									echo $oIntermentBookingForm['other_details']['notes']->renderError();
								endif;
								echo $oIntermentBookingForm['other_details']['notes']->render(array('class'=>'inputBoxWidth')); 
							?>
						</td>
					</tr>
					<tr class="odd">
						<td>&nbsp;</td>
						<td valign="middle" colspan="3">
							<div class="actions">
								<ul class="fleft">
									<li class="list1">
										<span>
											<?php 
												echo submit_tag(
													__('Save & Continue'), 
													array(
														'class'     => 'delete',
														'name'      => 'submit_button',
														'title'     => __('Save & Continue'), 
														'tabindex'  => 53,
														'onclick'   => "jQuery('#step1Save').val('1');"
													)
												);
											?>
										</span>
									</li>
									<li class="list1">
										<span>
											<?php echo button_to(__('Cancel'),$ssCancelUrl,array('class'=>'delete','title'=>__('Cancel'),'alt'=>__('Cancel'),'tabindex'=>54)); ?>
										</span>
									</li>
								</ul>
							</div>
						</td>
					</tr>
				</table>
				<?php
					echo input_hidden_tag('id', $sf_params->get('id'), array('readonly' => 'true'));
					echo input_hidden_tag('back', $sf_params->get('back'), array('readonly' => 'true'));
					echo input_hidden_tag('tab', ($sf_params->get('tab') ? $sf_params->get('tab') :'step1'), array('readonly' => 'true'));
					echo input_hidden_tag('step1Save', '', array('readonly' => true));
					echo $oIntermentBookingForm->renderHiddenFields(); 
				?></form>
			</div>
			<div id="step2">
				<?php
					echo $oAllocationDetailsForm->renderFormTag(
						url_for($sf_params->get('module').'/'.$sf_params->get('action').(!$oAllocationDetailsForm->getObject()->isNew() ? '?id='.$oAllocationDetailsForm->getObject()->getId().'&tab=step2&'.html_entity_decode($amExtraParameters['ssQuerystr']) : '?tab=step2')), 
						array("name" => $oAllocationDetailsForm->getName(), "method" => "post" ,'enctype'=>'multipart/form-data')
					);
				?>
				<table width="100%" border="0" cellspacing="0" cellpadding="0" class="sub_table">						
					<tr class="odd">
						<td colspan="4" align="left">
							<b><?php echo __('Grave details');?></b>
						</td>
					</tr>
					<?php if($sf_user->isSuperAdmin()):?>
					<tr class="even">
						<td valign="middle" align="right" >
							<?php echo $oAllocationDetailsForm['country_id']->renderLabel($oAllocationDetailsForm['country_id']->renderLabelName());?>
						</td>

						<td valign="middle"  colspan="3">
							<?php 
								if($oAllocationDetailsForm['country_id']->hasError()):
									echo $oAllocationDetailsForm['country_id']->renderError();
								endif;
								echo $oAllocationDetailsForm['country_id']->render(array('class'=>'inputBoxWidth')); 
							?>
						</td>
					</tr>							
					<tr class="odd">
						<td valign="middle" align="right" >
							<?php echo __('Select Cementery');?>
						</td>

						<td valign="middle"  colspan="3">
							<?php 
								if($sf_user->hasFlash('ssErrorCemeter') && $sf_user->getFlash('ssErrorCemeter') != ''):
									echo '<ul class="error_list"><li>'.$sf_user->getFlash('ssErrorCemeter').'</li></ul>';
									$sf_user->setFlash('ssErrorCemeter','');
								endif;
								include_partial('getCementeryList', array('asCementery' => $asCementery,'snCementeryId' => $snCementeryId)); 
							?>
						</td>
					</tr>
					<?php endif;?>														
					<tr class="even">
						<td valign="middle" align="right" >
							<?php echo __('Select Area')?>
						</td>

						<td valign="middle" >
							<?php 
								if($sf_user->hasFlash('ssErrorArea') && $sf_user->getFlash('ssErrorArea') != ''):
									echo '<ul class="error_list"><li>'.$sf_user->getFlash('ssErrorArea').'</li></ul>';
									$sf_user->setFlash('ssErrorArea','');
								endif;
								include_partial('getAreaList', array('asAreaList' => $asAreaList,'snAreaId' => $snAreaId)); 
							?>
						</td>
						<td valign="middle" align="right" >
							<?php echo __('Select Section')?>
						</td>

						<td valign="middle" >
							<?php 
								if($sf_user->hasFlash('ssErrorSection') && $sf_user->getFlash('ssErrorSection') != ''):
									echo '<ul class="error_list"><li>'.$sf_user->getFlash('ssErrorSection').'</li></ul>';
									$sf_user->setFlash('ssErrorSection','');
								endif;
								include_partial('getSectionList', array('asSectionList' => $asSectionList,'snSectionId' => $snSectionId)); 
							?>
						</td>                                
					</tr>	
					<tr class="odd">
						<td valign="middle" align="right" >
							<?php echo __('Select Row')?>
						</td>

						<td valign="middle" >
							<?php 
								if($sf_user->hasFlash('ssErrorRow') && $sf_user->getFlash('ssErrorRow') != ''):
									echo '<ul class="error_list"><li>'.$sf_user->getFlash('ssErrorRow').'</li></ul>';
									$sf_user->setFlash('ssErrorRow','');
								endif;
								include_partial('getRowList', array('asRowList' => $asRowList,'snRowId' => $snRowId)); 
							?>
						</td>
						<td valign="middle" align="right" >
							<?php echo __('Select Plot')?>
						</td>

						<td valign="middle" >
							<?php 
								if($sf_user->hasFlash('ssErrorPlot') && $sf_user->getFlash('ssErrorPlot') != ''):
									echo '<ul class="error_list"><li>'.$sf_user->getFlash('ssErrorPlot').'</li></ul>';
									$sf_user->setFlash('ssErrorPlot','');
								endif;
								include_partial('getPlotList', array('asPlotList' => $asPlotList,'snPlotId' => $snPlotId)); 
							?>
						</td>                                
					</tr>
					<tr class="even">
						<td valign="middle" align="right" >
							<?php echo __('Select Grave'); ?>
						</td>

						<td valign="middle" colspan="3">
							<?php 
								if($sf_user->hasFlash('ssErrorGrave') && $sf_user->getFlash('ssErrorGrave') != ''):
									echo '<ul class="error_list"><li>'.$sf_user->getFlash('ssErrorGrave').'</li></ul>';
									$sf_user->setFlash('ssErrorGrave','');
								endif;
								include_partial('getGraveList', array('asGraveList' => $asGraveList,'snGraveId' => $snGraveId)); 
							?>
						</td>                                
					</tr>
					<tr class="odd">
						<td valign="top" align="right" width="20%" style="padding-top:10px;">
							<?php echo __('Grave/Plot');?>
						</td>
						<td colspan="3" align="left">
							<div id="service_grave_size_info">
								<?php include_partial('fillGraveSizeDetails', array('amGraveUnitType' 	=> $amGraveUnitType,
																					'amGraveDetailsParams' 	=> $amGraveDetailsParams,																							
																					));
								?>
							</div>
						</td>				
					</tr>	
					
					<tr class="even">
						<td colspan="4" align="left">
							<b><?php echo __('Grantee details');?></b>
						</td>
					</tr>
					<tr class="odd">
						<td colspan="4" align="left">									
								<div id="service_grantee_list">
								<?php include_partial('fillGranteeDetails', array('amGranteeDetails' => $amGranteeDetails,
																				  'snGranteeId' => $snGranteeId, 
																				  'ssGranteeRelationShip' => $ssGranteeRelationShip,
																				  'ssGranteeRemarks1'	=> $ssGranteeRemarks1,
																				  'ssGranteeRemarks2'	=> $ssGranteeRemarks2
																				  )); ?>
								</div>
								<div class="clearb"></div>
								<div id="service_grantee_remarks_list">
								<?php include_partial('fillGranteeRemarks', array('ssGranteeRemarks1'	=> $ssGranteeRemarks1,
																				  'ssGranteeRemarks2'	=> $ssGranteeRemarks2
																				  )); ?>
								</div>
						</td>
					</tr>
											
					<tr class="even">
						<td colspan="4" align="left">
							<b><?php echo __('Monument Details (openings/internals)');?></b>
						</td>
					</tr>
					<tr class="odd">
						<td valign="middle" align="right" >
							<?php echo $oAllocationDetailsForm['monuments_grave_position']->renderLabel($oAllocationDetailsForm['monuments_grave_position']->renderLabelName());?>
						</td>

						<td valign="middle"  colspan="3">
							<?php 
								if($oAllocationDetailsForm['monuments_grave_position']->hasError()):
									echo $oAllocationDetailsForm['monuments_grave_position']->renderError();
								endif;
								echo $oAllocationDetailsForm['monuments_grave_position']->render(array('class'=>'inputBoxWidth')); 
							?>
						</td>
					</tr>							
					<tr class="even">
						<td valign="middle" align="right" >
							<?php echo $oAllocationDetailsForm['monument']->renderLabel($oAllocationDetailsForm['monument']->renderLabelName());?>
						</td>	
						<td valign="middle" >
							<?php 
								if($oAllocationDetailsForm['monument']->hasError()):
									echo $oAllocationDetailsForm['monument']->renderError();
								endif;
								echo $oAllocationDetailsForm['monument']->render(array('class'=>'inputBoxWidth')); 
							?>
						</td>
						<td valign="middle" align="right" >
							<?php echo $oAllocationDetailsForm['cem_stonemason_id']->renderLabel($oAllocationDetailsForm['cem_stonemason_id']->renderLabelName());?>
						</td>	
						<td valign="middle" >
							<?php 
								if($oAllocationDetailsForm['cem_stonemason_id']->hasError()):
									echo $oAllocationDetailsForm['cem_stonemason_id']->renderError();
								endif;
								echo $oAllocationDetailsForm['cem_stonemason_id']->render(array('class'=>'inputBoxWidth')); 
							?>
						</td>
					</tr>
					<tr class="odd">
						<td valign="middle" align="right" >
							<?php echo $oAllocationDetailsForm['monuments_unit_type']->renderLabel($oAllocationDetailsForm['monuments_unit_type']->renderLabelName());?>
						</td>	
						<td valign="middle" >
							<?php 
								if($oAllocationDetailsForm['monuments_unit_type']->hasError()):
									echo $oAllocationDetailsForm['monuments_unit_type']->renderError();
								endif;
								echo $oAllocationDetailsForm['monuments_unit_type']->render(array('class'=>'inputBoxWidth')); 
							?>
						</td>
						<td valign="middle" align="right" >
							<?php echo $oAllocationDetailsForm['monuments_depth']->renderLabel($oAllocationDetailsForm['monuments_depth']->renderLabelName());?>
						</td>	
						<td valign="middle" >
							<?php 
								if($oAllocationDetailsForm['monuments_depth']->hasError()):
									echo $oAllocationDetailsForm['monuments_depth']->renderError();
								endif;
								echo $oAllocationDetailsForm['monuments_depth']->render(array('class'=>'inputBoxWidth')); 
							?>
						</td>
					</tr>
					<tr class="even">
						<td valign="middle" align="right" >
							<?php echo $oAllocationDetailsForm['monuments_length']->renderLabel($oAllocationDetailsForm['monuments_length']->renderLabelName());?>
						</td>	
						<td valign="middle" >
							<?php 
								if($oAllocationDetailsForm['monuments_length']->hasError()):
									echo $oAllocationDetailsForm['monuments_length']->renderError();
								endif;
								echo $oAllocationDetailsForm['monuments_length']->render(array('class'=>'inputBoxWidth')); 
							?>
						</td>
						<td valign="middle" align="right" >
							<?php echo $oAllocationDetailsForm['monuments_width']->renderLabel($oAllocationDetailsForm['monuments_width']->renderLabelName());?>
						</td>	
						<td valign="middle" >
							<?php 
								if($oAllocationDetailsForm['monuments_width']->hasError()):
									echo $oAllocationDetailsForm['monuments_width']->renderError();
								endif;
								echo $oAllocationDetailsForm['monuments_width']->render(array('class'=>'inputBoxWidth')); 
							?>
						</td>
					</tr>
					<tr class="odd">
						<td colspan="4" align="left">
							<b><?php echo __('Interment Comments');?></b>
						</td>
					</tr>
					<tr class="even">
						<td valign="middle" align="right" >
							<?php echo $oAllocationDetailsForm['comment1']->renderLabel($oAllocationDetailsForm['comment1']->renderLabelName());?>
						</td>	
						<td valign="middle" >
							<?php 
								if($oAllocationDetailsForm['comment1']->hasError()):
									echo $oAllocationDetailsForm['comment1']->renderError();
								endif;
								echo $oAllocationDetailsForm['comment1']->render(array('class'=>'inputBoxWidth')); 
							?>
						</td>
						<td valign="middle" align="right" >
							<?php echo $oAllocationDetailsForm['comment2']->renderLabel($oAllocationDetailsForm['comment2']->renderLabelName());?>
						</td>	
						<td valign="middle" >
							<?php 
								if($oAllocationDetailsForm['comment2']->hasError()):
									echo $oAllocationDetailsForm['comment2']->renderError();
								endif;
								echo $oAllocationDetailsForm['comment2']->render(array('class'=>'inputBoxWidth')); 
							?>
						</td>
					</tr>							

					<tr class="odd">
						<td>&nbsp;</td>
						<td valign="middle" colspan="3">
							<div class="actions">
								<ul class="fleft">
									<li class="list1">
										<span>
											<?php 
												echo submit_tag(
													__('Save & Continue'), 
													array(
														'class'     => 'delete',
														'name'      => 'submit_button',
														'title'     => __('Save & Continue'), 
														'tabindex'  => 55,
														'onclick'   => "jQuery('#step2Save').val('1');"
													)
												);
											?>
										</span>
									</li>
									<li class="list1">
										<span>
											<?php echo button_to(__('Cancel'),$ssCancelUrl,array('class'=>'delete','title'=>__('Cancel'),'alt'=>__('Cancel'),'tabindex'=>56)); ?>
										</span>
									</li>
								</ul>
							</div>
						</td>
					</tr>
				</table>
				<?php
					echo input_hidden_tag('id', $sf_params->get('id'), array('readonly' => 'true'));
					echo input_hidden_tag('back', $sf_params->get('back'), array('readonly' => 'true'));
					echo input_hidden_tag('tab', ($sf_params->get('tab') ? $sf_params->get('tab') :'step1'), array('readonly' => 'true'));
					echo input_hidden_tag('step2Save', '', array('readonly' => true));
					echo $oAllocationDetailsForm->renderHiddenFields(); 
				?></form>
			</div>
			<div id="step3">
				<?php
					$snIndex = 0;
					echo $oIntermentBookingThreeForm->renderFormTag(
						url_for($sf_params->get('module').'/'.$sf_params->get('action').(!$oIntermentBookingForm->getObject()->isNew() ? '?id='.$oIntermentBookingForm->getObject()->getId().'&tab=step3&'.html_entity_decode($amExtraParameters['ssQuerystr']) : '?tab=step3')), 
						array("name" => $oIntermentBookingThreeForm->getName(), "method" => "post" ,'enctype'=>'multipart/form-data')
					);
				?>
				<table width="100%" border="0" cellspacing="0" cellpadding="0" class="sub_table">
					<tr class="odd">
						<td colspan="4" align="left">
							<b><?php echo __('Final Booking Checklist');?></b>
						</td>
					</tr>
					<tr class="even">
						<td valign="middle" align="left" width="50%" style="padding:0 0 0 12px;">
							<?php echo $oIntermentBookingThreeForm['file_location']->renderLabel($oIntermentBookingThreeForm['file_location']->renderLabelName(),array('style' => 'float:left;'));?>
						</td>

						<td valign="middle" width="50%">
							<?php 
								if($oIntermentBookingThreeForm['file_location']->hasError()):
									echo $oIntermentBookingThreeForm['file_location']->renderError();
								endif;
								echo $oIntermentBookingThreeForm['file_location']->render(array('style'=>'width:250px;')); 
							?>
						</td>
					</tr>
					<tr class="odd">
						<td valign="middle" align="left" width="50%">
							<span style="float:left; font-weight:bold;padding:0 0 0 12px;"><?php echo $snIndex+=1?> &nbsp;</span>
							<?php echo $oIntermentBookingThreeForm['cemetery_application']->renderLabel($oIntermentBookingThreeForm['cemetery_application']->renderLabelName(),array('style' => 'float:left;'));?>
						</td>

						<td valign="middle" width="50%"><?php 
								if($oIntermentBookingThreeForm['cemetery_application']->hasError()):
									echo $oIntermentBookingThreeForm['cemetery_application']->renderError();
								endif;
								echo $oIntermentBookingThreeForm['cemetery_application']->render(array('class'=>'RadioBox')); 
							?>
						</td>
					</tr>
					<tr class="even">
						<td valign="middle" align="left" width="50%">
							<span style="float:left; font-weight:bold;padding:0 0 0 12px;"><?php echo $snIndex+=1?> &nbsp;</span>
							<?php echo $oIntermentBookingThreeForm['burial_booking_form']->renderLabel($oIntermentBookingThreeForm['burial_booking_form']->renderLabelName(),array('style' => 'float:left;'));?>
						</td>

						<td valign="middle" width="50%">
							<?php 
								if($oIntermentBookingThreeForm['burial_booking_form']->hasError()):
									echo $oIntermentBookingThreeForm['burial_booking_form']->renderError();
								endif;
								echo $oIntermentBookingThreeForm['burial_booking_form']->render(array('class'=>'RadioBox')); 
							?>
						</td>
					</tr>
					<tr class="odd">
						<td valign="middle" align="left" width="50%">
							<span style="float:left; font-weight:bold;padding:0 0 0 12px;"><?php echo $snIndex+=1?> &nbsp;</span>
							<?php echo $oIntermentBookingThreeForm['ashes_booking_form']->renderLabel($oIntermentBookingThreeForm['ashes_booking_form']->renderLabelName(),array('style' => 'float:left;'));?>
						</td>

						<td valign="middle" width="50%">
							<?php 
								if($oIntermentBookingThreeForm['ashes_booking_form']->hasError()):
									echo $oIntermentBookingThreeForm['ashes_booking_form']->renderError();
								endif;
								echo $oIntermentBookingThreeForm['ashes_booking_form']->render(array('class'=>'RadioBox')); 
							?>
						</td>
					</tr>
					<tr class="even">
						<td valign="middle" align="left" width="50%">
							<span style="float:left; font-weight:bold;padding:0 0 0 12px;"><?php echo $snIndex+=1?> &nbsp;</span>
							<?php echo $oIntermentBookingThreeForm['exhumation_booking_from']->renderLabel($oIntermentBookingThreeForm['exhumation_booking_from']->renderLabelName(),array('style' => 'float:left;'));?>
						</td>

						<td valign="middle" width="50%">
							<?php 
								if($oIntermentBookingThreeForm['exhumation_booking_from']->hasError()):
									echo $oIntermentBookingThreeForm['exhumation_booking_from']->renderError();
								endif;
								echo $oIntermentBookingThreeForm['exhumation_booking_from']->render(array('class'=>'RadioBox')); 
							?>
						</td>
					</tr>
					<tr class="even">
						<td width="100%" colspan="2">
							<table width="100%" cellspacing="0" cellpadding="0">										
								<tr class="even">
									<td valign="middle" align="left" width="50%">
										<span style="float:left; font-weight:bold;padding:0 0 0 35px;"> &bull;&nbsp;</span>
										<?php echo $oIntermentBookingThreeForm['health_order']->renderLabel($oIntermentBookingThreeForm['health_order']->renderLabelName(),array('style' => 'float:left;'));?>
									</td>
									<td valign="middle" width="50%">
										<?php 
											if($oIntermentBookingThreeForm['health_order']->hasError()):
												echo $oIntermentBookingThreeForm['health_order']->renderError();
											endif;
											echo $oIntermentBookingThreeForm['health_order']->render(array('class'=>'RadioBox')); 
										?>
									</td>
								</tr>
								<tr class="even">
									<td valign="middle" align="left" width="50%">
										<span style="float:left; font-weight:bold;padding:0 0 0 35px;"> &bull;&nbsp;</span>
										<?php echo $oIntermentBookingThreeForm['court_order']->renderLabel($oIntermentBookingThreeForm['court_order']->renderLabelName(),array('style' => 'float:left;'));?>
									</td>
									<td valign="middle" width="50%">
										<?php 
											if($oIntermentBookingThreeForm['court_order']->hasError()):
												echo $oIntermentBookingThreeForm['court_order']->renderError();
											endif;
											echo $oIntermentBookingThreeForm['court_order']->render(array('class'=>'RadioBox')); 
										?>
									</td>
								</tr>										
							</table>
						</td>
					</tr>
					<tr class="odd">
						<td valign="middle" align="left" width="50%">
							<span style="float:left; font-weight:bold;padding:0 0 0 12px;"><?php echo $snIndex+=1?> &nbsp;</span>
							<?php echo $oIntermentBookingThreeForm['remains_booking_from']->renderLabel($oIntermentBookingThreeForm['remains_booking_from']->renderLabelName(),array('style' => 'float:left;'));?>
						</td>

						<td valign="middle" width="50%">
							<?php 
								if($oIntermentBookingThreeForm['remains_booking_from']->hasError()):
									echo $oIntermentBookingThreeForm['remains_booking_from']->renderError();
								endif;
								echo $oIntermentBookingThreeForm['remains_booking_from']->render(array('class'=>'RadioBox')); 
							?>
						</td>
					</tr>							
					<tr class="even">
						<td valign="middle" align="left" width="50%">
							<span style="float:left; font-weight:bold;padding:0 0 0 12px;"><?php echo $snIndex+=1?> &nbsp;</span>
							<?php echo $oIntermentBookingThreeForm['checked_fnd_details']->renderLabel($oIntermentBookingThreeForm['checked_fnd_details']->renderLabelName(),array('style' => 'float:left;'));?>
						</td>

						<td valign="middle" width="50%">
							<?php 
								if($oIntermentBookingThreeForm['checked_fnd_details']->hasError()):
									echo $oIntermentBookingThreeForm['checked_fnd_details']->renderError();
								endif;
								echo $oIntermentBookingThreeForm['checked_fnd_details']->render(array('class'=>'RadioBox')); 
							?>
						</td>
					</tr>
					<tr class="odd">
						<td valign="middle" align="left" width="50%">
							<span style="float:left; font-weight:bold;padding:0 0 0 12px;"><?php echo $snIndex+=1?> &nbsp;</span>
							<?php echo $oIntermentBookingThreeForm['checked_owner_grave']->renderLabel($oIntermentBookingThreeForm['checked_owner_grave']->renderLabelName(),array('style' => 'float:left;'));?>
						</td>

						<td valign="middle" width="50%">
							<?php 
								if($oIntermentBookingThreeForm['checked_owner_grave']->hasError()):
									echo $oIntermentBookingThreeForm['checked_owner_grave']->renderError();
								endif;
								echo $oIntermentBookingThreeForm['checked_owner_grave']->render(array('class'=>'RadioBox')); 
							?>
						</td>
					</tr>
					<tr class="odd">
						<td width="100%" colspan="2">
							<table width="100%" cellspacing="0" cellpadding="0">
								<tr class="odd">
									<td width="100%" colspan="2" style="padding:0 0 0 35px;">
									
										<?php echo __('Has all the necessary documenttion and permission been recieved from either:');?>
									</td>
								</tr>
								<tr class="odd">
									<td valign="middle" align="left" width="50%">
										<span style="float:left; font-weight:bold;padding:0 0 0 35px;"> &bull;&nbsp;</span>
										<?php echo $oIntermentBookingThreeForm['living_grave_owner']->renderLabel($oIntermentBookingThreeForm['living_grave_owner']->renderLabelName(),array('style' => 'float:left;'));?>
									</td>
									<td valign="middle" width="50%">
										<?php 
											if($oIntermentBookingThreeForm['living_grave_owner']->hasError()):
												echo $oIntermentBookingThreeForm['living_grave_owner']->renderError();
											endif;
											echo $oIntermentBookingThreeForm['living_grave_owner']->render(array('class'=>'RadioBox')); 
										?>
									</td>
								</tr>
								<tr class="odd">
									<td valign="middle" align="left" width="50%">
										<span style="float:left; font-weight:bold;padding:0 0 0 35px;"> &bull;&nbsp;</span>
										<?php echo $oIntermentBookingThreeForm['deceased_grave_owner']->renderLabel($oIntermentBookingThreeForm['deceased_grave_owner']->renderLabelName(),array('style' => 'float:left;'));?>
									</td>
									<td valign="middle" width="50%">
										<?php 
											if($oIntermentBookingThreeForm['deceased_grave_owner']->hasError()):
												echo $oIntermentBookingThreeForm['deceased_grave_owner']->renderError();
											endif;
											echo $oIntermentBookingThreeForm['deceased_grave_owner']->render(array('class'=>'RadioBox')); 
										?>
									</td>
								</tr>
							</table>
						</td>
					</tr>
					<tr class="even">
						<td valign="middle" align="left" width="50%">
							<span style="float:left; font-weight:bold;padding:0 0 0 12px;"><?php echo $snIndex+=1?> &nbsp;</span>
							<?php echo $oIntermentBookingThreeForm['cecked_chapel_booking']->renderLabel($oIntermentBookingThreeForm['cecked_chapel_booking']->renderLabelName(),array('style' => 'float:left;'));?>
						</td>

						<td valign="middle" width="50%">
							<?php 
								if($oIntermentBookingThreeForm['cecked_chapel_booking']->hasError()):
									echo $oIntermentBookingThreeForm['cecked_chapel_booking']->renderError();
								endif;
								echo $oIntermentBookingThreeForm['cecked_chapel_booking']->render(array('class'=>'RadioBox')); 
							?>
						</td>
					</tr>
					<tr class="even">
						<td width="100%" colspan="2">
							<table width="100%" cellspacing="0" cellpadding="0">										
								<tr class="even">
									<td valign="middle" align="left" width="50%">
										<span style="float:left; font-weight:bold;padding:0 0 0 35px;"> &bull;&nbsp;</span>
										<?php echo $oIntermentBookingThreeForm['advised_fd_to_check']->renderLabel($oIntermentBookingThreeForm['advised_fd_to_check']->renderLabelName(),array('style' => 'float:left;'));?>
									</td>
									<td valign="middle" width="50%">
										<?php 
											if($oIntermentBookingThreeForm['advised_fd_to_check']->hasError()):
												echo $oIntermentBookingThreeForm['advised_fd_to_check']->renderError();
											endif;
											echo $oIntermentBookingThreeForm['advised_fd_to_check']->render(array('class'=>'RadioBox')); 
										?>
									</td>
								</tr>										
							</table>
						</td>
					</tr>							
					<tr class="odd">
						<td valign="middle" align="left" width="50%">
							<span style="float:left; font-weight:bold;padding:0 0 0 12px;"><?php echo $snIndex+=1?> &nbsp;</span>
							<?php echo $oIntermentBookingThreeForm['advised_fd_recommended']->renderLabel($oIntermentBookingThreeForm['advised_fd_recommended']->renderLabelName(),array('style' => 'float:left;'));?>
						</td>

						<td valign="middle" width="50%">
							<?php 
								if($oIntermentBookingThreeForm['advised_fd_recommended']->hasError()):
									echo $oIntermentBookingThreeForm['advised_fd_recommended']->renderError();
								endif;
								echo $oIntermentBookingThreeForm['advised_fd_recommended']->render(array('class'=>'RadioBox')); 
							?>
						</td>
					</tr>
					<tr class="odd">
						<td width="100%" colspan="2">
							<table width="100%" cellspacing="0" cellpadding="0">										
								<tr class="odd">
									<td valign="middle" align="left" width="50%">
										<span style="float:left; font-weight:bold;padding:0 0 0 35px;"> &bull;&nbsp;</span>
										<?php echo $oIntermentBookingThreeForm['advised_fd_coffin_height']->renderLabel($oIntermentBookingThreeForm['advised_fd_coffin_height']->renderLabelName(),array('style' => 'float:left;'));?>
									</td>
									<td valign="middle" width="50%">
										<?php 
											if($oIntermentBookingThreeForm['advised_fd_coffin_height']->hasError()):
												echo $oIntermentBookingThreeForm['advised_fd_coffin_height']->renderError();
											endif;
											echo $oIntermentBookingThreeForm['advised_fd_coffin_height']->render(array('class'=>'RadioBox')); 
										?>
									</td>
								</tr>										
							</table>
						</td>
					</tr>							
					<tr class="even">
						<td valign="middle" align="left" width="50%" colspan="2">
							<span style="float:left; font-weight:bold;padding:0 0 0 12px;"><?php echo $snIndex+=1?> &nbsp;</span>
							<?php echo __('Medical Cause of Death Certificate');?>
						</td>
					</tr>
					<tr class="even">
						<td width="100%" colspan="2">
							<table width="100%" cellspacing="0" cellpadding="0">										
								<tr class="even">
									<td valign="middle" align="left" width="50%">
										<span style="float:left; font-weight:bold;padding:0 0 0 35px;"> &bull;&nbsp;</span>
										<?php echo $oIntermentBookingThreeForm['medical_death_certificate']->renderLabel($oIntermentBookingThreeForm['medical_death_certificate']->renderLabelName(),array('style' => 'float:left;'));?>
									</td>
									<td valign="middle" width="50%">
										<?php 
											if($oIntermentBookingThreeForm['medical_death_certificate']->hasError()):
												echo $oIntermentBookingThreeForm['medical_death_certificate']->renderError();
											endif;
											echo $oIntermentBookingThreeForm['medical_death_certificate']->render(array('class'=>'RadioBox')); 
										?>
									</td>
								</tr>
								<tr class="even">
									<td valign="middle" align="left" width="50%">
										<span style="float:left; font-weight:bold;padding:0 0 0 35px;"> &bull;&nbsp;</span>
										<?php echo $oIntermentBookingThreeForm['medical_certificate_spelling']->renderLabel($oIntermentBookingThreeForm['medical_certificate_spelling']->renderLabelName(),array('style' => 'float:left;'));?>
									</td>
									<td valign="middle" width="50%">
										<?php 
											if($oIntermentBookingThreeForm['medical_certificate_spelling']->hasError()):
												echo $oIntermentBookingThreeForm['medical_certificate_spelling']->renderError();
											endif;
											echo $oIntermentBookingThreeForm['medical_certificate_spelling']->render(array('class'=>'RadioBox')); 
										?>
									</td>
								</tr>
								<tr class="even">
									<td valign="middle" align="left" width="50%">
										<span style="float:left; font-weight:bold;padding:0 0 0 35px;"> &bull;&nbsp;</span>
										<?php echo $oIntermentBookingThreeForm['medical_certificate_infectious']->renderLabel($oIntermentBookingThreeForm['medical_certificate_infectious']->renderLabelName(),array('style' => 'float:left;'));?>
									</td>
									<td valign="middle" width="50%">
										<?php 
											if($oIntermentBookingThreeForm['medical_certificate_infectious']->hasError()):
												echo $oIntermentBookingThreeForm['medical_certificate_infectious']->renderError();
											endif;
											echo $oIntermentBookingThreeForm['medical_certificate_infectious']->render(array('class'=>'RadioBox')); 
										?>
									</td>
								</tr>
							</table>
						</td>
					</tr>							
					<tr class="odd">
						<td valign="middle" align="left" width="50%">
							<span style="float:left; font-weight:bold;padding:0 0 0 12px;"><?php echo $snIndex+=1?> &nbsp;</span>
							<?php echo $oIntermentBookingThreeForm['request_probe_reopen']->renderLabel($oIntermentBookingThreeForm['request_probe_reopen']->renderLabelName(),array('style' => 'float:left;'));?>
						</td>

						<td valign="middle" width="50%">
							<?php 
								if($oIntermentBookingThreeForm['request_probe_reopen']->hasError()):
									echo $oIntermentBookingThreeForm['request_probe_reopen']->renderError();
								endif;
								echo $oIntermentBookingThreeForm['request_probe_reopen']->render(array('class'=>'RadioBox')); 
							?>
						</td>
					</tr>
					<tr class="even">
						<td valign="middle" align="left" width="50%">
							<span style="float:left; font-weight:bold;padding:0 0 0 12px;"><?php echo $snIndex+=1?> &nbsp;</span>
							<?php echo $oIntermentBookingThreeForm['request_triple_depth_reopen']->renderLabel($oIntermentBookingThreeForm['request_triple_depth_reopen']->renderLabelName(),array('style' => 'float:left;'));?>
						</td>

						<td valign="middle" width="50%">
							<?php 
								if($oIntermentBookingThreeForm['request_triple_depth_reopen']->hasError()):
									echo $oIntermentBookingThreeForm['request_triple_depth_reopen']->renderError();
								endif;
								echo $oIntermentBookingThreeForm['request_triple_depth_reopen']->render(array('class'=>'RadioBox')); 
							?>
						</td>
					</tr>
					<tr class="odd">
						<td valign="middle" align="left" width="50%">
							<span style="float:left; font-weight:bold;padding:0 0 0 12px;"><?php echo $snIndex+=1?> &nbsp;</span>
							<?php echo $oIntermentBookingThreeForm['checked_monumental']->renderLabel($oIntermentBookingThreeForm['checked_monumental']->renderLabelName(),array('style' => 'float:left;'));?>
						</td>

						<td valign="middle" width="50%">
							<?php 
								if($oIntermentBookingThreeForm['checked_monumental']->hasError()):
									echo $oIntermentBookingThreeForm['checked_monumental']->renderError();
								endif;
								echo $oIntermentBookingThreeForm['checked_monumental']->render(array('class'=>'RadioBox')); 
							?>
						</td>
					</tr>
					<tr class="odd">
						<td width="100%" colspan="2">
							<table width="100%" cellspacing="0" cellpadding="0">										
								<tr class="odd">
									<td valign="middle" align="left" width="50%">
										<span style="float:left; font-weight:bold;padding:0 0 0 35px;"> &bull;&nbsp;</span>
										<?php echo $oIntermentBookingThreeForm['contacted_stonemason']->renderLabel($oIntermentBookingThreeForm['contacted_stonemason']->renderLabelName(),array('style' => 'float:left;'));?>
									</td>
									<td valign="middle" width="50%">
										<?php 
											if($oIntermentBookingThreeForm['contacted_stonemason']->hasError()):
												echo $oIntermentBookingThreeForm['contacted_stonemason']->renderError();
											endif;
											echo $oIntermentBookingThreeForm['contacted_stonemason']->render(array('class'=>'RadioBox')); 
										?>
									</td>
								</tr>										
							</table>
						</td>
					</tr>
					<tr class="even">
						<td valign="middle" align="left" width="50%">
							<span style="float:left; font-weight:bold;padding:0 0 0 12px;"><?php echo $snIndex+=1?> &nbsp;</span>
							<?php echo $oIntermentBookingThreeForm['checked_accessories']->renderLabel($oIntermentBookingThreeForm['checked_accessories']->renderLabelName(),array('style' => 'float:left;'));?>
						</td>

						<td valign="middle" width="50%">
							<?php 
								if($oIntermentBookingThreeForm['checked_accessories']->hasError()):
									echo $oIntermentBookingThreeForm['checked_accessories']->renderError();
								endif;
								echo $oIntermentBookingThreeForm['checked_accessories']->render(array('class'=>'RadioBox')); 
							?>
						</td>
					</tr>
					<tr class="even">
						<td width="100%" colspan="2">
							<table width="100%" cellspacing="0" cellpadding="0">										
								<tr class="even">
									<td valign="middle" align="left" width="50%">
										<span style="float:left; font-weight:bold;padding:0 0 0 35px;"> &bull;&nbsp;</span>
										<?php echo $oIntermentBookingThreeForm['balloons_na']->renderLabel($oIntermentBookingThreeForm['balloons_na']->renderLabelName(),array('style' => 'float:left;'));?>
									</td>
									<td valign="middle" width="50%">
										<?php 
											if($oIntermentBookingThreeForm['balloons_na']->hasError()):
												echo $oIntermentBookingThreeForm['balloons_na']->renderError();
											endif;
											echo $oIntermentBookingThreeForm['balloons_na']->render(array('class'=>'RadioBox')); 
										?>
									</td>
								</tr>
								<tr class="even">
									<td valign="middle" align="left" width="50%">
										<span style="float:left; font-weight:bold;padding:0 0 0 35px;"> &bull;&nbsp;</span>
										<?php echo $oIntermentBookingThreeForm['burning_drum']->renderLabel($oIntermentBookingThreeForm['burning_drum']->renderLabelName(),array('style' => 'float:left;'));?>
									</td>
									<td valign="middle" width="50%">
										<?php 
											if($oIntermentBookingThreeForm['burning_drum']->hasError()):
												echo $oIntermentBookingThreeForm['burning_drum']->renderError();
											endif;
											echo $oIntermentBookingThreeForm['burning_drum']->render(array('class'=>'RadioBox')); 
										?>
									</td>
								</tr>
								<tr class="even">
									<td valign="middle" align="left" width="50%">
										<span style="float:left; font-weight:bold;padding:0 0 0 35px;"> &bull;&nbsp;</span>
										<?php echo $oIntermentBookingThreeForm['canopy']->renderLabel($oIntermentBookingThreeForm['canopy']->renderLabelName(),array('style' => 'float:left;'));?>
									</td>
									<td valign="middle" width="50%">
										<?php 
											if($oIntermentBookingThreeForm['canopy']->hasError()):
												echo $oIntermentBookingThreeForm['canopy']->renderError();
											endif;
											echo $oIntermentBookingThreeForm['canopy']->render(array('class'=>'RadioBox')); 
										?>
									</td>
								</tr>
								<tr class="even">
									<td valign="middle" align="left" width="50%">
										<span style="float:left; font-weight:bold;padding:0 0 0 35px;"> &bull;&nbsp;</span>
										<?php echo $oIntermentBookingThreeForm['ceremonial_sand_bucket']->renderLabel($oIntermentBookingThreeForm['ceremonial_sand_bucket']->renderLabelName(),array('style' => 'float:left;'));?>
									</td>
									<td valign="middle" width="50%">
										<?php 
											if($oIntermentBookingThreeForm['ceremonial_sand_bucket']->hasError()):
												echo $oIntermentBookingThreeForm['ceremonial_sand_bucket']->renderError();
											endif;
											echo $oIntermentBookingThreeForm['ceremonial_sand_bucket']->render(array('class'=>'RadioBox')); 
										?>
									</td>
								</tr>
								<tr class="even">
									<td valign="middle" align="left" width="50%">
										<span style="float:left; font-weight:bold;padding:0 0 0 35px;"> &bull;&nbsp;</span>
										<?php echo $oIntermentBookingThreeForm['fireworks']->renderLabel($oIntermentBookingThreeForm['fireworks']->renderLabelName(),array('style' => 'float:left;'));?>
									</td>
									<td valign="middle" width="50%">
										<?php 
											if($oIntermentBookingThreeForm['fireworks']->hasError()):
												echo $oIntermentBookingThreeForm['fireworks']->renderError();
											endif;
											echo $oIntermentBookingThreeForm['fireworks']->render(array('class'=>'RadioBox')); 
										?>
									</td>
								</tr>
								<tr class="even">
									<td valign="middle" align="left" width="50%">
										<span style="float:left; font-weight:bold;padding:0 0 0 35px;"> &bull;&nbsp;</span>
										<?php echo $oIntermentBookingThreeForm['lowering_device']->renderLabel($oIntermentBookingThreeForm['lowering_device']->renderLabelName(),array('style' => 'float:left;'));?>
									</td>
									<td valign="middle" width="50%">
										<?php 
											if($oIntermentBookingThreeForm['lowering_device']->hasError()):
												echo $oIntermentBookingThreeForm['lowering_device']->renderError();
											endif;
											echo $oIntermentBookingThreeForm['lowering_device']->render(array('class'=>'RadioBox')); 
										?>
									</td>
								</tr>
								<tr class="even">
									<td valign="middle" align="left" width="50%">
										<span style="float:left; font-weight:bold;padding:0 0 0 35px;"> &bull;&nbsp;</span>
										<?php echo $oIntermentBookingThreeForm['other']->renderLabel($oIntermentBookingThreeForm['other']->renderLabelName(),array('style' => 'float:left;'));?>
									</td>
									<td valign="middle" width="50%">
										<?php 
											if($oIntermentBookingThreeForm['other']->hasError()):
												echo $oIntermentBookingThreeForm['other']->renderError();
											endif;
											echo $oIntermentBookingThreeForm['other']->render(array('style'=>'1000px;'));
										?>
									</td>
								</tr>										
							</table>
						</td>
					</tr>														
					<tr class="odd">
						<td valign="middle" align="left" width="50%">
							<span style="float:left; font-weight:bold;padding:0 0 0 12px;"><?php echo $snIndex+=1?> &nbsp;</span>
							<?php echo $oIntermentBookingThreeForm['checked_returned_signed']->renderLabel($oIntermentBookingThreeForm['checked_returned_signed']->renderLabelName(),array('style' => 'float:left;'));?>
						</td>

						<td valign="middle" width="50%">
							<?php 
								if($oIntermentBookingThreeForm['checked_returned_signed']->hasError()):
									echo $oIntermentBookingThreeForm['checked_returned_signed']->renderError();
								endif;
								echo $oIntermentBookingThreeForm['checked_returned_signed']->render(array('class'=>'RadioBox')); 
							?>
						</td>
					</tr>
					<tr class="even">
						<td valign="middle" align="left" width="50%">
							<span style="float:left; font-weight:bold;padding:0 0 0 12px;"><?php echo $snIndex+=1?> &nbsp;</span>
							<?php echo $oIntermentBookingThreeForm['check_coffin_sizes_surcharge']->renderLabel($oIntermentBookingThreeForm['check_coffin_sizes_surcharge']->renderLabelName(),array('style' => 'float:left;'));?>
						</td>

						<td valign="middle" width="50%">
							<?php 
								if($oIntermentBookingThreeForm['check_coffin_sizes_surcharge']->hasError()):
									echo $oIntermentBookingThreeForm['check_coffin_sizes_surcharge']->renderError();
								endif;
								echo $oIntermentBookingThreeForm['check_coffin_sizes_surcharge']->render(array('class'=>'RadioBox')); 
							?>
						</td>
					</tr>
					<tr class="even">
						<td width="100%" colspan="2">
							<table width="100%" cellspacing="0" cellpadding="0">
								<tr class="even">
									<td valign="middle" align="left" width="50%">
										<span style="float:left; font-weight:bold;padding:0 0 0 35px;"> &bull;&nbsp;</span>
										<?php echo $oIntermentBookingThreeForm['surcharge_applied']->renderLabel($oIntermentBookingThreeForm['surcharge_applied']->renderLabelName(),array('style' => 'float:left;'));?>
									</td>
									<td valign="middle" width="50%">
										<?php 
											if($oIntermentBookingThreeForm['surcharge_applied']->hasError()):
												echo $oIntermentBookingThreeForm['surcharge_applied']->renderError();
											endif;
											echo $oIntermentBookingThreeForm['surcharge_applied']->render(array('class'=>'RadioBox')); 
										?>
									</td>
								</tr>
							</table>
						</td>
					</tr>
					<tr class="odd">
						<td valign="middle" align="left" width="50%">
							<span style="float:left; font-weight:bold;padding:0 0 0 12px;"><?php echo $snIndex+=1?> &nbsp;</span>
							<?php echo $oIntermentBookingThreeForm['compare_burial_booking']->renderLabel($oIntermentBookingThreeForm['compare_burial_booking']->renderLabelName(),array('style' => 'float:left;'));?>
						</td>

						<td valign="middle" width="50%">
							<?php 
								if($oIntermentBookingThreeForm['compare_burial_booking']->hasError()):
									echo $oIntermentBookingThreeForm['compare_burial_booking']->renderError();
								endif;
								echo $oIntermentBookingThreeForm['compare_burial_booking']->render(array('class'=>'RadioBox')); 
							?>
						</td>
					</tr>
					<tr class="even">
						<td valign="middle" align="left" width="50%">
							<span style="float:left; font-weight:bold;padding:0 0 0 12px;"><?php echo $snIndex+=1?> &nbsp;</span>
							<?php echo $oIntermentBookingThreeForm['for_between_burials']->renderLabel($oIntermentBookingThreeForm['for_between_burials']->renderLabelName(),array('style' => 'float:left;'));?>
						</td>

						<td valign="middle" width="50%">
							<?php 
								if($oIntermentBookingThreeForm['for_between_burials']->hasError()):
									echo $oIntermentBookingThreeForm['for_between_burials']->renderError();
								endif;
								echo $oIntermentBookingThreeForm['for_between_burials']->render(array('class'=>'RadioBox')); 
							?>
						</td>
					</tr>
					<tr class="odd">
						<td valign="middle" align="left" width="50%">
							<span style="float:left; font-weight:bold;padding:0 0 0 12px;"><?php echo $snIndex+=1?> &nbsp;</span>
							<?php echo $oIntermentBookingThreeForm['double_check_yellow_date']->renderLabel($oIntermentBookingThreeForm['double_check_yellow_date']->renderLabelName(),array('style' => 'float:left;'));?>
						</td>

						<td valign="middle" width="50%">
							<?php 
								if($oIntermentBookingThreeForm['double_check_yellow_date']->hasError()):
									echo $oIntermentBookingThreeForm['double_check_yellow_date']->renderError();
								endif;
								echo $oIntermentBookingThreeForm['double_check_yellow_date']->render(array('class'=>'RadioBox')); 
							?>
						</td>
					</tr>
					
					<tr class="even">                            	
						<td valign="middle">
							<div class="actions">
								<ul class="fleft">
									<li class="list1">
										<span>
											<?php 
												echo submit_tag(
													__('Save & Continue'), 
													array(
														'class'     => 'delete',
														'name'      => 'submit_button',
														'title'     => __('Save & Continue'), 
														'tabindex'  => 38,
														'onclick'   => "jQuery('#step3Save').val('1');"
													)
												);
											?>
										</span>
									</li>
									<li class="list1">
										<span>
											<?php echo button_to(__('Cancel'),$ssCancelUrl,array('class'=>'delete','title'=>__('Cancel'),'alt'=>__('Cancel'),'tabindex'=>39)); ?>
										</span>
									</li>
								</ul>
							</div>
						</td>
						<td>&nbsp;</td>
					</tr>
				</table>
				<?php
					echo input_hidden_tag('id', $sf_params->get('id'), array('readonly' => 'true'));
					echo input_hidden_tag('back', $sf_params->get('back'), array('readonly' => 'true'));
					echo input_hidden_tag('tab', ($sf_params->get('tab') ? $sf_params->get('tab') :'step1'), array('readonly' => 'true'));
					echo input_hidden_tag('step3Save', '', array('readonly' => true));
					echo $oIntermentBookingThreeForm->renderHiddenFields(); 
				?>
				</form>
			</div>
			<div id="step4">
				<?php 
					echo $oIntermentBookingForm->renderFormTag(
						url_for($sf_params->get('module').'/'.$sf_params->get('action').(!$oIntermentBookingForm->getObject()->isNew() ? '?id='.$oIntermentBookingForm->getObject()->getId().'&tab=step4&'.html_entity_decode($amExtraParameters['ssQuerystr']) : '?tab=step4')), 
						array("name" => $oIntermentBookingFourForm->getName(), "method" => "post" ,'enctype'=>'multipart/form-data')
					);
				?>
				<table width="100%" border="0" cellspacing="0" cellpadding="0" class="sub_table">
					<tr class="odd">
						<td colspan="4" align="left">
							<b><?php echo __('Deceased Details');?></b>
						</td>
					</tr>
					<tr class="even">
						<td valign="middle" align="right" >
							<?php echo $oIntermentBookingFourForm['control_number']->renderLabel($oIntermentBookingFourForm['control_number']->renderLabelName());?>
						</td>	
						<td valign="middle" >
							<?php 
								if($oIntermentBookingFourForm['control_number']->hasError()):
									echo $oIntermentBookingFourForm['control_number']->renderError();
								endif;
								echo $oIntermentBookingFourForm['control_number']->render(array('class'=>'inputBoxWidth')); 
							?>
						</td>
						<td valign="middle" align="right" >
							<?php echo $oIntermentBookingFourForm['interment_date']->renderLabel($oIntermentBookingFourForm['interment_date']->renderLabelName());?>
						</td>	
						<td valign="right" >
							<?php 
								if($oIntermentBookingFourForm['interment_date']->hasError()):
									echo $oIntermentBookingFourForm['interment_date']->renderError();
								endif;
								echo $oIntermentBookingFourForm['interment_date']->render();
							?>
						</td>
					</tr>								
					<tr class="odd">
						<td valign="middle" align="right" >
							<?php echo $oIntermentBookingFourForm['deceased_date_of_death']->renderLabel($oIntermentBookingFourForm['deceased_date_of_death']->renderLabelName());?>
						</td>	
						<td valign="right"  style="padding:5px 0 1px 0;">
							<?php 
								if($oIntermentBookingFourForm['deceased_date_of_death']->hasError()):
									echo $oIntermentBookingFourForm['deceased_date_of_death']->renderError();
								endif;
								echo $oIntermentBookingFourForm['deceased_date_of_death']->render(array('class'=>'inputBoxWidth')); 
							?>
						</td>
						<td valign="middle" align="right" >
							<?php echo $oIntermentBookingFourForm['deceased_date_of_birth']->renderLabel($oIntermentBookingFourForm['deceased_date_of_birth']->renderLabelName());?>
						</td>	
						<td valign="middle" >
							<?php 
								if($oIntermentBookingFourForm['deceased_date_of_birth']->hasError()):
									echo $oIntermentBookingFourForm['deceased_date_of_birth']->renderError();
								endif;
								echo $oIntermentBookingFourForm['deceased_date_of_birth']->render(array('class'=>'inputBoxWidth')); 
							?>
						</td>
					</tr>
					<tr class="even">
						<td valign="middle" align="right" >
							<?php echo $oIntermentBookingFourForm['deceased_place_of_death']->renderLabel($oIntermentBookingFourForm['deceased_place_of_death']->renderLabelName());?>
						</td>	
						<td valign="middle" >
							<?php 
								if($oIntermentBookingFourForm['deceased_place_of_death']->hasError()):
									echo $oIntermentBookingFourForm['deceased_place_of_death']->renderError();
								endif;
								echo $oIntermentBookingFourForm['deceased_place_of_death']->render(array('class'=>'inputBoxWidth')); 
							?>
						</td>
						<td valign="middle" align="right" >
							<?php echo $oIntermentBookingFourForm['deceased_place_of_birth']->renderLabel($oIntermentBookingFourForm['deceased_place_of_birth']->renderLabelName());?>
						</td>	
						<td valign="right" >
							<?php 
								if($oIntermentBookingFourForm['deceased_place_of_birth']->hasError()):
									echo $oIntermentBookingFourForm['deceased_place_of_birth']->renderError();
								endif;
								echo $oIntermentBookingFourForm['deceased_place_of_birth']->render(array('class'=>'inputBoxWidth')); 
							?>
						</td>								
					</tr>
					<tr class="odd">
						<td valign="middle" align="right" >
							<?php echo $oIntermentBookingFourForm['deceased_country_id_of_death']->renderLabel($oIntermentBookingFourForm['deceased_country_id_of_death']->renderLabelName());?>
						</td>	
						<td valign="right" >
							<?php 
								if($oIntermentBookingFourForm['deceased_country_id_of_death']->hasError()):
									echo $oIntermentBookingFourForm['deceased_country_id_of_death']->renderError();
								endif;
								echo $oIntermentBookingFourForm['deceased_country_id_of_death']->render(array('class'=>'inputBoxWidth')); 
							?>
						</td>
						<td valign="middle" align="right" >
							<?php echo $oIntermentBookingFourForm['deceased_country_id_of_birth']->renderLabel($oIntermentBookingFourForm['deceased_country_id_of_birth']->renderLabelName());?>
						</td>	
						<td valign="middle" >
							<?php 
								if($oIntermentBookingFourForm['deceased_country_id_of_birth']->hasError()):
									echo $oIntermentBookingFourForm['deceased_country_id_of_birth']->renderError();
								endif;
								echo $oIntermentBookingFourForm['deceased_country_id_of_birth']->render(array('class'=>'inputBoxWidth')); 
							?>
						</td>
					</tr>							
					<tr class="even">
						<td valign="middle" align="right" >
							<?php echo $oIntermentBookingFourForm['deceased_age']->renderLabel($oIntermentBookingFourForm['deceased_age']->renderLabelName());?>
						</td>	
						<td valign="right" >
							<?php 
								if($oIntermentBookingFourForm['deceased_age']->hasError()):
									echo $oIntermentBookingFourForm['deceased_age']->renderError();
								endif;
								echo $oIntermentBookingFourForm['deceased_age']->render(array('class'=>'inputBoxWidth')); 
								echo $oIntermentBookingFourForm['finageuom']->render(array('style'=>'width:150px;'));
							?>
						</td>
						<td valign="middle" align="right" >
							<?php echo $oIntermentBookingFourForm['deceased_usual_address']->renderLabel($oIntermentBookingFourForm['deceased_usual_address']->renderLabelName());?>
						</td>	
						<td valign="middle" >
							<?php 
								if($oIntermentBookingFourForm['deceased_usual_address']->hasError()):
									echo $oIntermentBookingFourForm['deceased_usual_address']->renderError();
								endif;
								echo $oIntermentBookingFourForm['deceased_usual_address']->render(array('class'=>'inputBoxWidth')); 
							?>
						</td>
					</tr>							
					<tr class="odd">
						<td valign="middle" align="right" >
							<?php echo $oIntermentBookingFourForm['deceased_suburb_town']->renderLabel($oIntermentBookingFourForm['deceased_suburb_town']->renderLabelName());?>
						</td>	
						<td valign="right" >
							<?php 
								if($oIntermentBookingFourForm['deceased_suburb_town']->hasError()):
									echo $oIntermentBookingFourForm['deceased_suburb_town']->renderError();
								endif;
								echo $oIntermentBookingFourForm['deceased_suburb_town']->render(array('class'=>'inputBoxWidth')); 
							?>
						</td>
						<td valign="middle" align="right" >
							<?php echo $oIntermentBookingFourForm['deceased_state']->renderLabel($oIntermentBookingFourForm['deceased_state']->renderLabelName());?>
						</td>	
						<td valign="middle" >
							<?php 
								if($oIntermentBookingFourForm['deceased_state']->hasError()):
									echo $oIntermentBookingFourForm['deceased_state']->renderError();
								endif;
								echo $oIntermentBookingFourForm['deceased_state']->render(array('class'=>'inputBoxWidth')); 
							?>
						</td>
					</tr>
					<tr class="even">
						
						<td valign="middle" align="right" >
							<?php echo $oIntermentBookingFourForm['deceased_postal_code']->renderLabel($oIntermentBookingFourForm['deceased_postal_code']->renderLabelName());?>
						</td>	
						<td valign="middle" >
							<?php 
								if($oIntermentBookingFourForm['deceased_postal_code']->hasError()):
									echo $oIntermentBookingFourForm['deceased_postal_code']->renderError();
								endif;
								echo $oIntermentBookingFourForm['deceased_postal_code']->render(array('class'=>'inputBoxWidth')); 
							?>
						</td>								
						
						<td valign="middle" align="right" >
							<?php echo $oIntermentBookingFourForm['deceased_country_id']->renderLabel($oIntermentBookingFourForm['deceased_country_id']->renderLabelName());?>
						</td>	
						<td valign="right" >
							<?php 
								if($oIntermentBookingFourForm['deceased_country_id']->hasError()):
									echo $oIntermentBookingFourForm['deceased_country_id']->renderError();
								endif;
								echo $oIntermentBookingFourForm['deceased_country_id']->render(array('class'=>'inputBoxWidth')); 
							?>
						</td>

					</tr>
					<tr class="odd">
						<td valign="middle" align="right" >
							<?php echo $oIntermentBookingFourForm['deceased_marital_status']->renderLabel($oIntermentBookingFourForm['deceased_marital_status']->renderLabelName());?>
						</td>	
						<td valign="middle" colspan="3">
							<?php 
								if($oIntermentBookingFourForm['deceased_marital_status']->hasError()):
									echo $oIntermentBookingFourForm['deceased_marital_status']->renderError();
								endif;
								echo $oIntermentBookingFourForm['deceased_marital_status']->render(array('class'=>'inputBoxWidth')); 
							?>
						</td>															
					</tr>
					<tr class="even">
						<td valign="middle" align="right" >
							<?php echo $oIntermentBookingFourForm['deceased_partner_surname']->renderLabel($oIntermentBookingFourForm['deceased_partner_surname']->renderLabelName());?>
						</td>	
						<td valign="right" >
							<?php 
								if($oIntermentBookingFourForm['deceased_partner_surname']->hasError()):
									echo $oIntermentBookingFourForm['deceased_partner_surname']->renderError();
								endif;
								echo $oIntermentBookingFourForm['deceased_partner_surname']->render(array('class'=>'inputBoxWidth')); 
							?>
						</td>
						<td valign="middle" align="right" >
							<?php echo $oIntermentBookingFourForm['deceased_partner_name']->renderLabel($oIntermentBookingFourForm['deceased_partner_name']->renderLabelName());?>
						</td>	
						<td valign="middle" >
							<?php 
								if($oIntermentBookingFourForm['deceased_partner_name']->hasError()):
									echo $oIntermentBookingFourForm['deceased_partner_name']->renderError();
								endif;
								echo $oIntermentBookingFourForm['deceased_partner_name']->render(array('class'=>'inputBoxWidth')); 
							?>
						</td>
					</tr>
					<tr class="odd">
						<td valign="middle" align="right" >
							<?php echo $oIntermentBookingFourForm['deceased_father_surname']->renderLabel($oIntermentBookingFourForm['deceased_father_surname']->renderLabelName());?>
						</td>	
						<td valign="right" >
							<?php 
								if($oIntermentBookingFourForm['deceased_father_surname']->hasError()):
									echo $oIntermentBookingFourForm['deceased_father_surname']->renderError();
								endif;
								echo $oIntermentBookingFourForm['deceased_father_surname']->render(array('class'=>'inputBoxWidth')); 
							?>
						</td>
						<td valign="middle" align="right" >
							<?php echo $oIntermentBookingFourForm['deceased_father_name']->renderLabel($oIntermentBookingFourForm['deceased_father_name']->renderLabelName());?>
						</td>	
						<td valign="middle" >
							<?php 
								if($oIntermentBookingFourForm['deceased_father_name']->hasError()):
									echo $oIntermentBookingFourForm['deceased_father_name']->renderError();
								endif;
								echo $oIntermentBookingFourForm['deceased_father_name']->render(array('class'=>'inputBoxWidth')); 
							?>
						</td>
					</tr>
					<tr class="even">
						<td valign="middle" align="right" >
							<?php echo $oIntermentBookingFourForm['deceased_mother_maiden_surname']->renderLabel($oIntermentBookingFourForm['deceased_mother_maiden_surname']->renderLabelName());?>
						</td>	
						<td valign="right" >
							<?php 
								if($oIntermentBookingFourForm['deceased_mother_maiden_surname']->hasError()):
									echo $oIntermentBookingFourForm['deceased_mother_maiden_surname']->renderError();
								endif;
								echo $oIntermentBookingFourForm['deceased_mother_maiden_surname']->render(array('class'=>'inputBoxWidth')); 
							?>
						</td>
						<td valign="middle" align="right" >
							<?php echo $oIntermentBookingFourForm['deceased_mother_name']->renderLabel($oIntermentBookingFourForm['deceased_mother_name']->renderLabelName());?>
						</td>	
						<td valign="middle" >
							<?php 
								if($oIntermentBookingFourForm['deceased_mother_name']->hasError()):
									echo $oIntermentBookingFourForm['deceased_mother_name']->renderError();
								endif;
								echo $oIntermentBookingFourForm['deceased_mother_name']->render(array('class'=>'inputBoxWidth')); 
							?>
						</td>
					</tr>
					<tr class="odd">
						<td valign="middle" align="right" >
							<?php echo $oIntermentBookingFourForm['deceased_children1']->renderLabel($oIntermentBookingFourForm['deceased_children1']->renderLabelName());?>
						</td>
						<td valign="middle"  colspan="3">
							<div class="fleft">
							<?php 
								if($oIntermentBookingFourForm['deceased_children1']->hasError()):
									echo $oIntermentBookingFourForm['deceased_children1']->renderError();
								endif;
								echo $oIntermentBookingFourForm['deceased_children1']->render(array('class'=>'inputBoxWidth', 'title' => __('Deceased Children 1') )); 
							?>
							</div>
							<div class="fleft">
								<?php 
									if($oIntermentBookingFourForm['deceased_children2']->hasError()):
										echo $oIntermentBookingFourForm['deceased_children2']->renderError();
									endif;
									echo $oIntermentBookingFourForm['deceased_children2']->render(array('class'=>'inputBoxWidth', 'title' => __('Deceased Children 2') )); 
								?>
							</div>
							<div class="fleft">
								<?php 
									if($oIntermentBookingFourForm['deceased_children3']->hasError()):
										echo $oIntermentBookingFourForm['deceased_children3']->renderError();
									endif;
									echo $oIntermentBookingFourForm['deceased_children3']->render(array('class'=>'inputBoxWidth', 'title' => __('Deceased Children 3') )); 
								?>
							</div>
							<div class="clearb"></div>
							<div class="fleft">
								<?php 
									if($oIntermentBookingFourForm['deceased_children4']->hasError()):
										echo $oIntermentBookingFourForm['deceased_children4']->renderError();
									endif;
									echo $oIntermentBookingFourForm['deceased_children4']->render(array('class'=>'inputBoxWidth', 'title' => __('Deceased Children 4') )); 
								?>
							</div>
							<div class="fleft">
								<?php 
									if($oIntermentBookingFourForm['deceased_children5']->hasError()):
										echo $oIntermentBookingFourForm['deceased_children5']->renderError();
									endif;
									echo $oIntermentBookingFourForm['deceased_children5']->render(array('class'=>'inputBoxWidth', 'title' => __('Deceased Children 5') )); 
								?>
							</div>
							<div class="fleft">
								<?php 
									if($oIntermentBookingFourForm['deceased_children6']->hasError()):
										echo $oIntermentBookingFourForm['deceased_children6']->renderError();
									endif;
									echo $oIntermentBookingFourForm['deceased_children6']->render(array('class'=>'inputBoxWidth', 'title' => __('Deceased Children 6') )); 
								?>
							</div>
							<div class="clearb"></div>
							<div class="fleft">
								<?php 
									if($oIntermentBookingFourForm['deceased_children7']->hasError()):
										echo $oIntermentBookingFourForm['deceased_children7']->renderError();
									endif;
									echo $oIntermentBookingFourForm['deceased_children7']->render(array('class'=>'inputBoxWidth', 'title' => __('Deceased Children 7') )); 
								?>
							</div>
							<div class="fleft">
								<?php 
									if($oIntermentBookingFourForm['deceased_children8']->hasError()):
										echo $oIntermentBookingFourForm['deceased_children8']->renderError();
									endif;
									echo $oIntermentBookingFourForm['deceased_children8']->render(array('class'=>'inputBoxWidth', 'title' => __('Deceased Children 8') )); 
								?>
							</div>
							<div class="fleft">
								<?php 
									if($oIntermentBookingFourForm['deceased_children9']->hasError()):
										echo $oIntermentBookingFourForm['deceased_children9']->renderError();
									endif;
									echo $oIntermentBookingFourForm['deceased_children9']->render(array('class'=>'inputBoxWidth', 'title' => __('Deceased Children 9') )); 
								?>
							</div>
							<div class="clearb"></div>
							<div class="fleft">
								<?php 
									if($oIntermentBookingFourForm['deceased_children10']->hasError()):
										echo $oIntermentBookingFourForm['deceased_children10']->renderError();
									endif;
									echo $oIntermentBookingFourForm['deceased_children10']->render(array('class'=>'inputBoxWidth', 'title' => __('Children 10') ));
								?>
							</div>
							<div class="fleft">
								<?php 
									if($oIntermentBookingFourForm['deceased_children11']->hasError()):
										echo $oIntermentBookingFourForm['deceased_children11']->renderError();
									endif;
									echo $oIntermentBookingFourForm['deceased_children11']->render(array('class'=>'inputBoxWidth', 'title' => __('Children 11') )); 
								?>
							</div>
							<div class="fleft">
								<?php 
									if($oIntermentBookingFourForm['deceased_children12']->hasError()):
										echo $oIntermentBookingFourForm['deceased_children12']->renderError();
									endif;
									echo $oIntermentBookingFourForm['deceased_children12']->render(array('class'=>'inputBoxWidth', 'title' => __('Children 12') )); 
								?>
							</div>
						</td>
					</tr>

					<tr class="even">
						<td colspan="4" align="left">
							<b><?php echo __('Cultural/Religious Details');?></b>
						</td>
					</tr>
					<tr class="odd">
						<td valign="middle" align="right" >
							<?php echo $oIntermentBookingFourForm['cul_calender_type']->renderLabel($oIntermentBookingFourForm['cul_calender_type']->renderLabelName());?>
						</td>	
						<td valign="right">
							<?php 
								if($oIntermentBookingFourForm['cul_calender_type']->hasError()):
									echo $oIntermentBookingFourForm['cul_calender_type']->renderError();
								endif;
								echo $oIntermentBookingFourForm['cul_calender_type']->render(array('class'=>'inputBoxWidth')).'&nbsp;&nbsp;';
								echo '<strong>'.link_to_function(__('Link to calendar conversion'),"window.open('http://www.funaba.org/en/calendar-conversion.cgi','mywindow','width=800,height=600,scrollbars=yes,resizable=yes');", array('title'=>__('Link to calendar conversion') ) ).'</strong>';
							?>
						</td>		
						<td valign="middle" align="right" >
							<?php echo $oIntermentBookingFourForm['cul_time_of_death']->renderLabel($oIntermentBookingFourForm['cul_time_of_death']->renderLabelName());?>
						</td>	
						<td valign="middle" >
							<?php 
								if($oIntermentBookingFourForm['cul_time_of_death']->hasError()):
									echo $oIntermentBookingFourForm['cul_time_of_death']->renderError();
								endif;
								echo $oIntermentBookingFourForm['cul_time_of_death']->render(array('class'=>'inputBoxWidth')); 
							?>
						</td>                                		
												
														
					</tr>
					<tr class="even">
						<td valign="middle" align="right" >
							<?php echo $oIntermentBookingFourForm['cul_date_of_death']->renderLabel($oIntermentBookingFourForm['cul_date_of_death']->renderLabelName());?>
						</td>	
						<td valign="right" >
							<?php 
								if($oIntermentBookingFourForm['cul_date_of_death']->hasError()):
									echo $oIntermentBookingFourForm['cul_date_of_death']->renderError();
								endif;
								echo $oIntermentBookingFourForm['cul_date_of_death']->render(array('class'=>'inputBoxWidth')); 
							?>
						</td>
						<td valign="middle" align="right" >
							<?php echo $oIntermentBookingFourForm['cul_date_of_birth']->renderLabel($oIntermentBookingFourForm['cul_date_of_birth']->renderLabelName());?>
						</td>	
						<td valign="middle">
							<?php 
								if($oIntermentBookingFourForm['cul_date_of_birth']->hasError()):
									echo $oIntermentBookingFourForm['cul_date_of_birth']->renderError();
								endif;
								echo $oIntermentBookingFourForm['cul_date_of_birth']->render(array('class'=>'inputBoxWidth')); 
							?>
						</td>                                
					</tr>
					<tr class="odd">
						<td valign="middle" align="right" >
							<?php echo $oIntermentBookingFourForm['cul_date_of_interment']->renderLabel($oIntermentBookingFourForm['cul_date_of_interment']->renderLabelName());?>
						</td>	
						<td valign="right" >
							<?php 
								if($oIntermentBookingFourForm['cul_date_of_interment']->hasError()):
									echo $oIntermentBookingFourForm['cul_date_of_interment']->renderError();
								endif;
								echo $oIntermentBookingFourForm['cul_date_of_interment']->render(array('class'=>'inputBoxWidth')); 
							?>
						</td>
						<td valign="middle" align="right" >
							<?php echo $oIntermentBookingFourForm['cul_status']->renderLabel($oIntermentBookingFourForm['cul_status']->renderLabelName());?>
						</td>	
						<td valign="middle" >
							<?php 
								if($oIntermentBookingFourForm['cul_status']->hasError()):
									echo $oIntermentBookingFourForm['cul_status']->renderError();
								endif;
								echo $oIntermentBookingFourForm['cul_status']->render(array('class'=>'inputBoxWidth')); 
							?>
						</td>
					</tr>
					<tr class="even">
						<td valign="middle" align="right">
							<?php echo $oIntermentBookingFourForm['cul_died_after_dust']->renderLabel($oIntermentBookingFourForm['cul_died_after_dust']->renderLabelName());?>
						</td>	
						<td valign="right">
							
							<?php 
								if($oIntermentBookingFourForm['cul_died_after_dust']->hasError()):
									echo $oIntermentBookingFourForm['cul_died_after_dust']->renderError();
								endif;
								echo '<span class="fleft">'.$oIntermentBookingFourForm['cul_died_after_dust']->render(array('class'=>'inputBoxWidth')).'</span>'; 
							?>								
						</td>
						<td valign="middle" align="right" >
							<?php echo $oIntermentBookingFourForm['cul_remains_position']->renderLabel($oIntermentBookingFourForm['cul_remains_position']->renderLabelName());?>
						</td>	
						<td valign="middle" >
							<?php 
								if($oIntermentBookingFourForm['cul_remains_position']->hasError()):
									echo $oIntermentBookingFourForm['cul_remains_position']->renderError();
								endif;
								echo $oIntermentBookingFourForm['cul_remains_position']->render(array('class'=>'inputBoxWidth')); 
							?>
						</td>
					</tr>
					<tr class="odd">
						<td>&nbsp;</td>
						<td valign="middle" colspan="3">
							<div class="actions">
								<ul class="fleft">
									<li class="list1">
										<span>
											<?php 
												echo submit_tag(
													__('Save & Continue'), 
													array(
														'class'     => 'delete',
														'name'      => 'submit_button',
														'title'     => __('Save & Continue'), 
														'tabindex'  => 43,
														'onclick'   => "jQuery('#step4Save').val('1');"
													)
												);
											?>
										</span>
									</li>
									<li class="list1">
										<span>
											<?php echo button_to(__('Cancel'),$ssCancelUrl,array('class'=>'delete','title'=>__('Cancel'),'alt'=>__('Cancel'),'tabindex'=>44)); ?>
										</span>
									</li>
								</ul>
							</div>
						</td>
					</tr>						
				</table>
				<?php
					echo input_hidden_tag('id', $sf_params->get('id'), array('readonly' => 'true'));
					echo input_hidden_tag('back', $sf_params->get('back'), array('readonly' => 'true'));
					echo input_hidden_tag('tab', ($sf_params->get('tab') ? $sf_params->get('tab') :'step1'), array('readonly' => 'true'));
					echo input_hidden_tag('step4Save', '', array('readonly' => true));
					echo $oIntermentBookingFourForm->renderHiddenFields(); 
				?>
				</form>
			</div>				
			<div id="step5">
				<?php 
					echo $oApplicantDetailsForm->renderFormTag(
						url_for($sf_params->get('module').'/'.$sf_params->get('action').(!$oIntermentBookingForm->getObject()->isNew() ? '?id='.$oIntermentBookingForm->getObject()->getId().'&tab=step5&'.html_entity_decode($amExtraParameters['ssQuerystr']) : '?tab=step5')), 
						array("name" => $oApplicantDetailsForm->getName(), "method" => "post" ,'enctype'=>'multipart/form-data')
					);
				?>
				<table width="100%" border="0" cellspacing="0" cellpadding="0" class="sub_table">
					<tr class="odd">
						<td colspan="4" align="left">
							<b><?php echo __('Informant Details');?></b>
						</td>
					</tr>
					<tr class="even">
						<td valign="middle" align="right" >
							<?php echo $oApplicantDetailsForm['relationship_to_deceased']->renderLabel($oApplicantDetailsForm['relationship_to_deceased']->renderLabelName());?>
						</td>	
						<td valign="right">
							<?php 
								if($oApplicantDetailsForm['relationship_to_deceased']->hasError()):
									echo $oApplicantDetailsForm['relationship_to_deceased']->renderError();
								endif;
								echo $oApplicantDetailsForm['relationship_to_deceased']->render(array('class'=>'inputBoxWidth')); 
							?>
						</td>	
						<td valign="middle" align="right" >
							<?php echo $oApplicantDetailsForm['informant_state']->renderLabel($oApplicantDetailsForm['informant_state']->renderLabelName());?>
						</td>	
						<td valign="right" >
							<?php 
								if($oApplicantDetailsForm['informant_state']->hasError()):
									echo $oApplicantDetailsForm['informant_state']->renderError();
								endif;
								echo $oApplicantDetailsForm['informant_state']->render(array('class'=>'inputBoxWidth')); 
							?>
						</td>
					</tr>
                    <tr class="odd">
						<td valign="middle" align="right" >
							<?php echo $oApplicantDetailsForm['informant_title']->renderLabel($oApplicantDetailsForm['informant_title']->renderLabelName());?>
						</td>	
						<td valign="right" >
							<?php 
								if($oApplicantDetailsForm['informant_title']->hasError()):
									echo $oApplicantDetailsForm['informant_title']->renderError();
								endif;
								echo $oApplicantDetailsForm['informant_title']->render(array('class'=>'inputBoxWidth')); 
							?>
						</td>
						<td valign="middle" align="right" >
							<?php echo $oApplicantDetailsForm['informant_surname']->renderLabel($oApplicantDetailsForm['informant_surname']->renderLabelName());?>
						</td>	
						<td valign="right" >
							<?php 
								if($oApplicantDetailsForm['informant_surname']->hasError()):
									echo $oApplicantDetailsForm['informant_surname']->renderError();
								endif;
								echo $oApplicantDetailsForm['informant_surname']->render(array('class'=>'inputBoxWidth')); 
							?>
						</td>						
					</tr>
					<tr class="even">
                        <td valign="middle" align="right" >
							<?php echo $oApplicantDetailsForm['informant_first_name']->renderLabel($oApplicantDetailsForm['informant_first_name']->renderLabelName());?>
						</td>	
						<td valign="right" >
							<?php 
								if($oApplicantDetailsForm['informant_first_name']->hasError()):
									echo $oApplicantDetailsForm['informant_first_name']->renderError();
								endif;
								echo $oApplicantDetailsForm['informant_first_name']->render(array('class'=>'inputBoxWidth')); 
							?>
						</td>
                        <td valign="middle" align="right" >
							<?php echo $oApplicantDetailsForm['informant_middle_name']->renderLabel($oApplicantDetailsForm['informant_middle_name']->renderLabelName());?>
						</td>	
						<td valign="right" >
							<?php 
								if($oApplicantDetailsForm['informant_middle_name']->hasError()):
									echo $oApplicantDetailsForm['informant_middle_name']->renderError();
								endif;
								echo $oApplicantDetailsForm['informant_middle_name']->render(array('class'=>'inputBoxWidth')); 
							?>
						</td>						
											
					</tr>
					<tr class="odd">
						<td valign="middle" align="right" >
							<?php echo $oApplicantDetailsForm['informant_country_id']->renderLabel($oApplicantDetailsForm['informant_country_id']->renderLabelName());?>
						</td>	
						<td valign="middle" >
							<?php 
								if($oApplicantDetailsForm['informant_country_id']->hasError()):
									echo $oApplicantDetailsForm['informant_country_id']->renderError();
								endif;
								echo $oApplicantDetailsForm['informant_country_id']->render(array('class'=>'inputBoxWidth')); 
							?>
						</td>
						<td valign="middle" align="right" >
							<?php echo $oApplicantDetailsForm['informant_postal_code']->renderLabel($oApplicantDetailsForm['informant_postal_code']->renderLabelName());?>
						</td>	
						<td valign="right" >
							<?php 
								if($oApplicantDetailsForm['informant_postal_code']->hasError()):
									echo $oApplicantDetailsForm['informant_postal_code']->renderError();
								endif;
								echo $oApplicantDetailsForm['informant_postal_code']->render(array('class'=>'inputBoxWidth')); 
							?>
						</td>						
					</tr>
					<tr class="even">
						<td valign="middle" align="right" >
							<?php echo $oApplicantDetailsForm['informant_telephone_area_code']->renderLabel($oApplicantDetailsForm['informant_telephone_area_code']->renderLabelName());?>
						</td>	
						<td valign="middle" >
							<?php 
								if($oApplicantDetailsForm['informant_telephone_area_code']->hasError()):
									echo $oApplicantDetailsForm['informant_telephone_area_code']->renderError();
								endif;
								echo $oApplicantDetailsForm['informant_telephone_area_code']->render(array('class'=>'inputBoxWidth')); 
							?>
						</td>
						<td valign="middle" align="right" >
							<?php echo $oApplicantDetailsForm['informant_email']->renderLabel($oApplicantDetailsForm['informant_email']->renderLabelName());?>
						</td>	
						<td valign="middle" >
							<?php 
								if($oApplicantDetailsForm['informant_email']->hasError()):
									echo $oApplicantDetailsForm['informant_email']->renderError();
								endif;
								echo $oApplicantDetailsForm['informant_email']->render(array('class'=>'inputBoxWidth')); 
							?>
						</td>
					</tr>
					<tr class="odd">
						<td valign="middle" align="right" >
							<?php echo $oApplicantDetailsForm['informant_telephone']->renderLabel($oApplicantDetailsForm['informant_telephone']->renderLabelName());?>
						</td>	
						<td valign="middle" >
							<?php 
								if($oApplicantDetailsForm['informant_telephone']->hasError()):
									echo $oApplicantDetailsForm['informant_telephone']->renderError();
								endif;
								echo $oApplicantDetailsForm['informant_telephone']->render(array('class'=>'inputBoxWidth')); 
							?>
						</td>  
						<td valign="middle" align="right" >
							<?php echo $oApplicantDetailsForm['informant_address']->renderLabel($oApplicantDetailsForm['informant_address']->renderLabelName());?>
						</td>	
						<td valign="right" >
							<?php 
								if($oApplicantDetailsForm['informant_address']->hasError()):
									echo $oApplicantDetailsForm['informant_address']->renderError();
								endif;
								echo $oApplicantDetailsForm['informant_address']->render(array('class'=>'inputBoxWidth')); 
							?>
						</td>
					</tr>

					<tr class="even">
						<td valign="middle" align="right" >
							<?php echo $oApplicantDetailsForm['informant_mobile']->renderLabel($oApplicantDetailsForm['informant_mobile']->renderLabelName());?>
						</td>	
						<td valign="middle">
							<?php 
								if($oApplicantDetailsForm['informant_mobile']->hasError()):
									echo $oApplicantDetailsForm['informant_mobile']->renderError();
								endif;
								echo $oApplicantDetailsForm['informant_mobile']->render(array('class'=>'inputBoxWidth')); 
							?>
						</td>
						<td valign="middle" align="right" >
							<?php echo $oApplicantDetailsForm['informant_suburb_town']->renderLabel($oApplicantDetailsForm['informant_suburb_town']->renderLabelName());?>
						</td>	
						<td valign="middle" >
							<?php 
								if($oApplicantDetailsForm['informant_suburb_town']->hasError()):
									echo $oApplicantDetailsForm['informant_suburb_town']->renderError();
								endif;
								echo $oApplicantDetailsForm['informant_suburb_town']->render(array('class'=>'inputBoxWidth')); 
							?>
						</td>
					</tr>
					<tr class="odd">						
						<td valign="middle" align="right" >
							<?php echo $oApplicantDetailsForm['informant_fax_area_code']->renderLabel($oApplicantDetailsForm['informant_fax_area_code']->renderLabelName());?>
						</td>	
						<td valign="middle" >
							<?php 
								if($oApplicantDetailsForm['informant_fax_area_code']->hasError()):
									echo $oApplicantDetailsForm['informant_fax_area_code']->renderError();
								endif;
								echo $oApplicantDetailsForm['informant_fax_area_code']->render(array('class'=>'inputBoxWidth')); 
							?>
						</td>						
						<td valign="middle" align="right" >
							<?php echo $oApplicantDetailsForm['informant_fax']->renderLabel($oApplicantDetailsForm['informant_fax']->renderLabelName());?>
						</td>	
						<td valign="middle" >
							<?php 
								if($oApplicantDetailsForm['informant_fax']->hasError()):
									echo $oApplicantDetailsForm['informant_fax']->renderError();
								endif;
								echo $oApplicantDetailsForm['informant_fax']->render(array('class'=>'inputBoxWidth')); 
							?>
						</td>
					</tr>					
					<tr class="even">
						<td>&nbsp;</td>
						<td valign="middle" colspan="3">
							<div class="actions">
								<ul class="fleft">
									<li class="list1">
										<span>
											<?php 
												echo submit_tag(
													__('Save & Continue'), 
													array(
														'class'     => 'delete',
														'name'      => 'submit_button',
														'title'     => __('Save & Continue'), 
														'tabindex'  => 16,
														'onclick'   => "jQuery('#step5Save').val('1');"
													)
												);
											?>
										</span>
									</li>
									<li class="list1">
										<span>
											<?php echo button_to(__('Cancel'),$ssCancelUrl,array('class'=>'delete','title'=>__('Cancel'),'alt'=>__('Cancel'),'tabindex'=>17)); ?>
										</span>
									</li>
								</ul>
							</div>
						</td>
					</tr>						
				</table>
				<?php
					echo input_hidden_tag('id', $sf_params->get('id'), array('readonly' => 'true'));
					echo input_hidden_tag('back', $sf_params->get('back'), array('readonly' => 'true'));
					echo input_hidden_tag('tab', ($sf_params->get('tab') ? $sf_params->get('tab') :'step1'), array('readonly' => 'true'));
					echo input_hidden_tag('step5Save', '', array('readonly' => true));
					echo $oApplicantDetailsForm->renderHiddenFields(); 
				?>
				</form>
			</div>
			<div id="step6">
				<?php
					$snIndex = 0;
					echo $oLettersForm->renderFormTag(
						url_for($sf_params->get('module').'/'.$sf_params->get('action').(!$oIntermentBookingForm->getObject()->isNew() ? '?id='.$oIntermentBookingForm->getObject()->getId().'&tab=step6&'.html_entity_decode($amExtraParameters['ssQuerystr']) : '?tab=step6')), 
						array("name" => $oLettersForm->getName(), "method" => "post" ,'enctype'=>'multipart/form-data')
					);
				?>
				<table width="100%" border="0" cellspacing="0" cellpadding="0" class="sub_table">
					<tr class="odd">
						<td colspan="4" align="left">
							<b><?php echo __('Letters');?></b>
						</td>
					</tr>
                    
                    <?php 
                    if($oIntermentBookingForm->getObject()->isNew()):
                    if(count($asLetterDetail) > 0):
                        $snRow = 0;
                        foreach($asLetterDetail as $snKey=>$asValue):
                        $snRow = (($snRow%2 == 0)?"odd":"even");
                    ?>
                    <tr class="<?php echo $snRow;?>">
						<td valign="middle" align="left" width="50%">
							<span style="float:left; font-weight:bold;padding:0 0 0 12px;"><?php echo $snIndex+=1?> &nbsp;</span>
							<?php   echo $asValue['subject'];?>
                        </td>
						<td valign="middle" width="50%">							
						</td>
					</tr>
                    <?php
                    $snRow++;
                    endforeach;
                    endif;
                    else:?>
                    <?php 
                     if(count($asLetterDetail) > 0):
                        $snRow = 0;                       
                        foreach($asLetterDetail as $snKey=>$asValue):                        
                        $snRow = (($snRow%2 == 0)?"odd":"even");
                    ?>
                    <tr class="<?php echo $snRow;?>">
						<td valign="middle" align="left" width="50%">
							<span style="float:left; font-weight:bold;padding:0 0 0 12px;"><?php echo $snIndex+=1?> &nbsp;</span>
							<?php   echo $asValue['MailContent']['subject'];
                            //echo $oLettersForm['new_grave_inscription']->renderLabel($oLettersForm['new_grave_inscription']->renderLabelName(),array('style' => 'float:left;'));?>
						</td>

						<td valign="middle" width="50%">
							<?php 

								if(!$oIntermentBookingForm->getObject()->isNew() && !$sf_user->isSuperAdmin()):
									$snBookingId = $oIntermentBookingForm->getObject()->getId();
									echo button_to_function(__('Print'),"letterAction('".url_for('servicebooking/printLetters?id='.$asValue['interment_booking_id'].'&id_letter='.$asValue['id'])."','".$asValue['MailContent']['content_type']."');", 
												array('title' => __('Print'),'tabindex'=> 1,'id' => 'new_grave_inscription')
											);
									echo button_to_function(__('Email'),"letterAction('".url_for('servicebooking/sendLetters?id='.$asValue['interment_booking_id'].'&id_letter='.$asValue['id'])."','".$asValue['MailContent']['content_type']."');", 
												array('title' => __('Email'),'tabindex'=> 2 )
											);
									$ssSentStatus = ($asValue['status'] == 'Yes') ? __('Done') : __('Pending');
									echo '&nbsp;&nbsp;<strong>'.$ssSentStatus.'</strong>';
								endif;
							?>
						</td>
					</tr>
                    <?php
                    $snRow++;
                    endforeach;
                    endif;
                    
                    endif;
                    ?>
					<tr class="odd">                            	
						<td valign="middle">
							<div class="actions">
								<ul class="fleft">
									<li class="list1">
										<span>
											<?php echo button_to(__('Cancel'),$ssCancelUrl,array('class'=>'delete','title'=>__('Cancel'),'alt'=>__('Cancel'),'tabindex'=>41)); ?>
										</span>
									</li>
								</ul>
							</div>
						</td>
						<td>
							<?php if($finalize_button_check):?>
								<div class="actions">
									<ul class="fright">
										<li class="list1">
											<span>
												<?php
													$ssParamControlNumber = ($ssControlNumber != '') ? '&control_number='.$ssControlNumber : '';
													$ssParamIntermentDate = ($ssIntermentDate != '') ? '&interment_date='.$ssIntermentDate : '';
													echo link_to(__('Finalise'),url_for($sf_params->get('module').'/finalized'.(!$oIntermentBookingForm->getObject()->isNew() ? '?id='.$oIntermentBookingForm->getObject()->getId().'&tab=step4&'.html_entity_decode($amExtraParameters['ssQuerystr']).$ssParamControlNumber.$ssParamIntermentDate : '?tab=step4')),array('tabindex'=>42, 'title' => __('Finalise'),'class' => 'nyroModal'));
												?>
											</span>
										</li>
									</ul>
								</div>
							<?php endif;?>
						</td>
					</tr>
				</table>
				<?php
					echo input_hidden_tag('id', $sf_params->get('id'), array('readonly' => 'true'));
					echo input_hidden_tag('back', $sf_params->get('back'), array('readonly' => 'true'));
					echo input_hidden_tag('tab', ($sf_params->get('tab') ? $sf_params->get('tab') :'step1'), array('readonly' => 'true'));
					echo input_hidden_tag('step6Save', '', array('readonly' => true));
					echo $oLettersForm->renderHiddenFields(); 
				?>
				</form>
			</div>
			
		</div></div></div></div>
<div class="clearb">&nbsp;</div>
<div class="clearb">&nbsp;</div>
</div>
<?php 
if(!$sf_user->isSuperAdmin() && $oIntermentBookingForm->getObject()->isNew())
{
 echo javascript_tag("
	jQuery(document).ready(function() 
		{
			".
			// Ger area, section, row, plot, grave list as per cemetery.
			jq_remote_function(
			array('url'		=> url_for('servicebooking/getAreaListAsPerCemetery'),
				  'update'	=> 'service_area_list',
				  'with'	=> "'cemetery_id='+".$snCemeteryId."+'&country_id='+$('#service_country_id').val()",
				  'loading' => '$("#IdAjaxLocaderArea").show();',
				  'complete'=> '$("#IdAjaxLocaderArea").hide();'.jq_remote_function(
										array('url'		=> url_for('servicebooking/getSectionListAsPerArea'),
											  'update'	=> 'service_section_list',
											  'with'	=> "'country_id='+$('#service_country_id').val()+'&cemetery_id='+$('#service_cem_cemetery_id').val()",
											  'loading' => '$("#IdAjaxLocaderSection").show();',
											  'complete'=> '$("#IdAjaxLocaderSection").hide();'.jq_remote_function(
														array('url'		=> url_for('servicebooking/getRowListAsPerSection'),
															  'update'	=> 'service_row_list',
															  'with'	=> "'country_id='+$('#service_country_id').val()+'&cemetery_id='+$('#service_cem_cemetery_id').val()",
															  'loading' => '$("#IdAjaxLocaderRow").show();',
															  'complete'=> '$("#IdAjaxLocaderRow").hide();'.jq_remote_function(
																			array('url'		=> url_for('servicebooking/getPlotListAsPerRow'),
																				  'update'	=> 'service_plot_list',
																				  'with'	=> "'country_id='+$('#service_country_id').val()+'&cemetery_id='+$('#service_cem_cemetery_id').val()",
																				  'loading' => '$("#IdAjaxLocaderPlot").show();',
																				  'complete'=> '$("#IdAjaxLocaderPlot").hide();'.jq_remote_function(
																								array('url'		=> url_for('servicebooking/getGraveListAsPerPlot'),
																									  'update'	=> 'service_grave_list',
																									  'with'	=> "'country_id='+$('#service_country_id').val()+'&cemetery_id='+$('#service_cem_cemetery_id').val()",
																									  'loading' => '$("#IdAjaxLocaderGrave").show();',
																									  'complete'=> '$("#IdAjaxLocaderGrave").hide();'))
																			))
														))
										))
			))
			."
		});
	");
}

echo javascript_tag('
ssTags = document.getElementsByTagName("select");
document.getElementById(ssTags[1].id).focus();'

);
echo javascript_tag("

$('#service_service_date').change(function(){
	var splitDate = this.value.split('-');
	var d = new Date(splitDate[1]+'/'+splitDate[0]+'/'+splitDate[2]);
	var asDayName = ['Sunday','Monday','Tuesday','Wednesday', 'Thursday','Friday','Saturday'];
	$('#service_date1_day').val(asDayName[d.getDay()]);
});
$('#service_service_date2').change(function(){
	var splitDate = this.value.split('-');
	var d = new Date(splitDate[1]+'/'+splitDate[0]+'/'+splitDate[2]);
	var asDayName = ['Sunday','Monday','Tuesday','Wednesday', 'Thursday','Friday','Saturday'];
	$('#service_date2_day').val(asDayName[d.getDay()]);
});
$('#service_service_date3').change(function(){
	var splitDate = this.value.split('-');
	var d = new Date(splitDate[1]+'/'+splitDate[0]+'/'+splitDate[2]);
	var asDayName = ['Sunday','Monday','Tuesday','Wednesday', 'Thursday','Friday','Saturday'];
	$('#service_date3_day').val(asDayName[d.getDay()]);
});

jQuery(\"input[name='service[other_details][chapel]']\").click(function() {
	if(this.name == 'service[other_details][chapel]')
	{
		var ssChapelValue = jQuery(this).val();
		showHideDiv('chapel','chapeldiv',ssChapelValue);
	}
});

jQuery(\"input[name='service[other_details][room]']\").click(function() {
	if(this.name == 'service[other_details][room]')
	{
		var ssRoomValue = $(this).val();
		showHideDiv('room','roomydiv',ssRoomValue);
	}
});
if($('#service_grave_length').val() == 'Length' || $('#service_grave_length').val() == '')			
	jQuery('#service_grave_length').val('Length');

if($('#service_grave_width').val() == 'Width' || $('#service_grave_width').val() == '')
	jQuery('#service_grave_width').val('Width');

if($('#service_grave_depth').val() == 'Height' || $('#service_grave_depth').val() == '')
	jQuery('#service_grave_depth').val('Height');

jQuery(document).ready(function()
{
	tabSelection('".(($sf_params->get('tab')) ? $sf_params->get('tab') : 'step1')."','active');
	
	var ssChapel = $(\"input[name='service[other_details][chapel]']:checked\").val();
	var ssRoom = $(\"input[name='service[other_details][room]']:checked\").val();
	
	showHideDiv('chapel','chapeldiv',ssChapel);
	showHideDiv('room','roomydiv',ssRoom);
	
	jQuery(function() 
	{
		jQuery('.nyroModal').nyroModal();
	});
	
	var snCountryId = jQuery('#service_country_id').val();
	var snCemeteryId = $('#service_cem_cemetery_id option').length;
	if(snCountryId > 0 && snCemeteryId == 1)
		callAjaxRequest(snCountryId,'".url_for('servicebooking/getCementryListAsPerCountry')."','service_cementery_list');
});
function tabSelection(id, ssClassName)
{ 
	var asTabs      = new Array('booking_step1','booking_step2','booking_step3','booking_step4','booking_step5','booking_step6');
	var asUpdateDiv = new Array('step1','step2','step3','step4','step5','step6'); 

	for(var i=0;i<asTabs.length;i++)
	{
		jQuery('#' + asTabs[i] ).removeClass(ssClassName);
	}
	
	jQuery('#booking_' + id).addClass(ssClassName);
	
	for(var i=0;i<asUpdateDiv.length;i++)
	{
		jQuery('#' + asUpdateDiv[i] ).hide();
	}
	jQuery('#tab').val(id);
	jQuery('#' + id).show();
}

function letterAction(ssUrl, ssContentType)
{
	ssUrl = ssUrl+'?content_type='+ssContentType;
	window.open(ssUrl,'sendletterwindow','width=1200,height=1000,scrollbars=yes');
}
");
?>