<?php use_helper('pagination'); ?>
<div id="main" class="listtable">
    <div class="maintablebg">
        <?php 
            if(count($amAnnualSearchList) > 0):  
                echo input_hidden_tag('admin_act');
                echo input_hidden_tag('idgrave');
        ?>
        
        
                <table width="100%" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                        <tr>
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
							<th width="5%" align="left" valign="top" class="none"><?php   echo __('Area'); ?></th>
							<th width="5%" align="left" valign="top" class="none"><?php   echo __('Section'); ?></th>
							<th width="5%" align="left" valign="top" class="none"><?php   echo __('Row'); ?></th>
							<th width="5%" align="left" valign="top" class="none"><?php   echo __('Plot'); ?></th>
							<th width="8%" align="left" valign="top" class="none"><?php   echo __('Grave Number'); ?></th>
							<th width="7%" align="left" valign="top" class="none"><?php   echo __('Date of Paid'); ?></th>
							<th width="8%" align="left" valign="top" class="none"><?php   echo __('Amount Paid'); ?></th>
							<th width="8%" align="left" valign="top" class="none"><?php   echo __('Renewal Term'); ?></th>
							<th width="8%" align="left" valign="top" class="none"><?php   echo __('Renewal Date'); ?></th>
                        </tr>

                        <?php foreach($sf_data->getRaw('amAnnualSearchList') as $snKey=>$asValues): ?>
                            <tr class="<?php echo ($snKey%2 == 0) ? "even" : "odd";?>">
							
							<td align="left" valign="top"> 
								<?php 
									if($asValues['surname'] != ''):
											echo link_to($asValues['surname'],
												'gravemaintenance/addedit?id='.$asValues['id'].'&back=true',
												array('title'=>__('Annual Care') ,'class'=>'link1'));
									else: 
										echo '-';
									endif;			
								?>
							</td>
							<td align="left" valign="top"> <?php echo ($asValues['first_name'] != '') ? $asValues['first_name'] : '-'; ?> </td>
							
							<?php
								$ssDateOfPaid = $ssRenewalDate = '';
								if($asValues['date_paid'] != '' && $asValues['date_paid'] != '0000-00-00')
								{
									list($snYear,$snMonth,$snDay) = explode('-', $asValues['date_paid']);
									$ssDateOfPaid = $snDay.'-'.$snMonth.'-'.$snYear;
								}
								if($asValues['renewal_date'] != '' && $asValues['renewal_date'] != '0000-00-00')
								{
									list($snYear,$snMonth,$snDay) = explode('-', $asValues['renewal_date']);
									$ssRenewalDate = $snDay.'-'.$snMonth.'-'.$snYear;
								}
							?>
							
							<td align="left" valign="top"> <?php echo ($asValues['area_name'] != '' && $asValues['area_name'] != '0') ? $asValues['area_name'] : __('N/A'); ?> </td>
							<td align="left" valign="top"> <?php echo ($asValues['section_name'] != '' && $asValues['section_name'] != '0') ? $asValues['section_name'] : __('N/A'); ?> </td>
							<td align="left" valign="top"> <?php echo ($asValues['row_name'] != '' && $asValues['row_name'] != '0') ? $asValues['row_name'] : __('N/A'); ?> </td>
							<td align="left" valign="top"> <?php echo ($asValues['plot_name'] != '' && $asValues['plot_name'] != '0') ? $asValues['plot_name'] : __('N/A'); ?> </td>
							<td align="left" valign="top"> <?php echo $asValues['grave_number']; ?> </td>
							<td align="left" valign="top"> <?php echo $ssDateOfPaid; ?> </td>
							<td align="left" valign="top"> <?php echo $asValues['amount_paid']; ?> </td>
							<td align="left" valign="top"> <?php echo $asValues['renewal_term']; ?> </td>
							<td align="left" valign="top"> <?php echo $ssRenewalDate; ?> </td>
                                
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
