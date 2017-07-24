
<?php 
$connect = true;
require('../require/connexion.php');

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
	$Business_Name = mysql_real_escape_string(trim($_POST['Business_name']));
	$Office_Address = mysql_real_escape_string(trim($_POST['Office_Address']));
	$Office_Tel = $_POST['Office_No'];
	$Office_mail = mysql_real_escape_string(trim($_POST['Office_mail']));
	$CEO = mysql_real_escape_string(trim($_POST['personal_name']));
	$Phone_No =$_POST['personal_No'];
	$Phone_No2 =$_POST['personal_No2'];
	$email = mysql_real_escape_string(trim($_POST['personal_mail']));
	$UserId = mysql_real_escape_string(trim($_POST['userID']));
	$password = $_POST['pass2'];
	$id = time() + rand(1000,9999); 
	$timeCreated = time();
//if $phone_No2 is empty or invalid, set a default value 0
	if(empty($Phone_No2) || !is_numeric($Phone_No2)){
		$Phone_No2 = 0;
	}
//if user check the agreement box
	if(isset($_POST['agreement'])){
//if there is no any account or user with the same username, create account and make directory for the new user
		if(!file_exists("../$UserId") || mysql_num_rows(mysql_query("SELECT User_ID FROM profiles WHERE User_ID='$UserId'"))==0){
//if there is no other account with the business name
if(mysql_num_rows(mysql_query("SELECT Business_Name FROM profiles WHERE Business_Name='$Business_Name'"))==0){
$data = "INSERT INTO profiles(ID,Business_Name,Office_Address,Office_Tel_No,Business_email,CEO_Name,Phone_No,Alt_Phone_No,email, User_ID,password,timestamp)";
	$data .="VALUES('$id','$Business_Name','$Office_Address',$Office_Tel,'$Office_mail','$CEO',$Phone_No,$Phone_No2,'$email','$UserId','$password',$timeCreated)";
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
	//insert in activity log
	$activityID = uniqid(time());
	@mysql_query("INSERT INTO activities (activityID, action, subject, subject_ID, subject_Username, status, timestamp) VALUES('$activityID','AAO','$Business_Name','$id','$UserId','unseen',$timeCreated)");

			}
else{
	$registerationReport = "Sorry, You can not use the username <strong>'$UserId'</strong>. It has been used by another agent";
	$case = 2;
}			
	}
else{
	$registerationReport = "There was an error while registering your account, please bear with us and try again";
	$case = 2;
//echo('Technical issue: '.mysql_error().'<br/>Try Again');
				}
			}
else{
	$registerationReport = "Sorry, you cannot use the Business name <strong>'$Business_Name'</strong> because a user is using it already. <br/><br/>
	If you own the account but forgot the password, you can <a href=\"#\">Recover Password</a> <br/><br/>
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

<!DOCTYPE html>
<html>
<?php require('../require/meta-head.html'); ?>
<link href="../css/general.css" type="text/css" rel="stylesheet" />
<link href="../css/header_styles.css" type="text/css" rel="stylesheet" />
<link href="../css/style_for_signup.css" type="text/css" rel="stylesheet">

<head>
<title>Shelter | sign up</title>
<?php
//first log out current account to sign up for new one
setcookie('CTA',"",time()-60,"/","",0);
setcookie('name',"",time()-60,"/","",0);
$pagetitle = 'signup';
$ref='signup';
require('../require/plain-header.html');
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


	function nextSignupStep(currentStep,nextStep,progressStatus){
		if(currentStep == 'jumpTo'){
		//hide all section ...
document.querySelector('[class^=signup-tab]').className = 'signup-tab-hidden';
		}
		else{
document.querySelector('[class^=signup-tab]#'+currentStep).className = 'signup-tab-hidden';
		}
		//...show only @nextStep
document.querySelector('[class^=signup-tab]#'+nextStep).className = 'signup-tab-showing';

document.querySelector('#'+progressStatus+'>span[class$=step-no]').className = 'active-step-no';
document.querySelector('.active-step:not(#'+progressStatus+')>span[class$=step-no]').className = 'inactive-step-no';

document.querySelector('#'+progressStatus).className = 'active-step';
document.querySelector('.active-step:not(#'+progressStatus+')').className = 'inactive-step';

var Yoffset = window.pageYOffset;
var goUp = setInterval(steadyScrollUp,1);

function steadyScrollUp(){

if(Yoffset <= 5){
	clearInterval(goUp);
}
else{
window.scrollTo(0,Yoffset);
		Yoffset -= 20;
}
		
}
	}
			</script>		
<style type="text/css" rel="stylesheet">
	.signup-tab-showing{
		display:block;
	}
	.signup-tab-hidden{
		display:none;
	}
</style>

<!--if javascript is not active on the browser, just display all the steps-->		
	<noscript>
	<style>
	.continue-or-back-button{
		display:none;
	}
	.signup-tab-hidden{
		display:block;
		box-shadow:none;
	}
	fieldset{
		border:1px solid #E3E3E3;
	}
	</style>
	</noscript>	
			</head>			
<body class="no-pic-background">

<?php
	if(isset($case) and $case == 1){
	$icon = "background-position:-288px 0px";
	echo "<div id = \"registration-successful\">
	<h1>Sucessful!</h1>
	$registerationReport</div>";
	exit();
	}
	?>

<div id="all-wrapper">
<div id="LHS">
<p>A graphic will appear here</p>
</div>

<div id="mainsignup">

<h3 class="major-headings">Sign up</h3>
<div id="signup-progress-wrapper">
	<span  class="active-step" id="signup-progress-business-info" title="Provide information regarding your business">
		<span class="active-step-no" id="business-info-step-no">1</span>
		« Business Info »
		</span>
	
	<span  class="inactive-step" id="signup-progress-personal-info" title="Information about the business owner will be filled here">
	<span class="inactive-step-no" id="personal-info-step-no">2</span>
		« Personal Info »
		</span>

	<span  class="inactive-step" id="signup-progress-login-info" title="Create a username and password for login">
		<span class="inactive-step-no" id="login-info-step-no">3</span>
		« Login Info »
		</span>

</div>

	


	<p align="center">Already have an account? You can <a href="../login">login</a></p>
			<div id="yes-js-mainsignup" >
		
		<form name="signupform" action="<?php $_PHP_SELF ?>" method="POST" onsubmit="return(verify())">


<div class="signup-tab-showing" id="business-info-tab">
		<fieldset class="Business" >
		
					<?php 
//Here gives the repoort of the registration. successful or fail
if(isset($registerationReport)){
switch ($case){
//case 6: Form is not completed correctly
	case 6:
	$icon = "background-position:-312px 0px";
	echo "<div class=\"operation-fail-container\" id=\"registration-not-successful\" >
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
	echo "<div class=\"operation-fail-container\" id=\"registration-not-successful\">
	<h1>Failed!</h1>
	$registerationReport</div>";
	break;
}

}
	?>	
	
			<h3 class="legend">Business Information</h3>
			<p class="instruction">Let people know your business name, address and contacts. It makes it easier for clients and potential clients to locate or contact you.</p>
			<p class="instruction"><b>Fields asterisks (<span style="color: red">*</span>) are necessary</b></p>
			<label><span style="color: red">*</span>Business Registered Name: <input name="Business_name" placeholder="Enter business name here" size="60" maxlength="50" type="text" required="required" value="<?php if(isset($_POST['Business_name'])){echo $_POST['Business_name']; }?>"/></label>
			<label><span style="color: red">*</span>Office Address: <input name="Office_Address" placeholder="Enter office address here "  size="100" maxlength="150" type="text" required="required" value="<?php if(isset($_POST['Office_Address'])){echo $_POST['Office_Address']; }?>"></label>
			<label><span style="color: red">*</span>Office Tel No: <input placeholder="Enter office Tel here"  name="Office_No" size="30" maxlength="11" type="text" required="required" value="<?php if(isset($_POST['Office_No'])){echo $_POST['Office_No']; }?>"></label>
			<label>Business's e-mail: <input name="Office_mail" placeholder="Enter business e-mail here" size="30" maxlength="30" type="email" required="required" value="<?php if(isset($_POST['Office_mail'])){echo $_POST['Office_mail']; }?>"></label>
			
			<div class="continue-or-back-button-wrapper">
			<a class="continue-or-back-button continue" onclick="javascript: nextSignupStep('business-info-tab','personal-info-tab','signup-progress-personal-info')">Continue »</a>
			</div>

				</fieldset>
			
			</div>


	<div class="signup-tab-hidden" id="personal-info-tab">
			<fieldset class="personal">
	
			<h3 class="legend">Business Owner Information</h3>
			<p class="instruction">Provide us with the business owner's information. Be assured that this information will not be shared publicly. For more information, you can <a href="">read our privacy policy</a> or <a href="">contact us</a></p>
			<p class="instruction"><b>Fields asterisks (<span style="color: red">*</span>) are necessary</b> </p>
			<label><span style="color: red">*</span>CEO Name: <input name="personal_name" placeholder="Enter business owner's name here" size="60" maxlength="50" type="text" required="required" value="<?php if(isset($_POST['personal_name'])){echo $_POST['personal_name']; }?>"></label>
			<label><span style="color: red">*</span>Phone No: <input name="personal_No" placeholder="Enter business owner's phone no here" size="40" maxlength="11" type="text" required="required" value="<?php if(isset($_POST['personal_No'])){echo $_POST['personal_No']; }?>"></label>
			<label>Alternative Phone No: <input name="personal_No2" size="40" placeholder="Enter business owner's alternative phone no here" maxlength="11" type="text" value="<?php if(isset($_POST['personal_No2'])){echo $_POST['personal_No2']; }?>"/></label>
			<label><span style="color: red">*</span>e-mail: <input name="personal_mail" placeholder="Enter business owner's e-mail address here" size="30" maxlength="30" type="email" required="required" value="<?php if(isset($_POST['personal_mail'])){echo $_POST['personal_mail']; }?>"></label>

	<div class="continue-or-back-button-wrapper">				
	<a class="continue-or-back-button continue" onclick="javascript: nextSignupStep('personal-info-tab','login-info-tab','signup-progress-login-info')">Continue »</a>
	<a class="continue-or-back-button go-back" onclick="javascript: nextSignupStep('personal-info-tab','business-info-tab','signup-progress-business-info')">« Go Back</a>
		</div>					
			</fieldset>
			</div>
			
	<div class="signup-tab-hidden" id="login-info-tab">
			<fieldset class="personal">
	
			<h3 class="legend">Login Details</h3>
			<p class="instruction">Choose a username and created password. Make sure this password is secured. The combination of your username and password would be used for subsequent logins</p>
			<p class="instruction"><b>Fields asterisks (<span style="color: red">*</span>) are necessary</b></p>
			<label><span style="color: red">*</span>User ID: <input name="userID" placeholder="Choose a username" size="30" maxlength="20" type="text" required="required" value="<?php if(isset($_POST['userID'])){echo $_POST['userID']; }?>"/></label>
			<label><span style="color: red">*</span>Password: <input name="pass1" placeholder="Input password" size="30" maxlength="25" type="password" required="required"/></label>
			<label><span style="color: red">*</span>Repeat Password: <input name="pass2" placeholder="Repeat password" size="30" maxlength="25" type="password" required="required"/></label>
			
			<div class="continue-or-back-button-wrapper">
				<a class="continue-or-back-button go-back" onclick="javascript: nextSignupStep('login-info-tab','personal-info-tab','signup-progress-personal-info')">« Go Back</a>
			</div>

			<div > <input name="agreement" value="<?php if(isset($_POST['agreement'])) echo 'yes'; else echo 'no';?>"  type="checkbox" checked="checked">I agree with the <a href="#">terms and conditions</a> of shelter.com</div>
			<input name="register" value="sign up"  type="submit" id="signupbutton" align="right"/>
			</fieldset>
			</div>
			</form>
		</div>	
			
			
			</div>
</div>
			</body>
			<?php
			mysql_close($db_connection);
			?>
			</html>