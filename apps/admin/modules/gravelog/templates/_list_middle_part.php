<?php use_helper('pagination'); 
if(count($amGuardGroupList) > 0):?>
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
            if(count($amGuardGroupList) > 0):  
                echo input_hidden_tag('admin_act');
                echo input_hidden_tag('idgravelog');?>
                <table width="100%" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                        <tr>
							<th width="15%" align="left" valign="top" class="none"><?php   echo __('Time'); ?></th>
							<th width="15%" align="left" valign="top" class="none"><?php   echo __('Operation'); ?></th>
                            <th width="10%" align="left" valign="top" class="none"><?php   echo __('Area'); ?></th>
                            <th width="10%" align="left" valign="top" class="none"><?php   echo __('Section'); ?></th>
                            <th width="10%" align="left" valign="top" class="none"><?php   echo __('Row'); ?></th>
                            <th width="10%" align="left" valign="top" class="none"><?php   echo __('Plot'); ?></th>
							<th width="15%" align="left" valign="top" class="none"><?php   echo __('Grave Number'); ?></th>
                        </tr>

                        <?php foreach($sf_data->getRaw('amGuardGroupList') as $snKey=>$asValues): ?>
                            <tr class="<?php echo ($snKey%2 == 0) ? "even" : "odd";?>">
								<td align="left" valign="top"> <?php echo date('d-m-Y h:i:s', strtotime($asValues['operation_date'])); ?> </td>
								<td align="left" valign="top"> <?php echo $asValues['operation']; ?> </td>
                                <td align="left" valign="top"> <?php echo ($asValues['area_name'] != '') ? $asValues['area_name'] : __('N/A'); ?> </td>
                                <td align="left" valign="top"> <?php echo ($asValues['section_name'] != '') ? $asValues['section_name'] : __('N/A'); ?> </td>
                                <td align="left" valign="top"> <?php echo ($asValues['row_name'] != '') ? $asValues['row_name'] : __('N/A'); ?> </td>
                                <td align="left" valign="top"> <?php echo ($asValues['plot_name'] != '') ? $asValues['plot_name'] : __('N/A'); ?> </td>
								<td align="left" valign="top"> <?php echo $asValues['grave_number']; ?> </td>
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
