<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
mysql_connect('localhost','hcx10ho2_naveen','password');
mysql_select_db('hcx10ho2_app') or die("Cannot connect to db");

$provider = @$_POST['provider'];

$day_selected = @$_POST['day'];

$query = mysql_query("UPDATE doctor_schedule SET dayleave='".$day_selected."' WHERE provider='".$provider."'");
?>