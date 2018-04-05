<?php
if(isset($_GET['ajax']) && $_GET['ajax'] ==true){
	require('../resources/mato/lib/php/param.php');
}
?>
<form action="<?php echo "$root/search" ?>" method="GET" style="margin:0px">
<div class="row">

<div class="col-lg-10 col-md-10 col-sm-9 col-xs-12">
<div class="row">
<div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-6">
<select class="form-control" name="type">
<option value="ns">Select property type</option>
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
</div>
<div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-6">
<select class="form-control" name="max">
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
</div>

<div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12">
<div class="input-group">
<div class="input-group-addon"><span class="glyphicon glyphicon-map-marker"></span></div>
<input class="form-control" id="search-location-input" placeholder="Input location" name="location" size="15" type="text" value="<?php if(isset($_GET['location'])){echo $_GET['location'];}?>"/>
</div>
<div style="display:none" id="suggested-location-container" class="white-background result-container"></div>
</div>

<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
<div data-action="toggle">
<a class="btn btn-default" data-toggle-role="toggle-trigger" data-toggle-on=" Basic search only" data-toggle-off="More search filters"> More search filters</a>
<div data-toggle-role="main-toggle" class="padding-5 border-radius-5 margin-5-0 white-background ">
<div class="row">
<div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-6">
<select class="form-control" name="bath">
<option value="ns">Bathrooms</option>
<option value="1">1</option>
<option value="2">2</option>
<option value="3">3</option>
<option value="4">4</option>
<option value="5">5</option>
<option value="5+">more than 5</option>
</select>
</div>
<div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-6">
<select class="form-control" name="loo">
<option value="ns">Toilet</option>
<option value="1">1</option>
<option value="2">2</option>
<option value="3">3</option>
<option value="4">4</option>
<option value="5">5</option>
<option value="5+">more than 5</option>
</select>
</div>
<div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-4">
<div class="checkbox">
<label>
<input name="tiles" type="checkbox" value="true"/>  Tiles</label>
</div>
</div>
<div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-4">
<div class="checkbox">
<label>
<input name="pm" type="checkbox" value="true"/>  Pumping Machine</label>
</div>
</div>
<div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-4">
<div class="checkbox">
<label>
<input name="bh" type="checkbox" value="true"/>  Borehole</label>
</div>
</div>

</div>
</div>
</div>
</div>

</div>
</div>

<div class="form-group col-lg-2 col-md-2 col-sm-3 col-xs-12 text-left">
<button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-search"></button>
</div>

</div>
</form>
<script>
window.onclick = function(event){
	var theLocationList = document.querySelector('#suggested-location-container');
		if(event.target != theLocationList){
			theLocationList.style.display = 'none';
		}
		
	}
 document.querySelector('#search-location-input').addEventListener('keyup',function(){
	 var key = document.querySelector('#search-location-input').value;
	var theLocationList = document.querySelector('.result-container#suggested-location-container');

	if(key != ''){
			if(theLocationList.style.display != 'block'){
		fader(theLocationList,'fadeIn','normal');
	}

var getLocation = new useAjax(doc_root+"/resources/php/api/getLocations.php?key="+key);
getLocation.go(function(responseCode,responseText){
theLocationList.innerHTML = "<p class=\"text-center blue\">looking up <strong>"+key+" ...</strong></p>";
theLocationList.setAttribute('data-loading-content','searching');
	if(responseCode == 204){
theLocationList.removeAttribute('data-loading-content');
theLocationList.innerHTML = responseText;
	}
});
	}
	else{
		hide('#suggested-location-container');
	}
 });

function setLocation(location){
	var locField = document.querySelector('#search-location-input');
	locField.value = location;
	hide('#suggested-location-container')
}
</script>

