
<?php
$connect = true;
require('../require/connexion.php');
	$key = $_GET['key'];
$getLocs = mysql_query("SELECT location FROM properties WHERE (location LIKE '%$key%')");
	if($getLocs){
		if(mysql_num_rows($getLocs)==0){
			echo "<p class=\"no-data-loaded\" >No suggestion for '".$key."'</p>";
		}
		else{ 
		echo "<ul style=\"padding:0px;margin:0px;\">
		<p style=\"color:blue;margin:0px;display:block; width:96%; padding:2%;background-color:white; box-shadow:0px 5px 5px #555;\">Do you mean: </p>
		";
		while($loc = mysql_fetch_array($getLocs,MYSQL_ASSOC)){
			$l = $loc['location'];
	echo "<li onclick=\"setLocation('$l')\" class=\"suggestion-box-list\"><span class=\"black-icon search-result-icon\"></span>$l</li>";
		}
		echo"</ul>";
	}
}
	else{
		echo "<div class=\"search-whatsup\">could not get suggestion</div>";
	}


?>