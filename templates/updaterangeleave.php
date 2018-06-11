<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
mysql_connect('localhost','hcx10ho2_naveen','password');
mysql_select_db('hcx10ho2_app') or die("Cannot connect to db");

$provider = @$_POST['provider'];

$r1 = @$_POST['r1'];
$r2 = @$_POST['r2'];

$query = mysql_query("UPDATE doctor_schedule SET start='".$r1."',end='".$r2."' WHERE provider='".$provider."'");
?>