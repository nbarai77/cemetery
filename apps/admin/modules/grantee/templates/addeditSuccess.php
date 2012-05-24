<?php  use_javascript('/sfFormExtraPlugin/js/double_list.js');
use_javascript('jquery-ui-timepicker-addon.js');
use_stylesheet('jquery-ui-timepicker-addon.css');
?>

<div id="wapper">
<?php 
    echo $oGranteeForm->renderFormTag(
        url_for($sf_params->get('module').'/'.$sf_params->get('action').(!$oGranteeForm->getObject()->isNew() ? '?id='.$oGranteeForm->getObject()->getId().'&'.html_entity_decode($amExtraParameters['ssQuerystr']) : '')), 
        array("name" => $oGranteeForm->getName(), "method" => "post" ,'enctype'=>'multipart/form-data')
    );
?>
    <div class="comment_list"></div>
    <h1><?php echo $oGranteeForm->getObject()->isNew() ?  __('Add New Grantee Grave') : __('Edit Grantee Grave'). __(' of')." ".$oGranteeDetails->getGranteeFirstName()." ".$oGranteeDetails->getGranteeSurname();?></h1>
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
							<?php if($sf_user->isSuperAdmin()):?>
							<tr>
                            	<td valign="middle" align="right" width="20%">
                                	<?php echo $oGranteeForm['cem_cemetery_id']->renderLabel($oGranteeForm['cem_cemetery_id']->renderLabelName()."<span class='redText'>*</span>");?>
                        		</td>
	
                            	<td valign="middle" width="80%">
                                	<?php 
                                	    if($oGranteeForm['cem_cemetery_id']->hasError()):
                                    	    echo $oGranteeForm['cem_cemetery_id']->renderError();
                                        endif;
									    echo $oGranteeForm['cem_cemetery_id']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>
                    		</tr>
							<?php endif;?>
							<tr>
                            	<td valign="middle" align="right" width="20%">
									<?php echo __('Select Area');?>
                        		</td>
	
                            	<td valign="middle" width="80%">
                                	<?php 
										if($sf_user->hasFlash('ssErrorArea') && $sf_user->getFlash('ssErrorArea') != ''):
											echo '<ul class="error_list"><li>'.$sf_user->getFlash('ssErrorArea').'</li></ul>';
											$sf_user->setFlash('ssErrorArea','');
										endif;
										include_partial('getAreaList', array('asAreaList' => $asAreaList,'snAreaId' => $snAreaId)); 
								    ?>
                                </td>
                    		</tr>
							<tr>
                            	<td valign="middle" align="right" width="20%">
									<?php echo __('Select Section');?>
                        		</td>
	
                            	<td valign="middle" width="80%">
                                	<?php 
										if($sf_user->hasFlash('ssErrorSection') && $sf_user->getFlash('ssErrorSection') != ''):
											echo '<ul class="error_list"><li>'.$sf_user->getFlash('ssErrorSection').'</li></ul>';
											$sf_user->setFlash('ssErrorSection','');
										endif;
										include_partial('getSectionList', array('asSectionList' => $asSectionList,'snSectionId' => $snSectionId)); 
								    ?>
                                </td>
                    		</tr>
							<tr>
                            	<td valign="middle" align="right" width="20%">
									<?php echo __('Select Row');?>
                        		</td>
	
                            	<td valign="middle" width="80%">
                                	<?php 
										if($sf_user->hasFlash('ssErrorRow') && $sf_user->getFlash('ssErrorRow') != ''):
											echo '<ul class="error_list"><li>'.$sf_user->getFlash('ssErrorRow').'</li></ul>';
											$sf_user->setFlash('ssErrorRow','');
										endif;
										include_partial('getRowList', array('asRowList' => $asRowList,'snRowId' => $snRowId)); 
								    ?>
                                </td>
                    		</tr>
							<tr>
                            	<td valign="middle" align="right" width="20%">
									<?php echo __('Select Plot');?>
                        		</td>
	
                            	<td valign="middle" width="80%">
                                	<?php 
										if($sf_user->hasFlash('ssErrorPlot') && $sf_user->getFlash('ssErrorPlot') != ''):
											echo '<ul class="error_list"><li>'.$sf_user->getFlash('ssErrorPlot').'</li></ul>';
											$sf_user->setFlash('ssErrorPlot','');
										endif;
										include_partial('getPlotList', array('asPlotList' => $asPlotList,'snPlotId' => $snPlotId)); 
								    ?>
                                </td>
                    		</tr>							
							<tr>
                            	<td valign="middle" align="right" width="20%">
									<?php echo __('Select Grave')."<span class='redText'>*</span>"?>
                        		</td>
	
                            	<td valign="middle" width="80%">
                                	<?php 
										if($sf_user->hasFlash('ssErrorGrave') && $sf_user->getFlash('ssErrorGrave') != ''):
											echo '<ul class="error_list"><li>'.$sf_user->getFlash('ssErrorGrave').'</li></ul>';
											$sf_user->setFlash('ssErrorGrave','');
										endif;
										include_partial('getGraveList', array('asGraveList' => $asGraveList,'snGraveId' => $snGraveId)); 
								    ?>
                                </td>
                    		</tr>
							<tr>
                            	<td valign="middle" align="right" width="20%">
                                	<?php echo $oGranteeForm['grantee_identity_id']->renderLabel($oGranteeForm['grantee_identity_id']->renderLabelName());?>
                        		</td>
	
                            	<td valign="middle" width="80%">
                                	<?php 
                                	    if($oGranteeForm['grantee_identity_id']->hasError()):
                                    	    echo $oGranteeForm['grantee_identity_id']->renderError();
                                        endif;
									    echo $oGranteeForm['grantee_identity_id']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>
                    		</tr>
                            <tr>
                            	<td valign="middle" align="right" width="20%">
                                	<?php echo $oGranteeForm['catalog_id']->renderLabel($oGranteeForm['catalog_id']->renderLabelName());?>
                        		</td>
	
                            	<td valign="middle" width="80%">
                                	<?php 
                                	    if($oGranteeForm['catalog_id']->hasError()):
                                    	    echo $oGranteeForm['catalog_id']->renderError();
                                        endif;
									    echo $oGranteeForm['catalog_id']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>
                    		</tr>
                            <tr>
                            	<td valign="middle" align="right" width="20%">
                                	<?php echo $oGranteeForm['payment_id']->renderLabel($oGranteeForm['payment_id']->renderLabelName());?>
                        		</td>
	
                            	<td valign="middle" width="80%">
                                	<?php 
                                	    if($oGranteeForm['payment_id']->hasError()):
                                    	    echo $oGranteeForm['payment_id']->renderError();
                                        endif;
									    echo $oGranteeForm['payment_id']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>
                    		</tr>
							<tr>
                            	<td valign="middle" align="right" width="20%">
                                	<?php echo $oGranteeForm['grantee_identity_number']->renderLabel($oGranteeForm['grantee_identity_number']->renderLabelName());?>
                        		</td>
	
                            	<td valign="middle" width="80%">
                                	<?php 
                                	    if($oGranteeForm['grantee_identity_number']->hasError()):
                                    	    echo $oGranteeForm['grantee_identity_number']->renderError();
                                        endif;
									    echo $oGranteeForm['grantee_identity_number']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>
                    		</tr>							
							<tr>
                            	<td valign="middle" align="right" width="20%">
                                	<?php echo $oGranteeForm['receipt_number']->renderLabel($oGranteeForm['receipt_number']->renderLabelName() );?>
                        		</td>
	
                            	<td valign="middle" width="80%">
                                	<?php 
                                	    if($oGranteeForm['receipt_number']->hasError()):
                                    	    echo $oGranteeForm['receipt_number']->renderError();
                                        endif;
									    echo $oGranteeForm['receipt_number']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>
                    		</tr>
							<tr>
                            	<td valign="middle" align="right" width="20%">
                                	<?php echo $oGranteeForm['control_number']->renderLabel($oGranteeForm['control_number']->renderLabelName());?>
                        		</td>
	
                            	<td valign="middle" width="80%">
                                	<?php 
                                	    if($oGranteeForm['control_number']->hasError()):
                                    	    echo $oGranteeForm['control_number']->renderError();
                                        endif;
									    echo $oGranteeForm['control_number']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>
                    		</tr>
							<tr>
                            	<td valign="middle" align="right" width="20%">
                                	<?php echo $oGranteeForm['invoice_number']->renderLabel($oGranteeForm['invoice_number']->renderLabelName() );?>
                        		</td>
	
                            	<td valign="middle" width="80%">
                                	<?php 
                                	    if($oGranteeForm['invoice_number']->hasError()):
                                    	    echo $oGranteeForm['invoice_number']->renderError();
                                        endif;
									    echo $oGranteeForm['invoice_number']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>
                    		</tr>
							<tr>
                            	<td valign="middle" align="right" width="20%">
                                	<?php echo $oGranteeForm['date_of_purchase']->renderLabel($oGranteeForm['date_of_purchase']->renderLabelName() );?>
                        		</td>
	
                            	<td valign="middle" width="80%">
                                	<?php 
                                	    if($oGranteeForm['date_of_purchase']->hasError()):
                                    	    echo $oGranteeForm['date_of_purchase']->renderError();
                                        endif;
									    echo $oGranteeForm['date_of_purchase']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>
                    		</tr>
							<tr>
                            	<td valign="middle" align="right" width="20%">
                                	<?php echo $oGranteeForm['tenure_expiry_date']->renderLabel($oGranteeForm['tenure_expiry_date']->renderLabelName() );?>
                        		</td>
	
                            	<td valign="middle" width="80%">
                                	<?php 
                                	    if($oGranteeForm['tenure_expiry_date']->hasError()):
                                    	    echo $oGranteeForm['tenure_expiry_date']->renderError();
                                        endif;
									    echo $oGranteeForm['tenure_expiry_date']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>
                    		</tr>
							<?php /*<tr>
                            	<td valign="middle" align="right" width="20%">
                                	<?php echo $oGranteeForm['cost']->renderLabel($oGranteeForm['cost']->renderLabelName() );?>
                        		</td>
	
                            	<td valign="middle" width="80%">
                                	<?php 
                                	    if($oGranteeForm['cost']->hasError()):
                                    	    echo $oGranteeForm['cost']->renderError();
                                        endif;
									    echo $oGranteeForm['cost']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>
                    		</tr> */ ?>														
                    		<tr>
                            	<td>&nbsp;</td>
                        		<td valign="middle">
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
	                                                            'tabindex'  => 16,
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
															$ssCancelUrl = 'gravesearch/addedit?back=true';
														else:
															$ssCancelUrl    = url_for($sf_params->get('module').'/index?grantee_id='.$snIdGranteeDetailId.'&cemetery_id='.$snCementeryId.'&'.html_entity_decode($amExtraParameters['ssQuerystr']));
														endif;
														
                                                		echo button_to(__('Cancel'),$ssCancelUrl,array('class'=>'delete','title'=>__('Cancel'),'alt'=>__('Cancel'),'tabindex'=>17));
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
        echo input_hidden_tag('tab', ($sf_params->get('tab') ? $sf_params->get('tab') :'info'), array('readonly' => 'true'));
        echo input_hidden_tag('back', $sf_params->get('back'), array('readonly' => 'true'));
		
		echo input_hidden_tag('grantee_id',$snIdGranteeDetailId);
		echo input_hidden_tag('cemetery_id',$snCementeryId);
		
        echo $oGranteeForm->renderHiddenFields(); 
    ?>
    </form>
</div>
<?php 
	if(!$sf_user->isSuperAdmin() && $oGranteeForm->getObject()->isNew() && !sfContext::getInstance()->getRequest()->isMethod('post'))
	{
		$snCemeteryId = $sf_user->getAttribute('cemeteryid');
		 echo javascript_tag("
			jQuery(document).ready(function() 
				{
					".
					// Ger area, section, row, plot list as per cemetery.
					jq_remote_function(
					array('url'		=> url_for('grantee/getAreaListAsPerCemetery'),
						  'update'	=> 'grantee_area_list',
						  'with'	=> "'cemetery_id='+".$snCemeteryId."+'&country_id='+$('#grantee_country_id').val()",
						  'loading' => '$("#IdAjaxLocaderArea").show();',
						  'complete'=> '$("#IdAjaxLocaderArea").hide();'.jq_remote_function(
									array('url'		=> url_for('grantee/getSectionListAsPerArea'),
										  'update'	=> 'grantee_section_list',
										  'with'	=> "'country_id='+$('#grantee_country_id').val()+'&cemetery_id='+$('#grantee_cem_cemetery_id').val()",
										  'loading' => '$("#IdAjaxLocaderSection").show();',
										  'complete'=> '$("#IdAjaxLocaderSection").hide();'.jq_remote_function(
													array('url'		=> url_for('grantee/getRowListAsPerSection'),
														  'update'	=> 'grantee_row_list',
														  'with'	=> "'country_id='+$('#grantee_country_id').val()+'&cemetery_id='+$('#grantee_cem_cemetery_id').val()",
														  'loading' => '$("#IdAjaxLocaderRow").show();',
														  'complete'=> '$("#IdAjaxLocaderRow").hide();'.jq_remote_function(
																		array('url'		=> url_for('grantee/getPlotListAsPerRow'),
																			  'update'	=> 'grantee_plot_list',
																			  'with'	=> "'country_id='+$('#grantee_country_id').val()+'&cemetery_id='+$('#grantee_cem_cemetery_id').val()",
																			  'loading' => '$("#IdAjaxLocaderPlot").show();',
																			  'complete'=> '$("#IdAjaxLocaderPlot").hide();'.jq_remote_function(
																							array('url'		=> url_for('grantee/getGraveListAsPerPlot'),
																								  'update'	=> 'grantee_grave_list',
																								  'with'	=> "'plot_id='+$('#grantee_ar_plot_id').val()+'&country_id='+$('#grantee_country_id').val()+'&cemetery_id='+$('#grantee_cem_cemetery_id').val()+'&area_id='+$('#grantee_ar_area_id').val()+'&section_id='+$('#grantee_ar_section_id').val()+'&row_id='+$('#grantee_ar_row_id').val()+'&grantee_id='+$('#grantee_id').val()",
																								  'loading' => '$("#IdAjaxLocaderGrave").show();',
																								  'complete'=> '$("#IdAjaxLocaderGrave").hide();'.jq_remote_function(
																									array('url'		=> url_for('grantee/getFuneralListAsPerCemetery'),
																										  'update'	=> 'grantee_funeral_list',
																										  'with'	=> "'country_id='+$('#grantee_country_id').val()+'&cemetery_id='+$('#grantee_cem_cemetery_id').val()",
																										  'loading' => '$("#IdAjaxLocaderFnd").show();',
																										  'complete'=> '$("#IdAjaxLocaderFnd").hide();'))
																					))
																			  ))
													))
									))
					))	
					."
				});
			");
		
		
		
		
		

	}
    echo javascript_tag('
        ssTags = document.getElementsByTagName("INPUT");
        document.getElementById(ssTags[0].id).select();
        document.getElementById(ssTags[0].id).focus();'
    );
    
    echo javascript_tag("
        jQuery(document).ready(function() 
            {
                tabSelection('".(($sf_params->get('tab')) ? $sf_params->get('tab') : 'info')."','active');
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
