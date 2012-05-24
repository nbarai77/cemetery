<!--<link rel="stylesheet" href="/charts/amcharts/images/style.css" type="text/css">-->
<?php 
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
    <?php include_partial('global/indicator');?>

    <div id="result"></div>
    <?php
		 include_partial(
            'global/listing_top',
            array(
                'form_name'             => $ssFormName,
                'id_checkboxes'         => 'id[]',
                'inactivateIds'         => 'idgrave',
                'update_div'            => 'success_msgs',
                'url'                   => $ssModuleName.'/index?request_type=ajax_request',
                'admin_act_status'      => 'status',
                'admin_act_module'      => 'delete',
                'bStatusButton'         => 'false',
                'bChangeOrderButton'    => 'false',
                'back_url'				=> $ssModuleName.'/report?back=true',
                'bDeleteButton'    		=> 'cemAdmin',
                'checkbox'    			=> 'true',
            )
        );
        echo '<div>';
            echo '<div style="width:100%;float:left;">'; ?>
           
                	<div  id="contentlisting" >
						<div id="main" class="listtable">
    						<div class="maintablebg">
                                <div class="repotDesign">
                                	<table cellpadding="0" cellspacing="0" border="0" width="100%">
										<tr>
                                        	<td colspan="2"> 
                                            	<h1 style="text-align:left; width:100%;">
                                    				<?php 
														echo __('Cemetery & Burial Report').'&nbsp;';
														if($ssFromDate != '' && $ssToDate != '') echo __('(From').': '.$ssFromDate.' '.__('To').': '.$ssToDate.')';
													?> 
                                				</h1>
                                            </td>
                                        </tr>
                                        <tr>
											<td>
												<table cellspacing="0" cellpadding="0" border="0" width="100%">
													<tr>
														<th width="35%"></th>
														<th width="15%"><?php echo __('Interments');?></th>
														<th width="20%"><?php echo __('Occupied Graves');?></th>
														<th width="15%"><?php echo __('Empty Graves');?></th>
														<th width="15%"><?php echo __('Vacant Graves');?></th>
													</tr>
													<?php $snI=0;foreach($amFinalReport as $ssKey => $asData):?>
													<tr class="odd">
														<th><?php echo $ssKey.' : '.$asData['name']; ?></th>
														<td><?php 
															$snTotalInterments 		= isset($asData['total_interments']) ? $asData['total_interments'] : 0; 
															$snTotalOccupidGrave 	= isset($asData['total_occupied_grave']) ? $asData['total_occupied_grave'] : 0;
															$snTotalEmptyGrave 		= isset($asData['total_empty_grave']) ? $asData['total_empty_grave'] : 0;
															$snTotalVacantGraves	= isset($asData['total_vacant_grave']) ? $asData['total_vacant_grave'] : 0;

															$ssRequestIds = base64_encode(implode(",", $sf_data->getRaw('anRequestIds')));
															echo ($snTotalInterments > 0) ? link_to($snTotalInterments,
																url_for($sf_params->get('module').'/intermentDetails?ssSearchFor=cemetery&ssRequestIds='.$ssRequestIds),
																array('title' => __('See Details') ,'class' => 'link1')) : $snTotalInterments;
														?></td>
														<td class="green"><?php echo $snTotalOccupidGrave ?></td>
														<td class="red"><?php echo $snTotalEmptyGrave; ?></td>
														<td><?php echo $snTotalVacantGraves; ?></td>
													</tr>													
													<?php endforeach;?>
													<script class="code" type="text/javascript">
														$(document).ready(function(){
															var s1 = [<?php echo $amFinalReport['Cemetery']['total_interments']; ?>, <?php echo $amFinalReport['Area']['total_interments']; ?>, <?php echo $amFinalReport['Section']['total_interments']; ?>, <?php echo $amFinalReport['Row']['total_interments']; ?>, <?php echo $amFinalReport['Plot']['total_interments']; ?>,];

															var s2 = [<?php echo $amFinalReport['Cemetery']['total_occupied_grave']; ?>, <?php echo $amFinalReport['Area']['total_occupied_grave']; ?>, <?php echo $amFinalReport['Section']['total_occupied_grave']; ?>, <?php echo $amFinalReport['Row']['total_occupied_grave']; ?>, <?php echo $amFinalReport['Plot']['total_occupied_grave']; ?>];
															var s3 = [<?php echo $amFinalReport['Cemetery']['total_empty_grave']; ?>, <?php echo $amFinalReport['Area']['total_empty_grave']; ?>, <?php echo $amFinalReport['Section']['total_empty_grave']; ?>, <?php echo $amFinalReport['Row']['total_empty_grave']; ?>, <?php echo $amFinalReport['Plot']['total_empty_grave']; ?>];
															
															var s4 = [<?php echo $amFinalReport['Cemetery']['total_vacant_grave']; ?>, <?php echo $amFinalReport['Area']['total_vacant_grave']; ?>, <?php echo $amFinalReport['Section']['total_vacant_grave']; ?>, <?php echo $amFinalReport['Row']['total_vacant_grave']; ?>,<?php echo $amFinalReport['Plot']['total_vacant_grave']; ?>];

															// Can specify a custom tick Array.
															// Ticks should match up one for each y value (category) in the series.
															var ticks = ['Cemetery: <?php echo $amFinalReport['Cemetery']['name'];?>', 'Area: <?php echo $amFinalReport['Area']['name'];?>', 'Section: <?php echo $amFinalReport['Section']['name'];?>', 'Row: <?php echo $amFinalReport['Row']['name'];?>','Plot: <?php echo $amFinalReport['Plot']['name'];?>'];
															
															//s1 = [[2006, 4],[2008, 9], [2009, 16],[2008, 9],[2008, 9]];
															
															var plot1 = $.jqplot('chart1', [s1, s2, s3, s4], {
															
															title:'<strong style="font-size:22px;">Cemetery & Burial Report</strong>',
															// The "seriesDefaults" option is an options object that will
															// be applied to all series in the chart.
															seriesDefaults:{
																shadow: true,
																renderer:$.jqplot.BarRenderer,
																pointLabels: { show: true, formatString: '%d' },
																rendererOptions: {barSize: 30, barPadding: 8,barMargin: 10, fillToZero: false}
															},															
															// Custom labels for the series are specified with the "label"
															// option on the series option.  Here a series option object
															// is specified for each series.
															series:[
																{label:'Interments'},
																{label:'Occupied Graves'},
																{label:'Empty Graves'},
																{label:'Vacant Graves'}
															],
															// Show the legend and put it outside the grid, but inside the
															// plot container, shrinking the grid to accomodate the legend.
															// A value of "outside" would not shrink the grid and allow
															// the legend to overflow the container.
															legend: {
																show: true,
																placement: 'outsideGrid'
															},
															axes: {
																// Use a category axis on the x axis and use our custom ticks.
																xaxis: {
																	renderer: $.jqplot.CategoryAxisRenderer,
																	ticks: ticks,
																	label:'Cemetery And Burial Report'
																},
																// Pad the y axis just a little so bars can get close to, but
																// not touch, the grid boundaries.  1.2 is the default padding.
																yaxis: {
																	pad: 1.01,
																	tickOptions: {formatString: '%d'},
																	label:'Grave'
																}
															},															
															highlighter: {
																show: true,
																showMarker: false,
																showTooltip: true,
																tooltipFade: true,
																tooltipFadeSpeed: "slow",
																tooltipAxes: 'y',
																formatString: '<strong style="font-size:16px; color:#333333; background-color:#FFFFFF;">&nbsp;Total: %d&nbsp;</strong>'
															}
															});
														});
														</script>
												</table>
											</td>
										</tr>
                                     </table>       
                                </div>						
							</div>
						</div>
					</div>
	<?php
            echo '</div>';
            echo '<div class="clearb">&nbsp;</div>';
        echo '</div>';    	
    ?>
    <div class="clearb">&nbsp;</div>
	<div id="chart1" style="width:100%; height:550px;"></div>
    </form>
</div>
