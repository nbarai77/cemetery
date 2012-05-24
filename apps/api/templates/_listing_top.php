<?php 
    $bStatusButton      = (isset($bStatusButton) && $bStatusButton == 'false') ? false : true;
    $bChangeOrderButton = (isset($bChangeOrderButton) && $bChangeOrderButton == 'true') ? true : false;
?>
<div class="actions zindex_up">
    <ul class="fleft">
		
		<?php if(isset($checkbox) && $checkbox == 'true'):?>
		<?php else: ?>
        <li class="list1">
            <span>
                <div class="assanding1" >
                    <?php echo checkbox_tag('checkall','','',array('onclick'=>'checkAll(this,"'.$id_checkboxes.'","'.$inactivateIds.'")','style'=>"height:12px; float:left; width:12px;")); ?>
                    <span class="arrow" id="selectopt" style="cursor:pointer; border:1px solid #000000;">
                        <div class="inn_drupdown1" id="chkunchk" style="display:none;margin-top:18px;">
                            <ul>
                                <li><?php echo __('Select')?>:</li>
                                <li><?php echo jq_link_to_function('All',"SetAllCheckBoxes('$form_name','$id_checkboxes',true,'all','$inactivateIds')",array('class'=>'','name'=>'all','id'=>'all','title'=>'All')); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</li>
                                <li><?php echo jq_link_to_function('None',"SetAllCheckBoxes('$form_name','$id_checkboxes',false,'none','$inactivateIds')",array('class'=>'','title'=>'None'));?></li>
                            </ul>
							<div class="inn_drupdown1Bottom"></div>
                        </div>
                    </span>
                </div>
            </span>
        </li>
        <?php endif; ?>
        
		<?php if(isset($back_url)):?>
		 <li class="list1">
            <span> <?php echo link_to(__('Back'),$back_url,array('class'=>'None','title'=>__('Back')));?> </span>
         </li>
        <?php endif; ?>
		<?php if(isset($add_assign_grantee_url)):?>
		 <li class="list1">
            <span> <?php echo link_to(__('Assign Grantee'),$add_assign_grantee_url,array('class'=>'nyroModal','title'=>__('Assign Grantee')));?> </span>
         </li>
        <?php endif; ?>
		<?php if(isset($add_new_grantee_url)):?>
		 <li class="list1">
            <span> <?php echo link_to(__('Assign New Grantee'),$add_new_grantee_url,array('class'=>'None','title'=>__('Assign New Grantee')));?> </span>
         </li>
        <?php endif; ?>
		<?php if(isset($compose_url)):?>
		 <li class="list1">
            <span> <?php echo link_to(__('Compose'),$compose_url,array('class'=>'None','title'=>__('Compose')));?> </span>
         </li>
        <?php endif; ?>
		<?php if(isset($inbox_url)):?>
		 <li class="list1">
            <span> <?php echo link_to(__('Inbox'),$inbox_url,array('class'=>'None','title'=>__('Inbox')));?> </span>
         </li>
        <?php endif; ?>
		<?php if(isset($sent_url)):?>
		 <li class="list1">
            <span> <?php echo link_to(__('Sent'),$sent_url,array('class'=>'None','title'=>__('Sent')));?> </span>
         </li>
        <?php endif; ?>
		<?php if(isset($trash_url)):?>
		 <li class="list1">
            <span> <?php echo link_to(__('Trash'),$trash_url,array('class'=>'None','title'=>__('Trash')));?> </span>
         </li>
        <?php endif; ?>
        <?php if(isset($add_new_url)):?>
        <li class="list1">
            <span> <?php echo link_to(__('Add new'),$add_new_url,array('class'=>'None','title'=>__('Add new')));?> </span>
        </li>
        <?php endif; ?>
		<?php if(isset($add_multiple_url)):?>
        <li class="list1">
            <span> <?php echo link_to(__('Add Multiple Graves'),$add_multiple_url,array('class'=>'None','title'=>__('Add Multiple Graves')));?> </span>
        </li>
        <?php endif; ?>	
        <?php if(isset($bDeleteButton) && $bDeleteButton == 'cemAdmin'):?>
        <?php else: $ssDeleteLabel = (isset($delete_label)) ? __('Complete') : __('Delete'); ?>
        
        <li class="list1">
            <span>
                <?php 
                    echo jq_submit_to_remote(
                            $ssDeleteLabel, 
                            $ssDeleteLabel, 
                            array(
                                'update'   => $update_div,
                                'url'      => $url,
                                'before'   => "adminAct('".$admin_act_module."');",
                                'condition'=> "removeConfirm('".$id_checkboxes."','delete')",
                                'loading'  => jq_visual_effect('fadeIn','#indicator1'),
                                'complete' => jq_visual_effect('fadeOut','#indicator1')."sortingdiv();",
                            ),
                            array('id'=>'bStatus','class'=>'delete','title'=> $ssDeleteLabel)
                        ); 
                ?>
            </span>
        </li>
        <?php endif; ?>
        <?php if($bStatusButton): ?>
        <li class="list1">
            <span>
                <span class="arrow" id="selectopt1" style = "cursor:pointer;" title="<?php echo __('Change status');?>"><?php echo __('Change status');?>
                    <div class="assanding" style="display:block;">
                        <?php $ssDropDownClass="inn_drupdown";?>
                        <div class="<?php echo $ssDropDownClass;?>" id="chkunchk1" style="display:none;">
                            <ul>
                                <li><?php echo __('Select')?>:</li>
                                <li>
                                    <?php echo jq_submit_to_remote("Active", "Active", array(
                                    'update'   => $update_div,
                                    'url'      => $url."&request_status=Active",
                                    "before"   =>"adminAct('".$admin_act_status."');",
                                    "condition"=>"removeConfirm('".$id_checkboxes."','status')",
                                    'loading'  => jq_visual_effect('fadeIn','#indicator1'),
                                    'complete' => jq_visual_effect('fadeOut','#indicator1').'jQuery("#chkunchk1").hide();sortingdiv();uncheckAllChkbox()',
                                    ),array('title'=>__('Active'),'id'=>'bStatus','style'=>'cursor:pointer')); ?>
                                </li>
                                <li>
                                    <?php echo jq_submit_to_remote("InActive", "InActive", array(
                                    'update'   => $update_div,
                                    'url'      => $url."&request_status=InActive",
                                    "before"   =>"adminAct('".$admin_act_status."');",
                                    "condition"=>"removeConfirm('".$id_checkboxes."','status')",
                                    'loading'  => jq_visual_effect('fadeIn','#indicator1'),
                                    'complete' => jq_visual_effect('fadeOut','#indicator1').'jQuery("#chkunchk1").hide();sortingdiv();uncheckAllChkbox()',
                                    ),array('title'=>__('Inactive'),'id'=>'bStatus','style'=>'cursor:pointer')); ?>
                                </li>
                            </ul>
                        </div>
                    </div>
                </span>
            </span>
        </li>
        <?php endif; 
        if($bChangeOrderButton): ?>
        <li class="list1">
            <span>
                <?php echo jq_submit_to_remote(__('Change order'), __('Change order'), array(
                'update'   => $update_div,
                'url'      => $url,
                'before'   => "adminAct('change_order'); var ssFL = checkvalidNumber('sort_order[]','".__('Enter only numeric value')."'); if(!ssFL) return ssFL; ",
                'loading'  => jq_visual_effect('fadeIn','#indicator1'),
                'complete' => jq_visual_effect('fadeOut','#indicator1')."sortingdiv();",
                ),array('id'=>'bStatus','class'=>'delete','title'=>__('Change order'))); 
                ?>
            </span>
        </li>
        <?php endif; ?>
        
		<?php if(isset($annualsearch)):?>
		 <li class="list1">
            <span> <?php echo link_to(__('Search'),'annualsearch/report',array('class'=>'None','title'=>__('Search')));?> </span>
         </li>
        <?php endif; ?>        
        
        
    </ul>
</div>
<?php 
    echo javascript_tag('
        showHideSortDiv("chkunchk","selectopt");
        showHideSortDiv("chkunchk1","selectopt1"); 
    '); 
?>