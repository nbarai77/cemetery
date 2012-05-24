<?
include('auth.php');
$results = mysql_query("select * from time_periods order by period_id desc");
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
<h1>Time Periods</h1>
<p><a href="add_period.php">Add Period</a></p>
<table id="box-table-a">
<tr>
	<th>Period Id</th>
	<th>Start Date</th>
	<th>End Date</th>
	<th colspan="3">Action</th>
</tr>
<?
if($row = mysql_fetch_array($results)){
	do{
		$start_date = $row['start_date'];
		$end_date = $row['end_date'];
?>
<tbody>
<tr>
	<td><?=$row['period_id']?></td>
	<td><?=date('m/d/Y', strtotime($start_date))?></td>
	<td><?=date('m/d/Y', strtotime($end_date))?></td>
	<td><a href="view_data.php?period_id=<?=$row['period_id']?>">View</a>
	&nbsp;<a href="edit_period.php?period_id=<?=$row['period_id']?>">Edit</a>
	&nbsp;<a href="delete_period.php?period_id=<?=$row['period_id']?>">Delete</a>
	</td>
</tr>
<?
	}while($row = mysql_fetch_array($results));
}else{
?>
<tr>
	<td colspan="100%">Currently no time periods on file.</td>
</tr>
<?
}
?>
</tbody>
</table>

<? include("footer.php")?>

</body>
</html>
