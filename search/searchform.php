<script>

window.onclick = function(event){
	var theLocationList = document.getElementById('suggested-location-container');
		if(event.target != 'theLocationList'){
			theLocationList.style.display = 'none';
		}
		
	}
	
function getLocations(key){
	var theLocationList = document.getElementById('suggested-location-container');
var locationSearchField = document.getElementById('location-input');
	if(locationSearchField.value != ''){
		theLocationList.style.display = 'block';
try{
		//opera 8+, firefox,safari
		xmlhttp = new XMLHttpRequest();
	}
	catch(e){
		//Internet Explorer
		try{
			xmlhttp = new ActiveXObject('Msxml2.XMLHTTP');
		}
	catch(e){
		try{
		xmlhttp = new ActiveXObject('Microsoft.XMLHTTP');
		}
		catch(e){
			alert('This browser is crazy!');
		}
	}	
	}
	xmlhttp.onreadystatechange = function(){
	if(xmlhttp.status==200){
if(xmlhttp.readyState == 4){
//first clear the list
	theLocationList.innerHTML = "";
theLocationList.innerHTML += xmlhttp.responseText;

	}
		else{
			//Nothing here yet
		}
	}
	else if(xmlhttp.status==404){
		alert("things did not go well:404!");
	}
}
theLocationList.innerHTML = "<div><img class=\"gif stairs-loading\" src=\"resrc/gifs/loading.gif\" /></div>";

var url = "http://192.168.173.1/shelter/resrc/getLocations.php?key="+key;
xmlhttp.open("GET",url, true);
xmlhttp.send();	
	
	}
	else{
		theLocationList.style.display = 'none';
	}
}
function setLocation(location){
	var locField = document.getElementById('location-input');
	locField.value = location;
	document.getElementById('suggested-location-container').style.display = 'none';
}
</script>
<style>
.search-field{
	width:46%;
	margin-right:2%;
	margin-bottom:4px;
	background-color:white;
	border:none;
}

</style>
<form action="<?php echo "$root/search" ?>" method="GET" style="margin:0px">


<select class="search-field" name="type">
<option value="All types">Select property type</option>
<option value="Boys Quater">Boys Quater</option>
<option value="Bungalow">Bungalow</option>
<option value="Duplex">Duplex</option>
<option value="Flat">Flat</option>
<option value="Hall">Hall</option>
<option value="Land">Land</option>
<option value="Office Space">Office Space</option>
<option value="Self Contain">Self Contain</option>
<option value="Semi detached House">Semi detached House</option>
<option value="Shop">Shop</option>
<option value="Warehouse">Warehouse</option>
</select>

<select class="search-field" name="max">
<option value="100000">Max price</option>
<option value="100000">100,000</option>
<option value="150000">150,000</option>
<option value="200000">200,000</option>
<option value="250000">250,000</option>
<option value="300000">300,000</option>
<option value="500000">500,000</option>
<option value="1000000">1 million</option>
<option value="2000000">2 million</option>
<option value="5000000">5 million</option>
</select>

<div class="input-wrapper">
<input onkeyup="getLocations(this.value)" class="search-input-field" id="location-input" placeholder="Input location" name="location" size="15" type="text" value="<?php if(isset($_GET['location'])){echo $_GET['location'];}?>"/>
<button type="submit" class="search-btn">search</button>
</div>
</form>
<div class="suggestion-box" id="suggested-location-container"></div>


