<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
mysql_connect('localhost','hcx10ho2_naveen','password');
mysql_select_db('hcx10ho2_app') or die("Cannot connect to db");


$query = mysql_query("SELECT * FROM notificaitons WHERE status= 'pending' ");
$ar = array();
while($row = mysql_fetch_assoc($query)){
	$apt_date = $row['apt_date'];
	$apt_time = $row['apt_time'];
	$apt_provider = $row['provider'];
	$apt_username = $row['patientusername'];
	$apt_id = $row['id'];
	$apt_pname = $row['patientfullname'];
	$ar[] = array("date"=>$apt_date,"time"=>$apt_time,"provider"=>$apt_provider,"patientusername"=>$apt_username,"id"=>$apt_id,"patientfullname"=>$apt_pname);
}

echo json_encode($ar);
?>