<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
mysql_connect('localhost','hcx10ho2_naveen','password');
mysql_select_db('hcx10ho2_app') or die("Cannot connect to db");

$rest_json = file_get_contents("php://input");
$response = json_decode($rest_json);

$time = $response->time;
$date = $response->date;
$provider = $response->provider;
$username = $response->username;
date_default_timezone_set("America/Toronto");
$checkedintime = date("h:iA");


$query = mysql_query("INSERT INTO checkin VALUES('','".$date."','".$time."','".$provider."','".$username."','1','".$checkedintime."')");
$query_a=  mysql_query("UPDATE apt SET checkedin = '1' WHERE date='".$date."' AND time ='".$time."' AND provider='".$provider."' AND username='".$username."' AND showstatus='1'");
?>