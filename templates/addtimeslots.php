<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
mysql_connect('localhost','hcx10ho2_naveen','password');
mysql_select_db('hcx10ho2_app') or die("Cannot connect to db");

$date = @$_POST['date'];
$time = @$_POST['time'];
$wtd = @$_POST['wtd'];
$provider_selected=@$_POST['provider_selected'];
$type_selected = @$_POST['type_selected'];
$username = @$_POST['username'];
$id = @$_POST['id'];
$pname = @$_POST['pname'];
$showstatus = @$_POST['showstatus'];
$pid = @$_POST['pid'];
$status = @$_POST['status'];
$room = @$_POST['room'];

$query = mysql_query("INSERT INTO apt VALUES('','$date','$time','$wtd','$provider_selected','$type_selected','$username','$id','$pname','$showstatus','$pid','$status','$room','$username','0','0','0')");
?>