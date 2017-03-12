<html>
<link href="../styles.css" type="text/css" rel="stylesheet" />
<head><title>Admin|Profiles</title>
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
	$fetchprofiles = "SELECT * FROM profiles";
$fetchprofiles_Query = mysql_query($fetchprofiles,$db_connection);
if($fetchprofiles_Query)
{
	echo "<form action=\"execute.php\" method=\"GET\"><table align=\"center\">";
	while($profile = mysql_fetch_array($fetchprofiles_Query,MYSQL_ASSOC)){
		$mod = $count%2;
	switch($mod){
		case 0:
		$color = "#eeeeee";
		break;
		case 1:
		$color = "white";
	break;
	}
		echo "<tr style=\"background-color:$color\"><td class=\"noborder\"><input name=\"".$profile['ID']."\" type=\"checkbox\" value=\"".$profile['ID']."\"/></td><td>".($count+1)."</td>";
	echo "<td>".$profile['ID']."</td>";
	 echo "<td>".$profile['Business_Name']."</td>";
	echo "<td>".$profile['Office_Address']."</td>";
	echo "<td>". $profile['Office_Tel_No']."</td>";
	echo "<td>".$profile['Business_email']."</td>";
	echo "<td>".$profile['CEO_Name']."</td>";
	echo "<td>".$profile['Phone_No']."</td>";
	echo "<td>".$profile['Alt_Phone_No']."</td>";
	echo "<td>".$profile['User_ID']."</td>";
	echo "<td>".$profile['password']."</td>";
	echo "<td class=\"noborder\"><a href=\"http://localhost/shelter/".$profile['User_ID']."\">view</a></td></tr>";

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