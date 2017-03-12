<body>
<script>
function finish(){
	alert("property added successfully");
	window.location="http://localhost/shelter";
}
</script>
<style>
#message{
	margin-top: 60px;
}
#photos{

	margin-left:0.5%;
	margin-right:0.5%;
	width: 99%;
	height:400px;
	}
.picturebox{
	float:left;
	margin-left:0.1%;
	margin-right:0.1%;
	width: 24.62%;
	height: 370px;
	border: 1px solid purple;
}
</style>
<div id="message"><p align="center">Give your clients glimpses of what you have in stock, add photos now.</p></div>
<div id="photos">
<div class="picturebox">
<img width="100%" height="100%" alt="photo1" src="<?php echo "../images/".$_COOKIE['id']."_01.png";?>"/>
<form enctype="multipart/form-data" action="uploadfunction.php" method="POST" >
<input type="hidden" name="picname" size="50" value="<?php echo $_COOKIE['id']."_01";?>"/>
<input type="file" name="photo" size="30" style="background-color: cyan;"/>
<input type="submit" value="upload!" size="50">
</form></div>
<div class="picturebox">
<img width="100%" height="100%" alt="photo2" src="<?php echo "../images/".$_COOKIE['id']."_02.png"?>"/>
<form enctype="multipart/form-data" action="uploadfunction.php" method="POST" >
<input type="hidden" name="picname" size="50" style="background-color: green;" value="<?php echo $_COOKIE['id']."_02";?>"/>
<input type="file" name="photo" size="30" style="background-color: cyan;"/>
<input type="submit" value="upload!" size="50"/>
</form></div>
<div class="picturebox">
<img width="100%" height="100%" alt="photo3" src="<?php echo "../images/".$_COOKIE['id']."_03.png";?>"/>
<form enctype="multipart/form-data" action="uploadfunction.php" method="POST" >
<input type="hidden" name="picname" size="50" style="background-color: green;" value="<?php echo $_COOKIE['id']."_03";?>"/>
<input type="file" name="photo" size="30" style="background-color: cyan;"/>
<input type="submit" value="upload!" size="50"/>
</form></div>
<div class="picturebox">
<img width="100%" height="100%" alt="photo4" src="<?php echo "../images/".$_COOKIE['id']."_04.png";?>"/>
<form enctype="multipart/form-data" action="uploadfunction.php" method="POST" >
<input type="hidden" name="picname" size="50" style="background-color: green;" value="<?php echo $_COOKIE['id']."_04";?>"/>
<input type="file" name="photo" size="30" style="background-color: cyan;"/>
<input type="submit" value="upload!" size="50"/>
</form></div>
</div>
<div id="finish_box">
<form action="complete.php">
<input type="submit" value="Finish"  id="submit"/></form>
<p id="no_photo">There are no photos to add, <a style="color:#6D0AAA;" href="complete.php">I want to proceed</a></p>
</div>
<style>
#finish_box{

}
#submit{
	cursor:pointer;
	float:right;
	background-color:#6D0AAA;
	color:white;
}
#no_photo{
	margin-left:50px;
}
</style>
</body>