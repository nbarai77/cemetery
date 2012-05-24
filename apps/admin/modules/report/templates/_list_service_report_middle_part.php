<div id="main" class="listtable">
    <div class="maintablebg">
        <div class="repotDesign">
            <?php if(count($amGuardUserList) > 0): ?>
                <table width="100%" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                        <tr>
                            <th width="50%" align="left" valign="top"><?php echo __('Section'); ?></th>
                            <th width="10%" align="left" valign="top"><?php echo __('Chapel'); ?></th>
						     <th width="10%" align="left" valign="top"><?php   echo __('Room'); ?></th>
                            <th width="10%" align="left" valign="top"><?php echo __('Exhumations'); ?></th>
                            <th width="10%" align="left" valign="top"><?php echo __('Ashes'); ?></th>
                            <th width="10%" align="left" valign="top"><?php echo __('Burials'); ?></th>
                        </tr>

                        <?php 
                            $snTotalChapel = $snTotalRoom = $snTotalExhumation = $snTotalAshes = $snTotalBurial = 0;
                            foreach($sf_data->getRaw('amGuardUserList') as $snKey=>$asValues): 
                        ?>
                            <tr class="<?php echo ($snKey%2 == 0) ? "even" : "odd";?>">
                                <th align="center" valign="top"><?php echo $asValues['ArSection']['section_name']; ?></th>
                                <td align="center" valign="top"><?php echo $snChapel = Doctrine::getTable('IntermentBooking')->getCountServiceWise($snCountryId,$snCemeteryId, $asValues['ar_area_id'], $asValues['ar_section_id'], 'chapel');?></td>
                                <td align="center" valign="top"><?php echo $snRoom = Doctrine::getTable('IntermentBooking')->getCountServiceWise($snCountryId,$snCemeteryId, $asValues['ar_area_id'], $asValues['ar_section_id'], 'room');?></td>
                                <td align="center" valign="top"><?php echo $snExhumation = Doctrine::getTable('IntermentBooking')->getCountServiceWise($snCountryId,$snCemeteryId, $asValues['ar_area_id'], $asValues['ar_section_id'], sfConfig::get('app_service_type_id_exhumation'));?></td>
                                <td align="center" valign="top"><?php echo $snAshes = Doctrine::getTable('IntermentBooking')->getCountServiceWise($snCountryId,$snCemeteryId, $asValues['ar_area_id'], $asValues['ar_section_id'], sfConfig::get('app_service_type_id_ashes'));?></td>
                                <td align="center" valign="top"><?php echo $snBurials = Doctrine::getTable('IntermentBooking')->getCountServiceWise($snCountryId,$snCemeteryId, $asValues['ar_area_id'], $asValues['ar_section_id'], sfConfig::get('app_service_type_id_interment'));?></td>
                            </tr>
                        <?php 
                            $snTotalChapel = $snTotalChapel + $snChapel; 
                            $snTotalRoom = $snTotalRoom + $snRoom; 
                            $snTotalExhumation = $snTotalExhumation + $snExhumation; 
                            $snTotalAshes = $snTotalAshes + $snAshes; 
                            $snTotalBurial = $snTotalBurial + $snBurials; 
                            endforeach;
    						if(count($amGuardUserList) > 0): ?>
							     <tr style="border-top:1px solid;">
								    <th><?php echo __('TOTALS'); ?></th>
								    <td align="center"><strong><?php echo $snTotalChapel; ?></strong></td>
								    <td align="center"><strong><?php echo $snTotalRoom; ?></strong></td>
								    <td align="center"><strong><?php echo $snTotalExhumation; ?></strong></td>
								    <td align="center"><strong><?php echo $snTotalAshes; ?></strong></td>
								    <td align="center"><strong><?php echo $snTotalBurial; ?></strong></td>
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
