<?php use_helper('pagination');
use_javascript('nyroModal/jquery.nyroModal.custom.js');
use_stylesheet('nyroModal/nyroModal');
?>
<div id="main" class="listtable bordernone">
    <div class="maintablebg">
        <?php 
            if(count($amIntermentBookingList) > 0):  
                echo input_hidden_tag('admin_act');
                echo input_hidden_tag('idservicebooking');				
	        ?>
                <table width="100%" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                        <tr>
							<th width="3%" align="left" valign="top" class="none" style="0 5px 0 0;">&nbsp;</th>
							<th width="12%" align="left" valign="top" class="none">
							<?php   echo __('Deceased Surname'); ?>
							<div id="field_div_deceased_surname" class="assanding">
								<a href="javascript:void(0);"> <?php echo image_tag('admin/ass-a.gif');?> </a>
								<div id="sort_div_deceased_surname" class="inn_drupdownSort" style="display:none">
									<?php   
										include_partial(
											'global/sort_ajaxmain',
											array(
												'ssFieldName'       => 'deceased_surname',
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
							<?php   echo __('Deceased Name'); ?>
							<div id="field_div_deceased_first_name" class="assanding">
								<a href="javascript:void(0);"> <?php echo image_tag('admin/ass-a.gif');?> </a>
								<div id="sort_div_deceased_first_name" class="inn_drupdownSort" style="display:none">
									<?php   
										include_partial(
											'global/sort_ajaxmain',
											array(
												'ssFieldName'       => 'deceased_first_name',
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
							<th width="8%" align="left" valign="top" class="none">
								<?php   echo __('Service Type'); ?>							
							</th>	
							<th width="8%" align="left" valign="top" class="none">
								<?php   echo __('Service Date'); ?>
								<div id="field_div_service_booking_date" class="assanding">
									<a href="javascript:void(0);"> <?php echo image_tag('admin/ass-a.gif');?> </a>
									<div id="sort_div_service_booking_date" class="inn_drupdownSort" style="display:none">
										<?php   
											include_partial(
												'global/sort_ajaxmain',
												array(
													'ssFieldName'       => 'service_date',
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
								<?php   echo __('Service Time from'); ?>							
							</th>
							<th width="10%" align="left" valign="top" class="none">
								<?php   echo __('Service Time To'); ?>							
							</th>
							<!--<th width="10%" align="left" valign="top" class="none">
							<?php   //echo __('Funeral director'); ?>							
							</th>-->
							<th width="10%" align="left" valign="top" class="none">
								<?php   echo __('Consultant'); ?>
							</th>
							<th width="10%" align="left" valign="top" class="none">
								<?php   echo __('Taken By'); ?>							
							</th>
							<th width="10%" align="left" valign="top" class="none">
								<?php   echo __('Created At'); ?>							
							</th>							
							
							<th width="10%" align="left" valign="top" class="none"><?php echo __('Actions') ?></th>
                        </tr>

                        <?php foreach($sf_data->getRaw('amIntermentBookingList') as $snKey=>$asValues): ?>
                            <tr class="<?php echo ($snKey%2 == 0) ? "even" : "odd";?>">
								<td align="left" valign="top" class="checkStar">
                                    <?php  echo checkbox_tag('id[]',$asValues['id'], false, array('class'=>'','onclick'=>"uncheck(this,'all','$inactivateIds')"));?>
                                </td>
                                
								<td align="left" valign="top"> <?php echo $asValues['deceased_surname']; ?> </td>
                                <td align="left" valign="top"> <?php echo $asValues['deceased_first_name']; ?> </td>
								<td align="left" valign="top"> <?php echo $asValues['service_type_name']; ?> </td>

								<?php
									$ssServiceDate = '00-00-0000';
									
									if($asValues['service_date'] != '' && $asValues['service_date'] != '0000-00-00'):
										list($snYear,$snMonth,$snDay) = explode('-',$asValues['service_date']);
										$ssServiceDate = $snDay.'-'.$snMonth.'-'.$snYear;
									endif;									
								?>
								
								<td align="left" valign="top"> <?php echo $ssServiceDate; ?> </td>
                                <td align="left" valign="top"> <?php echo date('H:i:s',strtotime($asValues['service_booking_time_from'])); ?> </td>
                                <td align="left" valign="top"> <?php echo date('H:i:s',strtotime($asValues['service_booking_time_to'])); ?> </td>
								<!--<td align="left" valign="top"> <?php //echo $asValues['fnd_name']; ?> </td>-->
								<td align="left" valign="top"> <?php echo $asValues['consultant']; ?> </td>
								<td align="left" valign="top"> <?php echo $asValues['taken_by_name']; ?> </td>
								<td align="left" valign="top"> <?php echo date('d-m-Y',strtotime($asValues['created_at'])); ?> </td>
								
								<td align="center" valign="top">
									<div class="bookingActions">
										<div class="fleft" style="padding-left:5px;">
										<?php
											echo link_to(image_tag('admin/listdocs.jpeg'), url_for($ssModuleName.'/listDocuments?booking_id='.$asValues['id']), 
												 array('title'=>__('List of Documents')));
										?>
										</div>
										<div class="fleft" style="padding-left:5px;">
										<?php 
											echo link_to(image_tag('admin/edit.gif'),
												url_for($ssModuleName.'/addedit?id='.$asValues['id'].'&'.html_entity_decode($amExtraParameters['ssQuerystr'])),
												array('title'=>__('Edit Booking')));
										?>
										</div>
										<div class="fleft" style="padding-left:5px;">
										<?php 
											echo link_to(image_tag('admin/pdf.jpg'),
												url_for($ssModuleName.'/generatePDF?id='.$asValues['id']),
												array('title'=>__('Print as PDF')));
										?>
										</div>
										<!--<div class="fleft" style="padding-left:5px;">
										<?php /*
											echo link_to(image_tag('admin/email_attachment.png'),
												url_for($ssModuleName.'/sendLetters?id='.$asValues['id']),
												array('title'=>__('Send Letter')));*/
										?>
										</div>-->
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
