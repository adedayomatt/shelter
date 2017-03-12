<!DOCTYPE html>
<html><head>

<link href="css/styles.css" type="text/css" rel="stylesheet">
<link href="css/style_for_signup.css" type="text/css" rel="stylesheet">

<title>Shelter</title>

<div class="header">
<img id="logo" src="" alt="shelter logo" onclick="contact()" height="70px" width="300px">
<h3 class="construction" align="center">THIS PAGE IS UNDER CONSTRUCTION</h3>
</div>

<div class="search">
<input name="search" size="60" placeholder="Enter keyword" type="search"><input value="search" type="submit">
<h5 class="user">Are you an agent? <br><a id="signupbutt" href="signup.html"><b>sign up</b></a>   or   <a id="loginbutt" href="login.html"><b>login</b></a></h5>
</div>


<div class="groupie">
<ul>
		<li class="home"><a class="homelink" href="index.html" title="Home">Home</a></li> 
		<li class="agents"><a class="agentslink" href="registeredagents.php" title="Agents">Registered Agents</a></li>
		<li class="contact"><a class="contactlink" href="contact.html" title="Contact">Contact</a></li>
		<li class="about"><a class="aboutlink" href="about.html" title="About">About</a></li>
		</ul></div>
		<br>
		<div class="here"><p>You are here <button class="thisplace">&gt;&gt;sign up</button></p></div>
			</head>
			<body>
			<div class="mainsignup">
			<p align="center">You just made a better choice to sign up on shelter.com<br/> please provide us your infomation below and start connecting with your clients</p>
				<form action="register.php" method="post">
			<fieldset class="company">
			<legend><b>Company Information</b></legend>
			<label>Company's Registered Name: <input name="Company_name" id="Company_name" size="60" maxlength="50" type="text"></label><br><br>
			<label>Office Address: <input name="Office_Address" id="Office_Address" size="100" maxlength="150" type="text"></label><br><br>
			<label>Office Tel No: <input name="Office_No" id="Office_No" size="30" maxlength="11" type="text"></label><br><br>
			<label>Company's e-mail: <input name="Office_mail" id="Office_mail" size="30" maxlength="30" type="text"></label><br><br>
			</fieldset>
			<fieldset class="personal">
			<legend><b>Personal Information</b></legend>
			<label>CEO Name: <input name="personal_name" id="personal_name" size="60" maxlength="50" type="text"></label><br><br>
			<label>Phone No: <input name="personal_No" id="personal_No" size="40" maxlength="11" type="text"></label><br><br>
			<label>Alternative Phone No: <input name="personal_No2" id="personal_No2" size="40" maxlength="11" type="text"></label><br><br>
			<label>e-mail: <input name="personal_mail" id="personal_mail" size="30" maxlength="30" type="text"></label><br><br>
			</fieldset>
			 <input value="sign up"  type="submit" id="add">
			</form>
			
			

			<script>
		function successfull()
{
	alert("Connection to Database successfull<br/>Thank You.")
	
}
</script>
			</div>
			</body>
			</html>