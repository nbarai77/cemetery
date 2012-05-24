<?php use_helper('pagination');
if(count($amBookingLogList) > 0):?>
<div class="actions zindex_up">
	<ul class="fright">
		<li class="list1">
			<span><?php echo link_to_function(__('Export in PDF'),'savePDF();',array('title' => __('Export in PDF')) );?> </span>
		 </li>
	</ul>
</div>
<?php endif;?>
<div id="main" class="listtable">
    <div class="maintablebg">
        <?php 
			
            if(count($amBookingLogList) > 0):  
                echo input_hidden_tag('admin_act');
                echo input_hidden_tag('idbookinglog');?>
                <table width="100%" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                        <tr>
							<th width="10%" align="left" valign="top" class="none"><b><?php echo __('Time'); ?></b></th>
							<th width="10%" align="left" valign="top" class="none"><b><?php echo __('Operation'); ?></b></th>
							<th width="15%" align="left" valign="top" class="none"><b><?php echo __('Name'); ?></b></th>
							<th width="7%" align="left" valign="top" class="none"><b><?php  echo __('Area'); ?></b></th>
							<th width="10%" align="left" valign="top" class="none"><b><?php echo __('Section'); ?></b></th>
							<th width="7%" align="left" valign="top" class="none"><b><?php  echo __('Row'); ?></b></th>
							<th width="7%" align="left" valign="top" class="none"><b><?php  echo __('Block'); ?></b></th>
							<th width="10%" align="left" valign="top" class="none"><b><?php echo __('Grave'); ?></b></th>
							<th width="15%" align="left" valign="top" class="none"><b><?php echo __('Grantee'); ?></b></th>
							<th width="7%" align="left" valign="top" class="none"><b><?php echo __('Service'); ?></b></th>
							<th width="7%" align="left" valign="top" class="none"><b><?php echo __('Status'); ?></b></th>
                        </tr>

                        <?php foreach($sf_data->getRaw('amBookingLogList') as $snKey=>$asValues): ?>
                            <tr class="<?php echo ($snKey%2 == 0) ? "even" : "odd";?>">
								<td align="left" valign="top"> <?php echo date('d-m-Y h:i:s', strtotime($asValues['operation_date'])); ?> </td>
								<td align="left" valign="top"> <?php echo $asValues['operation']; ?> </td>
								<td align="left" valign="top"> <?php echo $asValues['deceased_surname'].' '.$asValues['deceased_name']; ?> </td>
								<td align="left" valign="top"> <?php echo ($asValues['area'] != '') ? $asValues['area'] : __('N/A'); ?> </td>
								<td align="left" valign="top"> <?php echo ($asValues['section'] != '') ? $asValues['section'] : __('N/A'); ?> </td>
								<td align="left" valign="top"> <?php echo ($asValues['row'] != '') ? $asValues['row'] : __('N/A'); ?> </td>
								<td align="left" valign="top"> <?php echo ($asValues['plot'] != '') ? $asValues['plot'] : __('N/A'); ?> </td>
								<td align="left" valign="top"> <?php echo ($asValues['grave'] != '') ? $asValues['grave'] : __('N/A'); ?> </td>
								<td align="left" valign="top"> <?php echo ($asValues['grantee'] != '') ? $asValues['grantee'] : __('N/A'); ?> </td>
								<td align="left" valign="top"> <?php echo ($asValues['service_type'] != '') ? $asValues['service_type'] : __('N/A'); ?> </td>
								<td align="left" valign="top"> <?php echo ($asValues['status'] == 1) ? __('Finalized') : __('Booking'); ?> </td>
                            </tr>
                        <?php endforeach;?>
                    </tbody>
                </table>
        <?php 
            else:
                echo '<div class="warning-msg noborder"><span>'.__('Record(s) not found').'</span></div>';
            endif;
        ?>
    </div>
</div>
<?php 
    echo input_hidden_tag('sortby',$sortby);
    echo input_hidden_tag('sortmode',$sortmode);
    echo input_hidden_tag('inactivateIds'); 
?>
