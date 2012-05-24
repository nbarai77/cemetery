<?php use_helper('pagination');
use_javascript('nyroModal/jquery.nyroModal.custom.js');
use_stylesheet('nyroModal/nyroModal');
?>
<div id="main" class="listtable">
    <div class="maintablebg">
        <?php 
            if(count($amBookingDocsList) > 0):  
                echo input_hidden_tag('admin_act');
                echo input_hidden_tag('idbookingdocs');
	        ?>
                <table width="100%" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                        <tr>
							<th width="2%" align="left" valign="top" class="none">&nbsp;</th>
							<th width="20%" align="left" valign="top" class="none">
								<?php   echo __('Document Name'); ?>							
							</th>						
							<th width="40%" align="left" valign="top" class="none">
								<?php   echo __('Description'); ?>							
							</th>
							<th width="10%" align="left" valign="top" class="none">
								<?php  echo __('Expiry Date'); ?>
							</th>
							<th width="5%" align="left" valign="top" class="none">
								<?php   echo __('Actions'); ?>
							</th>
                        </tr>

                        <?php foreach($sf_data->getRaw('amBookingDocsList') as $snKey=>$asValues): ?>
                            <tr class="<?php echo ($snKey%2 == 0) ? "even" : "odd";?>">
								<td align="left" valign="top" class="checkStar">
                                    <?php  echo checkbox_tag('id[]',$asValues['id'], false, array('class'=>'','onclick'=>"uncheck(this,'all','$inactivateIds')"));?>
                                </td>
								<?php
									$ssExpiryDate = '00-00-0000';
									
									if($asValues['expiry_date'] != ''):
										list($snYear,$snMonth,$snDay) = explode('-',$asValues['expiry_date']);
										$ssExpiryDate = $snDay.'-'.$snMonth.'-'.$snYear;
									endif;									
								?>
                                <td align="left" valign="top"> <?php echo $asValues['file_name']; ?> </td>
                                <td align="left" valign="top"> <?php echo $asValues['file_description']; ?> </td>
								<td align="left" valign="top"> <?php echo $ssExpiryDate; ?> </td>

								<td align="right" valign="top">
									<div id="actions">									
                                    <?php
										/*
										echo '<div class="fleft">';
											echo link_to(image_tag('admin/upload.jpeg'), url_for($ssModuleName.'/document?booking_id='.$snBookingId),
													 array('title'=>__('Upload Document')));	
										echo '</div>';*/									
										echo '<div class="fleft" style="margin-left:5px;">';
											echo link_to(image_tag('admin/download.jpeg'), url_for($ssModuleName.'/listDocuments?booking_id='.$snBookingId.'&type=download&filename='.base64_encode($asValues['file_path'])), array('title'=>__('Download Document')));
										echo '</div>';
										echo '<div class="fleft" style="margin-left:5px;">';
											echo link_to(image_tag('admin/edit.gif'), url_for($ssModuleName.'/document?id='.$asValues['id'].'&booking_id='.$snBookingId.'&'.html_entity_decode($amExtraParameters['ssQuerystr'])),array('title'=>__('Edit Document') ,'class'=>'link1'));
										echo '</div>';
									?>
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
