<?php
/**
This script fetch part of the record
**/
$count = 0;
require('../require/db_connect.php');
if($db_connection){
	mysql_select_db('shelter');
	//get properties by agent with the username $Aid(from index.php)
$fetchpropeties = mysql_query("SELECT property_ID,directory,type,location,rent,min_payment,bath,toilet,description,uploadby,date_uploaded FROM properties WHERE (uploadby='".$Aid."')ORDER BY date_uploaded DESC");
if($fetchproperties){
	while($property = mysql_fetch_array($fetchproperties,MYSQL_ASSOC)){
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
			}
		}	
			

	?>