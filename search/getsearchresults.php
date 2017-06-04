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

$max = 4;
if(isset($_GET['next']) && $_GET['next']>0){
	$start = $_GET['next'];
}
 else{
	 $start = 0;
 }
 $x = $start+1;
 $y = $start;
//if user is searching from related results based on type or price or location, fake data are assigned to the other ones.
if($propertytype=="all"  && $loc=="everywhere" || $maxprice==0){
	if($loc=="everywhere" && $maxprice==0){
	if($propertytype=="All type"){
	$contentshowing = "Showing result for <strong>all</strong> properties";
	$totalFound = mysql_num_rows(mysql_query("SELECT property_ID FROM properties ORDER BY date_uploaded"));
		$fetchpropeties = "SELECT property_ID,directory,type,location,rent,min_payment,bath,toilet,description,uploadby,date_uploaded,timestamp FROM properties ORDER BY date_uploaded DESC LIMIT $start,$max";
	
	}
	else{
	$contentshowing = "Showing result for <strong>$propertytype</strong>";
	$totalFound = mysql_num_rows(mysql_query("SELECT property_ID FROM properties WHERE(type='$propertytype')"));
		$fetchpropeties = "SELECT property_ID,directory,type,location,rent,min_payment,bath,toilet,description,uploadby,date_uploaded,timestamp FROM properties WHERE(type='$propertytype') ORDER BY date_uploaded DESC LIMIT $start,$max";	
			
		}
	}
	else if($propertytype=="all"  && $loc=="everywhere"){
		$contentshowing = "Showing result for <strong>all types</strong> with rent not more than <strong>$maxprice</strong>";
		$totalFound = mysql_num_rows(mysql_query("SELECT property_ID FROM properties WHERE(rent<=$maxprice)"));
		$fetchpropeties = "SELECT property_ID,directory,type,location,rent,min_payment,bath,toilet,description,uploadby,date_uploaded,timestamp FROM properties WHERE(rent<=$maxprice) ORDER BY date_uploaded DESC LIMIT $start,$max";	
		
	}
	else if($propertytype=="all" && $maxprice==0){
		$contentshowing = "Showing result for <strong>all types</strong> around <strong>$loc</strong>";
		$totalFound = mysql_num_rows(mysql_query("SELECT property_ID FROM properties WHERE(location LIKE '%$loc%')"));
		$fetchpropeties = "SELECT property_ID,directory,type,location,rent,min_payment,bath,toilet,description,uploadby,date_uploaded,timestamp FROM properties WHERE(location LIKE '%$loc%') ORDER BY date_uploaded DESC LIMIT $start,$max";	
		}
}
//if user is search from the search form itself
	else{
	if($propertytype=="All types"  && empty($loc)){
		$contentshowing = "Showing result for <strong>all types</strong> with rent not more than <strong>$maxprice</strong>";
		$totalFound = mysql_num_rows(mysql_query("SELECT property_ID FROM properties WHERE(rent<=$maxprice)"));
		$fetchpropeties = "SELECT property_ID,directory,type,location,rent,min_payment,bath,toilet,description,uploadby,date_uploaded,timestamp FROM properties WHERE(rent<=$maxprice) ORDER BY date_uploaded DESC LIMIT $start,$max";	
		
	}
	else if($propertytype !="All types"  && empty($loc)){
		$contentshowing = "Showing result for <strong>$propertytype</strong> with rent not more than <strong>$maxprice</strong>";
		$totalFound = mysql_num_rows(mysql_query("SELECT property_ID FROM properties WHERE(type='$propertytype' AND rent<=$maxprice)"));
		$fetchpropeties = "SELECT property_ID,directory,type,location,rent,min_payment,bath,toilet,description,uploadby,date_uploaded,timestamp FROM properties WHERE(type='$propertytype' AND rent<=$maxprice) ORDER BY date_uploaded DESC LIMIT $start,$max";	
	}
	//if user select a property type and did not specify maxprice and location, fetch all records that match the property type 
	else if($propertytype == "All types" && !empty($loc)){
		$contentshowing = "Showing result for <strong>all</strong> recent properties with rent not more than <strong>$maxprice</strong> at <strong>$loc</strong> ";
		$totalFound = mysql_num_rows(mysql_query("SELECT property_ID FROM properties WHERE (rent<=$maxprice) AND (location LIKE '%$loc%')"));
		$fetchpropeties = "SELECT property_ID,directory,type,location,rent,min_payment,bath,toilet,description,uploadby,date_uploaded,timestamp FROM properties WHERE (rent<=$maxprice) AND (location LIKE '%$loc%') ORDER BY date_uploaded DESC LIMIT $start,$max";	
	}
	else if($propertytype != "All types" && !empty($loc)){
		$contentshowing = "Showing result for <strong>$propertytype</strong> with rent not more than <strong>$maxprice</strong> at <strong>$loc</strong> ";
		$totalFound = mysql_num_rows(mysql_query("SELECT property_ID FROM properties WHERE (type = '$propertytype' AND rent<=$maxprice AND location LIKE '%$loc%')"));
		$fetchpropeties = "SELECT property_ID,directory,type,location,rent,min_payment,bath,toilet,description,uploadby,date_uploaded,timestamp FROM properties WHERE (type = '$propertytype' AND rent<=$maxprice AND location LIKE '%$loc%') ORDER BY date_uploaded DESC LIMIT $start,$max";	
	}
	}
//if from suggestions
	
echo "<p class=\"inline-block all-corners-border-1\" style=\" padding: 2%;\">$contentshowing</p>";
$fetchresult = mysql_query($fetchpropeties);
if($fetchresult){
echo "<p class=\"inline-block all-corners-border-1\" style=\" padding: 2%;\">Total Result found: ".$totalFound."</p>";
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
	$howlong[$count] = $property['timestamp'];
	$y++;
	$count++;
/*last value of count will eventually equals to the total records fetched and the value is pass to propertyboxes.php*/
		}
	}
else{
	echo "<p align=\"center\"><b>An error occured!!</b></p>";
			}
		

	?>