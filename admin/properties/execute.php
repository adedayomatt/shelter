<html>
<head><title>Admin|Confirm</title></head>
<body>
<p align="center"> You have requested to peform the following tasks</p>
<?php
//initialize an empty array that colloects info about records selected
$affected = array();
//if submitted...
if(isset($_GET['execute'])){
/*connect to the database*/
	require('../../require/db_connect.php');
/*if connection is successful*/
	if($db_connection){
/*select database*/
	mysql_select_db('shelter');
/*Get all the ids in the table*/
	$fetchIds = "SELECT property_ID FROM properties ORDER BY date_uploaded DESC";
$fetchIds_Query = mysql_query($fetchIds,$db_connection);
if($fetchIds_Query)
{
	/*if there is any id that matches the ones selected, add it to $affected[]*/
	while($existing = mysql_fetch_array($fetchIds_Query,MYSQL_ASSOC)){
		$x = $existing['property_ID'];
		if(isset($_GET["$x"])){
			$affected[] = $existing['property_ID'];
				}
			}
		}
	}
	mysql_close($db_connection);
}
/*if affected array is not empty...*/
if(!empty($affected)){
	/*switch the what to do with the records selected, if 0, deleted them using the erase() function..*/
	if(isset($_GET['action'])){
	switch($_GET['action']){
	case 0:
	$no = 0;
	foreach($affected as $victims){
		erase($victims);
		$no++;
	}
echo "<script>alert(\"You have successfully deleted $no records\");window.location=\"http://localhost/shelter/admin/properties\";</script>";
	break;
	case 1:
	//block
	echo "<h4 align=\"center\" color=\"red\">Blocking not availble yet!</h4>";
	foreach($affected as $victims){
		block($victims);
	}
	break;
}
	}
	//if no action is selected
else{
	echo "<script>alert(\"No action was selected\");window.location=\"http://localhost/shelter/admin/properties\";</script>";
}
}

else{
	echo "<script>alert(\"You did not select any record\");window.location=\"http://localhost/shelter/admin/properties\";</script>";
}

function erase($que){
	$no = 1;
	require('../../require/db_connect.php');
	mysql_select_db('shelter');
		$delete_statement = "DELETE FROM properties WHERE properties.property_ID='".$que."'";
		$delete_query = mysql_query($delete_statement,$db_connection);
		if(!$delete_query){
			echo "<p align=\"center\">deleting $que unsuccesful</p>";
		}
	//
	mysql_close($db_connection);
}
function block($que){
	echo "<p align=\"center\">You cannot block ".$que."</p>";
}
?>
</body>
</html>