<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
mysql_connect('localhost','hcx10ho2_naveen','password');
mysql_select_db('hcx10ho2_app') or die("Cannot connect to db");

$rest_json = file_get_contents("php://input");
$response = json_decode($rest_json);


$firstname = $response->fname;
$lastname = $response->lname;
$email = $response->email;
$phone = $response->phone;
$username = $response->username;
$password = $response->password;
$hc = $response->hc;
$uid = uniqid();
$q = mysql_query("SELECT * FROM app_users WHERE username='".$username."'");
$r = mysql_num_rows($q);
$a = mysql_query("SELECT * FROM registeruser WHERE  (email='".$email."' OR phone='".$phone."') AND status='pending'");
$o = mysql_num_rows($a);
if($r == 0){
	if($o ==0){
	$query = mysql_query("INSERT INTO registeruser VALUES('','".$firstname."','".$lastname."','".$email."','".$phone."','".$username."','".$password."','".$hc."','pending','0','".$uid."')");

$to = $email;
$subject = "Authorize Email Account";

$message = "
<html>
<head>
<title>Cederbrea Medical Center</title>
<style>
html,body{width:100%;height:100%;background:#f2f3f4;}
</style>
</head>
<body>
<div style='wdith:100%;height:100%;background:#fff;'>
<p style='width:100%;height:25px;text-align:center;background:#00A6FB;color:#fff;font-weight:600;font-size:22px;'>Cederbrea Medical Center\n</p>
<p>Dear ".$firstname.",</p>
<a href='http://hc.x10host.com/emailactivate.php?uid=".$uid."'>Click Here to Authorize this email account</a>
</div>
</body>
</html>
";

// Always set content-type when sending HTML email
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

// More headers
$headers .= 'From: <notifications@cmc.com>' . "\r\n";


mail($to,$subject,$message,$headers);
	$ar = array("status"=>"Check your email to Authorize your email account","error"=>"success");
}else{
	$ar = array("status"=>"You already have a pending request,please wait upto 24h");
}
}else{
	$ar = array("status"=>"Username Already in use");
}




echo json_encode($ar);
?>