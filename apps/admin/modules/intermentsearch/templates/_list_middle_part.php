<?php use_helper('pagination'); ?>
<?php

/*echo '<pre>';
print_r($sf_data->getRaw('amArGraveList'));
exit;*/
?>
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
							<th width="10%" align="left" valign="top" class="none">
								<?php echo __('Control Number'); ?>
							</th>						
							<th width="12%" align="left" valign="top" class="none">
							<?php   echo __('Surname'); ?>

							</th>	
							<th width="12%" align="left" valign="top" class="none">
							<?php   echo __('First Name'); ?>

							</th>					
							<th width="8%" align="left" valign="top" class="none"><?php   echo __('Status'); ?></th>		
							<th width="10%" align="left" valign="top" class="none"><?php   echo __('Date Of Interment'); ?></th>
							<th width="8%" align="left" valign="top" class="none"><?php   echo __('Date Of Birth'); ?></th>
							<th width="8%" align="left" valign="top" class="none"><?php   echo __('Date Of Death'); ?></th>

							<th width="5%" align="left" valign="top" class="none"><?php   echo __('Area'); ?></th>
							<th width="5%" align="left" valign="top" class="none"><?php   echo __('Section'); ?></th>
							<th width="5%" align="left" valign="top" class="none"><?php   echo __('Row'); ?></th>
							<th width="5%" align="left" valign="top" class="none"><?php   echo __('Plot'); ?></th>
							<th width="8%" align="left" valign="top" class="none"><?php   echo __('Grave Number'); ?></th>
							
                        </tr>

                        <?php foreach($sf_data->getRaw('amArGraveList') as $snKey=>$asValues): ?>
                            <tr class="<?php echo ($snKey%2 == 0) ? "even" : "odd";?>">

								<td align="left" valign="top"> <?php echo $asValues['control_number']; ?> </td>
								<td align="left" valign="top"> 
									<?php 
										$ssSurname = ($asValues['deceased_surname'] != '') ? $asValues['deceased_surname'] : $asValues['deceased_other_surname'];
										if($sf_user->getAttribute('groupid') == sfConfig::get('app_cemrole_staff') || $sf_user->getAttribute('groupid') == sfConfig::get('app_cemrole_stonemason') || $sf_user->getAttribute('groupid') == sfConfig::get('app_cemrole_funeraldirector')):
											echo $ssSurname;
										else:
											echo link_to($ssSurname,url_for('servicebooking/addedit?id='.$asValues['id'].'&back=true'),array('title'=> $ssSurname,'class'=>'link1'));
										endif;	
									?>
								</td>
                                <td align="left" valign="top">
                                	<?php 
										$ssFirstName = ($asValues['deceased_first_name'] != '') ? $asValues['deceased_first_name'] : ' ';
										if($sf_user->getAttribute('groupid') == sfConfig::get('app_cemrole_staff') || $sf_user->getAttribute('groupid') == sfConfig::get('app_cemrole_stonemason') || $sf_user->getAttribute('groupid') == sfConfig::get('app_cemrole_funeraldirector')):
											echo $ssFirstName;
										else:	
											echo link_to($ssFirstName,url_for('servicebooking/addedit?id='.$asValues['id'].'&back=true'), array('title'=> $asValues['deceased_first_name'],'class'=>'link1'));
										endif;	
									?>
                                </td>
                                <td align="left" valign="top"> <?php echo $asValues['service_type']; ?> </td>
								<?php
									list($snYear,$snMonth,$snDay) = explode('-',$asValues['interment_date']);
									$ssIntermentDate = $snDay.'-'.$snMonth.'-'.$snYear;
								?>                              
                                <td align="left" valign="top"><?php echo $ssIntermentDate; ?> </td>
                                
								<?php
									if($asValues['date_of_birth'] != '') {
										list($snYear,$snMonth,$snDay) = explode('-',$asValues['date_of_birth']);
										$date_of_birth = $snDay.'-'.$snMonth.'-'.$snYear;
									}
									?>
									
                                <td align="left" valign="top"><?php echo ($asValues['date_of_birth'] != '' && $asValues['date_of_birth'] != '0000-00-00') ? $date_of_birth : ''; ?> </td>
                                
								<?php
									if($asValues['date_of_death'] != '') {
										list($snYear,$snMonth,$snDay) = explode('-',$asValues['date_of_death']);
										$date_of_death = $snDay.'-'.$snMonth.'-'.$snYear;
									}	
								?>                                   
                                <td align="left" valign="top"><?php echo ($asValues['date_of_death'] != '' && $asValues['date_of_death'] != '0000-00-00') ? $date_of_death : ''; ?> </td>
                                <td align="left" valign="top"><?php echo ($asValues['area_name'] != '' && $asValues['area_name'] != '0') ? $asValues['area_name'] : __('N/A'); ?> </td>
                                <td align="left" valign="top"><?php echo ($asValues['section_name'] != '' && $asValues['section_name'] != '0') ? $asValues['section_name'] : __('N/A'); ?> </td>
                                <td align="left" valign="top"> <?php echo ($asValues['row_name'] != '' && $asValues['row_name'] != '0') ? $asValues['row_name'] : __('N/A'); ?> </td>
                                <td align="left" valign="top"> <?php echo ($asValues['plot_name'] != '' && $asValues['plot_name'] != '0') ? $asValues['plot_name'] : __('N/A'); ?> </td>
								
                                <td align="left" valign="top"> 
									<?php 
										if($asValues['grave_number'] != '' && $asValues['grave_number'] != '0'):
											echo link_to($asValues['grave_number'],
												 url_for('servicebooking/displayInfo?id_grave='.$asValues['id_grave'].'&isearch=true'.'&'.html_entity_decode($amExtraParameters['ssQuerystr'])),
												array('title'=> __('Display Grave, Grantee, Burial Information'),'class'=>'link1'));
										else:
											echo __('N/A');
										endif;
										
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
