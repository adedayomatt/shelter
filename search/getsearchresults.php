<?php
/**
This script fetch part of the record
**/
$propertyId = array();
$type = array();
$location = array();
$rent = array();
$min_duration = array();
$tiles = array();
$date_uploaded = array();
$uploadby = array();
$count = 0;

//if user is searching from related results based on type or price or location, fake data are assigned to the other ones.
if($propertytype=="all"  && $loc=="everywhere" || $maxprice==0){
	if($loc=="everywhere" && $maxprice==0){
	if($propertytype=="All type"){
	$contentshowing = "Showing result for <strong>all</strong> properties";
		$fetchpropeties = "SELECT property_ID,directory,type,location,rent,min_payment,bath,toilet,description,uploadby,date_uploaded FROM properties ORDER BY date_uploaded DESC";	
	}
	else{
	$contentshowing = "Showing result for <strong>$propertytype</strong>";
		$fetchpropeties = "SELECT property_ID,directory,type,location,rent,min_payment,bath,toilet,description,uploadby,date_uploaded FROM properties WHERE(type='$propertytype') ORDER BY date_uploaded DESC";	
		}
	}
	else if($propertytype=="all"  && $loc=="everywhere"){
		$contentshowing = "Showing result for <strong>all types</strong> with rent not more than <strong>$maxprice</strong>";
		$fetchpropeties = "SELECT property_ID,directory,type,location,rent,min_payment,bath,toilet,description,uploadby,date_uploaded FROM properties WHERE(rent<=$maxprice) ORDER BY date_uploaded DESC";	
	}
	else if($propertytype=="all" && $maxprice==0){
		$contentshowing = "Showing result for <strong>all types</strong> around <strong>$loc</strong>";
		$fetchpropeties = "SELECT property_ID,directory,type,location,rent,min_payment,bath,toilet,description,uploadby,date_uploaded FROM properties WHERE(location LIKE '%$loc%') ORDER BY date_uploaded DESC";	
	
	}
}
//if user is searchg from the search form itself
	else{
	if($propertytype=="All types"  && empty($loc)){
		$contentshowing = "Showing result for <strong>all types</strong> with rent not more than <strong>$maxprice</strong>";
		$fetchpropeties = "SELECT property_ID,directory,type,location,rent,min_payment,bath,toilet,description,uploadby,date_uploaded FROM properties WHERE(rent<=$maxprice) ORDER BY date_uploaded DESC";	
	}
	else if($propertytype !="All types"  && empty($loc)){
		$contentshowing = "Showing result for <strong>$propertytype</strong> with rent not more than <strong>$maxprice</strong>";
		$fetchpropeties = "SELECT property_ID,directory,type,location,rent,min_payment,bath,toilet,description,uploadby,date_uploaded FROM properties WHERE(type='$propertytype' AND rent<=$maxprice) ORDER BY date_uploaded DESC";	
	}
	//if user select a property type and did not specify maxprice and location, fetch all records that match the property type 
	else if($propertytype == "All types" && !empty($loc)){
		$contentshowing = "Showing result for <strong>all</strong> recent properties with rent not more than <strong>$maxprice</strong> at <strong>$loc</strong> ";
		$fetchpropeties = "SELECT property_ID,directory,type,location,rent,min_payment,bath,toilet,description,uploadby,date_uploaded FROM properties WHERE (rent<=$maxprice) AND (location LIKE '%$loc%') ORDER BY date_uploaded DESC";	
	}
	else if($propertytype != "All types" && !empty($loc)){
		$contentshowing = "Showing result for <strong>$propertytype</strong> with rent not more than <strong>$maxprice</strong> at <strong>$loc</strong> ";
		$fetchpropeties = "SELECT property_ID,directory,type,location,rent,min_payment,bath,toilet,description,uploadby,date_uploaded FROM properties WHERE (type = '$propertytype' AND rent<=$maxprice AND location LIKE '%$loc%') ORDER BY date_uploaded DESC";	
	}
	}
//if from suggestions
	
echo "<p style=\"margin-left:20px;\"><i>$contentshowing</i></p>";
$fetchresult = mysql_query($fetchpropeties);
if($fetchresult){
	while($property = mysql_fetch_array($fetchresult,MYSQL_ASSOC)){
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
/*last value of count will eventually equals to the total records fetched and the value is pass to propertyboxes.php*/
		}
	}
else{
	echo "<p align=\"center\"><b>An error occured!!</b></p>";
			}
		

	?>