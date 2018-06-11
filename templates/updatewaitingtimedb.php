<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
mysql_connect('localhost','hcx10ho2_naveen','password');
mysql_select_db('hcx10ho2_app') or die("Cannot connect to db");



$waittime =@$_POST['waittime'];
$provider = @$_POST['provider'];
$query = mysql_query("SELECT * FROM waitime WHERE provider='".$provider."'");
$rows = mysql_num_rows($query);
if($rows ==0){
	$query = mysql_query("INSERT INTO waitime VALUES('','0','".$provider."')");
}
$fetch = mysql_fetch_assoc($query);
$time = $fetch['time'];
$total = $waittime + $time;
$q = mysql_query("UPDATE waitime SET time='".$total."' WHERE provider='".$provider."'");

?>