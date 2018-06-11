<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
mysql_connect('localhost','hcx10ho2_naveen','password');
mysql_select_db('hcx10ho2_app') or die("Cannot connect to db");

$rest_json = file_get_contents("php://input");
$response = json_decode($rest_json);

$selecteddate = $response->selectedDate;
$selecteddoctor = $response->selectedDoctor;

$q = mysql_query("SELECT * FROM doctor_schedule WHERE provider='".$selecteddoctor."'");
$fetch = mysql_fetch_assoc($q);
$dayleave = $fetch['dayleave'];
$a1 = $fetch['start'];
$a2 = $fetch['end'];
if($dayleave == $selecteddate){
	$arr = array("status"=>"Doctor is unavailable on this day");
	echo json_encode($arr);
}else{
	if($selecteddate >= $a1 && $selecteddate <= $a2){
		$arr = array("status"=>"Doctor is unavailable from ".$a1."to".$a2);
	echo json_encode($arr);
	}else{
	$query = mysql_query("SELECT * FROM apt WHERE provider ='$selecteddoctor' AND date='$selecteddate' AND showstatus='1'");
	
	
$rows = array();
while($row = mysql_fetch_assoc($query)){
	$rows[] = $row['time'];
}
$ss = strtotime($selecteddate);
$dayname = strtolower(date('l',$ss));
$z = mysql_query("SELECT * FROM doctor_schedule WHERE provider='".$selecteddoctor."'");
$f = mysql_fetch_assoc($z);
$timee = $f[$dayname];
if(!$timee){
		$arr = array("status"=>"Doctor Schedule unavailable for this day");
		echo json_encode($arr);
}else{
$start = substr($timee,0,2);
$endstring = substr($timee, 8,7);
$end = substr($timee,8,2);

if(substr($start,0,1) == "0"){
	$start = intval(substr($start, 1,1));
}
if($end == "01"){
	$end = 13;
}
if($end == "02"){
	$end = 14;
}
if($end == "03"){
	$end = 15;
}
if($end == "04"){
	$end = 16;
}
if($end == "05"){
	$end = 17;
}
if($end == "06"){
	$end = 18;
}
if($end == "07"){
	$end = 19;
}
if($end == "08"){
	$end = 20;
}
if($end == "09"){
	$end = 21;
}
if($end == "10"){
	$end = 22;
}

$timeslots = array();
$z="";
for($i =$start;$i<$end;$i++){
	if($i<10){
		$i ="0".$i;
	}
	$z = $i;

	if($i< 12){
		$day = "AM"; 
	}else{
		$day = "PM";
	}
	if($i==13){
		$z = "01";
	}
	if($i==14){
		$z = "02";
	}
	if($i==15){
		$z = "03";
	}
	if($i==16){
		$z = "04";
	}
	if($i==17){
		$z = "05";
	}
	if($i==18){
		$z = "06";
	}
	if($i==19){
		$z = "07";
	}
	if($i==20){
		$z = "08";
	}
	if($i==21){
		$z = "09";
	}
	if($i==22){
		$z = "10";
	}
	
	for($k = 0;$k<60;$k=$k+10){
		if($k == 0){
			$k = "00";
		}else{
			$k = $k;
		}
		$timeslots[] = $z.":".$k.$day;
	}
}
array_push($timeslots, $endstring);
$timeslots = array_diff($timeslots, $rows);
echo json_encode($timeslots);
}
}
}




?>