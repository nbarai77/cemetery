<h1><?php echo __('Grave/Plot Report'); ?></h1>
<table width="100%" cellpadding="3" cellspacing="0" border="0">
    <tr>
        <td width="15%"><b><?php echo __('Country'); ?></b></td>
        <td width="85%">:&nbsp;<?php echo (($amGravePlotReportResult[0]['country_name'] != '') ? $amGravePlotReportResult[0]['country_name'] : __('N/A')); ?></td>
	</tr>
	<tr>
        <td><b><?php echo __('Cemetery'); ?></b></td>
        <td>:&nbsp;<?php echo (($amGravePlotReportResult[0]['cemetery_name'] != '') ? $amGravePlotReportResult[0]['cemetery_name'] : __('N/A')); ?></td>
    </tr>
</table>
<div class="clearb">&nbsp;</div>
        
<?php if(isset($amGravePlotReportAsPerDateResult)):
    $snTotVacant 			= isset($amGravePlotReportAsPerDateResult[0]) ? $amGravePlotReportAsPerDateResult[0]['COUNT'] : 0;
	$snTotPrePurchase 		= isset($amGravePlotReportAsPerDateResult[1]) ? $amGravePlotReportAsPerDateResult[1]['COUNT'] : 0;
	$snTotInUse 			= isset($amGravePlotReportAsPerDateResult[2]) ? $amGravePlotReportAsPerDateResult[2]['COUNT'] : 0;
	$snTotToBeInvestigated	= isset($amGravePlotReportAsPerDateResult[3]) ? $amGravePlotReportAsPerDateResult[3]['COUNT'] : 0;
	$snTotTree 				= isset($amGravePlotReportAsPerDateResult[4]) ? $amGravePlotReportAsPerDateResult[4]['COUNT'] : 0;
	$snTotReserved 			= isset($amGravePlotReportAsPerDateResult[5]) ? $amGravePlotReportAsPerDateResult[5]['COUNT'] : 0;
	$snTotOnHold 			= isset($amGravePlotReportAsPerDateResult[6]) ? $amGravePlotReportAsPerDateResult[6]['COUNT'] : 0;
	$snTotaAllocated 		= isset($amGravePlotReportAsPerDateResult[7]) ? $amGravePlotReportAsPerDateResult[7]['COUNT'] : 0;
	$snTotObstruction 		= isset($amGravePlotReportAsPerDateResult[8]) ? $amGravePlotReportAsPerDateResult[8]['COUNT'] : 0;
?>	        
    <table width="100%" border="01" cellpadding="3" cellspacing="0">
        <tbody>
            <tr><td colspan="9" align="center"><strong><?php echo $ssFromDate.'&nbsp;'.__('To').':&nbsp;'.$ssToDate; ?></strong></td></tr>
            <tr>
                <th width="10%" align="left" valign="top"><?php echo __('Vacant'); ?></th>
                <th width="17%" align="left" valign="top"><?php echo __('Pre-Purchased'); ?></th>
                <th width="8%" align="left" valign="top"><?php echo __('In Use'); ?></th>
                <th width="14%" align="left" valign="top"><?php echo __('To Be Investigated'); ?></th>
                <th width="7%" align="left" valign="top"><?php echo __('Tree'); ?></th>
                <th width="12%" align="left" valign="top"><?php echo __('Reserved'); ?></th>
                <th width="10%" align="left" valign="top"><?php echo __('On Hold'); ?></th>
                <th width="11%" align="left" valign="top"><?php echo __('Allocated'); ?></th>
                <th width="11%" align="left" valign="top"><?php echo __('Obstruction'); ?></th>
            </tr>
            <tr>
                <td align="center" valign="top"><?php echo $snTotVacant; ?></td>
                <td align="center" valign="top"><?php echo $snTotPrePurchase; ?></td>
                <td align="center" valign="top"><?php echo $snTotInUse; ?></td>
                <td align="center" valign="top"><?php echo $snTotToBeInvestigated; ?></td>
                <td align="center" valign="top"><?php echo $snTotTree; ?></td>
                <td align="center" valign="top"><?php echo $snTotReserved; ?></td>
                <td align="center" valign="top"><?php echo $snTotOnHold; ?></td>
                <td align="center" valign="top"><?php echo $snTotaAllocated; ?></td>
                <td align="center" valign="top"><?php echo $snTotObstruction; ?></td>
            </tr>
        </tbody>
    </table>
    <div class="clearb">&nbsp;</div>
<?php endif; ?>
        
<?php if(count($amGravePlotReportResult) > 0):
    $snTotVacant 			= isset($amGravePlotReportResult[0]) ? $amGravePlotReportResult[0]['COUNT'] : 0;
	$snTotPrePurchase 		= isset($amGravePlotReportResult[1]) ? $amGravePlotReportResult[1]['COUNT'] : 0;
	$snTotInUse 			= isset($amGravePlotReportResult[2]) ? $amGravePlotReportResult[2]['COUNT'] : 0;
	$snTotToBeInvestigated	= isset($amGravePlotReportResult[3]) ? $amGravePlotReportResult[3]['COUNT'] : 0;
	$snTotTree 				= isset($amGravePlotReportResult[4]) ? $amGravePlotReportResult[4]['COUNT'] : 0;
	$snTotReserved 			= isset($amGravePlotReportResult[5]) ? $amGravePlotReportResult[5]['COUNT'] : 0;
	$snTotOnHold 			= isset($amGravePlotReportResult[6]) ? $amGravePlotReportResult[6]['COUNT'] : 0;
	$snTotaAllocated 		= isset($amGravePlotReportResult[7]) ? $amGravePlotReportResult[7]['COUNT'] : 0;
	$snTotObstruction 		= isset($amGravePlotReportResult[8]) ? $amGravePlotReportResult[8]['COUNT'] : 0;
?>	        
    <table width="100%" border="01" cellpadding="3" cellspacing="0">
        <tbody>
            <tr><td colspan="9" align="center"><strong><?php echo __('Total Grave/Plot Report'); ?></strong></td></tr>
            <tr>
                <th width="10%" align="left" valign="top"><?php echo __('Vacant'); ?></th>
                <th width="17%" align="left" valign="top"><?php echo __('Pre-Purchased'); ?></th>
                <th width="8%" align="left" valign="top"><?php echo __('In Use'); ?></th>
                <th width="14%" align="left" valign="top"><?php echo __('To Be Investigated'); ?></th>
                <th width="7%" align="left" valign="top"><?php echo __('Tree'); ?></th>
                <th width="12%" align="left" valign="top"><?php echo __('Reserved'); ?></th>
                <th width="10%" align="left" valign="top"><?php echo __('On Hold'); ?></th>
                <th width="11%" align="left" valign="top"><?php echo __('Allocated'); ?></th>
                <th width="11%" align="left" valign="top"><?php echo __('Obstruction'); ?></th>
            </tr>
            <tr>
                <td align="center" valign="top"><?php echo $snTotVacant; ?></td>
                <td align="center" valign="top"><?php echo $snTotPrePurchase; ?></td>
                <td align="center" valign="top"><?php echo $snTotInUse; ?></td>
                <td align="center" valign="top"><?php echo $snTotToBeInvestigated; ?></td>
                <td align="center" valign="top"><?php echo $snTotTree; ?></td>
                <td align="center" valign="top"><?php echo $snTotReserved; ?></td>
                <td align="center" valign="top"><?php echo $snTotOnHold; ?></td>
                <td align="center" valign="top"><?php echo $snTotaAllocated; ?></td>
                <td align="center" valign="top"><?php echo $snTotObstruction; ?></td>
            </tr>
        </tbody>
    </table>
<?php endif; ?>
