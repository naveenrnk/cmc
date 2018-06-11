<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
mysql_connect('localhost','hcx10ho2_naveen','password');
mysql_select_db('hcx10ho2_app') or die("Cannot connect to db");	


$query = mysql_query('SELECT * FROM staff');
$rows = array();

while($r = mysql_fetch_assoc($query)){
	$rows['list'][] = $r;

}
echo json_encode($rows);
?>