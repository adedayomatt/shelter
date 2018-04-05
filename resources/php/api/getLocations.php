<?php
	require('api_tools.php');

$connection = connect();
 
	$key = $_GET['key'];
$getLocs = $connection->query("SELECT CONCAT(area,', ',city) AS location FROM properties WHERE (area LIKE '%$key%' OR city LIKE '%$key%') GROUP BY CONCAT(area,', ',city)");
	if(!$connection->error){
		if($getLocs->num_rows==0){
			echo "<div class=\"text-center white-background padding-10 \">No suggestion for <strong>".$key."</strong></div>";
		}
		else{ 
		echo "<div class=\"text-center f7-background padding-10 e3-border-bottom\">Do you mean: </div>
				<ul class=\"padding-0\">";
		while($loc = $getLocs->fetch_array(MYSQLI_ASSOC)){
			$l = $loc['location'];
	echo "<li onclick=\"setLocation('$l')\" class=\"result-list\">
	<span class=\"glyphicon glyphicon-map-marker icon\"></span><span class=\"text\">$l</span></li>";
		}
		echo"</ul>";
	}
}
	else{
		echo "<div class=\"text-center red\">could not get suggestion</div>";
	}

$connection->close();

?>