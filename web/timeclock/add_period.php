<?
	include('auth.php');
	if(isset($_POST['submit'])){
		$start_month = $_POST['start_month'];
		$start_day = $_POST['start_day'];
		$start_year = $_POST['start_year'];
		
		$end_month = $_POST['end_month'];
		$end_day = $_POST['end_day'];
		$end_year = $_POST['end_year'];
		
		$start_date = $start_year . "-" . $start_month . "-" . $start_day;
		$end_date = $end_year . "-" . $end_month . "-" . $end_day;
		
		mysql_query("insert into time_periods (start_date, end_date) values ('$start_date', '$end_date')");
		header('Location: time_periods.php');
		exit();
	}elseif(isset($_POST['cancel'])){
		header('Location: time_periods.php');
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
<h1>Adding Time Period</h1>
<form method="post" action="add_period.php">
<table id="box-table-a">
	<tr>
		<td align="right">Start Date:&nbsp;</td>
		<td align="left">Month:&nbsp;<input type="text" name="start_month" size="2">&nbsp;
			Day:&nbsp;<input type="text" name="start_day" size="2">&nbsp;
			Year:&nbsp;<input type="text" name="start_year" size="4">
		</td>
	</tr>
	<tr>
		<td align="right">End Date:&nbsp;</td>
		<td align="left">Month:&nbsp;<input type="text" name="end_month" size="2">&nbsp;
			Day:&nbsp;<input type="text" name="end_day" size="2">&nbsp;
			Year:&nbsp;<input type="text" name="end_year" size="4">
		</td>
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
