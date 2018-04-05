<?php
if(isset($altHeaderContent)){
	?>
<div class="row alt-static-header">
<div class="col-lg-1  col-md-1 col-sm-1 col-xs-1" style="padding:5px;">
<span class="glyphicon glyphicon-circle-arrow-left icon-size-35 opac-black" onclick="javascript: window.history.back()" style="cursor:pointer"></span>
</div>

<div class="col-lg-10 col-md-10 col-sm-10 col-xs-9 text-center font-24" style="padding: 15px 5px 5px 15px;" >
<?php 
echo $altHeaderContent;
?>
</div>

<div class="col-lg-1  col-md-1 col-sm-1 col-xs-2 text-center" style="padding: 10px 5px 5px" >
<a href="<?php echo $root ?>"><span class="glyphicon glyphicon-home icon-size-25 site-color"></span></a>
</div>

</div>
<style>
.alt-static-header{
background-color:white; 
width:100%;
z-index:98; 
position:fixed; 
box-shadow:0px 5px 5px #555;
min-height:50px;
line-height:25px;
}
.container-fluid{
	padding-top:100px;
}

</style>
<?php
}
?>