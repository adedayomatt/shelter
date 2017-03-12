
<?php
$BizName = array();
 $OAddress = array();
 $OTel = array();
 $Omail = array();
	$CEO = array();
$Phone = array();
$Phone2 = array();
$email = array();
$user_id = array();
$password = array();

require('../require/db_connect.php');
if($db_connection){
mysql_select_db('shelter');
$fetch = "SELECT * FROM profiles";
$g = mysql_query($fetch,$db_connection);
$in = 0;
if($g){
	while($user = mysql_fetch_array($g,MYSQL_ASSOC)){
		$ID = $user['ID'];
		$BizName[$in] = $user['Business_Name'];
		$OAddress[$in] = $user['Office_Address'];
		$OTel[$in] = $user['Office_Tel_No'];
		$Omail [$in]= $user['Business_email'];
		$CEO[$in] = $user['CEO_Name'];
		$Phone[$in] = $user['Phone_No'];
		$Phone2[$in] = $user['Alt_Phone_No'];
		$email[$in] = $user['email'];
		$user_id[$in] = $user['User_ID'];
		$password[$in] = $user['password'];
		$in++;
	}
}
	else{
echo "<h3 align=\"center\">There was an error while fetching profiles</h3>";
echo "<p align=\"center\"><a href=\"#\">Report</a> the problem</p>";
}
//if this is required from login page to check for account existence, don't close the connection yet
if($ref !='loginpage' || !isset($ref)){
	mysql_close($db_connection);
}
}
?>