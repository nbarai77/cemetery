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
        url_for($sf_params->get('module').'/serviceReport'), 
        array("name" => $oGravePlotReportForm->getName(), "method" => "post" ,'enctype'=>'multipart/form-data')
    );
?>
    <div class="comment_list"></div>
    <h1><?php echo __('Cemetery Service Report');?></h1>
    <div id="message"></div>
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
										include_partial('getCementeryList', array('asCementryList' => $asCementery,'snCementeryId' => $snCementeryId)); 
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
    <?php if((isset($amServiceReportAsPerDateResult) && count($amServiceReportAsPerDateResult) > 0) || (isset($amServiceReportResult) && count($amServiceReportResult) > 0)):?>
    <div class="fright">
        <?php 
            $ssActionName = 'printServiceReport?report_type=service&country_id='.$snCountryId.'&cemetery_id='.$snCemeteryId.'&from_date='.$ssFromDate.'&to_date='.$ssToDate;
            echo link_to(__('Print Report'), url_for($ssModuleName.'/'.$ssActionName), array('title' => __('Print Report')));
        ?>
    </div>
	 <div class="clearb">&nbsp;</div>
    <?php 
        endif; 
        $snTotChapel = $snTotRoom = $snTotBurials = $snTotAshes = $snTotExhumation = 0;
        if(isset($amServiceReportAsPerDateResult) && count($amServiceReportAsPerDateResult) > 0):
            foreach($amServiceReportAsPerDateResult as $amResult):
                switch($amResult['ServiceType']['id']){
                    case 1:
                        $snTotBurials = $amResult['COUNT'];
                        break;
                    case 2:
                        $snTotExhumation = $amResult['COUNT'];
                        break;
                    case 3:
                        $snTotAshes = $amResult['COUNT'];
                        break;        
                }
            endforeach;
		    $snTotChapel 		= isset($amServiceReportAsPerDateResult[0]) ? $amServiceReportAsPerDateResult[0]['chapel'] : 0;
		    $snTotRoom 		    = isset($amServiceReportAsPerDateResult[0]) ? $amServiceReportAsPerDateResult[0]['room'] : 0;
        endif;
        if(isset($amServiceReportAsPerDateResult) && count($amServiceReportAsPerDateResult) > 0):
	?>
		<script class="code" type="text/javascript">
			$(document).ready(function(){
				var s1 = [<?php echo $snTotChapel; ?>,<?php echo $snTotRoom; ?>,<?php echo $snTotBurials ?>,<?php echo $snTotAshes; ?>,<?php echo $snTotExhumation ?>,];
				
				//var s1 = [10,20,35,4,85,89,66,99,100];
							
				// Can specify a custom tick Array.
				// Ticks should match up one for each y value (category) in the series.
				var ticks = ['<?php echo __("Chapel") ?>', '<?php echo __("Room") ?>', '<?php echo __("Burials") ?>', '<?php echo __("Ashes") ?>', '<?php echo __("Exhumations") ?>'];
				
				//s1 = [[2006, 4],[2008, 9], [2009, 16],[2008, 9],[2008, 9]];
				
				var plot1 = $.jqplot('chart1', [s1], {
				
				title:'<strong style="font-size:22px;"><?php echo $ssFromDate."&nbsp;".__("To").":&nbsp".$ssToDate; ?></strong>',
				// The "seriesDefaults" option is an options object that will
				// be applied to all series in the chart.
				seriesDefaults:{
					shadow: true,
					renderer:$.jqplot.BarRenderer,
					pointLabels: { show: true, formatString: '%d' },
					rendererOptions: {
								barSize: 30, 
								barPadding: 8,
								barMargin: 10,
								fillToZero: false,
								animation: {speed: 2500},
								varyBarColor: true,
								useNegativeColors: true
							}
				},															
				// Custom labels for the series are specified with the "label"
				// option on the series option.  Here a series option object
				// is specified for each series.
				series:[
					{label:'<?php echo __("Chapel") ?>'},
					{label:'<?php echo __("Room") ?>'},
					{label:'<?php echo __("Exhumations") ?>'},
					{label:'<?php echo __("Ashes") ?>'},
					{label:'<?php echo __("Burials") ?>'},
				],
				// Show the legend and put it outside the grid, but inside the
				// plot container, shrinking the grid to accomodate the legend.
				// A value of "outside" would not shrink the grid and allow
				// the legend to overflow the container.
				axes: {
					// Use a category axis on the x axis and use our custom ticks.
					xaxis: {
						renderer: $.jqplot.CategoryAxisRenderer,

						ticks: ticks
					},
					// Pad the y axis just a little so bars can get close to, but
					// not touch, the grid boundaries.  1.2 is the default padding.
					yaxis: {
						pad: 1.2,
						tickOptions: {formatString: '%d'}
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
	    <div id="chart1" style="width:100%; height:470px;"></div>
	<?php endif;?>
	<div class="clearb">&nbsp;</div>
	<?php 
	    $snTotChapel = $snTotRoom = $snTotBurials = $snTotAshes = $snTotExhumation = 0;
	    if(count($amServiceReportResult) > 0):
	        foreach($amServiceReportResult as $amResult):
                switch($amResult['ServiceType']['id']){
                    case 1:
                        $snTotBurials = $amResult['COUNT'];
                        break;
                    case 2:
                        $snTotExhumation = $amResult['COUNT'];
                        break;
                    case 3:
                        $snTotAshes = $amResult['COUNT'];
                        break;        
                }
            endforeach;
			$snTotChapel 		= isset($amServiceReportResult[0]) ? $amServiceReportResult[0]['chapel'] : 0;
			$snTotRoom 		    = isset($amServiceReportResult[0]) ? $amServiceReportResult[0]['room'] : 0;
		endif;
	    if(isset($amServiceReportResult) && count($amServiceReportResult) > 0):
    ?>
		<script class="code" type="text/javascript">
			$(document).ready(function(){
				var s1 = [<?php echo $snTotChapel; ?>,<?php echo $snTotRoom; ?>,<?php echo $snTotBurials; ?>,<?php echo $snTotAshes; ?>,<?php echo $snTotExhumation; ?>,];
				
				//var s1 = [10,20,35,4,85,89,66,99,100];
							
				// Can specify a custom tick Array.
				// Ticks should match up one for each y value (category) in the series.
				var ticks = ['<?php echo __("Chapel") ?>', '<?php echo __("Room") ?>', '<?php echo __("Burials") ?>', '<?php echo __("Ashes") ?>', '<?php echo __("Exhumations") ?>'];
				
				//s1 = [[2006, 4],[2008, 9], [2009, 16],[2008, 9],[2008, 9]];
				
				var plot1 = $.jqplot('chart2', [s1], {
				
				title:'<strong style="font-size:22px;"><?php echo __("Total Service Report")?></strong>',
				// The "seriesDefaults" option is an options object that will
				// be applied to all series in the chart.
				seriesDefaults:{
					shadow: true,
					renderer:$.jqplot.BarRenderer,
					pointLabels: { show: true, formatString: '%d' },
					rendererOptions: {
								barSize: 30, 
								barPadding: 8,
								barMargin: 10,
								fillToZero: false,
								animation: {speed: 2500},
								varyBarColor: true,
								useNegativeColors: true
							}
				},															
				// Custom labels for the series are specified with the "label"
				// option on the series option.  Here a series option object
				// is specified for each series.
				series:[
					{label:'<?php echo __("Chapel") ?>'},
					{label:'<?php echo __("Room") ?>'},
					{label:'<?php echo __("Exhumations") ?>'},
					{label:'<?php echo __("Ashes") ?>'},
					{label:'<?php echo __("Burials") ?>'},
				],
				// Show the legend and put it outside the grid, but inside the
				// plot container, shrinking the grid to accomodate the legend.
				// A value of "outside" would not shrink the grid and allow
				// the legend to overflow the container.
				axes: {
					// Use a category axis on the x axis and use our custom ticks.
					xaxis: {
						renderer: $.jqplot.CategoryAxisRenderer,
						ticks: ticks
					},
					// Pad the y axis just a little so bars can get close to, but
					// not touch, the grid boundaries.  1.2 is the default padding.
					yaxis: {
						pad: 1.2,
						tickOptions: {formatString: '%d'}
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
        <div id="chart2" style="width:100%; height:550px;"></div>				
	<?php endif;?>
	<div class="clearb">&nbsp;</div>
    <?php if(isset($amSerReportAsPerAreaList)):
        echo '<h1>'.__('Service By Area').':&nbsp;"'.$asAreaList[$snAreaId].'"</h1>';
        echo '<div class="clearb"></div>';
        include_partial('global/indicator');
	    echo jq_form_remote_tag(
                array(
                    'url'       => $ssModuleName.'/serviceReport?request_type=ajax_request',
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
                if($snPageTotalSerReportAsPerPages == 0): 
                    echo '<div class="warning-msg"><span>'.__('Record(s) not found').'</span></div>';
                else:
                    echo '<div id="contentlisting">';
                        include_partial(
                            'list_service_report_middle_part',
                            array(
                                'oGuardUserList'    => $oSerReportAsPerAreaList,
                                'amGuardUserList'   => $amSerReportAsPerAreaList,
                                'amExtraParameters' => $amExtraParameters,
                                'amSearch'          => '',		                                                
                                'ssModuleName'      => $ssModuleName,
                                'sortby'            => $amExtraParameters['ssSortBy'],
                                'sortmode'          => $amExtraParameters['ssSortMode'],
                                'inactivateIds'     => 'iduser',
                                'snCountryId'       => (isset($snCountryId)?$snCountryId:''),
                                'snCemeteryId'      => (isset($snCemeteryId)?$snCemeteryId:''),
                            )
                        );
                    echo "</div>";
					
                    include_partial(
                        'global/listing_bottom',
                        array(
                            'amPagerSearchResults'  => $oSerReportAsPerAreaList, 
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
						  'complete'=> '$("#IdAjaxLocaderArea").hide();'
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
