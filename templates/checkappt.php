<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
mysql_connect('localhost','hcx10ho2_naveen','password');
mysql_select_db('hcx10ho2_app') or die("Cannot connect to db");

$rest_json = file_get_contents("php://input");
$response = json_decode($rest_json);

$time = $response->time;
$date = $response->date;
$pusername = $response->username;
$patientfullname = $response->fullname;
$provider = $response->provider;
$email = $response->email;
$phone = $response->phone;

$date_r = substr($date,0,strpos($date, "T"));

/*
$d = substr($date,8,2);
$m = substr($date,4,3);
$y = substr($date,11,4);
if($m == "Jan"){
	$m = "01";
}
if($m == "Feb"){
	$m = "02";
}
if($m == "Mar"){
	$m = "03";
}
if($m == "Apr"){
	$m = "04";
}
if($m == "May"){
	$m = "05";
}
if($m == "Jun"){
	$m = "06";
}
if($m == "Jul"){
	$m = "07";
}
if($m == "Aug"){
	$m = "08";
}
if($m == "Sep"){
	$m = "09";
}
if($m == "Oct"){
	$m = "10";
}
if($m == "Nov"){
	$m = "11";
}
if($m == "Dec"){
	$m = "12";
}

$dd = $y.'-'.$m.'-'.$d;
*/
$query = mysql_query('SELECT * FROM apt WHERE date = "'.$date_r.'" AND time="'.$time.'" AND provider="'.$provider.'" AND showstatus="1"');
$rows = mysql_num_rows($query);

$q = mysql_query('SELECT * FROM notificaitons WHERE apt_date= "'.$date_r.'" AND patientusername="'.$pusername.'" AND provider="'.$provider.'" AND (status="confirmed" OR status="pending")');
$r = mysql_num_rows($q);

if($r ==0){
if($rows == 0){
	
	$query = mysql_query('INSERT INTO notificaitons VALUES("","'.$pusername.'","'.$patientfullname.'","'.$date_r.'","'.$time.'","'.$provider.'","'.$email.'","'.$phone.'","pending","unread")');
	$arr= array('status'=>"Appointment Booked!<br/> Wait For Confirmation in Notfication Centre");
	echo json_encode($arr);
}else{
	$arr= array('status'=>"Sorry,This Slot is no longer Available");
	echo json_encode($arr);
}
}else{
	$arr = array('status'=>"Sorry,You are allowed Max 1 appointment request per day");
	echo json_encode($arr);
}
?>