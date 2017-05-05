<?php
//$root = "http://localhost/shelter";
$root = "http://192.168.173.1/shelter";
if(isset($connect) and $connect==true){
$dbhost = '127.0.0.1';
$dbuser = 'adedayo';
$dbpass = 'matthew';
$db_connection = @mysql_connect($dbhost, $dbuser, $dbpass);
if($db_connection) {
mysql_select_db('shelter');
}
else{
	echo "
<html>
<head><title>Connection failed!</title></head>
<body>
<div style=\"padding:10%; line-height:200%;\">
<h2 align=\"center\">No Connection to Server</h2>
<p align=\"center\">Connection to the server could not be established. We are sorry for any inconviniency this might bring you and please be assured that we are working hard to resolve it soon</p>
</div>
</body>
</html>";
exit(); 
}
}
else{
	echo "
<html>
<head><title>Page not Available!</title></head>
<body>
<div style=\"padding:10%; line-height:200%;\">
<h2 align=\"center\">Page temporarily not available.</h2>
<p align=\"center\">This page you are trying to view is temporarily not available. We are sorry for any inconviniency this might bring you. You can <a href=\"$root\">visit our homepage</a></p>
</div>
</body>
</html>";
exit(); 
}
?>