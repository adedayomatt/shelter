<?php
require('../site_config.php');
$HOST = database_config::$HOST;
$USER = database_config::$USER;
$PASSWORD = database_config::$PASSWORD;
$DBN = database_config::$DATABASE_NAME;

$connection = new MySQLi($HOST,$USER,$PASSWORD,$DBN);
 
	$key = $_GET['key'];
$getAgents = $connection->query("SELECT * FROM profiles WHERE (Business_Name LIKE '%$key%')");
	if(!$connection->error ){
		if($getAgents->num_rows==0){
			echo "<div><p class=\"no-data-loaded\">no result found for '".$key."'</p>
				</div>";
		}
		else{
			echo "<ul style=\"padding:0px;margin:0px;\">";
		while($agent = $getAgents->fetch_array(MYSQLI_ASSOC)){
			echo "<a href=\"$root/".$agent['User_ID']."\" class=\"suggestion-box-link\">
			<li class=\"suggestion-box-list\">
			<span class=\"black-icon search-result-icon\"></span>".$agent['Business_Name']."
			</li></a>";
		}
		echo"</ul>";
	}
}
	else{
		echo "<div class=\"search-whatsup\">There was an error fetch agents profiles</div>";
	}


?>