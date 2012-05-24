<?php use_helper('pagination');
use_javascript('nyroModal/jquery.nyroModal.custom.js');
use_stylesheet('nyroModal/nyroModal');
?>
<div id="main" class="listtable bordernone">
    <div class="maintablebg">
        <?php 
            if(count($amIntermentList) > 0):  
                echo input_hidden_tag('admin_act');
                echo input_hidden_tag('idservicebooking');				
	        ?>
                <table width="100%" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                        <tr>
							<th width="3%" align="left" valign="top" class="none">&nbsp;</th>
							<th width="11%" align="left" valign="top" class="none">
							<?php echo __('Control Number'); ?>
							<div id="field_div_control_number" class="assanding">
								<a href="javascript:void(0);"> <?php echo image_tag('admin/ass-a.gif');?> </a>
								<div id="sort_div_control_number" class="inn_drupdownSort" style="display:none">
									<?php   
										include_partial(
											'global/sort_ajaxmain',
											array(
												'ssFieldName'       => 'control_number',
												'ssLink'            => $ssModuleName.'/interment?request_type=ajax_request',
												'amExtraParameters' => $amExtraParameters,
												'amSearch'          => $amSearch,                                
												'update_div'        => 'contentlisting',
											)
										);
									?>
								</div>
							</div>
							</th>
							<th width="8%" align="left" valign="top" class="none">
							<?php echo __('Surname'); ?>
							<div id="field_div_deceased_surname" class="assanding">
								<a href="javascript:void(0);"> <?php echo image_tag('admin/ass-a.gif');?> </a>
								<div id="sort_div_deceased_surname" class="inn_drupdownSort" style="display:none">
									<?php   
										include_partial(
											'global/sort_ajaxmain',
											array(
												'ssFieldName'       => 'deceased_surname',
												'ssLink'            => $ssModuleName.'/interment?request_type=ajax_request',
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
							<div id="field_div_deceased_first_name" class="assanding">
								<a href="javascript:void(0);"> <?php echo image_tag('admin/ass-a.gif');?> </a>
								<div id="sort_div_deceased_first_name" class="inn_drupdownSort" style="display:none">
									<?php   
										include_partial(
											'global/sort_ajaxmain',
											array(
												'ssFieldName'       => 'deceased_first_name',
												'ssLink'            => $ssModuleName.'/interment?request_type=ajax_request',
												'amExtraParameters' => $amExtraParameters,
												'amSearch'          => $amSearch,
												'update_div'        => 'contentlisting',
											)
										);
									?>
								</div>
							</div>
							</th>
							<?php if($sf_user->getAttribute('issuperadmin') == 1): ?>
							<th width="12%" align="left" valign="top" class="none">
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
							<th width="7%" align="left" valign="top" class="none">
								<?php echo __('Grave Number'); ?>
							</th>											
							<th width="8%" align="left" valign="top" class="none">
								<?php echo __('Interment Date'); ?>
							</th>
							<th width="2%" align="left" valign="top" class="none"><?php echo __('Private');?></th>
							<th width="5%" align="left" valign="top" class="none"><?php echo __('Action');?></th>
                        </tr>

                        <?php foreach($sf_data->getRaw('amIntermentList') as $snKey=>$asValues): ?>
                            <tr class="<?php echo ($snKey%2 == 0) ? "even" : "odd";?>">
								<td align="left" valign="top" class="checkStar">
                                    <?php  echo checkbox_tag('id[]',$asValues['id'], false, array('class'=>'','onclick'=>"uncheck(this,'all','$inactivateIds')"));?>
                                </td>
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
										echo link_to($ssSurname,url_for('servicebooking/addedit?id='.$asValues['id']),
											array('title'=> $ssSurname,'class'=>'link1'));
									?>
								</td>
                                <td align="left" valign="top">
                                	<?php 
										if($asValues['deceased_first_name'] != ''):
											echo link_to($asValues['deceased_first_name'],url_for('servicebooking/addedit?id='.$asValues['id']),
												array('title'=> $asValues['deceased_first_name'],'class'=>'link1'));
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
								<td align="left" valign="top"> 
									<?php 
										if($asValues['grave_number'] != '' && $asValues['grave_number'] != '0'):
											echo link_to($asValues['grave_number'],
												 url_for('servicebooking/displayInfo?id_grave='.$asValues['id_grave'].'&'.html_entity_decode($amExtraParameters['ssQuerystr'])),
												array('title'=> __('Display Grave, Grantee, Burial Information'),'class'=>'link1'));
										else:
											echo __('N/A');
										endif;
										
									?>
								</td>
								<td align="left" valign="top"> <?php echo $ssIntermentDate; ?> </td>
								<td align="center" valign="top"> 
                                <?php echo image_tag('admin/'.($asValues['is_private'] == 1 ? 'Active.gif' : 'InActive.gif'), array('title' => ($asValues['is_private'] == 1 ? __('Private') : __('Public')))); ?>
                                </td>
								<td align="center" valign="top">
									<div class="bookingActions">
										<div class="fleft" style="padding-left:5px;">
											<?php 
												echo link_to(image_tag('admin/edit.gif'),
													url_for($ssModuleName.'/addedit?id='.$asValues['id'].'&'.html_entity_decode($amExtraParameters['ssQuerystr'])),
													array('title'=>__('Edit Interment') ,'class'=>'link1'));
											?>
										</div>
										<!--<div class="fleft" style="padding-left:5px;">
											<?php /*
												echo link_to(image_tag('admin/print.png'), url_for($ssModuleName.'/printLetters?id='.$asValues['id']),
													array('title'=>__('Print Letters') ,'class'=>'link1'));*/
											?>
										</div>-->
										<?php if(!$sf_user->isSuperAdmin()):?>
									    <div class="fleft" style="margin-left:5px;">
											<?php echo link_to(image_tag('admin/pdf.jpg'),url_for($ssModuleName.'/printBurialCertificate?interment_id='.$asValues['id'].'&'.html_entity_decode($amExtraParameters['ssQuerystr'])),array('title' => __('Print Burial Certificate')));?>
									    </div>
									    <?php endif;?>
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
