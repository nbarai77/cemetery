<?php use_helper('pagination'); 
use_javascript('nyroModal/jquery.nyroModal.custom.js');
use_stylesheet('nyroModal/nyroModal');
?>
<div id="main" class="listtable bordernone">
    <div class="maintablebg">
        <?php 
            if(count($amArGraveList) > 0):  
                echo input_hidden_tag('admin_act');
                echo input_hidden_tag('idgrave');
        ?>
                <table width="100%" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                        <tr>
							<th width="2%" align="left" valign="top" class="none">&nbsp;</th>
							<th width="10%" align="left" valign="top" class="none">
							<?php   echo __('Grave Number'); ?>
							<div id="field_div_plot_grave_number" class="assanding">
								<a href="javascript:void(0);"> <?php echo image_tag('admin/ass-a.gif');?> </a>
								<div id="sort_div_plot_grave_number" class="inn_drupdownSort" style="display:none">
									<?php   
										include_partial(
											'global/sort_ajaxmain',
											array(
												'ssFieldName'       => 'grave_number',
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
							<th width="10%" align="left" valign="top" class="none">
								<?php   echo __('Country'); ?>
							</th>
							<th width="15%" align="left" valign="top" class="none">
								<?php   echo __('Cemetery'); ?>
							</th>
							<?php endif; ?>
							<th width="6%" align="left" valign="top" class="none">
								<?php   echo __('Area'); ?>
							</th>
							<th width="6%" align="left" valign="top" class="none">
								<?php   echo __('Section'); ?>							
							</th>
							<th width="6%" align="left" valign="top" class="none">
								<?php   echo __('Row'); ?>
							</th>							
							<th width="6%" align="left" valign="top" class="none">
								<?php   echo __('Plot'); ?>
							</th>
							<th width="2%" align="left" valign="top" class="none">
								<?php echo __('Active'); ?>								
							</th>
							<th width="7%" align="left" valign="top" class="none">
								<?php echo __('Status'); ?>
							</th>
                        	<th width="10%" align="left" valign="top" class="none"><?php echo __('Actions');?></th>
							
                        </tr>

                        <?php foreach($sf_data->getRaw('amArGraveList') as $snKey=>$asValues): ?>
                            <tr class="<?php echo ($snKey%2 == 0) ? "even" : "odd";?>">
                                <td align="left" valign="top" class="checkStar">
                                    <?php  echo checkbox_tag('id[]',$asValues['id'], false, array('class'=>'','onclick'=>"uncheck(this,'all','$inactivateIds')"));?>
                                </td>
								
								<td align="left" valign="top"> 
									<?php 
										/*echo link_to($asValues['grave_number'],url_for($ssModuleName.'/addedit?id='.$asValues['id'].'&'.html_entity_decode($amExtraParameters['ssQuerystr'])),												
											array('title' => $asValues['grave_number'],'class' => 'link1'));*/
									?>
									<?php 
                                    echo $asValues['grave_number'];
                                    /*echo link_to($asValues['grave_number'],
												 url_for('servicebooking/displayInfo?id_grave='.$asValues['id'].'&'.html_entity_decode($amExtraParameters['ssQuerystr'])),
												array('title'=> __('Display Grave, Grantee, Burial Information'),'class'=>'nyroModal link1'));*/
									?>	
								</td>
								<?php if($sf_user->getAttribute('issuperadmin') == 1): ?>
                                <td align="left" valign="top"> <?php echo $asValues['country_name']; ?> </td>
                                <td align="left" valign="top"> <?php echo $asValues['cemetery_name']; ?> </td>
                                <?php endif; ?>
								<?php
									$ssArea 	= ($asValues['area_name'] != '' && $asValues['area_name'] != '0') ? $asValues['area_name'] : __('N/A');
									$ssSection 	= ($asValues['section_name'] != '' && $asValues['section_name'] != '0') ? $asValues['section_name'] : __('N/A');
									$ssRow		= ($asValues['row_name'] != '' && $asValues['row_name'] != '0') ? $asValues['row_name'] : __('N/A');
									$ssPlot 	= ($asValues['plot_name'] != '' && $asValues['plot_name'] != '0') ? $asValues['plot_name'] : __('N/A');
								?>
								
								<td align="left" valign="top"> <?php echo $ssArea; ?> </td>
								<td align="left" valign="top"> <?php echo $ssSection; ?> </td>
								<td align="left" valign="top"> <?php echo $ssRow; ?> </td>
								<td align="left" valign="top"> <?php echo $ssPlot; ?> </td>
								 <td align="left" valign="top"> 
                                <?php echo image_tag('admin/'.($asValues['is_enabled'] == 1 ? 'Active.gif' : 'InActive.gif'), array('title' => ($asValues['is_enabled'] == 1 ? __('Active') : __('InActive')))); ?>
                                </td>
								<td align="left" valign="top"> <?php echo $asValues['grave_status']; ?> </td>

                                <td align="left" valign="top">
                                    <div class="graveActions">
										<div class="fleft">
												<?php echo link_to(image_tag('admin/history.gif'),url_for('grantee/viewHistory?grave_id='.$asValues['id'].'&back=grave'),
													array('title' => __('View Grave History')));?>
										</div>
										<div class="fleft" style="padding-left:5px;">
		                                <?php 
		                                    echo link_to(image_tag('admin/edit.gif'),
		                                        $ssModuleName.'/addedit?id='.$asValues['id'].'&'.html_entity_decode($amExtraParameters['ssQuerystr']),
		                                        array('title'=>__('Edit Grave') ,'class'=>'link1'));
		                                ?>
		                                </div>										
										<div class="fleft" style="padding-left:5px;">
		                                <?php
											$amGraveDetails = array(
																	'cemetery'	=> $asValues['cemetery_name'],
																	'area'		=> $ssArea,
																	'section'	=> $ssSection,
																	'row'		=> $ssRow,
																	'plot'		=> $ssPlot,
																	'grave'		=> $asValues['grave_number'],
																	'latitude'	=> $asValues['latitude'],
																	'longitude'	=> $asValues['longitude'],
																	'latcem'	=> $asValues['latcem'],
																	'longcem'	=> $asValues['longcem'],																	
																	
																	);
											$ssRequestIds = base64_encode(implode(",", $amGraveDetails ));
											echo link_to_function(image_tag('admin/marker.jpg'),"window.open('".url_for('grave/showGraveOnMap?ssParams='.$ssRequestIds)."','mywindow','width=1100,height=600');", array('title'=>__('See on map')) );
		                                ?>
		                                </div>
										<div class="fleft" style="padding-left:5px;">
										<?php 
		                                    echo link_to(image_tag('admin/grantees.jpg'), $ssModuleName.'/showGrantees?grave_id='.$asValues['id'].'&'.html_entity_decode($amExtraParameters['ssQuerystr']),
		                                        array('title'=>__('Show Grantees')));
		                                ?>
										</div>
										 <?php if(!$sf_user->isSuperAdmin() && count($asValues['Grantee']) > 0): ?>
										<div class="fleft" style="padding-left:5px;">
											<?php 
												$ssActionName = 'generatePDF?grave_id='.$asValues['id'].'&'.html_entity_decode($amExtraParameters['ssQuerystr']);
												echo link_to(image_tag('admin/pdf.jpg'),url_for('grantee/'.$ssActionName),
														array('title' => __('Print Right of Burial Certificate') ));
												?>
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
