<link href="../css/header_styles.css" type="text/css" rel="stylesheet" />
<link href="../css/style_for_signup.css" type="text/css" rel="stylesheet">

<?php
$pagetitle="Registered";
	require('../require/db_connect.php');
if(isset($_POST['sign']))
{
	
	$Company_Name = $_POST['Company_name'];
	$Office_Address = $_POST['Office_Address'];
	$Office_Tel = $_POST['Office_No'];
	$Office_mail = $_POST['Office_mail'];
	$CEO =$_POST['personal_name'];
	$Phone_No =$_POST['personal_No'];
	$Phone_No2 =$_POST['personal_No2'];
	$email =$_POST['personal_mail'];
	$UserId = $_POST['userID'];
	$password = $_POST['pass2'];
	$id = time();
	//date("ymdHis", 
	if(empty($Phone_No2)){
		
		$Phone_No2 = 0;
	}
	if(isset($_POST['agreement'])){
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
			require('../require/header.php');
		echo "<h3>Your Account as been registered successfully as <b>$UserId</b><br/> Click <a href=\"../login\">here</a> to continue</h3>" ;
		}
		
		
	}
else{
	
require('../require/header.php');
echo('Could not enter Information: <br/>ERRORS: <br/>');
echo('Technical issue: '.mysql_error().'<br/>Try Again');
}
	}
	else
		{
			require('../require/header.php');
		echo 'You need to agree to the <a href="terms.html">terms and conditions</a>';
	}
	}
	
	mysql_close($db_connection);
	

			
?>