<?php
$connect = true;
require('../require/connexion.php');
	$key = $_GET['key'];
$getAgents = mysql_query("SELECT * FROM profiles WHERE (Business_Name LIKE '%$key%')");
	if($getAgents){
		if(mysql_num_rows($getAgents)==0){
			echo "<div class=\"search-whatsup\">no result found for '".$key."'</div>";
		}
		else{
			echo "<ul style=\"padding:0px;\">";
		while($agent = mysql_fetch_array($getAgents,MYSQL_ASSOC)){
			echo "<a href=\"".$agent['User_ID']."\" class=\"suggestion-box-link\"><li class=\"suggestion-box-list\"><span class=\"white-icon search-result-icon\"></span>".$agent['Business_Name']."</li></a>";
		}
		echo"</ul>";
	}
}
	else{
		echo "<div class=\"search-whatsup\">There was an error fetch agents profiles</div>";
	}


?>