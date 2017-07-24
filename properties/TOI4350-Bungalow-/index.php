<?php $connect = true;
			require('../../require/connexion.php'); ?>
			<html>
			<?php require('../../require/meta-head.html'); ?>
<head>
<link href="../../css/general.css" type="text/css" rel="stylesheet" />
<link href="../../css/header_styles.css" type="text/css" rel="stylesheet" />
<link href="../../css/details_styles.css" type="text/css" rel="stylesheet" />
<?php $pagetitle="TOI4350 - Bungalow for rent"; 
require('../../require/header.php') ?>
<script type="text/javascript" language="javascript" src="../../js/detailsscript.js"></script>
</head>
<body class="pic-background">
<?php
$ID = "TOI4350";
require('../detail.php');
?>
</body>
</html>