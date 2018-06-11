<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
mysql_connect('localhost','hcx10ho2_naveen','password');
mysql_select_db('hcx10ho2_app') or die("Cannot connect to db");

$id = @$_POST['id'];
$reason = @$_POST['reason'];
$query = mysql_query("UPDATE notificaitons set status='cancelled' WHERE id='".$id."'");

$q = mysql_query("SELECT * FROM notificaitons WHERE id='".$id."'");
$fetch = mysql_fetch_assoc($q);
$fullname = $fetch['patientfullname'];
$date = $fetch['apt_date'];
$time = $fetch['apt_time'];
$provider = $fetch['provider'];
$email = $fetch['email'];

$to = $email;
$subject = "Your Request for Appointment at ".$time." on ".$date." has been cancelled";

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
<p>Dear ".$fullname.",</p>
<p>Your Appointment is cancelled due to : ".$reason."</p>
<p>Appointment Details</p>
<table style='width:100%;border-collapse:collapse;'>
<tr>
<td style='font-weight:bold;width:48%;padding:2%;'>Date</td>
<td>".$date."</td>
</tr>
<tr>
<td style='font-weight:bold;width:48%;padding:2%;'>Time</td>
<td>".$time."</td>
</tr>
<tr>
<td style='font-weight:bold;width:48%;padding:2%;'>Doctor</td>
<td>".$provider."</td>
</tr>
</table>
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