<?php
if(isset($_GET['p']) && isset($_GET['cb']) && isset($_GET['ref'])){
	$property = $_GET['p'];
	$by = $_GET['cb'];
	$ref = $_GET['ref'];
	$connect = true;
//since this scripts does not require header, then the connexion is required directly
	require('../require/connexion.php');
	$getclipped = mysql_query("SELECT * FROM clipped where (propertyId='$property' AND clippedby='$by')");
//if clipped already
	if(mysql_num_rows($getclipped)==1){
		$unclip = mysql_query("DELETE FROM clipped WHERE (clipped.propertyId='$property' AND clipped.clippedby='$by')");
		if(!$unclip){
			echo "<script>alert(\"unclipping of $property failed\");</script> ";
		}
	}
//if not clipped before
	else{
		$clip = mysql_query("INSERT INTO clipped (propertyId,clippedby) VALUE ('$property','$by')");
		if(!$clip){
			echo "<script>alert(\"clipping of $property failed\");</script> ";
			}
		}
		mysql_close($db_connection);
//redirect back to the prevoius page
	if($ref=='home_page' && isset($_GET['next'])){
		$jump = $_GET['next'];
		header("location: ../?next=$jump");
	}
	else if ($ref=='home_page' && !isset($_GET['next'])){
		header("location: ../");
	}
	else if ($ref=='search_page' && isset($_GET['next'])){
		$jump = $_GET['next'];
		header("location: ../search/?next=$jump");
	}
	else if ($ref=='search_page' && !isset($_GET['next'])){
		$jump = $_GET['next'];
		header("location: ../search");
	}
	else if ($ref=='match_page' && !isset($_GET['next'])){
		$jump = $_GET['next'];
		header("location: ../cta");
	}
	
	
}


?>