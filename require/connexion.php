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
<br/><br/><hr/><p align=\"center\">There was a fatal error while connecting with the server <br/>We are working hard to resolve it soon<br/><hr/><br/><br/></p>
</body>
</html>";
exit(); 
}
}

?>