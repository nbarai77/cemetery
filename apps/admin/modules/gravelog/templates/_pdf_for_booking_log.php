<div style="text-align:center;">
	<b style="font-size:12pt;"><?php echo $ssPDFHeading.' ('. $ssCemetery .')';?></b><br />
	<?php
		$ssOperator = ($ssSearchUserId != '') ? __('Operator'). ': <b>'. $ssUsername.'</b>' : '';
		$ssDate = ($ssSearchOperationDate != '') ? __('Date').': <b>'. $ssSearchOperationDate.'</b>' : '';
		$ssSubHeading = '';
		if($ssOperator != '' && $ssDate != '')
			$ssSubHeading = $ssOperator.'    '.$ssDate;
		elseif($ssOperator != '' && $ssDate == '')
			$ssSubHeading = $ssOperator;
		elseif($ssOperator == '' && $ssDate != '')
			$ssSubHeading = $ssDate;
		echo $ssSubHeading;
	?>
</div>
<div id="main" class="listtable">
  <div class="maintablebg">
    <table width="100%" border="01" cellpadding="2" cellspacing="0">
      <tbody>
        <tr>
			<th width="10%" align="center" valign="top" class="none"><b><?php echo __('Time'); ?></b></th>
			<th width="10%" align="center" valign="top" class="none"><b><?php echo __('Operation'); ?></b></th>
			<th width="15%" align="center" valign="top" class="none"><b><?php echo __('Name'); ?></b></th>
			<th width="7%" align="center" valign="top" class="none"><b><?php  echo __('Area'); ?></b></th>
			<th width="10%" align="center" valign="top" class="none"><b><?php echo __('Section'); ?></b></th>
			<th width="7%" align="center" valign="top" class="none"><b><?php  echo __('Row'); ?></b></th>
			<th width="7%" align="center" valign="top" class="none"><b><?php  echo __('Block'); ?></b></th>
			<th width="10%" align="center" valign="top" class="none"><b><?php echo __('Grave'); ?></b></th>
			<th width="10%" align="center" valign="top" class="none"><b><?php echo __('Grantee'); ?></b></th>
			<th width="10%" align="center" valign="top" class="none"><b><?php echo __('Service'); ?></b></th>
			<th width="10%" align="center" valign="top" class="none"><b><?php echo __('Status'); ?></b></th>
        </tr>
        <?php foreach($sf_data->getRaw('amLogsResult') as $snKey=>$asValues): ?>
        <tr class="<?php echo ($snKey%2 == 0) ? "even" : "odd";?>">
			<td align="left" valign="top"> <?php echo date('d-m-Y h:i:s', strtotime($asValues['operation_date'])); ?> </td>
			<td align="left" valign="top"> <?php echo $asValues['operation']; ?> </td>
			<td align="left" valign="top"> <?php echo $asValues['deceased_surname'].' '.$asValues['deceased_name']; ?> </td>
			<td align="left" valign="top"> <?php echo ($asValues['area'] != '') ? $asValues['area'] : __('N/A'); ?> </td>
			<td align="left" valign="top"> <?php echo ($asValues['section'] != '') ? $asValues['section'] : __('N/A'); ?> </td>
			<td align="left" valign="top"> <?php echo ($asValues['row'] != '') ? $asValues['row'] : __('N/A'); ?> </td>
			<td align="left" valign="top"> <?php echo ($asValues['plot'] != '') ? $asValues['plot'] : __('N/A'); ?> </td>
			<td align="left" valign="top"> <?php echo ($asValues['grave'] != '') ? $asValues['grave'] : __('N/A'); ?> </td>
			<td align="left" valign="top"> <?php echo ($asValues['grantee'] != '') ? $asValues['grantee'] : __('N/A'); ?> </td>
			<td align="left" valign="top"> <?php echo ($asValues['service_type'] != '') ? $asValues['service_type'] : __('N/A'); ?> </td>
			<td align="left" valign="top"> <?php echo ($asValues['status'] == 1) ? __('Finalized') : __('Booking'); ?> </td>
        </tr>
        <?php endforeach;?>
      </tbody>
    </table>
  </div>
</div>
