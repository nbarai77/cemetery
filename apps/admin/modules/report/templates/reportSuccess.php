<?php use_javascript('/sfFormExtraPlugin/js/double_list.js');?>
<div id="wapper">
<?php 
    echo $oReportForm->renderFormTag(
        url_for($sf_params->get('module').'/'.'index'), 
        array("name" => $oReportForm->getName(), "method" => "post" ,'enctype'=>'multipart/form-data')
    );
?>
    <div class="comment_list"></div>
    <h1><?php echo __('Cemetery & Burial Report');?></h1>
    <div id="message">
        <div id="success_msgs">
            <?php echo include_partial('global/notification_msg', array('amSuccessMsg' => $amSuccessMsg,'amErrorMsg' => $amErrorMsg));?>
        </div>
    </div>
    <div class="clearb">&nbsp;</div>    
    <div id="main">
        <div class="maintablebg">
            <div class="main_cont">
                <div class="">
            		<div id="info">
                		<table width="100%" border="0" cellspacing="0" cellpadding="0" class="sub_table">

							<?php if($sf_user->isSuperAdmin()):?>
                    		<tr>
                            	<td valign="middle" align="right" width="20%">
                                	<?php echo $oReportForm['country_id']->renderLabel($oReportForm['country_id']->renderLabelName());?>
                        		</td>
	
                            	<td valign="middle" width="30%">
                                	<?php 
                                	    if($oReportForm['country_id']->hasError()):
                                    	    echo $oReportForm['country_id']->renderError();
                                        endif;
									    echo $oReportForm['country_id']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>
                    		
                            	<td valign="middle" align="right" width="20%">
									<?php echo __('Select Cementery')?>
                        		</td>
	
                            	<td valign="middle" width="30%" align="left">
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
                            	<td valign="middle" align="right" width="20%">
									<?php echo __('Select Area')?>
                        		</td>
	
                            	<td valign="middle" width="30%">
                                	<?php 
										if($sf_user->hasFlash('ssErrorArea') && $sf_user->getFlash('ssErrorArea') != ''):
											echo '<ul class="error_list"><li>'.$sf_user->getFlash('ssErrorArea').'</li></ul>';
											$sf_user->setFlash('ssErrorArea','');
										endif;
										include_partial('getAreaList', array('asAreaList' => $asAreaList,'snAreaId' => $snAreaId)); 
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
										include_partial('getSectionList', array('asSectionList' => $asSectionList,'snSectionId' => $snSectionId)); 
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
										include_partial('getRowList', array('asRowList' => $asRowList,'snRowId' => $snRowId)); 
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
										include_partial('getPlotList', array('asPlotList' => $asPlotList,'snPlotId' => $snPlotId)); 
								    ?>
                                </td>                                
                    		</tr>
							
							<tr>
                            	<td valign="middle" align="right" width="20%">
                                	<?php echo $oReportForm['from_date']->renderLabel($oReportForm['from_date']->renderLabelName());?>
                        		</td>
	
                            	<td valign="middle" width="30%">
                                	<?php 
                                	    if($oReportForm['from_date']->hasError()):
                                    	    echo $oReportForm['from_date']->renderError();
                                        endif;
									    echo $oReportForm['from_date']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>
                    		
                            	<td valign="middle" align="right" width="20%">
                                	<?php echo $oReportForm['to_date']->renderLabel($oReportForm['to_date']->renderLabelName());?>
                        		</td>
	
                            	<td valign="middle" width="30%">
                                	<?php 
                                	    if($oReportForm['to_date']->hasError()):
                                    	    echo $oReportForm['to_date']->renderError();
                                        endif;
									    echo $oReportForm['to_date']->render(array('class'=>'inputBoxWidth')); 
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
	                                                        __('Search'), 
	                                                        array(
	                                                            'class'     => 'delete',
	                                                            'name'      => 'submit_button',
	                                                            'title'     => __('Search'), 
	                                                            'tabindex'  => 7,
	                                                            'onclick'   => "jQuery('#tab').val('');"
	                                                        )
	                                                    );
	                                                ?>
                                        		</span>
                                        	</li>
                                			<!--<li class="list1">
                                        		<span>
                                        			<?php  
                                        			 //   $ssCancelUrl    = $sf_params->get('module').'/index?'.html_entity_decode($amExtraParameters['ssQuerystr']);
                                                		//echo button_to(__('Cancel'),$ssCancelUrl,array('class'=>'delete','title'=>__('Cancel'),'alt'=>__('Cancel'),'tabindex'=>1));
                                                    ?>
                                    			</span>
                                    		</li>-->
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
        echo $oReportForm->renderHiddenFields(); 
    ?>
    </form>
</div>
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
					array('url'		=> url_for('report/getAreaListAsPerCemetery'),
						  'update'	=> 'reports_area_list',
						  'with'	=> "'cemetery_id='+".$snCemeteryId."+'&country_id='+$('#reports_country_id').val()",
						  'loading' => '$("#IdAjaxLocaderArea").show();',
						  'complete'=> '$("#IdAjaxLocaderArea").hide();'.jq_remote_function(
									array('url'		=> url_for('report/getSectionListAsPerArea'),
										  'update'	=> 'reports_section_list',
										  'with'	=> "'country_id='+$('#reports_country_id').val()+'&cemetery_id='+$('#reports_cem_cemetery_id').val()",
										  'loading' => '$("#IdAjaxLocaderSection").show();',
										  'complete'=> '$("#IdAjaxLocaderSection").hide();'.jq_remote_function(
													array('url'		=> url_for('report/getRowListAsPerSection'),
														  'update'	=> 'reports_row_list',
														  'with'	=> "'country_id='+$('#reports_country_id').val()+'&cemetery_id='+$('#reports_cem_cemetery_id').val()",
														  'loading' => '$("#IdAjaxLocaderRow").show();',
														  'complete'=> '$("#IdAjaxLocaderRow").hide();'.jq_remote_function(
																		array('url'		=> url_for('report/getPlotListAsPerRow'),
																			  'update'	=> 'reports_plot_list',
																			  'with'	=> "'country_id='+$('#reports_country_id').val()+'&cemetery_id='+$('#reports_cem_cemetery_id').val()",
																			  'loading' => '$("#IdAjaxLocaderPlot").show();',
																			  'complete'=> '$("#IdAjaxLocaderPlot").hide();'
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


<?php if($sf_user->getAttribute('cn') != ''):
echo javascript_tag(
  jq_remote_function(array(
    'update'  => 'reports_cemetery_list',
    'url'     => url_for('report/getCementryListAsPerCountry?id='.$sf_user->getAttribute('cn').'&cnval='.$sf_user->getAttribute('cm')),
	'loading' => '$("#IdAjaxLocaderCemetery").show();',
	'complete'=> '$("#IdAjaxLocaderCemetery").hide();'
  )));
endif;


if($sf_user->getAttribute('cm') != ''):
	echo javascript_tag(
		jq_remote_function(array(
			'update'  => 'reports_area_list',
			'url'     => url_for('report/getAreaListAsPerCemetery?country_id='.$sf_user->getAttribute('cn').'&cemetery_id='.$sf_user->getAttribute('cm').'&arval='.$sf_user->getAttribute('ar')),
			'loading' => '$("#IdAjaxLocaderArea").show();',
			'complete'=> '$("#IdAjaxLocaderArea").hide();'
		)));
	if($sf_user->getAttribute('ar') == ''):
		 echo javascript_tag(
		  jq_remote_function(array(
			'update'  => 'reports_section_list',
			'url'     => url_for('report/getSectionListAsPerArea?country_id='.$sf_user->getAttribute('cn').'&cemetery_id='.$sf_user->getAttribute('cm').'&secval='.$sf_user->getAttribute('sc')),
			'loading' => '$("#IdAjaxLocaderSection").show();',
			'complete'=> '$("#IdAjaxLocaderSection").hide();'
		  ))); 		
	endif; 
	if($sf_user->getAttribute('sc') == '' && $sf_user->getAttribute('ar') == ''): 
		echo javascript_tag(
			jq_remote_function(array(
				'update'  => 'reports_row_list',
				'url'     => url_for('report/getRowListAsPerSection?country_id='.$sf_user->getAttribute('cn').'&cemetery_id='.$sf_user->getAttribute('cm').'&rwval='.$sf_user->getAttribute('rw')),
				'loading' => '$("#IdAjaxLocaderRow").show();',
				'complete'=> '$("#IdAjaxLocaderRow").hide();'
			))); 
	endif;
	if($sf_user->getAttribute('rw') == '' && $sf_user->getAttribute('sc') == '' && $sf_user->getAttribute('ar') == ''): 
	 echo javascript_tag(
		jq_remote_function(array(
			'update'  => 'reports_plot_list',
			'url'     => url_for('report/getPlotListAsPerRow?country_id='.$sf_user->getAttribute('cn').'&cemetery_id='.$sf_user->getAttribute('cm').'&plval='.$sf_user->getAttribute('pl')),
			'loading' => '$("#IdAjaxLocaderPlot").show();',
			'complete'=> '$("#IdAjaxLocaderPlot").hide();'
		))); 
	 endif;	
endif; 



 if($sf_user->getAttribute('ar') != ''): 
	 echo javascript_tag(
	  jq_remote_function(array(
		'update'  => 'reports_section_list',
		'url'     => url_for('report/getSectionListAsPerArea?country_id='.$sf_user->getAttribute('cn').'&cemetery_id='.$sf_user->getAttribute('cm').'&area_id='.$sf_user->getAttribute('ar').'&secval='.$sf_user->getAttribute('sc')),
		'loading' => '$("#IdAjaxLocaderSection").show();',
		'complete'=> '$("#IdAjaxLocaderSection").hide();'
	  ))); 

	 if($sf_user->getAttribute('sc') == ''): 
	 echo javascript_tag(
		
	  jq_remote_function(array(
		'update'  => 'reports_row_list',
		'url'     => url_for('report/getRowListAsPerSection?country_id='.$sf_user->getAttribute('cn').'&cemetery_id='.$sf_user->getAttribute('cm').'&area_id='.$sf_user->getAttribute('ar').'&rwval='.$sf_user->getAttribute('rw')),
		'loading' => '$("#IdAjaxLocaderRow").show();',
		'complete'=> '$("#IdAjaxLocaderRow").hide();'
	  ))); 
	 endif; 

	 if($sf_user->getAttribute('rw') == '' && $sf_user->getAttribute('sc') == ''): 
	 echo javascript_tag(
	  jq_remote_function(array(
		'update'  => 'reports_plot_list',
		'url'     => url_for('report/getPlotListAsPerRow?country_id='.$sf_user->getAttribute('cn').'&cemetery_id='.$sf_user->getAttribute('cm').'&area_id='.$sf_user->getAttribute('ar').'&plval='.$sf_user->getAttribute('pl')),
		'loading' => '$("#IdAjaxLocaderPlot").show();',
		'complete'=> '$("#IdAjaxLocaderPlot").hide();'
	  ))); 
	 endif;
 endif; 


 if($sf_user->getAttribute('sc') != ''): 
	 echo javascript_tag(
	  jq_remote_function(array(
		'update'  => 'reports_row_list',
		'url'     => url_for('report/getRowListAsPerSection?country_id='.$sf_user->getAttribute('cn').'&cemetery_id='.$sf_user->getAttribute('cm').'&area_id='.$sf_user->getAttribute('ar').'&section_id='.$sf_user->getAttribute('sc').'&rwval='.$sf_user->getAttribute('rw')),
		'loading' => '$("#IdAjaxLocaderRow").show();',
		'complete'=> '$("#IdAjaxLocaderRow").hide();'
	  ))); 
	  
	 if($sf_user->getAttribute('rw') == ''): 
	 echo javascript_tag(
	  jq_remote_function(array(
		'update'  => 'reports_plot_list',
		'url'     => url_for('report/getPlotListAsPerRow?country_id='.$sf_user->getAttribute('cn').'&cemetery_id='.$sf_user->getAttribute('cm').'&area_id='.$sf_user->getAttribute('ar').'&section_id='.$sf_user->getAttribute('sc').'&plval='.$sf_user->getAttribute('pl')),
		'loading' => '$("#IdAjaxLocaderPlot").show();',
		'complete'=> '$("#IdAjaxLocaderPlot").hide();'
	  ))); 
	 endif;
 endif; 



 if($sf_user->getAttribute('rw') != ''): 
	 echo javascript_tag(
	  jq_remote_function(array(
		'update'  => 'reports_plot_list',
		'url'     => url_for('report/getPlotListAsPerRow?country_id='.$sf_user->getAttribute('cn').'&cemetery_id='.$sf_user->getAttribute('cm').'&area_id='.$sf_user->getAttribute('ar').'&section_id='.$sf_user->getAttribute('sc').'&row_id='.$sf_user->getAttribute('rw').'&plval='.$sf_user->getAttribute('pl')),
		'loading' => '$("#IdAjaxLocaderPlot").show();',
		'complete'=> '$("#IdAjaxLocaderPlot").hide();'
	  )));
 endif;

if(!$sf_params->get('back')):
    echo javascript_tag("
        jQuery(document).ready(function() 
		{
			jQuery('#reports_country_id').attr('value', '".sfConfig::get('app_default_country_id')."');
			var snCountryId = jQuery('#reports_country_id').val();
			var snCemeteryId = $('#reports_cem_cemetery_id option').length;

			if(snCountryId > 0 && snCemeteryId == 1)
				callAjaxRequest(snCountryId,'".url_for('report/getCementryListAsPerCountry')."','reports_cemetery_list');
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