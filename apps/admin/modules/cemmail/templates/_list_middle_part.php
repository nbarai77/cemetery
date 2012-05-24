<?php use_helper('pagination'); ?>
<div id="main" class="listtable">
    <div class="maintablebg">
        <?php 
            if(count($amCemMailsList) > 0):  
                echo input_hidden_tag('admin_act');
                echo input_hidden_tag('idmails');
				$user_id = $sf_user->getAttribute('userid');
        ?>
                <table width="100%" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                        <tr>
							<th width="2%" align="left" valign="top" class="none">&nbsp;</th>
							<th width="20%" align="left" valign="top" class="none">
								<?php 
									$ssLabelName = ($sf_params->get('mail_type') == 'sent') ? __('To') : __('From');
									echo $ssLabelName;
									?>
							</th>
							<th width="15%" align="left" valign="top" class="none">
								<?php   echo __('Date'); ?>
							</th>
							<th width="60%" align="left" valign="top" class="none">
								<?php   echo __('Subject'); ?>							
							</th>
                        </tr>

                        <?php foreach($sf_data->getRaw('amCemMailsList') as $snKey=>$asValues): ?>
							<tr class="<?php echo ($snKey%2 == 0) ? "even" : "odd";?>">
								<td align="left" valign="top" class="checkStar">
									<?php  echo checkbox_tag('id[]',$asValues['id'], false, array('class'=>'','onclick'=>"uncheck(this,'all','$inactivateIds')"));?>
								</td>
								<td align="left" valign="top">
									<?php 
										$ssFromToValue = ($sf_params->get('mail_type') == 'sent') ? $asValues['to_email_address']: $asValues['from_email'];
										echo $ssFromToValue; 
									?>
								</td>
								<td align="left" valign="top"><?php echo date('d.m.Y H:i:s',strtotime($asValues['CemMail']['created_at'])); ?></td>
								<td align="left" valign="top">
									<?php 
										$ssReadClass = ($asValues['read_unread_status'] == 1) ? 'readmail' : 'unreadmail';
										$ssURL = url_for($ssModuleName.'/showDetails?id='.$asValues['id'].'&'.html_entity_decode($amExtraParameters['ssQuerystr']));
										
										echo link_to_function($asValues['CemMail']['mail_subject'],"showMailDetails('".$ssURL."','".$asValues['id']."','".$ssMailType."','".$asValues['CemMail']['id']."','".$asValues['from_user_id']."');", 
											array('title' => $asValues['CemMail']['mail_subject'],'class' => $ssReadClass));
									?>
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
