<?php
/*
This script handles uploading of new data to the database
*/
if($status==1)){
	addproperty();
}
else{
	r
	exit();
}

function addproperty(){
	//Receiving information from the submitted form
$propertyId = generateid();
$type = $_POST['type'];
$location =mysql_real_escape_string($_POST['location']);
$rent = $_POST['rent'];
$min_payment = $_POST['min_payment'];
$bath = $_POST['bath'];
$loo = $_POST['loo'];
$pmachine = status($_POST['pmachine']);
$borehole = status($_POST['borehole']);
$well = status($_POST['well']);
$tiles = status($_POST['tiles']);
$pspace = status($_POST['pspace']);
$electricity = $_POST['electricity'];
$road = $_POST['road'];
$social = $_POST['social'];
$security = $_POST['security'];
$description = mysql_real_escape_string($_POST['description']);
$manager = $_COOKIE['name'];



require("../require/db_connect.php");
if($db_connection){
mysql_select_db("shelter");
$upload = "INSERT INTO properties"; 
$upload .= "(property_ID,type,location,rent,min_payment,bath,toilet,pumping_machine,borehole,well,tiles,parking_space,electricity,road,socialization,security,description,uploadby,date_uploaded)";
$upload .="VALUES('$propertyId','$type','$location',$rent,'$min_payment',$bath,$loo,'$pmachine','$borehole','$well','$tiles','$pspace',$electricity,$road,$social,$security,'$description','$manager',NOW())";
echo $upload;
$uploadQuery = mysql_query($upload,$db_connection);
//if recorded addedd successfully
if($uploadQuery){
	setcookie('id',$propertyId,time()+300,"/","",0);
	header("Location: http://localhost/shelter/upload/addphoto.php");
//echo"<script>alert(\" upload successfull, proceed to add photos!!\"); window.location=\"http://localhost/shelter/upload/addphoto.php\"</script>";

}
else{
	echo"<script>alert(\"There was an error\"); \"</script>";
	//window.location=\"http://localhost/shelter/upload
		}
		mysql_close($db_connection);
	}
}
/*
This function  randomly generate a unique Id.
*/
function generateid(){
	$alphabets = ['A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z'];
	$firstalphaIndex = rand(0,25);
	$firstalpha  = $alphabets[$firstalphaIndex];
	$secondalphaIndex = rand(0,25);
	$secondalpha  = $alphabets[$secondalphaIndex];
	$thirdalphaIndex = rand(0,25);
	$thirdalpha  = $alphabets[$thirdalphaIndex];
	$figure = rand(1000,9999);
	$final = $firstalpha.$secondalpha.$thirdalpha.$figure;
	//check if the ID already exist
	require("../require/db_connect.php");
if($db_connection){
	mysql_select_db("shelter");
	$fetchId = "SELECT property_ID FROM properties";
	$fetchIdQuery = mysql_query($fetchId,$db_connection);
	//if fetching the IDs is successfull...
	if($fetchIdQuery){
		while($id = mysql_fetch_array($fetchIdQuery,MYSQL_ASSOC)){
			if($id['property_ID'] == $final){
				$exist=$id['property_ID'];
			}
		}
		//if there is no any match with the final id, then return the value...
		if(!isset($exist)){
			return $final;
		}
		//if there is any match with the final id, then recurse the function generateid until no match is found
		else{
			generateid();
		}
	}
	//if query to fetch id is unsucessful
	else{
		echo 'Error occur while verifying ID';
		}
		mysql_close($db_connection);
	}
	
}

function status($form_field){
	if(isset($form_field)){
	return $form_field;
}
else{
	return 'No';
}
}


?>