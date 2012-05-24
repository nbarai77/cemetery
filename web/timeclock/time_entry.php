<?
include('auth.php');
$results = mysql_query("select * from time_data where user_id = $timeapp_id order by data_date desc limit $time_entry_display_rows;");
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
<h1>Time Entry</h1>
<h2><a href="add_entry.php">Add Entry</a></h2>
<table id="box-table-a">
	<tr>
		<td colspan="100%"></td>
	</tr>
	<tr>
		<th>Date</th>
		<th>Type</th>
		<th>Hours</th>
		<th>Notes</th>
		<th>Action</th>
	</tr>
<?
	if($row = mysql_fetch_array($results)){
		do{
			$data_date = $row['data_date'];
			$type_id = $row['type_id'];
			$tresult = mysql_query("select description from time_types where type_id = $type_id;");
			$trow = mysql_fetch_array($tresult);
			
?>
	<tr>
		<td><?=date('m/d/Y', strtotime($data_date))?></td>
		<td><?=$trow['description']?></td>
		<td><?=$row['hours']?></td>
		<td><?=$row['notes']?></td>
		<td><a href="edit_entry.php?time_id=<?=$row['time_id']?>">Edit</a>
		&nbsp;<a href="delete_entry.php?time_id=<?=$row['time_id']?>">Delete</a>
		</td>
	</tr>
<?
		}while($row = mysql_fetch_array($results));
	}else{
?>
	<tr>
		<td align="center" colspan="100%">Currently no time entry on file.</td>
	</tr>
<?
	}
?>
</table>
<? include('footer.php')?>
</body>
</html>
