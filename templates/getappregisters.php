<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
mysql_connect('localhost','hcx10ho2_naveen','password');
mysql_select_db('hcx10ho2_app') or die("Cannot connect to db");

$query = mysql_query("SELECT * FROM registeruser WHERE status='pending' AND emailstatus='1'");
$ar = array();
while($row = mysql_fetch_assoc($query)){
	$firstname = $row['firstname'];
	$lastname = $row['lastname'];
	$email = $row['email'];
	$phone = $row['phone'];
	$username = $row['username'];
	$password = $row['password'];
	$hc = $row['hc'];
	$id = $row['id'];
	$ar[] = array("firstname"=>$firstname,"lastname"=>$lastname,"email"=>$email,"phone"=>$phone,"username"=>$username,"password"=>$password,"hc"=>$hc,"id"=>$id);
}

echo json_encode($ar);

?>