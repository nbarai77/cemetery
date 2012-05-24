<?php use_helper('pagination'); ?>
<div id="main" class="listtable bordernone">
    <div class="maintablebg">
        <?php 
            if(count($amArGraveList) > 0):  
                echo input_hidden_tag('admin_act');
                echo input_hidden_tag('idlinkgrave');
        ?>
                <table width="100%" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                        <tr>
                            <th width="2%" align="left" valign="top" class="none">&nbsp;</th>
							<th width="50%" align="left" valign="top" class="none">
							<?php   echo __('Grave Number'); ?>
							</th>
                            <th width="10%" align="left" valign="top" class="none">
							<?php   echo __('Area'); ?>
							</th>
                            <th width="10%" align="left" valign="top" class="none">
							<?php   echo __('Section'); ?>
							</th>
                            <th width="10%" align="left" valign="top" class="none">
							<?php   echo __('Plot'); ?>
							</th>
                            <th width="10%" align="left" valign="top" class="none">
							<?php   echo __('Grave'); ?>
							</th>
                        	<th width="10%" align="left" valign="top" class="none"><?php echo __('Actions');?></th>
							
                        </tr>

                        <?php foreach($sf_data->getRaw('amArGraveList') as $snKey=>$asValues): ?>
                            <tr class="<?php echo ($snKey%2 == 0) ? "even" : "odd";?>">
                                <td align="left" valign="top" class="checkStar">
                                    <?php  echo checkbox_tag('id[]',$asValues['id'], false, array('class'=>'','onclick'=>"uncheck(this,'all','$inactivateIds')"));?>
                                </td>
                                <td align="left" valign="top"> 
									<?php 
										echo $asValues['grave_id'];
									?>
								</td>
                                <td align="left" valign="top"> 
									<?php 
										echo ((isset($asValues['area_name']) && $asValues['area_name'] != '')?$asValues['area_name']:'N/A');
									?>
								</td>
                                <td align="left" valign="top"> 
									<?php 
                                        echo ((isset($asValues['section_name']) && $asValues['section_name'] !='' )?$asValues['section_name']:'N/A');									
									?>
								</td>
                                <td align="left" valign="top"> 
									<?php 
                                        echo ((isset($asValues['plot_name']) && $asValues['plot_name'] != '')?$asValues['plot_name']:'N/A');																			
									?>
								</td>
                                <td align="left" valign="top"> 
									<?php 
                                        echo ((isset($asValues['row_name']) && $asValues['row_name'] != '')?$asValues['row_name']:'N/A');																													
									?>
								</td>
                                <td align="left" valign="top">
                                    <div class="graveActions">
										<div class="fleft" style="padding-left:5px;">
		                                <?php 
		                                    echo link_to(image_tag('admin/edit.gif'),
		                                        $ssModuleName.'/addEditGraveLink?id='.$asValues['id'].'&'.html_entity_decode($amExtraParameters['ssQuerystr']),
		                                        array('title'=>__('Add More Grave') ,'class'=>'link1'));
		                                ?>
		                                </div>										
									</div>
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
