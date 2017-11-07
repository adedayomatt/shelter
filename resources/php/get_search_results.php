<?php

$basic_query = property::$property_query;
$counting_query = "SELECT property_ID FROM properties";


//if user is searching from related results based on type or price or location, fake data are assigned to the other ones.
if($propertytype=="all"  || $loc=="everywhere" || $maxprice==0){
	if($loc=="everywhere" && $maxprice==0){
	if($propertytype=="All type"){
	$filter = "";
	$contentshowing = "Showing result for <strong>all</strong> properties";

	//	$fetchpropeties = "SELECT * FROM properties ORDER BY date_uploaded DESC LIMIT $start,$max";
	
	}
	else{
		$filter = " WHERE(type='$propertytype') ";
	$contentshowing = "Showing result for <strong>$propertytype</strong>";
				}
	}
	else if($propertytype=="all"  && $loc=="everywhere"){
		$filter = " WHERE(rent<=$maxprice) ";
		$contentshowing = "Showing result for <strong>all types</strong> with rent not more than <strong>".number_format($maxprice)."</strong>";
	}
	else if($propertytype=="all" && $maxprice==0){
		$filter = " WHERE(location LIKE '%$loc%') ";
		$contentshowing = "Showing result for <strong>all types</strong> around <strong>$loc</strong>";
		}
}
//if user is searching from the search form itself
	else{
	if($propertytype=="All types"  && empty($loc)){
		$filter = " WHERE(rent<=$maxprice) ";
		$contentshowing = "Showing result for <strong>all types</strong> with rent not more than <strong>".number_format($maxprice)."</strong>";		
	}
	else if($propertytype !="All types"  && empty($loc)){
		$filter = " WHERE(type='$propertytype' AND rent<=$maxprice) ";
		$contentshowing = "Showing result for <strong>$propertytype</strong> with rent not more than <strong>".number_format($maxprice)."</strong>";
	}
	//if user select a property type and did not specify maxprice and location, fetch all records that match the property type 
	else if($propertytype == "All types" && !empty($loc)){
		$filter = " WHERE (rent<=$maxprice) AND (location LIKE '%$loc%') ";
		$contentshowing = "Showing result for <strong>all</strong> recent properties with rent not more than <strong>".number_format($maxprice)."</strong> at <strong>$loc</strong> ";
	}
	else if($propertytype != "All types" && !empty($loc)){
		$filter = " WHERE (type = '$propertytype' AND rent<=$maxprice AND location LIKE '%$loc%') ";
		$contentshowing = "Showing result for <strong>$propertytype</strong> with rent not more than <strong>".number_format($maxprice)."</strong> at <strong>$loc</strong> ";
		}
	}

$final_property_query = $basic_query.$filter.' ORDER BY date_uploaded DESC';
//get all the results any way
$all_search_result = $db->query_object($counting_query.$filter);
$totalFound = $all_search_result->num_rows;
//store all result ids in an array
$all_search_result_IDs = array();
while($r = $all_search_result->fetch_array(MYSQLI_ASSOC)){
$all_search_result_IDs[] = $r['property_ID'];
}
?>	
<div class="row" >
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 result-displaying">
		<p><?php echo $contentshowing ?></p>
		<p>Total Result found: <?php echo $totalFound ?></p>
		</div>
		</div>
<?php
require('../resources/global/property_display.php');
?>

<?php
/*
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
	$howlong[$count] = $property['timestamp'];
	$views[$count] = $property['views'];
	$lastReviewed[$count] = $property['last_reviewed'];
	$avail[$count] = $property['status'];
	$y++;
	$count++;
//last value of count will eventually equals to the total records fetched and the value is pass to propertyboxes.php
		}
	}
else{
	echo "<p align=\"center\"><b>An error occured!!</b></p>";
			}
		
**/
	?>