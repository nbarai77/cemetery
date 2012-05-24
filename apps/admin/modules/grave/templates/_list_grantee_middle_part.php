<?php use_helper('pagination'); 
use_javascript('nyroModal/jquery.nyroModal.custom.js');
use_stylesheet('nyroModal/nyroModal');
?>
<div id="main" class="listtable">
	<div class="maintablebg">
		<?php if(count($amGranteesList) > 0): 
				echo input_hidden_tag('admin_act');
				echo input_hidden_tag('idgrantees');
		?>
			<table width="100%" border="0" cellpadding="0" cellspacing="0">
				<tbody>
					<tr>
						<th width="2%" align="left" valign="top" class="none">&nbsp;</th>
						<th width="10%" align="left" valign="top" class="none"><?php echo __('Grantee Identity'); ?></th>
						<th width="15%" align="left" valign="top" class="none"><?php echo __('Grantee Identity Number'); ?></th>
						<th width="10%" align="left" valign="top" class="none">
							<?php echo __('Surname'); ?>
						</th>
						<th width="10%" align="left" valign="top" class="none">
							<?php echo __('First Name'); ?>
						</th>
						<?php if($sf_user->getAttribute('issuperadmin') == 1): ?>
						<th width="10%" align="left" valign="top" class="none">
							<?php echo __('Country'); ?>
						</th>
						<th width="15%" align="left" valign="top" class="none">
							<?php echo __('Cemetery'); ?>
						</th>
						<?php endif; ?>
						<th width="6%" align="left" valign="top" class="none">
							<?php echo __('Area'); ?>
						</th>
						<th width="6%" align="left" valign="top" class="none">
							<?php echo __('Section'); ?>							
						</th>
						<th width="6%" align="left" valign="top" class="none">
							<?php echo __('Row'); ?>
						</th>
						<th width="6%" align="left" valign="top" class="none">
							<?php echo __('Plot'); ?>
						</th>
						<th width="10%" align="left" valign="top" class="none">
							<?php echo __('Grave Number'); ?>
						</th>
						<th width="2%" align="left" valign="top" class="none"><?php echo __('Actions');?></th>
					</tr>

					<?php foreach($amGranteesList as $snKey=>$asValues): ?>
						<tr class="<?php echo ($snKey%2 == 0) ? "even" : "odd";?>">
							<td align="left" valign="top" class="checkStar">
                                    <?php  echo checkbox_tag('id[]',$asValues['grantee_id'], false, array('class'=>'','onclick'=>"uncheck(this,'all','$inactivateIds')"));?>
                            </td>
							<td align="left" valign="top"> <?php echo $asValues['grantee_identity_name']; ?> </td>
							<td align="left" valign="top"> <?php echo $asValues['grantee_identity_number']; ?> </td>
							<td align="left" valign="top"> 
								<?php echo $asValues['grantee_surname'];?>
							</td>
							<td align="left" valign="top"> 
								<?php echo ($asValues['title'] != '') ? $asValues['title'].' '.$asValues['grantee_first_name'] : $asValues['grantee_first_name'];?>
							</td>
							<?php if($sf_user->getAttribute('issuperadmin') == 1): ?>
							<td align="left" valign="top"> <?php echo $asValues['country_name']; ?> </td>
							<td align="left" valign="top"> <?php echo $asValues['cemetery_name']; ?> </td>
							<?php endif; ?>
							<td align="left" valign="top"> <?php echo ($asValues['area_name'] != '' && $asValues['area_name'] != '0') ? $asValues['area_name'] : __('N/A'); ?> </td>
							<td align="left" valign="top"> <?php echo ($asValues['section_name'] != '' && $asValues['section_name'] != '0') ? $asValues['section_name'] : __('N/A'); ?> </td>
							<td align="left" valign="top"> <?php echo ($asValues['row_name'] != '' && $asValues['row_name'] != '0') ? $asValues['row_name'] : __('N/A'); ?> </td>
							<td align="left" valign="top"> <?php echo ($asValues['plot_name'] != '' && $asValues['plot_name'] != '0') ? $asValues['plot_name'] : __('N/A'); ?> </td>
							<td align="left" valign="top"> <?php echo $asValues['grave_number'];?> </td>
							<td align="left" valign="top">
								<div class="fleft" style="margin-left:5px;">
									<?php
										 echo link_to(image_tag('admin/EditImage.png'),url_for('grantee/surrenderGrave?id='.$asValues['grantee_id'].'&grantee_id='.$asValues['id'].'&grave_id='.$snIdGrave),array('title' => __('Surrender Grave')));?>
								</div>
								<?php if(!$sf_user->isSuperAdmin() && $asValues['is_transferd_grave'] > 0 ): ?>
								<div class="fleft" style="margin-left:5px;">
									<?php 
										$ssActionName = 'transferGraveCertificate?grave_id='.$asValues['grave_id'].'&'.html_entity_decode($amExtraParameters['ssQuerystr']);
										echo link_to(image_tag('admin/pdf.jpg'),url_for('grantee/'.$ssActionName),
												array('title' => __('Print Grave Transfer Certificate') ));
										?>
								</div>
								<?php endif; ?>
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
