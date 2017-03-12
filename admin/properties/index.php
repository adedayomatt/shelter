<html>
<link href="../styles.css" type="text/css" rel="stylesheet" />
<head><title>Admin|Records</title>
</head>
<body>
<p align="center">This page is for administration of <a href="http://localhost/shelter">shelter.com</a> </p>
<p><a href="http://localhost/shelter/admin">Home</a></p>
<?php

$propertyId = array();
$type = array();
$location = array();
$rent = array();
$min_duration = array();
$tiles = array();
$pmachine = array();
$comment = array();
$date_uploaded = array();
$uploadedby = array();
$count = 0;
	require('../../require/db_connect.php');
if($db_connection){
	mysql_select_db('shelter');
	$fetchpropeties = "SELECT * FROM properties ORDER BY date_uploaded DESC";
$fetchpropeties_Query = mysql_query($fetchpropeties,$db_connection);
if($fetchpropeties_Query)
{
	echo "<form action=\"execute.php\" method=\"GET\"><table align=\"center\">";
	echo "<th><td></td><td >id</td><td>type</td><td>location</td><td>rent</td><td>min. payment</td><td>tiles</td><td>p. machine</td><td>description</td><td>date uploaded</td><td>managed by</td></th>";
	while($property = mysql_fetch_array($fetchpropeties_Query,MYSQL_ASSOC)){
		$mod = $count%2;
	switch($mod){
		case 0:
		$color = "#eeeeee";
		break;
		case 1:
		$color = "white";
	break;
	}
		echo "<tr style=\"background-color:$color\"><td class=\"noborder\"><input name=\"".$property['property_ID']."\" type=\"checkbox\" value=\"".$property['property_ID']."\"/></td><td>".($count+1)."</td>";
	echo "<td>".$property['property_ID']."</td>";
	 echo "<td>".$property['type']."</td>";
	echo "<td>".$property['location']."</td>";
	echo "<td>". number_format($property['rent'])."</td>";
	echo "<td>".$property['min_payment']."</td>";
	echo "<td>".$property['tiles']."</td>";
	echo "<td>".$property['pumping_machine']."</td>";
	echo "<td>".$property['description']."</td>";
	echo "<td>".$property['date_uploaded']."</td>";
	echo "<td>".$property['uploadby']."</td>";
	echo "<td class=\"noborder\"><a href=\"http://localhost/shelter/detail.php?shid=".$property['property_ID']."\">view</a></td></tr>";
	$count++;
}
echo "</table>
<input type=\"radio\" value=\"0\" name=\"action\"/><label for=\"delete\">Delete</label>
<input type=\"radio\" value=\"1\" name=\"action\"/><label for=\"block\">Block</label>
<input type=\"submit\" value=\"Execute!\" name=\"execute\"/>
</form>";
}
else{
	echo "<p align=\"center\"><b>An error occured!!</b></p>";
			}
	
	
	
			
			mysql_close($db_connection);
		
}
		
?></body>
</html>