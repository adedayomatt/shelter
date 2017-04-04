<style>
.search-field{
	padding:2%;
	width:80%;
	margin-left:10%;
	margin-right:10%;
	margin-bottom:4px;
	background-color:white;
	color:#6D0AAA;
}
#location-input{
	width:75%;
}
#search-icon{
	background-position: -48px 0px;
}
#search-btn{
	margin-left:70%;
	cursor:pointer;
	background-color:#6D0AAA;
	border:none;
	border-radius:5px;
	font-weight:bold;
	color:white;
	padding:2%;
	box-shadow: 2px 2px 2px 2px grey;
}
#search-btn:hover{
	box-shadow: 2px 2px 2px 2px #333;
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
<input class="search-field" id="location-input" placeholder="Input location" name="location" size="15" type="text" value="<?php if(isset($_GET['location'])){echo $_GET['location'];}?>"/></label>
<button type="submit" id="search-btn"><i class="white-icon" id="search-icon"></i>search</button>

</form>
