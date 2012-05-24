<?php use_helper('pagination');
use_javascript('nyroModal/jquery.nyroModal.custom.js');
use_stylesheet('nyroModal/nyroModal');
?>
<div id="main" class="listtable">
    <div class="maintablebg">
        <?php 
            if(count($amStonemasonDocsList) > 0):  
                echo input_hidden_tag('admin_act');
                echo input_hidden_tag('idstonemasondocs');
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
							<th width="10%" align="left" valign="top" class="none">
								<?php   echo __('Expiry Date'); ?>
							</th>
							<th width="5%" align="center" valign="top" class="none">
								<?php   echo __('Download'); ?>
							</th>
							<?php if($sf_user->getAttribute('groupid') == 6): ?>
								<th width="5%" align="left" valign="top" class="none">&nbsp;</th>
							<?php endif; ?>	
                        </tr>

                        <?php foreach($sf_data->getRaw('amStonemasonDocsList') as $snKey=>$asValues): ?>
                            <tr class="<?php echo ($snKey%2 == 0) ? "even" : "odd";?>">
								<td align="left" valign="top" class="checkStar">
                                    <?php  echo checkbox_tag('id[]',$asValues['id'], false, array('class'=>'','onclick'=>"uncheck(this,'all','$inactivateIds')"));?>
                                </td>
								<?php
									$ssExpirydate = '00-00-0000';
									
									if($asValues['expiry_date'] != '' && $asValues['expiry_date'] != '0000-00-00'):
										list($snYear,$snMonth,$snDay) = explode('-',$asValues['expiry_date']);
										$ssExpirydate = $snDay.'-'.$snMonth.'-'.$snYear;
									endif;									
								?>
                                <td align="left" valign="top"> <?php echo $asValues['doc_name']; ?> </td>
                                <td align="left" valign="top"> <?php echo $asValues['doc_description']; ?> </td>
								<td align="left" valign="top"> <?php echo $ssExpirydate; ?> </td>

								<td align="center" valign="top">
                                    <?php
										echo link_to(image_tag('admin/download.jpeg'), $ssModuleName.'/listDocuments?id_stonemason='.$snStoneMasonId.'&type=download&filename='.base64_encode($asValues['doc_path']), 
											 array('title'=>__('Download')));
									?>
                                </td>
								<?php if($sf_user->getAttribute('groupid') == 6): ?>
									 <td align="center" valign="top">
										<?php 
											echo link_to(image_tag('admin/edit.gif'),
												$ssModuleName.'/upload?id='.$asValues['id'].'&'.html_entity_decode($amExtraParameters['ssQuerystr']),
												array('title'=>__('Edit Cemetery') ,'class'=>'link1'));
										?>
									</td>
								<?php endif; ?>	
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
