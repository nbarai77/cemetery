<?php use_helper('pagination'); ?>
<div id="main" class="listtable">
    <div class="maintablebg">
        <?php 
            if(count($amWorkorderList) > 0):  
                echo input_hidden_tag('admin_act');
                echo input_hidden_tag('idworkorder');
        ?>
                <table width="100%" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                        <tr>
							<th width="2%" align="left" valign="top" class="none">&nbsp;</th>
							<th width="10%" align="left" valign="top" class="none">
								<?php   echo __('Surname'); ?>
								<div id="field_div_surname" class="assanding">
                                    <a href="javascript:void(0);"> <?php echo image_tag('admin/ass-a.gif');?> </a>
                                    <div id="sort_div_surname" class="inn_drupdownSort" style="display:none">
                                        <?php   
                                            include_partial(
                                                'global/sort_ajaxmain',
                                                array(
                                                    'ssFieldName'       => 'surname',
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
							<th width="10%" align="left" valign="top" class="none">
								<?php   echo __('Name'); ?>
								<div id="field_div_name" class="assanding">
                                    <a href="javascript:void(0);"> <?php echo image_tag('admin/ass-a.gif');?> </a>
                                    <div id="sort_div_name" class="inn_drupdownSort" style="display:none">
                                        <?php   
                                            include_partial(
                                                'global/sort_ajaxmain',
                                                array(
                                                    'ssFieldName'       => 'name',
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
							<th width="6%" align="left" valign="top" class="none">
								<?php   echo __('Area'); ?>
							</th>
							<th width="6%" align="left" valign="top" class="none">
								<?php   echo __('Section'); ?>							
							</th>
							<th width="6%" align="left" valign="top" class="none">
								<?php   echo __('Row'); ?>
							</th>							
							<th width="6%" align="left" valign="top" class="none">
								<?php   echo __('Plot'); ?>
							</th>
							<th width="8%" align="left" valign="top" class="none">
								<?php echo __('Grave Number'); ?>
							</th>
							<th width="6%" align="left" valign="top" class="none">
								<?php   echo __('Work Date'); ?>
							</th>
							<th width="10%" align="left" valign="top" class="none">
								<?php   echo __('Department Delegation'); ?>
							</th>
							<th width="10%" align="left" valign="top" class="none">
								<?php   echo __('Completed By'); ?>
							</th>
							<th width="10%" align="left" valign="top" class="none">
								<?php   echo __('Completion Date'); ?>
							</th>

                        	<th width="2%" align="left" valign="top" class="none">&nbsp;</th>
                        </tr>

                        <?php foreach($sf_data->getRaw('amWorkorderList') as $snKey=>$asValues): ?>
                            <tr class="<?php echo ($snKey%2 == 0) ? "even" : "odd";?>">
                                <td align="left" valign="top" class="checkStar">
                                    <?php  echo checkbox_tag('id[]',$asValues['id'], false, array('class'=>'','onclick'=>"uncheck(this,'all','$inactivateIds')"));?>
                                </td>
								
								<td align="left" valign="top"> <?php echo $asValues['surname']; ?> </td>								
                                <td align="left" valign="top"> <?php echo $asValues['name']; ?> </td>
	
								<td align="left" valign="top"> <?php echo ($asValues['area_name'] != '' && $asValues['area_name'] != '0') ? $asValues['area_name'] : __('N/A'); ?> </td>
								<td align="left" valign="top"> 
									<?php echo ($asValues['section_name'] != '' && $asValues['section_name'] != '0') ? $asValues['section_name'] : __('N/A'); ?> 
								</td>
								<td align="left" valign="top"> <?php echo ($asValues['row_name'] != '' && $asValues['row_name'] != '0') ? $asValues['row_name'] : __('N/A'); ?> </td>
								<td align="left" valign="top"> <?php echo ($asValues['plot_name'] != '' && $asValues['plot_name'] != '0') ? $asValues['plot_name'] : __('N/A'); ?> </td>
								<td align="left" valign="top"> <?php echo ($asValues['grave_number'] != '' && $asValues['grave_number'] != '0') ? $asValues['grave_number'] : __('N/A'); ?> </td>
								
								<td align="left" valign="top"> 
									<?php echo ($asValues['work_date'] != '' && $asValues['work_date'] != '0000-00-00') ? date('d-m-Y', strtotime($asValues['work_date'])) : ''; ?> 
								</td>
								<td align="left" valign="top"> <?php echo $asValues['department_name']; ?> </td>
								<td align="left" valign="top"> <?php echo $asValues['completed_by']; ?> </td>
								<td align="left" valign="top"> 
									<?php echo ($asValues['completion_date'] != '' && $asValues['completion_date'] != '0000-00-00') ? date('d-m-Y', strtotime($asValues['completion_date'])) : '';?> 
								</td>

                                <td align="center" valign="top">
									<?php 
										echo link_to(image_tag('admin/edit.gif'),
											$ssModuleName.'/addedit?id='.$asValues['id'].'&'.html_entity_decode($amExtraParameters['ssQuerystr']),
											array('title'=>__('Edit Grave Maintenance') ,'class'=>'link1'));
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
