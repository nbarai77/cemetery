<?php use_helper('pagination');
use_javascript('nyroModal/jquery.nyroModal.custom.js');
use_stylesheet('nyroModal/nyroModal');
?>
<div id="main" class="listtable bordernone">
    <div class="maintablebg">
        <?php 
			echo input_hidden_tag('grantee_id',$snGranteeId);
			echo input_hidden_tag('cemetery_id',$snCementeryId);
            if(count($amGranteeList) > 0):  
                echo input_hidden_tag('admin_act');
                echo input_hidden_tag('idgrantee');				
	        ?>
                <table width="100%" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                        <tr>
							<th width="2%" align="left" valign="top" class="none">&nbsp;</th>
							<th width="15%" align="left" valign="top" class="none"><?php echo __('Grantee Identity'); ?></th>
							<th width="15%" align="left" valign="top" class="none"><?php echo __('Grantee Identity Number'); ?></th>
							<?php /*?><th width="10%" align="left" valign="top" class="none">
							<?php   echo __('Tenure From'); ?>
							<div id="field_div_date_of_purchase" class="assanding">
								<a href="javascript:void(0);"> <?php echo image_tag('admin/ass-a.gif');?> </a>
								<div id="sort_div_date_of_purchase" class="inn_drupdownSort" style="display:none">
									<?php   
										include_partial(
											'global/sort_ajaxmain',
											array(
												'ssFieldName'       => 'date_of_purchase',
												'ssLink'            => $ssModuleName.'/index?request_type=ajax_request&grantee_id='.$snGranteeId,
												'amExtraParameters' => $amExtraParameters,
												'amSearch'          => $amSearch,                                
												'update_div'        => 'contentlisting',
											)
										);
									?>
								</div>
							</div>
							</th><?php */ /*?>
							<th width="10%" align="left" valign="top" class="none">
							<?php   echo __('Tenure To'); ?>
							<div id="field_div_tenure_expiry_date" class="assanding">
								<a href="javascript:void(0);"> <?php echo image_tag('admin/ass-a.gif');?> </a>
								<div id="sort_div_tenure_expiry_date" class="inn_drupdownSort" style="display:none">
									<?php   
										include_partial(
											'global/sort_ajaxmain',
											array(
												'ssFieldName'       => 'tenure_expiry_date',
												'ssLink'            => $ssModuleName.'/index?request_type=ajax_request&grantee_id='.$snGranteeId,
												'amExtraParameters' => $amExtraParameters,
												'amSearch'          => $amSearch,                                
												'update_div'        => 'contentlisting',
											)
										);
									?>
								</div>
							</div>
							</th><?php */?>
							<th width="7%" align="left" valign="top" class="none"><?php   echo __('Area'); ?></th>
							<th width="7%" align="left" valign="top" class="none"><?php   echo __('Section'); ?></th>
							<th width="7%" align="left" valign="top" class="none"><?php   echo __('Row'); ?></th>
							<th width="7%" align="left" valign="top" class="none"><?php   echo __('Plot'); ?></th>								
							<th width="10%" align="left" valign="top" class="none">
								<?php  echo __('Grave Number'); ?>
							</th>
							<th width="15%" align="left" valign="top" class="none"><?php echo __('Actions');?></th>				
                        </tr>

                        <?php foreach($sf_data->getRaw('amGranteeList') as $snKey=>$asValues): ?>
                            <tr class="<?php echo ($snKey%2 == 0) ? "even" : "odd";?>">
                                <td align="left" valign="top" class="checkStar">
                                    <?php  echo checkbox_tag('id[]',$asValues['id'], false, array('class'=>'','onclick'=>"uncheck(this,'all','$inactivateIds')"));?>
                                </td>
								<td align="left" valign="top"> <?php echo $asValues['grantee_identity_name']; ?> </td>
								<td align="left" valign="top"> <?php echo $asValues['grantee_identity_number']; ?> </td>
								
								<?php /*?><td align="left" valign="top"> 
									<?php
										$ssDateofPurchase = '-';
										if($asValues['date_of_purchase'] != '' && $asValues['date_of_purchase'] != '0000-00-00'):
											list($snYear,$snMonth,$snDay) = explode('-', $asValues['date_of_purchase']);
											$ssDateofPurchase = $snDay.'-'.$snMonth.'-'.$snYear;
										endif;
										echo $ssDateofPurchase;
									?>
								</td><?php */ /*?>
								<td align="left" valign="top"> 
									<?php
										$ssTenureExpiry = '-';
										if($asValues['tenure_expiry_date'] != '' && $asValues['tenure_expiry_date'] != '0000-00-00'):
											list($snYear,$snMonth,$snDay) = explode('-', $asValues['tenure_expiry_date']);
											$ssTenureExpiry = $snDay.'-'.$snMonth.'-'.$snYear;
										endif;
										echo $ssTenureExpiry;
									?>
								</td><?php */ ?>
                                <td align="left" valign="top"> <?php echo ($asValues['area_name'] != '') ? $asValues['area_name'] : __('N/A'); ?> </td>
                                
                                <td align="left" valign="top"> <?php echo ($asValues['section_name'] != '') ? $asValues['section_name'] : __('N/A'); ?> </td>
                                <td align="left" valign="top"> <?php echo ($asValues['row_name'] != '') ? $asValues['row_name'] : __('N/A'); ?> </td>
                                <td align="left" valign="top"> <?php echo ($asValues['plot_name'] != '') ? $asValues['plot_name'] : __('N/A'); ?> </td>
								<td align="left" valign="top"> 
								    <?php 
								        //echo $asValues['grave_number']; 
								        echo link_to($asValues['grave_number'],
												 url_for('servicebooking/displayInfo?id_grave='.$asValues['ar_grave_id'].'&'.html_entity_decode($amExtraParameters['ssQuerystr'])),
												array('title'=> __('Display Grave, Grantee, Burial Information'),'class'=>'nyroModal link1'));
                                    ?> 
                                </td>

                                <td align="center" valign="top">
									<div>										
										<div class="fleft" style="margin-left:5px;">
											<?php echo link_to(image_tag('admin/history.gif'),url_for('grantee/viewHistory?grave_id='.$asValues['ar_grave_id'].'&grantee_id='.$snGranteeId.'&'.html_entity_decode($amExtraParameters['ssQuerystr'])),
												array('title' => __('View Grave History')));?>
										</div>
										<div class="fleft" style="margin-left:5px;">
											<?php 
												$ssSurrenderGraveURL = url_for('grantee/surrenderGrave?cemetery_id='.$asValues['GranteeDetails']['cem_id'].'&grantee_id='.$snGranteeId.'&id='.$asValues['id']);
												echo link_to(image_tag('admin/EditImage.png'),$ssSurrenderGraveURL,array('title' => __('Surrender Grave')));?>
										</div>										
										<div class="fleft" style="margin-left:5px;">
											<?php
												$ssEditURL = url_for($ssModuleName.'/addedit?grantee_id='.$snGranteeId.'&cemetery_id='.$snCementeryId.'&id='.$asValues['id'].'&'.html_entity_decode($amExtraParameters['ssQuerystr']));
												echo link_to(image_tag('admin/edit.gif'), $ssEditURL, array('title'=>__('Edit Purchased Grave') ,'class'=>'link1'));?>	
										</div>
										<?php if(!$sf_user->isSuperAdmin() && $asValues['is_transferd_grave'] > 0 ): ?>
										<div class="fleft" style="margin-left:5px;">
											<?php 												
                                                $ssActionName = 'transferGraveCertificate?grave_id='.$asValues['ar_grave_id'].'&'.html_entity_decode($amExtraParameters['ssQuerystr']);
												echo link_to(image_tag('admin/pdf.jpg'),url_for($ssModuleName.'/'.$ssActionName),
														array('title' => __('Print Grave Transfer Certificate') ));
												?>
										</div>
										<?php endif; ?>
									</div>									
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
