<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
mysql_connect('localhost','hcx10ho2_naveen','password');
mysql_select_db('hcx10ho2_app') or die("Cannot connect to db");

$rest_json = file_get_contents("php://input");
$response = json_decode($rest_json);
$provider = @$_POST['provider'];
date_default_timezone_set("America/Toronto");
$today = date("Y-m-d");
$currenttime = date("H:iA");
$query = mysql_query("SELECT * FROM apt WHERE seen='0' AND date='".$today."' AND provider='".$provider."' ORDER BY STR_TO_DATE(time,'%l:%i %p')");


$arr= array();
while($row = mysql_fetch_assoc($query)){
	$arr[] = $row['time'];
};
$currentapttime = $arr[0];
$current_hour = substr($currenttime,0,2);
$current_min = substr($currenttime,3,2);
$current_hour_to_min = $current_hour * 60;
$total_current_min = $current_min+$current_hour_to_min;

$apt_time_in_24hour = date("H:i",strtotime($currentapttime));

$apt_hour = substr($apt_time_in_24hour,0,2);
$apt_min = substr($apt_time_in_24hour,3,2);
$apt_hour_to_min = $apt_hour *60;
$total_apt_min = $apt_min+$apt_hour_to_min;


if(count($arr)>1){
	$secondapttime = $arr[1];
	$apt2_time_in_24hour = date("H:i",strtotime($secondapttime));
	$apt2_hour = substr($apt2_time_in_24hour,0,2);
	$apt2_min = substr($apt2_time_in_24hour,3,2);
	$apt2_hour_to_min = $apt2_hour *60;
	$total_apt2_min = $apt2_min+$apt2_hour_to_min;


		$delay = $total_current_min - $total_apt2_min;
		
			
			$totaldelay = $delay;

	
}else{
	$totaldelay = 0;
}
$arr = array("delay"=>$totaldelay);
echo json_encode($arr);
?>