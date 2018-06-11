<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
mysql_connect('localhost','hcx10ho2_naveen','password');
mysql_select_db('hcx10ho2_app') or die("Cannot connect to db");

$date = @$_POST['date'];
$time = @$_POST['time'];
$provider = @$_POST['provider'];
$username = @$_POST['username'];
$addedby = @$_POST['addedby'];
$bid=@$_POST['bid'];
$pname=@$_POST['pname'];
$pid= @$_POST['pid'];
$id=@$_POST['id'];

$query = mysql_query('UPDATE notificaitons SET status="confirmed" WHERE id="'.$id.'"');
$query = mysql_query('INSERT INTO apt VALUES("","'.$date.'","'.$time.'","","'.$provider.'","Booked","'.$addedby.'","'.$bid.'","'.$pname.'","1","'.$pid.'","R","N/A","'.$username.'","0","0","0")');

?>