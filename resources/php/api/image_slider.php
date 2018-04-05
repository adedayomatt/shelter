<?php
if(isset($_GET['dir']) && isset($_GET['r'])){
	require('api_tools.php');
		$dir = $_GET['dir'];
		$rent = $_GET['r'];
		$root_trace = "";
		$i = 2;
		while($i < substr_count($_SERVER['PHP_SELF'],'/')){
			$root_trace .= '../';
			$i++;
		}
		$images = array();
		$imageFormats = array('.png','.PNG','.jpg','JPG','.jpeg','.pjpeg','.x-png');
		for($j = 0; $j<count($imageFormats); $j++){
			foreach(glob($root_trace.$dir."/*$imageFormats[$j]") as $img){
				$images[] = $img;
			}
		}
		
		$total_images = count($images);
		if($total_images == 0){
			?>
			<div class="text-center">There are no images to display</div>
			<?php
			die();
		}
?>


<div id="images-carousel" class="carousel slide" data-ride="carousel" data-interval="1000">
  <!-- Indicators -->
  <ol class="carousel-indicators">
  <?php
  $indicator_counter = 0;
  while($indicator_counter < $total_images){
	  ?>
	    <li data-target="#images-carousel" data-slide-to="<?php echo $indicator_counter+1 ?>" class="<?php echo $indicator_counter == 0 ? "active" : ""?>"></li>
	  <?php
	  $indicator_counter++;
  }
  ?>
  </ol>

  <!-- Wrapper for slides -->
  <div class="carousel-inner" role="listbox">
    <?php
	$wrapper_counter = 0;
	while($wrapper_counter < $total_images){
		?>
		<div class="item <?php echo $wrapper_counter == 0 ? "active" : ""?>">
			<img  src="<?php echo $root.'/'.substr($images[$wrapper_counter],strlen('../../../')) ?>" style="width:100%; height:300px"  alt="<?php echo $images[$wrapper_counter] ?>" />
				<div class="carousel-caption">
				<?php echo "IMAGE $wrapper_counter"?>
			</div>
		</div>
		<?php
		$wrapper_counter++;
	}
	?>
  </div>

  <!-- Controls -->
  <a class="left carousel-control" href="#images-carousel" role="button" data-slide="prev">
    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="right carousel-control" href="#images-carousel" role="button" data-slide="next">
    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
</div>
<div class="padding-5">
<p><span class=" padding-5-10 margin-5 border-radius-5 bold opac-3-site-color-background site-color "><?php echo number_format($rent)?>/year</span>
<a href="<?php  echo $root.'/'.$dir ?>">See Full Details</a>
</div>
<?php
}
?>