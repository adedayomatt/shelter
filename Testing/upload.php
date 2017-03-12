<?php
$uploadNo = 0;
if($_SERVER['REQUEST_METHOD']=='POST'){
if(isset($_FILES['file'])){
	$allowed = array ('image/pjpeg','image/jpeg', 'image/JPG','image/X-PNG', 'image/PNG','image/png', 'image/x-png');
$mb = ($_FILES['file']['size'])/1000000;
if(in_array(($_FILES['file']['type']),$allowed)){
	if (move_uploaded_file ($_FILES['file']['tmp_name'],"../uploads/pi.png")) {
	echo '<p><em>The file has been uploaded!</em></p>';
}
else{
	echo 'upload unsuccesful try again: '.$_FILES['file']['error'];
}	
}
else{
	echo 'Unsupported file format';
}
}	
else{
	echo 'No file is selected';
}
}
else{
	echo "Request Method should be POST";
}
?>
<html>
<head>
<title>Uploading Complete</title>
</head>
<body>
<h2>Uploaded File Info:</h2>
<ul>
<li>Sent file: <?php echo $_FILES['file']['name']; ?>
<li>File size: <?php echo $mb; ?> Mb
<li>File type: <?php echo $_FILES['file']['type']; ?>
</ul>
</body>
</html>