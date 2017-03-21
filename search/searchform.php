<style>
#search-icon{
	background-position: -48px 2px;
}
#search-btn{
	cursor:pointer;
	background-color:#6D0AAA;
	border:none;
	border-radius:5px;
	font-weight:bold;
	color:white;
}
</style>
<form action="http://localhost/shelter/search" method="GET">

<label>
<select class="search-field" name="type">
<option value="All types">All types</option>
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
</select></label>
<label class="search-field">Max price N 
<select name="max">
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
</label>

<label>select location<input name="location" size="15" type="text" value="<?php if(isset($_GET['location'])){echo $_GET['location'];}?>"/></label>
<button type="submit" id="search-btn"><i class="white-icon" id="search-icon"></i>search</button>

</form>
