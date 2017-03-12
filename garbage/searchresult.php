//if user  selet property types and did not specify  location, fetch all records that match the type and price
	else if($propertytype!="All types" && $maxprice!="" && $loc==""){
		$contentshowing = "Showing all <strong>$propertytype</strong> with rent not more than <strong>".number_format($maxprice)."</strong>";
		$fetchpropeties = "SELECT property_ID,type,location,rent,min_payment,description,uploadby,date_uploaded FROM properties WHERE (type = '$propertytype') AND (rent<$maxprice) ORDER BY date_uploaded DESC";	
	}
	//if user  selet property types and did not specify  maxprice, fetch all records that match the type and location
	else if($propertytype!="All types" && $maxprice=="" && $loc!=""){
	$contentshowing = "Showing all <strong>$propertytype</strong> at <strong>$loc</strong>";
		$fetchpropeties = "SELECT property_ID,type,location,rent,min_payment,description,uploadby,date_uploaded FROM properties WHERE (type = '$propertytype') AND (location LIKE '%$loc%') ORDER BY date_uploaded DESC";		
	}
	else if($propertytype=="All types" && $maxprice!="" && $loc!=""){
	$contentshowing = "Showing <strong>$propertytype</strong> around <strong>$loc</strong> with rent not more than <strong>".number_format($maxprice)."</strong> ";
		$fetchpropeties = "SELECT property_ID,type,location,rent,min_payment,description,uploadby,date_uploaded FROM properties WHERE (rent < '$maxprice') AND (location LIKE '%$loc%') ORDER BY date_uploaded DESC";		
	}
	//if user  selet all property types and maxprice without location preference, fetch all types of records that match the  maxprice 
	else if($propertytype=="All types" && $maxprice!="" && $loc=""){
		$contentshowing = "showing result for <strong>". $propertytype. "</strong> with rent not more than <strong>".number_format($maxprice)."</strong>";
		$fetchpropeties = "SELECT property_ID,type,location,rent,min_payment,description,uploadby,date_uploaded FROM properties WHERE (rent<$maxprice) AND (location LIKE '%$loc%') ORDER BY date_uploaded DESC";
		}
	//if user  selet property types, maxprice and location, fetch all records that match the type, maxprice and location
	else if($propertytype!="All types" && $maxprice!="" && $loc!=""){
		$contentshowing = "showing result for <strong>". $propertytype. "</strong> around <strong>".$loc. "</strong> with rent not more than <strong>".number_format($maxprice)."</strong>";
		$fetchpropeties = "SELECT property_ID,type,location,rent,min_payment,description,uploadby,date_uploaded FROM properties WHERE (type = '$propertytype') AND (rent<$maxprice) AND (location LIKE '%$loc%') ORDER BY date_uploaded DESC";
		}
		else{
			$contentshowing ="This search instance has not been programmed, therefore the result shows all records without any filteration";
			echo ">>".$propertytype."| ".number_format($maxprice)."| ".$loc;
		$fetchpropeties = "SELECT property_ID,type,location,rent,min_payment,description,uploadby,date_uploaded FROM properties ORDER BY date_uploaded DESC";	

		}