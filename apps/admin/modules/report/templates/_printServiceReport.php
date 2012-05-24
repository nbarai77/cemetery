<h1><?php echo __('Cemetery Service Report'); ?></h1>
<table width="100%" cellpadding="3" cellspacing="0" border="0">
    <tr>
        <td width="15%"><b><?php echo __('Country'); ?></b></td>
        <td width="85%">:&nbsp;<?php echo (($amServiceReportResult[0]['country_name'] != '') ? $amServiceReportResult[0]['country_name'] : __('N/A')); ?></td>
	</tr>
	<tr>
        <td><b><?php echo __('Cemetery'); ?></b></td>
        <td>:&nbsp;<?php echo (($amServiceReportResult[0]['cemetery_name'] != '') ? $amServiceReportResult[0]['cemetery_name'] : __('N/A')); ?></td>
    </tr>
</table>
<div class="clearb">&nbsp;</div>
        
<?php 
    $snTotChapel = $snTotRoom = $snTotBurials = $snTotExhumation = $snTotAshes = 0;
    if(isset($amServiceReportAsPerDateResult)):
        foreach($amServiceReportAsPerDateResult as $amResult):
            switch($amResult['ServiceType']['id']){
                case 1:
                    $snTotBurials = $amResult['COUNT'];
                    break;
                case 2:
                    $snTotExhumation = $amResult['COUNT'];
                    break;
                case 3:
                    $snTotAshes = $amResult['COUNT'];
                    break;        
            }
        endforeach;
        $snTotChapel 		= isset($amServiceReportAsPerDateResult[0]) ? $amServiceReportAsPerDateResult[0]['chapel'] : 0;
	    $snTotRoom 		    = isset($amServiceReportAsPerDateResult[0]) ? $amServiceReportAsPerDateResult[0]['room'] : 0;
?>	        
        <table width="100%" border="01" cellpadding="3" cellspacing="0">
            <tbody>
                <tr><td colspan="5" align="center"><strong><?php echo $ssFromDate.'&nbsp;'.__('To').':&nbsp;'.$ssToDate; ?></strong></td></tr>
                <tr>
                    <th width="20%" align="left" valign="top"><?php echo __('Chapel'); ?></th>
                    <th width="20%" align="left" valign="top"><?php echo __('Room'); ?></th>
                    <th width="20%" align="left" valign="top"><?php echo __('Burials'); ?></th>
                    <th width="20%" align="left" valign="top"><?php echo __('Ashes'); ?></th>
                    <th width="20%" align="left" valign="top"><?php echo __('Exhumations'); ?></th>
                </tr>
                <tr>
                    <td align="left" valign="top"><?php echo $snTotChapel; ?></td>
                    <td align="left" valign="top"><?php echo $snTotRoom; ?></td>
                    <td align="left" valign="top"><?php echo $snTotBurials; ?></td>
                    <td align="left" valign="top"><?php echo $snTotAshes; ?></td>
                    <td align="left" valign="top"><?php echo $snTotExhumation; ?></td>
                </tr>
            </tbody>
        </table>
        <div class="clearb">&nbsp;</div>
<?php endif; ?>
        
<?php 
    $snTotChapel = $snTotRoom = $snTotBurials = $snTotExhumation = $snTotAshes = 0;
    if(count($amServiceReportResult) > 0):
        foreach($amServiceReportResult as $amResult):
            switch($amResult['ServiceType']['id']){
                case 1:
                    $snTotBurials = $amResult['COUNT'];
                    break;
                case 2:
                    $snTotExhumation = $amResult['COUNT'];
                    break;
                case 3:
                    $snTotAshes = $amResult['COUNT'];
                    break;        
            }
        endforeach;
        $snTotChapel 		= isset($amServiceReportResult[0]) ? $amServiceReportResult[0]['chapel'] : 0;
	    $snTotRoom 		    = isset($amServiceReportResult[0]) ? $amServiceReportResult[0]['room'] : 0;
?>	        
        <table width="100%" border="01" cellpadding="3" cellspacing="0">
            <tbody>
                <tr><td colspan="5" align="center"><strong><?php echo __('Total Service Report'); ?></strong></td></tr>
                <tr>
                    <th width="20%" align="left" valign="top"><?php echo __('Chapel'); ?></th>
                    <th width="20%" align="left" valign="top"><?php echo __('Room'); ?></th>
                    <th width="20%" align="left" valign="top"><?php echo __('Burials'); ?></th>
                    <th width="20%" align="left" valign="top"><?php echo __('Ashes'); ?></th>
                    <th width="20%" align="left" valign="top"><?php echo __('Exhumations'); ?></th>
                </tr>
                <tr>
                    <td align="left" valign="top"><?php echo $snTotChapel; ?></td>
                    <td align="left" valign="top"><?php echo $snTotRoom; ?></td>
                    <td align="left" valign="top"><?php echo $snTotBurials; ?></td>
                    <td align="left" valign="top"><?php echo $snTotAshes; ?></td>
                    <td align="left" valign="top"><?php echo $snTotExhumation; ?></td>
                </tr>
            </tbody>
        </table>
<?php endif; ?>
