<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
mysql_connect('localhost','newadmin_cmc','Sidman99');
mysql_select_db('newwaittime') or die("Cannot connect to db");


$query = mysql_query("SELECT * FROM patients WHERE status='0'");
$ar = array();
while($row = mysql_fetch_assoc($query)){
  $firstname = substr($row['firstname'],0,1);
  $lastname = substr($row['lastname'],0,1);
    $ar[] =array("id"=>$row['id'],"firstname"=>$firstname,"lastname"=>$lastname,"phone"=>$row['phone'],"waittime"=>$row['waittime'],"patientfullname"=>$apt_pname,"timestamp"=>$row['timestamp']);

}
echo json_encode($ar);
?>
