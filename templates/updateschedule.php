<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
mysql_connect('localhost','hcx10ho2_naveen','password');
mysql_select_db('hcx10ho2_app') or die("Cannot connect to db");

$provider = @$_POST['provider'];
$time = @$_POST['time'];
$day_selected = @$_POST['day'];

if($day_selected == "Monday"){
				$queryc = mysql_query('UPDATE doctor_schedule SET monday="'.$time.'" WHERE provider="'.$provider.'"');
			}
			if($day_selected == "Tuesday"){
				$queryc = mysql_query('UPDATE doctor_schedule SET tuesday="'.$time.'" WHERE provider="'.$provider.'"');
			}
			if($day_selected == "Wednesday"){
				$queryc = mysql_query('UPDATE doctor_schedule SET wednesday="'.$time.'" WHERE provider="'.$provider.'"');
			}
			if($day_selected == "Thursday"){
				$queryc = mysql_query('UPDATE doctor_schedule SET thursday="'.$time.'" WHERE provider="'.$provider.'"');
			}
			if($day_selected == "Friday"){
				$queryc = mysql_query('UPDATE doctor_schedule SET friday="'.$time.'" WHERE provider="'.$provider.'"');
			}
			if($day_selected == "Saturday"){
				$queryc = mysql_query('UPDATE doctor_schedule SET saturday="'.$time.'" WHERE provider="'.$provider.'"');
			}
			if($day_selected == "Sunday"){
				$queryc = mysql_query('UPDATE doctor_schedule SET sunday="'.$time.'" WHERE provider="'.$provider.'"');
			}

?>