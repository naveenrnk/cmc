<?php
mysql_connect('localhost','hcx10ho2_naveen','password');
mysql_select_db('hcx10ho2_app') or die("Cannot connect to db");

$provider = @$_POST['provider'];
$query = mysql_query("SELECT * FROM waitime WHERE provider='".$provider."'");
$fetch = mysql_fetch_assoc($query);
$delay = $fetch['time'];
echo $delay;
?>