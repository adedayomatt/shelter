<!--popup-->
<?php

/*
this snippet must be added immediately after the body tag to work properly
This is a prepared popup, you can popit up by calling the showPopup() javascript function and set
the content by call popUpContent() which returns the element that will hold the content if the popup
to set the content of the popup:
_________________
showPopup();
popUpContent.innerHTML = "THE CONTENT";
*/
?>
<div class="modal-container" style="display:none">	
	<div class="modal-inner">
	<div class="site-color-background" style="height:40px; width:100%">
	<span class="close margin-5 font-20 bold" style="color:white" onclick="closePopup()">&times </span>
	</div>
<div class="custom-modal-content">
<?php
if(isset($onPageLoadPopup)){
	echo $onPageLoadPopup;
	?>
<script>
showPopup();
</script>
<?php
}
?>

</div>
<div class="site-color-background" style="height:20px; width:100%">
</div>

</div>
</div>

<!--*******************************Popup ends here***************************************-->

