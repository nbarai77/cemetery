<?php  use_javascript('/sfFormExtraPlugin/js/double_list.js');?>
<div id="wapper">
<?php 
    echo $oArGraveForm->renderFormTag(
        url_for($sf_params->get('module').'/'.$sf_params->get('action').(!$oArGraveForm->getObject()->isNew() ? '?id='.$oArGraveForm->getObject()->getId().'&'.html_entity_decode($amExtraParameters['ssQuerystr']) : '')), 
        array("name" => $oArGraveForm->getName(), "method" => "post" ,'enctype'=>'multipart/form-data')
    );
?>
    <div class="comment_list"></div>
    <h1><?php echo $oArGraveForm->getObject()->isNew() ?  __('Add Grave') : __('Edit Grave');?></h1>
    <div id="message">
        <div id="success_msgs">
            <?php echo include_partial('global/notification_msg', array('amSuccessMsg' => $amSuccessMsg,'amErrorMsg' => $amErrorMsg));?>
        </div>
    </div>
    <div class="clearb">&nbsp;</div>    
    <div id="main">
        <div class="maintablebg">
            <div class="main_cont">
                <div class="left_part">
            		<div id="info">
                		<table width="100%" border="0" cellspacing="0" cellpadding="0" class="sub_table">
							<tr>
								<td colspan="4">
								    <span class="fleft"><h1><?php echo __('Grave Details');?></h1></span>
								    <span class="fright"><h1><?php echo __('Monument Details');?></h1></span>
								</td>
							</tr>
                    		<?php if($sf_user->isSuperAdmin()):?>
							<tr>
                            	<td valign="middle" align="right" width="20%">
                                	<?php echo $oArGraveForm['country_id']->renderLabel($oArGraveForm['country_id']->renderLabelName()."<span class='redText'>*</span>");?>
                        		</td>
	
                            	<td valign="middle" width="25%">
                                	<?php 
                                	    if($oArGraveForm['country_id']->hasError()):
                                    	    echo $oArGraveForm['country_id']->renderError();
                                        endif;
									    echo $oArGraveForm['country_id']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>
								<td valign="middle" align="right" >
                                	<?php echo $oArGraveForm['monuments_grave_position']->renderLabel($oArGraveForm['monuments_grave_position']->renderLabelName());?>
                        		</td>
	
                            	<td valign="middle"  colspan="3">
                                	<?php 
                                	    if($oArGraveForm['monuments_grave_position']->hasError()):
                                    	    echo $oArGraveForm['monuments_grave_position']->renderError();
                                        endif;
									    echo $oArGraveForm['monuments_grave_position']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>
                    		</tr>	
                    								
							<tr>
                            	<td valign="middle" align="right" width="20%">
									<?php echo __('Select Cementery')."<span class='redText'>*</span>"?>
                        		</td>
	
                            	<td valign="middle" width="25%">
                                	<?php 
										if($sf_user->hasFlash('ssErrorCemeter') && $sf_user->getFlash('ssErrorCemeter') != ''):
											echo '<ul class="error_list"><li>'.$sf_user->getFlash('ssErrorCemeter').'</li></ul>';
											$sf_user->setFlash('ssErrorCemeter','');
										endif;
										include_partial('getCementeryList', array('asCementryList' => $asCementery,'snCementeryId' => $snCementeryId)); 
								    ?>
                                </td>
								<td valign="middle" align="left" width="20%">
									<?php echo $oArGraveForm['monument']->renderLabel($oArGraveForm['monument']->renderLabelName());?>
								</td>	
								<td valign="middle" width="25%">
									<?php 
										if($oArGraveForm['monument']->hasError()):
											echo $oArGraveForm['monument']->renderError();
										endif;
										echo $oArGraveForm['monument']->render(array('class'=>'inputBoxWidth')); 
									?>
								</td>								                            
                    		</tr>							
							<?php endif;?>
							
							<tr>
                            	<td valign="middle" align="right" width="20%">
									<?php echo __('Select Area');?>
                        		</td>
	
                            	<td valign="middle" width="25%">
                                	<?php 
										if($sf_user->hasFlash('ssErrorArea') && $sf_user->getFlash('ssErrorArea') != ''):
											echo '<ul class="error_list"><li>'.$sf_user->getFlash('ssErrorArea').'</li></ul>';
											$sf_user->setFlash('ssErrorArea','');
										endif;
										include_partial('getAreaList', array('asAreaList' => $asAreaList,'snAreaId' => $snAreaId)); 
								    ?>
                                </td>
								<?php if(!$sf_user->isSuperAdmin()):?>
								<td valign="middle" align="right" >
                                	<?php echo $oArGraveForm['monuments_grave_position']->renderLabel($oArGraveForm['monuments_grave_position']->renderLabelName());?>
                        		</td>
	
                            	<td valign="middle"  colspan="3">
                                	<?php 
                                	    if($oArGraveForm['monuments_grave_position']->hasError()):
                                    	    echo $oArGraveForm['monuments_grave_position']->renderError();
                                        endif;
									    echo $oArGraveForm['monuments_grave_position']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>
								<?php else:?>
                                <td valign="middle" align="right" >
                                	<?php //echo $oArGraveForm['monuments_unit_type']->renderLabel($oArGraveForm['monuments_unit_type']->renderLabelName());?>
                        		</td>	
                            	<td valign="middle" >
                                	<h2><?php echo __("Internals"); ?></h2>
                                </td>
								<?php endif;?>
                    		</tr>
                    		
							<tr>
                            	<td valign="middle" align="right" width="20%">
									<?php echo __('Select Section');?>
                        		</td>
	
                            	<td valign="middle" width="25%">
                                	<?php 
										if($sf_user->hasFlash('ssErrorSection') && $sf_user->getFlash('ssErrorSection') != ''):
											echo '<ul class="error_list"><li>'.$sf_user->getFlash('ssErrorSection').'</li></ul>';
											$sf_user->setFlash('ssErrorSection','');
										endif;
										include_partial('getSectionList', array('asSectionList' => $asSectionList,'snSectionId' => $snSectionId)); 
								    ?>
                                </td>
								
								<?php if(!$sf_user->isSuperAdmin()):?>
								<td valign="middle" align="left" width="20%">
									<?php echo $oArGraveForm['monument']->renderLabel($oArGraveForm['monument']->renderLabelName());?>
								</td>	
								<td valign="middle" width="25%">
									<?php 
										if($oArGraveForm['monument']->hasError()):
											echo $oArGraveForm['monument']->renderError();
										endif;
										echo $oArGraveForm['monument']->render(array('class'=>'inputBoxWidth')); 
									?>
								</td>
								<?php else:?>
                                <td valign="middle" align="right" >
                                	<?php echo $oArGraveForm['monuments_unit_type']->renderLabel($oArGraveForm['monuments_unit_type']->renderLabelName());?>
                        		</td>	
                            	<td valign="middle" >
                                	<?php 
                                	    if($oArGraveForm['monuments_unit_type']->hasError()):
                                    	    echo $oArGraveForm['monuments_unit_type']->renderError();
                                        endif;
									    echo $oArGraveForm['monuments_unit_type']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>								
								
								

								<?php endif;?>
                    		</tr>
							<tr>
                            	<td valign="middle" align="right" width="20%">
									<?php echo __('Select Row');?>
                        		</td>
	
                            	<td valign="middle" width="25%">
                                	<?php 
										if($sf_user->hasFlash('ssErrorRow') && $sf_user->getFlash('ssErrorRow') != ''):
											echo '<ul class="error_list"><li>'.$sf_user->getFlash('ssErrorRow').'</li></ul>';
											$sf_user->setFlash('ssErrorRow','');
										endif;
										include_partial('getRowList', array('asRowList' => $asRowList,'snRowId' => $snRowId)); 
								    ?>
                                </td>
								<?php if(!$sf_user->isSuperAdmin()):?>
								<td valign="middle" align="right" >
                                	<?php //echo $oArGraveForm['monuments_unit_type']->renderLabel($oArGraveForm['monuments_unit_type']->renderLabelName());?>
                        		</td>	
                            	<td valign="middle" >
									<h2><?php echo __("Internals"); ?></h2>
                                </td>
								<?php else:?>
                                <td valign="middle" align="right" >
                                	<?php echo $oArGraveForm['monuments_depth']->renderLabel($oArGraveForm['monuments_depth']->renderLabelName());?>
                        		</td>	
                            	<td valign="middle" >
                                	<?php 
                                	    if($oArGraveForm['monuments_depth']->hasError()):
                                    	    echo $oArGraveForm['monuments_depth']->renderError();
                                        endif;
									    echo $oArGraveForm['monuments_depth']->render(array('class'=>'inputBoxWidth')); 
								    ?>
								</td>																

								<?php endif;?>
                    		</tr>
							<tr>
                            	<td valign="middle" align="right" width="20%">
									<?php echo __('Select Plot');?>
                        		</td>
	
                            	<td valign="middle" width="25%">
                                	<?php 
										if($sf_user->hasFlash('ssErrorPlot') && $sf_user->getFlash('ssErrorPlot') != ''):
											echo '<ul class="error_list"><li>'.$sf_user->getFlash('ssErrorPlot').'</li></ul>';
											$sf_user->setFlash('ssErrorPlot','');
										endif;
										include_partial('getPlotList', array('asPlotList' => $asPlotList,'snPlotId' => $snPlotId)); 
								    ?>
                                </td>
								<?php if(!$sf_user->isSuperAdmin()):?>
								<td valign="middle" align="right" >
                                	<?php echo $oArGraveForm['monuments_unit_type']->renderLabel($oArGraveForm['monuments_unit_type']->renderLabelName());?>
                        		</td>	
                            	<td valign="middle" >
                                	<?php 
                                	    if($oArGraveForm['monuments_unit_type']->hasError()):
                                    	    echo $oArGraveForm['monuments_unit_type']->renderError();
                                        endif;
									    echo $oArGraveForm['monuments_unit_type']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>								

								<?php else:?>
                                <td valign="middle" align="right" >
                                	<?php echo $oArGraveForm['monuments_length']->renderLabel($oArGraveForm['monuments_length']->renderLabelName());?>
                        		</td>	
                            	<td valign="middle" >
                                	<?php 
                                	    if($oArGraveForm['monuments_length']->hasError()):
                                    	    echo $oArGraveForm['monuments_length']->renderError();
                                        endif;
									    echo $oArGraveForm['monuments_length']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>								

								<?php endif;?>
                    		</tr>

							<tr>
                            	<td valign="middle" align="right" width="20%">
                                	<?php echo $oArGraveForm['grave_number']->renderLabel($oArGraveForm['grave_number']->renderLabelName()."<span class='redText'>*</span>");?>
                        		</td>
								<?php $ssColumnStyle = ($sf_user->isSuperAdmin()) ? 'colspan="3"' : '';?>
                            	<td valign="middle" width="25%" <?php //echo $ssColumnStyle?>>
                                	<?php 
                                	    if($oArGraveForm['grave_number']->hasError()):
                                    	    echo $oArGraveForm['grave_number']->renderError();
                                        endif;
									    echo $oArGraveForm['grave_number']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>
                                
                                <?php if(!$sf_user->isSuperAdmin()):?>
								<td valign="middle" align="right" >
                                	<?php echo $oArGraveForm['monuments_depth']->renderLabel($oArGraveForm['monuments_depth']->renderLabelName());?>
                        		</td>	
                            	<td valign="middle" >
                                	<?php 
                                	    if($oArGraveForm['monuments_depth']->hasError()):
                                    	    echo $oArGraveForm['monuments_depth']->renderError();
                                        endif;
									    echo $oArGraveForm['monuments_depth']->render(array('class'=>'inputBoxWidth')); 
								    ?>
								</td>                                
                                <?php else: ?>
                                <td valign="middle" align="right" >
                                	<?php echo $oArGraveForm['monuments_width']->renderLabel($oArGraveForm['monuments_width']->renderLabelName());?>
                        		</td>	
                            	<td valign="middle" >
                                	<?php 
                                	    if($oArGraveForm['monuments_width']->hasError()):
                                    	    echo $oArGraveForm['monuments_width']->renderError();
                                        endif;
									    echo $oArGraveForm['monuments_width']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>                                
                                
								<?php endif;?>
                    		</tr>
							<tr>
                            	<td valign="middle" align="right" width="20%">
                                	<?php echo $oArGraveForm['ar_grave_status_id']->renderLabel($oArGraveForm['ar_grave_status_id']->renderLabelName()."<span class='redText'>*</span>");?>
                        		</td>
	
                            	<td valign="middle" width="40%">
                                	<?php 
                                	    if($oArGraveForm['ar_grave_status_id']->hasError()):
                                    	    echo $oArGraveForm['ar_grave_status_id']->renderError();
                                        endif;
									    echo $oArGraveForm['ar_grave_status_id']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>
                                <?php if(!$sf_user->isSuperAdmin()):?>
								<td valign="middle" align="right" >
                                	<?php echo $oArGraveForm['monuments_length']->renderLabel($oArGraveForm['monuments_length']->renderLabelName());?>
                        		</td>	
                            	<td valign="middle" >
                                	<?php 
                                	    if($oArGraveForm['monuments_length']->hasError()):
                                    	    echo $oArGraveForm['monuments_length']->renderError();
                                        endif;
									    echo $oArGraveForm['monuments_length']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>
								<?php else:?>
								<td valign="middle" align="right" >
                                	<?php echo $oArGraveForm['comment1']->renderLabel($oArGraveForm['comment1']->renderLabelName());?>
                        		</td>	
                            	<td valign="middle">
                                	<?php 
                                	    if($oArGraveForm['comment1']->hasError()):
                                    	    echo $oArGraveForm['comment1']->renderError();
                                        endif;
									    echo $oArGraveForm['comment1']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>
								<?php endif;?>
                    		</tr>
							<?php if($oArGraveForm->isNew()):?>
							<tr>
                            	<td valign="middle" align="right" width="20%">
                                	<?php echo $oArGraveForm['grantee_unique_id']->renderLabel($oArGraveForm['grantee_unique_id']->renderLabelName());?>
                        		</td>
	
                            	<td valign="middle" width="25%">
                                	<?php
										if($sf_user->hasFlash('ssErrorGranteeNotExists') && $sf_user->getFlash('ssErrorGranteeNotExists') != ''):
											echo '<ul class="error_list"><li>'.$sf_user->getFlash('ssErrorGranteeNotExists').'</li></ul>';
											$sf_user->setFlash('ssErrorGranteeNotExists','');
										endif;
									    echo $oArGraveForm['grantee_unique_id']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>
                                
                                <?php if(!$sf_user->isSuperAdmin()):?>
								<td valign="middle" align="right" >
                                	<?php echo $oArGraveForm['monuments_width']->renderLabel($oArGraveForm['monuments_width']->renderLabelName());?>
                        		</td>	
                            	<td valign="middle" >
                                	<?php 
                                	    if($oArGraveForm['monuments_width']->hasError()):
                                    	    echo $oArGraveForm['monuments_width']->renderError();
                                        endif;
									    echo $oArGraveForm['monuments_width']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>
								<?php else:?>
								<td valign="middle" align="right" >
                                	<?php echo $oArGraveForm['comment2']->renderLabel($oArGraveForm['comment2']->renderLabelName());?>
                        		</td>	
                            	<td valign="middle">
                                	<?php 
                                	    if($oArGraveForm['comment2']->hasError()):
                                    	    echo $oArGraveForm['comment2']->renderError();
                                        endif;
									    echo $oArGraveForm['comment2']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>
                                <?php endif;?>
                    		</tr>
							<?php endif;?>
							
							<tr>
                            	<td valign="middle" align="right" width="20%">
                                	<?php echo $oArGraveForm['grave_image1']->renderLabel($oArGraveForm['grave_image1']->renderLabelName());?>
                        		</td>
								<?php if($oArGraveForm->isNew() && $sf_user->isSuperAdmin()):?>
									<td valign="middle" width="40%" colspan="3">
								<?php else: ?>	
									<td valign="middle" width="25%" colspan="">
								<?php endif;?>	
                                	<?php 
                                	    if($oArGraveForm['grave_image1']->hasError()):
                                    	    echo $oArGraveForm['grave_image1']->renderError();
                                        endif;
									    echo $oArGraveForm['grave_image1']->render(array('class'=>'inputBoxWidth'));
										//if(!$oArGraveForm->getObject()->isNew() && $oArGraveForm->getObject()->getGraveImage1() != '')
											//echo image_tag(sfConfig::get('app_upload_dir').'/'.sfConfig::get('app_graveimages_thumbnail_dir').'/'.$oArGraveForm->getObject()->getGraveImage1());
								    ?>
                                </td>
                                <?php if(!$oArGraveForm->isNew() && !$sf_user->isSuperAdmin()):?>
								<td valign="middle" align="right" >
                                	<?php echo $oArGraveForm['monuments_width']->renderLabel($oArGraveForm['monuments_width']->renderLabelName());?>
                        		</td>	
                            	<td valign="middle" >
                                	<?php 
                                	    if($oArGraveForm['monuments_width']->hasError()):
                                    	    echo $oArGraveForm['monuments_width']->renderError();
                                        endif;
									    echo $oArGraveForm['monuments_width']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>
								<?php elseif($oArGraveForm->isNew() && !$sf_user->isSuperAdmin()):?>
								<td valign="middle" align="right" >
                                	<?php echo $oArGraveForm['comment1']->renderLabel($oArGraveForm['comment1']->renderLabelName());?>
                        		</td>	
                            	<td valign="middle" >
                                	<?php 
                                	    if($oArGraveForm['comment1']->hasError()):
                                    	    echo $oArGraveForm['comment1']->renderError();
                                        endif;
									    echo $oArGraveForm['comment1']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>
								<?php elseif(!$oArGraveForm->isNew() && $sf_user->isSuperAdmin()):?>
								<td valign="middle" align="right" >
                                	<?php echo $oArGraveForm['comment2']->renderLabel($oArGraveForm['comment2']->renderLabelName());?>
                        		</td>	
                            	<td valign="middle" >
                                	<?php 
                                	    if($oArGraveForm['comment2']->hasError()):
                                    	    echo $oArGraveForm['comment2']->renderError();
                                        endif;
									    echo $oArGraveForm['comment2']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>
                                <?php endif;?>
                    		</tr>
							<tr>
                            	<td valign="middle" align="right" width="20%">
                                	<?php echo $oArGraveForm['grave_image2']->renderLabel($oArGraveForm['grave_image2']->renderLabelName());?>
                        		</td>
	
                            	<?php if(!$oArGraveForm->isNew() && $sf_user->isSuperAdmin()):?>
									<td valign="middle" width="40%" colspan="3">
								<?php else: ?>	
									<td valign="middle" width="25%" colspan="">
								<?php endif;?>	
                                	<?php 
                                	    if($oArGraveForm['grave_image2']->hasError()):
                                    	    echo $oArGraveForm['grave_image2']->renderError();
                                        endif;
									    echo $oArGraveForm['grave_image2']->render(array('class'=>'inputBoxWidth'));
										//if(!$oArGraveForm->getObject()->isNew() && $oArGraveForm->getObject()->getGraveImage2() != '')
											//echo image_tag(sfConfig::get('app_upload_dir').'/'.sfConfig::get('app_graveimages_thumbnail_dir').'/'.$oArGraveForm->getObject()->getGraveImage2());
								    ?>
                                </td>
								<?php if(!$oArGraveForm->isNew() && !$sf_user->isSuperAdmin()):?>
								<td valign="middle" align="right" >
                                	<?php echo $oArGraveForm['comment1']->renderLabel($oArGraveForm['comment1']->renderLabelName());?>
                        		</td>	
                            	<td valign="middle" >
                                	<?php 
                                	    if($oArGraveForm['comment1']->hasError()):
                                    	    echo $oArGraveForm['comment1']->renderError();
                                        endif;
									    echo $oArGraveForm['comment1']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>
								<?php elseif($oArGraveForm->isNew() && !$sf_user->isSuperAdmin()):?>
								<td valign="middle" align="right" >
                                	<?php echo $oArGraveForm['comment2']->renderLabel($oArGraveForm['comment2']->renderLabelName());?>
                        		</td>	
                            	<td valign="middle" >
                                	<?php 
                                	    if($oArGraveForm['comment2']->hasError()):
                                    	    echo $oArGraveForm['comment2']->renderError();
                                        endif;
									    echo $oArGraveForm['comment2']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>
                                <?php endif;?>
                    		</tr>
							<tr>
                            	<td valign="middle" align="right" width="20%">
                                	<?php echo $oArGraveForm['length']->renderLabel($oArGraveForm['length']->renderLabelName() );?>
                        		</td>
								<?php $ssColspanStyle = ( ($oArGraveForm->isNew() && !$sf_user->isSuperAdmin()) || ($oArGraveForm->isNew() && $sf_user->isSuperAdmin()) ) ? 'colspan="3"' : ''; ?>
                            	<td valign="middle" width="40%" <?php echo $ssColspanStyle;?> >
								<?php 
                                	    if($oArGraveForm['length']->hasError()):
                                    	    echo $oArGraveForm['length']->renderError();
                                        endif;
									    echo $oArGraveForm['length']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>
                                <?php if(!$oArGraveForm->isNew() && !$sf_user->isSuperAdmin()):?>
								<td valign="middle" align="right" >
                                	<?php echo $oArGraveForm['comment2']->renderLabel($oArGraveForm['comment2']->renderLabelName());?>
                        		</td>	
                            	<td valign="middle" >
                                	<?php 
                                	    if($oArGraveForm['comment2']->hasError()):
                                    	    echo $oArGraveForm['comment2']->renderError();
                                        endif;
									    echo $oArGraveForm['comment2']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>
                                <?php endif;?>
                    		</tr>
							<tr>
                            	<td valign="middle" align="right" width="20%">
                                	<?php echo $oArGraveForm['width']->renderLabel($oArGraveForm['width']->renderLabelName() );?>
                        		</td>
	
                            	<td valign="middle" width="40%" colspan="3">
                                	<?php 
                                	    if($oArGraveForm['width']->hasError()):
                                    	    echo $oArGraveForm['width']->renderError();
                                        endif;
									    echo $oArGraveForm['width']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>
                                
                    		</tr>
							<tr>
                            	<td valign="middle" align="right" width="20%">
                                	<?php echo $oArGraveForm['height']->renderLabel($oArGraveForm['height']->renderLabelName() );?>
                        		</td>
	
                            	<td valign="middle" width="40%" colspan="3">
                                	<?php 
                                	    if($oArGraveForm['height']->hasError()):
                                    	    echo $oArGraveForm['height']->renderError();
                                        endif;
									    echo $oArGraveForm['height']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>
                                
                    		</tr>
							<tr>
                            	<td valign="middle" align="right" width="20%">
                                	<?php echo $oArGraveForm['unit_type_id']->renderLabel($oArGraveForm['unit_type_id']->renderLabelName());?>
                        		</td>
	
                            	<td valign="middle" width="40%" colspan="3">
                                	<?php 
                                	    if($oArGraveForm['unit_type_id']->hasError()):
                                    	    echo $oArGraveForm['unit_type_id']->renderError();
                                        endif;
									    echo $oArGraveForm['unit_type_id']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>
                                
                    		</tr>
							<tr>
                            	<td valign="middle" align="right" width="20%">
                                	<?php echo $oArGraveForm['cem_stonemason_id']->renderLabel($oArGraveForm['cem_stonemason_id']->renderLabelName());?>
                        		</td>
	
                            	<td valign="middle" width="40%" colspan="3">
                                	<?php 
                                	    if($oArGraveForm['cem_stonemason_id']->hasError()):
                                    	    echo $oArGraveForm['cem_stonemason_id']->renderError();
                                        endif;
									    echo $oArGraveForm['cem_stonemason_id']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>
                                
                    		</tr>                    		
							<tr>
                            	<td valign="middle" align="right" width="20%">
                                	<?php echo $oArGraveForm['details']->renderLabel($oArGraveForm['details']->renderLabelName() );?>
                        		</td>
	
                            	<td valign="middle" width="40%" colspan="3">
                                	<?php 
                                	    if($oArGraveForm['details']->hasError()):
                                    	    echo $oArGraveForm['details']->renderError();
                                        endif;
									    echo $oArGraveForm['details']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>                                
                    		</tr>
							<tr>
                            	<td valign="middle" align="right" width="20%">
                                	<?php echo $oArGraveForm['latitude']->renderLabel($oArGraveForm['latitude']->renderLabelName() );?>
                        		</td>
	
                            	<td valign="middle" width="40%" colspan="3">
                                	<?php 
                                	    if($oArGraveForm['latitude']->hasError()):
                                    	    echo $oArGraveForm['latitude']->renderError();
                                        endif;
									    echo $oArGraveForm['latitude']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>                                
                    		</tr>
							<tr>
                            	<td valign="middle" align="right" width="20%">
                                	<?php echo $oArGraveForm['longitude']->renderLabel($oArGraveForm['longitude']->renderLabelName() );?>
                        		</td>
	
                            	<td valign="middle" width="40%" colspan="3">
                                	<?php 
                                	    if($oArGraveForm['longitude']->hasError()):
                                    	    echo $oArGraveForm['longitude']->renderError();
                                        endif;
									    echo $oArGraveForm['longitude']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>                                
                    		</tr>
							<tr>
								<td valign="middle">
									<?php echo $oArGraveForm['is_enabled']->renderLabel($oArGraveForm['is_enabled']->renderLabelName());?>
								</td>
								<td valign="middle" colspan="3"> <?php echo $oArGraveForm['is_enabled']->render();?> </td>
							</tr>
                    		<tr>
                            	<td>&nbsp;</td>
                        		<td valign="middle" colspan="3">
                                	<div class="actions">
                                		<ul class="fleft">
                                        	<li class="list1">
                                        		<span>
	                                                <?php 
	                                                    echo submit_tag(
	                                                        __('Save'), 
	                                                        array(
	                                                            'class'     => 'delete',
	                                                            'name'      => 'submit_button',
	                                                            'title'     => __('Save'), 
	                                                            'tabindex'  => 30,
	                                                            'onclick'   => "jQuery('#tab').val('');"
	                                                        )
	                                                    );
	                                                ?>
                                        		</span>
                                        	</li>
                                			<li class="list1">
                                        		<span>
                                        			<?php  
														if($sf_params->get('back') == true):
															$ssCancelUrl = 'gravesearch/addedit?back=true&'.html_entity_decode($amExtraParameters['ssQuerystr']);
														else:	
															$ssCancelUrl = $sf_params->get('module').'/index?'.html_entity_decode($amExtraParameters['ssQuerystr']);
														endif;
															
                                                		echo button_to(__('Cancel'),$ssCancelUrl,array('class'=>'delete','title'=>__('Cancel'),'alt'=>__('Cancel'),'tabindex'=>31));
                                                    ?>
                                    			</span>
                                    		</li>
                            			</ul>
                                	</div>
                        		</td>
                                
                        	</tr>
                		</table>
            		</div>

                </div>
                <div class="clearb"></div>
            </div>
        </div>
    </div>
    <div class="clearb">&nbsp;</div>
    <div class="clearb">&nbsp;</div>
    <?php
        echo input_hidden_tag('id', $sf_params->get('id'), array('readonly' => 'true'));
        echo input_hidden_tag('back', $sf_params->get('back'), array('readonly' => 'true'));
        echo input_hidden_tag('tab', ($sf_params->get('tab') ? $sf_params->get('tab') :'info'), array('readonly' => 'true'));
        echo $oArGraveForm->renderHiddenFields(); 
    ?>
    </form>
</div>
<?php 

	if(!$sf_user->isSuperAdmin() && $oArGraveForm->getObject()->isNew() && !sfContext::getInstance()->getRequest()->isMethod('post'))
	{
		$snCemeteryId = $sf_user->getAttribute('cemeteryid');
		 echo javascript_tag("
			jQuery(document).ready(function() 
				{
					".
					// Ger area, section, row, plot list as per cemetery.
					jq_remote_function(
					array('url'		=> url_for('grave/getAreaListAsPerCemetery'),
						  'update'	=> 'grave_area_list',
						  'with'	=> "'cemetery_id='+".$snCemeteryId."+'&country_id='+$('#grave_country_id').val()",
						  'loading' => '$("#IdAjaxLocaderArea").show();',
						  'complete'=> '$("#IdAjaxLocaderArea").hide();'.jq_remote_function(
									array('url'		=> url_for('grave/getSectionListAsPerArea'),
										  'update'	=> 'grave_section_list',
										  'with'	=> "'country_id='+$('#grave_country_id').val()+'&cemetery_id='+$('#grave_cem_cemetery_id').val()",
										  'loading' => '$("#IdAjaxLocaderSection").show();',
										  'complete'=> '$("#IdAjaxLocaderSection").hide();'.jq_remote_function(
													array('url'		=> url_for('grave/getRowListAsPerSection'),
														  'update'	=> 'grave_row_list',
														  'with'	=> "'country_id='+$('#grave_country_id').val()+'&cemetery_id='+$('#grave_cem_cemetery_id').val()",
														  'loading' => '$("#IdAjaxLocaderRow").show();',
														  'complete'=> '$("#IdAjaxLocaderRow").hide();'.jq_remote_function(
																		array('url'		=> url_for('grave/getPlotListAsPerRow'),
																			  'update'	=> 'grave_plot_list',
																			  'with'	=> "'country_id='+$('#grave_country_id').val()+'&cemetery_id='+$('#grave_cem_cemetery_id').val()",
																			  'loading' => '$("#IdAjaxLocaderPlot").show();',
																			  'complete'=> '$("#IdAjaxLocaderPlot").hide();'))
													))
									))
					))	
					."
				});
			");
	}
	
    echo javascript_tag('
        ssTags = document.getElementsByTagName("select");
        document.getElementById(ssTags[1].id).focus();'
    );
    
    echo javascript_tag("
        jQuery(document).ready(function() 
		{
			var snCountryId = jQuery('#grave_country_id').val();
			var snCemeteryId = $('#grave_cem_cemetery_id option').length;
			if(snCountryId > 0 && snCemeteryId == 1)
				callAjaxRequest(snCountryId,'".url_for('grave/getCementryListAsPerCountry')."','grave_cemetery_list');
		});
        function tabSelection(id, ssClassName)
        { 
            var asTabs      = new Array('user_info','user_permission');
            var asUpdateDiv = new Array('info','permission'); 
            
            for(var i=0;i<asTabs.length;i++)
            {
	            jQuery('#' + asTabs[i] ).removeClass(ssClassName);
            }
            
            jQuery('#user_' + id).addClass(ssClassName);
            
            for(var i=0;i<asUpdateDiv.length;i++)
            {
                jQuery('#' + asUpdateDiv[i] ).attr('style','display:none');
            }

            jQuery('#' + id).attr('style','display:block');
        }
    ");
?>

<?php
    echo javascript_tag("
        jQuery(document).ready(function() 
            {
				$('table').find('tr:visible:odd').addClass('even').end().find('tr:visible:even').addClass('odd');
                
            });
    ");
?>
