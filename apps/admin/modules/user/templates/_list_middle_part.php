<div id="main" class="listtable bordernone">
    <div class="maintablebg">
        <?php 
            if(count($amGuardUserList) > 0):  
                echo input_hidden_tag('admin_act');
                echo input_hidden_tag('iduser');
        ?>
                <table width="100%" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                        <tr>
                            <th width="2%" align="left" valign="top" class="none">&nbsp;</th>
                            <th width="10%" align="left" valign="top" class="none">
                                <?php echo __('Surname'); ?>     
                                <div id="field_div_last_name" class="assanding">
                                    <a href="javascript:void(0);"> <?php echo image_tag('admin/ass-a.gif');?> </a>
                                    <div id="sort_div_last_name" class="inn_drupdownSort" style="display:none">
                                        <?php 
                                            include_partial(
                                                'global/sort_ajaxmain',
                                                array(
                                                    'ssFieldName'       => 'last_name',
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
                                <?php   echo __('First name'); ?>
                                <div id="field_div_first_name" class="assanding">
                                    <a href="javascript:void(0);"> <?php echo image_tag('admin/ass-a.gif');?> </a>
                                    <div id="sort_div_first_name" class="inn_drupdownSort" style="display:none">
                                        <?php   
                                            include_partial(
                                                'global/sort_ajaxmain',
                                                array(
                                                    'ssFieldName'       =>'first_name',
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
                            <th width="10%" align="left" valign="top" class="none"><?php echo __('Email'); ?></th>
                            <?php if($sf_user->getAttribute('issuperadmin') == 1): ?>
								<th width="15%" align="left" valign="top" class="none"><?php   echo __('Cemetery'); ?></th>
							<?php endif; ?>	
                            <th width="10%" align="left" valign="top" class="none">
								<?php echo __('Organization'); ?>
                                <div id="field_div_organisation" class="assanding">
                                    <a href="javascript:void(0);"> <?php echo image_tag('admin/ass-a.gif');?> </a>
                                    <div id="sort_div_organisation" class="inn_drupdownSort" style="display:none">
                                        <?php 
                                            include_partial(
                                                'global/sort_ajaxmain',
                                                array(
                                                    'ssFieldName'       => 'organisation',
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
                            <th width="5%" align="left" valign="top" class="none"><?php echo __('Code'); ?></th>
							<th width="10%" align="left" valign="top" class="none"><?php   echo __('User Role'); ?>
                                <div id="field_div_group_id" class="assanding">
                                    <a href="javascript:void(0);"> <?php echo image_tag('admin/ass-a.gif');?> </a>
                                    <div id="sort_div_group_id" class="inn_drupdownSort" style="display:none">
                                        <?php 
                                            include_partial(
                                                'global/sort_ajaxmain',
                                                array(
                                                    'ssFieldName'       => 'group_id',
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
                            <th width="2%" align="left" valign="top" class="none">&nbsp;</th>
                        </tr>

                        <?php foreach($sf_data->getRaw('amGuardUserList') as $snKey=>$asValues): ?>
                            <tr class="<?php echo ($snKey%2 == 0) ? "even" : "odd";?>">
                                <td align="left" valign="top" class="checkStar">
                                    <?php  echo checkbox_tag('id_user[]',$asValues['id'], false, array('class'=>'','onclick'=>"uncheck(this,'all','$inactivateIds')"));?>
                                </td>
                                <td align="left" valign="top"> 
									<?php
										echo link_to($asValues['last_name'],url_for($ssModuleName.'/addedit?id='.$asValues['id'].'&'.html_entity_decode($amExtraParameters['ssQuerystr'])),
											array('title' => $asValues['last_name'],'class' => 'link1'));
									?>
								</td>

                                <td align="left" valign="top"> 
									<?php
										$ssFirstName = ($asValues['title'] != '') ? $asValues['title'].' '.$asValues['first_name'] : $asValues['first_name'];
										echo link_to($ssFirstName,url_for($ssModuleName.'/addedit?id='.$asValues['id'].'&'.html_entity_decode($amExtraParameters['ssQuerystr'])),
											array('title' => $ssFirstName,'class' => 'link1'));
									?>
								</td>								
                                <td align="left" valign="top"> 
									<?php echo mail_to($asValues['email_address'], $asValues['email_address'], array('class' => 'link1', 'title' => $asValues['email_address'])); ?> 
								</td>
								<?php if($sf_user->getAttribute('issuperadmin') == 1): ?>
									<td align="left" valign="top"> <?php echo $asValues['cemetery_name'];?> </td>
								<?php endif; ?>		
                                <td align="left" valign="top"> <?php echo $asValues['organisation']; ?> </td>
                                <td align="left" valign="top"> <?php echo $asValues['code']; ?> </td>
                                <td align="left" valign="top"> <?php echo $asValues['group_name']; ?> </td>
                               
								
                                <td align="center" valign="top">
                                    <?php 
                                        echo link_to(image_tag('admin/edit.gif'),
                                            $ssModuleName.'/addedit?id='.$asValues['id'].'&'.html_entity_decode($amExtraParameters['ssQuerystr']),
                                            array('title'=>__('Edit user') ,'class'=>'link1'));
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
