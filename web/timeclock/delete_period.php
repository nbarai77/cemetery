<?
	include('auth.php');
	
	if(isset($_POST['submit'])){
		$period_id = $_POST['period_id'];
		mysql_query("delete from time_periods where period_id = $period_id");
		header('Location: time_periods.php');
		exit();
	}elseif(isset($_POST['cancel'])){
		header('Location: time_periods.php');
		exit();
	}else{
		$period_id = $_GET['period_id'];
		
		$result = mysql_query("select * from time_periods where period_id = $period_id");
		$row = mysql_fetch_array($result);
		$start_date = $row['start_date'];
		$end_date = $row['end_date'];
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
<h1>Deleting Time Period</h1>
<h2>Are you sure you want to delete this time period?</h2>
<form method="post" action="delete_period.php">
<table id="box-table-a">
	<tr>
		<td align="center">
		<?=date('m/d/Y', strtotime($start_date))?> to <?=date('m/d/Y', strtotime($end_date))?></td>
	</tr>
	<tr>
		<td align="center"><input type="hidden" name="period_id" value="<?=$period_id?>">
		<input type="submit" name="submit" value="Delete" class="button">&nbsp;<input type="submit" name="cancel" value="Cancel" class="button"></td>
	</tr>
</table>
</form>
<? include('footer.php')?>
</body>
</html>
