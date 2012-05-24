<?
	include('auth.php');
	$err = '';
	if(isset($_POST['submit'])){
		$time_id = $_POST['time_id'];
		
		$data_month = $_POST['data_month'];
		$data_day = $_POST['data_day'];
		$data_year = $_POST['data_year'];
		$type_id = $_POST['type_id'];
		$hours = $_POST['hours'];
		$notes = $_POST['notes'];
		
		$data_date = $data_year . "-" . $data_month . "-" . $data_day;
		
		if(is_numeric($hours)){
			mysql_query("update time_data set data_date = '$data_date', type_id = '$type_id', hours = '$hours', notes = '$notes' where time_id = $time_id");
			header('Location: time_entry.php');
			exit();
		}else{
			$err = "Hours must be numeric!!";
			
			$result = mysql_query("select * from time_data where time_id = $time_id");
			$row = mysql_fetch_array($result);
			$data_date = $row['data_date'];
			$type_id = $row['type_id'];
			
			$iresult = mysql_query("select description from time_types where type_id = $type_id");
			$irow = mysql_fetch_array($iresult);
		}
	}elseif(isset($_POST['cancel'])){
		header('Location: time_entry.php');
		exit();
	}else{
		$time_id = $_GET['time_id'];
		
		$result = mysql_query("select * from time_data where time_id = $time_id");
		$row = mysql_fetch_array($result);
		$data_date = $row['data_date'];
		$type_id = $row['type_id'];
		
		$iresult = mysql_query("select description from time_types where type_id = $type_id");
		$irow = mysql_fetch_array($iresult);
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
<h1>Edit Time Entry</h1>
<form method="post" action="edit_entry.php">
<table id="box-table-a">
<? if(strlen($err) > 0){ ?>
<tr>
	<td align="center" colspan="100%"><?=$err?></td>
</tr>
<? } ?>
<tr>
	<td align="right">Date:&nbsp;</td><td align="left">
	Month: <input type="text" name="data_month" size="2" value="<?=date('m', strtotime($data_date))?>">&nbsp;
	Day: <input type="text" name="data_day" size="2" value="<?=date('d', strtotime($data_date))?>">&nbsp;
	Year: <input type="text" name="data_year" size="4" value="<?=date('Y', strtotime($data_date))?>"></td>
</tr>
<tr>
	<td align="right">Type:&nbsp;</td>
	<td>
		<select name="type_id">
			<option value="<?=$type_id?>" selected><?=$irow['description']?></option>
<? 
	$tresults = mysql_query("select * from time_types order by description");
	if($trow = mysql_fetch_array($tresults)){
		do{
?>			
			<option value="<?=$trow['type_id']?>"><?=$trow['description']?></option>
<? 
		}while($trow = mysql_fetch_array($tresults));
	}
?>
		</select>
	</td>
</tr>
<tr>
	<td align="right">Hours:&nbsp;</td><td align="left"><input type="text" name="hours" size="4"  value="<?=$row['hours']?>"></td>
</tr>
<tr>
	<td align="right" valign="top">Notes:&nbsp;</td><td align="left"><textarea name="notes" cols="30" rows="3"><?=$row['notes']?></textarea></td>
</tr>
<tr>
	<td><input type="hidden" name="time_id" value="<?=$time_id?>"></td>
	<td><input type="submit" name="submit" value="Update" class="button">&nbsp;<input type="submit" name="cancel" value="Cancel" class="button"></td>
</tr>
</table>
</form>
<? include('footer.php')?>
</body>
</html>
