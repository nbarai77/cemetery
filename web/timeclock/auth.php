<?
# create a session cookie
session_start();

# see if user has logged in or is already logged in and
# grab username and password if available
$timeapp_username = isset($_POST['username']) ? $_POST['username'] : $_SESSION['timeapp_username'];
$timeapp_password = isset($_POST['password']) ? $_POST['password'] : $_SESSION['timeapp_password'];

# redirect to login page if not logged in
if(!isset($timeapp_username) || !isset($timeapp_password)) 
{
  header ("Location: login.php");
  exit();
}

# update session variables if this is a fresh login
$_SESSION['timeapp_username'] = $timeapp_username;
$_SESSION['timeapp_password'] = $timeapp_password;

include 'db.php';

# query to search for this particular user in the users db
$sql = "SELECT * FROM user_info WHERE username = '$timeapp_username' AND password = '$timeapp_password'";        
$result = mysql_query($sql);

# make sure the database is working correctly
if (!$result) {
  echo('A database error occurred while checking your '.
		  'login details.\n ');
}else{
	$row = mysql_fetch_array($result);
	$_SESSION['timeapp_level'] = $row['level'];
	$_SESSION['timeapp_id'] = $row['user_id'];
	$timeapp_id = $_SESSION['timeapp_id'];
	$timeapp_level = $_SESSION['timeapp_level'];
}

if (mysql_num_rows($result) == 0) {
	  unset($_SESSION['timeapp_username']);
	  unset($_SESSION['timeapp_password']);
	  unset($_SESSION['timeapp_level']);
	  $_SESSION = array();
	  session_destroy();
	  header ("Location: login.php");
  	  exit();
}
?>