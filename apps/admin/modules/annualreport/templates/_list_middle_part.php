<?php use_helper('pagination'); ?>
<h1>
	<?php echo __('Annual Care Report');?>
	<span id="no_of_items"><?php include_partial('global/total_items',array('snTotalItems'=> $snPageTotalAnnualReportRecords));?></span>
</h1>
<div id="main" class="listtable">
    <div class="maintablebg">
        <?php 
            if(count($amAnnualReportList) > 0):  
                echo input_hidden_tag('admin_act');
                echo input_hidden_tag('idgrave');
        ?>
		<table width="100%" border="0" cellpadding="0" cellspacing="0">
			<tbody>
				<tr>
					<th width="1%" align="left" valign="top" class="none">&nbsp;</th>
					<th width="5%" align="left" valign="top" class="none"><?php   echo __('Area'); ?></th>
					<th width="5%" align="left" valign="top" class="none"><?php   echo __('Section'); ?></th>
					<th width="5%" align="left" valign="top" class="none"><?php   echo __('Row'); ?></th>
					<th width="5%" align="left" valign="top" class="none"><?php   echo __('Plot'); ?></th>
					<th width="8%" align="left" valign="top" class="none"><?php   echo __('Grave'); ?></th>
					<th width="7%" align="left" valign="top" class="none"><?php   echo __('Interred'); ?></th>
					<th width="7%" align="left" valign="top" class="none"><?php   echo __('Renewal Date'); ?></th>
					<th width="5%" align="left" valign="top" class="none"><?php   echo __('Renewal Term'); ?></th>
					<th width="15%" align="left" valign="top" class="none"><?php   echo __('Operations Notes'); ?></th>
				</tr>

				<?php foreach($sf_data->getRaw('amAnnualReportList') as $snKey=>$asValues): ?>
					<tr class="<?php echo ($snKey%2 == 0) ? "even" : "odd";?>">
					<td align="left" valign="top">&nbsp;</td>
					<td align="left" valign="top"> <?php echo ($asValues['area_name'] != '' && $asValues['area_name'] != '0') ? $asValues['area_name'] : __('N/A'); ?> </td>
					<td align="left" valign="top"> <?php echo ($asValues['section_name'] != '' && $asValues['section_name'] != '0') ? $asValues['section_name'] : __('N/A'); ?> </td>
					<td align="left" valign="top"> <?php echo ($asValues['row_name'] != '' && $asValues['row_name'] != '0') ? $asValues['row_name'] : __('N/A'); ?> </td>
					<td align="left" valign="top"> <?php echo ($asValues['plot_name'] != '' && $asValues['plot_name'] != '0') ? $asValues['plot_name'] : __('N/A'); ?> </td>
					<td align="left" valign="top"> <?php echo $asValues['grave_number']; ?> </td>
					<td align="left" valign="top"> <?php echo $asValues['interred']; ?> </td>
					<?php
						$ssRenewalDate = '';
						if($asValues['renewal_date'] != '' && $asValues['renewal_date'] != '0000-00-00'):
							list($snYear,$snMonth,$snDay) = explode('-', $asValues['renewal_date']);
							$ssRenewalDate = $snDay.'-'.$snMonth.'-'.$snYear;
						endif;
					?>
					<td align="left" valign="top"> <?php echo $ssRenewalDate; ?> </td>
					<td align="left" valign="top"> <?php echo $asValues['renewal_term']; ?> </td>
					<td align="left" valign="top"> <?php echo $asValues['notes']; ?> </td>

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
