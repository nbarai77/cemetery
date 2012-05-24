<table width="100%" cellpadding="5" cellspacing="0" border="1">
	<tr>
		<td colspan="4">
			<h4><?php echo __('Final Booking Checklist'); ?>:</h4>
			<?php $snI=0;?>
		</td>
	</tr>
	<tr>
		<td align="left" valign="top" width="75%"> <?php echo __('File Location'); ?> </td>
		<td align="left" valign="top" colspan="3" width="25%"> <?php echo $amBookingInfo['IntermentBookingThree'][0]['file_location']; ?> </td>
	</tr>
	<tr>
		<td align="left" valign="top"> <?php echo '<b>'.++$snI .'</b>&nbsp;'.__('Cemetery Application'); ?> </td>
		<td align="left" valign="top" colspan="3"> <?php echo $amBookingInfo['IntermentBookingThree'][0]['cemetery_application']; ?> </td>
	</tr>
	<tr>
		<td align="left" valign="top"> <?php echo '<b>'.++$snI .'</b>&nbsp;'.__('Burial Booking Form'); ?> </td>
		<td align="left" valign="top" colspan="3"> <?php echo $amBookingInfo['IntermentBookingThree'][0]['burial_booking_form']; ?> </td>
	</tr>
	<tr>
		<td align="left" valign="top"> <?php echo '<b>'.++$snI .'</b>&nbsp;'.__('Ashes Booking Form'); ?> </td>
		<td align="left" valign="top" colspan="3"> <?php echo $amBookingInfo['IntermentBookingThree'][0]['ashes_booking_form']; ?> </td>
	</tr>
	<tr>
		<td align="left" valign="top" colspan="4">
			<table width="100%" cellspacing="0" cellpadding="1" border="0">
				<tr>
					<td align="left" valign="top" width="76%"> <?php echo '<b>'.++$snI .'</b>&nbsp;'.__('Exhumation Booking From'); ?> </td>
					<td align="left" valign="top" width="24%"> <?php echo $amBookingInfo['IntermentBookingThree'][0]['exhumation_booking_from']; ?> </td>
				</tr>
				<tr>
					<td valign="top" align="left" width="76%">
						<span style="float:left; font-weight:bold;padding:0 0 0 35px;"> &bull;&nbsp;</span>
						<?php echo __('HealthDepartment Order'); ?>
					</td>
					<td valign="top" width="24%">
						<?php echo $amBookingInfo['IntermentBookingThree'][0]['health_order']; ?>
					</td>
				</tr>
				<tr>
					<td valign="top" align="left" width="76%">
						<span style="float:left; font-weight:bold;padding:0 0 0 35px;"> &bull;&nbsp;</span>
						<?php echo __('Court Order'); ?>
					</td>
					<td valign="top" width="24%">
						<?php echo $amBookingInfo['IntermentBookingThree'][0]['court_order']; ?>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td align="left" valign="top"> <?php echo '<b>'.++$snI .'</b>&nbsp;'.__('Remains Booking From'); ?> </td>
		<td align="left" valign="top" colspan="3"> <?php echo $amBookingInfo['IntermentBookingThree'][0]['remains_booking_from']; ?> </td>
	</tr>	
	<tr>
		<td align="left" valign="top"> <?php echo '<b>'.++$snI .'</b>&nbsp;'.__('Checked Funeral Directors detail- Name, address and Fax number'); ?> </td>
		<td align="left" valign="top" colspan="3"> <?php echo $amBookingInfo['IntermentBookingThree'][0]['checked_fnd_details']; ?> </td>
	</tr>
	<tr>
		<td align="left" valign="top" colspan="4">
			<table width="100%" cellspacing="0" cellpadding="1" border="0">
				<tr>
					<td align="left" valign="top" width="76%"> <?php echo '<b>'.++$snI .'</b>&nbsp;'.__('Checked Grave and Section including owner details'); ?> </td>
					<td align="left" valign="top" width="24%"> <?php echo $amBookingInfo['IntermentBookingThree'][0]['checked_owner_grave']; ?> </td>
				</tr>
				<tr>
					<td colspan="2" style="padding:0px 45px 0px 0px;">
						<?php echo __('Has all the necessary documenttion and permission been recieved from either:');?>
					</td>
				</tr>
				<tr>
					<td valign="top" align="left" width="76%">
						<span style="float:left; font-weight:bold;padding:0 0 0 35px;"> &bull;&nbsp;</span>
						<?php echo __('Living grave owner'); ?>
					</td>
					<td valign="top" width="24%">
						<?php echo $amBookingInfo['IntermentBookingThree'][0]['living_grave_owner']; ?>
					</td>
				</tr>
				<tr>
					<td valign="top" align="left" width="76%">
						<span style="float:left; font-weight:bold;padding:0 0 0 35px;"> &bull;&nbsp;</span>
						<?php echo __('Deceased grave owner: all their heirs and or descendants'); ?>
					</td>
					<td valign="top" width="24%">
						<?php echo $amBookingInfo['IntermentBookingThree'][0]['deceased_grave_owner']; ?>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td align="left" valign="top" colspan="4">
			<table width="100%" cellspacing="0" cellpadding="1" border="0">
				<tr>
					<td align="left" valign="top" width="76%"> <?php echo '<b>'.++$snI .'</b>&nbsp;'.__('Checked Chapel booking(if requested)'); ?> </td>
					<td align="left" valign="top" width="24%"> <?php echo $amBookingInfo['IntermentBookingThree'][0]['cecked_chapel_booking']; ?> </td>
				</tr>				
				<tr>
					<td valign="top" align="left" width="76%">
						<span style="float:left; font-weight:bold;padding:0 0 0 35px;"> &bull;&nbsp;</span>
						<?php echo __('Advised FD to check Chapel Equipment at least one day before'); ?>
					</td>
					<td valign="top" width="24%">
						<?php echo $amBookingInfo['IntermentBookingThree'][0]['advised_fd_to_check']; ?>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td align="left" valign="top" colspan="4">
			<table width="100%" cellspacing="0" cellpadding="1" border="0">
				<tr>
					<td align="left" valign="top" width="76%"> <?php echo '<b>'.++$snI .'</b>&nbsp;'.__('Advised FD of recommended Coffin Sizes'); ?> </td>
					<td align="left" valign="top" width="24%"> <?php echo $amBookingInfo['IntermentBookingThree'][0]['advised_fd_recommended']; ?> </td>
				</tr>				
				<tr>
					<td valign="top" align="left" width="76%">
						<span style="float:left; font-weight:bold;padding:0 0 0 35px;"> &bull;&nbsp;</span>
						<?php echo __('Advised FD of coffin height surcharges'); ?>
					</td>
					<td valign="top" width="24%">
						<?php echo $amBookingInfo['IntermentBookingThree'][0]['advised_fd_coffin_height']; ?>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td align="left" valign="top" colspan="4">
			<table width="100%" cellspacing="0" cellpadding="1" border="0">
				<tr>
					<td align="left" valign="top" colspan="2"> <?php echo '<b>'.++$snI .'</b>&nbsp;'.__('Medical Cause of Death Certificate'); ?> </td>
				</tr>				
				<tr>
					<td valign="top" align="left" width="76%">
						<span style="float:left; font-weight:bold;padding:0 0 0 35px;"> &bull;&nbsp;</span>
						<?php echo __('Recieved'); ?>
					</td>
					<td valign="top" width="24%">
						<?php echo $amBookingInfo['IntermentBookingThree'][0]['medical_death_certificate']; ?>
					</td>
				</tr>
				<tr>
					<td valign="top" align="left" width="76%">
						<span style="float:left; font-weight:bold;padding:0 0 0 35px;"> &bull;&nbsp;</span>
						<?php echo __('Checked spelling of deceased full name'); ?>
					</td>
					<td valign="top" width="24%">
						<?php echo $amBookingInfo['IntermentBookingThree'][0]['medical_certificate_spelling']; ?>
					</td>
				</tr>
				<tr>
					<td valign="top" align="left" width="76%">
						<span style="float:left; font-weight:bold;padding:0 0 0 35px;"> &bull;&nbsp;</span>
						<?php echo __('Checked for infectious diseases. If "Yes" noted same on booking sheets'); ?>
					</td>
					<td valign="top" width="24%">
						<?php echo $amBookingInfo['IntermentBookingThree'][0]['medical_certificate_infectious']; ?>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td align="left" valign="top"> <?php echo '<b>'.++$snI .'</b>&nbsp;'.__('Request for triple depth grave on re-opens'); ?> </td>
		<td align="left" valign="top" colspan="3"> <?php echo $amBookingInfo['IntermentBookingThree'][0]['request_probe_reopen']; ?> </td>
	</tr>
	<tr>
		<td align="left" valign="top"> <?php echo '<b>'.++$snI .'</b>&nbsp;'.__('Request triple depth reopen'); ?> </td>
		<td align="left" valign="top" colspan="3"> <?php echo $amBookingInfo['IntermentBookingThree'][0]['request_triple_depth_reopen']; ?> </td>
	</tr>
	<tr>
		<td align="left" valign="top"> <?php echo '<b>'.++$snI .'</b>&nbsp;'.__('Checked Monumental information'); ?> </td>
		<td align="left" valign="top" colspan="3"> <?php echo $amBookingInfo['IntermentBookingThree'][0]['checked_monumental']; ?> </td>
	</tr>
	<tr>
		<td align="left" valign="top" colspan="4">
			<table width="100%" cellspacing="0" cellpadding="1" border="0">				
				<tr>
					<td valign="top" align="left" width="76%">
						<span style="float:left; font-weight:bold;padding:0 0 0 35px;"> &bull;&nbsp;</span>
						<?php echo __('Contacted Stonemason if needed (e.g. slab removal)'); ?>
					</td>
					<td valign="top" width="24%">
						<?php echo $amBookingInfo['IntermentBookingThree'][0]['contacted_stonemason']; ?>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td align="left" valign="top" colspan="4">
			<table width="100%" cellspacing="0" cellpadding="1" border="0">
				<tr>
					<td align="left" valign="top" width="76%"> <?php echo '<b>'.++$snI .'</b>&nbsp;'.__('Checked accessories'); ?> </td>
					<td align="left" valign="top" width="24%"> <?php echo $amBookingInfo['IntermentBookingThree'][0]['checked_accessories']; ?> </td>
				</tr>
				<tr>
					<td valign="top" align="left" width="76%">
						<span style="float:left; font-weight:bold;padding:0 0 0 35px;"> &bull;&nbsp;</span>
						<?php echo __('BalloonsN/A'); ?>
					</td>
					<td valign="top" width="24%">
						<?php echo $amBookingInfo['IntermentBookingThree'][0]['balloons_na']; ?>
					</td>
				</tr>
				<tr>
					<td valign="top" align="left" width="76%">
						<span style="float:left; font-weight:bold;padding:0 0 0 35px;"> &bull;&nbsp;</span>
						<?php echo __('Burning Drum'); ?>
					</td>
					<td valign="top" width="24%">
						<?php echo $amBookingInfo['IntermentBookingThree'][0]['burning_drum']; ?>
					</td>
				</tr>
				<tr>
					<td valign="top" align="left" width="76%">
						<span style="float:left; font-weight:bold;padding:0 0 0 35px;"> &bull;&nbsp;</span>
						<?php echo __('Canopy'); ?>
					</td>
					<td valign="top" width="24%">
						<?php echo $amBookingInfo['IntermentBookingThree'][0]['canopy']; ?>
					</td>
				</tr>
				<tr>
					<td valign="top" align="left" width="76%">
						<span style="float:left; font-weight:bold;padding:0 0 0 35px;"> &bull;&nbsp;</span>
						<?php echo __('Ceremonial Sand Bucket'); ?>
					</td>
					<td valign="top" width="24%">
						<?php echo $amBookingInfo['IntermentBookingThree'][0]['ceremonial_sand_bucket']; ?>
					</td>
				</tr>
				<tr>
					<td valign="top" align="left" width="76%">
						<span style="float:left; font-weight:bold;padding:0 0 0 35px;"> &bull;&nbsp;</span>
						<?php echo __('Fireworks'); ?>
					</td>
					<td valign="top" width="24%">
						<?php echo $amBookingInfo['IntermentBookingThree'][0]['fireworks']; ?>
					</td>
				</tr>
				<tr>
					<td valign="top" align="left" width="76%">
						<span style="float:left; font-weight:bold;padding:0 0 0 35px;"> &bull;&nbsp;</span>
						<?php echo __('Lowering Device'); ?>
					</td>
					<td valign="top" width="24%">
						<?php echo $amBookingInfo['IntermentBookingThree'][0]['lowering_device']; ?>
					</td>
				</tr>
				<tr>
					<td valign="top" align="left" width="76%">
						<span style="float:left; font-weight:bold;padding:0 0 0 35px;"> &bull;&nbsp;</span>
						<?php echo __('Other'); ?>
					</td>
					<td valign="top" width="24%">
						<?php echo $amBookingInfo['IntermentBookingThree'][0]['other']; ?>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td align="left" valign="top"> <?php echo '<b>'.++$snI .'</b>&nbsp;'.__('Checked confirmation signed and returned'); ?> </td>
		<td align="left" valign="top" colspan="3"> <?php echo $amBookingInfo['IntermentBookingThree'][0]['checked_returned_signed']; ?> </td>
	</tr>
	<tr>
		<td align="left" valign="top" colspan="4">
			<table width="100%" cellspacing="0" cellpadding="1" border="0">
				<tr>
					<td align="left" valign="top" width="76%"> <?php echo '<b>'.++$snI .'</b>&nbsp;'.__('Check coffin sizes are acceptable and surcharge applied'); ?> </td>
					<td align="left" valign="top" width="24%"> <?php echo $amBookingInfo['IntermentBookingThree'][0]['check_coffin_sizes_surcharge']; ?> </td>
				</tr>				
				<tr>
					<td valign="top" align="left" width="76%">
						<span style="float:left; font-weight:bold;padding:0 0 0 35px;"> &bull;&nbsp;</span>
						<?php echo __('Surcharge applied'); ?>
					</td>
					<td valign="top" width="24%">
						<?php echo $amBookingInfo['IntermentBookingThree'][0]['surcharge_applied']; ?>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td align="left" valign="top"> <?php echo '<b>'.++$snI .'</b>&nbsp;'.__('Compare Burial check to burial booking (coffin size/spear lowering)'); ?> </td>
		<td align="left" valign="top" colspan="3"> <?php echo $amBookingInfo['IntermentBookingThree'][0]['compare_burial_booking']; ?> </td>
	</tr>
	<tr>
		<td align="left" valign="top"> <?php echo '<b>'.++$snI .'</b>&nbsp;'.__('For in-between burials, check surcharge has been paid'); ?> </td>
		<td align="left" valign="top" colspan="3"> <?php echo $amBookingInfo['IntermentBookingThree'][0]['for_between_burials']; ?> </td>
	</tr>
	<tr>
		<td align="left" valign="top"> <?php echo '<b>'.++$snI .'</b>&nbsp;'.__('Double check that yellow copy shows up to date information ie. coffin sizes, burial times etc...'); ?> </td>
		<td align="left" valign="top" colspan="3"> <?php echo $amBookingInfo['IntermentBookingThree'][0]['double_check_yellow_date']; ?> </td>
	</tr>
</table>