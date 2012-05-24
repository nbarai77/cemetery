<?php 
use_javascript('/sfFormExtraPlugin/js/double_list.js');
$ssModuleName = $sf_params->get('module'); 
?>
<script src="http://maps.google.com/maps?file=api&v=2&sensor=true&key=<?php echo sfConfig::get('app_google_map_key');?>" type="text/javascript"></script>
<div id="wapper"> 
	<?php echo form_tag(url_for($sf_params->get('module').'/onsiteGraves'), array('name' => 'frm_onsite_work_graves', 'method' => 'post'));?>
	<table width="70%" border="0" cellspacing="0" cellpadding="5">
		<tr>
			<td valign="middle" align="right" width="15%">
				<?php echo __('Select Onsite Work Date'); ?> : 
			</td>				
			<td valign="middle" width="15%">
				<?php echo input_tag('onsite_work_date',$ssOnsiteWorkDate); ?>
			</td>
			<td valign="middle" width="35%">
				<div class="actions">
					<ul class="fleft">
						<li class="list1">
							<span>
								<?php 
									echo submit_tag(
										__('Show'), 
										array(
											'class'     => 'delete',
											'name'      => 'submit_button',
											'title'     => __('Show'), 
											'tabindex'  => 2,
											'onclick'   => "jQuery('#tab').val('');"
										)
									);
								?>
							</span>
						</li>
						<li class="list1">
							<span>
								<?php  
									echo button_to(__('Reset'),url_for($sf_params->get('module').'/onsiteGraves'),
													array('class'=>'delete','title'=>__('Reset'),'alt'=>__('Cancel'),'tabindex'=>3));
								?>
							</span>
						</li>
						<li class="list1">
							<span>
								<?php  
									echo button_to(__('Back'),url_for($sf_params->get('module').'/index?'.html_entity_decode($amExtraParameters['ssQuerystr'])),
										 array('class'=>'delete','title'=>__('Back'),'alt'=>__('Back'),'tabindex'=>4));
								?>
							</span>
						</li>
					</ul>
				</div>
			</td>
		</tr>
	</table>
	</form>
	<div>
		<div style="width:100%;float:left;">	
			 <h1>
				<?php echo __('Onsite Work Graves List');?> 
			</h1> 	
		
			<!-------- LIST ON SITE GRAVES ------->						
			<div id="contentlisting">
			<?php
				include_partial('list_onsite_graves_middle_part',
								array('amOnSiteGraves'  	=> $amOnSiteGraves)
				);
			?>
			</div>
			<!-------- SHOW ONSITE GRAVES LOCATION ON MAP ------->
			<div class="clearb">&nbsp;</div>
			<?php if(count($amOnSiteGraves) > 0):?>				
				<table width="100%" cellspacing="0" cellpadding="0" border="0">
					<tr>
						<td align="center">
							<h2><?php echo __('Show Onsite Work Location On Map');?></h2>
						</td>
					</tr>
					<tr>
						<td align="center">
							<div id="map_canvas" style="width: 750px; height: 430px;float;left;"></div>
						</td>
						<!--<td width="35%">
							<div id="directionsPanel" style="float;left;overflow:auto;float:left"></div>
						</td>-->
					</tr>
				</table>
			<?php endif;?>
			</div>
		</div>
		<div class="clearb">&nbsp;</div>
		<?php foreach($amOnSiteGraves as $snKey => $asValues):
				$ssArea 	= ($asValues['area_name'] != '') ? $asValues['area_name'] : __('N/A');
				$ssSection	= ($asValues['section_name'] != '') ? $asValues['section_name'] : __('N/A');
				$ssRow 		= ($asValues['row_name'] != '') ? $asValues['row_name'] : __('N/A');
				$ssPlot		= ($asValues['plot_name'] != '') ? $asValues['plot_name'] : __('N/A');?>
				<div id="grave_info_<?php echo $snKey;?>" style="display:none;">
					<table style="font-family: Arial, Helvetica, sans-serif; font-size:13px;" cellpadding="1" cellspacing="0" width="100%">
						<tr>
							<td>
								<strong style="font-family: Arial, Helvetica, sans-serif; font-size:14px;"><u><?php echo __('Grave Details');?></u></strong>
							</td>
						</tr>
						<tr>
							<td><?php echo '<b>'.__('Cemetery: ').'</b>'.$asValues['cemetery_name'];?></td>
						</tr>
						<tr>
							<td><?php echo '<b>'.__('Area:').'</b>'.'&nbsp;'.$ssArea?></td>
						</tr>
						<tr>
							<td><?php echo '<b>'.__('Section:').'</b>'.'&nbsp;'.$ssSection?></td>
						</tr>
						<tr>
							<td><?php echo '<b>'.__('Row:').'</b>'.'&nbsp;'.$ssRow;?></td>
						</tr>
						<tr>
							<td><?php echo '<b>'.__('Plot:').'</b>'.'&nbsp;'.$ssPlot;?></td>
						</tr>
						<tr>
							<td><?php echo '<b>'.__('Grave: ').'</b>'.$asValues['grave_number'];?></td>
						</tr>
					</table>
			</div>
		<?php endforeach;?>
	</div>
</div>
<?php 
	//$ssImageName = url_for('images/jquery/calendar.gif').'/calendar.gif';		// LIVE
	$ssImageName = sfConfig::get('app_cal_image_path');							// LATEST

	if(count($amOnSiteGraves) > 0):
		echo javascript_tag('
				jQuery(document).ready(function() 
				{	
					load("'.$smLatLongDirections.'");
				});
			');
	endif;
	echo javascript_tag("
	jQuery(document).ready(function() 
	{		
		var params = {
			changeMonth : true,
			changeYear : true,
			numberOfMonths : 1,
			dateFormat: 'dd-mm-yy',
			showButtonPanel : true,
			showOn: 'button',
			buttonImage: '".$ssImageName."',
			buttonImageOnly: true,
			showSecond: false,
		 };
		$('#onsite_work_date').datepicker(params);		
	});
	
	function load(smLatLongData)
	{
		var amLatLong = smLatLongData.split('|');
		
		if (GBrowserIsCompatible()) 
		{
			var map = new GMap2(document.getElementById('map_canvas'));
			var smStartPoint = new GLatLng(".sfConfig::get('app_orgin_direction_point').");
			
			map.removeMapType(G_HYBRID_MAP);
			map.addControl(new GMapTypeControl());
			map.addControl(new GSmallMapControl());

			var smEndPoint, smLatLong;
			var html = [];
            for(var snI = 0; snI < amLatLong.length; snI++) 
			{
				smLatLong = amLatLong[snI].split(',');
				smEndPoint = new GLatLng(smLatLong[0],smLatLong[1]);
				var ssHtmlDiv = 'grave_info_'+snI;
				html[snI] = document.getElementById(ssHtmlDiv).innerHTML; 

				map.addOverlay( createMarker(smEndPoint, html[snI]) );
				map.setCenter(smEndPoint, 15);
            } 			
		}				
	}
	function createMarker(point, html)
	{
		var marker = new GMarker(point);		
		GEvent.addListener(marker, 'mouseover', function() {
			marker.openInfoWindowHtml(html);		
		});
		
		GEvent.addListener(marker, 'mouseout', function() {
			marker.closeInfoWindow();
		});
		return marker;
	}
");
?>