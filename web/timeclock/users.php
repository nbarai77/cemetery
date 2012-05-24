<?
	include('auth.php');
	
	$results = mysql_query("select * from user_info order by lname");
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
<h1>Users</h1>

<p><a href="add_user.php">Add User</a> | <a href="index.php">Exit</a></p>

<table id="box-table-a">
<tr>
	<th>ID</th>
	<th>Name</th>
	<th>Level</th>
	<th>Username</th>
	<th>Password</th>
	<th colspan="2" align="center">Action</th>
</tr>
<?
if($row = mysql_fetch_array($results)){
	do{
		
?>
<tr>
	<td><?=$row['user_id']?></td>
	<td><?=$row['lname']?>, <?=$row['fname']?></td>
	<td><?=$row['level']?></td>
	<td><?=$row['username']?>&nbsp;</td>
	<td><?=$row['password']?>&nbsp;</td>
	<td><a href="edit_user.php?user_id=<?=$row['user_id']?>">Edit</a></td>
	<td><a href="delete_user.php?user_id=<?=$row['user_id']?>">Delete</a></td>
	</td>
</tr>
<?
	}while($row = mysql_fetch_array($results));
}else{
?>
<tr>
	<td align="center" colspan="100%">Currently no users on file.</td>
</tr>
<?
}
?>
</table>
<? include('footer.php')?>
</body>
</html>
