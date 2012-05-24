<table width="100%" border="0" cellspacing="0" cellpadding="0" class="sub_table">
	<tr>
		<td colspan="3" align="right" style="border:1px solid; background-color:#FFFFFF;">
			<div class="fright" style="margin-right:5px;">
				<?php 
				echo link_to(__('Reply'),url_for('cemmail/sendMail?id='.$snMailId.'&from_user_id='.$snUserMailId),array('title' => __('Reply'),'class' => 'link1'));?>
			</div>
			<div class="fright" style="margin-right:5px;">
				<?php echo link_to(__('Forward'),url_for('cemmail/sendMail?id='.$snMailId.'&from_user_id='.$snUserMailId),array('title' => __('Forward'), 'class' => 'link1'));?> |
			</div>						
		</td>
	</tr>
	<tr>
		<td colspan="3" width="100%" style="border:1px solid; background-color:#CCCCCC;">
			<table width="100%" cellpadding="0" cellspacing="0">				
				<tr>
					<td width="20%" align="right">
						<strong><?php echo __('From');?></strong>
					</td>
					<td>:</td>
					<td>
						<?php echo $amCemMailsDetails['from_email'];?>
					</td>
				</tr>
				<tr>
					<td width="20%" align="right">
						<strong><?php echo __('Subject');?></strong>
					</td>
					<td width="1%">:</td>
					<td width="79%">
						<?php echo $amCemMailsDetails['mail_subject'];?>
					</td>
				</tr>
				<tr>
					<td width="20%" align="right">
						<strong><?php echo __('Date');?></strong>
					</td>
					<td>:</td>
					<td>
						<?php echo date('d-m-Y H:i:s',strtotime($amCemMailsDetails['sent_date']));?>
					</td>
				</tr>
				<tr>	
					<td width="20%" align="right">
						<strong><?php echo __('To');?></strong>
					</td>
					<td>:</td>
					<td>
						<?php echo $amCemMailsDetails['to_email'];?>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td colspan="3" width="100%">
			<div style="border:1px solid;">
				<br />
				<p style="margin-left:5px;"><?php echo html_entity_decode($amCemMailsDetails['mail_body']);?></p>
				<br />
			</div>
		</td>
	</tr>
</table>