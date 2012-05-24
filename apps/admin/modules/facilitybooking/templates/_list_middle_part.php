<?php use_helper('pagination'); ?>
<div id="main" class="listtable bordernone">
    <div class="maintablebg">
        <?php 
            if(count($amFacilityBookingList) > 0):  
                echo input_hidden_tag('admin_act');
                echo input_hidden_tag('idfacilitybooking');
        ?>
                <table width="100%" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                        <tr>
							<th width="3%" align="left" valign="top" class="none">&nbsp;</th>
							<th width="9%" align="left" valign="top" class="none">
							<?php   echo __('Surname'); ?>
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
							<th width="12%" align="left" valign="top" class="none">
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
							
							<th width="13%" align="left" valign="top" class="none">
							<?php   echo __('Email'); ?>
							<div id="field_div_email" class="assanding">
								<a href="javascript:void(0);"> <?php echo image_tag('admin/ass-a.gif');?> </a>
								<div id="sort_div_email" class="inn_drupdownSort" style="display:none">
									<?php   
										include_partial(
											'global/sort_ajaxmain',
											array(
												'ssFieldName'       => 'email',
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
							<th width="10%" align="left" valign="top" class="none"><?php   echo __('Phone Number'); ?></th>
							<th width="8%" align="left" valign="top" class="none">
								<?php echo __('Chapel Booking'); ?>								
							</th>
							
							<th width="10%" align="left" valign="top" class="none">
								<?php echo __('Room Booking'); ?>
							</th>
							<th width="10%" align="left" valign="top" class="none"><?php   echo __('Receipt Number'); ?></th>
							<th width="5%" align="left" valign="top" class="none"><?php   echo __('Total'); ?></th>
							<th width="2%" align="left" valign="top" class="none"><?php echo __('Finalized');?></th>
                        	<th width="2%" align="left" valign="top" class="none">&nbsp;</th>
                        </tr>

                        <?php foreach($sf_data->getRaw('amFacilityBookingList') as $snKey=>$asValues): ?>
                            <tr class="<?php echo ($snKey%2 == 0) ? "even" : "odd";?>">
                                <td align="left" valign="top" class="checkStar">
                                    <?php  echo checkbox_tag('id[]',$asValues['id'], false, array('class'=>'','onclick'=>"uncheck(this,'all','$inactivateIds')"));?>
                                </td>

								<td align="left" valign="top">
                                    <?php
										echo link_to($asValues['surname'], url_for( $ssModuleName.'/addedit?id='.$asValues['id'].'&'.html_entity_decode($amExtraParameters['ssQuerystr'])), 
											 array('title'=> $asValues['surname'],'class' => 'link1'));
									?>
                                </td>
								<td align="left" valign="top">
                                    <?php
										$ssName = ($asValues['title'] != '') ? $asValues['title'].' '.$asValues['first_name'] : $asValues['first_name'];
										echo link_to($ssName, url_for( $ssModuleName.'/addedit?id='.$asValues['id'].'&'.html_entity_decode($amExtraParameters['ssQuerystr'])), 
											 array('title'=> $ssName,'class' => 'link1'));
									?>
                                </td>
                                
                                <td align="left" valign="top"> <?php echo mail_to($asValues['email'], $asValues['email'], array('title' => $asValues['email'],'class' => 'link1')); ?> </td>
                                
                                <td align="left" valign="top"> <?php echo $asValues['telephone']; ?> </td>
                                
                                <td align="left" valign="top"> <?php echo $asValues['chapel']; ?> </td>
                                <td align="left" valign="top"> <?php echo $asValues['room']; ?> </td>
								<td align="left" valign="top"> <?php echo $asValues['receipt_number']; ?> </td>
                                <td align="left" valign="top"> $ <?php echo $asValues['total']; ?></td>  
								<td align="center" valign="top"> 
                                <?php echo image_tag('admin/'.($asValues['is_finalized'] == 1 ? 'Active.gif' : 'InActive.gif'), array('title' => ($asValues['is_finalized'] == 1 ? __('Finalized') : __('Pending')))); ?>
                                </td>
                                <td align="center" valign="top">
                                    <?php 
                                        echo link_to(image_tag('admin/edit.gif'),
                                            $ssModuleName.'/addedit?id='.$asValues['id'].'&'.html_entity_decode($amExtraParameters['ssQuerystr']),
                                            array('title'=>__('Edit Facility Booking') ,'class'=>'link1'));
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
