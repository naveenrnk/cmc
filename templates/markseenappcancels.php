<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
mysql_connect('localhost','hcx10ho2_naveen','password');
mysql_select_db('hcx10ho2_app') or die("Cannot connect to db");

$id = @$_POST['id'];
$username = @$_POST['username'];

$query = mysql_query("UPDATE usercancelled SET seenbyrecep = '1' WHERE id='".$id."' AND username = '".$username."'");
?>