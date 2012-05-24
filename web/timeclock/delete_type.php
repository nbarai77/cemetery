<?
include('auth.php');

if(isset($_POST['submit'])){
	$type_id = $_POST['type_id'];
	mysql_query("delete from time_types where type_id = $type_id");
	header('Location: time_types.php');
	exit();
}elseif(isset($_POST['cancel'])){
	header('Location: time_types.php');
	exit();
}else{
	$type_id = $_GET['type_id'];
	$result = mysql_query("select description from time_types where type_id = $type_id");
	$row = mysql_fetch_array($result);
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Delete Time Type</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="stylesheet" href="timeapp.css" type="text/css">
</head>

<body>
<?include "nav.php";?>
<h1>Deleting Time Type</h1>
<h2>Are you sure you want to delete this time type?</h2>
<form method="post" action="delete_type.php">
<input type="hidden" name="type_id" value="<?=$type_id?>">
<table id="box-table-a">
	<tr>
		<td>Description</td>
		<td><?=$row['description']?></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td><input type="submit" name="submit" value="Delete" class="button">&nbsp;<input type="submit" name="cancel" value="Cancel" class="button"></td>
	</tr>
</table>
</form>
<? include('footer.php')?>
</body>
</html>
