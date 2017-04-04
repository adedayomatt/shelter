<!DOCTYPE html>
<html>
<link href="../css/general.css" type="text/css" rel="stylesheet" />
<link href="../css/header_styles.css" type="text/css" rel="stylesheet" />
<link href="../css/style_for_signup.css" type="text/css" rel="stylesheet">

<header>
<title>Shelter | sign up</title>
<?php
//first log out current account to sign up for new one
setcookie('CTA',"",time()-60,"/","",0);
setcookie('name',"",time()-60,"/","",0);
$pagetitle = 'signup';
$ref='signup';
$connect = true;
require('../require/connexion.php');
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
		
			</header>			
<body class="special-background">
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
		if(!file_exists("../$UserId") || mysql_num_rows(mysql_query("SELECT User_ID FROM profiles WHERE User_ID='$UserId'"))==1){
//if there is no other account with the business name
if(mysql_num_rows(mysql_query("SELECT Business_Name FROM profiles WHERE Business_Name='$Business_Name'"))==0){
$data = "INSERT INTO profiles(ID,Business_Name,Office_Address,Office_Tel_No,Business_email,CEO_Name,Phone_No,Alt_Phone_No,email, User_ID,password)";
	$data .="VALUES('$id','$Business_Name','$Office_Address',$Office_Tel,'$Office_mail','$CEO',$Phone_No,$Phone_No2,'$email','$UserId','$password')";
	$reg = mysql_query($data);
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
else{
	$registerationReport = "Sorry, you cannot use the Business name <strong>'$Business_Name'</strong> because a user is using it already<br/>
	If you own the account but forgot the password, you can <a href=\"#\">Recover Password</a> <br/>
	If this is an error, <a href=\"#\">Report Now</a>";
	$case = 3;
}
	}
//if there is already a user/account with the username submitted
	else{
		$registerationReport = "There is already an account with the username <strong>'$UserId'</strong> please choose another<br/>
		If you own the account but forgot the password, you can <a href=\"#\">Recover Password</a> <br/>";
	
		$case = 4;
	}
		}
//if user did not check the agreement box
	else
		{
	$registerationReport = "Account not registered, You need to agree to the <a href=\"terms.html\">terms and conditions</a>";
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
<a id="shelter" href="../"><h1>Shelter</h1></a>
	<?php 
//Here gives the repoort of the registration. successful or fail
if(isset($registerationReport)){
switch ($case){
//case 1: Registration is successful
	case 1:
	$icon = "background-position:-288px 0px";
	echo "<div id = \"registration-successful\">
	<h1>Sucessful!</h1>
	$registerationReport</div>";
	exit();
	break;
//case 6: Form is not completed correctly
	case 6:
	$icon = "background-position:-312px 0px";
	echo "<div id=\"registration-not-successful\" >
	<h1>Failed!</h1>
	$registerationReport<br/>";
//List the invalid data
echo "<ul>";
foreach($error as $e){
	echo "<li >". $e."</li>";
	}
echo "</ul>check your input and try again</div>";
	break;
	default:
	$icon = "background-position:-312px 0px";
	echo "<div id=\"registration-not-successful\">
	<h1>Failed!</h1>
	$registerationReport</div>";
	break;
}

}
	?>
			<form name="signupform" action="<?php $_PHP_SELF ?>" method="POST" onsubmit="return(verify())">
			<fieldset class="Business">
			<h3 class="legend">Business Information</h3>
			<p class="instruction"><b>Fields asterisks (<span style="color: red">*</span>) are necessary</b></p>
			<label><span style="color: red">*</span>Business Registered Name: <input name="Business_name" size="60" maxlength="50" type="text" required="required" value="<?php if(isset($_POST['Business_name'])){echo $_POST['Business_name']; }?>"/></label>
			<label><span style="color: red">*</span>Office Address: <input name="Office_Address" size="100" maxlength="150" type="text" required="required" value="<?php if(isset($_POST['Office_Address'])){echo $_POST['Office_Address']; }?>"></label>
			<label><span style="color: red">*</span>Office Tel No: <input name="Office_No" size="30" maxlength="11" type="text" required="required" value="<?php if(isset($_POST['Office_No'])){echo $_POST['Office_No']; }?>"></label>
			<label>Business's e-mail: <input name="Office_mail" size="30" maxlength="30" type="email" required="required" value="<?php if(isset($_POST['Office_mail'])){echo $_POST['Office_mail']; }?>"></label>
			</fieldset>
			<fieldset class="personal">
			<h3 class="legend">Personal Information</h3>
			<p class="instruction"><b>Fields asterisks (<span style="color: red">*</span>) are necessary</b> </p>
			<label><span style="color: red">*</span>CEO Name: <input name="personal_name" size="60" maxlength="50" type="text" required="required" value="<?php if(isset($_POST['personal_name'])){echo $_POST['personal_name']; }?>"></label>
			<label><span style="color: red">*</span>Phone No: <input name="personal_No" size="40" maxlength="11" type="text" required="required" value="<?php if(isset($_POST['personal_No'])){echo $_POST['personal_No']; }?>"></label>
			<label>Alternative Phone No: <input name="personal_No2" size="40" maxlength="11" type="text" value="<?php if(isset($_POST['personal_No2'])){echo $_POST['personal_No2']; }?>"/></label>
			<label><span style="color: red">*</span>e-mail: <input name="personal_mail" size="30" maxlength="30" type="email" required="required" value="<?php if(isset($_POST['personal_mail'])){echo $_POST['personal_mail']; }?>"></label>
			</fieldset>
			<fieldset class="personal">
			<h3 class="legend">Login Details</h3>
			<p class="instruction"><b>Fields asterisks (<span style="color: red">*</span>) are necessary</b></p>
			<p class="instruction"><b>please choose a user ID, this will be for used to login subsequently</b></p>
			<label><span style="color: red">*</span>User ID: <input name="userID" size="30" maxlength="20" type="text" required="required" value="<?php if(isset($_POST['userID'])){echo $_POST['userID']; }?>"/></label>
			<p class="instruction"><b>create password, make sure this password is secured</b></p>
			<label><span style="color: red">*</span>Password: <input name="pass1" size="30" maxlength="25" type="password" required="required"/></label>
			<label><span style="color: red">*</span>Repeat Password: <input name="pass2" size="30" maxlength="25" type="password" required="required"/></label>
			
			<span id="agreement"> <input id="agreement-box" name="agreement" value="<?php if(isset($_POST['agreement'])) echo 'yes'; else echo 'no';?>"  type="checkbox" checked="checked"> <b>I agree with the <a href="#">terms and conditions</a> of shelter.com</b></span>
			<input name="register" value="sign up"  type="submit" id="signupbutton" align="right"/>
			</fieldset>
			
						</form>
			
			</div>
			</body>
			<?php
			mysql_close($db_connection);
			?>
			</html>