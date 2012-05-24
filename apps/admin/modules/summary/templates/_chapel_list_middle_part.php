<?php use_helper('pagination'); ?>
<h1>
	<?php echo __('Chapel');?>
	<span id="no_of_items"><?php include_partial('global/total_items',array('snTotalItems'=> $snPageTotalChapelRecords));?></span>
</h1>
<div id="main" class="listtable bordernone">
    <div class="maintablebg">
		<table width="100%" border="0" cellpadding="0" cellspacing="0">
			<tbody>
				<tr class="th1">
					<th width="5%" align="left" valign="top" class="none"><?php   echo __('From'); ?></th>
					<th width="5%" align="left" valign="top" class="none"><?php   echo __('To'); ?></th>		
					<th width="20%" align="left" valign="top" class="none"><?php   echo __('Location'); ?></th>			
					<th width="20%" align="left" valign="top" class="none"><?php   echo __('Service Of'); ?></th>
					<!--<th width="20%" align="left" valign="top" class="none"><?php   //echo __('first_name'); ?></th>-->
					<th width="25%" align="left" valign="top" class="none"><?php   echo __('Informant'); ?></th>
					<th width="25%" align="center" valign="top" class="none"><?php   echo __('Status'); ?></th>
					<!--<th width="10%" align="left" valign="top" class="none"><?php   //echo __('Service Date'); ?></th>-->
					
				</tr>
				<?php  if(count($amChapelSummaryList) > 0):  
					foreach($sf_data->getRaw('amChapelSummaryList') as $snKey=>$asValues): 
					$ssInformantName = (!isset($asValues['informant_surname']) || !isset($asValues['informant_first_name']) ) ? __('N/A'): (($asValues['informant_surname'] != '' || $asValues['informant_first_name'] != '') ? $asValues['informant_surname'].' '.$asValues['informant_first_name'] : '' );
					$ssInformantName = ($ssInformantName != '') ? $ssInformantName : __('N/A');
					?>
					<tr class="<?php echo ($snKey%2 == 0) ? "even-small" : "odd-small";?>">

						<td align="left" valign="top"> 
							<?php echo date('H:i:s',strtotime($asValues['chapel_time_from']));?>
						</td>
						<td align="left" valign="top"> 
							<?php echo date('H:i:s',strtotime($asValues['chapel_time_to']));?>
						</td>
						
						
						<td align="left" valign="top"> 
							<?php echo $asValues['chapel_types'];?>
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
						<td align="left" valign="top"> <?php echo $ssInformantName; ?> </td>
						<td align="center" valign="top"> <?php echo (!isset($asValues['is_finalized'])) ? __('Facility Booking') : ( ($asValues['is_finalized'] == 1) ? __('Interment') : __('Service Booking')); ?> </td>
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
