<?php use_helper('pagination'); ?>
<div id="main" class="listtable bordernone">
    <div class="maintablebg">
        <?php 
            if(count($amArSectionList) > 0):  
                echo input_hidden_tag('admin_act');
                echo input_hidden_tag('idsection');
        ?>
                <table width="100%" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                        <tr>
							<th width="2%" align="left" valign="top" class="none">&nbsp;</th>
							
							
							<th width="13%" align="left" valign="top" class="none">
							<?php   echo __('Section Name'); ?>
							<div id="field_div_section" class="assanding">
								<a href="javascript:void(0);"> <?php echo image_tag('admin/ass-a.gif');?> </a>
								<div id="sort_div_section" class="inn_drupdownSort" style="display:none">
									<?php   
										include_partial(
											'global/sort_ajaxmain',
											array(
												'ssFieldName'       => 'section_name',
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
							<?php if($sf_user->getAttribute('issuperadmin') == 1): ?>
							<th width="10%" align="left" valign="top" class="none">
								<?php   echo __('Country'); ?>							
							</th>
							<th width="23%" align="left" valign="top" class="none">
								<?php   echo __('Cemetery'); ?>							
							</th>
							<?php endif; ?>
							<th width="10%" align="left" valign="top" class="none">
								<?php   echo __('Area'); ?>	
							</th>
							<th width="10%" align="left" valign="top" class="none">
								<?php   echo __('Section'); ?>
							</th>

							<th width="10%" align="left" valign="top" class="none">
								<?php echo __('Status'); ?>								
							</th>

                        	<th width="2%" align="left" valign="top" class="none">&nbsp;</th>
                        </tr>

                        <?php foreach($sf_data->getRaw('amArSectionList') as $snKey=>$asValues): ?>
                            <tr class="<?php echo ($snKey%2 == 0) ? "even" : "odd";?>">
                                <td align="left" valign="top" class="checkStar">
                                    <?php  echo checkbox_tag('id[]',$asValues['id'], false, array('class'=>'','onclick'=>"uncheck(this,'all','$inactivateIds')"));?>
                                </td>

								<td align="left" valign="top"> 
									<?php 
										echo link_to($asValues['section_name'],url_for($ssModuleName.'/addedit?id='.$asValues['id'].'&'.html_entity_decode($amExtraParameters['ssQuerystr'])),												
											array('title' => $asValues['section_name'],'class' => 'link1'));
									?>
								</td>
								<?php if($sf_user->getAttribute('issuperadmin') == 1): ?>
                                <td align="left" valign="top"> <?php echo $asValues['country_name']; ?> </td>
                                <td align="left" valign="top"> <?php echo $asValues['cemetery_name']; ?> </td>
                                <?php endif; ?>
								<td align="left" valign="top"> <?php echo ($asValues['area_code'] != '' && $asValues['area_code'] != '0') ? $asValues['area_code'] : __('N/A'); ?> </td>
								<td align="left" valign="top"> <?php echo $asValues['section_code']; ?> </td>

                                <td align="left" valign="top"> 
                                <?php echo image_tag('admin/'.($asValues['is_enabled'] == 1 ? 'Active.gif' : 'InActive.gif'), array('title' => ($asValues['is_enabled'] == 1 ? __('Active') : __('InActive')))); ?>
                                </td>

                                <td align="center" valign="top">
                                    <?php 
                                        echo link_to(image_tag('admin/edit.gif'),
                                            $ssModuleName.'/addedit?id='.$asValues['id'].'&'.html_entity_decode($amExtraParameters['ssQuerystr']),
                                            array('title'=>__('Edit group') ,'class'=>'link1'));
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
