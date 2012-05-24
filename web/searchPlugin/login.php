<?php 
/****************************************************
 * index.php
 *
 * @package    : Interment Search Plugin
 * @subpackage : view
 * @author     : Prakash Panchal
 * @version    : 1.0

****************************************************/

if(isset($_REQUEST['logout']))
{
	include("../../../../members/bootstrap.php");
	Am_Di::getInstance()->auth->logout();
}
if($_POST)
{
	$ssMsgUsername = $ssMsgPassword = $ssInvalidCredential = '';
	$bIsValid = true;
	
	$ssUsername = trim($_POST['username']);
	$ssPwd = trim($_POST['password']);
	
	if($ssUsername == '')
	{
		$ssMsgUsername = 'Please enter username';
		$bIsValid = false;
	}
	if($ssPwd == '')
	{
		$ssMsgPassword = 'Please enter password';
		$bIsValid = false;
	}

	if($bIsValid)
	{
		include("../../../../members/bootstrap.php");
		
		$result = Am_Di::getInstance()->auth->login($ssUsername, $ssPwd, $_SERVER['REMOTE_ADDR']);
		if($result->isValid())
			header('Location: http://interments.info/live/cemetery_live/web/searchPlugin/index.php');
		else
			$ssInvalidCredential = $result->getMessage();
	}
}

?>
<html>
<title>aMember Pro Authentication</title>
<head>
<script src="js/jquery-1.4.1.min.js"></script>
<script src="js/common.js"></script>

<link href="css/style.css" rel="stylesheet" type="text/css">
</head>
<body>
	<div style="width:60%; padding-left:15px;">
	<form method="post" name="searchinterment" id="searchinterment" action="login.php">
		<table cellpadding="5" cellspacing="0" width="100%" border="0">
			<tr>
				<td colspan="2">
					<h1>Please login with aMember Pro User</h1>
				</td>
			</tr>
			<tr>
				<td>&nbsp;</td>				
				<td align="left">										
					<?php 
						if(isset($ssInvalidCredential) && $ssInvalidCredential != ''):
							echo '<span style="color:#FF0000">'.$ssInvalidCredential.'</span>';
					 	endif;?>
				</td>
			</tr>
			<tr>
				<td width="20%" align="right">
					Username<strong style="color:#FF0000">*</strong>
				</td>				
				<td align="left">										
					<input type="text" name="username" id="username" class="inputBoxWidth" value="<?php echo $_REQUEST['username'] ?>" />
					<?php 
						if(isset($ssMsgUsername) && $ssMsgUsername != ''):
							echo '<span style="color:#FF0000">'.$ssMsgUsername.'</span>';
					 	endif;?>
				</td>
			</tr>
			<tr>
				<td width="20%" align="right">
					Password<strong style="color:#FF0000">*</strong>
				</td>
				<td align="left" align="left">
					<input type="password" name="password" id="password" class="inputBoxWidth"/>
					<?php 
						if(isset($ssMsgPassword) && $ssMsgPassword != ''):
							echo '<span style="color:#FF0000">'.$ssMsgPassword.'</span>';
					 	endif;?>
				</td>				
			</tr>			
			<tr>
				<td>&nbsp;</td>
				<td align="left">					
					<input type="submit" name="submit_button" id="submit_button" value="Login" title="Login" class="delete" />
					<input type="button" name="submit_button" id="submit_button" value="Sign Up" title="Login" class="delete" onClick="window.location.href = 'http://interments.info/members/signup/index';"/>
				</td>
			</tr>			
		</table>
	</form>
	</div>
</body>
</html>
