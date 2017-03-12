<link href="../css/general.css" type="text/css" rel="stylesheet" />
<link href="../css/header_styles.css" type="text/css" rel="stylesheet" />
<?php
$pagetitle ='logout';
$ref='logoutpage';
$getuserName=true;
$connect = true;
require('../require/header.php');
if($status==0){
	$confirmation = "You were not logged in!<br/>You can <a href=\"$root/login\">login now</a> or <a href=\"$root/shelter/signup\">signup today</a>";
}
else{
setcookie('name',"",time()-60,"/","",0);
setcookie('CTA',"",time()-60,"/","",0);
$confirmation = "<p><br/>Your account has been logged out successfull!<br/>click <a style=\"text-decoration: none\" href=\"$root/login\"><b>here</b></a> to login </p>";
}
?>
<html>
<header>
<?php 
?>
</header>
<body class="pic-background"> <p align="center"><?php echo $confirmation; ?></p>	</body>

<style>
</style>
</html>