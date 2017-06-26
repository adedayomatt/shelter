<?php 
session_start();
$connect = true;
require('../require/connexion.php');  

if(!isset($_SESSION['directory']) && !isset($_SESSION['id'])){
	mysql_close($db_connection);
	header('location: ../upload');
	exit();
}
else{
	$p = $_SESSION['directory'];
	mysql_close($db_connection);
	session_destroy();
	@header("location: $root/properties/$p");
}
?>
<html>
<link href="../css/header_styles.css" type="text/css" rel="stylesheet" />
<link href="../css/general.css" type="text/css" rel="stylesheet" />
<head>
<?php
$pagetitle="complete";
$connect = true;
$getuserName = true;
require('../require/header.php');
if($status != 1){
	redirect();
	exit();
}

?>
</head>
<body class="pic-background">
<?php echo "<div style=\"text-align:center\"> Your upload is completed, if you are not redirected click <a href=\"$root/properties/$p\">here</a></div>";?>
</body>
</html>