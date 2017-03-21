<?php
if(isset($_GET['p']) && isset($_GET['cb']) && isset($_GET['ref'])){
	$property = $_GET['p'];
	$by = $_GET['cb'];
	$ref = $_GET['ref'];
	$connect = true;
//since this scripts does not require header, then the connexion is required directly
	require('../require/connexion.php');
	$RemainingClips = "SELECT * FROM clipped where (clippedby='$by')" ;
	$getclipped = mysql_query("SELECT * FROM clipped where (propertyId='$property' AND clippedby='$by')");
//if clipped already
	if(mysql_num_rows($getclipped)==1){
		$unclip = mysql_query("DELETE FROM clipped WHERE (clipped.propertyId='$property' AND clipped.clippedby='$by')");
		if($unclip){
	$remains = mysql_num_rows(mysql_query($RemainingClips));
			if($ref=='ctaPage'){
				echo "removed/".$remains;
			}
			else{
				echo "clip/".$remains;
			}
		}
		//if unclipping is unsuccessfull
		else{echo "failed!";}
	}
//if not clipped before
	else{
		$clip = mysql_query("INSERT INTO clipped (propertyId,clippedby) VALUE ('$property','$by')");
		if($clip){
			$remains = mysql_num_rows(mysql_query($RemainingClips));
			echo "unclip/".$remains;
			}
			else{
				echo "failed!";
			}
		}
		mysql_close($db_connection);
		
//redirect back to the prevoius page
/*if(isset($ref) )
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
	*/
	
}


?>