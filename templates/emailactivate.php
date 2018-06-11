<!DOCTYPE html>
<html>
<head>
	<title>Email Authorization</title>
	<link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

</head>
<style type="text/css">
html,body{width:100%;height: 100%;padding: 0;margin:0;}
</style>
<body>

	<p style="text-align:center;width:100%;position:relative;top:40%;color:#00A6FB;font-size:16px;font-weight:600;font-family:'Open Sans', sans-serif;
	">Thank You,Your Email is now authorized,You Will be able to login after your account verification is successfull</p>

</body>
</html>
<?php

mysql_connect('localhost','hcx10ho2_naveen','password');
mysql_select_db('hcx10ho2_app') or die("Cannot connect to db");
$uid = @$_GET['uid'];
$query = mysql_query('UPDATE registeruser SET emailstatus="1" WHERE uid="'.$uid.'"');



?>
