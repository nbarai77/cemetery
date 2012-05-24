<?php 
	use_javascript('/sfFormExtraPlugin/js/double_list.js');
    use_helper('pagination');
    $ssModuleName = $sf_params->get('module'); 
	use_javascript('jqPlot/jquery.jqplot.min.js');
	use_javascript('jqPlot/core/shCore.min.js');
	use_javascript('jqPlot/core/shBrushJScript.min.js');
	use_javascript('jqPlot/core/shBrushXml.min.js');
	use_javascript('jqPlot/plugins/jqplot.barRenderer.min.js');
	use_javascript('jqPlot/plugins/jqplot.categoryAxisRenderer.min.js');
	use_javascript('jqPlot/plugins/jqplot.pointLabels.min.js');
	use_javascript('jqPlot/plugins/jqplot.highlighter.min.js');
	use_javascript('jqPlot/plugins/jqplot.cursor.min.js');
	use_stylesheet('jqPlot/jquery.jqplot.min.css');
?>
<div id="wapper">
<?php 
    echo $oGravePlotReportForm->renderFormTag(
        url_for($sf_params->get('module').'/gravePlotReport'), 
        array("name" => $oGravePlotReportForm->getName(), "method" => "post" ,'enctype'=>'multipart/form-data')
    );
?>
    <div class="comment_list"></div>
    <h1><?php echo __('Grave/Plot Report');?></h1>
    <div id="message">
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
                                	<?php echo $oGravePlotReportForm['country_id']->renderLabel($oGravePlotReportForm['country_id']->renderLabelName());?>
                        		</td>
	
                            	<td valign="middle" width="30%">
                                	<?php 
                                	    if($oGravePlotReportForm['country_id']->hasError()):
                                    	    echo $oGravePlotReportForm['country_id']->renderError();
                                        endif;
									    echo $oGravePlotReportForm['country_id']->render(array('class'=>'inputBoxWidth')); 
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
										include_partial('getCementeryList', array('asCementryList' => $asCementery,'snCementeryId' => $snCemeteryId)); 
								    ?>
                                </td>
                    		</tr>
							<?php endif;?>		

						
							<tr>
                            	<td valign="middle" align="right" width="20%">
									<?php echo __('Select Area')?>
                        		</td>
	
                            	<td valign="middle" width="30%" colspan="3">
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
                                	<?php echo $oGravePlotReportForm['from_date']->renderLabel($oGravePlotReportForm['from_date']->renderLabelName());?>
                        		</td>
	
                            	<td valign="middle" width="30%">
                                	<?php 
                                	    if($oGravePlotReportForm['from_date']->hasError()):
                                    	    echo $oGravePlotReportForm['from_date']->renderError();
                                        endif;
									    echo $oGravePlotReportForm['from_date']->render(array('class'=>'inputBoxWidth')); 
								    ?>
                                </td>
                    		
                            	<td valign="middle" align="right" width="20%">
                                	<?php echo $oGravePlotReportForm['to_date']->renderLabel($oGravePlotReportForm['to_date']->renderLabelName());?>
                        		</td>
	
                            	<td valign="middle" width="30%">
                                	<?php 
                                	    if($oGravePlotReportForm['to_date']->hasError()):
                                    	    echo $oGravePlotReportForm['to_date']->renderError();
                                        endif;
									    echo $oGravePlotReportForm['to_date']->render(array('class'=>'inputBoxWidth')); 
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
    <?php
        echo input_hidden_tag('id', $sf_params->get('id'), array('readonly' => 'true'));
        echo input_hidden_tag('tab', ($sf_params->get('tab') ? $sf_params->get('tab') :'info'), array('readonly' => 'true'));
        echo $oGravePlotReportForm->renderHiddenFields(); 
    ?>
    </form>
    <div class="clearb">&nbsp;</div>
    <?php if(count($amGravePlotReportAsPerDateResult) > 0 || count($amGravePlotReportResult) > 0 ):?>
    <div class="fright">
        <?php 
            $ssActionName = 'printServiceReport?report_type=grave&country_id='.$snCountryId.'&cemetery_id='.$snCemeteryId.'&from_date='.$ssFromDate.'&to_date='.$ssToDate;
            echo link_to(__('Print Report'), url_for($ssModuleName.'/'.$ssActionName), array('title' => __('Print Report')));
        ?>
    </div>
	 <div class="clearb">&nbsp;</div>
    <?php endif; 
			$snTotVacant = $snTotPrePurchase = $snTotInUse = $snTotToBeInvestigated = $snTotTree = $snTotReserved = $snTotOnHold = $snTotaAllocated = $snTotObstruction = 0;
			if(count($amGravePlotReportAsPerDateResult) > 0):
				$snTotVacant 			= isset($amGravePlotReportAsPerDateResult[0]) ? $amGravePlotReportAsPerDateResult[0]['COUNT'] : 0;
				$snTotPrePurchase 		= isset($amGravePlotReportAsPerDateResult[1]) ? $amGravePlotReportAsPerDateResult[1]['COUNT'] : 0;
				$snTotInUse 			= isset($amGravePlotReportAsPerDateResult[2]) ? $amGravePlotReportAsPerDateResult[2]['COUNT'] : 0;
				$snTotToBeInvestigated	= isset($amGravePlotReportAsPerDateResult[3]) ? $amGravePlotReportAsPerDateResult[3]['COUNT'] : 0;
				$snTotTree 				= isset($amGravePlotReportAsPerDateResult[4]) ? $amGravePlotReportAsPerDateResult[4]['COUNT'] : 0;
				$snTotReserved 			= isset($amGravePlotReportAsPerDateResult[5]) ? $amGravePlotReportAsPerDateResult[5]['COUNT'] : 0;
				$snTotOnHold 			= isset($amGravePlotReportAsPerDateResult[6]) ? $amGravePlotReportAsPerDateResult[6]['COUNT'] : 0;
				$snTotaAllocated 		= isset($amGravePlotReportAsPerDateResult[7]) ? $amGravePlotReportAsPerDateResult[7]['COUNT'] : 0;
				$snTotObstruction 		= isset($amGravePlotReportAsPerDateResult[8]) ? $amGravePlotReportAsPerDateResult[8]['COUNT'] : 0;
			endif;
			
			if($ssFromDate != '' && $ssToDate !=''):?>
				<script class="code" type="text/javascript">
					$(document).ready(function()
					{
						var snTotVacant 			= '<?php echo $snTotVacant; ?>';
						var snTotPrePurchase 		= '<?php echo $snTotPrePurchase; ?>';
						var snTotInUse 				= '<?php echo $snTotInUse ?>';
						var snTotToBeInvestigated	= '<?php echo $snTotToBeInvestigated; ?>';
						var snTotTree 				= '<?php echo $snTotTree; ?>';
						var snTotReserved 			= '<?php echo $snTotReserved; ?>';
						var snTotOnHold 			= '<?php echo $snTotOnHold; ?>';
						var snTotaAllocated 		= '<?php echo $snTotaAllocated; ?>';
						var snTotObstruction 		= '<?php echo $snTotObstruction; ?>';
						
						var s1 = [snTotVacant,snTotPrePurchase,snTotInUse,snTotToBeInvestigated,snTotTree,snTotReserved,snTotOnHold,snTotaAllocated,snTotObstruction];
									
                        var ssVacant 			= '<?php echo __("Vacant"); ?>';
						var ssPrePurchase 		= '<?php echo __("Pre-Purchased"); ?>';
						var ssInUse 			= '<?php echo __("In Use"); ?>';
						var ssToBeInvestigated	= '<?php echo __("To Be Investigated"); ?>';
						var ssTree 				= '<?php echo __("Tree"); ?>';
						var ssReserved 			= '<?php echo __("Reserved"); ?>';
						var ssOnHold 			= '<?php echo __("On Hold"); ?>';
						var ssAllocated 		= '<?php echo __("Allocated"); ?>';
						var ssObstruction 		= '<?php echo __("Obstruction"); ?>';
									
						// Can specify a custom tick Array.
						// Ticks should match up one for each y value (category) in the series.
						var ticks = [ssVacant, ssPrePurchase, ssInUse, ssToBeInvestigated, ssTree, ssReserved, ssOnHold, ssAllocated, ssObstruction];
						
						var plot1 = $.jqplot('chart1', [s1], {
						
						title:'<strong style="font-size:22px;"><?php echo $ssFromDate."&nbsp;".__("To").":&nbsp;".$ssToDate; ?></strong>',
						// The "seriesDefaults" option is an options object that will
						// be applied to all series in the chart.
						seriesDefaults:{
							shadow: true,
							renderer:$.jqplot.BarRenderer,	
							pointLabels: { show: true, formatString: '%d' },					
							rendererOptions: {
								fillToZero: false,
								varyBarColor: true,
								useNegativeColors: true
							}
						},															
						// Custom labels for the series are specified with the "label"
						// option on the series option.  Here a series option object
						// is specified for each series.
						series:[
							{label:ssVacant},
							{label:ssPrePurchase},
							{label:ssInUse},
							{label:ssToBeInvestigated},
							{label:ssTree},
							{label:ssReserved},
							{label:ssOnHold},
							{label:ssAllocated},
							{label:ssObstruction}
						],
						// Show the legend and put it outside the grid, but inside the
						// plot container, shrinking the grid to accomodate the legend.
						// A value of "outside" would not shrink the grid and allow
						// the legend to overflow the container.
						axes: {
							// Use a category axis on the x axis and use our custom ticks.
							xaxis: {
								renderer: $.jqplot.CategoryAxisRenderer,
								ticks: ticks,
								label:'<?php echo __("Grave Status"); ?>'
							},
							// Pad the y axis just a little so bars can get close to, but
							// not touch, the grid boundaries.  1.2 is the default padding.
							yaxis: {
								pad: 1.2,
								tickOptions: {formatString: '%d'},
                                label:'<?php echo __("Grave"); ?>'
							}
						},															
						highlighter: {
							show: true,
							showMarker: false,
							tooltipFade: true,
							tooltipFadeSpeed: "slow",
							tooltipAxes: 'y',
							formatString: '<strong style="font-size:16px; color:#333333; background-color:#FFFFFF;">&nbsp;<?php echo __("Total"); ?>: %d&nbsp;</strong>'
						}
						});
					});
				</script>
				<div id="chart1" style="width:100%; height:470px;"></div>
			<?php endif;?>
	<div class="clearb">&nbsp;</div>
	<?php 
			$snTotVacant = $snTotPrePurchase = $snTotInUse = $snTotToBeInvestigated = $snTotTree = $snTotReserved = $snTotOnHold = $snTotaAllocated = $snTotObstruction = 0;
			if(count($amGravePlotReportResult) > 0):
				$snTotVacant 			= isset($amGravePlotReportResult[0]) ? $amGravePlotReportResult[0]['COUNT'] : 0;
				$snTotPrePurchase 		= isset($amGravePlotReportResult[1]) ? $amGravePlotReportResult[1]['COUNT'] : 0;
				$snTotInUse 			= isset($amGravePlotReportResult[2]) ? $amGravePlotReportResult[2]['COUNT'] : 0;
				$snTotToBeInvestigated	= isset($amGravePlotReportResult[3]) ? $amGravePlotReportResult[3]['COUNT'] : 0;
				$snTotTree 				= isset($amGravePlotReportResult[4]) ? $amGravePlotReportResult[4]['COUNT'] : 0;
				$snTotReserved 			= isset($amGravePlotReportResult[5]) ? $amGravePlotReportResult[5]['COUNT'] : 0;
				$snTotOnHold 			= isset($amGravePlotReportResult[6]) ? $amGravePlotReportResult[6]['COUNT'] : 0;
				$snTotaAllocated 		= isset($amGravePlotReportResult[7]) ? $amGravePlotReportResult[7]['COUNT'] : 0;
				$snTotObstruction 		= isset($amGravePlotReportResult[8]) ? $amGravePlotReportResult[8]['COUNT'] : 0;
			endif;
	
			if(count($amGravePlotReportResult) > 0):?>
			<script class="code" type="text/javascript">
				$(document).ready(function()
				{				
					var snTotVacant 			= '<?php echo $snTotVacant; ?>';
					var snTotPrePurchase 		= '<?php echo $snTotPrePurchase; ?>';
					var snTotInUse 				= '<?php echo $snTotInUse ?>';
					var snTotToBeInvestigated	= '<?php echo $snTotToBeInvestigated; ?>';
					var snTotTree 				= '<?php echo $snTotTree; ?>';
					var snTotReserved 			= '<?php echo $snTotReserved; ?>';
					var snTotOnHold 			= '<?php echo $snTotOnHold; ?>';
					var snTotaAllocated 		= '<?php echo $snTotaAllocated; ?>';
					var snTotObstruction 		= '<?php echo $snTotObstruction; ?>';

					var s1 = [snTotVacant,snTotPrePurchase,snTotInUse,snTotToBeInvestigated,snTotTree,snTotReserved,snTotOnHold,snTotaAllocated,snTotObstruction];
					
					var ssVacant 			= '<?php echo __("Vacant"); ?>';
					var ssPrePurchase 		= '<?php echo __("Pre-Purchased"); ?>';
					var ssInUse 			= '<?php echo __("In Use"); ?>';
					var ssToBeInvestigated	= '<?php echo __("To Be Investigated"); ?>';
					var ssTree 				= '<?php echo __("Tree"); ?>';
					var ssReserved 			= '<?php echo __("Reserved"); ?>';
					var ssOnHold 			= '<?php echo __("On Hold"); ?>';
					var ssAllocated 		= '<?php echo __("Allocated"); ?>';
					var ssObstruction 		= '<?php echo __("Obstruction"); ?>';
					
					//var s1 = [10,20,35,4,85,89,66,99,100];
								
					// Can specify a custom tick Array.
					// Ticks should match up one for each y value (category) in the series.
					var ticks = [ssVacant, ssPrePurchase, ssInUse, ssToBeInvestigated, ssTree, ssReserved, ssOnHold, ssAllocated, ssObstruction];
					
					//s1 = [[2006, 4],[2008, 9], [2009, 16],[2008, 9],[2008, 9]];
					
					var plot1 = $.jqplot('chart2', [s1], {
					
					title:'<strong style="font-size:22px;"><?php echo __("Total Grave/Plot Report"); ?></strong>',
					// The "seriesDefaults" option is an options object that will
					// be applied to all series in the chart.
					seriesDefaults:{
						shadow: true,
						renderer:$.jqplot.BarRenderer,
						pointLabels: { show: true, formatString: '%d' },
						rendererOptions: {
							fillToZero: false,
							varyBarColor: true,
							useNegativeColors: true
						}
					},															
					// Custom labels for the series are specified with the "label"
					// option on the series option.  Here a series option object
					// is specified for each series.
					series:[
							{label:ssVacant},
							{label:ssPrePurchase},
							{label:ssInUse},
							{label:ssToBeInvestigated},
							{label:ssTree},
							{label:ssReserved},
							{label:ssOnHold},
							{label:ssAllocated},
							{label:ssObstruction}
						],
					// Show the legend and put it outside the grid, but inside the
					// plot container, shrinking the grid to accomodate the legend.
					// A value of "outside" would not shrink the grid and allow
					// the legend to overflow the container.
					axes: {
						// Use a category axis on the x axis and use our custom ticks.
						xaxis: {
							renderer: $.jqplot.CategoryAxisRenderer,
							ticks: ticks,
							label:'<?php echo __("Grave Status"); ?>'
						},
						// Pad the y axis just a little so bars can get close to, but
						// not touch, the grid boundaries.  1.2 is the default padding.
						yaxis: {
							pad: 1.2,
							tickOptions: {formatString: '%d'},
                            label:'<?php echo __("Grave"); ?>'
						}
					},															
					highlighter: {
						show: true,
						showMarker: false,
						showTooltip: true,
						tooltipFade: true,
						tooltipFadeSpeed: "slow",
						tooltipAxes: 'y',
						formatString: '<strong style="font-size:16px; color:#333333; background-color:#FFFFFF;">&nbsp;<?php echo __("Total"); ?>: %d&nbsp;</strong>'
					}
					});
				});
				</script>
			<div id="chart2" style="width:100%; height:470px;"></div>
	<?php endif;?>
	<div class="clearb">&nbsp;</div>
	<?php if(count($amGraveSectionsReportList) > 0):
	    echo '<h1>'.__('Service By Area').':&nbsp;"'.$asAreaList[$snAreaId].'"</h1>';
        echo '<div class="clearb"></div>';
        include_partial('global/indicator');
	    echo jq_form_remote_tag(
                array(
                    'url'       => $ssModuleName.'/gravePlotReport?request_type=ajax_request',
                    'update'    => 'contentlisting',
                    'script'    => true,
                    'loading'   => jq_visual_effect('fadeIn','#indicator1'),
                    'complete'  => jq_visual_effect('fadeOut','#indicator1').";sortingdiv();",
                ),
                array('name' => $ssFormName, 'id' => $ssFormName)
            );

        echo input_hidden_tag('page',$snPage);
        echo input_hidden_tag('paging',$snPaging);
        echo input_hidden_tag('form_name',$ssFormName);
        echo input_hidden_tag('reports_ar_area_id', $snAreaId);
        echo input_hidden_tag('reports_cem_cemetery_id',$snCemeteryId);
        echo input_hidden_tag('reports_country_id',$snCountryId);

        echo '<div>';
            echo '<div style="width:100%;float:left;">';  
                if($snPageTotalGraveSectionsReportPages == 0): 
                    echo '<div class="warning-msg"><span>'.__('Record(s) not found').'</span></div>';
                else:
                    echo '<div id="contentlisting">';
                        include_partial(
                            'list_grave_report_middle_part',
                            array(
                                'oGraveSectionsReportList'  => $oGraveSectionsReportList,
                                'amGraveSectionsReportList'	=> $amGraveSectionsReportList,
								'amGraveAreaTotalReportResult' => $amGraveAreaTotalReportResult,
                                'amExtraParameters' 		=> $amExtraParameters,
                                'amSearch'          => '',		                                                
                                'ssModuleName'      => $ssModuleName,
                                'sortby'            => $amExtraParameters['ssSortBy'],
                                'sortmode'          => $amExtraParameters['ssSortMode'],
                                'inactivateIds'     => 'id_report',
                                'snCountryId'       => $snCountryId,
                                'snCemeteryId'      => $snCemeteryId,
                            )
                        );
                    echo "</div>";

                    include_partial(
                        'global/listing_bottom',
                        array(
                            'amPagerSearchResults'  => $oGraveSectionsReportList, 
                            'amExtraParameters'     => $amExtraParameters,
                        )
                    );
                endif;
            echo '</div>';
            echo '<div class="clearb">&nbsp;</div>';
        echo '</div>';
        echo '</form>'; 
         
        //Sorting for selected field
        echo javascript_tag('
            jQuery(document).ready(function() 
            {
                sortingdiv();
            });
            function sortingdiv()
            {
                showHideSortDiv("chkunchk2","selectopt2");
                showHideSortDiv("chkunchk3","selectopt3");  
            }');
        endif;      
    ?>	
</div>
<?php 
    
    
	if(!$sf_user->isSuperAdmin() && !$sf_request->isMethod('post'))
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
endif; 

if(!$sf_params->get('back') && !$sf_request->isMethod('post') && $sf_user->isSuperAdmin()):
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
