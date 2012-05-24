<?php use_helper('pagination'); ?>
<div id="main" class="listtable">
    <div class="maintablebg">
        <?php 
            if(count($amArGraveList) > 0):  
                echo input_hidden_tag('admin_act');
                echo input_hidden_tag('idgrave');
        ?>
        
        
                <table width="100%" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                        <tr>							
							<th width="12%" align="left" valign="top" class="none">
							<?php   echo __('Surname'); ?>
							</th>													
							<th width="12%" align="left" valign="top" class="none">
							<?php   echo __('First Name'); ?>
							</th>
							<th width="12%" align="left" valign="top" class="none"><?php echo __('Grantee Identity'); ?></th>
							<th width="15%" align="left" valign="top" class="none"><?php echo __('Grantee Identity Number'); ?></th>
							<th width="10%" align="left" valign="top" class="none"><?php   echo __('Date of Purchase'); ?></th>
							<th width="8%" align="left" valign="top" class="none"><?php   echo __('Area'); ?></th>
							<th width="8%" align="left" valign="top" class="none"><?php   echo __('Section'); ?></th>
							<th width="8%" align="left" valign="top" class="none"><?php   echo __('Row'); ?></th>
							<th width="8%" align="left" valign="top" class="none"><?php   echo __('Plot'); ?></th>
							<th width="10%" align="left" valign="top" class="none"><?php   echo __('Grave Number'); ?></th>
							
                        </tr>

                        <?php foreach($sf_data->getRaw('amArGraveList') as $snKey=>$asValues): ?>
                            <tr class="<?php echo ($snKey%2 == 0) ? "even" : "odd";?>">
								<?php if($sf_user->getAttribute('groupid') == sfConfig::get('app_cemrole_staff') || $sf_user->getAttribute('groupid') == sfConfig::get('app_cemrole_stonemason') || $sf_user->getAttribute('groupid') == sfConfig::get('app_cemrole_funeraldirector')): ?>									
									<td align="left" valign="top"> <?php echo $asValues['grantee_surname']; ?> </td>
									<td align="left" valign="top"> <?php echo $asValues['title'].' '.$asValues['grantee_first_name']; ?> </td>
									<td align="left" valign="top"> <?php echo $asValues['grantee_identity_name']; ?> </td>
									<td align="left" valign="top"> <?php echo $asValues['grantee_identity_number']; ?> </td>
								<?php else: ?>									
									<td align="left" valign="top"> 										
										<?php 
											echo link_to($asValues['grantee_surname'],
												'granteedetails/addedit?id='.$asValues['grantee_id'].'&back=true',
												array('title'=> $asValues['grantee_surname'] ,'class'=>'link1'));
										?>
									</td>
									<td align="left" valign="top">
										<?php 
											$ssGranteeName = trim($asValues['title'].' '.$asValues['grantee_first_name']);
											echo link_to($ssGranteeName,
												'granteedetails/addedit?id='.$asValues['grantee_id'].'&back=true',
												array('title'=> $ssGranteeName ,'class'=>'link1'));
										?>
									</td>
									<td align="left" valign="top"> <?php echo $asValues['grantee_identity_name']; ?> </td>
									<td align="left" valign="top"> <?php echo $asValues['grantee_identity_number']; ?> </td>									
                                <?php endif; 
								
								$ssDateOfPurchase = '00-00-0000';
								if($asValues['date_of_purchase'] != ''):
									list($snYear,$snMonth,$snDay) = explode('-',$asValues['date_of_purchase']);
									$ssDateOfPurchase = $snDay.'-'.$snMonth.'-'.$snYear;
								endif;?>									

                                <td align="left" valign="top"> <?php echo $ssDateOfPurchase; ?> </td>
                                <td align="left" valign="top"> <?php echo ($asValues['area_name'] != '' && $asValues['area_name'] != '0') ? $asValues['area_name'] : __('N/A'); ?> </td>
                                <td align="left" valign="top"> 
									<?php echo ($asValues['section_name'] != '' && $asValues['section_name'] != '0') ? $asValues['section_name'] : __('N/A'); ?> 
								</td>
                                <td align="left" valign="top"> <?php echo ($asValues['row_name'] != '' && $asValues['row_name'] != '0') ? $asValues['row_name'] : __('N/A'); ?> </td>
                                <td align="left" valign="top"> <?php echo ($asValues['plot_name'] != '' && $asValues['plot_name'] != '0') ? $asValues['plot_name'] : __('N/A'); ?> </td>
                                <td align="left" valign="top"> <?php echo $asValues['grave_number']; ?> </td>
                                
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
