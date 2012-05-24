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
		
		$ssWidth = ($ssLogType != 'gravelog') ? 'width="8%"' : 'width="15%"';
	?>
</div>
<div id="main" class="listtable">
  <div class="maintablebg">
    <table width="100%" border="01" cellpadding="2" cellspacing="0">
      <tbody>
        <tr>
          <th width="12%" align="left" valign="top" class="none"><b><?php echo __('Time'); ?></b></th>
          <th width="12%" align="left" valign="top" class="none"><b><?php echo __('Operation'); ?></b></th>
		  <?php if($ssLogType != 'gravelog'):?>
		  <th width="15%" align="left" valign="top" class="none"><b><?php echo __('Transfer From'); ?></b></th>
		  <th width="15%" align="left" valign="top" class="none"><b><?php echo __('Transfer To'); ?></b></th>
		  <?php endif;?>
          <th <?php echo $ssWidth ?> align="left" valign="top" class="none"><b><?php echo __('Area'); ?></b></th>
          <th <?php echo $ssWidth ?> align="left" valign="top" class="none"><b><?php echo __('Section'); ?></b></th>
          <th <?php echo $ssWidth ?> align="left" valign="top" class="none"><b><?php echo __('Row'); ?></b></th>
          <th width="10%" align="left" valign="top" class="none"><b><?php echo __('Plot '); ?></b></th>
          <th width="13%" align="left" valign="top" class="none"><b><?php echo __('Grave Number'); ?></b></th>
        </tr>
        <?php foreach($sf_data->getRaw('amLogsResult') as $snKey=>$asValues): ?>
        <tr class="<?php echo ($snKey%2 == 0) ? "even" : "odd";?>">
          <td align="left" valign="top"><?php echo date('d-m-Y h:i:s', strtotime($asValues['operation_date'])); ?> </td>
          <td align="left" valign="top"><?php echo $asValues['operation']; ?> </td>
		  <?php if($ssLogType != 'gravelog'):?>
		  <td align="left" valign="top"> <?php echo $asValues['old_grantee']; ?> </td>
		  <td align="left" valign="top"> <?php echo ($asValues['new_grantee'] != '') ? $asValues['new_grantee'] : __('N/A'); ?> </td>
		  <?php endif;?>
          <td align="left" valign="top"><?php echo ($asValues['area_name'] != '') ? $asValues['area_name'] : __('N/A'); ?> </td>
          <td align="left" valign="top"><?php echo ($asValues['section_name'] != '') ? $asValues['section_name'] : __('N/A'); ?> </td>
          <td align="left" valign="top"><?php echo ($asValues['row_name'] != '') ? $asValues['row_name'] : __('N/A'); ?> </td>
          <td align="left" valign="top"><?php echo ($asValues['plot_name'] != '') ? $asValues['plot_name'] : __('N/A'); ?> </td>
          <td align="left" valign="top"><?php echo $asValues['grave_number']; ?> </td>
        </tr>
        <?php endforeach;?>
      </tbody>
    </table>
  </div>
</div>
