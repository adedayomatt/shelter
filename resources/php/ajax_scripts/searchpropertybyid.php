<?php
	$id = $_GET['pid'];
	$agent_ = $_GET['agent'];
	
require('../master_script.php');
$HOST = database_config::$HOST;
$USER = database_config::$USER;
$PASSWORD = database_config::$PASSWORD;
$DBN = database_config::$DATABASE_NAME;

$connection = new MySQLi($HOST,$USER,$PASSWORD,$DBN);
 
$getproperty = $connection->query("SELECT * FROM properties LEFT JOIN profiles ON (properties.uploadby = profiles.User_ID) WHERE (property_ID LIKE '%$id%' AND User_ID = '$agent_')");
	if(!$connection->error ){
		if($getproperty->num_rows==0){
    ?>
<div>
<p class="no-data-loaded">None of your properties is found with the PID '<?php echo $id ?>'</p>
	</div>
<?php
		}
		else{
while($p = $getproperty->fetch_array(MYSQLI_ASSOC)){
?>
<div class="row white-background e3-border" style="margin-bottom:5px;">
<h3 class="red"><?php echo $p['property_ID']?></h3>
<div class="row white-background e3-border" style="margin-bottom:5px">
	<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
	<img src="<?php echo $property_obj->get_property_dp('../properties/'.$p['directory'],$p['display_photo']) ?>" class="mini-property-photo"/>
	</div>
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
		<div class="font-20 margin-5"><a href="<?php echo "../properties/".$p['directory']?>"><?php echo $p['type'] ?></a></div>
		<div class="margin-5 grey"><span class="glyphicon glyphicon-map-marker red"></span><?php echo $p['location'] ?></div>
		<div class="margin-5 grey"><span class="glyphicon glyphicon-calendar red"></span>updated <?php echo $general->since($p['last_reviewed']) ?></div>
		<div class="margin-5 grey"><a class="btn btn-primary" href="<?php echo 'property.php?id='.$p['property_ID'].'&action=change&agent='.$p['token'] ?>"><span class="glyphicon glyphicon-pencil"></span>update</a> <a class="text-right float-right " href=""><span class="glyphicon glyphicon-trash red"></span></a></div>
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

$connection->close();
