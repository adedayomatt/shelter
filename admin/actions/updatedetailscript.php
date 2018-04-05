<?php
require('../../resources/master_script.php');
$exist = 0;
$lost = 0;
//get all the ones in the database
$lost_dir = array();
$properties =$db->query_object("SELECT property_ID,directory,type FROM properties");
echo "<p> $properties->num_rows total record found in the database</p>";

while($p = $properties->fetch_array(MYSQLI_ASSOC)){
$index = "../../properties/".$p['directory']."/index.php";
if(file_exists($index)){
$newscript ="
<?php 
require('../../resources/master_script.php'); ?>
<html>
<head>
<?php \$pagetitle=\"".$p['property_ID']." - ".$p['type']." for rent\"; 
require('../../resources/global/meta-head.php') ?>
<link href=\"../../css/header_styles.css\" type=\"text/css\" rel=\"stylesheet\" />
<link href=\"../../css/details_styles.css\" type=\"text/css\" rel=\"stylesheet\" />
</head>
<body class=\"no-pic-background\">
<?php
\$ID =\"".$p['property_ID']."\";
require('../detail.php');
?>
</body>
</html>";
$file = fopen($index,"w");
fwrite($file,$newscript);
fclose($file);
$exist++;
    }
else{
$lost_dir[] = $p['directory'];
$lost++;
    }
}
echo "<p> $exist total index files found and updated</p>";
echo "<p style=\"color:red\">$lost total index files were not found</p>";

?>