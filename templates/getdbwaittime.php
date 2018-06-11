<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
mysql_connect('localhost','hcx10ho2_naveen','password');
mysql_select_db('hcx10ho2_app') or die("Cannot connect to db");

$rest_json = file_get_contents("php://input");
$response = json_decode($rest_json);

$provider = $response->provider;
$query = mysql_query("SELECT * FROM waitime WHERE provider = '".$provider."'");
$fetch = mysql_fetch_assoc($query);
$delay = $fetch['time'];

if($delay <= 0){
	$arr = array("status"=>"On Time");
	echo json_encode($arr);
}
if($delay >0){
	if($delay >60){
		$delay_hours = floor($delay/60);
		$delay_min = $delay%60;
		$arr = array("status"=>"Delayed By".$delay_hours."Hour/s".$delay_min."Min/s");
		echo json_encode($arr);
	}else{
		$arr = array("status"=>"Delayed By".$delay."Min/s");
		echo json_encode($arr);
	}
}

?>