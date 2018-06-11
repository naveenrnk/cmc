<?php
mysql_connect('localhost','hcx10ho2_naveen','password');
mysql_select_db('hcx10ho2_app') or die("Cannot connect to db");

$provider = @$_POST['provider'];
$delay = @$_POST['delay'];
if(!$delay){
$query = mysql_query("UPDATE waitime SET time='0' WHERE provider='".$provider."'");
}else{
	$query = mysql_query("SELECT * FROM waitime WHERE provider='".$provider."'");
	$fetch = mysql_fetch_assoc($query);
	$delay_db = $fetch['time'];
	$totaldelay = $delay_db+$delay;
	$query_a = mysql_query("UPDATE waitime SET time='".$totaldelay."' WHERE provider='".$provider."'");
}
?>