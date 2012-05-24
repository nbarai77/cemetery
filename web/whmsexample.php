<?php 


$url = "http://bruntech.net.au/clients/includes/api.php";

//$url = "http://www.yourdomain.com/whmcs/includes/api.php"; # URL to WHMCS API file
 $username = "nitinbarai"; # Admin username goes here
 $password = "nitinbarai"; # Admin password goes here
 
 $postfields["username"] = $username;
 $postfields["password"] = md5($password);
 $postfields["accesskey"] = "bruntech123";
 $postfields["action"] = "getclients"; #action performed by the [[API:Functions]] 

 $ch = curl_init();
 curl_setopt($ch, CURLOPT_URL, $url);
 curl_setopt($ch, CURLOPT_POST, 1);
 curl_setopt($ch, CURLOPT_TIMEOUT, 100);
 curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
 curl_setopt($ch, CURLOPT_POSTFIELDS, $postfields);
 $data = curl_exec($ch);
 curl_close($ch);
 
 $data = explode(";",$data); 
 
 foreach ($data AS $temp) 
 {
   $temp = explode("=",$temp);
   $results[$temp[0]] = $temp[1];
 }
 echo "<pre>";print_R($results);exit;
 if ($results["result"]=="success") {
   # Result was OK!
 } else {
   # An error occured
   echo "The following error occured: ".$results["message"];
 }