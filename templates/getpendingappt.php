<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
mysql_connect('localhost','hcx10ho2_naveen','password');
mysql_select_db('hcx10ho2_app') or die("Cannot connect to db");

$rest_json = file_get_contents("php://input");
$response = json_decode($rest_json);

$username = $response->username;
$date = $response->date;

$query = mysql_query("SELECT * FROM notificaitons WHERE patientusername='".$username."' AND apt_date >= '".$date."' AND status='pending'");
$ar = array();
while($row = mysql_fetch_assoc($query)){
	$apt_date = $row['apt_date'];
	$apt_time = $row['apt_time'];
	$apt_provider = $row['provider'];
	$ar[] = array("date"=>$apt_date,"time"=>$apt_time,"provider"=>$apt_provider);
}

echo json_encode($ar);
?>