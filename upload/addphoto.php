<?php session_start();

require('../resources/php/master_script.php');

//check if user is logged in
if($status != 1){
		$general->redirect('login');
	}
	
if(isset($_SESSION['id']) && isset($_SESSION['directory']) && $_GET['ptk']==$_COOKIE['PHPSESSID'] && $_GET['sHptk']==SHA1($_COOKIE['PHPSESSID'])){
//The relative url of the uploaded is in this session variable already
$imgurl = $_SESSION['directory'];
	$pid = $_SESSION['id'];
}
else{
	$general->redirect('upload');
}
$max_upload = upload_config::$max_photo;
//This handles photo upload
if(isset($_FILES['photo'])){

	if($_POST['imgIndex'] > $max_upload){
$photoUploadReport = "You have reached the limit of $max_upload photos!";
	}
	else{
$mb = ($_FILES['photo']['size'])/1000000;

//The function is_upload_image() is in master_script.php
if($general->is_upload_image($_FILES['photo']['type']) == 'clean'){
	$format = '.'.substr($_FILES['photo']['type'],1+strpos($_FILES['photo']['type'],'/'));
	if (!move_uploaded_file ($_FILES['photo']['tmp_name'],$imgurl."/".$_POST['picname'].$format)) {
	$photoUploadReport = 'upload unsuccesful try again: '.$_FILES['photo']['error'];
}
else{
	//discard the tmp file
	if(is_file($_FILES['photo']['tmp_name']) && file_exists($_FILES['photo']['tmp_name'])){
		unlink($_FILES['photo']['tmp_name']);
	}
}	
}
else{
	$photoUploadReport = "Unsupported file format";
}
}	
}
 ?>
<html>
<?php require('../resources/html/meta-head.html'); ?>
<link href="../css/general.css" type="text/css" rel="stylesheet" />
<link href="../css/header_styles.css" type="text/css" rel="stylesheet" />
<link href="../css/upload_styles.css" type="text/css" rel="stylesheet" />

<head>
	<title>Shelter | Add Photo</title>
<?php
require('../resources/html/plain-header.html');

?>
</head>

<body class="pic-background">
<?php
//if completed/finished
if (isset($_GET['cmpLt']) && $_GET['cmpLt']==MD5('OK')){
	session_unset();
	session_destroy();
	setcookie('PHPSESSID',"",time()-60,"/","",0);
echo "<div class=\"upload-section\" style=\"text-align:center; margin-top:10%\">
		<h3 style=\"font-size:200%;font-weight:normal\">Upload complete!</h3>
		<p>View property <a href=\"$imgurl\">here</a></p>
		</div>";
	$general->halt_page();
}
?>
<div class="add-photo-section">
	<h2 class="upload-heading">Add Photo</h2>
<div id="message"><p class="instruction" align="center">Give your clients glimpses of what you have in stock, add photos now.</p></div>
<div id="photos">

<div class="picturebox">
	<?php
	$uploadedPhotos = "";
//get_images() returns an array of all the images in the directory
		$existedImages_array = $general->get_images($imgurl);
		foreach($existedImages_array as $img){
			$uploadedPhotos .= "<img class=\"uploaded-photos\" alt=\"$pid image\" src=\"$img\" />";
			}
	//count images in the array
	$existedImages_no = count($existedImages_array);
	$nxtImg = $existedImages_no+1;	

	if(isset($photoUploadReport)){
	echo "<div class=\"upload-error-wrapper\" style=\"color:red\">$photoUploadReport</div>";
}

echo "<p>$existedImages_no photos uploaded  (Max: $max_upload photos)</p>";
echo $uploadedPhotos;

if($existedImages_no==$max_upload){
	?>
<style>
	#add-more-photo-area,#add-more-photo-area>form>input{
		cursor:not-allowed;
		opacity:0.4;
	}
	</style>
<?php
}
?>

<div id="add-more-photo-area">
<?php
if($existedImages_no > 0){
	echo "<div class=\"upload-sub-heading\">Add more photos</div>";
}
?>
<form enctype="multipart/form-data" action="<?php $_PHP_SELF ?>" method="POST" >
<input type="hidden" name="picname"  value="<?php echo $pid."_0".$nxtImg; ?>" />
<input type="hidden" name="imgIndex"  value="<?php echo $nxtImg ?>" />
<input type="file" name="photo" size="30"style="background-color:#eee;" />
<input type="submit" value="upload!" class="deepblue-inline-block-link" style="border:none">
</form>
</div>

</div>

</div>
<a href="../manage/property.php?id=<?php echo $pid ?>&action=change"><span class="black-icon edit-icon"></span>Edit details</a>
<div id="finish-box">

<a  href="<?php echo "?ptk=".$_COOKIE['PHPSESSID']."&cmpLt=".MD5('OK')."&sHptk=".SHA1($_COOKIE['PHPSESSID']) ?>" >
<button class="deepblue-inline-block-link" id="finish-button" name="complete" type="submit" value="Finish"  id="submit">Finish</button>
</a>
<?php
if($existedImages_no == 0){
	echo "<p id=\"no_photo\">There are no photos to add, <a  href=\"?ptk=".$_COOKIE['PHPSESSID']."&cmpLt=".MD5('OK')."&sHptk=".SHA1($_COOKIE['PHPSESSID'])."\">Proceed anyway</a></p>";
}
?>
</div>
</div>

<?php require('../resources/php/footer.php') ?>
</body>
</html>