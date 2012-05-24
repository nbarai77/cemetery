<?
	include('auth.php');
	
	if(isset($_POST['submit'])){
		$type_id = $_POST['type_id'];
		$description = $_POST['description'];
		mysql_query("update time_types set description = '$description' where type_id = $type_id");
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
<title>Time Application</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="stylesheet" href="timeapp.css" type="text/css">
</head>

<body>
<?include "nav.php";?>
<h1>Editing Time Type</h1>
<form method="post" action="edit_type.php">
<input type="hidden" name="type_id" value="<?=$type_id?>">
<table id="box-table-a">
<thead>
	<tr>
		<th>Description:&nbsp;</th>
		<th><input type="text" name="description" size="50" value="<?=$row['description']?>"></th>
	</tr>
</thead>
<tbody>
	<tr>
		<td>&nbsp;</td>
		<td><input type="submit" name="submit" value="Update" class="button">&nbsp;<input type="submit" name="cancel" value="Cancel" class="button"></td>
	</tr>
</tbody>
</table>
</form>
<? include('footer.php')?>
</body>
</html>
