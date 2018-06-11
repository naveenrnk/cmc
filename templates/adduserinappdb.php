<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
mysql_connect('localhost','hcx10ho2_naveen','password');
mysql_select_db('hcx10ho2_app') or die("Cannot connect to db");


$firstname = @$_POST['firstname'];
$lastname = @$_POST['lastname'];
$email = @$_POST['email'];
$phone = @$_POST['phone'];
$username = @$_POST['username'];
$password = @$_POST['password'];
$id= @$_POST['id'];
$z = mysql_query("UPDATE registeruser SET status='confirmed' WHERE id='$id'");

$q = mysql_query("SELECT * FROM app_users WHERE username = '".$username."'");
$r = mysql_num_rows($q);
if($r==0){
	$query = mysql_query("INSERT INTO app_users VALUES('','".$firstname."','".$lastname."','".$phone."','','".$email."','".$username."','".$password."')");
}

?>