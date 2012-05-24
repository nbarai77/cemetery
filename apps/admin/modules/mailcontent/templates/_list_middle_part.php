<?php use_helper('pagination'); 
use_javascript('nyroModal/jquery.nyroModal.custom.js');
use_stylesheet('nyroModal/nyroModal');
?>
<div id="main" class="listtable">
    <div class="maintablebg">
        <?php 
            if(count($amMailContentList) > 0):  
                echo input_hidden_tag('admin_act');
                echo input_hidden_tag('idmailcontent');
        ?>
                <table width="100%" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                        <tr>
                            <th width="80%" align="left" valign="top" class="none">
                                <?php   echo __('Subject'); ?>
                                <div id="field_div_subject" class="assanding">
                                    <a href="javascript:void(0);"> <?php echo image_tag('admin/ass-a.gif');?> </a>
                                    <div id="sort_div_subject" class="inn_drupdownSort" style="display:none">
                                        <?php   
                                            include_partial(
                                                'global/sort_ajaxmain',
                                                array(
                                                    'ssFieldName'       => 'subject',
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
							<?php $snWidth= (($sf_params->get('type') == 'common_letter')?4:2)?>
                            <th width="<?php echo $snWidth?>%" align="left" valign="top" class="none">&nbsp;</th>
                        </tr>

                        <?php foreach($sf_data->getRaw('amMailContentList') as $snKey=>$asValues): ?>
                            <tr class="<?php echo ($snKey%2 == 0) ? "even" : "odd";?>">
                                <td align="left" valign="top"> 
									<?php echo link_to($asValues['subject'],url_for($ssModuleName.'/addedit?id='.$asValues['id'].'&'.html_entity_decode($amExtraParameters['ssQuerystr'])),
												array('title' => $asValues['subject'],'class' => 'link1'));?>
								</td>
								
                                <td align="center" valign="top">
								<div class="fleft" style="padding-left:5px;">
                                   <?php 
								   if($sf_params->get('type') == 'common_letter')
									{
										echo link_to(image_tag('admin/pdf.jpg'),
												 url_for('mailcontent/selectdate?id_letter='.$asValues['id']),
												array('title'=> __('Generate PDF'),'class'=>'nyroModal link1','id'=>'nyroLetter'));
									}
									
		/*							echo link_to_function(image_tag('admin/pdf.jpg'),"letterAction('".url_for('mailcontent/printcommonletter?id='.$asValues['id'])."');", 
												array('title' => __('Print'),'tabindex'=> 78 )
											);
									} */
									?>
									</div>
									<div class="fleft" style="padding-left:5px;">
									<?php									 
                                        echo link_to(image_tag('admin/edit.gif'),
                                            $ssModuleName.'/addedit?id='.$asValues['id'].'&'.html_entity_decode($amExtraParameters['ssQuerystr']),
                                            array('title'=>__('Edit Letter') ,'class'=>'link1'));
                                    ?>
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
