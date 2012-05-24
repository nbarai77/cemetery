<?
	include('auth.php');
	$err = '';
	if(isset($_POST['submit'])){
		$user_id = $_POST['user_id'];
		$fname = $_POST['fname'];
		$lname = $_POST['lname'];
		$access_level = $_POST['access_level'];
		$u_name = $_POST['u_name'];
		$user_password = $_POST['user_password'];
		
		if(strlen($u_name) > 0 && strlen($user_password) > 0){
			mysql_query("update user_info set fname = '$fname', lname = '$lname', level = '$access_level', username = '$u_name', password = '$user_password' where user_id = $user_id");
			header('Location: users.php');
			exit();
		}else{
			$err = "Username and password are required!!";
		}
	}elseif(isset($_POST['cancel'])){
		header('Location: users.php');
		exit();
	}else{
		$user_id = $_GET['user_id'];
		
		$result = mysql_query("select * from user_info where user_id = $user_id");
		$row = mysql_fetch_array($result);
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
<h1>Editing User</h1>
<form method="post" action="edit_user.php">
<table id="box-table-a">
<? if(strlen($err) > 0){ ?>
<tr>
	<td align="center" colspan="100%"><?=$err?></td>
</tr>
<? } ?>
<tr>
	<td>First Name:&nbsp;</td><td><input type="text" name="fname" size="30" value="<?=$row['fname']?>"></td>
</tr>
<tr>
	<td>Last Name:&nbsp;</td><td><input type="text" name="lname" size="30" value="<?=$row['lname']?>"></td>
</tr>
<tr>
	<td>Access Level:&nbsp;</td>
	<td>
		<select name="access_level">
			<option value="<?=$row['level']?>" selected><?=$row['level']?></option>
			<option value="Administrator">Administrator</option>
			<option value="User">User</option>
		</select>
	</td>
</tr>
<tr>
	<td>Username:&nbsp;</td><td><input type="text" name="u_name" size="30" value="<?=$row['username']?>"></td>
</tr>
<tr>
	<td>Password:&nbsp;</td><td><input type="text" name="user_password" size="30" value="<?=$row['password']?>"></td>
</tr>
<tr>
	<td><input type="hidden" name="user_id" value="<?=$user_id?>"></td>
	<td><input type="submit" name="submit" value="Update" class="button">&nbsp;<input type="submit" name="cancel" value="Cancel" class="button"></td>
</tr>
</table>

</form>
<? include('footer.php')?>
</body>
</html>
