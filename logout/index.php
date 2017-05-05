
<html>
<link href="../css/general.css" type="text/css" rel="stylesheet" />
<link href="../css/header_styles.css" type="text/css" rel="stylesheet" />
<header>
<style>
#all-header-container{
	display:none;
}
h1{
	font-size:250%;
	color:white;
}
#logout-prompt{
	padding:5%;
	background-color:white;
	width:80%;
	margin:auto;
	color:grey;
	box-shadow:3px 3px 3px 3px #DDD;
	border-radius:5px;
}
</style>
<?php
$pagetitle ='logout';
$ref='logoutpage';
$getuserName=true;
$connect = true;
require('../require/header.php');
if($status==0){
	$confirmation = "<h2>You were not logged in!</h2><p>You can <a href=\"$root/login\">login now</a> or <a href=\"$root/signup\">signup today</a></p>";
}
else{
setcookie('name',"",time()-60,"/","",0);
setcookie('CTA',"",time()-60,"/","",0);
$confirmation = "<h2>Logged out</h2><p>Your account has been logged out successfully, click <a href=\"$root/login\"><b>here</b></a> to login </p>";
}
?>
</header>
<body class="mixedcolor-background"> 
<h1 align="center">Shelter</h1>
<div id="logout-prompt" align="center"><?php echo $confirmation; ?></div>	</body>

</html>