<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
mysql_connect('localhost','hcx10ho2_naveen','password');
mysql_select_db('hcx10ho2_app') or die("Cannot connect to db");

$rest_json = file_get_contents("php://input");
$response = json_decode($rest_json);

$username = $response->username;
$date = $response->today;

$query = mysql_query("UPDATE notificaitons SET seen='read' WHERE patientusername='".$username."' AND apt_date >='".$date."' AND (status='confirmed' OR status='cancelled')");

?>