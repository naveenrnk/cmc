<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
mysql_connect('localhost','hcx10ho2_naveen','password');
mysql_select_db('hcx10ho2_app') or die("Cannot connect to db");

$d_selected = @$_POST['provider'];
$time = @$_POST['time'];
$day_selected = @$_POST['day'];

if($day_selected == "Monday"){
				$queryA = mysql_query('INSERT INTO doctor_schedule VALUES("","'.$time.'","","","","","","","","","'.$d_selected.'","")');
			}
			if($day_selected == "Tuesday"){
				$queryA = mysql_query('INSERT INTO doctor_schedule VALUES("","","'.$time.'","","","","","","","","'.$d_selected.'","")');
			}
			if($day_selected == "Wednesday"){
				$queryA = mysql_query('INSERT INTO doctor_schedule VALUES("","","","'.$time.'","","","","","","","'.$d_selected.'","")');
			}
			if($day_selected == "Thursday"){
				$queryA = mysql_query('INSERT INTO doctor_schedule VALUES("","","","","'.$time.'","","","","","","'.$d_selected.'","")');
			}
			if($day_selected == "Friday"){
				$queryA = mysql_query('INSERT INTO doctor_schedule VALUES("","","","","","'.$time.'","","","","","'.$d_selected.'","")');
			}
			if($day_selected == "Saturday"){
				$queryA = mysql_query('INSERT INTO doctor_schedule VALUES("","","","","","","'.$time.'","","","","'.$d_selected.'","")');
			}
			if($day_selected == "Sunday"){
				$queryA = mysql_query('INSERT INTO doctor_schedule VALUES("","","","","","","","'.$time.'","","","'.$d_selected.'","")');
			}

			$arr = array("status"=>mysql_error());
			echo json_encode($arr);

?>