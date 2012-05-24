<?
	include('auth.php');
	
	if(isset($_POST['submit'])){
		$user_id = $_POST['user_id'];
		mysql_query("delete from user_info where user_id = $user_id");
		header('Location: users.php');
		exit();
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
<h1>Deleting User</h1>
<h2>Are you sure you want to delete this user?</h2>
<form method="post" action="delete_user.php">
<input type="hidden" name="user_id" value="<?=$user_id?>">
<table id="box-table-a">
	<tr>
		<td align="center"><?=$row['fname']?> <?=$row['lname']?></td>
	</tr>
	<tr>
		<td align="center">
		<input type="submit" name="submit" value="Delete" class="button">&nbsp;<input type="submit" name="cancel" value="Cancel" class="button"></td>
	</tr>
</table>
</form>
<? include('footer.php')?>
</body>
</html>
