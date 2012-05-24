<?php use_helper('pagination'); ?>
<div id="main" class="listtable">
    <div class="maintablebg">
        <?php 
            if(count($amSearchIntermentList) > 0):  
                echo input_hidden_tag('admin_act');
                echo input_hidden_tag('idarea');
        ?>
                <table width="100%" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                        <tr>
							<th width="20%" align="left" valign="top" class="none">
								<?php  echo __('Name'); ?>				
							</th>
							<th width="10%" align="left" valign="top" class="none">
								<?php echo __('Date Of Birth'); ?>
							</th>
							<th width="10%" align="left" valign="top" class="none">
								<?php echo __('Date Of Interment'); ?>
							</th>
							<th width="5%" align="left" valign="top" class="none">
								<?php echo __('Action'); ?>
							</th>
                        </tr>

                        <?php foreach($sf_data->getRaw('amSearchIntermentList') as $snKey=>$asValues): ?>
                            <tr class="<?php echo ($snKey%2 == 0) ? "even" : "odd";?>">

								<td align="left" valign="top"> <?php echo $asValues['name']; ?> </td>
								<td align="left" valign="top"> <?php echo $asValues['deceased_date_of_birth']; ?> </td>
								<td align="left" valign="top"> <?php echo $asValues['interment_date']; ?> </td>

                                <td align="center" valign="top">
                                    <?php echo link_to_function(__('Details'),"showHideDiv('".$asValues['id']."','show')", array('title' => __('Details') ));?>
                                </td>
                            </tr>
							<tr id="moreDetails_<?php echo $asValues['id'];?>" style="display:none;">
								<td colspan="4">									
									<table width="100%" cellpadding="2" cellspacing="2">
										<tr>
											<td colspan="2">
												<?php  echo __('Interment Detail Information'); ?>
											</td>
											<td align="right">
                                    			<?php echo link_to_function(__('Close'),"showHideDiv('".$asValues['id']."','hide')", array('title' => __('Close') ));?>
											</td>
										</tr>
										<tr>
											<td>
												<?php echo __('Cemetery'); ?>
											</td>
											<td>
												<?php echo $asValues['cem_name']; ?>
											</td>
										</tr>
										<tr>
											<td>
												<?php echo __('Area'); ?>
											</td>
											<td>
												<?php echo $asValues['area_code']; ?>
											</td>											
										</tr>
										<tr>
											<td>
												<?php echo __('Section'); ?>
											</td>
											<td>
												<?php echo $asValues['section_code']; ?>
											</td>
										</tr>
										<tr>
											<td>
												<?php echo __('Row'); ?>
											</td>
											<td>
												<?php echo $asValues['row_name']; ?>
											</td>
										</tr>
										<tr>
											<td>
												<?php echo __('Plot'); ?>
											</td>
											<td>
												<?php echo $asValues['plot_name']; ?>
											</td>
										</tr>
										<tr>
											<td>
												<?php echo __('Grave No.'); ?>
											</td>
											<td>
												<?php echo $asValues['grave_number']; ?>
											</td>
										</tr>
										<tr>
											<td>
												<?php echo __('Cemetery Address'); ?>
											</td>
											<td>
												<?php echo $asValues['cem_address']; ?>
											</td>
										</tr>
										<tr>
											<td>
												<?php echo __('Cemetery Phone'); ?>
											</td>
											<td>
												<?php echo $asValues['cem_phone']; ?>
											</td>
										</tr>
										<tr>
											<td>
												<?php echo __('Cemetery Fax'); ?>
											</td>
											<td>
												<?php echo $asValues['cem_fax']; ?>
											</td>
										</tr>
										<tr>
											<td>
												<?php echo __('Cemetery Email'); ?>
											</td>
											<td>
												<?php echo $asValues['cem_email']; ?>
											</td>
										</tr>
										<tr>
											<td>
												<?php echo __('Cemetery URL'); ?>
											</td>
											<td>
												<?php echo $asValues['cem_url']; ?>
											</td>
										</tr>
										<tr>
											<td>
												<?php echo __('Grave Image'); ?>
											</td>
											<td>
												<?php 
													$ssImage = ($asValues['grave_image1'] != '') ? $asValues['grave_image1'] : ( ($asValues['grave_image2'] != '') ? $asValues['grave_image2'] : 'no_image.jpg');
													$ssImagePath = sfConfig::get('upload_dir').'/grave/thumbnail/'.$ssImage;
													echo image_tag($ssImagePath); ?>
											</td>
										</tr>
									</table>
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
