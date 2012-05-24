<table width="100%" cellpadding="5" cellspacing="0" border="1">
	<tr>
		<td colspan="4">
			<h4><?php echo __('Grave details');?></h4>
		</td>
	</tr>
	
	<tr>
		<td align="left" valign="top"> <?php echo __('Country'); ?> </td>
		<td align="left" valign="top" colspan="3"> <?php echo $amBookingInfo['country_name']; ?> </td>
	</tr>
	<tr>
		<td align="left" valign="top"> <?php echo __('Cemetery'); ?> </td>
		<td align="left" valign="top" colspan="3"> <?php echo $amBookingInfo['cemetery_name']; ?> </td>		
	</tr>
	<tr>
		<td align="left" valign="top"> <?php echo __('Area'); ?> </td>
		<td align="left" valign="top"> <?php echo $amBookingInfo['area_name']; ?> </td>
		<td align="left" valign="top"> <?php echo __('Section'); ?> </td>
		<td align="left" valign="top"> <?php echo $amBookingInfo['section_name']; ?> </td>		
	</tr>
	<tr>
		<td align="left" valign="top"> <?php echo __('Row'); ?> </td>
		<td align="left" valign="top"> <?php echo $amBookingInfo['row_name']; ?> </td>
		<td align="left" valign="top"> <?php echo __('Block/Plot'); ?> </td>
		<td align="left" valign="top"> <?php echo $amBookingInfo['plot_name']; ?> </td>		
	</tr>
	<tr>
		<td align="left" valign="top"> <?php echo __('Grave'); ?> </td>
		<td align="left" valign="top" colspan="3"> <?php echo $amBookingInfo['grave_number']; ?> </td>
	</tr>
	<tr>
		<td align="left" valign="top"> <?php echo __('Grave/Plot'); ?> </td>		
		<td align="left" valign="top" colspan="3"> 			
			<table width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td><?php echo __('Length'); ?>: </td>
					<td><?php echo $amBookingInfo['grave_length']; ?> </td>
					<td><?php echo __('Width'); ?>:</td>
					<td><?php echo $amBookingInfo['grave_width']; ?> </td>
					<td><?php echo __('Height'); ?>: </td>
					<td><?php echo $amBookingInfo['grave_depth']; ?> </td>
					<td width="15%"><?php echo __('Unit Type'); ?>: </td>
					<td><?php echo $amBookingInfo['grave_unit_type']; ?> </td>
					<td><?php echo __('Status'); ?>: </td>
					<td><?php echo $amBookingInfo['ar_grave_status']; ?> </td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td colspan="4">
			<h4><?php echo __('Grantee details');?></h4>
		</td>
	</tr>
	<tr>
		<td align="left" valign="top"> <?php echo __('Grantee'); ?> </td>
		<td align="left" valign="top"> <?php echo $amBookingInfo['grantee_id']; ?> </td>
	</tr>
	<tr>
		<td align="left" valign="top"> <?php echo __('Relationship'); ?> </td>
		<td align="left" valign="top" colspan="3"> <?php echo $amBookingInfo['grantee_relationship']; ?> </td>
	</tr>
	<tr>
		<td colspan="4">
			<h4><?php echo __('Monument Details (openings/internals)');?></h4>
		</td>
	</tr>
	<tr>
		<td align="left" valign="top"> <?php echo __('Grave Position'); ?> </td>
		<td align="left" valign="top"> <?php echo $amBookingInfo['monuments_grave_position']; ?> </td>
		<td align="left" valign="top"> <?php echo __('Monument'); ?> </td>
		<td align="left" valign="top"> <?php echo $amBookingInfo['monument']; ?> </td>	
	</tr>
	<tr>
		<td align="left" valign="top"> <?php echo __('Stone Mason'); ?> </td>
		<td align="left" valign="top"> <?php echo $amBookingInfo['cem_stonemason_id']; ?> </td>
		<td align="left" valign="top"> <?php echo __('Block/Plot Unit Type'); ?> </td>
		<td align="left" valign="top"> <?php echo $amBookingInfo['monuments_unit_type']; ?> </td>		
	</tr>
	<tr>
		<td align="left" valign="top"> <?php echo __('Depth'); ?> </td>
		<td align="left" valign="top"> <?php echo $amBookingInfo['monuments_depth']; ?> </td>
		<td align="left" valign="top"> <?php echo __('Length'); ?> </td>
		<td align="left" valign="top"> <?php echo $amBookingInfo['monuments_length']; ?> </td>		
	</tr>
	<tr>
		<td align="left" valign="top"> <?php echo __('Width'); ?> </td>
		<td align="left" valign="top" colspan="3"> <?php echo $amBookingInfo['monuments_width']; ?> </td>
	</tr>
</table>