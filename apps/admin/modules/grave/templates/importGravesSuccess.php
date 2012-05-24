<?php  use_javascript('/sfFormExtraPlugin/js/double_list.js');?>
<div id="wapper">
<?php 
    echo $oImportGraveForm->renderFormTag(
        url_for($sf_params->get('module').'/'.$sf_params->get('action').(!$oImportGraveForm->getObject()->isNew() ? '?id='.$oImportGraveForm->getObject()->getId().'&'.html_entity_decode($amExtraParameters['ssQuerystr']) : '')), 
        array("name" => $oImportGraveForm->getName(), "method" => "post" ,'enctype'=>'multipart/form-data')
    );
?>
    <div class="comment_list"></div>
    <h1><?php echo $oImportGraveForm->getObject()->isNew() ?  __('Add Multiple Grave') : __('Edit Grave');?></h1>
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
                                	<?php echo $oImportGraveForm['country_id']->renderLabel($oImportGraveForm['country_id']->renderLabelName()."<span class='redText'>*</span>");?>
                        		</td>
	
                            	<td valign="middle" width="20%">
                                	<?php 
                                	    if($oImportGraveForm['country_id']->hasError()):
                                    	    echo $oImportGraveForm['country_id']->renderError();
                                        endif;
									    echo $oImportGraveForm['country_id']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>
                                <td valign="middle" width="60%">&nbsp;</td>
                    		</tr>							
							<tr>
                            	<td valign="middle" align="right" width="20%">
									<?php echo __('Select Cementery')."<span class='redText'>*</span>"?>
                        		</td>
                            	<td valign="middle" width="20%">
                                	<?php 
										if($sf_user->hasFlash('ssErrorCemeter') && $sf_user->getFlash('ssErrorCemeter') != ''):
											echo '<ul class="error_list"><li>'.$sf_user->getFlash('ssErrorCemeter').'</li></ul>';
											$sf_user->setFlash('ssErrorCemeter','');
										endif;
										include_partial('getCementeryList', array('asCementryList' => $asCementery, 'snCementeryId' => $snCementeryId)); 
								    ?>
                                </td>
                                <td valign="middle" width="60%">&nbsp;</td>
                    		</tr>							
							<?php endif;?>
							<tr>
                            	<td valign="middle" align="right" width="20%">
									<?php echo __('Select Area');?>
                        		</td>
	
                            	<td valign="middle" width="20%">
                                	<?php 
										if($sf_user->hasFlash('ssErrorArea') && $sf_user->getFlash('ssErrorArea') != ''):
											echo '<ul class="error_list"><li>'.$sf_user->getFlash('ssErrorArea').'</li></ul>';
											$sf_user->setFlash('ssErrorArea','');
										endif;
										include_partial('getAreaList', array('asAreaList' => $asAreaList,'snAreaId' => $snAreaId)); 
								    ?>
                                </td>
                                <td valign="middle" width="60%">&nbsp;</td>
                    		</tr>
							<tr>
                            	<td valign="middle" align="right" width="20%">
									<?php echo __('Select Section');?>
                        		</td>
	
                            	<td valign="middle" width="20%">
                                	<?php 
										if($sf_user->hasFlash('ssErrorSection') && $sf_user->getFlash('ssErrorSection') != ''):
											echo '<ul class="error_list"><li>'.$sf_user->getFlash('ssErrorSection').'</li></ul>';
											$sf_user->setFlash('ssErrorSection','');
										endif;
										include_partial('getSectionList', array('asSectionList' => $asSectionList,'snSectionId' => $snSectionId)); 
								    ?>
                                </td>
                                <td valign="middle" width="60%">&nbsp;</td>
                    		</tr>
							<tr>
                            	<td valign="middle" align="right" width="20%">
									<?php echo __('Select Row');?>
                        		</td>
	
                            	<td valign="middle" width="20%">
                                	<?php 
										if($sf_user->hasFlash('ssErrorRow') && $sf_user->getFlash('ssErrorRow') != ''):
											echo '<ul class="error_list"><li>'.$sf_user->getFlash('ssErrorRow').'</li></ul>';
											$sf_user->setFlash('ssErrorRow','');
										endif;
										include_partial('getRowList', array('asRowList' => $asRowList,'snRowId' => $snRowId)); 
								    ?>
                                </td>
                                <td valign="middle" width="60%">&nbsp;</td>
                    		</tr>
							<tr>
                            	<td valign="middle" align="right" width="20%">
									<?php echo __('Select Plot');?>
                        		</td>
	
                            	<td valign="middle" width="20%">
                                	<?php 
										if($sf_user->hasFlash('ssErrorPlot') && $sf_user->getFlash('ssErrorPlot') != ''):
											echo '<ul class="error_list"><li>'.$sf_user->getFlash('ssErrorPlot').'</li></ul>';
											$sf_user->setFlash('ssErrorPlot','');
										endif;
										include_partial('getPlotList', array('asPlotList' => $asPlotList,'snPlotId' => $snPlotId)); 
								    ?>
                                </td>
                                <td valign="middle" width="60%">&nbsp;</td>
                    		</tr>

							<tr>
                            	<td valign="middle" align="right" width="20%">
                                	<?php echo $oImportGraveForm['grave_number_start']->renderLabel($oImportGraveForm['grave_number_start']->renderLabelName()."<span class='redText'>*</span>");?>
                        		</td>
	
                            	<td valign="middle" width="20%">
                                	<?php 
                                	    if($oImportGraveForm['grave_number_start']->hasError()):
                                    	    echo $oImportGraveForm['grave_number_start']->renderError();
                                        endif;
									    echo $oImportGraveForm['grave_number_start']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>
                                <td valign="middle" width="60%">&nbsp;</td>
                    		</tr>
							<tr>
                            	<td valign="middle" align="right" width="20%">
                                	<?php echo $oImportGraveForm['grave_number_end']->renderLabel($oImportGraveForm['grave_number_end']->renderLabelName()."<span class='redText'>*</span>");?>
                        		</td>
	
                            	<td valign="middle" width="20%">
                                	<?php 
                                	    if($oImportGraveForm['grave_number_end']->hasError()):
                                    	    echo $oImportGraveForm['grave_number_end']->renderError();
                                        endif;
									    echo $oImportGraveForm['grave_number_end']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>
                                <td valign="middle" width="60%">&nbsp;</td>
                    		</tr>
							<tr>
                            	<td valign="middle" align="right" width="20%">
                                	<?php echo $oImportGraveForm['ar_grave_status_id']->renderLabel($oImportGraveForm['ar_grave_status_id']->renderLabelName()."<span class='redText'>*</span>");?>
                        		</td>
	
                            	<td valign="middle" width="20%">
                                	<?php 
                                	    if($oImportGraveForm['ar_grave_status_id']->hasError()):
                                    	    echo $oImportGraveForm['ar_grave_status_id']->renderError();
                                        endif;
									    echo $oImportGraveForm['ar_grave_status_id']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>
                                <td valign="middle" width="60%">&nbsp;</td>
                    		</tr>
							<tr>
                            	<td valign="middle" align="right" width="20%">
                                	<?php echo $oImportGraveForm['grantee_unique_id']->renderLabel($oImportGraveForm['grantee_unique_id']->renderLabelName());?>
                        		</td>
	
                            	<td valign="middle" width="20%">
                                	<?php
										if($sf_user->hasFlash('ssErrorGranteeNotExists') && $sf_user->getFlash('ssErrorGranteeNotExists') != ''):
											echo '<ul class="error_list"><li>'.$sf_user->getFlash('ssErrorGranteeNotExists').'</li></ul>';
											$sf_user->setFlash('ssErrorGranteeNotExists','');
										endif;
									    echo $oImportGraveForm['grantee_unique_id']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>
                                <td valign="middle" width="60%">&nbsp;</td>
                    		</tr>					
							<tr>
                            	<td valign="middle" align="right" width="20%">
                                	<?php echo $oImportGraveForm['length']->renderLabel($oImportGraveForm['length']->renderLabelName() );?>
                        		</td>
	
                            	<td valign="middle" width="20%">
                                	<?php 
                                	    if($oImportGraveForm['length']->hasError()):
                                    	    echo $oImportGraveForm['length']->renderError();
                                        endif;
									    echo $oImportGraveForm['length']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>
                                <td valign="middle" width="60%">&nbsp;</td>
                    		</tr>
							<tr>
                            	<td valign="middle" align="right" width="20%">
                                	<?php echo $oImportGraveForm['width']->renderLabel($oImportGraveForm['width']->renderLabelName() );?>
                        		</td>
	
                            	<td valign="middle" width="20%">
                                	<?php 
                                	    if($oImportGraveForm['width']->hasError()):
                                    	    echo $oImportGraveForm['width']->renderError();
                                        endif;
									    echo $oImportGraveForm['width']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>
                                <td valign="middle" width="60%">&nbsp;</td>
                    		</tr>
							<tr>
                            	<td valign="middle" align="right" width="20%">
                                	<?php echo $oImportGraveForm['height']->renderLabel($oImportGraveForm['height']->renderLabelName() );?>
                        		</td>
	
                            	<td valign="middle" width="20%">
                                	<?php 
                                	    if($oImportGraveForm['height']->hasError()):
                                    	    echo $oImportGraveForm['height']->renderError();
                                        endif;
									    echo $oImportGraveForm['height']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>
                                <td valign="middle" width="60%">&nbsp;</td>
                    		</tr>
							<tr>
                            	<td valign="middle" align="right" width="20%">
                                	<?php echo $oImportGraveForm['unit_type_id']->renderLabel($oImportGraveForm['unit_type_id']->renderLabelName());?>
                        		</td>
	
                            	<td valign="middle" width="20%">
                                	<?php 
                                	    if($oImportGraveForm['unit_type_id']->hasError()):
                                    	    echo $oImportGraveForm['unit_type_id']->renderError();
                                        endif;
									    echo $oImportGraveForm['unit_type_id']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>
                                <td valign="middle" width="60%">&nbsp;</td>
                    		</tr>							                   		
							<tr>
                            	<td valign="middle" align="right" width="20%">
                                	<?php echo $oImportGraveForm['details']->renderLabel($oImportGraveForm['details']->renderLabelName() );?>
                        		</td>
	
                            	<td valign="middle" width="20%">
                                	<?php 
                                	    if($oImportGraveForm['details']->hasError()):
                                    	    echo $oImportGraveForm['details']->renderError();
                                        endif;
									    echo $oImportGraveForm['details']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>
                                <td valign="middle" width="60%">&nbsp;</td>
                    		</tr>
							<tr>
								<td valign="middle">
									<?php echo $oImportGraveForm['is_enabled']->renderLabel($oImportGraveForm['is_enabled']->renderLabelName());?>
								</td>
								<td valign="middle" colspan="3"> <?php echo $oImportGraveForm['is_enabled']->render();?> </td>
							</tr>
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
	                                                            'tabindex'  => 17,
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
															$ssCancelUrl = $sf_params->get('module').'/index?back=true&'.html_entity_decode($amExtraParameters['ssQuerystr']);
														endif;
															
                                                		echo button_to(__('Cancel'),$ssCancelUrl,array('class'=>'delete','title'=>__('Cancel'),'alt'=>__('Cancel'),'tabindex'=>18));
                                                    ?>
                                    			</span>
                                    		</li>
                            			</ul>
                                	</div>
                        		</td>
                                <td valign="middle" width="60%">&nbsp;</td>
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
        echo $oImportGraveForm->renderHiddenFields(); 
    ?>
    </form>
</div>
<?php 

	if(!$sf_user->isSuperAdmin() && $oImportGraveForm->getObject()->isNew() && !sfContext::getInstance()->getRequest()->isMethod('post'))
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
