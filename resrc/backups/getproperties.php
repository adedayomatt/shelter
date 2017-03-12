<?php
/*
This script get all the properties in the database
*/
$propertyId = array();
$type = array();
$location = array();
$rent = array();
$min_duration = array();
$tiles = array();
$pmachine = array();
$comment = array();
$date_uploaded = array();
GLOBAL $count;
$count = 0;
function partialfetch(){
require('require/db_connect.php');
if($db_connection){
	mysql_select_db('shelter');
$fetchpropeties = "SELECT property_ID,type,location,rent,min_payment,comment,date_uploaded FROM properties ORDER BY date_uploaded DESC";
$fetchpropeties_Query = mysql_query($fetchpropeties,$db_connection);
if($fetchpropeties_Query){
	while($property = mysql_fetch_array($fetchpropeties_Query,MYSQL_ASSOC)){
	$propertyId[$count] = $property['property_ID'];
	$type[$count] = $property['type'];
	$location[$count] = $property['location'];
	$rent[$count] = $property['rent'];
	$min_payment[$count] = $property['min_payment'];
	$comment[$count] = $property['comment'];
	$date_uploaded[$count] = $property['date_uploaded'];
	$count++;
		}
	}
else{
	echo "<p align=\"center\"><b>An error occured!!</b></p>";
			}
		}
	}
function fullfetch(){
		$count = 0;
	require('require/db_connect.php');
if($db_connection){
	mysql_select_db('shelter');
	$fetchpropeties = "SELECT * FROM properties ORDER BY date_uploaded DESC";
$fetchpropeties_Query = mysql_query($fetchpropeties,$db_connection);
if($fetchpropeties_Query){
	while($property = mysql_fetch_array($fetchpropeties_Query,MYSQL_ASSOC)){
	$propertyId[$count] = $property['property_ID'];
	$type[$count] = $property['type'];
	$location[$count] = $property['location'];
	$rent[$count] = $property['rent'];
	$min_payment[$count] = $property['min_payment'];
	$tiles[$count] = $property['tiles'];
	$pmachine[$count] = $property['pumping_machine'];
	$comment[$count] = $property['comment'];
	$date_uploaded[$count] = $property['date_uploaded'];
	$count++;
}
}
else{
	echo "<p align=\"center\"><b>An error occured!!</b></p>";
			}
		}
	}
?> 