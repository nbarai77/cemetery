<table width="100%" cellpadding="5" cellspacing="0" border="1">	
	<tr>
		<td colspan="4">
			<h4><?php echo __('Booking Details'); ?>:</h4>
		</td>
	</tr>
	<tr>
		<td align="left" valign="top"> <?php echo __('Service Type'); ?> </td>
		<td align="left" valign="top"> <?php echo $amBookingInfo['service_type_id']; ?> </td>
		<td align="left" valign="top"> <?php echo __('Confirmed'); ?> </td>
		<td align="left" valign="top"> <?php echo $amBookingInfo['confirmed']; ?> </td>		
	</tr>  
	<tr>
		<td align="left" valign="top"> <?php echo __('Date Notified'); ?> </td>
		<td align="left" valign="top"> 
			<?php 
				list($snYear,$snMonth,$snDay) = explode('-',$amBookingInfo['date_notified']);
				echo $snDay.'-'.$snMonth.'-'.$snYear.'&nbsp;';
			?> 
		</td>
		<td align="left" valign="top"> <?php echo __('Taken By'); ?> </td>
		<td align="left" valign="top"> <?php echo $amBookingInfo['confirmed']; ?> </td>		
	</tr>
	<tr>
		<td align="left" valign="top"> <?php echo __('Funeral Director'); ?> </td>
		<td align="left" valign="top"> <?php echo $amBookingInfo['fnd_fndirector_id']; ?> </td>
		<td align="left" valign="top"> <?php echo __('Consultant'); ?> </td>
		<td align="left" valign="top"> <?php echo $amBookingInfo['consultant']; ?> </td>		
	</tr>

	<tr>
		<td align="left" valign="top"> <?php echo __('Service Date 1'); ?> </td>
		<td align="left" valign="top"> 
			<?php 
				list($snYear,$snMonth,$snDay) = explode('-',$amBookingInfo['service_date']);
				echo $snDay.'-'.$snMonth.'-'.$snYear.'&nbsp;';
				echo ($amBookingInfo['date1_day'] != '') ? '('.$amBookingInfo['date1_day'].')' : '';
			?> 
		</td>
		<td align="left" valign="top" colspan="2">
			<table>
				<tr>
					<td><?php echo __('Time From'); ?>: </td>
					<td><?php echo $amBookingInfo['service_booking_time_from']; ?></td>
					<td><?php echo __('Time To'); ?>: </td>
					<td><?php echo $amBookingInfo['service_booking_time_to']; ?></td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td align="left" valign="top"> <?php echo __('Service Date 2'); ?> </td>
		<td align="left" valign="top"> 
			<?php 
				list($snYear,$snMonth,$snDay) = explode('-',$amBookingInfo['service_date2']);
				echo $snDay.'-'.$snMonth.'-'.$snYear.'&nbsp;';
				echo ($amBookingInfo['date2_day'] != '') ? '('.$amBookingInfo['date2_day'].')' : '';
			?> 
		</td>
		<td align="left" valign="top" colspan="2">
			<table>
				<tr>
					<td><?php echo __('Time From'); ?>: </td>
					<td><?php echo $amBookingInfo['service_booking2_time_from']; ?></td>
					<td><?php echo __('Time To'); ?>: </td>
					<td><?php echo $amBookingInfo['service_booking2_time_to']; ?></td>
				</tr>
			</table>
		</td>		 
	</tr>
	<tr>
		<td align="left" valign="top"> <?php echo __('Service Date 3'); ?> </td>
		<td align="left" valign="top"> 
			<?php 
				list($snYear,$snMonth,$snDay) = explode('-',$amBookingInfo['service_date3']);
				echo $snDay.'-'.$snMonth.'-'.$snYear.'&nbsp;';
				echo ($amBookingInfo['date3_day'] != '') ? '('.$amBookingInfo['date3_day'].')' : '';
			?> 
		</td>
		<td align="left" valign="top" colspan="2">
			<table>
				<tr>
					<td><?php echo __('Time From'); ?>: </td>
					<td><?php echo $amBookingInfo['service_booking3_time_from']; ?></td>
					<td><?php echo __('Time To'); ?>: </td>
					<td><?php echo $amBookingInfo['service_booking3_time_to']; ?></td>
				</tr>
			</table>
		</td>		 
	</tr>

	<tr>
		<td align="left" valign="top"> <?php echo __('Deceased Surname'); ?> </td>
		<td align="left" valign="top"> <?php echo $amBookingInfo['deceased_surname']; ?> </td>
		<td align="left" valign="top"> <?php echo __('Deceased Other Surname'); ?> </td>
		<td align="left" valign="top"> <?php echo $amBookingInfo['deceased_other_surname']; ?> </td>		
	</tr>

	<tr>
		<td align="left" valign="top"> <?php echo __('Deceased First Name'); ?> </td>
		<td align="left" valign="top"> <?php echo $amBookingInfo['deceased_first_name']; ?> </td>
		<td align="left" valign="top"> <?php echo __('Deceased Other First Name'); ?> </td>
		<td align="left" valign="top"> <?php echo $amBookingInfo['deceased_other_first_name']; ?> </td>		
	</tr>	

	<tr>
		<td align="left" valign="top"> <?php echo __('Deceased Middle Name'); ?> </td>
		<td align="left" valign="top"> <?php echo $amBookingInfo['deceased_middle_name']; ?> </td>
		<td align="left" valign="top"> <?php echo __('Deceased Other Middle Name'); ?> </td>
		<td align="left" valign="top"> <?php echo $amBookingInfo['deceased_other_middle_name']; ?> </td>		
	</tr>	

	<tr>
		<td align="left" valign="top"> <?php echo __('deceased_gender'); ?> </td>
		<td align="left" valign="top"> <?php echo $amBookingInfo['deceased_gender']; ?> </td>
	</tr>	
	<tr>
		<td colspan="4">
			<h4><?php echo __('Other Details'); ?>:</h4>
		</td>
	</tr>
	<tr>
		<td align="left" valign="top"> <?php echo __('Coffin Type'); ?> </td>
		<td align="left" valign="top"> <?php echo $amBookingInfo['coffin_type_id']; ?> </td>
		<td align="left" valign="top"> <?php echo __('Unit Type'); ?> </td>
		<td align="left" valign="top"> <?php echo $amBookingInfo['unit_type_id']; ?> </td>		
	</tr>
	<tr>
		<td align="left" valign="top"> <?php echo __('Coffin Length'); ?> </td>
		<td align="left" valign="top"> <?php echo $amBookingInfo['IntermentBookingTwo'][0]['coffin_length']; ?> </td>
		<td align="left" valign="top"> <?php echo __('Coffin Width'); ?> </td>
		<td align="left" valign="top"> <?php echo $amBookingInfo['IntermentBookingTwo'][0]['coffin_width']; ?> </td>		
	</tr>
	<tr>
		<td align="left" valign="top"> <?php echo __('Coffin Height'); ?> </td>
		<td align="left" valign="top"> <?php echo $amBookingInfo['IntermentBookingTwo'][0]['coffin_height']; ?> </td>
		<td align="left" valign="top"> <?php echo __('Coffin Surcharge'); ?> </td>
		<td align="left" valign="top"> <?php echo $amBookingInfo['IntermentBookingTwo'][0]['coffin_surcharge']; ?> </td>		
	</tr>
	<tr>
		<td align="left" valign="top"> <?php echo __('Death Certificate'); ?> </td>
		<td align="left" valign="top"> <?php echo $amBookingInfo['IntermentBookingTwo'][0]['death_certificate']; ?> </td>
		<td align="left" valign="top"> <?php echo __('Infectious Disease'); ?> </td>
		<td align="left" valign="top"> <?php echo $amBookingInfo['disease_id']; ?> </td>		
	</tr>
	<tr>
		<td align="left" valign="top"> <?php echo __('Own Clergy'); ?> </td>
		<td align="left" valign="top"> <?php echo $amBookingInfo['IntermentBookingTwo'][0]['own_clergy']; ?> </td>
		<td align="left" valign="top"> <?php echo __('Clergy Name'); ?> </td>
		<td align="left" valign="top"> <?php echo $amBookingInfo['IntermentBookingTwo'][0]['clergy_name']; ?> </td>		
	</tr>
	<tr>
		<td align="left" valign="top"> <?php echo __('Chapel'); ?> </td>
		<td align="left" valign="top"> <?php echo $amBookingInfo['IntermentBookingTwo'][0]['chapel']; ?> </td>
		<td align="left" valign="top" colspan="2">
			<table width="100%" cellspacing="0" cellpadding="1" border="0">
				<tr>
					<td width="10%"><?php echo __('From'); ?>: </td>
					<td width="40%">
						<?php 
							$ssChapelDateFrom = isset($amBookingInfo['IntermentBookingTwo'][0]['chapel_time_from']) ? $amBookingInfo['IntermentBookingTwo'][0]['chapel_time_from'] : '0000-00-00 00:00:00';
							list($ssDate,$ssTime) = explode(' ', $ssChapelDateFrom);
							list($snYear,$snMonth,$snDay) = explode('-',$ssDate);
							echo $snDay.'-'.$snMonth.'-'.$snYear.'&nbsp;'.$ssTime;
						?>
					</td>
					<td width="10%"><?php echo __('To'); ?>: </td>
					<td width="40%">
						<?php 
							$ssChapelDateTo = isset($amBookingInfo['IntermentBookingTwo'][0]['chapel_time_to']) ? $amBookingInfo['IntermentBookingTwo'][0]['chapel_time_to'] : '0000-00-00 00:00:00';
							list($ssDate,$ssTime) = explode(' ',$ssChapelDateTo);
							list($snYear,$snMonth,$snDay) = explode('-',$ssDate);
							echo $snDay.'-'.$snMonth.'-'.$snYear.'&nbsp;'.$ssTime;
						?>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td align="left" valign="top"> <?php echo __('Room'); ?> </td>
		<td align="left" valign="top"> <?php echo $amBookingInfo['IntermentBookingTwo'][0]['room']; ?> </td>
		<td align="left" valign="top" colspan="2">
			<table width="100%" cellspacing="0" cellpadding="1" border="0">
				<tr>
					<td width="10%"><?php echo __('From'); ?>: </td>
					<td width="40%">
						<?php 
							$ssRoomDateFrom = isset($amBookingInfo['IntermentBookingTwo'][0]['room_time_from']) ? $amBookingInfo['IntermentBookingTwo'][0]['room_time_from'] : '0000-00-00 00:00:00';
							list($ssDate,$ssTime) = explode(' ',$ssRoomDateFrom);
							list($snYear,$snMonth,$snDay) = explode('-',$ssDate);
							echo $snDay.'-'.$snMonth.'-'.$snYear.'&nbsp;'.$ssTime;
						?>
					</td>
					<td width="10%"><?php echo __('To'); ?>: </td>
					<td width="40%">
						<?php 
							$ssRoomDateTo = isset($amBookingInfo['IntermentBookingTwo'][0]['room_time_to']) ? $amBookingInfo['IntermentBookingTwo'][0]['room_time_to'] : '0000-00-00 00:00:00';
							list($ssDate,$ssTime) = explode(' ',$ssRoomDateTo);
							list($snYear,$snMonth,$snDay) = explode('-',$ssDate);
							echo $snDay.'-'.$snMonth.'-'.$snYear.'&nbsp;'.$ssTime;
						?>
					</td>
				</tr>
			</table>
		</td>
	</tr>	
	<tr>
		<td align="left" valign="top"> <?php echo __('Burning Drum'); ?> </td>
		<td align="left" valign="top" colspan="3"> <?php echo $amBookingInfo['IntermentBookingTwo'][0]['burning_drum']; ?> </td>
	</tr>
	<tr>
		<td align="left" valign="top"> <?php echo __('Fireworks'); ?> </td>
		<td align="left" valign="top" colspan="3"> <?php echo $amBookingInfo['IntermentBookingTwo'][0]['fireworks']; ?> </td>
	</tr>
	<tr>
		<td align="left" valign="top"> <?php echo __('Ceremonial Sand'); ?> </td>
		<td align="left" valign="top" colspan="3"> <?php echo $amBookingInfo['IntermentBookingTwo'][0]['ceremonial_sand']; ?> </td>
	</tr>
	<tr>
		<td align="left" valign="top"> <?php echo __('Canopy'); ?> </td>
		<td align="left" valign="top" colspan="3"> <?php echo $amBookingInfo['IntermentBookingTwo'][0]['canopy']; ?> </td>
	</tr>
	<tr>
		<td align="left" valign="top"> <?php echo __('Lowering Device'); ?> </td>
		<td align="left" valign="top" colspan="3"> <?php echo $amBookingInfo['IntermentBookingTwo'][0]['lowering_device']; ?> </td>
	</tr>
	<tr>
		<td align="left" valign="top"> <?php echo __('Balloons'); ?> </td>
		<td align="left" valign="top" colspan="3"> <?php echo $amBookingInfo['IntermentBookingTwo'][0]['balloons']; ?> </td>
	</tr>
	<tr>
		<td align="left" valign="top"> <?php echo __('Chapel Multimedia'); ?> </td>
		<td align="left" valign="top"> <?php echo $amBookingInfo['IntermentBookingTwo'][0]['chapel_multimedia']; ?> </td>
	</tr>
	<tr>
		<td align="left" valign="top"> <?php echo __('Cost'); ?> </td>
		<td align="left" valign="top" colspan="3"> <?php echo $amBookingInfo['IntermentBookingTwo'][0]['cost']; ?> </td>
	</tr>
	<tr>
		<td align="left" valign="top"> <?php echo __('Receipt Number'); ?> </td>
		<td align="left" valign="top" colspan="3"> <?php echo $amBookingInfo['IntermentBookingTwo'][0]['receipt_number']; ?> </td>
	</tr>
	<tr>
		<td align="left" valign="top"> <?php echo __('Special Instruction'); ?> </td>
		<td align="left" valign="top" colspan="3"> <?php echo $amBookingInfo['IntermentBookingTwo'][0]['special_instruction']; ?> </td>
	</tr>
	<tr>
		<td align="left" valign="top"> <?php echo __('Notes'); ?> </td>
		<td align="left" valign="top" colspan="3"> <?php echo $amBookingInfo['IntermentBookingTwo'][0]['notes']; ?> </td>
	</tr>	
</table>