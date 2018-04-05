<?php
require('api_tools.php');

$connection = connect();
	$key = $_GET['key'];
$getAgents = $connection->query("SELECT * FROM profiles WHERE (Business_Name LIKE '%$key%')");
	if(!$connection->error ){
		if($getAgents->num_rows==0){
			echo "<p class=\"text-center\">no result found for <strong>".$key."</strong></p>";
		}
		else{
			echo "<ul class=\"padding-0\">";
		while($agent = $getAgents->fetch_array(MYSQLI_ASSOC)){
			echo "<a href=\"$root/agents/".$agent['User_ID']."\" class=\"black icon-n-text\">
			<li class=\"result-list\">
			<span class=\"glyphicon glyphicon-briefcase icon\"></span><span class=\"text\">".$agent['Business_Name']."</span>
			<p class=\"text-right grey\"><span class=\"glyphicon glyphicon-map-marker\"></span>".$agent['Office_Address']."</p>
			</li>
			</a>";
		}
		echo"</ul>";
	}
}
	else{
		echo "<p class=\"text-center red\">There was an error fetch agents profiles</p>";
	}

$connection->close();
?>
<style>
a:hover{
	text-decoration:none;
}
</style>