<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
mysql_connect('localhost','hcx10ho2_naveen','password');
mysql_select_db('hcx10ho2_app') or die("Cannot connect to db");

$rest_json = file_get_contents("php://input");
$response = json_decode($rest_json);


$email = $response->email;

$query = mysql_query("SELECT * FROM app_users WHERE email = '$email'");
$rows = mysql_num_rows($query);

if($rows == 1){
	$fetch = mysql_fetch_assoc($query);
	$username = $fetch['username'];
	$password = $fetch['password'];
	$email = $fetch['email'];
	$arr = array("status"=>"Check Your Email for Login Credentials");
	$to = $email;
$subject = "Account Recovery";

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
<p>Username: ".$username."</p>
<p>Password: ".$password."</p>
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
}else{
$arr = array("status"=>"No user exists with this email");
}



echo json_encode($arr);
?>