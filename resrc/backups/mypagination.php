<?php
if(isset($_GET['next'])){
	$i = $_GET['next'];
	
}else{ $i = 0; }
/*pagination logic starts here*/
/* $maxi specify the maximum number of records to be shown at once when page loads */
$maxi = 2;
$track = "<p style=\"display:inline\">showing ".($i+1)." - ".($i+$maxi)." of ".$count."</p>";

while($i < $count){

	**CONTENT TO BE DISPLAYED FOR EACH INDEX $i AS IT INCRESES**
	**$count INDICATES THE TOTAL NUMBER OF RECORDS**
	
	$i++;
	if(($i%$maxi)==0){
		break;
	}
}
	echo $track;
/*Calculate number of referer button to be made by dividing the total number of
 records generated by number of 
records to shown on a single page*/

$no_of_button = (int)(($count/$maxi)-1);
//initialize a button counter
$countbutton = 0;
/*create referer  buttons. The referer buttons are created using form with hidden input that takes
 *index to start the page it is refering to as value, when submitted, it loads index.php passing the
 *value along with GET method.*/
 
	while($countbutton<=$no_of_button){
/* $buttonvalue set tag on each refering button, it takes the value returned by pagereferertag()*/
		$buttonvalue = pagereferertag($countbutton,0,($no_of_button));
		
		$goto = $countbutton*$maxi;
		if(isset($_GET['next'])){
			if($countbutton==($_GET['next']/$maxi)){
			$bgcolor = '#6D0AAA';
			$fcolor='white';
		}
		else{
			$bgcolor='#eeeeee';
			$fcolor="#6D0AAA";
		}}else{ $bgcolor = '#eeeeee';$fcolor="#6D0AAA";}
		$pagebutton = "<form action=\"index.php\" method=\"GET\"/>";
		$pagebutton .= "<input name=\"next\" type=\"hidden\" value=\"$goto\"/>";
		$pagebutton .= "<input id=\"page\" style=\"float:left; background-color:$bgcolor; color:$fcolor;\"type=\"submit\" value=\"$buttonvalue\"/>";
		$pagebutton .= "</form>";
		echo $pagebutton;
		$countbutton++;
		}
		?>
