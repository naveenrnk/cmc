<?php
$timeslots = array();
for(var i = 7,i<22,i++){
	i ="0"+i;
	for(var k = 0,k<60,k=k+10){
		if(k == 0){
			k = "00";
		}else{
			k = k;
		}
		$timeslots[] = i + " "+ k;
	}
}
console.log($timeslots);
?>