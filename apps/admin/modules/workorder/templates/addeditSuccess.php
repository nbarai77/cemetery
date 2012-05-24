<?php  use_javascript('/sfFormExtraPlugin/js/double_list.js');?>
<div id="wapper">
<?php 
    echo $oWorkflowForm->renderFormTag(
        url_for($sf_params->get('module').'/'.$sf_params->get('action').(!$oWorkflowForm->getObject()->isNew() ? '?id='.$oWorkflowForm->getObject()->getId().'&'.html_entity_decode($amExtraParameters['ssQuerystr']) : '')), 
        array("name" => $oWorkflowForm->getName(), "method" => "post" ,'enctype'=>'multipart/form-data')
    );
?>
    <div class="comment_list"></div>
    <h1><?php echo $oWorkflowForm->getObject()->isNew() ?  __('Add New Work Order') : __('Edit Work Order');?></h1>
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
								<td valign="middle" align="right">
                                	<?php echo $oWorkflowForm['work_date']->renderLabel($oWorkflowForm['work_date']->renderLabelName());?>
                        		</td>
	
                            	<td valign="middle" colspan="3">
                                	<?php 
                                	    if($oWorkflowForm['work_date']->hasError()):
                                    	    echo $oWorkflowForm['work_date']->renderError();
                                        endif;
									    echo $oWorkflowForm['work_date']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>
                    		</tr>
							<tr>								
								<td valign="middle" align="right">
                                	<?php echo $oWorkflowForm['title']->renderLabel($oWorkflowForm['title']->renderLabelName() );?>
                        		</td>
	
                            	<td valign="middle">
                                	<?php 
                                	    if($oWorkflowForm['title']->hasError()):
                                    	    echo $oWorkflowForm['title']->renderError();
                                        endif;
									    echo $oWorkflowForm['title']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>
								<td valign="middle" align="right">
                                	<?php echo $oWorkflowForm['email']->renderLabel($oWorkflowForm['email']->renderLabelName() );?>
                        		</td>
	
                            	<td valign="middle">
                                	<?php 
                                	    if($oWorkflowForm['email']->hasError()):
                                    	    echo $oWorkflowForm['email']->renderError();
                                        endif;
									    echo $oWorkflowForm['email']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>
                    		</tr>
							<tr>                            	
								<td valign="middle" align="right">
                                	<?php echo $oWorkflowForm['name']->renderLabel($oWorkflowForm['name']->renderLabelName()."<span class='redText'>*</span>");?>
                        		</td>
	
                            	<td valign="middle">
                                	<?php 
                                	    if($oWorkflowForm['name']->hasError()):
                                    	    echo $oWorkflowForm['name']->renderError();
                                        endif;
									    echo $oWorkflowForm['name']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>
								<td valign="middle" align="right">
                                	<?php echo $oWorkflowForm['surname']->renderLabel($oWorkflowForm['surname']->renderLabelName()."<span class='redText'>*</span>");?>
                        		</td>
	
                            	<td valign="middle">
                                	<?php 
                                	    if($oWorkflowForm['surname']->hasError()):
                                    	    echo $oWorkflowForm['surname']->renderError();
                                        endif;
									    echo $oWorkflowForm['surname']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>
                    		</tr>
							<tr>                            	
								<td valign="middle" align="right">
                                	<?php echo $oWorkflowForm['area_code']->renderLabel($oWorkflowForm['area_code']->renderLabelName() );?>
                        		</td>
	
                            	<td valign="middle">
                                	<?php 
                                	    if($oWorkflowForm['area_code']->hasError()):
                                    	    echo $oWorkflowForm['area_code']->renderError();
                                        endif;
									    echo $oWorkflowForm['area_code']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>
								<td valign="middle" align="right">
                                	<?php echo $oWorkflowForm['telephone']->renderLabel($oWorkflowForm['telephone']->renderLabelName());?>
                        		</td>
	
                            	<td valign="middle">
                                	<?php 
                                	    if($oWorkflowForm['telephone']->hasError()):
                                    	    echo $oWorkflowForm['telephone']->renderError();
                                        endif;
									    echo $oWorkflowForm['telephone']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>
                    		</tr>									
                    		<?php if($sf_user->isSuperAdmin()):?>
							<tr>
                            	<td valign="middle" align="right">
                                	<?php echo $oWorkflowForm['country_id']->renderLabel($oWorkflowForm['country_id']->renderLabelName()."<span class='redText'>*</span>");?>
                        		</td>
	
                            	<td valign="middle" colspan="3">
                                	<?php 
                                	    if($oWorkflowForm['country_id']->hasError()):
                                    	    echo $oWorkflowForm['country_id']->renderError();
                                        endif;
									    echo $oWorkflowForm['country_id']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>
                    		</tr>							
							<tr>
                            	<td valign="middle" align="right">
									<?php echo __('Cementery')."<span class='redText'>*</span>"?>
                        		</td>
	
                            	<td valign="middle" colspan="3">
                                	<?php 
										if($sf_user->hasFlash('ssErrorCemeter') && $sf_user->getFlash('ssErrorCemeter') != ''):
											echo '<ul class="error_list"><li>'.$sf_user->getFlash('ssErrorCemeter').'</li></ul>';
											$sf_user->setFlash('ssErrorCemeter','');
										endif;
										include_partial('getCementeryList', array('asCementryList' => $asCementery,'snCementeryId' => $snCementeryId)); 
								    ?>
                                </td>
                    		</tr>							
							<?php endif;?>
							
							<tr>
                            	<td valign="middle" align="right" >
									<?php echo __('Area')?>
                        		</td>
	
                            	<td valign="middle" >
                                	<?php 
										if($sf_user->hasFlash('ssErrorArea') && $sf_user->getFlash('ssErrorArea') != ''):
											echo '<ul class="error_list"><li>'.$sf_user->getFlash('ssErrorArea').'</li></ul>';
											$sf_user->setFlash('ssErrorArea','');
										endif;
										include_partial('getAreaList', array('asAreaList' => $asAreaList,'snAreaId' => $snAreaId)); 
								    ?>
                                </td>
								<td valign="middle" align="right" >
									<?php echo __('Section')?>
                        		</td>
	
                            	<td valign="middle">
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
                            	<td valign="middle" align="right">
									<?php echo __('Row');?>
                        		</td>
	
                            	<td valign="middle">
                                	<?php 
										if($sf_user->hasFlash('ssErrorRow') && $sf_user->getFlash('ssErrorRow') != ''):
											echo '<ul class="error_list"><li>'.$sf_user->getFlash('ssErrorRow').'</li></ul>';
											$sf_user->setFlash('ssErrorRow','');
										endif;
										include_partial('getRowList', array('asRowList' => $asRowList,'snRowId' => $snRowId)); 
								    ?>
                                </td>
								<td valign="middle" align="right">
									<?php echo __('Plot');?>
                        		</td>
	
                            	<td valign="middle">
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
                            	<td valign="middle" align="right">
									<?php echo __('Grave');?>
                        		</td>
	
                            	<td valign="middle">
                                	<?php 
										if($sf_user->hasFlash('ssErrorGrave') && $sf_user->getFlash('ssErrorGrave') != ''):
											echo '<ul class="error_list"><li>'.$sf_user->getFlash('ssErrorGrave').'</li></ul>';
											$sf_user->setFlash('ssErrorGrave','');
										endif;
										include_partial('getGraveList', array('asGraveList' => $asGraveList,'snGraveId' => $snGraveId)); 
								    ?>
                                </td>
								<td valign="middle" align="right">
                                	<?php echo __('Department Delegation');?>
                        		</td>
	
                            	<td valign="middle">
                                	<?php include_partial('getDeptDelegationList', array('asDeptList' => $asDeptList,'snDeptId' => $snDeptId)); ?>
                                </td>
							</tr>
												
							<tr>
								<td valign="middle" align="right">
                                	<?php echo $oWorkflowForm['work_description']->renderLabel($oWorkflowForm['work_description']->renderLabelName() );?>
                        		</td>
	
                            	<td valign="middle">
                                	<?php 
                                	    if($oWorkflowForm['work_description']->hasError()):
                                    	    echo $oWorkflowForm['work_description']->renderError();
                                        endif;
									    echo $oWorkflowForm['work_description']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>
								<td valign="middle" align="right">
                                	<?php echo __('Completed By');?>
                        		</td>
	
                            	<td valign="middle">
                                	<?php include_partial('getCemeteryStaffList', array('asCemStaffList' => $asCemStaffList,'snCompletedBy' => $snCompletedBy)); ?>
                                </td>
							</tr>
							<tr>
                            	<td valign="middle" align="right">
                                	<?php echo $oWorkflowForm['action_taken']->renderLabel($oWorkflowForm['action_taken']->renderLabelName() );?>
                        		</td>
	
                            	<td valign="middle">
                                	<?php 
                                	    if($oWorkflowForm['action_taken']->hasError()):
                                    	    echo $oWorkflowForm['action_taken']->renderError();
                                        endif;
									    echo $oWorkflowForm['action_taken']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>
								<td valign="middle" align="right">
                                	<?php echo $oWorkflowForm['completion_date']->renderLabel($oWorkflowForm['completion_date']->renderLabelName() );?>
                        		</td>
	
                            	<td valign="middle">
                                	<?php 
                                	    if($oWorkflowForm['completion_date']->hasError()):
                                    	    echo $oWorkflowForm['completion_date']->renderError();
                                        endif;
									    echo $oWorkflowForm['completion_date']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>
							</tr>
							<tr>
								<td valign="middle" align="right">
                                	<?php echo $oWorkflowForm['feed_charges']->renderLabel($oWorkflowForm['feed_charges']->renderLabelName() );?>
                        		</td>
	
                            	<td valign="middle">
                                	<?php 
                                	    if($oWorkflowForm['feed_charges']->hasError()):
                                    	    echo $oWorkflowForm['feed_charges']->renderError();
                                        endif;
									    echo $oWorkflowForm['feed_charges']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>
								<td valign="middle" align="right">
                                	<?php echo $oWorkflowForm['receipt_number']->renderLabel($oWorkflowForm['receipt_number']->renderLabelName() );?>
                        		</td>
	
                            	<td valign="middle">
                                	<?php 
                                	    if($oWorkflowForm['receipt_number']->hasError()):
                                    	    echo $oWorkflowForm['receipt_number']->renderError();
                                        endif;
									    echo $oWorkflowForm['receipt_number']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>	
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
	                                                            'tabindex'  => 22,
	                                                            'onclick'   => "jQuery('#tab').val('');"
	                                                        )
	                                                    );
	                                                ?>
                                        		</span>
                                        	</li>
                                			<li class="list1">
                                        		<span>
                                        			<?php  
                                        			    $ssCancelUrl    = $sf_params->get('module').'/index?'.html_entity_decode($amExtraParameters['ssQuerystr']);
                                                		echo button_to(__('Cancel'),$ssCancelUrl,array('class'=>'delete','title'=>__('Cancel'),'alt'=>__('Cancel'),'tabindex'=>23));
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
        echo $oWorkflowForm->renderHiddenFields(); 
    ?>
    </form>
</div>
<?php 

	if(!$sf_user->isSuperAdmin() && $oWorkflowForm->getObject()->isNew() && !sfContext::getInstance()->getRequest()->isMethod('post'))
	{
		$snCemeteryId = $sf_user->getAttribute('cemeteryid');
		 echo javascript_tag("
			jQuery(document).ready(function() 
				{
					".
					// Ger area, section, row, plot list as per cemetery.
					jq_remote_function(
					array('url'		=> url_for('workorder/getAreaListAsPerCemetery'),
						  'update'	=> 'workorder_area_list',
						  'with'	=> "'cemetery_id='+".$snCemeteryId."+'&country_id='+$('#workorder_country_id').val()",
						  'loading' => '$("#IdAjaxLocaderRow").show();',
						  'complete'=> '$("#IdAjaxLocaderRow").hide();'.jq_remote_function(
									array('url'		=> url_for('workorder/getSectionListAsPerArea'),
										  'update'	=> 'workorder_section_list',
										  'with'	=> "'country_id='+$('#workorder_country_id').val()+'&cemetery_id='+$('#workorder_cem_cemetery_id').val()",
										  'loading' => '$("#IdAjaxLocaderSection").show();',
										  'complete'=> '$("#IdAjaxLocaderSection").hide();'.jq_remote_function(
													array('url'		=> url_for('workorder/getRowListAsPerSection'),
														  'update'	=> 'workorder_row_list',
														  'with'	=> "'country_id='+$('#workorder_country_id').val()+'&cemetery_id='+$('#workorder_cem_cemetery_id').val()",
														  'loading' => '$("#IdAjaxLocaderRow").show();',
														  'complete'=> '$("#IdAjaxLocaderRow").hide();'.jq_remote_function(
																		array('url'		=> url_for('workorder/getPlotListAsPerRow'),
																			  'update'	=> 'workorder_plot_list',
																			  'with'	=> "'country_id='+$('#workorder_country_id').val()+'&cemetery_id='+$('#workorder_cem_cemetery_id').val()",
																			  'loading' => '$("#IdAjaxLocaderPlot").show();',
																			  'complete'=> '$("#IdAjaxLocaderPlot").hide();'.jq_remote_function(
																				array('url'		=> url_for('workorder/getGraveListAsPerPlot'),
																					  'update'	=> 'workorder_workorder_list',
																					  'with'	=> "'country_id='+$('#workorder_country_id').val()+'&cemetery_id='+$('#workorder_cem_cemetery_id').val()",
																					  'loading' => '$("#IdAjaxLocaderGrave").show();',
																					  'complete'=> '$("#IdAjaxLocaderGrave").hide();'.jq_remote_function(
																						array('url'		=> url_for('workorder/getDepartmentListAsPerCemetery'),
																							  'update'	=> 'workorder_department_delegation_list',
																							  'with'	=> "'cemetery_id='+$('#workorder_cem_cemetery_id').val()",
																							  'loading' => '$("#IdAjaxLocaderDept").show();',
																							  'complete'=> '$("#IdAjaxLocaderDept").hide();'.jq_remote_function(
																								array('url'		=> url_for('workorder/getStaffListAsPerCemetery'),
																									  'update'	=> 'workorder_completed_by_list',
																									  'with'	=> "'cemetery_id='+$('#workorder_cem_cemetery_id').val()",
																									  'loading' => '$("#IdAjaxLocaderStaff").show();',
																									  'complete'=> '$("#IdAjaxLocaderStaff").hide();'))
																							 ))
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
		document.getElementById(ssTags[0].id).focus();'
    );
    
    echo javascript_tag("
        jQuery(document).ready(function() 
		{
			var snCountryId = jQuery('#workorder_country_id').val();
			var snCemeteryId = $('#workorder_cem_cemetery_id option').length;
			if(snCountryId > 0 && snCemeteryId == 1)
				callAjaxRequest(snCountryId,'".url_for('workorder/getCementryListAsPerCountry')."','workorder_cemetery_list');
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
