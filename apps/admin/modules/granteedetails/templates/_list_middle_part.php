<?php use_helper('pagination'); ?>
<div id="main" class="listtable bordernone">
    <div class="maintablebg">
        <?php 
            if(count($amGranteeDetailsList) > 0):  
                echo input_hidden_tag('admin_act');
                echo input_hidden_tag('idgranteedetails');
        ?>
                <table width="100%" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                        <tr>
							<th width="2%" align="left" valign="top" class="none">&nbsp;</th>
							<th width="10%" align="left" valign="top" class="none">
								<?php echo __('Unique ID'); ?>
							</th>
							<th width="15%" align="left" valign="top" class="none">
							<?php   echo __('Surname'); ?>
							<div id="field_div_grantee_surname" class="assanding">
								<a href="javascript:void(0);"> <?php echo image_tag('admin/ass-a.gif');?> </a>
								<div id="sort_div_grantee_surname" class="inn_drupdownSort" style="display:none">
									<?php   
										include_partial(
											'global/sort_ajaxmain',
											array(
												'ssFieldName'       => 'grantee_surname',
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
							<th width="15%" align="left" valign="top" class="none">
							<?php   echo __('First Name'); ?>
							<div id="field_div_grantee_first_name" class="assanding">
								<a href="javascript:void(0);"> <?php echo image_tag('admin/ass-a.gif');?> </a>
								<div id="sort_div_grantee_first_name" class="inn_drupdownSort" style="display:none">
									<?php   
										include_partial(
											'global/sort_ajaxmain',
											array(
												'ssFieldName'       => 'grantee_first_name',
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
							<?php if($sf_user->getAttribute('issuperadmin') == 1): ?>
							<th width="25%" align="left" valign="top" class="none">
								<?php echo __('Cemetery'); ?>
							</th>
							<?php endif; ?>
							<th width="10%" align="center" valign="top" class="none">
								<?php echo __('Purchase Grave'); ?>
							</th>
							<th width="5%" align="left" valign="top" class="none"><?php echo __('Actions'); ?></th>				
                        </tr>

                        <?php foreach($sf_data->getRaw('amGranteeDetailsList') as $snKey=>$asValues): ?>
                            <tr class="<?php echo ($snKey%2 == 0) ? "even" : "odd";?>">
                                <td align="left" valign="top" class="checkStar">
                                    <?php  echo checkbox_tag('id[]',$asValues['id'], false, array('class'=>'','onclick'=>"uncheck(this,'all','$inactivateIds')"));?>
                                </td>
								<td align="left" valign="top"> <?php echo $asValues['grantee_unique_id']; ?> </td>
								<td align="left" valign="top"> 
									<?php 
										if($asValues['grantee_surname'] != ''):
										echo link_to($asValues['grantee_surname'],url_for($ssModuleName.'/addedit?id='.$asValues['id'].'&'.html_entity_decode($amExtraParameters['ssQuerystr'])), 
											array('title' => $asValues['grantee_surname'],'class' => 'link1'));
										endif;
									?>
								</td>
								<td align="left" valign="top"> 
									<?php 
										$ssName = ($asValues['title'] != '') ? $asValues['title'].' '.$asValues['grantee_first_name'] : $asValues['grantee_first_name'];
										if($ssName != ''):
											echo link_to($ssName,url_for($ssModuleName.'/addedit?id='.$asValues['id'].'&'.html_entity_decode($amExtraParameters['ssQuerystr'])),		
												array('title' => $ssName,'class' => 'link1'));
										endif;
									?>
								</td>
								<?php if($sf_user->getAttribute('issuperadmin') == 1): ?>
								<td align="left" valign="top"> <?php echo $asValues['name']; ?> </td>
								<?php endif; ?>
								<td align="center" valign="top">
                                    <?php 
                                        echo link_to(image_tag('admin/grave.gif'),url_for('grantee/index?grantee_id='.$asValues['id'].'&cemetery_id='.$asValues['cem_id']),
                                            array('title'=>__('Purchase Grave') ,'class'=>'link1'));
                                    ?>
                                </td>								
                                <td align="center" valign="top">
									<div class="fleft">
										<?php 
											echo link_to(image_tag('admin/edit.gif'), url_for($ssModuleName.'/addedit?id='.$asValues['id'].'&'.html_entity_decode($amExtraParameters['ssQuerystr'])),array('title'=>__('Edit Grantee Details') ,'class'=>'link1'));
										?>
									</div>
									<?php if($asValues['grantee_id'] != '' && !$sf_user->isSuperAdmin()):?>
									<!--div class="fleft" style="margin-left:5px;">
											<?php /*echo link_to(image_tag('admin/pdf.jpg'),url_for($ssModuleName.'/showAllGranteeGraves?grantee_id='.$asValues['id'].'&'.html_entity_decode($amExtraParameters['ssQuerystr'])),array('title' => __('Print Grantee Burial Licence Certificate')));*/?>
									</div-->
									<?php endif;?>
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
