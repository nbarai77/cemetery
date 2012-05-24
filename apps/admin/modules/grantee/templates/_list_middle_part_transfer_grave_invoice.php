<?php use_helper('pagination');
use_javascript('nyroModal/jquery.nyroModal.custom.js');
use_stylesheet('nyroModal/nyroModal');
?>
<div id="main" class="listtable bordernone">
    <div class="maintablebg">
        <?php 
			echo input_hidden_tag('cemetery_id',$snCementeryId);
            if(count($amTransferGraveList) > 0):  
                echo input_hidden_tag('admin_act');
                echo input_hidden_tag('idgrantee');				
	        ?>
                <table width="100%" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                        <tr>
							<th width="11%" align="left" valign="top" class="none">
							<?php   echo __('Surrender From'); ?>							
							</th>						
							<th width="11%" align="left" valign="top" class="none">
							<?php   echo __('Surrender To'); ?>							
							</th>
							<th width="10%" align="left" valign="top" class="none">
								<?php   echo __('Date Of Surrender'); ?>							
							</th>
							<th width="7%" align="left" valign="top" class="none"><?php   echo __('Area'); ?></th>
							<th width="7%" align="left" valign="top" class="none"><?php   echo __('Section'); ?></th>
							<th width="7%" align="left" valign="top" class="none"><?php   echo __('Row'); ?></th>
							<th width="7%" align="left" valign="top" class="none"><?php   echo __('Plot'); ?></th>							
							<th width="10%" align="left" valign="top" class="none"><?php echo __('Payment Name'); ?></th>
							<th width="10%" align="left" valign="top" class="none"><?php echo __('Cost Price'); ?></th>
							<th width="10%" align="left" valign="top" class="none"><?php echo __('Special Price'); ?></th>
							<th width="10%" align="left" valign="top" class="none"><?php echo __('Payment Status'); ?></th>
                            <th width="10%" align="left" valign="top" class="none"><?php echo __('Action'); ?></th>
                            
                        </tr>

                        <?php foreach($sf_data->getRaw('amTransferGraveList') as $snKey=>$asValues): ?>
                            <tr class="<?php echo ($snKey%2 == 0) ? "even" : "odd";?>">
								<td align="left" valign="top"> <?php echo $asValues['surrender_from_name']; ?> </td>
								<td align="left" valign="top"> <?php echo $asValues['surrender_from_to']; ?> </td>
                                <td align="left" valign="top"> <?php echo  date('d-m-Y',strtotime($asValues['surrender_date'])); ?> </td>
                                
                                <td align="left" valign="top"> <?php echo ($asValues['area_name'] != '') ? $asValues['area_name'] : __('N/A'); ?> </td>
                                
                                <td align="left" valign="top"> <?php echo ($asValues['section_name'] != '') ? $asValues['section_name'] : __('N/A'); ?> </td>
                                <td align="left" valign="top"> <?php echo ($asValues['row_name'] != '') ? $asValues['row_name'] : __('N/A'); ?> </td>
                                <td align="left" valign="top"> <?php echo ($asValues['plot_name'] != '') ? $asValues['plot_name'] : __('N/A'); ?> </td>
								
                                <td align="left" valign="top"> <?php echo $asValues['Catalog']['name']; ?> </td>
								<td align="left" valign="top"> <?php echo $asValues['Catalog']['cost_price']; ?> </td>
								<td align="left" valign="top"> <?php echo $asValues['Catalog']['special_cost_price']; ?> </td>
								<td align="left" valign="top"> <?php echo ($asValues['payment_id'] == 1 ? 'Credit' : ($asValues['payment_id'] == 2 ? 'Waiting' : ($asValues['payment_id'] == 3 ? 'Pending' : '')));  ?> </td>
                                <td align="left" valign="top">
                                <div>										
                                    <div class="fleft" style="margin-left:5px;">											
                                        <?php                                         
                                            $ssActionName = 'generateTransferGraveInvoice?grave_history_id='.$asValues['id'];
                                            echo link_to(image_tag('admin/pdf.jpg'),url_for($ssModuleName.'/'.$ssActionName),
                                                    array('title' => __('Print Grave Transfer Invoice') ));
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
    //echo input_hidden_tag('sortby',$sortby);
    //echo input_hidden_tag('sortmode',$sortmode);
    echo input_hidden_tag('inactivateIds'); 
?>
