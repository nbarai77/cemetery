<?
	include('auth.php');
	$err = '';
	if(isset($_POST['submit'])){
		$data_month = $_POST['data_month'];
		$data_day = $_POST['data_day'];
		$data_year = $_POST['data_year'];
		$type_id = $_POST['type_id'];
		$hours = $_POST['hours'];
		$notes = $_POST['notes'];
		
		$data_date = $data_year . "-" . $data_month . "-" . $data_day;
		
		if(is_numeric($hours)){
			mysql_query("insert into time_data (user_id, data_date, type_id, hours, notes) values ('$timeapp_id', '$data_date', '$type_id', '$hours', '$notes')");
			header('Location: time_entry.php');
			exit();
		}else{
			$err = "Hours must be numeric!!";
		}
	}elseif(isset($_POST['cancel'])){
		header('Location: time_entry.php');
		exit();
	}else{
		// do nothing but load the page
	}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<head>
<title>Time Application</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="stylesheet" href="timeapp.css" type="text/css">
</head>
<body>
<?include "nav.php";?>
<h1>Adding Time Entry</h1>
<form method="post" action="add_entry.php">
<table id="box-table-a">
<? if(strlen($err) > 0){ ?>
<tr>
	<td align="center" colspan="100%"><?=$err?></td>
</tr>
<? } ?>
<tr>
	<td>Date:&nbsp;</td>
	<td>
	Month: <input type="text" name="data_month" size="2">&nbsp;Day: <input type="text" name="data_day" size="2">&nbsp;Year: <input type="text" name="data_year" size="4"></td>
</tr>
<tr>
	<td>Type:&nbsp;</td>
	<td>
		<select name="type_id">
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
	<td>Hours:&nbsp;</td><td><input type="text" name="hours" size="4"></td>
</tr>
<tr>
	<td valign="top">Notes:&nbsp;</td><td><textarea name="notes" cols="30" rows="3"></textarea></td>
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
