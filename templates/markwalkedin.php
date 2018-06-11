<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
mysql_connect('localhost','hcx10ho2_naveen','password');
mysql_select_db('hcx10ho2_app') or die("Cannot connect to db");

$provider = @$_POST['provider'];
$date=@$_POST['date'];
$bid = @$_POST['bid'];


$query = mysql_query("UPDATE apt SET walkedin='1' WHERE provider='".$provider."' AND  date='".$date."' AND bid='".$bid."'");

?>