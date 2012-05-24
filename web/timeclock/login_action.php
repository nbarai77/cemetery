<?php
if (isset($_POST['username'])) {
	$username = trim($_POST['username']);
	}else{
	$username = "";
}

if (isset($_POST['password'])) {
	$password = trim($_POST['password']);
//	$hash = md5($password);
	}else{
	$password = "";
}

include ("db.php");

$query = ("SELECT * FROM user_info WHERE username = '$username' AND password = '$password' limit 1;");
//echo $query;
$results = mysql_query($query);
$qdata = mysql_fetch_array($results);

if ($qdata == null) {
	echo "<p>Login Incorrect</p>";
	include('footer.php');
    exit;
}

$_SESSION['timeapp_level'] = $qdata['level'];
$_SESSION['timeapp_id'] = $qdata['user_id'];

//record to the logs
$user_id = $qdata['user_id'];
$loginip = $_SERVER['REMOTE_ADDR'];
$lastlogin = date("Ymd" ,time());
$logquery = "INSERT into user_log (user_id,loginip,lastlogin)VALUES($user_id,'$loginip',$lastlogin);";
$logresult = mysql_query($logquery);


if(isset($_SESSION['timeapp_id'])){
	echo "timeapp_id: " . $_SESSION['timeapp_id'];
}else{
	echo "not working";
}

echo "<p><a href='index.php'>index</a></p>";
//header( "Location: index.php" );
?>