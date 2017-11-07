
<?php
require('../site_config.php');
$HOST = database_config::$HOST;
$USER = database_config::$USER;
$PASSWORD = database_config::$PASSWORD;
$DBN = database_config::$DATABASE_NAME;

$connection = new MySQLi($HOST,$USER,$PASSWORD,$DBN);
 
	$key = $_GET['key'];
$getLocs = $connection->query("SELECT location FROM properties WHERE (location LIKE '%$key%')");
	if(!$connection->error){
		if($getLocs->num_rows==0){
			echo "<p class=\"no-data-loaded\" >No suggestion for '".$key."'</p>";
		}
		else{ 
		echo "<ul style=\"padding:0px;margin:0px;\">
		<p style=\"color:blue;margin:0px;display:block; padding:5px;background-color:white; box-shadow:0px 5px 5px #555;\">
		Do you mean: </p>";
		while($loc = $getLocs->fetch_array(MYSQLI_ASSOC)){
			$l = $loc['location'];
	echo "<li onclick=\"setLocation('$l')\" class=\"suggestion-box-list grey\">
	<span class=\"glyphicon glyphicon-map-marker e3-border padding-10\" style=\"border-radius:50%;\"></span>$l</li>";
		}
		echo"</ul>";
	}
}
	else{
		echo "<div class=\"search-whatsup\">could not get suggestion</div>";
	}

$connection->close();

?>