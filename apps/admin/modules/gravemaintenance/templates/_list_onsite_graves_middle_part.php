<div id="main" class="listtable">
    <div class="maintablebg">
        <?php if(count($amOnSiteGraves) > 0):?>
                <table width="100%" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                        <tr>
							<th width="10%" align="left" valign="top" class="none">
							<?php   echo __('Surname'); ?>								
							</th>
							<th width="10%" align="left" valign="top" class="none">
							<?php   echo __('First Name'); ?>								
							</th>
							<th width="6%" align="left" valign="top" class="none">
								<?php   echo __('Area'); ?>
							</th>
							<th width="6%" align="left" valign="top" class="none">
								<?php   echo __('Section'); ?>							
							</th>
							<th width="6%" align="left" valign="top" class="none">
								<?php   echo __('Row'); ?>
							</th>							
							<th width="6%" align="left" valign="top" class="none">
								<?php   echo __('Plot'); ?>
							</th>
							<th width="10%" align="left" valign="top" class="none">
								<?php echo __('Grave Number'); ?>
							</th>
							<th width="6%" align="left" valign="top" class="none">
								<?php   echo __('Date Paid'); ?>
							</th>
							<th width="6%" align="left" valign="top" class="none">
								<?php   echo __('Amount Paid'); ?>
							</th>
							<th width="6%" align="left" valign="top" class="none">
								<?php   echo __('Renewal Term'); ?>
							</th>
							<th width="6%" align="left" valign="top" class="none">
								<?php   echo __('Renewal Date'); ?>
							</th>
                        </tr>

                        <?php foreach($sf_data->getRaw('amOnSiteGraves') as $snKey=>$asValues): ?>
                            <tr class="<?php echo ($snKey%2 == 0) ? "even" : "odd";?>">                                
								
								<td align="left" valign="top"> <?php echo ($asValues['surname'] != '') ? $asValues['surname'] : '-'; ?> </td>								
                                <td align="left" valign="top"> <?php echo ($asValues['first_name'] != '') ? $asValues['first_name'] : '-'; ?> </td>
								<td align="left" valign="top"> <?php echo ($asValues['area_name'] != '' && $asValues['area_name'] != '0') ? $asValues['area_name'] : __('N/A'); ?> </td>
								<td align="left" valign="top"> <?php echo ($asValues['section_name'] != '' && $asValues['section_name'] != '0') ? $asValues['section_name'] : __('N/A'); ?> </td>
								<td align="left" valign="top"> <?php echo ($asValues['row_name'] != '' && $asValues['row_name'] != '0') ? $asValues['row_name'] : __('N/A'); ?> </td>
								<td align="left" valign="top"> <?php echo ($asValues['plot_name'] != '' && $asValues['plot_name'] != '0') ? $asValues['plot_name'] : __('N/A'); ?> </td>
								<td align="left" valign="top"> <?php echo $asValues['grave_number']; ?> </td>
								
								<?php
									$ssRenewalDate = $ssDatePaid = '';
									if($asValues['renewal_date'] != '' && $asValues['renewal_date'] != '0000-00-00'):
										list($snYear,$snMonth,$snDay) = explode('-', $asValues['renewal_date']);
										$ssRenewalDate = $snDay.'-'.$snMonth.'-'.$snYear;
									endif;
									if($asValues['date_paid'] != '' && $asValues['date_paid'] != '0000-00-00'):
										list($snYear,$snMonth,$snDay) = explode('-', $asValues['date_paid']);
										$ssDatePaid = $snDay.'-'.$snMonth.'-'.$snYear;
									endif;
								?>
								
								<td align="left" valign="top"> <?php echo ($ssDatePaid != '') ? $ssDatePaid : '-'; ?> </td>
								<td align="left" valign="top"> $ <?php echo ($asValues['amount_paid'] != '') ? $asValues['amount_paid'] : 0; ?> </td>
								<td align="left" valign="top"> <?php echo $asValues['renewal_term']; ?> </td>								
								<td align="left" valign="top"> <?php echo $ssRenewalDate;?> </td>                               
                            </tr>
                        <?php endforeach;?>
                    </tbody>
                </table>
        <?php 
            else:
                echo '<div class="warning-msg"><span>'.__('Record(s) not found').'</span></div>';
            endif;
        ?>
    </div>
</div>
