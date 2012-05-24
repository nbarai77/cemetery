<?php  use_javascript('/sfFormExtraPlugin/js/double_list.js');?>
<div id="wapper">
<?php 
    echo $oGraveLinkForm->renderFormTag(
        url_for($sf_params->get('module').'/addEditGraveLink?'.html_entity_decode($amExtraParameters['ssQuerystr']) ), 
        array("name" => $oGraveLinkForm->getName(), "method" => "post" ,'enctype'=>'multipart/form-data')
    );
?>
    <div class="comment_list"></div>
    <h1><?php echo $oGraveLinkForm->getObject()->isNew() ?  __('Add Linked Grave') : __('Add More Linked Grave');?></h1>
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
										<?php echo $oGraveLinkForm['country_id']->renderLabel($oGraveLinkForm['country_id']->renderLabelName());?>
									</td>
		
									<td valign="middle" width="30%">
										<?php 
											if($oGraveLinkForm['country_id']->hasError()):
												echo $oGraveLinkForm['country_id']->renderError();
											endif;
											echo $oGraveLinkForm['country_id']->render(); 
										?>
									</td>
								
									<td valign="middle" align="right" width="20%">
										<?php echo __('Select Cementery')?>
									</td>
		
									<td valign="middle" width="30%">
										<?php 
											if($sf_user->hasFlash('ssErrorCemeter') && $sf_user->getFlash('ssErrorCemeter') != ''):
												echo '<ul class="error_list"><li>'.$sf_user->getFlash('ssErrorCemeter').'</li></ul>';
												$sf_user->setFlash('ssErrorCemeter','');
											endif;
											include_partial('getCementeryListLink', array('asCementryList' => $asCementery,'snCementeryId' => $snCementeryId)); 
										?>
									</td>
								</tr>
							<?php endif;?>
								
							<tr>
                            	<td valign="middle" align="right" width="20%">
									<?php echo __('Select Area')?>
                        		</td>
	
                            	<td valign="middle" width="30%">
                                	<?php 
										if($sf_user->hasFlash('ssErrorArea') && $sf_user->getFlash('ssErrorArea') != ''):
											echo '<ul class="error_list"><li>'.$sf_user->getFlash('ssErrorArea').'</li></ul>';
											$sf_user->setFlash('ssErrorArea','');
										endif;
										include_partial('getAreaListLink', array('asAreaList' => $asAreaList,'snAreaId' => $snAreaId)); 
								    ?>
                                </td>
                            	<td valign="middle" align="right" width="20%">
									<?php echo __('Select Section')?>
                        		</td>
	
                            	<td valign="middle" width="30%">
                                	<?php 
										if($sf_user->hasFlash('ssErrorSection') && $sf_user->getFlash('ssErrorSection') != ''):
											echo '<ul class="error_list"><li>'.$sf_user->getFlash('ssErrorSection').'</li></ul>';
											$sf_user->setFlash('ssErrorSection','');
										endif;
										include_partial('getSectionListLink', array('asSectionList' => $asSectionList,'snSectionId' => $snSectionId)); 
								    ?>
                                </td>                                
                    		</tr>
	
							<tr>
                            	<td valign="middle" align="right" width="20%">
									<?php echo __('Select Row')?>
                        		</td>
	
                            	<td valign="middle" width="30%">
                                	<?php 
										if($sf_user->hasFlash('ssErrorRow') && $sf_user->getFlash('ssErrorRow') != ''):
											echo '<ul class="error_list"><li>'.$sf_user->getFlash('ssErrorRow').'</li></ul>';
											$sf_user->setFlash('ssErrorRow','');
										endif;
										include_partial('getRowListLink', array('asRowList' => $asRowList,'snRowId' => $snRowId)); 
								    ?>
                                </td>
                            	<td valign="middle" align="right" width="20%">
									<?php echo __('Select Plot')?>
                        		</td>
	
                            	<td valign="middle" width="30%">
                                	<?php 
										if($sf_user->hasFlash('ssErrorPlot') && $sf_user->getFlash('ssErrorPlot') != ''):
											echo '<ul class="error_list"><li>'.$sf_user->getFlash('ssErrorPlot').'</li></ul>';
											$sf_user->setFlash('ssErrorPlot','');
										endif;
										include_partial('getPlotListLink', array('asPlotList' => $asPlotList,'snPlotId' => $snPlotId)); 
								    ?>
                                </td>                                
                    		</tr>

							<tr>

								<td valign="middle" align="right" width="20%">
									<?php echo __('Select Grave')."<span class='redText'>*</span>"; ?>
                        		</td>
	
                            	<td valign="middle" width="30%" colspan="3">
                                	<?php 
										if($sf_user->hasFlash('ssErrorGrave') && $sf_user->getFlash('ssErrorGrave') != ''):
											echo '<ul class="error_list"><li>'.$sf_user->getFlash('ssErrorGrave').'</li></ul>';
											$sf_user->setFlash('ssErrorGrave','');
										endif;
										include_partial('getGraveListLink', array('asGraveList' => $asGraveList, 'snGraveId' => $snGraveId)); 
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
	                                                            'tabindex'  => 8,
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
															$ssCancelUrl = 'grave/addEditGraveLink?back=true&'.html_entity_decode($amExtraParameters['ssQuerystr']);
														else:	
															$ssCancelUrl = $sf_params->get('module').'/graveLink?'.html_entity_decode($amExtraParameters['ssQuerystr']);
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
        echo input_hidden_tag('tab', ($sf_params->get('tab') ? $sf_params->get('tab') :'info'), array('readonly' => 'true'));
        echo $oGraveLinkForm->renderHiddenFields(); 
    ?>
    </form>
</div>
<?php 
    echo javascript_tag('
        ssTags = document.getElementsByTagName("select");
        document.getElementById(ssTags[1].id).focus();'
    );
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

	if(!$sf_user->isSuperAdmin() && !$sf_params->get('back'))
	{
		$snCemeteryId = $sf_user->getAttribute('cemeteryid');
		 echo javascript_tag("
			jQuery(document).ready(function() 
				{
					".
					// Ger area, section, row, plot list as per cemetery.
					jq_remote_function(
					array('url'		=> url_for('grave/getAreaListAsPerCemetery?render_partial=getAreaListLink'),
						  'update'	=> 'grave_area_list',
						  'with'	=> "'cemetery_id='+".$snCemeteryId."+'&country_id='+$('#grave_country_id').val()",
						  'loading' => '$("#IdAjaxLocaderArea").show();',
						  'complete'=> '$("#IdAjaxLocaderArea").hide();'.jq_remote_function(
									array('url'		=> url_for('grave/getSectionListAsPerArea?render_partial=getSectionListLink'),
										  'update'	=> 'grave_section_list',
										  'with'	=> "'country_id='+$('#grave_country_id').val()+'&cemetery_id='+$('#grave_cem_cemetery_id').val()",
										  'loading' => '$("#IdAjaxLocaderSection").show();',
										  'complete'=> '$("#IdAjaxLocaderSection").hide();'.jq_remote_function(
													array('url'		=> url_for('grave/getRowListAsPerSection?render_partial=getRowListLink'),
														  'update'	=> 'grave_row_list',
														  'with'	=> "'country_id='+$('#grave_country_id').val()+'&cemetery_id='+$('#grave_cem_cemetery_id').val()",
														  'loading' => '$("#IdAjaxLocaderRow").show();',
														  'complete'=> '$("#IdAjaxLocaderRow").hide();'.jq_remote_function(
																		array('url'		=> url_for('grave/getPlotListAsPerRow?render_partial=getPlotListLink'),
																			  'update'	=> 'grave_plot_list',
																			  'with'	=> "'country_id='+$('#grave_country_id').val()+'&cemetery_id='+$('#grave_cem_cemetery_id').val()",
																			  'loading' => '$("#IdAjaxLocaderPlot").show();',
																			  'complete'=> '$("#IdAjaxLocaderPlot").hide();'.jq_remote_function(
																							array('url'		=> url_for('grave/getGraveListAsPerPlot?render_partial=getGraveListLink'),
																								  'update'	=> 'grave_list',
																								  'with'	=> "'plot_id='+$('#grave_ar_plot_id').val()+'&country_id='+$('#grave_country_id').val()+'&cemetery_id='+$('#grave_cem_cemetery_id').val()+'&area_id='+$('#grave_ar_area_id').val()+'&section_id='+$('#grave_ar_section_id').val()+'&row_id='+$('#grave_ar_row_id').val()",																								  
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


if($sf_user->getAttribute('cn') != ''):
echo javascript_tag(
  jq_remote_function(array(
    'update'  => 'grave_cemetery_list',
    'url'     => url_for('grave/getCementryListAsPerCountry?id='.$sf_user->getAttribute('cn').'&cnval='.$sf_user->getAttribute('cm').'&render_partial=getCementryListLink'),
	'loading' => '$("#IdAjaxLocaderCemetery").show();',
  	'complete'=> '$("#IdAjaxLocaderCemetery").hide();'
  )));
endif;


if($sf_user->getAttribute('cm') != ''):
	echo javascript_tag(
		jq_remote_function(array(
			'update'  => 'grave_area_list',
			'url'     => url_for('grave/getAreaListAsPerCemetery?country_id='.$sf_user->getAttribute('cn').'&cemetery_id='.$sf_user->getAttribute('cm').'&arval='.$sf_user->getAttribute('ar').'&render_partial=getAreaListLink'),
			'loading' => '$("#IdAjaxLocaderArea").show();',
			'complete'=> '$("#IdAjaxLocaderArea").hide();'
		)));
	if($sf_user->getAttribute('ar') == ''):
		 echo javascript_tag(
		  jq_remote_function(array(
			'update'  => 'grave_section_list',
			'url'     => url_for('grave/getSectionListAsPerArea?country_id='.$sf_user->getAttribute('cn').'&cemetery_id='.$sf_user->getAttribute('cm').'&secval='.$sf_user->getAttribute('sc').'&render_partial=getSectionListLink'),
			'loading' => '$("#IdAjaxLocaderSection").show();',
  			'complete'=> '$("#IdAjaxLocaderSection").hide();'
		  ))); 		
	endif; 
	if($sf_user->getAttribute('sc') == '' && $sf_user->getAttribute('ar') == ''): 
		echo javascript_tag(
			jq_remote_function(array(
				'update'  => 'grave_row_list',
				'url'     => url_for('grave/getRowListAsPerSection?country_id='.$sf_user->getAttribute('cn').'&cemetery_id='.$sf_user->getAttribute('cm').'&rwval='.$sf_user->getAttribute('rw').'&render_partial=getRowListLink'),
				'loading' => '$("#IdAjaxLocaderRow").show();',
			  	'complete'=> '$("#IdAjaxLocaderRow").hide();'
			))); 
	endif;
	if($sf_user->getAttribute('rw') == '' && $sf_user->getAttribute('sc') == '' && $sf_user->getAttribute('ar') == ''): 
	 echo javascript_tag(
		jq_remote_function(array(
			'update'  => 'grave_plot_list',
			'url'     => url_for('grave/getPlotListAsPerRow?country_id='.$sf_user->getAttribute('cn').'&cemetery_id='.$sf_user->getAttribute('cm').'&plval='.$sf_user->getAttribute('pl').'&render_partial=getPlotListLink'),
			'loading' => '$("#IdAjaxLocaderPlot").show();',
		 	'complete'=> '$("#IdAjaxLocaderPlot").hide();'
		))); 
	 endif;	
	if($sf_user->getAttribute('pl') == '' && $sf_user->getAttribute('rw') == '' && $sf_user->getAttribute('sc') == '' && $sf_user->getAttribute('ar') == ''):
		echo javascript_tag(
		  jq_remote_function(array(
			'update'  => 'grave_list',
			'url'     => url_for('grave/getGraveListAsPerPlot?country_id='.$sf_user->getAttribute('cn').'&cemetery_id='.$sf_user->getAttribute('cm').'&gnval='.$sf_user->getAttribute('gn').'&render_partial=getGraveListLink'),
			'loading' => '$("#IdAjaxLocaderGrave").show();',
		  	'complete'=> '$("#IdAjaxLocaderGrave").hide();'
		  )));
	endif;	  	
endif; 

if($sf_user->getAttribute('ar') != ''): 
	 echo javascript_tag(
	  jq_remote_function(array(
		'update'  => 'grave_section_list',
		'url'     => url_for('grave/getSectionListAsPerArea?country_id='.$sf_user->getAttribute('cn').'&cemetery_id='.$sf_user->getAttribute('cm').'&area_id='.$sf_user->getAttribute('ar').'&secval='.$sf_user->getAttribute('sc').'&render_partial=getSectionListLink'),
		'loading' => '$("#IdAjaxLocaderSection").show();',
	  	'complete'=> '$("#IdAjaxLocaderSection").hide();'
	  ))); 

	 if($sf_user->getAttribute('sc') == ''): 
	 echo javascript_tag(
		
	  jq_remote_function(array(
		'update'  => 'grave_row_list',
		'url'     => url_for('grave/getRowListAsPerSection?country_id='.$sf_user->getAttribute('cn').'&cemetery_id='.$sf_user->getAttribute('cm').'&area_id='.$sf_user->getAttribute('ar').'&rwval='.$sf_user->getAttribute('rw').'&render_partial=getRowListLink'),
		'loading' => '$("#IdAjaxLocaderRow").show();',
	  	'complete'=> '$("#IdAjaxLocaderRow").hide();'
	  ))); 
	 endif; 

	 if($sf_user->getAttribute('rw') == '' && $sf_user->getAttribute('sc') == ''): 
	 echo javascript_tag(
	  jq_remote_function(array(
		'update'  => 'grave_plot_list',
		'url'     => url_for('grave/getPlotListAsPerRow?country_id='.$sf_user->getAttribute('cn').'&cemetery_id='.$sf_user->getAttribute('cm').'&area_id='.$sf_user->getAttribute('ar').'&plval='.$sf_user->getAttribute('pl').'&render_partial=getPlotListLink'),
		'loading' => '$("#IdAjaxLocaderPlot").show();',
	  	'complete'=> '$("#IdAjaxLocaderPlot").hide();'
	  ))); 
	 endif;  
	if($sf_user->getAttribute('rw') == '' && $sf_user->getAttribute('sc') == '' && $sf_user->getAttribute('pl') == ''):
	echo javascript_tag(
	  jq_remote_function(array(
		'update'  => 'grave_list',
		'url'     => url_for('grave/getGraveListAsPerPlot?country_id='.$sf_user->getAttribute('cn').'&cemetery_id='.$sf_user->getAttribute('cm').'&area_id='.$sf_user->getAttribute('ar').'&gnval='.$sf_user->getAttribute('gn').'&render_partial=getGraveListLink'),
		'loading' => '$("#IdAjaxLocaderGrave").show();',
  		'complete'=> '$("#IdAjaxLocaderGrave").hide();'
	  )));
	endif;	 
 endif; 


 if($sf_user->getAttribute('sc') != ''): 
	 echo javascript_tag(
	  jq_remote_function(array(
		'update'  => 'grave_row_list',
		'url'     => url_for('grave/getRowListAsPerSection?country_id='.$sf_user->getAttribute('cn').'&cemetery_id='.$sf_user->getAttribute('cm').'&area_id='.$sf_user->getAttribute('ar').'&section_id='.$sf_user->getAttribute('sc').'&rwval='.$sf_user->getAttribute('rw').'&render_partial=getRowListLink'),
		'loading' => '$("#IdAjaxLocaderRow").show();',
	  	'complete'=> '$("#IdAjaxLocaderRow").hide();'
	  ))); 
	  
	 if($sf_user->getAttribute('rw') == ''): 
	 echo javascript_tag(
	  jq_remote_function(array(
		'update'  => 'grave_plot_list',
		'url'     => url_for('grave/getPlotListAsPerRow?country_id='.$sf_user->getAttribute('cn').'&cemetery_id='.$sf_user->getAttribute('cm').'&area_id='.$sf_user->getAttribute('ar').'&section_id='.$sf_user->getAttribute('sc').'&plval='.$sf_user->getAttribute('pl').'&render_partial=getPlotListLink'),
		'loading' => '$("#IdAjaxLocaderPlot").show();',
	  	'complete'=> '$("#IdAjaxLocaderPlot").hide();'
	  ))); 
	 endif;
	if($sf_user->getAttribute('rw') == '' && $sf_user->getAttribute('pl') == ''):
	echo javascript_tag(
	  jq_remote_function(array(
		'update'  => 'grave_list',
		'url'     => url_for('grave/getGraveListAsPerPlot?country_id='.$sf_user->getAttribute('cn').'&cemetery_id='.$sf_user->getAttribute('cm').'&area_id='.$sf_user->getAttribute('ar').'&section_id='.$sf_user->getAttribute('sc').'&gnval='.$sf_user->getAttribute('gn').'&render_partial=getGraveListLink'),
		'loading' => '$("#IdAjaxLocaderGrave").show();',
	  	'complete'=> '$("#IdAjaxLocaderGrave").hide();'
	  )));
	endif;	 
	   
 endif; 

 if($sf_user->getAttribute('rw') != ''): 
	 echo javascript_tag(
	  jq_remote_function(array(
		'update'  => 'grave_plot_list',
		'url'     => url_for('grave/getPlotListAsPerRow?country_id='.$sf_user->getAttribute('cn').'&cemetery_id='.$sf_user->getAttribute('cm').'&area_id='.$sf_user->getAttribute('ar').'&section_id='.$sf_user->getAttribute('sc').'&row_id='.$sf_user->getAttribute('rw').'&plval='.$sf_user->getAttribute('pl').'&render_partial=getPlotListLink'),
		'loading' => '$("#IdAjaxLocaderPlot").show();',
	  	'complete'=> '$("#IdAjaxLocaderPlot").hide();'
	  )));
	if($sf_user->getAttribute('pl') == ''):
	echo javascript_tag(
	  jq_remote_function(array(
		'update'  => 'grave_list',
		'url'     => url_for('grave/getGraveListAsPerPlot?country_id='.$sf_user->getAttribute('cn').'&cemetery_id='.$sf_user->getAttribute('cm').'&area_id='.$sf_user->getAttribute('ar').'&section_id='.$sf_user->getAttribute('sc').'&row_id='.$sf_user->getAttribute('rw').'&gnval='.$sf_user->getAttribute('gn').'&render_partial=getGraveListLink'),
		'loading' => '$("#IdAjaxLocaderGrave").show();',
	  	'complete'=> '$("#IdAjaxLocaderGrave").hide();'
	  )));
	endif;   
 endif;

if($sf_user->getAttribute('pl') != ''):
echo javascript_tag(
  jq_remote_function(array(
    'update'  => 'grave_list',
    'url'     => url_for('grave/getGraveListAsPerPlot?country_id='.$sf_user->getAttribute('cn').'&cemetery_id='.$sf_user->getAttribute('cm').'&area_id='.$sf_user->getAttribute('ar').'&section_id='.$sf_user->getAttribute('sc').'&row_id='.$sf_user->getAttribute('rw').'&plot_id='.$sf_user->getAttribute('pl').'&gnval='.$sf_user->getAttribute('gn').'&render_partial=getGraveListLink'),
	'loading' => '$("#IdAjaxLocaderGrave").show();',
	'complete'=> '$("#IdAjaxLocaderGrave").hide();'
  )));
endif;
if(!$sf_params->get('back') && $sf_user->isSuperAdmin()):
    echo javascript_tag("
        jQuery(document).ready(function() 
		{
			jQuery('#grave_country_id').attr('value', '".sfConfig::get('app_default_country_id')."');
			var snCountryId = jQuery('#grave_country_id').val();
			var snCemeteryId = $('#grave_cem_cemetery_id option').length;

			if(snCountryId > 0 && snCemeteryId == 1)
				callAjaxRequest(snCountryId,'".url_for('grave/getCementryListAsPerCountry?render_partial=getCementeryListLink')."','grave_cemetery_list');
		});
    ");
endif;
echo javascript_tag("
	jQuery(document).ready(function() 
	{
		$('table').find('tr:visible:odd').addClass('even').end().find('tr:visible:even').addClass('odd');
	});
");
?>

