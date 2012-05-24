<table width="100%" cellpadding="5" cellspacing="0" border="1">
	<tr>
		<td colspan="4">			
			<h4><?php echo __('Deceased Details'); ?>:</h4>
		</td>
	</tr>
	<tr>
		<td align="left" valign="top"> <?php echo __('Date of Death'); ?> </td>
		<td align="left" valign="top"> 
			<?php 
				$ssDOD = isset($amBookingInfo['IntermentBookingFour'][0]['deceased_date_of_death']) ? $amBookingInfo['IntermentBookingFour'][0]['deceased_date_of_death'] : '0000-00-00';
				list($snYear,$snMonth,$snDay) = explode('-',$ssDOD);
				echo $snDay.'-'.$snMonth.'-'.$snYear.'&nbsp;';
			?> 
		</td>
		<td align="left" valign="top"> <?php echo __('Date Of Birth'); ?> </td>
		<td align="left" valign="top"> 
			<?php 
				$ssDOB = isset($amBookingInfo['IntermentBookingFour'][0]['deceased_date_of_birth']) ? $amBookingInfo['IntermentBookingFour'][0]['deceased_date_of_birth'] : '0000-00-00';
				list($snYear,$snMonth,$snDay) = explode('-',$ssDOB);
				echo $snDay.'-'.$snMonth.'-'.$snYear.'&nbsp;';
			?> 
		</td>
	</tr>
	<tr>
		<td align="left" valign="top"> <?php echo __('Place of Death'); ?> </td>
		<td align="left" valign="top"> <?php echo $amBookingInfo['IntermentBookingFour'][0]['deceased_place_of_death']; ?> </td>
		<td align="left" valign="top"> <?php echo __('Place of Birth'); ?> </td>
		<td align="left" valign="top"> <?php echo $amBookingInfo['IntermentBookingFour'][0]['deceased_place_of_birth']; ?> </td>		
	</tr>
	<tr>
		<td align="left" valign="top"> <?php echo __('Country of Death'); ?> </td>
		<td align="left" valign="top"> <?php echo $amBookingInfo['deceased_country_id_of_death']; ?> </td>
		<td align="left" valign="top"> <?php echo __('Country of Birth'); ?> </td>
		<td align="left" valign="top"> <?php echo $amBookingInfo['deceased_country_id_of_birth']; ?> </td>		
	</tr>
	<tr>
		<td align="left" valign="top"> <?php echo __('Age'); ?> </td>
		<td align="left" valign="top"> <?php echo $amBookingInfo['IntermentBookingFour'][0]['deceased_age']; ?> </td>
		<td align="left" valign="top"> <?php echo __('Usual Address'); ?> </td>
		<td align="left" valign="top"> <?php echo $amBookingInfo['IntermentBookingFour'][0]['deceased_usual_address']; ?> </td>		
	</tr>
	<tr>
		<td align="left" valign="top"> <?php echo __('Subrub/Town'); ?> </td>
		<td align="left" valign="top"> <?php echo $amBookingInfo['IntermentBookingFour'][0]['deceased_suburb_town']; ?> </td>
		<td align="left" valign="top"> <?php echo __('Postal Code'); ?> </td>
		<td align="left" valign="top"> <?php echo $amBookingInfo['IntermentBookingFour'][0]['deceased_postal_code']; ?> </td>		
	</tr>
	<tr>
		<td align="left" valign="top"> <?php echo __('Country'); ?> </td>
		<td align="left" valign="top"> <?php echo $amBookingInfo['deceased_country_id']; ?> </td>
		<td align="left" valign="top"> <?php echo __('Marital Status'); ?> </td>
		<td align="left" valign="top"> <?php echo $amBookingInfo['IntermentBookingFour'][0]['deceased_marital_status']; ?> </td>		
	</tr>
	<tr>
		<td align="left" valign="top"> <?php echo __('Partner Surname'); ?> </td>
		<td align="left" valign="top"> <?php echo $amBookingInfo['IntermentBookingFour'][0]['deceased_partner_surname']; ?> </td>
		<td align="left" valign="top"> <?php echo __('Partner Name'); ?> </td>
		<td align="left" valign="top"> <?php echo $amBookingInfo['IntermentBookingFour'][0]['deceased_partner_name']; ?> </td>		
	</tr>
	<tr>
		<td align="left" valign="top"> <?php echo __('Father Surname'); ?> </td>
		<td align="left" valign="top"> <?php echo $amBookingInfo['IntermentBookingFour'][0]['deceased_father_surname']; ?> </td>
		<td align="left" valign="top"> <?php echo __('Father Name'); ?> </td>
		<td align="left" valign="top"> <?php echo $amBookingInfo['IntermentBookingFour'][0]['deceased_father_name']; ?> </td>		
	</tr>
	<tr>
		<td align="left" valign="top"> <?php echo __('Mother Maiden Surname'); ?> </td>
		<td align="left" valign="top"> <?php echo $amBookingInfo['IntermentBookingFour'][0]['deceased_mother_maiden_surname']; ?> </td>
		<td align="left" valign="top"> <?php echo __('Mother Name'); ?> </td>
		<td align="left" valign="top"> <?php echo $amBookingInfo['IntermentBookingFour'][0]['deceased_mother_name']; ?> </td>		
	</tr>
	<tr>
		<td align="left" valign="top"> <?php echo __('Children of Deceased'); ?> </td>
		<td align="left" valign="top" colspan="3">
			<table width="100%" cellspacing="0" cellpadding="0">
				<tr>
					<td align="left" valign="top"> <?php echo $amBookingInfo['IntermentBookingFour'][0]['deceased_children1']; ?> </td>	
					<td align="left" valign="top"> <?php echo $amBookingInfo['IntermentBookingFour'][0]['deceased_children2']; ?> </td>	
					<td align="left" valign="top"> <?php echo $amBookingInfo['IntermentBookingFour'][0]['deceased_children3']; ?> </td>	
				</tr>
				<tr>
					<td align="left" valign="top"> <?php echo $amBookingInfo['IntermentBookingFour'][0]['deceased_children4']; ?> </td>	
					<td align="left" valign="top"> <?php echo $amBookingInfo['IntermentBookingFour'][0]['deceased_children5']; ?> </td>	
					<td align="left" valign="top"> <?php echo $amBookingInfo['IntermentBookingFour'][0]['deceased_children6']; ?> </td>	
				</tr>
				<tr>
					<td align="left" valign="top"> <?php echo $amBookingInfo['IntermentBookingFour'][0]['deceased_children7']; ?> </td>	
					<td align="left" valign="top"> <?php echo $amBookingInfo['IntermentBookingFour'][0]['deceased_children8']; ?> </td>	
					<td align="left" valign="top"> <?php echo $amBookingInfo['IntermentBookingFour'][0]['deceased_children9']; ?> </td>	
				</tr>
			</table>
		</td>
	</tr>
		<tr>
		<td align="left" valign="top"> <?php echo __('Control Number'); ?> </td>
		<td align="left" valign="top" colspan="3"> <?php echo $amBookingInfo['IntermentBookingFour'][0]['control_number']; ?> </td>
	</tr>
	<tr>
		<td colspan="4">
			<h4><?php echo __('Cultural/Religious Details'); ?>:</h4>
		</td>
	</tr>
	<tr>
		<td align="left" valign="top"> <?php echo __('Background'); ?> </td>
		<td align="left" valign="top"> <?php echo $amBookingInfo['IntermentBookingFour'][0]['cul_calender_type']; ?> </td>
		<td align="left" valign="top"> <?php echo __('Time of Death'); ?> </td>
		<td align="left" valign="top"> <?php echo $amBookingInfo['IntermentBookingFour'][0]['cul_time_of_death']; ?> </td>		
	</tr>
	<tr>
		<td align="left" valign="top"> <?php echo __('Date of Death'); ?> </td>
		<td align="left" valign="top"> <?php echo $amBookingInfo['IntermentBookingFour'][0]['cul_date_of_death']; ?> </td>
		<td align="left" valign="top"> <?php echo __('Date of Birth'); ?> </td>
		<td align="left" valign="top"> <?php echo $amBookingInfo['IntermentBookingFour'][0]['cul_date_of_birth']; ?> </td>		
	</tr>
	<tr>
		<td align="left" valign="top"> <?php echo __('Date of Interment'); ?> </td>
		<td align="left" valign="top"> <?php echo $amBookingInfo['IntermentBookingFour'][0]['cul_date_of_interment']; ?> </td>
		<td align="left" valign="top"> <?php echo __('Status'); ?> </td>
		<td align="left" valign="top"> <?php echo $amBookingInfo['IntermentBookingFour'][0]['cul_status']; ?> </td>		
	</tr>
	<tr>
		<td align="left" valign="top"> <?php echo __('Died After Dusk'); ?> </td>
		<td align="left" valign="top"> 
			<?php 
				$ssStatus = ($amBookingInfo['IntermentBookingFour'][0]['cul_died_after_dust'] == '1') ? __('Yes') : __('No');
				echo $ssStatus; 
			?> 
		</td>
		<td align="left" valign="top"> <?php echo __('Remains Position'); ?> </td>
		<td align="left" valign="top"> <?php echo $amBookingInfo['IntermentBookingFour'][0]['cul_remains_position']; ?> </td>		
	</tr>	
</table>