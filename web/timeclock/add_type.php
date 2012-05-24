<?
	include('auth.php');
	
	if(isset($_POST['submit'])){
		$description = $_POST['description'];
		mysql_query("insert into time_types (description) values ('$description')");
		header('Location: time_types.php');
		exit();
	}elseif(isset($_POST['cancel'])){
		header('Location: time_types.php');
		exit();
	}else{
		// do nothing but load the page
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
<h1>Adding Time Type</h1>
<form method="post" action="add_type.php">
<table id="box-table-a">
	<tr>
		<td>Description:&nbsp;</td>
		<td><input type="text" name="description" size="50"></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td><input type="submit" name="submit" value="Add" class="button">&nbsp;<input type="submit" name="cancel" value="Cancel" class="button"></td>
	</tr>
</table>

</form>
<? include('footer.php')?>
</body>
</html>
