<?php
	require('api_tools.php');

if(isset($_GET['p']) && isset($_GET['cb']) && isset($_GET['ref'])){

	$property = $_GET['p'];
	$by = $_GET['cb'];
	$ref = $_GET['ref'];
	$client_token = $_GET['tkn'];

//if cta is checked in
if(isset($_COOKIE['user_client']) && $_COOKIE['user_client']==$client_token){

$connection = connect();
 
if(!$connection->connect_error) {

	$RemainingClips_Q = "SELECT * FROM clipped where (clippedby=$by)" ;
	$getclipped = $connection->query("SELECT * FROM clipped WHERE (propertyId='$property' AND clippedby=$by)");
//if clipped already
	if($getclipped->num_rows==1){
		$unclip = $connection->query("DELETE FROM clipped WHERE (clipped.propertyId='$property' AND clipped.clippedby=$by)");
		if($connection->affected_rows==1){
	$remains = $connection->query($RemainingClips_Q)->num_rows;
			if($ref=='ctaPage'){
				echo "removed/".$remains;
			}
			else{
				echo "unclipped/".$remains;
			}
		}
		//if unclipping is unsuccessfull
		else{echo "failed!";}
	}
//if not clipped before
	else{
		$now = time();
		$clip_id = $by + rand(1000000,9999999);
		$clip = $connection->query("INSERT INTO clipped (clip_id,propertyId,clippedby,timestamp) VALUES ($clip_id,'$property',$by,$now)");
		if(!$connection->error){
			$remains = $connection->query($RemainingClips_Q)->num_rows;
			echo "clipped/".$remains;
			}
			else{
				echo "failed! ".$connection->error;
					}
			}
	
	}
$connection->close();
}
//if cta is not logged in
else{
	?>
<div class="text-center">
<p>You can clip properties to view later only when you are checked in your Client Temporary Account (CTA)</p>
<p><a href="<?php echo "$root/cta/checkin.php?a=checkin"?>" class="btn btn-primary">checkin now</a></p>
<h3 class="red">Don't have a CTA yet?</h3>
<p><a href="<?php echo "$root/cta/checkin.php?a=create"?>" class="btn btn-primary">create a new CTA</a></p>
<p class="text-right">Learn about CTA</p>
</div>
	<?php
}
//if GET conttent are not set
}
else{
	header("location: $root");
	exit();
}

?>