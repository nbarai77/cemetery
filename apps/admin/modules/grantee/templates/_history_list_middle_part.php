<?php use_helper('pagination');
use_javascript('nyroModal/jquery.nyroModal.custom.js');
use_stylesheet('nyroModal/nyroModal');
?>
<div id="main" class="listtable">
    <div class="maintablebg">
        <?php 
            if(count($amGranteeGraveHistoryList) > 0):  
                echo input_hidden_tag('admin_act');
				echo input_hidden_tag('grave_id',$snIdGrave);
				echo input_hidden_tag('grantee_id',$snGranteeId);
                echo input_hidden_tag('idsurrendergrave');
        ?>
                <table width="100%" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                        <tr>
							<th width="2%" align="left" valign="top" class="none">&nbsp;</th>
							<th width="15%" align="left" valign="top" class="none">
							<?php   echo __('Surrender From'); ?>
							<div id="field_div_old_grantee_first_name" class="assanding">
								<a href="javascript:void(0);"> <?php echo image_tag('admin/ass-a.gif');?> </a>
								<div id="sort_div_old_grantee_first_name" class="inn_drupdownSort" style="display:none">
									<?php   
										include_partial(
											'global/sort_ajaxmain',
											array(
												'ssFieldName'       => 'surrender_from_name',
												'ssLink'            => $ssModuleName.'/viewHistory?request_type=ajax_request&grantee_id='.$snGranteeId.'&grave_id='.$snIdGrave,
												'amExtraParameters' => $amExtraParameters,
												'amSearch'          => $amSearch,                                
												'update_div'        => 'contentlisting',
											)
										);
									?>
								</div>
							</div>
							</th>						
							<th width="15%" align="left" valign="top" class="none">
							<?php   echo __('Surrender To'); ?>
							<div id="field_div_new_grantee_first_name" class="assanding">
								<a href="javascript:void(0);"> <?php echo image_tag('admin/ass-a.gif');?> </a>
								<div id="sort_div_new_grantee_first_name" class="inn_drupdownSort" style="display:none">
									<?php   
										include_partial(
											'global/sort_ajaxmain',
											array(
												'ssFieldName'       => 'surrender_from_to',
												'ssLink'            => $ssModuleName.'/viewHistory?request_type=ajax_request&grantee_id='.$snGranteeId.'&grave_id='.$snIdGrave,
												'amExtraParameters' => $amExtraParameters,
												'amSearch'          => $amSearch,                                
												'update_div'        => 'contentlisting',
											)
										);
									?>
								</div>
							</div>
							</th>
							<th width="20%" align="left" valign="top" class="none">
								<?php   echo __('Date Of Surrender'); ?>							
							</th>
							<th width="5%" align="left" valign="top" class="none">
								<?php   echo __('Area'); ?>
							</th>
							<th width="5%" align="left" valign="top" class="none">
								<?php   echo __('Section'); ?>
							</th>
							<th width="5%" align="left" valign="top" class="none">
								<?php   echo __('Row'); ?>
							</th>
							<th width="5%" align="left" valign="top" class="none">
								<?php   echo __('Plot'); ?>
							</th>
							<th width="10%" align="left" valign="top" class="none">
								<?php   echo __('Grave Number'); ?>							
							</th>	
                        </tr>

                        <?php foreach($sf_data->getRaw('amGranteeGraveHistoryList') as $snKey=>$asValues): ?>
                            <tr class="<?php echo ($snKey%2 == 0) ? "even" : "odd";?>">
                                <td align="left" valign="top" class="checkStar">
                                    <?php  echo checkbox_tag('id[]',$asValues['id'], false, array('class'=>'','onclick'=>"uncheck(this,'all','$inactivateIds')"));?>
                                </td>

                                <td align="left" valign="top"> <?php echo $asValues['surrender_from_name']; ?> </td>
                                <td align="left" valign="top"> <?php echo $asValues['surrender_from_to']; ?> </td>
								<td align="left" valign="top">
									<div id="div_upd_transfer_date_<?php echo $asValues['id'];?>">
									<?php 
										include_partial('transferDate',array('ssTransferDate'	=> date('d-m-Y',strtotime($asValues['surrender_date'])),
																				 'snHistoryId'  => $asValues['id']
																				)
														);
									?> 
									</div>
								</td>
								<td align="left" valign="top"> <?php echo ($asValues['area_name'] != '' && $asValues['area_name'] != '0') ? $asValues['area_name'] : __('N/A'); ?> </td>
								<td align="left" valign="top"> <?php echo ($asValues['section_name'] != '' && $asValues['section_name'] != '0') ? $asValues['section_name'] : __('N/A'); ?> </td>
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