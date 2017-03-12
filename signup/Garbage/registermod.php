<?php
//This script add the new user to the database
if(isset($_POST['register'])){
require('../require/db_connect.php');
if($db_connection){
	$Company_Name = mysql_real_escape_string($_POST['Company_name']);
	$Office_Address = mysql_real_escape_string($_POST['Office_Address']);
	$Office_Tel = $_POST['Office_No'];
	$Office_mail = mysql_real_escape_string($_POST['Office_mail']);
	$CEO = mysql_real_escape_string($_POST['personal_name']);
	$Phone_No =$_POST['personal_No'];
	$Phone_No2 =$_POST['personal_No2'];
	$email = mysql_real_escape_string($_POST['personal_mail']);
	$UserId = mysql_real_escape_string($_POST['userID']);
	$password = $_POST['pass2'];
	$id = time();
	if(empty($Phone_No2)){
		$Phone_No2 = 0;
	}
	if(isset($_POST['agreement'])){
		if(exit("../$UserId")){
			$registerationReport = "There is already an account with the username '$UserId' please choose another" ;
			$case = 0;
		}
	else{
$data = "INSERT INTO profiles(ID,Business_Name,Office_Address,Office_Tel_No,Business_email,CEO_Name,Phone_No,Alt_Phone_No,email, User_ID,password)";
	$data .="VALUES('$id','$Company_Name','$Office_Address',$Office_Tel,'$Office_mail','$CEO',$Phone_No,$Phone_No2,'$email','$UserId','$password')";
		mysql_select_db('shelter');
	$reg = mysql_query($data,$db_connection);
	if($reg ) {
		//create a directory for new user 
		if(mkdir("../$UserId")){
			//this is a prepared statement for a new php file that will be the index of the new directory
			$prepared ="<?php ";
			$prepared .="\$BN = \"".$Company_Name."\";";
			$prepared .="\$Aid =\"".$UserId."\";";
			$prepared .="\$key = \"".$id."\";";
			$prepared .="require('../profile/profile.php');";
			$prepared .= "?>";
			//create the index.php file
			$open = fopen("../".$UserId."/index.php",'w');
			$write = fwrite($open,$prepared);
			fclose($open);
			$registerationReport = "Your Account as been registered successfully as <b>$UserId</b><br/> Click <a href=\"../login\">here</a> to continue</h3>" ;
			$case = 1;
		}
			}
else{
	$registerationReport = "There was an error while registering your acount, please bear with us and try again";
	$case = 2;
//echo('Technical issue: '.mysql_error().'<br/>Try Again');
	}
		}
			}
	else
		{
$registerationReport = "Account not registered, You need to agree to the <a href=\"terms.html\">terms and conditions</a>";
 $case = 3;
}
	}
	
			}
	mysql_close($db_connection);
}
else{
	$registerationReport = "There was an error while connecting to the server";
	$case = 4;
}
}
	?>
	