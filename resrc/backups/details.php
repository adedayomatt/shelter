<html>
<head>
<?php
$pagetitle = "";
if(isset($_COOKIE['name'])){
	require('require/user_header.php');
}
else{
	require('require/header.php');
}

?>

</head>
<body>
<?php
$shid=$_GET['shid'];

require('require/db_connect.php');
mysql_select_db('shelter');
if($db_connection){
	$getquery = "SELECT FROM properties WHERE (property_ID = ".$shid.")";
	$executegetquery = ($getquery,$db_connection);
	if($executegetquery){
		if(mysql_affected_rows==1){
		while($detail = mysql_fetch_array($executegetquery,MYSQL_ASSOC)){
			$id = $detail['property_ID'];
			$type = $detail['type'];
			$location = $detail['location'];
			$rent = $detail['rent'];
			$mp = $detail['min_payment'];
			$tile = $detail['tiles'];
			$pm = $detail['pumping_machine'];
			$comment = $detail['comment'];
			$date = $detail['date_uploaded'];
			$manager = $detail['uploadby'];
		}
		}
	}
	echo $id." ".$manager;
}
?>
</body>
</html>