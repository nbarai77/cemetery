<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
<title>Cemetery</title>
<script src="http://maps.google.com/maps?file=api&v=2&sensor=true&key=<?php echo sfConfig::get('app_google_map_key');?>" type="text/javascript"></script>
<script type="text/javascript">

//<![CDATA[

function load(smLat, smLong) 
{
	if(smLat == '' || smLong == '')
	{
		alert('No latitude & longitude define for this grave');
		return false;
	}
	
	if (GBrowserIsCompatible()) 
	{
		var map = new GMap2(document.getElementById("map_canvas"));
		
		var smStartPoint = new GLatLng(<?php echo $ssCemLat; ?>, <?php echo $ssCemLong; ?>);
		var smEndPoint = new GLatLng(smLat,smLong);
		
		var smDirectionStartPoint = <?php echo $ssCemLat; ?>+','+<?php echo $ssCemLong; ?>;
		var smDirectionEndPoint = smLat+','+smLong;		
		
		map.removeMapType(G_HYBRID_MAP);
		map.addControl(new GMapTypeControl());
		map.addControl(new GSmallMapControl());
		
		var marker = new GMarker(smEndPoint);
		map.addOverlay(marker);
		map.setCenter(smEndPoint, 15);
		GEvent.addListener(marker, "click", function(){
			marker.openInfoWindowHtml(document.getElementById('grave_info').innerHTML);
		});
		
		directionsPanel = document.getElementById("directionsPanel");
		directions = new GDirections(map, directionsPanel);
		directions.load(smDirectionStartPoint+" to "+smDirectionEndPoint);
	}
	
}

//]]>
</script>
</head>
<body onload="load('<?php echo $smLat; ?>','<?php echo $smLong; ?>');">
<!---------------------- Map CAnvas -------------------->
<div id="showmap">
<table width="100%" cellpadding="0" cellpadding="0" border="0">
	<tr>
		<td width="30%" valign="top">
			<div id="directionsPanel" style="float;left;overflow:auto;"></div>
		</td>
		<td width="70%">
			<div id="map_canvas" style="width: 780px; height: 450px;float;left;"></div>
		</td>
	</tr>
</table>
</div>
<!---------------------- Map Marker Click -------------------->
<div id="grave_info" style="display:none;">
	<strong style="font-family: Arial, Helvetica, sans-serif; font-size:14px;"><u><?php echo __('Grave Details');?></u></strong>
	<div style="font-family: Arial, Helvetica, sans-serif; font-size:13px;">
		<div><?php echo '<b>'.__('Cemetery: ').'</b>'.$ssCemetery;?></div>	
		<div><?php echo '<b>'.__('Area:').'</b>'.'&nbsp;'.$ssArea ;?> </div>
		<div><?php echo '<b>'.__('Section:').'</b>'.'&nbsp;'.$ssSection;?></div>
		<div><?php echo '<b>'.__('Row:').'</b>'.'&nbsp;'.$ssRow;?></div>
		<div><?php echo '<b>'.__('Plot:').'</b>'.'&nbsp;'.$ssPlot;?></div>
		<div><?php echo '<b>'.__('Grave: ').'</b>'.$ssGrave;?></div>	
	</div>
</div>
</body>
</html>
