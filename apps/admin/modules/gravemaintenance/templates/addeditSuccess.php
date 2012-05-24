<?php  use_javascript('/sfFormExtraPlugin/js/double_list.js');?>
<div id="wapper">
<?php 
    echo $oArGraveMaintenanceForm->renderFormTag(
        url_for($sf_params->get('module').'/'.$sf_params->get('action').(!$oArGraveMaintenanceForm->getObject()->isNew() ? '?id='.$oArGraveMaintenanceForm->getObject()->getId().'&'.html_entity_decode($amExtraParameters['ssQuerystr']) : '')), 
        array("name" => $oArGraveMaintenanceForm->getName(), "method" => "post" ,'enctype'=>'multipart/form-data')
    );
?>
    <div class="comment_list"></div>
    <h1><?php echo $oArGraveMaintenanceForm->getObject()->isNew() ?  __('Add New Grave Maintenance') : __('Edit Grave Maintenance');?></h1>
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
                            	<td valign="middle" align="right"  colspan="4">									
                                    <b><?php echo __('Annual Care');?></b>
								</td>
							</tr>
                    		<?php if($sf_user->isSuperAdmin()):?>
							<tr>
                            	<td valign="middle" align="right">
                                	<?php echo $oArGraveMaintenanceForm['country_id']->renderLabel($oArGraveMaintenanceForm['country_id']->renderLabelName()."<span class='redText'>*</span>");?>
                        		</td>
	
                            	<td valign="middle" colspan="3">
                                	<?php 
                                	    if($oArGraveMaintenanceForm['country_id']->hasError()):
                                    	    echo $oArGraveMaintenanceForm['country_id']->renderError();
                                        endif;
									    echo $oArGraveMaintenanceForm['country_id']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>
                    		</tr>							
							<tr>
                            	<td valign="middle" align="right">
									<?php echo __('Select Cementery')."<span class='redText'>*</span>"?>
                        		</td>
	
                            	<td valign="middle">
                                	<?php 
										if($sf_user->hasFlash('ssErrorCemeter') && $sf_user->getFlash('ssErrorCemeter') != ''):
											echo '<ul class="error_list"><li>'.$sf_user->getFlash('ssErrorCemeter').'</li></ul>';
											$sf_user->setFlash('ssErrorCemeter','');
										endif;
										include_partial('getCementeryList', array('asCementryList' => $asCementery,'snCementeryId' => $snCementeryId)); 
								    ?>
                                </td>
								<td valign="middle" align="right">
                                	<?php echo $oArGraveMaintenanceForm['onsite_work_date']->renderLabel($oArGraveMaintenanceForm['onsite_work_date']->renderLabelName());?>
                        		</td>
	
                            	<td valign="middle">
                                	<?php 
                                	    if($oArGraveMaintenanceForm['onsite_work_date']->hasError()):
                                    	    echo $oArGraveMaintenanceForm['onsite_work_date']->renderError();
                                        endif;
									    echo $oArGraveMaintenanceForm['onsite_work_date']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>
                    		</tr>							
							<?php endif;?>
							
							<tr>
                            	<td valign="middle" align="right" >
									<?php echo __('Select Area')?>
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
								<td valign="middle" align="right">
                                	<?php echo $oArGraveMaintenanceForm['date_paid']->renderLabel($oArGraveMaintenanceForm['date_paid']->renderLabelName());?>
                        		</td>
	
                            	<td valign="middle">
                                	<?php 
                                	    if($oArGraveMaintenanceForm['date_paid']->hasError()):
                                    	    echo $oArGraveMaintenanceForm['date_paid']->renderError();
                                        endif;
									    echo $oArGraveMaintenanceForm['date_paid']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>
                    		</tr>	
							<tr>
                            	<td valign="middle" align="right" >
									<?php echo __('Select Section')?>
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
								<td valign="middle" align="right">
                                	<?php echo $oArGraveMaintenanceForm['amount_paid']->renderLabel($oArGraveMaintenanceForm['amount_paid']->renderLabelName() );?>
                        		</td>
	
                            	<td valign="middle">
                                	<?php 
                                	    if($oArGraveMaintenanceForm['amount_paid']->hasError()):
                                    	    echo $oArGraveMaintenanceForm['amount_paid']->renderError();
                                        endif;
									    echo $oArGraveMaintenanceForm['amount_paid']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>
							</tr>
							<tr>
                            	<td valign="middle" align="right">
									<?php echo __('Select Row');?>
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
                                	<?php echo $oArGraveMaintenanceForm['receipt']->renderLabel($oArGraveMaintenanceForm['receipt']->renderLabelName() );?>
                        		</td>
	
                            	<td valign="middle">
                                	<?php 
                                	    if($oArGraveMaintenanceForm['receipt']->hasError()):
                                    	    echo $oArGraveMaintenanceForm['receipt']->renderError();
                                        endif;
									    echo $oArGraveMaintenanceForm['receipt']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>
							</tr>
							<tr>
                            	<td valign="middle" align="right">
									<?php echo __('Select Plot');?>
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
								<td valign="middle" align="right">
                                	<?php echo $oArGraveMaintenanceForm['renewal_term']->renderLabel($oArGraveMaintenanceForm['renewal_term']->renderLabelName()."<span class='redText'>*</span>");?>
                        		</td>
	
                            	<td valign="middle">
                                	<?php 
                                	    if($oArGraveMaintenanceForm['renewal_term']->hasError()):
                                    	    echo $oArGraveMaintenanceForm['renewal_term']->renderError();
                                        endif;
									    echo $oArGraveMaintenanceForm['renewal_term']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>
							</tr>
							<tr>
                            	<td valign="middle" align="right">
									<?php echo __('Select Grave')."<span class='redText'>*</span>"?>
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
                                	<?php echo $oArGraveMaintenanceForm['renewal_date']->renderLabel($oArGraveMaintenanceForm['renewal_date']->renderLabelName() );?>
                        		</td>
	
                            	<td valign="middle">
                                	<?php 
                                	    if($oArGraveMaintenanceForm['renewal_date']->hasError()):
                                    	    echo $oArGraveMaintenanceForm['renewal_date']->renderError();
                                        endif;
									    echo $oArGraveMaintenanceForm['renewal_date']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>
							</tr>
							<tr>
                            	<td valign="middle" align="right">
                                	<?php echo $oArGraveMaintenanceForm['interred_name']->renderLabel($oArGraveMaintenanceForm['interred_name']->renderLabelName());?>
                        		</td>
	
                            	<td valign="middle">
                                	<?php 
                                	    if($oArGraveMaintenanceForm['interred_name']->hasError()):
                                    	    echo $oArGraveMaintenanceForm['interred_name']->renderError();
                                        endif;
									    echo $oArGraveMaintenanceForm['interred_name']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>
								<td valign="middle" align="right">
                                	<?php echo $oArGraveMaintenanceForm['interred_surname']->renderLabel($oArGraveMaintenanceForm['interred_surname']->renderLabelName());?>
                        		</td>
	
                            	<td valign="middle">
                                	<?php 
                                	    if($oArGraveMaintenanceForm['interred_surname']->hasError()):
                                    	    echo $oArGraveMaintenanceForm['interred_surname']->renderError();
                                        endif;
									    echo $oArGraveMaintenanceForm['interred_surname']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>
							</tr>							
							<tr>
								<td colspan="4" align="left">
									<b><?php echo __('Caregiver');?></b>
								</td>
							</tr>
							<tr>
                            	<td valign="middle" align="right">
                                	<?php echo $oArGraveMaintenanceForm['title']->renderLabel($oArGraveMaintenanceForm['title']->renderLabelName() );?>
                        		</td>
	
                            	<td valign="middle">
                                	<?php 
                                	    if($oArGraveMaintenanceForm['title']->hasError()):
                                    	    echo $oArGraveMaintenanceForm['title']->renderError();
                                        endif;
									    echo $oArGraveMaintenanceForm['title']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>
								<td valign="middle" align="right">
                                	<?php echo $oArGraveMaintenanceForm['organization_name']->renderLabel($oArGraveMaintenanceForm['organization_name']->renderLabelName() );?>
                        		</td>
	
                            	<td valign="middle">
                                	<?php 
                                	    if($oArGraveMaintenanceForm['organization_name']->hasError()):
                                    	    echo $oArGraveMaintenanceForm['organization_name']->renderError();
                                        endif;
									    echo $oArGraveMaintenanceForm['organization_name']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>
							</tr>
							<tr>
                            	<td valign="middle" align="right">
                                	<?php echo $oArGraveMaintenanceForm['first_name']->renderLabel($oArGraveMaintenanceForm['first_name']->renderLabelName() );?>
                        		</td>
	
                            	<td valign="middle">
                                	<?php 
                                	    if($oArGraveMaintenanceForm['first_name']->hasError()):
                                    	    echo $oArGraveMaintenanceForm['first_name']->renderError();
                                        endif;
									    echo $oArGraveMaintenanceForm['first_name']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>
								<td valign="middle" align="right">
                                	<?php echo $oArGraveMaintenanceForm['surname']->renderLabel($oArGraveMaintenanceForm['surname']->renderLabelName() );?>
                        		</td>
	
                            	<td valign="middle">
                                	<?php 
                                	    if($oArGraveMaintenanceForm['surname']->hasError()):
                                    	    echo $oArGraveMaintenanceForm['surname']->renderError();
                                        endif;
									    echo $oArGraveMaintenanceForm['surname']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>
							</tr>
							<tr>
                            	<td valign="middle" align="right">
                                	<?php echo $oArGraveMaintenanceForm['address']->renderLabel($oArGraveMaintenanceForm['address']->renderLabelName() );?>
                        		</td>
	
                            	<td valign="middle">
                                	<?php 
                                	    if($oArGraveMaintenanceForm['address']->hasError()):
                                    	    echo $oArGraveMaintenanceForm['address']->renderError();
                                        endif;
									    echo $oArGraveMaintenanceForm['address']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>
								<td valign="middle" align="right">
                                	<?php echo $oArGraveMaintenanceForm['subrub']->renderLabel($oArGraveMaintenanceForm['subrub']->renderLabelName() );?>
                        		</td>
	
                            	<td valign="middle">
                                	<?php 
                                	    if($oArGraveMaintenanceForm['subrub']->hasError()):
                                    	    echo $oArGraveMaintenanceForm['subrub']->renderError();
                                        endif;
									    echo $oArGraveMaintenanceForm['subrub']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>
							</tr>
							<tr>
                            	<td valign="middle" align="right">
                                	<?php echo $oArGraveMaintenanceForm['state']->renderLabel($oArGraveMaintenanceForm['state']->renderLabelName() );?>
                        		</td>
	
                            	<td valign="middle">
                                	<?php 
                                	    if($oArGraveMaintenanceForm['state']->hasError()):
                                    	    echo $oArGraveMaintenanceForm['state']->renderError();
                                        endif;
									    echo $oArGraveMaintenanceForm['state']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>
								<td valign="middle" align="right">
                                	<?php echo $oArGraveMaintenanceForm['postal_code']->renderLabel($oArGraveMaintenanceForm['postal_code']->renderLabelName() );?>
                        		</td>
	
                            	<td valign="middle">
                                	<?php 
                                	    if($oArGraveMaintenanceForm['postal_code']->hasError()):
                                    	    echo $oArGraveMaintenanceForm['postal_code']->renderError();
                                        endif;
									    echo $oArGraveMaintenanceForm['postal_code']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>
							</tr>
							<tr>
                            	<td valign="middle" align="right">
                                	<?php echo $oArGraveMaintenanceForm['user_country']->renderLabel($oArGraveMaintenanceForm['user_country']->renderLabelName() );?>
                        		</td>
	
                            	<td valign="middle">
                                	<?php 
                                	    if($oArGraveMaintenanceForm['user_country']->hasError()):
                                    	    echo $oArGraveMaintenanceForm['user_country']->renderError();
                                        endif;
									    echo $oArGraveMaintenanceForm['user_country']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>
								<td valign="middle" align="right">
                                	<?php echo $oArGraveMaintenanceForm['email']->renderLabel($oArGraveMaintenanceForm['email']->renderLabelName() );?>
                        		</td>
	
                            	<td valign="middle">
                                	<?php 
                                	    if($oArGraveMaintenanceForm['email']->hasError()):
                                    	    echo $oArGraveMaintenanceForm['email']->renderError();
                                        endif;
									    echo $oArGraveMaintenanceForm['email']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>
							</tr>
							<tr>
                            	<td valign="middle" align="right">
                                	<?php echo $oArGraveMaintenanceForm['area_code']->renderLabel($oArGraveMaintenanceForm['area_code']->renderLabelName() );?>
                        		</td>
	
                            	<td valign="middle">
                                	<?php 
                                	    if($oArGraveMaintenanceForm['area_code']->hasError()):
                                    	    echo $oArGraveMaintenanceForm['area_code']->renderError();
                                        endif;
									    echo $oArGraveMaintenanceForm['area_code']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>
								<td valign="middle" align="right">
                                	<?php echo $oArGraveMaintenanceForm['number']->renderLabel($oArGraveMaintenanceForm['number']->renderLabelName() );?>
                        		</td>
	
                            	<td valign="middle">
                                	<?php 
                                	    if($oArGraveMaintenanceForm['number']->hasError()):
                                    	    echo $oArGraveMaintenanceForm['number']->renderError();
                                        endif;
									    echo $oArGraveMaintenanceForm['number']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>
							</tr>
							<tr>
                            	<td valign="middle" align="right">
                                	<?php echo $oArGraveMaintenanceForm['notes']->renderLabel($oArGraveMaintenanceForm['notes']->renderLabelName() );?>
                        		</td>
	
                            	<td valign="middle" colspan="3">
                                	<?php 
                                	    if($oArGraveMaintenanceForm['notes']->hasError()):
                                    	    echo $oArGraveMaintenanceForm['notes']->renderError();
                                        endif;
									    echo $oArGraveMaintenanceForm['notes']->render(array('class'=>'inputBoxWidth')); 
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
	                                                            'tabindex'  => 28,
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
															$ssCancelUrl = 'annualsearch/report?back=true';
														else:	                                        			 
															$ssCancelUrl    = $sf_params->get('module').'/index?'.html_entity_decode($amExtraParameters['ssQuerystr']);
														endif;	
                                                		echo button_to(__('Cancel'),$ssCancelUrl,array('class'=>'delete','title'=>__('Cancel'),'alt'=>__('Cancel'),'tabindex'=>29));
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
        echo $oArGraveMaintenanceForm->renderHiddenFields(); 
    ?>
    </form>
</div>
<?php 

	if(!$sf_user->isSuperAdmin() && $oArGraveMaintenanceForm->getObject()->isNew() && !sfContext::getInstance()->getRequest()->isMethod('post'))
	{
		$snCemeteryId = $sf_user->getAttribute('cemeteryid');
		 echo javascript_tag("
			jQuery(document).ready(function() 
				{
					".
					// Ger area, section, row, plot list as per cemetery.
					jq_remote_function(
					array('url'		=> url_for('gravemaintenance/getAreaListAsPerCemetery'),
						  'update'	=> 'gravemaintenance_area_list',
						  'with'	=> "'cemetery_id='+".$snCemeteryId."+'&country_id='+$('#gravemaintenance_country_id').val()",
						  'loading' => '$("#IdAjaxLocaderRow").show();',
						  'complete'=> '$("#IdAjaxLocaderRow").hide();'.jq_remote_function(
									array('url'		=> url_for('gravemaintenance/getSectionListAsPerArea'),
										  'update'	=> 'gravemaintenance_section_list',
										  'with'	=> "'country_id='+$('#gravemaintenance_country_id').val()+'&cemetery_id='+$('#gravemaintenance_cem_cemetery_id').val()",
										  'loading' => '$("#IdAjaxLocaderSection").show();',
										  'complete'=> '$("#IdAjaxLocaderSection").hide();'.jq_remote_function(
													array('url'		=> url_for('gravemaintenance/getRowListAsPerSection'),
														  'update'	=> 'gravemaintenance_row_list',
														  'with'	=> "'country_id='+$('#gravemaintenance_country_id').val()+'&cemetery_id='+$('#gravemaintenance_cem_cemetery_id').val()",
														  'loading' => '$("#IdAjaxLocaderRow").show();',
														  'complete'=> '$("#IdAjaxLocaderRow").hide();'.jq_remote_function(
																		array('url'		=> url_for('gravemaintenance/getPlotListAsPerRow'),
																			  'update'	=> 'gravemaintenance_plot_list',
																			  'with'	=> "'country_id='+$('#gravemaintenance_country_id').val()+'&cemetery_id='+$('#gravemaintenance_cem_cemetery_id').val()",
																			  'loading' => '$("#IdAjaxLocaderPlot").show();',
																			  'complete'=> '$("#IdAjaxLocaderPlot").hide();'.jq_remote_function(
																							array('url'		=> url_for('gravemaintenance/getGraveListAsPerPlot'),
																								  'update'	=> 'gravemaintenance_grave_list',
																								  'with'	=> "'plot_id='+$('#gravemaintenance_ar_plot_id').val()+'&country_id='+$('#gravemaintenance_country_id').val()+'&cemetery_id='+$('#gravemaintenance_cem_cemetery_id').val()+'&area_id='+$('#gravemaintenance_ar_area_id').val()+'&section_id='+$('#gravemaintenance_ar_section_id').val()+'&row_id='+$('#gravemaintenance_ar_row_id').val()",
																								  'loading' => '$("#IdAjaxLocaderGrave").show();',
																								  'complete'=> '$("#IdAjaxLocaderGrave").hide();'))
																			  ))
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
    if($sf_user->isSuperAdmin()):
    echo javascript_tag("
        jQuery(document).ready(function() 
		{
			var snCountryId = jQuery('#gravemaintenance_country_id').val();
			var snCemeteryId = $('#gravemaintenance_cem_cemetery_id option').length;
			if(snCountryId > 0 && snCemeteryId == 1)
				callAjaxRequest(snCountryId,'".url_for('gravemaintenance/getCementryListAsPerCountry')."','gravemaintenance_cemetery_list');
		});
	");
	endif;
    echo javascript_tag("
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
