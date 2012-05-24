<?php
$amGraveDetails = explode(",", base64_decode($_REQUEST['ssParams']) );
if(count($amGraveDetails) > 0)
{
	$ssCemetery = $amGraveDetails[0];
	$ssArea		= $amGraveDetails[1];
	$ssSection	= $amGraveDetails[2];
	$ssRow		= $amGraveDetails[3];
	$ssPlot		= $amGraveDetails[4];
	$ssGrave	= $amGraveDetails[5];
	$smLat		= $amGraveDetails[6];
	$smLong		= $amGraveDetails[7];
}
//$ssGoogleMapApiKey = "ABQIAAAARzE1o5C--2H_UAq2UEWiOhT9a5hZzoS1WWnDpo10qGpCE-Sh8xSjFfb3ZaBsHmH85mmvFgdIRnxiiA";		// GOOGLE MAP API KEY FOR "interments.info"
$ssGoogleMapApiKey = "ABQIAAAARzE1o5C--2H_UAq2UEWiOhQc_vR0YPdpPF4MBWXByvnh0paSJRRLJ4GxSmuXkrGAxgNNBD-8co5jRw";		// GOOGLE MAP API KEY FOR "admin.cemetery.ntn"
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
<title>Cemetery</title>
<script src="http://maps.google.com/maps?file=api&v=2&sensor=true&key=<?php echo $ssGoogleMapApiKey;?>" type="text/javascript"></script>
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
		var map = new GMap2(document.getElementById("map"));
		var point = new GLatLng(smLat,smLong);
		var marker = new GMarker(point);
		map.addOverlay(marker);
		map.addControl(new GSmallMapControl());
		
		map.setCenter(point, 13);
		GEvent.addListener(marker, "click", function(){
			marker.openInfoWindowHtml(document.getElementById('grave_info').innerHTML);
		});
	}
	
}

//]]>
</script>
</head>
<body onload="load('<?php echo $smLat; ?>','<?php echo $smLong; ?>')" onunload="GUnload()">
<div id="map" style="width: 580px; height: 430px"></div>
<div id="grave_info" style="display:none;">
	<strong style="font-family: Arial, Helvetica, sans-serif; font-size:14px;"><u><?php echo 'Grave Details';?></u></strong>
	<div style="font-family: Arial, Helvetica, sans-serif; font-size:13px;">
		<div><?php echo '<b>Cemetery:&nbsp;</b>'.$ssCemetery;?></div>	
		<div><?php echo '<b>Area:</b>&nbsp;'.$ssArea ;?> </div>
		<div><?php echo '<b>Section:</b>&nbsp;'.$ssSection;?></div>
		<div><?php echo '<b>Row:</b>&nbsp;'.$ssRow;?></div>
		<div><?php echo '<b>Plot:</b>&nbsp;'.$ssPlot;?></div>
		<div><?php echo '<b>Grave:&nbsp;</b>'.$ssGrave;?></div>	
	</div>
</div>
</body>
</html>
