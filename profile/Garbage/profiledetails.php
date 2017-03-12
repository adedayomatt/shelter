<html>
<link href="../css/general.css" type="text/css" rel="stylesheet" />
<link href="../css/profile_styles.css" type="text/css" rel="stylesheet" />
<link href="../css/header_styles.css" type="text/css" rel="stylesheet" />
<link href="../css/propertybox_styles.css" type="text/css" rel="stylesheet" />
<head>
<?php 
		$pagetitle = $Agent_Id;
		require('../require/header.php');
?>
</head>
<body class="pic-background">
<div class="left">
<div class="maincontent">
<div id="biz-logo">
<img src="logo" alt="Business Logo" style="border:2px solid white; border-radius:30px;" height="100px" width="100px"/></div>
<div id="about-biz"><h4 align="center"><?php echo $BizName?></h4>
<p><?php echo $OAddress?></p>
<p><?php echo $OTel?></p>
<p> <?php echo $email?></p>
<?php
if($status==1){
echo "<p align=\"right\"><a href=\"http://localhost/shelter/manage/account.php\"><i class=\"black-icon\" id=\"edit-icon\"></i>Edit profile</a></p>";
}
?>
</div>
</div><hr style="width:100%; "/>
<div class="recent-uploads">
<h4>Recent uploads by <?php echo $BizName?></h4></div>
<?php
require("getmyproperties.php");
$ref="profile_page";
require("../require/propertyboxes.php");
?>
</div>
<div class="right">
<h4 align="center">options</h4>
<?php
switch($status){
	case 0:
	echo "Advert could be placed here";
	break;
	case 1:
	echo "<a href=\"editprofile.php\"><button class=\"editbutton\">Edit profile</button></a>";
	break;
}
?>
</div>

</body>
<?php //require("../require/footer.html"); ?>
</html>