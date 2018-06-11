<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
mysql_connect('localhost','hcx10ho2_naveen','password');
mysql_select_db('hcx10ho2_app') or die("Cannot connect to db");

$rest_json = file_get_contents("php://input");
$response = json_decode($rest_json);

$username = $response->username;
$date = $response->date;
$provider = $response->provider;

$query = mysql_query("SELECT * FROM apt WHERE username='".$username."' AND date='".$date."' AND checkedin='1' AND seen='0' AND provider='".$provider."' AND walkedin='0'");
$arr=array();
while($row = mysql_fetch_assoc($query)){
	$date = $row['date'];
	$time = $row['time'];
	$provider = $row['provider'];
	$arr[] =array("date"=>$date,"time"=>$time,"provider"=>$provider); 
}
echo json_encode($arr);


?>