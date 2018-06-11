<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
mysql_connect('localhost','hcx10ho2_naveen','password');
mysql_select_db('hcx10ho2_app') or die("Cannot connect to db");

$rest_json = file_get_contents("php://input");
$response = json_decode($rest_json);

$date = $response->date;
$time = $response->time;
$provider = $response->provider;
$username = $response->username;

$cancel = mysql_query("INSERT INTO usercancelled VALUES('','".$date."','".$time."','".$provider."','".$username."','unseen')");

$query = mysql_query("UPDATE apt SET showstatus='0' WHERE date='".$date."' AND time='".$time."' AND provider='".$provider."' AND username='".$username."'");
$q = mysql_query("UPDATE notificaitons SET status='cancelled' WHERE apt_date='".$date."' AND apt_time='".$time."' AND provider='".$provider."' AND patientusername='".$username."'");
if($q && $query){
	$arr=array("status"=>"Cancelled Appointment");
}else{
	$arr=array("status"=>"Error Cancelling,Please call secratory");
}
echo json_encode($arr);
?>