<?php
/**
This script fetch part of the record
**/
$count = 0;
require('../require/db_connect.php');
if($db_connection){
	mysql_select_db('shelter');
$x =0;
while($x<$clipcounter){
	$getMatches = "SELECT property_ID,directory,type,location,min_payment,bath,toilet,rent,description,uploadby,date_uploaded FROM properties WHERE (property_ID='".$clippedproperty[$x]."') ORDER BY date_uploaded DESC";
	$getMatches_sql = mysql_query($getMatches,$db_connection);
if($getMatches_sql){
	while($property = mysql_fetch_array($getMatches_sql,MYSQL_ASSOC)){
	$propertyId[$count] = $property['property_ID'];
	$propertydir[$count] = $property['directory'];
	$type[$count] = $property['type'];
	$location[$count] = $property['location'];
	$rent[$count] = $property['rent'];
	$min_payment[$count] = $property['min_payment'];
	$bath[$count] = $property['bath'];
	$toilet[$count] = $property['toilet'];
	$description[$count] = $property['description'];
	$date_uploaded[$count] = $property['date_uploaded'];
	$uploadby[$count] = $property['uploadby'];
	$count++;
//last value of count will eventually equals to the total records fetched.
		}
	}
else{
	echo "<p align=\"center\"><b>An error occured!!</b></p>";
	mysql_close($db_connection);
	exit();
			}
$x++;
}

	mysql_close($db_connection);
	
		}

	?>