<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
mysql_connect('localhost','hcx10ho2_naveen','password');
mysql_select_db('hcx10ho2_app') or die("Cannot connect to db");

$count = @$_POST['count'];
$count_a = @$_POST['count_a'];
$appcancels = @$_POST['appcancels'];

$query = mysql_query("SELECT * FROM notificaitons");
$newcount = mysql_num_rows($query);
$q = mysql_query("SELECT * FROM registeruser WHERE emailstatus='1'");
$r = mysql_num_rows($q);
$y = mysql_query("SELECT * FROM usercancelled");
$z = mysql_num_rows($y);
$remainingcount = $newcount - $count;
$remainingcount_a = $r - $count_a;
$remainingcount_b = $z - $appcancels;
$totalremaining = $remainingcount+$remainingcount_a+$remainingcount_b;
$arr = array("remainingcount"=>$totalremaining,"newcount"=>$newcount,"newcount_a"=>$r,"newcount_b"=>$z);
echo json_encode($arr);
?>