<?php use_helper('pagination'); ?>
<div id="main" class="listtable">
    <div class="maintablebg">
        <?php 
            if(count($amStonemasonList) > 0):  
                echo input_hidden_tag('admin_act');
                echo input_hidden_tag('idarea');
        ?>
                <table width="100%" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                        <tr>
							<th width="2%" align="left" valign="top" class="none">&nbsp;</th>
							
							<th width="20%" align="left" valign="top" class="none">
							<?php   echo __('Company'); ?>
							<div id="field_div_organisation" class="assanding">
								<a href="javascript:void(0);"> <?php echo image_tag('admin/ass-a.gif');?> </a>
								<div id="sort_div_organisation" class="inn_drupdownSort" style="display:none">
									<?php   
										include_partial(
											'global/sort_ajaxmain',
											array(
												'ssFieldName'       => 'organisation',
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
								<?php   echo __('Code'); ?>							
							</th>
							<th width="20%" align="left" valign="top" class="none">
								<?php   echo __('Suburb/Town'); ?>							
							</th>
							<th width="5%" align="left" valign="top" class="none">
								<?php   echo __('Telephone'); ?>							
							</th>
							
							<th width="5%" align="left" valign="top" class="none">&nbsp;</th>
                        </tr>

                        <?php foreach($sf_data->getRaw('amStonemasonList') as $snKey=>$asValues): ?>
                            <tr class="<?php echo ($snKey%2 == 0) ? "even" : "odd";?>">
                                <td align="left" valign="top" class="checkStar">
                                    <?php  echo checkbox_tag('id[]',$asValues['id'], false, array('class'=>'','onclick'=>"uncheck(this,'all','$inactivateIds')"));?>
                                </td>

								 <td align="left" valign="top"> 
									<?php echo link_to($asValues['organisation'],url_for($ssModuleName.'/listDocuments?id_stonemason='.$asValues['user_id'].'&company='.$asValues['organisation']),
												array('title' => $asValues['organisation'],'class' => 'link1'));?>
								</td>
								<td align="left" valign="top"> <?php echo $asValues['code']; ?> </td>
								<td align="left" valign="top"> <?php echo $asValues['suburb']; ?> </td>
								<td align="left" valign="top"> <?php echo $asValues['phone']; ?> </td>
								
								<td align="center" valign="top">
									<?php echo link_to(image_tag('admin/listdocs.jpeg'), url_for($ssModuleName.'/listDocuments?id_stonemason='.$asValues['user_id'].'&company='.$asValues['organisation']), 
												 array('title'=>__('List of Documents')));
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
