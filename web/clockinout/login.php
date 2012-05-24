<?php
/****************************************************
 * login.php
 *
 * @package    : Interment Search Plugin
 * @subpackage : view
 * @author     : Arpita Rana
 * @version    : 1.0

****************************************************/
$oCon = mysql_connect('192.168.0.155','root','vi155vi');
$oDb  = mysql_select_db('cemetery',$oCon);
$snIdUser = '';
$ssTitle = '';
$ssMiddleName = '';
session_start();
if($_POST)
{
	$ssMsgUsername = '';
	$bIsValid = true;	
	$ssUsername = trim($_POST['user_code']);	
	
	if($ssUsername == '')
	{
		$ssMsgUsername = 'Please enter usercode';
		$bIsValid = false;
	}
    if($ssUsername != '')
    {
        $ssQuery = "SELECT uc.*,sfgu.* FROM user_cemetery uc LEFT JOIN sf_guard_user sfgu ON sfgu.id = uc.user_id where uc.user_code='".$ssUsername."'";
        $amResult = mysql_query($ssQuery);
        $asUserDetail = mysql_fetch_array($amResult);
        if(mysql_num_rows($amResult) == 0 || $asUserDetail['group_id'] != 7)
        {
            $ssMsgUsername = 'Usercode is wrong';
            $bIsValid = false;
        }
    }
	
	if($bIsValid)
	{
        //$ssQuery = "SELECT uc.* FROM user_cemetery uc where uc.user_code='".$ssUsername."'" ;       
        //$amResult = mysql_query($ssQuery);
        //$asUserDetail = mysql_fetch_array($amResult);        
        $snIdUser = $asUserDetail['user_id'];
        $ssTitle = $asUserDetail['title'];        
        $ssFirstName = $asUserDetail['first_name']; 
        
        $_SESSION['id_user'] = $snIdUser;
        $_SESSION['title'] = $ssTitle;
        $_SESSION['name'] = $ssFirstName;       
        header('Location: /clockinout/inout.php');		
	}
}
?>
<html>
<title>Login</title>
<head>
<script src="js/jquery-1.4.1.min.js"></script>
<script src="js/common.js"></script>

<link href="css/style.css" rel="stylesheet" type="text/css">
</head>
<body>
<div id="page-top-outer">    
	<!-- Start: page-top -->
	<div id="page-top">            

		<!-- start logo -->
		<div id="logo">
			<img width="332" height="53" src="/images/logo.png">
        </div>
		<div class="clear"></div>
	</div>
	<!-- End: page-top -->
</div>	
    <div id="container">
	<div style="width:98%; padding-left:15px;">
	<form method="post" name="searchinterment" id="searchinterment" action="login.php">
		<table cellpadding="5" cellspacing="0" width="100%" border="0" align="center">
			<tr>
                <td width="20%" align="right">
                <h1>Login to timesheet</h1>
                </td>
				<td align="left">
					
				</td>
			</tr>			
			<tr>
				<td width="20%" align="right">
					Usercode<strong style="color:#FF0000">*</strong>
				</td>				
				<td align="left">										
					<input type="text" name="user_code" id="user_code" class="inputBoxWidth" value="<?php echo (isset($_REQUEST['user_code'])?$_REQUEST['user_code']:'') ?>" />
					<?php 
						if(isset($ssMsgUsername) && $ssMsgUsername != ''):
							echo '<span style="color:#FF0000">'.$ssMsgUsername.'</span>';
					 	endif;?>
				</td>
			</tr>					
			<tr>
				<td>&nbsp;</td>
				<td align="left">
                    <div class="actions">
                        <ul class="fleft">
                            <li class="list1">
                            <span>
                            <input type="submit" name="submit_button" id="submit_button" value="Login" title="Login" class="delete" />
                            </span>                                
                            </li>
                            <li class="list1">
                            <span>                     
								<a href="/">Cancel</a>
                            </span>           
                            </li>
                        </ul>
                    </div>
                
					
				</td>
			</tr>			
		</table>
	</form>
    </div>
</div>
    <div id="footer">
<!-- <div id="footer-pad">&nbsp;</div> -->
	<!--  start footer-left -->
	<div id="footer-left">
		 &copy;2011 OCMS &ndash; The Online Cemetery Management System	</div>
	<!--  end footer-left -->
	<div class="clear">&nbsp;</div>
</div>

</body>
</html>
