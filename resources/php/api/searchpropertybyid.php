<?php
	$id = $_GET['pid'];
	$agent_ = $_GET['agent'];
	
require('../../master_script.php');
 
$getproperty = $db->query_object("SELECT property_ID AS id FROM properties  WHERE (property_ID LIKE '%$id%' AND uploadby = '$agent_')");
	if(!$db->connection->error ){
		if($getproperty->num_rows==0){
    ?>
<div class="text-center padding-10 e3-border">None of your properties is found with the PID '<?php echo $id ?>'</div>
<?php
		}
		else{
while($p = $getproperty->fetch_array(MYSQLI_ASSOC)){
	$property = new property($p['id']);
?>
<div class="row white-background e3-border" style="margin-bottom:5px;">
<h3 class="red"><?php echo $property->id ?></h3>
<div class="row white-background e3-border" style="margin-bottom:5px">
	<div class="padding-5">
		<div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
			<img src="<?php echo substr($property->display_photo_url(),strlen('../../')) ?>" class="mini-property-image size-100"/>
		</div>
		<div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">
			<div class="font-20 margin-5"><a href="<?php echo "../properties/".$property->p_directory?>"><?php echo $property->type ?></a></div>
			<div class="margin-5 grey"><span class="glyphicon glyphicon-map-marker red"></span><?php echo $property->location ?></div>
			<div class="margin-5 grey"><span class="glyphicon glyphicon-calendar red"></span>updated <?php echo $tool->since($property->last_reviewed) ?></div>
			<div class="margin-5 grey"><a class="btn btn-primary" href="<?php echo 'property.php?id='.$property->id.'&action=change&agent='.$property->agent_token ?>"><span class="glyphicon glyphicon-pencil"></span>update</a> <a class="text-right float-right " href=""><span class="glyphicon glyphicon-trash red"></span></a></div>
		</div>
	</div>
</div>
</div>
<?php
}
$getproperty->free();

	}
}
	else{
		echo "<div class=\"search-whatsup\">Oops!, an error occurred while getting your properties</div>";
	}
?>
<div style="display:none">
<?php
$db->close();
?>
</div>