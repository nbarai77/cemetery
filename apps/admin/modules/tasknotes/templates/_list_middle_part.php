<?php use_helper('pagination'); ?>
<div id="main" class="listtable bordernone">
    <div class="maintablebg">
        <?php 
            if(count($amUserTaskNotesList) > 0):  
                echo input_hidden_tag('admin_act');
                echo input_hidden_tag('idtasknotes');
        ?>
                <table width="100%" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                        <tr>
							<th width="3%" align="left" valign="top" class="none">&nbsp;</th>
							<th width="14%" align="left" valign="top" class="none">
							<?php   echo __('Task Title'); ?>
							<div id="field_div_task_title" class="assanding">
								<a href="javascript:void(0);"> <?php echo image_tag('admin/ass-a.gif');?> </a>
								<div id="sort_div_task_title" class="inn_drupdownSort" style="display:none">
									<?php   
										include_partial(
											'global/sort_ajaxmain',
											array(
												'ssFieldName'       => 'task_title',
												'ssLink'            => $ssModuleName.'/index?request_type=ajax_request',
												'amExtraParameters' => $amExtraParameters,
												'amSearch'          => $amSearch,                                
												'update_div'        => 'contentlisting',
											)
										);
									?>
								</div>
							</div>
							</th>
							<th width="40%" align="left" valign="top" class="none">
								<?php   echo __('Task Description'); ?>							
							</th>
							<th width="15%" align="left" valign="top" class="none">
								<?php echo __('Entry Date'); ?>
							</th>							
							<th width="14%" align="left" valign="top" class="none">
								<?php echo __('Due Date'); ?>
							</th>
							<th width="3%" align="left" valign="top" class="none">&nbsp;</th>				
                        </tr>

                        <?php foreach($sf_data->getRaw('amUserTaskNotesList') as $snKey=>$asValues): ?>
                            <tr class="<?php echo ($snKey%2 == 0) ? "even" : "odd";?>">
                                <td align="left" valign="top" class="checkStar">
                                    <?php  echo checkbox_tag('id[]',$asValues['id'], false, array('class'=>'','onclick'=>"uncheck(this,'all','$inactivateIds')"));?>
                                </td>
								<td align="left" valign="top"> 
									<?php 
										echo link_to($asValues['task_title'],url_for($ssModuleName.'/addedit?id='.$asValues['id'].'&'.html_entity_decode($amExtraParameters['ssQuerystr'])), 
											array('title' => $asValues['task_title'],'class' => 'link1'));
									?>
								</td>
								<td align="left" valign="top"> <?php echo $asValues['task_description']; ?> </td>								
								<?php
									$ssEntryDate = $ssDueDate = '';
									
									if($asValues['entry_date'] != '' && $asValues['entry_date'] != '0000-00-00'):
										list($snYear,$snMonth,$snDay) = explode('-',$asValues['entry_date']);
										$ssEntryDate = $snDay.'-'.$snMonth.'-'.$snYear;
									endif;
									if($asValues['due_date'] != '' && $asValues['due_date'] != '0000-00-00'):
										list($snYear,$snMonth,$snDay) = explode('-',$asValues['due_date']);
										$ssDueDate = $snDay.'-'.$snMonth.'-'.$snYear;
									endif;										
								?>
								<td align="left" valign="top"> <?php echo $ssEntryDate; ?> </td>
								<td align="left" valign="top"> <?php echo $ssDueDate; ?> </td>
								<td align="center" valign="top">
									<?php 
										echo link_to(image_tag('admin/edit.gif'),
											$ssModuleName.'/addedit?id='.$asValues['id'].'&'.html_entity_decode($amExtraParameters['ssQuerystr']),
											array('title'=>__('Edit Task Notes') ,'class'=>'link1'));
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
