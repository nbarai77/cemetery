<div id="main" class="listtable">
    <div class="maintablebg">
		<div class="repotDesign">
			<?php if(count($amGraveSectionsReportList) > 0): ?>
				<table width="100%" border="0" cellpadding="0" cellspacing="0">
					<tbody>
						<tr>
						    <th width="55%"><?php echo __('Section');?></th>
							<th width="5%"><?php echo __('Vacant');?></th>
							<th width="5%"><?php echo __('Pre-Purchase');?></th>
							<th width="5%"><?php echo __('In Use');?></th>
							<th width="5%"><?php echo __('To Be Investigated');?></th>
							<th width="5%"><?php echo __('Tree');?></th>
							<th width="5%"><?php echo __('Reserved');?></th>
							<th width="5%"><?php echo __('On Hold');?></th>
							<th width="5%"><?php echo __('Allocated');?></th>
							<th width="5%"><?php echo __('Obstruction');?></th>
						</tr>
						<?php 
                        $snTotalVacant = $snTotalPrePurchase = $snTotalInUse = $snTotalInvestigated = $snTotalTree = $snTotalReserved = $snTotalHold = $snTotalAllocate = $snTotalObstruction = 0;
                        foreach($sf_data->getRaw('amGraveSectionsReportList') as $snKey=>$asValues):?>
							<tr class="<?php echo ($snKey%2 == 0) ? "even" : "odd";?>">								
                                <th><?php echo $asValues['ArSection']['section_name']; ?></th>
                                <td align="center"><?php echo $snVacant = Doctrine::getTable('ArGrave')->getCountGraveStatusWise($snCountryId,$snCemeteryId,$asValues['ar_area_id'],$asValues['ar_section_id'],sfConfig::get('app_grave_status_vacant'));?></td>
								<td align="center"><?php echo $snPrePurchase = Doctrine::getTable('ArGrave')->getCountGraveStatusWise($snCountryId,$snCemeteryId,$asValues['ar_area_id'],$asValues['ar_section_id'],sfConfig::get('app_grave_status_pre_Purchased')); ?></td>
								<td align="center"><?php echo $snInUse = Doctrine::getTable('ArGrave')->getCountGraveStatusWise($snCountryId,$snCemeteryId,$asValues['ar_area_id'],$asValues['ar_section_id'],sfConfig::get('app_grave_status_in_use')); ?></td>
								<td align="center"><?php echo $snInvestigated = Doctrine::getTable('ArGrave')->getCountGraveStatusWise($snCountryId,$snCemeteryId,$asValues['ar_area_id'],$asValues['ar_section_id'],sfConfig::get('app_grave_status_to_be_investigated')); ?></td>
								<td align="center"><?php echo $snTree = Doctrine::getTable('ArGrave')->getCountGraveStatusWise($snCountryId,$snCemeteryId,$asValues['ar_area_id'],$asValues['ar_section_id'],sfConfig::get('app_grave_status_tree')); ?></td>
								<td align="center"><?php echo $snReserved = Doctrine::getTable('ArGrave')->getCountGraveStatusWise($snCountryId,$snCemeteryId,$asValues['ar_area_id'],$asValues['ar_section_id'],sfConfig::get('app_grave_status_reserved')); ?></td>
								<td align="center"><?php echo $snHold = Doctrine::getTable('ArGrave')->getCountGraveStatusWise($snCountryId,$snCemeteryId,$asValues['ar_area_id'],$asValues['ar_section_id'],sfConfig::get('app_grave_status_on_hold')); ?></td>
								<td align="center"><?php echo $snAllocate = Doctrine::getTable('ArGrave')->getCountGraveStatusWise($snCountryId,$snCemeteryId,$asValues['ar_area_id'],$asValues['ar_section_id'],sfConfig::get('app_grave_allocate')); ?></td>
								<td align="center"><?php echo $snObstruction = Doctrine::getTable('ArGrave')->getCountGraveStatusWise($snCountryId,$snCemeteryId,$asValues['ar_area_id'],$asValues['ar_section_id'],sfConfig::get('app_grave_obstruction')); ?></td>
							</tr>
						<?php 
                        $snTotalVacant = $snTotalVacant + $snVacant; 
                        $snTotalPrePurchase = $snTotalPrePurchase + $snPrePurchase; 
                        $snTotalInUse = $snTotalInUse + $snInUse; 
                        $snTotalInvestigated = $snTotalInvestigated + $snInvestigated; 
                        $snTotalTree = $snTotalTree + $snTree; 
                        $snTotalReserved = $snTotalReserved + $snReserved; 
                        $snTotalHold = $snTotalHold + $snHold; 
                        $snTotalAllocate = $snTotalAllocate + $snAllocate; 
                        $snTotalObstruction = $snTotalObstruction + $snObstruction; 
                        endforeach;
                        
						if(count($amGraveAreaTotalReportResult) > 0): ?>
							 <tr style="border-top:1px solid;">
								<th><?php echo __('TOTALS'); ?></th>
								<td align="center"><strong><?php echo $snTotalVacant?></strong></td>
								<td align="center"><strong><?php echo $snTotalPrePurchase; ?></strong></td>
								<td align="center"><strong><?php echo $snTotalInUse; ?></strong></td>
								<td align="center"><strong><?php echo $snTotalInvestigated; ?></strong></td>
								<td align="center"><strong><?php echo $snTotalTree; ?></strong></td>
								<td align="center"><strong><?php echo $snTotalReserved; ?></strong></td>
								<td align="center"><strong><?php echo $snTotalHold ?></strong></td>
								<td align="center"><strong><?php echo $snTotalAllocate; ?></strong></td>
								<td align="center"><strong><?php echo $snTotalObstruction; ?></strong></td>
							</tr>
						<?php endif;?>
					</tbody>
				</table>
			<?php 
				else:
					echo '<div class="warning-msg"><span>'.__('Record(s) not found').'</span></div>';
				endif;
			?>
		</div>
    </div>
</div>
