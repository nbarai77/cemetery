<?php use_helper('pagination'); ?>
<h1>
	<?php echo __('Burials');?>
	<span id="no_of_items"><?php include_partial('global/total_items',array('snTotalItems'=> $snPageTotalBurialRecords));?></span>
</h1>
<div id="main" class="listtable bordernone">
    <div class="maintablebg">
		<table width="100%" border="0" cellpadding="0" cellspacing="0">
			<tbody>
				<tr class="th1">
					<th width="5%" align="left" valign="top" class="none"><?php   echo __('From'); ?></th>
					<th width="5%" align="left" valign="top" class="none"><?php   echo __('To'); ?></th>
					<th width="15%" align="left" valign="top" class="none"><?php   echo __('Service Of'); ?></th>
					<!--<th width="10%" align="left" valign="top" class="none"><?php   //echo __('first_name'); ?></th>-->
					<th width="15%" align="left" valign="top" class="none"><?php   echo __('Funeral Director'); ?></th>
					<th width="10%" align="left" valign="top" class="none"><?php   echo __('Area'); ?></th>
					<th width="10%" align="left" valign="top" class="none"><?php   echo __('Section'); ?></th>
					<th width="10%" align="left" valign="top" class="none"><?php   echo __('Row'); ?></th>
					<th width="10%" align="left" valign="top" class="none"><?php   echo __('Plot'); ?></th>
					<th width="9%" align="left" valign="top" class="none"><?php   echo __('Grave No'); ?></th>
					<th width="11%" align="center" valign="top" class="none"><?php   echo __('Status'); ?></th>
					<!--<th width="10%" align="left" valign="top" class="none"><?php   //echo __('Service Date'); ?></th>-->
					
				</tr>
				<?php  if(count($amBurialSummaryList) > 0):  
					foreach($sf_data->getRaw('amBurialSummaryList') as $snKey=>$asValues): ?>
					<tr class="<?php echo ($snKey%2 == 0) ? "even-small" : "odd-small";?>">

						<td align="left" valign="top"> 
							<?php echo $asValues['service_booking_time_from'];
								/*echo link_to($asValues['service_booking_time_from'],
									url_for('servicebooking/addedit?id='.$asValues['id'].'&'.html_entity_decode($amExtraParameters['ssQuerystr'])),
									array('title'=>__('Edit'),'class'=>'link1'));*/
                             ?>
						</td>
						<td align="left" valign="top"> 
							<?php echo $asValues['service_booking_time_to'];
								/*echo link_to($asValues['service_booking_time_to'],
									url_for('servicebooking/addedit?id='.$asValues['id'].'&'.html_entity_decode($amExtraParameters['ssQuerystr'])),
									array('title'=>__('Edit'),'class'=>'link1'));*/
                             ?>
						</td>						
						<td align="left" valign="top"> 
							<?php 
								$ssDeceasedSurname =  ($asValues['deceased_title'] != '') ? $asValues['deceased_title'].'&nbsp;'.$asValues['deceased_first_name'] : $asValues['deceased_first_name'];
                                $ssDeceasedName = $asValues['deceased_surname'];
								echo link_to($ssDeceasedSurname." ".$ssDeceasedName,
									url_for('servicebooking/addedit?id='.$asValues['id'].'&'.html_entity_decode($amExtraParameters['ssQuerystr'])),
									array('title'=>__('Edit').'&nbsp;'.$ssDeceasedName ,'class'=>'link1'));
                             ?>
						</td>

						<td align="left" valign="top"> <?php echo $asValues['fnd_name']; ?> </td>
						<td align="left" valign="top"> <?php echo ($asValues['area_name'] != '') ? $asValues['area_name'] : __('N/A'); ?> </td>
						<td align="left" valign="top"> <?php echo ($asValues['section_name'] != '') ? $asValues['section_name'] : __('N/A'); ?> </td>
						<td align="left" valign="top"> <?php echo ($asValues['row_name'] != '') ? $asValues['row_name'] : __('N/A'); ?> </td>
						<td align="left" valign="top"> <?php echo ($asValues['plot_name'] != '') ? $asValues['plot_name'] : __('N/A'); ?> </td>
						<td align="left" valign="top"> <?php echo ($asValues['grave_number'] != '') ? $asValues['grave_number'] : __('N/A'); ?> </td>
						<td align="center" valign="top"> <?php echo ($asValues['is_finalized'] == 1) ? __('Interment') : __('Service Booking'); ?> </td>
						<!--<td align="left" valign="top"> <?php //echo date("d-m-Y",strtotime($asValues['service_date'])); ?> </td>-->
						
					</tr>
					<?php endforeach;
					 else:
						echo '<tr><td colspan="11"><div class="warning-msg"><span>'.__('Record(s) not found').'</span></div></td></tr>';
					endif;
				?>
			</tbody>
		</table>
    </div>
</div>

<?php 
    echo input_hidden_tag('sortby',$sortby);
    echo input_hidden_tag('sortmode',$sortmode);
    echo input_hidden_tag('inactivateIds'); 
?>


