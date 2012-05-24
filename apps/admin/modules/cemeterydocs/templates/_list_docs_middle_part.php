<?php use_helper('pagination');
use_javascript('nyroModal/jquery.nyroModal.custom.js');
use_stylesheet('nyroModal/nyroModal');
?>
<div id="main" class="listtable">
    <div class="maintablebg">
        <?php 
            if(count($amCemeteryDocsList) > 0):  
                echo input_hidden_tag('admin_act');
                echo input_hidden_tag('idcemeterydocs');
	        ?>
                <table width="100%" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                        <tr>
							<th width="2%" align="left" valign="top" class="none">&nbsp;</th>
							<th width="20%" align="left" valign="top" class="none">
							<?php   echo __('Name'); ?>
							<div id="field_div_doc_name" class="assanding">
								<a href="javascript:void(0);"> <?php echo image_tag('admin/ass-a.gif');?> </a>
								<div id="sort_div_doc_name" class="inn_drupdownSort" style="display:none">
									<?php   
										include_partial(
											'global/sort_ajaxmain',
											array(
												'ssFieldName'       => 'doc_name',
												'ssLink'            => $ssModuleName.'/listDocuments?request_type=ajax_request',
												'amExtraParameters' => $amExtraParameters,
												'amSearch'          => $amSearch,                                
												'update_div'        => 'contentlisting',
											)
										);
									?>
								</div>
							</div>
							</th>						
							<th width="56%" align="left" valign="top" class="none">
								<?php   echo __('Description'); ?>							
							</th>
							<th width="5%" align="left" valign="top" class="none">
								<?php   echo __('Actions'); ?>
							</th>
                        </tr>

                        <?php foreach($sf_data->getRaw('amCemeteryDocsList') as $snKey=>$asValues): ?>
                            <tr class="<?php echo ($snKey%2 == 0) ? "even" : "odd";?>">
								<td align="left" valign="top" class="checkStar">
                                    <?php  echo checkbox_tag('id[]',$asValues['id'], false, array('class'=>'','onclick'=>"uncheck(this,'all','$inactivateIds')"));?>
                                </td>
								
                                <td align="left" valign="top"> <?php echo $asValues['doc_name']; ?> </td>
                                <td align="left" valign="top"> <?php echo $asValues['doc_description']; ?> </td>

								<td align="left" valign="top">
									<div id="actions">
										<div class="fleft">
										<?php
											echo link_to(image_tag('admin/download.jpeg'), $ssModuleName.'/listDocuments?type=download&filename='.base64_encode($asValues['doc_path']), 
												 array('title'=>__('Download Document')));
										?>
										</div>
										<?php if($sf_user->getAttribute('groupid') != sfConfig::get('app_cemrole_funeraldirector') && $sf_user->getAttribute('groupid') != sfConfig::get('app_cemrole_stonemason')): ?>
										<div class="fleft" style="margin-left:8px;">
										<?php
											echo link_to(image_tag('admin/mail.jpeg'), $ssModuleName.'/sendDocument?filename='.base64_encode($asValues['doc_path']), 
												 array('title'=>__('Send Document')));
										?>
										</div>										
										<div class="fleft" style="margin-left:8px;">
										<?php 
											echo link_to(image_tag('admin/edit.gif'),
												$ssModuleName.'/upload?id='.$asValues['id'].'&'.html_entity_decode($amExtraParameters['ssQuerystr']),
												array('title'=>__('Edit Cemetery') ,'class'=>'link1'));
										?>
										</div>
										 <?php endif; ?>
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
