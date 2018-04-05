<?php session_start();

require('../resources/master_script.php');

//check if user is logged in
if($status != 1){
		$tool->redirect_to('../login?return='.$current_url);
	}
	
if(isset($_SESSION['id']) && isset($_SESSION['directory']) && $_GET['ptk']==$_COOKIE['PHPSESSID'] && $_GET['sHptk']==SHA1($_COOKIE['PHPSESSID'])){
//The relative url of the uploaded is in this session variable already
$imgurl = $_SESSION['directory'];
	$pid = $_SESSION['id'];
}
else{
	$tool->redirectTo('../upload');
}
$max_upload = 10;
//This handles photo upload
if(isset($_FILES['photo'])){

	if($_POST['imgIndex'] > $max_upload){
$photoUploadReport = "You have reached the limit of $max_upload photos!";
	}
	else{
$mb = ($_FILES['photo']['size'])/1000000;

//The function is_upload_image() is in master_script.php
if($tool->is_upload_image($_FILES['photo']['type'])){
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
<head>
<?php $pagetitle = "Add Photo" ?>
	<?php require('../resources/global/meta-head.php'); ?>
<style>
.uploaded-photos{
width:120px;
height:120px;	
}
	
</style>
</head>

<body>
<?php
$altHeaderContent ="Upload Property";
require('../resources/global/alt_static_header.php');
?>
<div class="container-fluid">
<?php
//if completed/finished
if (isset($_GET['cmpLt']) && $_GET['cmpLt']==MD5('OK')){
	session_unset();
	session_destroy();
	setcookie('PHPSESSID',"",time()-60,"/","",0);
	?>
	<div class="center-content">
	<div class="operation-report-container success" style="text-align:center;">
		<h3 class="font-30 text-center">Upload complete!</h3>
		<p>View property <a href="<?php echo $imgurl ?>">here</a></p>
		</div>
		<div>
		<?php
	$tool->halt_page();
}
?>
<div class="center-content ">
	<div class="contain box-shadow">
	<div class="head f7-background">
	<h4>Add Photos</h4>
	</div>

	<div class="body white-background">
<p class="help-block text-center">Give your clients glimpses of what you have in stock, add photos now.</p>

<div id="photos">

<div class="picturebox text-center">
	<?php
	$uploadedPhotos = "";
//get_images() returns an array of all the images in the directory
		$existedImages_array = $tool->get_images($imgurl);
		foreach($existedImages_array as $img){
			$uploadedPhotos .= "<img class=\"uploaded-photos margin-2\" alt=\"$pid image\" src=\"$img\" />";
			}
	//count images in the array
	$existedImages_no = count($existedImages_array);
	$nxtImg = $existedImages_no+1;	

	if(isset($photoUploadReport)){
	echo "<div class=\"operation-report-container fail\">$photoUploadReport</div>";
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

<div class="row">
<?php
if($existedImages_no > 0){
}
?>
<div class="upload-sub-heading">Add more photos</div>
<form enctype="multipart/form-data" action="<?php $_PHP_SELF ?>" method="POST" >
<div class="row">
<div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
<div class="form-group">
<input type="hidden" name="picname"  value="<?php echo $pid."_0".$nxtImg; ?>" />
<input type="hidden" name="imgIndex"  value="<?php echo $nxtImg ?>" />
<input type="file" name="photo" size="30" class="form-control" />
</div>
</div>
<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
<input type="submit" value="upload!" class="btn btn-primary" />
</div>
</div>
</form>

<?php
if($existedImages_no == 0){
	echo "<p id=\"no_photo\">There are no photos to add, <a  href=\"?ptk=".$_COOKIE['PHPSESSID']."&cmpLt=".MD5('OK')."&sHptk=".SHA1($_COOKIE['PHPSESSID'])."\">Proceed anyway</a></p>";
}
?>
</div>

</div>

</div>

<a href="../manage/property.php?id=<?php echo $pid ?>&action=change" class="site-color"><span class="glyphicon glyphicon-edit"></span>Edit details</a>
<div id="finish-box">

<a  class="btn btn-block btn-primary white width-80p margin-auto site-color-background" href="<?php echo "?ptk=".$_COOKIE['PHPSESSID']."&cmpLt=".MD5('OK')."&sHptk=".SHA1($_COOKIE['PHPSESSID']) ?>" >
Finish
</a>

</div>
</div>
</div>
</div>

<?php require('../resources/global/footer.php') ?>
</div>
</body>
</html>