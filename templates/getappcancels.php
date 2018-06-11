<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
mysql_connect('localhost','hcx10ho2_naveen','password');
mysql_select_db('hcx10ho2_app') or die("Cannot connect to db");

$query = mysql_query('SELECT * FROM usercancelled WHERE seenbyrecep="0"');
$arr=array();
while($fetch = mysql_fetch_assoc($query)){
 		$date = $fetch['date'];
 		$time = $fetch['time'];
 		$username = $fetch['username'];
 		$id=$fetch['id'];
 		$provider = $fetch['provider'];
 		$arr[] = array("date"=>$date,"time"=>$time,"username"=>$username,"id"=>$id,"provider"=>$provider);
}
echo json_encode($arr);
?>