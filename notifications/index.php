<?php 
require('../resources/php/master_script.php'); 
 //confirm if user is still logged in 
if($status==0){
	$general->redirect('login');
}
?>

<!DOCTYPE html>
<html>
<head>
<?php
$pagetitle = "Notifications";
$ref='notificatons_page';
require('../resources/global/meta-head.php');?>
<link href="../css/header_styles.css" type="text/css" rel="stylesheet" />
</head>
<body class="no-pic-background">
<?php require('../resources/global/header.php'); ?>
<div class="container-fluid body-content">
<div class="main-content00">

<?php require("../resources/php/ajax_scripts/loadNotifications.php") ?>

</div>
<?php require('../resources/global/footer.php') ?>

</div>

</body>
<style>
.notice{
	margin-bottom:5px;
}
@media all and (min-width:778px){
.main-content00{
	margin:0px 20px;
}
}
</style>

</html>




