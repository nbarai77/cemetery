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
							<th width="15%" align="left" valign="top" class="none">
							<?php   echo __('Deceased Name'); ?>							
							</th>
							<th width="13%" align="left" valign="top" class="none">
								<?php   echo __('Service Type'); ?>							
							</th>							
							<th width="10%" align="left" valign="top" class="none">
								<?php   echo __('Service Time from'); ?>							
							</th>
							<th width="10%" align="left" valign="top" class="none">
								<?php   echo __('Service Time To'); ?>							
							</th>							
							<th width="13%" align="left" valign="top" class="none">
								<?php   echo __('Taken By'); ?>							
							</th>
							
							<th width="10%" align="left" valign="top" class="none"><?php echo __('Payment Name');?></th>
                            <th width="8%" align="left" valign="top" class="none"><?php echo __('Cost Price');?></th>
                            <th width="8%" align="left" valign="top" class="none"><?php echo __('Special Price');?></th>
                            <th width="8%" align="left" valign="top" class="none"><?php echo __('Payment Status');?></th>
                            <th width="5%" align="left" valign="top" class="none"><?php echo __('Action'); ?></th>                            
                        </tr>

                        <?php foreach($sf_data->getRaw('amIntermentBookingList') as $snKey=>$asValues): ?>
                            <tr class="<?php echo ($snKey%2 == 0) ? "even" : "odd";?>">
								<td align="left" valign="top"> <?php echo $asValues['deceased_surname'].' '.$asValues['deceased_first_name']; ?> </td>
                                <td align="left" valign="top"> <?php echo $asValues['service_type_name']; ?> </td>								
                                <td align="left" valign="top"> <?php echo date('H:i:s',strtotime($asValues['service_booking_time_from'])); ?> </td>
                                <td align="left" valign="top"> <?php echo date('H:i:s',strtotime($asValues['service_booking_time_to'])); ?> </td>
								<td align="left" valign="top"> <?php echo $asValues['taken_by_name']; ?> </td>
								<td align="left" valign="top"> <?php echo $asValues['catalog_name']; ?> </td>
								<td align="left" valign="top"> <?php echo $asValues['cost_price']; ?> </td>
								<td align="left" valign="top"> <?php echo $asValues['special_cost_price']; ?> </td>
								<td align="left" valign="top"> <?php echo $asValues['payment_id'] == 1 ? 'Credit' : ($asValues['payment_id'] == 2 ? 'Waiting' : ($asValues['payment_id'] == 3 ? 'Pending' : ''));  ?> </td>
                                <td align="left" valign="top">
                                <div>										
                                    <div class="fleft" style="margin-left:5px;">											
                                        <?php                                         
                                            $ssActionName = 'generateBookingInvoice?booking_id='.$asValues['id'];
                                            echo link_to(image_tag('admin/pdf.jpg'),url_for($ssModuleName.'/'.$ssActionName),
                                                    array('title' => __('Print Grave Transfer Certificate') ));
                                            ?>
                                    </div>
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
