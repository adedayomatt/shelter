<?php session_start(); 
if(!isset($_SESSION['directory']) && !isset($_SESSION['id'])){
	header('location: index.php');
	exit();
}
?>
<html>
<link href="../css/header_styles.css" type="text/css" rel="stylesheet" />
<link href="../css/general.css" type="text/css" rel="stylesheet" />
<?php
$pagetitle="complete";
session_destroy();
$connect = true;
$getuserName = true;
require('../require/header.php');
if($status != 1){
	redirect();
	exit();
}

?>
<body class="pic-background">
<?php echo "<br/><br/><p align=\"center\"> Upload complete <a href=\"$root\">continue</a></p>";?>
</body>
</html>