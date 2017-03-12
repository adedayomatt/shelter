
<?php
session_start();
/*
This script handles upload of images
*/

/*check if user is logged in else redirect user to the login page*/
if(isset($_COOKIE['name'])){
//$picname is a hidden input from addimage.php that passes the record id.
	uploadphoto($_POST['picname']);
}
else{
	header('location: http://localhost/shelter/login');
}

function uploadphoto($name){
	if(isset($_SESSION['directory']))
	{
if(isset($_FILES['photo'])){
	$allowed = array ('image/pjpeg','image/jpeg', 'image/JPG','image/X-PNG', 'image/PNG','image/png', 'image/x-png');
$mb = ($_FILES['photo']['size'])/1000000;
if(in_array(($_FILES['photo']['type']),$allowed)){
	if (move_uploaded_file ($_FILES['photo']['tmp_name'],$_SESSION['directory']."/".$name.'.png')) {
	header('location: addphoto.php');
	exit();
}
else{
	echo 'upload unsuccesful try again: '.$_FILES['photo']['error'];
	
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
}


?>