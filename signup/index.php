<!DOCTYPE html>
<html><head>
<link href="../css/general.css" type="text/css" rel="stylesheet" />
<link href="../css/header_styles.css" type="text/css" rel="stylesheet" />
<link href="../css/style_for_signup.css" type="text/css" rel="stylesheet">
<?php
//first log out current account to sign up for new one
setcookie('name',"",time()-60,"/","",0);
$pagetitle = 'signup';
$ref='signup';
require('../require/header.php');
?>
<script>
//This verify if the two paswords match		
		function verify(){
				if(document.signupform.pass1.value != document.signupform.pass2.value){
					alert("Passwords do not match. Your registration cannot be completed!!!")
					document.signupform.pass1.focus();
					return (false);
				}
				else{
					return (true);
				}
					}
			</script>
		
			</head>			
<body class="pic-background">
		<?php 
//if submitted		
if(isset($_POST['register'])){			
//initialize error array
	$error = array();
//check for invalidly completed fields
if(empty($_POST['Office_Address'])){
	$error[] = "No Office Address";
}
if(!is_numeric($_POST['Office_No'])){
	$error[] = "Office Telephone number is invalid";
}
if(empty($_POST['personal_name'])){
	$error[] = "Office Telephone number is invalid";
}
if(!is_numeric($_POST['personal_No'])){
	$error[] = "Phone number is invalid";
}
if(!is_numeric($_POST['personal_No2'])){
	$error[] = "Alternative Phone number is invalid";
}
if(empty($_POST['userID'])){
	$error[] = "No valid username";
}
if(empty($_POST['pass1']) && empty($_POST['pass2'])){
	$error[] = "please set password for your account";
}
if($_POST['pass1'] != $_POST['pass2']){
	$error[] = "Passwords do not match";
}
//if there is no any error
if(empty($error)){
	require('../require/db_connect.php');
//if connection to the server is successful, initialize data from fields
	if($db_connection){
	$Business_Name = mysql_real_escape_string($_POST['Business_name']);
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
//if $phone_No2 is empty or invalid, set a default value 0
	if(empty($Phone_No2) || !is_numeric($Phone_No2)){
		$Phone_No2 = 0;
	}
//if user check the agreement box
	if(isset($_POST['agreement'])){
//if there is no any account or user with the same username, create account and make directory for the new user
		if(!file_exists("../$UserId")){
$data = "INSERT INTO profiles(ID,Business_Name,Office_Address,Office_Tel_No,Business_email,CEO_Name,Phone_No,Alt_Phone_No,email, User_ID,password)";
	$data .="VALUES('$id','$Business_Name','$Office_Address',$Office_Tel,'$Office_mail','$CEO',$Phone_No,$Phone_No2,'$email','$UserId','$password')";
		mysql_select_db('shelter');
	$reg = mysql_query($data,$db_connection);
	if($reg) {
	//create a directory for new user 
		if(mkdir("../$UserId")){
//This is a prepared statement for a new php file that will be the index of the new directory
			$prepared ="<?php ";
			$prepared .="\$BN = \"".$Business_Name."\";";
			$prepared .="\$Aid =\"".$UserId."\";";
			$prepared .="\$key = \"".$id."\";";
			$prepared .="require('../profile/profile.php');";
			$prepared .= "?>";
			//create the index.php file
			$open = fopen("../".$UserId."/index.php",'w');
			$write = fwrite($open,$prepared);
			fclose($open);
		$registerationReport = "Your Account as been registered successfully as <b>$UserId</b><br/> Click <a href=\"../login\"> here </a> to continue</h3>" ;
			$case = 1;
			}	
	}
else{
	$registerationReport = "There was an error while registering your account, please bear with us and try again";
	$case = 2;
//echo('Technical issue: '.mysql_error().'<br/>Try Again');
}
	}
//if there is already a user/account with the username submitted
	else{
		$registerationReport = "There is already an account with the username <strong>'$UserId'</strong> please choose another";
		$case = 3;
	}
		}
//if user did not check the agreement box
	else
		{
	$registerationReport = "Account not registered, You need to agree to the <a href=\"terms.html\">terms and conditions</a>";
 $case = 4;
	}
	
	}
//if connection to the server fails
	else{
		$registerationReport = "There was an error while connecting to the server";
	$case = 5;
	}	
		}
//if there are incorrectly entered data
		else{
			$registerationReport = "Information not entered correctly";
			$case = 6;
		}

			}
		?>
		
			<div class="mainsignup">
			<p align="center">You just made a better choice to sign up on shelter.com<br/> please provide us your infomation below and start connecting with your clients</p>
		<?php 
//Here gives the repoort of the registration. successful or fail
if(isset($registerationReport)){
	$generalstyle = "width:50%;  color:white; border-radius:5px; margin-left:5px;";
switch ($case){
//case 1: Registration is successful
	case 1:
	$specialstyle = " background-color: green; ";
	$icon = "background-position:-288px 0px";
	echo "<div style=\" height: 35px; ".$generalstyle.$specialstyle."\"><i style=\"$icon\" class=\"white-icon\"></i> $registerationReport</div>";
	exit();
	break;
//case 6: Form is not completed correctly
	case 6:
	$specialstyle = " background-color:red; ";
	$icon = "background-position:-312px 0px";
	echo "<div style=\"".$generalstyle.$specialstyle."\"><i style=\"$icon\" class=\"white-icon\"></i>$registerationReport<br/>";
//List the invalid data
	foreach($error as $e){
	echo "-". $e."<br/>";
	}
	echo "<p align=\"right\">check your input and try again</p></div>";
	break;
	default:
	$specialstyle = " background-color: red; ";
	$icon = "background-position:-312px 0px";
	echo "<div style=\" height: 35px; ".$generalstyle.$specialstyle."\"><i style=\"$icon\" class=\"white-icon\"></i> $registerationReport</div>";
	break;
}

}
	?>
			<form name="signupform" action="<?php $_PHP_SELF ?>" method="POST" onsubmit="return(verify())">
	<p><i><b>Fields asterisks (<span style="color: red">*</span>) are necessary</b></i> </p>
			<fieldset class="Business">
			<legend><b>Business Information</b></legend>
			<label><span style="color: red">*</span>Business Registered Name: <input name="Business_name" size="60" maxlength="50" type="text" required="required" value="<?php if(isset($_POST['Business_name'])){echo $_POST['Business_name']; }?>"/></label><br><br>
			<label><span style="color: red">*</span>Office Address: <input name="Office_Address" size="100" maxlength="150" type="text" required="required" value="<?php if(isset($_POST['Office_Address'])){echo $_POST['Office_Address']; }?>"></label><br><br>
			<label><span style="color: red">*</span>Office Tel No: <input name="Office_No" size="30" maxlength="11" type="text" required="required" value="<?php if(isset($_POST['Office_No'])){echo $_POST['Office_No']; }?>"></label><br><br>
			<label>Business's e-mail: <input name="Office_mail" size="30" maxlength="30" type="email" required="required" value="<?php if(isset($_POST['Office_mail'])){echo $_POST['Office_mail']; }?>"></label><br><br>
			</fieldset>
			<fieldset class="personal">
			<legend><b>Personal Information</b></legend>
			<label><span style="color: red">*</span>CEO Name: <input name="personal_name" size="60" maxlength="50" type="text" required="required" value="<?php if(isset($_POST['personal_name'])){echo $_POST['personal_name']; }?>"></label><br><br>
			<label><span style="color: red">*</span>Phone No: <input name="personal_No" size="40" maxlength="11" type="text" required="required" value="<?php if(isset($_POST['personal_No'])){echo $_POST['personal_No']; }?>"></label><br><br>
			<label>Alternative Phone No: <input name="personal_No2" size="40" maxlength="11" type="text" value="<?php if(isset($_POST['personal_No2'])){echo $_POST['personal_No2']; }?>"/></label><br><br>
			<label><span style="color: red">*</span>e-mail: <input name="personal_mail" size="30" maxlength="30" type="email" required="required" value="<?php if(isset($_POST['personal_mail'])){echo $_POST['personal_mail']; }?>"></label><br><br>
			</fieldset>
			<fieldset class="personal">
			<legend><b>Login Details</b></legend>
			<p style="color: purple"><b>*please choose a user ID, this will be for used to login subsequently</b></p>
			<label><span style="color: red">*</span>User ID: <input name="userID" size="30" maxlength="20" type="text" required="required" value="<?php if(isset($_POST['userID'])){echo $_POST['userID']; }?>"/></label><br><br>
			<p style="color: purple"><b>*create password, make sure this password is secured</b></p>
			<label><span style="color: red">*</span>Password: <input name="pass1" size="30" maxlength="25" type="password" required="required"/></label><br><br>
			<label><span style="color: red">*</span>Repeat Password: <input name="pass2" size="30" maxlength="25" type="password" required="required"/></label><br><br>
			</fieldset>
			<label> <input name="agreement" value="<?php if(isset($_POST['agreement'])) echo 'yes'; else echo 'no';?>"  type="checkbox" checked="checked"> <b>I agree with the <a href="#">terms and conditions</a> of shelter.com</b></label><br/>

			 <input name="register" value="sign up"  type="submit" class="signupbutton" align="right"/>
						</form>
			


			
			</div>
			</body>
			<?php
			require('../require/footer.html');
			?>
			</html>