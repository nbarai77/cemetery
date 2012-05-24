<?php 
/****************************************************
 * index.php
 *
 * @package    : Interment Search Plugin
 * @subpackage : view
 * @author     : Prakash Panchal
 * @version    : 1.0

****************************************************/

/*
include("../../../../members/bootstrap.php");
$oUser =  Am_Di::getInstance()->auth->getUser();

if($oUser == null)
	header('Location: http://interments.info/live/cemetery_live/web/searchPlugin/login.php');
*/
?>
<html>
<title>Deceased Search</title>
<head>
<script src="js/jquery-1.4.1.min.js"></script>
<script src="js/common.js"></script>

<link href="css/style.css" rel="stylesheet" type="text/css">

<script type="text/javascript" src="/sfJqueryReloadedPlugin/js/jquery-1.4.1.min.js"></script>
<script type="text/javascript" src="/js/admin/common.js"></script>
<script type="text/javascript" src="/js/nyroModal/jquery.nyroModal.custom.js"></script>
<script type="text/javascript" src="http://maps.google.com/maps?file=api&v=2&sensor=true&key=<?php //echo sfConfig::get('app_google_map_key');?>"></script>
<link rel="stylesheet" type="text/css" media="screen" href="/css/nyroModal/nyroModal.css" />

</head>
<body>
	<div style="width:80%; padding-left:15px;">
	<form method="post" name="searchinterment" id="searchinterment">
		<input type="hidden" readonly="true" name="page" id="page" value="<?php echo DEFAULT_PAGE?>">
		<input type="hidden" readonly="true" name="paging" id="paging" value="<?php echo DEFAULT_PER_PAGE?>">
		<table cellpadding="5" cellspacing="0" width="100%" border="0">
			<?php if($_REQUEST['ack'] == 'Success'):?>
			<tr>
				<td colspan="4" align="center">
					<strong style="color:#669900;"><?php echo 'Payement has been successfully done'; ?></strong>
				</td>
			</tr>
			<?php elseif($_REQUEST['ack'] == 'Failure'):?>
			<tr>
				<td colspan="4" align="center">					
					<strong style="color:#FF0000;"><?php echo 'Payment has been failure'; ?></strong>
				</td>
			</tr>
			<?php endif;?>
			<tr>
				<td colspan="3">
					<h1>Deceased Search</h1>
				</td>
				<?php if(!empty($oUser)):?>
					<td> <?php echo 'Welcome '.$oUser->login?>&nbsp;<a href="login.php?logout=true" title="Logout">Logout</a></td>
				<?php endif;?>
			</tr>
			<tr>
				<td colspan="4" align="left">
					<font style="font-weight:bold; color:#660000">
						Whilst our Deceased Search is now back online, please note that this facility continues to undergo regular maintenance.
					</font>
				</td>
			</tr>
			<tr>
				<td colspan="4" align="left">
					<strong>Deceased Details</strong>
				</td>
			</tr>
			<tr>
				<td width="20%" align="right">
					Name<strong style="color:#FF0000">*</strong>
				</td>
				<td align="left">					
					<input type="text" name="name" id="name" class="inputBoxWidth"/>
				</td>				
				<td width="20%" align="right">
					Surname<strong style="color:#FF0000">*</strong>
				</td>
				<td align="left" align="left">				
					<input type="text" name="surname" id="surname" class="inputBoxWidth" />
				</td>				
			</tr>
			<tr>
				<td colspan="4" align="left">
					<strong> Interment Year Range</strong>
				</td>
			</tr>
			<tr>
				<td width="20%" align="right">
					From
				</td>				
				<td align="left">
					<input type="text" name="yrfrom" id="yrfrom" class="inputBoxWidth"/>
				</td>
				<td width="20%" align="right">				
					To
				</td>
				<td align="left">
					<input type="text" name="yrto" id="yrto" class="inputBoxWidth"/>
				</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td colspan="3" align="left">
					<input type="button" name="submit_button" id="submit_button" value="Search" title="Search" class="delete" onClick="showResults(true);return false;" />
				</td>
			</tr>			
		</table>
		<div class="loaderimgText" style="display:none; margin:0px; left:0px;" id="ajaxLoader">
			<img src="images/loader2.gif" />
			<div class="backTransparant"></div>
		</div>
		<div id="searchResults"></div>		
	</form>
	</div>
</body>
</html>
<script type="text/javascript">
	function showHideDiv(snId, ssType)
	{
		if(ssType == "show")
			$("#moreDetails_"+snId).show();
		else
			$("#moreDetails_"+snId).hide();
	}
	function displayMap(ssMapPath)
	{
		window.open(ssMapPath,"mywindow","width=900,height=700");
	}
</script>