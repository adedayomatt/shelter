
<?php
$connect = true;
require('../require/connexion.php');
	$key = $_GET['key'];
$getLocs = mysql_query("SELECT location FROM properties WHERE (location LIKE '%$key%')");
	if($getLocs){
		if(mysql_num_rows($getLocs)==0){
			//echo "<div class=\"search-whatsup\">No suggestion for '".$key."'</div>";
		}
		else{ 
		echo "<ul style=\"padding:0px;margin:0px; background-color:#DDD;\">";
		while($loc = mysql_fetch_array($getLocs,MYSQL_ASSOC)){
			$l = $loc['location'];
	echo "<li onclick=\"setLocation('$l')\" class=\"suggested-location-list\"><span class=\"black-icon search-result-icon\"></span>$l</li>";
		}
		echo"</ul>";
	}
}
	else{
		echo "<div class=\"search-whatsup\">could not get suggestion</div>";
	}


?>