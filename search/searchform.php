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
	}
	else if(xmlhttp.status==404){
		alert("things did not go well:404!");
	}
}
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
	padding:1%;
	width:46%;
	margin-right:2%;
	margin-bottom:4px;
	background-color:white;
	border:none;
}
#location-input{
	width:60%;
}
#search-icon{
	background-position: -48px 0px;
}
#search-btn{
	cursor:pointer;
	background-color:purple;
	color:white;
	border-radius:5px;
	font-weight:bold;
	padding:2%;
	padding-left:5%;
	padding-right:5%;
	border:none;
}
#search-btn:hover{
	box-shadow: 2px 2px 2px 2px #DDD;
}
@media only screen and (min-device-width: 300px) and (max-device-width: 1000px){
	.search-field{
		border-radius:10px;
	}
#suggested-location-container{
	position:absolute;
	width:70%;
	max-height:600px;
	background-color:#DDD;
	display:none;
	overflow-y:scroll;
	margin-top:0px;
	padding:0px;
	margin-left:10px;
	box-shadow:2px 2px 2px 2px #DDD;
	font-size:170%;
	
}	
}
@media only screen and (min-device-width: 1000px){
	.search-field{
		border-radius:5px;
	}
	#suggested-location-container{
	position:absolute;
	width:300px;
	max-height:300px;
	background-color:#DDD;
	display:none;
	overflow-y:scroll;
	margin-top:0px;
	padding:0px;
	margin-left:10px;
	box-shadow:2px 2px 2px 2px #DDD;
	font-size:100%;
	
}
}


li.suggested-location-list{
	width:100%;
	list-style-type:none;
	background-color:white;
	margin-bottom:1px;	
	padding-top:2%;
	padding-bottom:2%;
}
li.suggested-location-list:hover{
	background-color:#DDDEEE;
}
</style>
<form action="<?php echo "$root/search" ?>" method="GET">


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
<br/>
<input onkeyup="getLocations(this.value)" class="search-field" id="location-input" placeholder="Input location" name="location" size="15" type="text" value="<?php if(isset($_GET['location'])){echo $_GET['location'];}?>"/></label>
<button type="submit" id="search-btn"><i class="white-icon" id="search-icon"></i>search</button>
<div id="suggested-location-container"></div>
</form>

