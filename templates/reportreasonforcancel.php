<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
mysql_connect('localhost','hcx10ho2_naveen','password');
mysql_select_db('hcx10ho2_app') or die("Cannot connect to db");


$id = @$_POST['id'];
$reason = @$_POST['reason'];

$q = mysql_query("UPDATE registeruser SET status='cancelled' WHERE id='$id'");

$query = mysql_query("SELECT * FROM registeruser WHERE id='".$id."'");
$fetch = mysql_fetch_assoc($query);
$firstname = $fetch['firstname'];
$email= $fetch['email'];
$to = $email;
$subject = "Your Request for registeration is cancelled";

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
<p>Your Registeration is cancelled due to : ".$reason."</p>
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


?>