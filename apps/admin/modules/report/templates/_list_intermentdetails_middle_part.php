<?php use_helper('pagination');
use_javascript('nyroModal/jquery.nyroModal.custom.js');
use_stylesheet('nyroModal/nyroModal');
?>
<div id="main" class="listtable">
    <div class="maintablebg">
        <?php 
            if(count($amIntermentDetailsList) > 0):  
                echo input_hidden_tag('admin_act');
                echo input_hidden_tag('idinterment');				
	        ?>
                <table width="100%" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                        <tr>
							<th width="9%" align="left" valign="top" class="none">
								<?php echo __('Control Number'); ?>							
							</th>
							<th width="8%" align="left" valign="top" class="none">
								<?php echo __('Surname'); ?>
							</th>
							<th width="8%" align="left" valign="top" class="none">
								<?php   echo __('First Name'); ?>
							</th>
							<?php if($sf_user->getAttribute('issuperadmin') == 1): ?>
							<th width="20%" align="left" valign="top" class="none">
								<?php echo __('Cemetery'); ?>
							</th>	
							<?php endif; ?>
							<th width="5%" align="left" valign="top" class="none">
								<?php echo __('Area'); ?>
							</th>
							<th width="5%" align="left" valign="top" class="none">
								<?php echo __('Section'); ?>
							</th>
							<th width="5%" align="left" valign="top" class="none">
								<?php echo __('Row'); ?>
							</th>
							<th width="5%" align="left" valign="top" class="none">
								<?php echo __('Plot'); ?>
							</th>
							<th width="5%" align="left" valign="top" class="none">
								<?php echo __('Grave Number'); ?>
							</th>
							<th width="8%" align="left" valign="top" class="none">
								<?php echo __('Interment Date'); ?>
							</th>
							<th width="8%" align="left" valign="top" class="none">
								<?php echo __('Funeral director'); ?>
							</th>							
                        </tr>

                        <?php foreach($sf_data->getRaw('amIntermentDetailsList') as $snKey=>$asValues): ?>
                            <tr class="<?php echo ($snKey%2 == 0) ? "even" : "odd";?>">								
								<?php
									$ssIntermentDate = '00-00-0000';
									if($asValues['interment_date'] != '' && $asValues['interment_date'] != '0000-00-00'):
										list($snYear,$snMonth,$snDay) = explode('-',$asValues['interment_date']);
										$ssIntermentDate = $snDay.'-'.$snMonth.'-'.$snYear;
									endif;
								?>
								 <td align="left" valign="top">
                                	<?php echo $asValues['control_number']; ?>
                                </td>
								<td align="left" valign="top"> 
									<?php 
										$ssSurname = ($asValues['deceased_surname'] != '') ? $asValues['deceased_surname'] : $asValues['deceased_other_surname'];
										if($ssSurname != ''):
												echo $ssSurname;
										endif;	
									?>
								</td>
                                <td align="left" valign="top">
                                	<?php 
										if($asValues['deceased_first_name'] != ''):
											echo $asValues['deceased_first_name'];
										endif;
									?>
                                </td>
                                <?php if($sf_user->getAttribute('issuperadmin') == 1): ?>
								 <td align="left" valign="top">
                                	<?php echo $asValues['cemetery_name'];?>
                                </td>
                                <?php endif; ?>
								<td align="left" valign="top"> <?php echo ($asValues['area_name'] != '' && $asValues['area_name'] != '0') ? $asValues['area_name'] : __('N/A'); ?> </td>
								<td align="left" valign="top"> <?php echo ($asValues['section_name'] != '' && $asValues['section_name'] != '0') ? $asValues['section_name'] : __('N/A'); ?> </td>
								<td align="left" valign="top"> <?php echo ($asValues['row_name'] != '' && $asValues['row_name'] != '0') ? $asValues['row_name'] : __('N/A'); ?> </td>
								<td align="left" valign="top"> <?php echo ($asValues['plot_name'] != '' && $asValues['plot_name'] != '0') ? $asValues['plot_name'] : __('N/A'); ?> </td>
								<td align="left" valign="top"> <?php echo ($asValues['grave_number'] != '' && $asValues['grave_number'] != '0') ? $asValues['grave_number'] : __('N/A'); ?> </td>
								<td align="left" valign="top"> <?php echo $ssIntermentDate; ?> </td>
								
								<td align="left" valign="top"> <?php echo $asValues['fnd_name']; ?> </td>
                                
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
