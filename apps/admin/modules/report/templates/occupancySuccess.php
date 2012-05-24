<?php 

	ini_set('memory_limit', '-1');
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
<?php 
    use_helper('pagination');
    $ssModuleName = $sf_params->get('module'); 
?>
<div id="wapper">    
    <?php include_partial('global/indicator');?>

    <div id="result"></div>
    <?php
		echo '<div class="clearb">&nbsp;</div>';
        echo '<div>';
            echo '<div style="width:100%;float:left;">'; ?>           
                	<div  id="contentlisting" >
						<div id="main" class="listtable bordernone1">
    						<div class="maintablebg">
                                <div class="repotDesign">
									<table cellpadding="0" cellspacing="1" border="0" width="100%">
										<?php if($sf_user->isSuperAdmin()):?>
										<?php echo form_tag('report/occupancy', array('method' => 'post', 'name' => 'frmoccupancyreport'));?>
											<tr>
												<td align="right" valign="middle" width="50%">
													<?php 
														if($sf_user->hasFlash('ssErrorCemeter') && $sf_user->getFlash('ssErrorCemeter') != ''):
															echo '<ul class="error_list"><li>'.$sf_user->getFlash('ssErrorCemeter').'</li></ul>';
															$sf_user->setFlash('ssErrorCemeter','');
														endif;
														echo select_tag('report_cem_cemetery_id', options_for_select($asCementryList , isset($snCementeryId) ? $snCementeryId : '', 'include_custom='.__('--- Select Cementery ----')));?>
												</td>
												<td width="50%">
													<?php echo submit_tag(__('Generate Report'),array('title' => __('Generate Report') ));?>
												</td>
											</tr>
										</form>
										<?php endif;?>
										<tr class="heading"> 
											<th colspan="2">
												<h3 style="text-align:center; padding:0px 0px; width:100%;">
													<?php echo __('Ocupancy Report');?> 
												</h3>
											</th>
										</tr>
										<script class="code" type="text/javascript">
											var s1 = new Array();
											var ticks = new Array();
										</script>
										 <?php 
									 		if($snTotalRecords > 0): 
												echo '<tr><td align="center" valign="top" colspan="2">';
												echo '<strong>'.$snTotalVacantGrave.'</strong>&nbsp;'.__('Graves vacant');
												echo '</td></tr>';
										 		foreach($results as $snKey=>$ssValues): ?>
													<tr>
														<td align="center" valign="top" colspan="2"> 
															<?php echo '<strong>'.$ssValues.'</strong>&nbsp;'.__('Graves have').'&nbsp;<strong>'.$snKey.'</strong>&nbsp;'.__('interments'); ?>
														</td>
													</tr>
													
													<script class="code" type="text/javascript">
														$(document).ready(function(){
															s1.push(<?php echo $ssValues; ?>);
															ticks.push(<?php echo $snKey; ?>);
														});
													</script>

													
										<?php 	endforeach;
											else:										
												echo '<tr><td align="left" valign="top" colspan="2"><div class="warning-msg"><span>'.__('Record(s) not found').'</span></div></td></tr>';
											endif;?>
                                	</table>
                                	
                                	<script class="code" type="text/javascript">
										
										$(document).ready(function(){
											var plot1 = $.jqplot('chart1', [s1], {
												
											title:'<strong style="font-size:22px;">Cemetery Occupancy Report</strong>',
											// The "seriesDefaults" option is an options object that will
											// be applied to all series in the chart.
											seriesDefaults:{
												shadow: true,
												renderer:$.jqplot.BarRenderer,
												rendererOptions: {barSize: 30, barPadding: 8,barMargin: 10, fillToZero: false}
											},				
											
											series:[
												{label:'Interments'},
											],																				

											legend: {
												show: true,
												placement: 'outsideGrid'
											},
											axes: {
												// Use a category axis on the x axis and use our custom ticks.
												xaxis: {
													renderer: $.jqplot.CategoryAxisRenderer,
													ticks: ticks,
													tickOptions: {formatString: '<stron style="font-size:16px;">%d</stron>'},
													label:'Interments'
												},
												// Pad the y axis just a little so bars can get close to, but
												// not touch, the grid boundaries.  1.2 is the default padding.
												yaxis: {
													pad: 1.01,
													tickOptions: {formatString: '<stron style="font-size:12px;">%d</stron>'},
													label:'Graves'
												}
											},															
											highlighter: {
												show: true,
												showMarker: false,
												showTooltip: true,
												tooltipFade: true,
												tooltipFadeSpeed: "slow",
												tooltipAxes: 'y',
												//formatString: '<stron style="font-size:14px;">Interments</stron>'
											}
											})
										});
									
									
									</script>	                                	
                                	
                                	
                                	
									</div>
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
    <div class="clearb">&nbsp;</div>
    </form>
    <div class="clearb">&nbsp;</div>
	<div id="chart1" style="width:100%; height:550px;"></div>    
    
</div>
<?php
echo javascript_tag("
	jQuery(document).ready(function() 
		{
			$('table').find('tr:visible:odd').addClass('even').end().find('tr:visible:even').addClass('odd');
			
		});
");
?>
