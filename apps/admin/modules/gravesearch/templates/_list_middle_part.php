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
							<th width="10%" align="left" valign="top" class="none"><?php   echo __('Grave Number'); ?></th>
							<th width="7%" align="left" valign="top" class="none"><?php echo __('Area'); ?></th>	
							<th width="7%" align="left" valign="top" class="none"><?php echo __('Section'); ?></th>
							<th width="7%" align="left" valign="top" class="none"><?php echo __('Row'); ?></th>
							<th width="7%" align="left" valign="top" class="none"><?php echo __('Plot'); ?></th>
							
							<th width="10%" align="left" valign="top" class="none"><?php echo __('Status'); ?></th>
							<th width="10%" align="center" valign="top" class="none"><?php echo __('Grantee Grave Details'); ?></th>
						</tr>

                        <?php foreach($sf_data->getRaw('amArGraveList') as $snKey=>$asValues): ?>
                            <tr class="<?php echo ($snKey%2 == 0) ? "even" : "odd";?>">
								<?php if($sf_user->getAttribute('groupid') == sfConfig::get('app_cemrole_staff') || $sf_user->getAttribute('groupid') == sfConfig::get('app_cemrole_stonemason') || $sf_user->getAttribute('groupid') == sfConfig::get('app_cemrole_funeraldirector')): ?>
									<td align="left" valign="top"> <?php echo $asValues['grave_number']; ?> </td>	
                                <?php else: ?>
									<td align="left" valign="top">
										<?php 
											echo link_to($asValues['grave_number'],
												'grave/addedit?id='.$asValues['id'].'&back=true',
												array('title'=>__('Grave') ,'class'=>'link1'));
										?>
									</td>                                
                                <?php endif; ?>

                                <td align="left" valign="top"> <?php echo ($asValues['area_name'] != '' && $asValues['area_name'] != '0') ? $asValues['area_name'] : __('N/A'); ?> </td>
                                <td align="left" valign="top"> <?php echo ($asValues['section_name'] != '' && $asValues['section_name'] != '0') ? $asValues['section_name'] : __('N/A'); ?> </td>
                                <td align="left" valign="top"> <?php echo ($asValues['row_name'] != '' && $asValues['row_name'] != '0') ? $asValues['row_name'] : __('N/A'); ?> </td>
                                <td align="left" valign="top"> <?php echo ($asValues['plot_name'] != '' && $asValues['plot_name'] != '0') ? $asValues['plot_name'] : __('N/A'); ?> </td>

								<td align="left" valign="top"> <?php echo $asValues['grave_status']; ?> </td>
								<?php 
								$ssGraveStatus = ($asValues['grantee_details_id'] != '') ? __('Purchased') : __('Not Purchased');
								if($sf_user->getAttribute('groupid') != sfConfig::get('app_cemrole_staff') && $sf_user->getAttribute('groupid') != sfConfig::get('app_cemrole_funeraldirector') && $asValues['grantee_details_id'] != ''): ?>
									<td align="center" valign="top">
										<?php 
		                                    echo link_to(image_tag('admin/grantees.jpg'), 
														 url_for('grave/showGrantees?grave_id='.$asValues['id'].'&back2gsearch='.base64_encode(html_entity_decode($amExtraParameters['ssQuerystr'])) ),
														 array('title'=>__('Show Grantees'))
														);
		                                ?>
									</td>
								<?php else: ?>
									<td align="center" valign="top">
										<?php echo $ssGraveStatus; ?>
									</td>
								<?php endif; ?>
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
