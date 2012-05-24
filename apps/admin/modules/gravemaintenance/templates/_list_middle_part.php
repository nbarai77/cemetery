<?php use_helper('pagination'); ?>
<div id="main" class="listtable bordernone">
    <div class="maintablebg">
        <?php 
            if(count($amArGraveMaintenanceList) > 0):  
                echo input_hidden_tag('admin_act');
                echo input_hidden_tag('idgravemaintenance');
        ?>
                <table width="100%" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                        <tr>
							<th width="2%" align="left" valign="top" class="none">&nbsp;</th>
							<th width="10%" align="left" valign="top" class="none">
								<?php   echo __('Surname'); ?>
								<div id="field_div_surname" class="assanding">
                                    <a href="javascript:void(0);"> <?php echo image_tag('admin/ass-a.gif');?> </a>
                                    <div id="sort_div_surname" class="inn_drupdownSort" style="display:none">
                                        <?php   
                                            include_partial(
                                                'global/sort_ajaxmain',
                                                array(
                                                    'ssFieldName'       => 'surname',
                                                    'ssLink'            => $ssModuleName.'/index?request_type=ajax_request',
                                                    'amExtraParameters' => $amExtraParameters,
                                                    'amSearch'          => $amSearch,                                
                                                    'update_div'        => 'contentlisting',
                                                )
                                            );
                                        ?>
                                    </div>
                                </div>
							</th>
							<th width="10%" align="left" valign="top" class="none">
								<?php   echo __('First Name'); ?>
								<div id="field_div_first_name" class="assanding">
                                    <a href="javascript:void(0);"> <?php echo image_tag('admin/ass-a.gif');?> </a>
                                    <div id="sort_div_first_name" class="inn_drupdownSort" style="display:none">
                                        <?php   
                                            include_partial(
                                                'global/sort_ajaxmain',
                                                array(
                                                    'ssFieldName'       => 'first_name',
                                                    'ssLink'            => $ssModuleName.'/index?request_type=ajax_request',
                                                    'amExtraParameters' => $amExtraParameters,
                                                    'amSearch'          => $amSearch,                                
                                                    'update_div'        => 'contentlisting',
                                                )
                                            );
                                        ?>
                                    </div>
                                </div>
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

                        	<th width="2%" align="left" valign="top" class="none">&nbsp;</th>
                        </tr>

                        <?php foreach($sf_data->getRaw('amArGraveMaintenanceList') as $snKey=>$asValues): ?>
                            <tr class="<?php echo ($snKey%2 == 0) ? "even" : "odd";?>">
                                <td align="left" valign="top" class="checkStar">
                                    <?php  echo checkbox_tag('id[]',$asValues['id'], false, array('class'=>'','onclick'=>"uncheck(this,'all','$inactivateIds')"));?>
                                </td>
								
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

                                <td align="center" valign="top">
									<?php 
										echo link_to(image_tag('admin/edit.gif'),
											$ssModuleName.'/addedit?id='.$asValues['id'].'&'.html_entity_decode($amExtraParameters['ssQuerystr']),
											array('title'=>__('Edit Grave Maintenance') ,'class'=>'link1'));
									?>
                                </td>
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
<?php 
    echo input_hidden_tag('sortby',$sortby);
    echo input_hidden_tag('sortmode',$sortmode);
    echo input_hidden_tag('inactivateIds'); 
?>
