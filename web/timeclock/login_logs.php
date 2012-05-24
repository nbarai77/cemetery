<?php
//$dbi = 1;
include('auth.php');
if ($_SESSION['timeapp_level'] <> "Administrator"){
echo "Not Allowed";
exit;
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Main Menu</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="stylesheet" href="timeapp.css" type="text/css">
</head>

<body>
<?php include "nav.php";?>
<h1>Login Log</h1>
<table id="box-table-a">
<thead>
<tr>
	<th>user id</th>
	<th>login ip</th>
	<th>login time</th>
</tr>
</thead>
<tbody>
<?php
$myquery = "select * from user_log order by id desc limit 200;";
$results = mysql_query($myquery);
$num = mysql_num_rows($results);
while ($row = mysql_fetch_assoc($results)) {
	//echo $postClass;
	$user_id = $row['user_id'];
	$loginip = $row['loginip'];
	$timestamp = $row['timestamp'];
?>
<tr>
	<td><?php echo $user_id;?></td>
	<td><?php echo $loginip;?></td>
	<td><?php echo $timestamp;?></td>
<?php } ?>	
</tbody>
</table>

<?php include('footer.php')?>
</body>
</html>
