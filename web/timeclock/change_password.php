<?
	include('auth.php');
	$err = '';
	if(isset($_POST['submit'])){
		$user_id = $_POST['user_id'];
		$old_password = $_POST['old_password'];
		$new_password = $_POST['new_password'];
		$confirm_new_password = $_POST['confirm_new_password'];
		
		if($old_password == $timeapp_password && $new_password == $confirm_new_password){
			mysql_query("update user_info set password = '$new_password' where user_id = $user_id");
			header('Location: login.php');
			exit();
		}else{
			$err = 'Invalid Input';
		}
	}elseif(isset($_POST['cancel'])){
		header('Location: users.php');
		exit();
	}else{
		$result = mysql_query("select * from user_info where username = '$timeapp_username' and password = '$timeapp_password'");
		$row = mysql_fetch_array($result);
		$user_id = $row['user_id'];
	}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Time Application</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="stylesheet" href="timeapp.css" type="text/css">
</head>

<body>
<?include "nav.php";?>
<h1>Change Password</h1>
<form method="post" action="change_password.php">
<table id="box-table-a">
<? if(strlen($err) > 1){ ?>
	<tr>
		<td colspan="100%" align="center"><?=$err?></td>
	</tr>
<? } ?>
	<tr>
		<td>Old Password:&nbsp;</td>
		<td><input type="text" name="old_password" size="30"></td>
	</tr>
	<tr>
		<td>New Password:&nbsp;</td>
		<td><input type="text" name="new_password" size="30"></td>
	</tr>
	<tr>
		<td>Confirm New Password:&nbsp;</td>
		<td><input type="text" name="confirm_new_password" size="30"></td>
	</tr>
		<td><input type="hidden" name="user_id" value="<?=$user_id?>"></td>
		<td><input type="submit" name="submit" value="Update" class="button">&nbsp;<input type="submit" name="cancel" value="Cancel" class="button"></td>
	</tr>
</table>
</form>
<? include('footer.php')?>			
</body>
</html>
